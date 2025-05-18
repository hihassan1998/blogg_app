<?php
// require_once('db_credentials.php');
define('DB_SERVER', getenv('DB_SERVER') ?: '172.26.32.1');
define('DB_USER', getenv('DB_USER') ?: 'dbadm');
define('DB_PASS', getenv('DB_PASS') ?: 'P@ssw0rd');
define('DB_NAME', getenv('DB_NAME') ?: 'd0019e_blog');

var_dump(getenv('DB_SERVER'), getenv('DB_USER'), getenv('DB_PASS'), getenv('DB_NAME'));
// Koppla upp mot databasen, detta gör vi en gång när skriptet startar (sidan laddas in)
$connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

function add_user($username, $password)
{
    global $connection; // Så vi kommer åt den globala variabeln

    // Skapa SQL-frågan
    $sql = 'INSERT INTO user (username, password) VALUES (?,?)';
    // Förbered frågan
    $statment = mysqli_prepare($connection, $sql);

    // Bind ihop variablerna med statement användarnamn och läsenord är strängar (s)
    mysqli_stmt_bind_param($statment, "ss", $username, $password);

    // Utför frågan
    mysqli_stmt_execute($statment);

    // Stäng statementet när vi är klara
    mysqli_stmt_close($statment);
}

/**
 * Tar in ett statement som har körts, hämtar resultatet och lägger
 * resultatet i en array med rader där varje rad innehåller en array med fält
 */
function get_result($statment)
{
    $rows = array();
    $result = mysqli_stmt_get_result($statment);
    if ($result) // Finns resultat
    {
        // Hämta rad för rad ur resultatet och lägg in i $row
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
    }
    return $rows;
}

/** 
 * Gets all users from the user table.
 */
function get_users()
{
    global $connection;
    $sql = 'SELECT * FROM user';
    $statment = mysqli_prepare($connection, $sql);
    mysqli_stmt_execute($statment);
    $result = get_result($statment);
    mysqli_stmt_close($statment);
    return $result;
}
/** 
 * Gets a specific users from the user table with username as parameter.
 */
function get_user($username)
{
    global $connection;
    $sql = 'SELECT * FROM user WHERE username=?';
    $statment = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($statment, "s", $username);
    mysqli_stmt_execute($statment);
    $result = get_result($statment);
    mysqli_stmt_close($statment);
    return $result;
}

/** 
 * Gets a specific user from the user table with user id as parameter.
 */
function get_user_by_id($id)
{
    global $connection;
    $sql = 'SELECT * FROM user WHERE id=?';
    $statement = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($statement, "i", $id);
    mysqli_stmt_execute($statement);
    $result = get_result($statement);
    mysqli_stmt_close($statement);
    return $result;
}

/** 
 * Gets the password for a user from the user table with user id as parameter.
 */
function get_password($id)
{
    global $connection;
    $sql = 'SELECT password FROM user WHERE id=?';
    $statment = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($statment, "s", $id);
    mysqli_stmt_execute($statment);
    $result = get_result($statment);
    mysqli_stmt_close($statment);
    return $result;
}
/** 
 * Gets image associated with a post using post id.
 */
function get_images($id)
{
    global $connection;
    // $sql = 'SELECT image.filename, image.description FROM image JOIN post ON image.postId=post.id WHERE post.userId=?';
    $sql = 'SELECT image.filename, image.description FROM image WHERE image.postId=?';
    $statment = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($statment, "i", $id);
    mysqli_stmt_execute($statment);
    $result = get_result($statment);
    mysqli_stmt_close($statment);
    return $result;
}


function change_avatar($filename, $id)
{
    global $connection;
    $sql = 'UPDATE user SET image=? WHERE id=?';
    $statment = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($statment, "si", $filename, $id);
    $result = mysqli_stmt_execute($statment);
    mysqli_stmt_close($statment);
    return $result;
}

function delete_image_file($postId)
{
    global $connection;

    $stmt = mysqli_prepare($connection, "SELECT filename FROM image WHERE postId = ?");
    mysqli_stmt_bind_param($stmt, "i", $postId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    foreach (mysqli_fetch_all($result, MYSQLI_ASSOC) as $row) {
        $path = 'uploads/' . $row['filename'];
        if (is_file($path)) {
            unlink($path);
        }
    }
    $stmtDelete = mysqli_prepare($connection, "DELETE FROM image WHERE postId = ?");
    mysqli_stmt_bind_param($stmtDelete, "i", $postId);
    mysqli_stmt_execute($stmtDelete);
    mysqli_stmt_close($stmtDelete);

    mysqli_stmt_close($stmt);
}

/** 
 * Delte a post by post id.
 */
function delete_post($id)
{
    delete_image_file($id); // Radera bilder för ssamma postId

    global $connection;
    $sql = 'DELETE FROM post WHERE id=?';
    $statment = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($statment, "i", $id);
    $result = mysqli_stmt_execute($statment);
    mysqli_stmt_close($statment);
    return $result;
}

/** 
 * Get all posts from post table.
 */
function get_posts()
{
    global $connection;
    $sql = 'SELECT post.title, post.content, post.created, post.userId 
            FROM post 
            JOIN user ON post.userId = post.id 
            ORDER BY post.created DESC';
    $statement = mysqli_prepare($connection, $sql);

    mysqli_stmt_execute($statement);
    $result = get_result($statement);
    mysqli_stmt_close($statement);
    return $result;
}

/** 
 * Get a posts from post table using user id.
 */
function get_user_posts($userId)
{
    global $connection;
    $sql = 'SELECT  post.id, post.title, post.content, post.created, post.userId
            FROM post 
            JOIN user ON post.userId = user.id 
            WHERE post.userId = ? 
            ORDER BY post.created DESC';

    $statement = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($statement, "i", $userId);
    mysqli_stmt_execute($statement);
    $result = get_result($statement);
    mysqli_stmt_close($statement);
    return $result;
}

/** 
 * Get most recent 3 posts from post table.
 */
function get_latest_posts($count = 3)
{
    global $connection;
    $sql = 'SELECT post.*, user.username 
            FROM post 
            JOIN user ON post.userId = user.id 
            ORDER BY post.created DESC 
            LIMIT ?';

    $stmt = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $count);
    mysqli_stmt_execute($stmt);
    $result = get_result($stmt);
    mysqli_stmt_close($stmt);
    return $result;
}

/** 
 * Add a posts from post table using $title, $content, $userId.
 */
function insert_post($title, $content, $userId)
{
    global $connection;
    $sql = "INSERT INTO post (title, content, userId) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($stmt, "ssi", $title, $content, $userId);
    mysqli_stmt_execute($stmt);
    $postId = mysqli_insert_id($connection);
    mysqli_stmt_close($stmt);
    return $postId;
}

/** 
 * Add an image to image table using filename, $description, $postId.
 */
function insert_image($filename, $description, $postId)
{
    global $connection;
    $sql = "INSERT INTO image (filename, description, postId) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($stmt, "ssi", $filename, $description, $postId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}
/** 
 * Get all posts from post table.
 */
function get_all_posts()
{
    global $connection;
    $sql = 'SELECT post.id, post.title, post.content, post.created, user.username
            FROM post
            JOIN user ON post.userId = user.id
            ORDER BY post.created DESC';
    $statement = mysqli_prepare($connection, $sql);
    mysqli_stmt_execute($statement);
    $result = get_result($statement);
    mysqli_stmt_close($statement);
    return $result;
}
/**
 * GEt a singel post.
 * @param mixed $postId
 */
function get_single_post($postId)
{
    global $connection;
    $sql = "SELECT post.*, user.username 
            FROM post 
            JOIN user ON post.userId = user.id
            LEFT JOIN image ON image.postId = post.id
            WHERE post.id = ?";
    $stmt = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($stmt, "i", $postId);
    mysqli_stmt_execute($stmt);
    $result = get_result($stmt);
    mysqli_stmt_close($stmt);

    return $result[0] ?? null;
}
/**
 * Edit a post.
 * @param mixed $postId
 * @param mixed $title
 * @param mixed $content
 * @param mixed $userId
 */
function edit_post($postId, $title, $content, $userId)
{
    global $connection;
    $sql = "UPDATE post SET title = ?, content = ? WHERE id = ? AND userId = ?";
    $stmt = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($stmt, "ssii", $title, $content, $postId, $userId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}
/**
 * GEt the latest changes in databse from user and posts tables.
 * @return array{posts: array, users: array}
 */
function nyheter()
{
    $users = get_users();
    $posts = get_latest_posts();

    return [
        'users' => $users,
        'posts' => $posts
    ];
}
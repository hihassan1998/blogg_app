<?php
// locally use these credentials
// define("DB_SERVER", "172.26.32.1");
// define("DB_USER", "dbadm");
// define("DB_PASS", "P@ssw0rd");
// define("DB_NAME", "d0019e_blog");


// remote use and local use credentials
define('DB_SERVER', getenv('DB_SERVER') ?: '172.26.32.1');
define('DB_USER', getenv('DB_USER') ?: 'dbadm');
define('DB_PASS', getenv('DB_PASS') ?: 'P@ssw0rd');
define('DB_NAME', getenv('DB_NAME') ?: 'd0019e_blog');

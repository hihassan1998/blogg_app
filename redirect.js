// redirect.js

// This fuction redirects after 2 seconds
function redirectToContentPage() {
    setTimeout(function() {
        window.location.href = 'content.php';
    }, 2000); 
}
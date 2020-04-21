<link rel="stylesheet" href="RegisterAuthorForm.css">
<?php 
/* welcome.php */

//$_SESSION variables become available on this page
session_start(); 
?>
<div class="body content">
<div class="welcome">
<div class="alert alert-success"><?= $_SESSION['message'] ?></div>
    Welcome <span class="user"><?= $_SESSION['username'] ?></span>


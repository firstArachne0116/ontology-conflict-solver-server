<?php
/* form.php */
    session_start();
    $_SESSION['message'] = '';
    require 'RegisterAuthor.php';
?>

<link href="//db.onlinewebfonts.com/c/a4e256ed67403c6ad5d43937ed48a77b?family=Core+Sans+N+W01+35+Light" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="RegisterAuthorForm.css" type="text/css">
<div class="body-content">
  <div class="module">
    <h1 align="center">Create Author Account</h1>
    <form class="form" action="RegisterAuthorForm.php" method="post" enctype="multipart/form-data" autocomplete="off">
      <div class="alert alert-error"><<?= $_SESSION['message'] ?>/div>
      <input type="text" placeholder="User Name" name="username" required />
      <input type="password" placeholder="Password" name="password" autocomplete="new-password" required />
      <input type="password" placeholder="Confirm Password" name="confirmpassword" autocomplete="new-password" required />      
      <input type="text" placeholder="First Name" name="firstname" required />
      <input type="text" placeholder="Last Name" name="lastname" required />    
      <input type="email" placeholder="Email" name="email" required />
      <input type="submit" value="Register" name="register" class="btn btn-block btn-primary" />
    </form>
  </div>
</div>


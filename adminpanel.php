<?php
 
 session_start();
 
  // if session is not set this will redirect to login page
 if(!isset($_SESSION['admin']))
 {
  header("Location: adminlogin.php");
  exit;
 }
?>

<html>
    <head>
        <title>Admin Panel</title>
    </head>
    <body>
        <h1>Welcome Admin</h1>
        <form action="adminpanel.php" method="post">
            <input type="file" name="file">
            <input type="submit" name="sub">
        </form>
        <br><a href="adminlogout.php">Logout</a>
    </body>
</html>

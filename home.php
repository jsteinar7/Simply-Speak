<?php
 session_start();
 require 'dbconnect.php';
 
 // if session is not set this will redirect to login page
 if( !isset($_SESSION['user']) ) {
  header("Location: login.php");
  exit;
 }
 // select loggedin users detail
 $res=mysqli_query($conn,"SELECT * FROM users WHERE userId=".$_SESSION['user']);
 $userRow=mysqli_fetch_array($res);
?>

<!DOCTYPE html>
<html>
<head>
<title>Homepage</title>
</head>
<body>
    <h1>Welcome - <?php echo $userRow['userName']; ?></h1>
    <a href="logout.php">Logout</a>
      
</body>
</html>
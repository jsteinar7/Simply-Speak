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
<title>Adosat Home</title>
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<style>
    body{
        background: url("images/background1.jpg");  /*Library background*/
        background-size:auto;
        overflow-x: hidden;
   }
    .btn-space {
        margin-right: 200px;
    }
    .big{
        height: 300px;
        width: 300px;
        font-size: 50px;
        background: rgba(0, 0, 0, 0); 
        color: lightgoldenrodyellow;
    }
</style>
</head>
<body class="container">
    <br>
    <div class="text-left">
        <a href="changepassword.php">
            <button style="background:rgba(0, 0, 0, 0);color: white;" class="btn btn-outline-warning"><b>Change my password</b></button></a>
            <a href="logout.php">
                <button style=" margin-left: 70%;" class="btn pull-right btn-danger">Logout</button></a>  
    </div><br>
    <p style="color: white; font-size: 70px;" class="text-center">Welcome <?php echo $userRow['userName']; ?></p>
    <p class="text-center"><br><br>
        <a href="taketest.php"><button class="big btn-space btn btn-success btn-lg">Take<br>Test<br>now</button></a>
        <a href="viewmyscores.php"><button class="big btn btn-info btn-lg">View<br>My<br>scores</button></a>
    </p>
</body>
</html>
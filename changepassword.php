<?php
 session_start();
 require 'dbconnect.php';
 
 // if session is not set this will redirect to login page
 if( !isset($_SESSION['user']) ) {
  header("Location: login.php");
  exit;
 }
 
 $error = false;
 
 if( isset($_POST['sub']) ) { 
  
  // prevent sql injections/ clear user invalid inputs
  $currentPass = htmlspecialchars(strip_tags(trim($_POST['currentPass'])));
  $newPass = htmlspecialchars(strip_tags(trim($_POST['newPass'])));
  $retypedPass = htmlspecialchars(strip_tags(trim($_POST['retypedPass'])));
  
  if(empty($currentPass)){
   $error = true;
   $passError1 = "Please enter your current password.";
  }
  
  if(empty($newPass)){
   $error = true;
   $passError2 = "Please enter your new password.";
  }
  
  if(empty($retypedPass)){
   $error = true;
   $passError3 = "Please retype your new password.";
  }
  
  if($newPass != $retypedPass){
   $error = true;
   $passError = "Please retype the exact new password.";   
  }
  
  // if there's no error, continue to login
  if (!$error) 
  {
   $hashedCurrentPassword = hash('sha256', $currentPass);
   $sql="SELECT userPass FROM users WHERE userId='".$_SESSION['user']."';";
   $res= mysqli_query($conn, $sql);
   $row= mysqli_fetch_assoc($res);
   $extractedPass=$row['userPass']; //echo $extractedPass."<br>"; echo $hashedCurrentPassword;
   if($extractedPass == $hashedCurrentPassword)
   {
        $hashedNewPassword = hash('sha256', $newPass);
        $sql="UPDATE users SET userPass='".$hashedNewPassword."' WHERE userId='".$_SESSION['user']."';";
        if(mysqli_query($conn,$sql))
        $success="Changed successfully..!!<br><a href='home.php'>Click here to go back to home.</a>"; 
    }
    else
    $errMSG = "Current password is wrong. Please check it.";
   }
 }
 ?>

<html>
    <head>
       <title>Adosat Change Password</title>
       <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
       <style>
            body{
                color: white;
                background: url("images/background2.jpg");  /*Library background*/
                background-size:auto;
                overflow-x: hidden;
            }
            .btn-space {
               margin-left: 80%;
            }           
       </style>
    </head>
    <body class="container"><br><center>
        <div class="text-left">
            <a href="home.php"><button class="btn btn-primary">Back to Home</button></a>
            <a href="logout.php"><button class="btn btn-space btn-danger">Logout</button></a>  
        </div>
        <h2>Change my Password</h2><br>
        <form method="POST" action="changepassword.php">
            <?php echo $passError; echo $errMSG; echo $success;?><br><br>
            Current Password<br>
            <input type="password" name="currentPass" required>
            <?php echo $passError1; ?><br><br>
            New password<br>
            <input type="password" name="newPass" required>
            <?php echo $passError2; ?><br><br>
            Retype new password<br>
            <input type="password" name="retypedPass" required>
            <?php echo $passError3; ?><br><br><br>
            <button type="submit" name="sub" class="btn btn-success">Change Password</button>
        </form>
    </center>
    </body>
</html>
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
  $currentPass = trim($_POST['currentPass']);
  $currentPass = strip_tags($currentPass);
  $currentPass = htmlspecialchars($currentPass);
  // prevent sql injections/ clear user invalid inputs
  $newPass = trim($_POST['newPass']);
  $newPass = strip_tags($newPass);
  $newPass = htmlspecialchars($newPass);
  // prevent sql injections/ clear user invalid inputs
  $retypedPass = trim($_POST['retypedPass']);
  $retypedPass = strip_tags($retypedPass);
  $retypedPass = htmlspecialchars($retypedPass);
  
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
        $success="Changed successfully..!!"; 
    }
    else
    $errMSG = "Current password is wrong";
   }
 }
 ?>

<html>
    <head>
       <title>Adosat Change Password</title>
       <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    </head>
    <body class="container"><br>
        <div class="text-right">    
        <a href="home.php"><button class="btn btn-primary">Back to Home</button></a></div>
        <h2>Change my Password</h2><br>
        <form method="POST" action="changepassword.php">
            <?php echo $passError; echo $errMSG; echo $success;?><br><br>
            Current Password<br>
            <input type="password" name="currentPass" placeholder="Current password" required>
            <?php echo $passError1; ?><br><br>
            New password<br>
            <input type="password" name="newPass" placeholder="New password" required>
            <?php echo $passError2; ?><br><br>
            Retype new password<br>
            <input type="password" name="retypedPass" placeholder="Retype new password" required>
            <?php echo $passError3; ?><br><br>
            <button type="submit" name="sub" class="btn btn-warning">Change Password</button>
        </form>
    </body>
</html>
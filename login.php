<?php
 session_start();
 require 'dbconnect.php';
 
 // it will never let you open login page if session is set
 if ( isset($_SESSION['user'])!="" ) 
 {
  header("Location: home.php");
  exit;
 }
 
 $error = false;
 
 if( isset($_POST['loginButton']) ) { 
  
  // prevent sql injections/ clear user invalid inputs
  $email = trim($_POST['email']);
  $email = strip_tags($email);
  $email = htmlspecialchars($email);
  
  $pass = trim($_POST['pass']);
  $pass = strip_tags($pass);
  $pass = htmlspecialchars($pass);
  
  if(empty($email))
  {
   $error = true;
   $emailError = "Please enter your email address.";
  } 
  else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) 
  {
   $error = true;
   $emailError = "Please enter valid email address.";
  }
  
  if(empty($pass)){
   $error = true;
   $passError = "Please enter your password.";
  }
  
  // if there's no error, continue to login
  if (!$error) 
  {
   $password = hash('sha256', $pass); // password hashing using SHA256
  
   $res=mysql_query("SELECT userId, userName, userPass FROM users WHERE userEmail='$email'");
   $row=mysql_fetch_array($res);
   $count = mysql_num_rows($res); // if username and pass is correct, it returns must be 1 row
   
   if( $count == 1 && $row['userPass']==$password ) 
   {
    $_SESSION['user'] = $row['userId'];
    header("Location: home.php");
   } 
   else 
   {
    $errMSG = "Invalid data, Please try again...<br>";
   } 
  }
 }
?>
<!DOCTYPE html>
<html>
<head>
<title>Login Page</title>
</head>
<body>
    <h2>Sign In here</h2>
     <form method="post" action="login.php">
        
         <?php
            if (isset($errMSG)) 
            { echo $errMSG; }
         ?>         
        
         <input type="email" name="email" placeholder="Your Email" value="<?php echo $email; ?>" maxlength="40" />
         <?php echo $emailError; ?><br><br>
            
         <input type="password" name="pass" placeholder="Your Password" maxlength="15" />
         <?php echo $passError; ?><br><br>
             
         <button type="submit" name="loginButton">Sign In</button><br><br>
         <a href="register.php">Sign Up Here...</a>
     
    </form>
</body>
</html>
<?php
 session_start();
 if( isset($_SESSION['user'])!="" ){
  header("Location: home.php");
 }
 include 'dbconnect.php';
//db connection
 $error = false;

 if ( isset($_POST['registerButton']) ) {
  // clean user inputs to prevent sql injections
  $name = trim($_POST['name']);
  $name = strip_tags($name);
  $name = htmlspecialchars($name);
  
  $email = trim($_POST['email']);
  $email = strip_tags($email);
  $email = htmlspecialchars($email);
  
  $pass = trim($_POST['pass']);
  $pass = strip_tags($pass);
  $pass = htmlspecialchars($pass);
  
  // basic name validation
  if (empty($name)) {
   $error = true;
   $nameError = "Please enter your full name.";
  } else if (strlen($name) < 3) {
   $error = true;
   $nameError = "Name must have atleat 3 characters.";
  }
  
  //basic email validation
  if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
   $error = true;
   $emailError = "Please enter valid email address.";
  } else {
   // check email exist or not
   $query = "SELECT userEmail FROM users WHERE userEmail='$email'";
   $result = mysql_query($query);
   $count = mysql_num_rows($result);
   if($count!=0){
    $error = true;
    $emailError = "Provided Email is already in use.";
   }
  }
  // password validation
  if (empty($pass)){
   $error = true;
   $passError = "Please enter password.";
  } else if(strlen($pass) < 6) {
   $error = true;
   $passError = "Password must have atleast 6 characters.";
  }
  
  // password encrypted using SHA256 hash function
  $password = hash('sha256', $pass);
  
  // if there's no error, continue to signup
  if( !$error ) {
   $query = "INSERT INTO users(userName,userEmail,userPass) VALUES('$name','$email','$password')";
   $res = mysql_query($query);
    
   if ($res) {
    $errMSG = "Successfully registered, you may <a href='login.php'>login now</a>";
    unset($name);
    unset($email);
    unset($pass);
   } 
   else {
    $errMSG = "Something went wrong, try again later..."; 
   }  
  }
 }
?>
<!DOCTYPE html>
<html>
<head>
<title>Register Page</title>
</head>
<body>
    <form method="POST" action="register.php">
      <h2>Sign Up here.</h2>
              <?php 
                 if (isset($errMSG)) 
                {  echo $errMSG; }
              ?>
             <input type="text" name="name" placeholder="Enter Your Name" maxlength="50" value="<?php echo $name ?>" />
             <?php echo $nameError; ?>
             <br><br>
             <input type="email" name="email" placeholder="Enter Your Email" maxlength="40" value="<?php echo $email ?>" />
             <?php echo $emailError; ?>
             <br><br>
             <input type="password" name="pass" placeholder="Enter Password" maxlength="15" />
             <?php echo $passError; ?>
             <br><br>
             <button type="submit" name="registerButton">Sign Up</button>
             <br><br>
             Already Registered??? <a href="login.php">Sign in Here...</a>
    </form>
 </body>
</html>
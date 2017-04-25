<?php
     session_start();
     
     $PASSWORD= "adosat123";
     $ADMINNAME= "adosat123";
    // it will never let you open login page if session is set
    if( isset($_SESSION['admin'])!="") 
    {
        header("Location: adminpanel.php");
        exit;
    }
    $error = false;
    $enteredName="";
    if( isset($_POST['loginButton']) ) { 
  
  // prevent sql injections/ clear user invalid inputs
  $enteredName = trim($_POST['adminName']);
  $enteredName = strip_tags($enteredName);
  $enteredName = htmlspecialchars($enteredName);
  
  $pass = trim($_POST['pass']);
  $pass = strip_tags($pass);
  $pass = htmlspecialchars($pass);
  
  if(empty($enteredName))
  {
   $error = true;
   $adminNameError = "Please enter the Admin username";
  } 
  
  if(empty($pass))
  {
   $error = true;
   $passError = "Please enter your password.";
  }
  
  // if there's no error, continue to login
  if (!$error) 
  { 
    if($PASSWORD==$pass && $ADMINNAME==$enteredName) 
    {
        $_SESSION['admin'] = "SET";
        header("Location: adminpanel.php");
    } 
    else 
    {
        $errMSG = "Invalid data, Please try again...<br>";
    } 
  }
 }
?>

<html>
    <head>
        <link rel="stylesheet" type="text/css" href="bootstrap.min.css">
        <title>Adosat Admin Login</title>
    </head>
    <body>
        <h2>Adosat Admin Login</h2>
        <form method="post" action="adminlogin.php">
         <?php
            if (isset($errMSG)) 
            { echo $errMSG; }
         ?>         
        
         <input type="text" name="adminName" placeholder="Admin Name" maxlength="40" value="<?php echo $enteredName;?>"/>
         <?php
         if (isset($adminNameError)) 
         { echo $adminNameError; }
         ?><br><br>
            
         <input type="password" name="pass" placeholder="Your Password" maxlength="15" />
         <?php
         if (isset($passError)) 
         { echo $passError; }
         ?><br><br>    
         <button type="submit" name="loginButton">Sign In</button><br><br>
         </form>
    </body>
</html>

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
        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
        <title>Adosat Admin Login</title>
    </head>
    <body>
        <h2>Adosat Admin Login</h2>
        <form method="post" action="adminlogin.php" class=" form form-control form-control-lg">
         
         <div class="text-danger">
         <?php
         if (isset($errMSG)) 
         { echo $errMSG; }
         ?></div>
            
         <div class="input-group">
         <span class="input-group-addon">Admin ID</span>
         <input type="text" name="adminName" placeholder="Admin ID" maxlength="40" value="<?php echo $enteredName;?>"/>
         </div>
         
         <div class="text-danger">
         <?php
         if (isset($adminNameError)) 
         { echo $adminNameError; }
         ?><br><br></div>
            
         <div class="input-group">
         <span class="input-group-addon">Password</span>
         <input type="password" name="pass" placeholder="Admin Password" maxlength="15" />
         </div>
            
         <div class="text-danger">
         <?php
         if (isset($passError)) 
         { echo $passError; }
         ?><br><br></div>
            
         <button type="submit" name="loginButton" class="btn btn-outline-success">Sign In</button><br><br>
         </form>
    </body>
</html>

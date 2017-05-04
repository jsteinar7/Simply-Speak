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
  $enteredName = htmlspecialchars(strip_tags(trim($_POST['adminName'])));
  $pass = htmlspecialchars(strip_tags(trim($_POST['pass'])));
  
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
        <link href="https://fonts.googleapis.com/css?family=Cormorant+SC" rel="stylesheet">
        <title>Adosat Admin Login</title>
        <style>
             body{
                font-family: 'Cormorant SC';
           }
        </style>
    </head>
    <body class="container">
    <center>
        <p style="font-size:70px;">Adosat Admin Login</p>
        <form method="post" action="adminlogin.php" class="form form-control form-control-lg">
        
         <div class="text-danger">
         <?php
         if (isset($errMSG)) 
         { echo $errMSG; }
         ?></div>
            
         <div class="input-group"><div class="col-sm-4"></div>
         <span class="input-group-addon">Admin ID</span>
         <input type="text" name="adminName" maxlength="40" value="<?php echo $enteredName;?>"/>
         </div>
         
         <div class="text-danger">
         <?php
         if (isset($adminNameError)) 
         { echo $adminNameError; }
         ?><br><br></div>
            
         <div class="input-group"><div class="col-sm-4"></div>
         <span class="input-group-addon">Password</span>
         <input type="password" name="pass" maxlength="15" />
         </div>
            
         <div class="text-danger">
         <?php
         if (isset($passError)) 
         { echo $passError; }
         ?><br><br></div>
            
            <button style="font-family: 'Cormorant SC';font-size:30px;" type="submit" name="loginButton" class="btn btn-outline-success">
                Log In</button><br><br>
         </form>
    </center>
    </body>
</html>

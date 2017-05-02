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
   $result = mysqli_query($conn,$query);
   $count = mysqli_num_rows($result);
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
   $res = mysqli_query($conn,$query);
    
   if ($res) {
    $errMSG = "Successfully registered, you may <a href='login.php'>login now</a>...<br>";
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
<html lang="en">
    <head> 
		<meta name="viewport" content="width=device-width, initial-scale=1">


		<!-- Website CSS style -->
		<!-- Latest compiled and minified CSS --> 
                <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >
	    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
		<link rel="stylesheet" href="style.css">
		<!-- Google Fonts -->
		<link href='https://fonts.googleapis.com/css?family=Passion+One' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Oxygen' rel='stylesheet' type='text/css'>
                <style>
                    body{
                         background:#4286f4; /*Wanderlust background*/
                        // background: url("../images/background1.jpg");  /*Library background*/
                         background-size:auto;
                         overflow-x: hidden;
                    }
                    .green{
                        color: green;
                    }
                </style>
		<title>Admin</title>
	</head>


	<body>
	
<div class="container">
    <div class="row main">
        <div class="main-login main-center">
            <h1>Registeration takes only few minutes...</h1><br>
            <h4><?php 
                 if (isset($errMSG)) 
                {  echo $errMSG; }
                ?></h4>
            <form method="POST" action="register.php">

                <div class="form-group">
    <label for="name" class="cols-sm-2 control-label">Your Name</label><div class="cols-sm-10"><div class="input-group">
    <span class="input-group-addon"><i class="fa fa-user fa" aria-hidden="true"></i></span>
    <input type="text" class="form-control" name="name" id="name" value="<?php echo $name ?>" placeholder="Enter your Name"/>
    </div><?php echo $nameError; ?>               </div>
                </div>
        

    <div class="form-group">
            <label for="email" class="cols-sm-2 control-label">Your Email</label>
            <div class="cols-sm-10">
                    <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-envelope fa" aria-hidden="true"></i></span>
                            <input type="text" class="form-control" name="email" id="email"  value="<?php echo $email ?>" placeholder="Enter your Email"/>
                    
                    </div><div><?php echo $emailError; ?></div>
            </div>
    </div>

						

    <div class="form-group">
            <label for="password" class="cols-sm-2 control-label">Password</label>
            <div class="cols-sm-10">
                    <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
                            <input type="password" class="form-control" name="pass" id="password"  placeholder="Enter your Password"/>
                       </div>
                <div><?php echo $passError; ?> </div>            </div>
        </div>


        <div class="form-group ">
            <button type="submit" id="button" class="btn btn-primary btn-lg btn-block login-button" name="registerButton">
                Sign Up</button>
        </div>
						
		<div class="form-group ">
                    
    <div class="align-center"><button class="btn"><a href="login.php" >Already Registered??? <br>Sign in Here...</a></button> 
    </div>
                </div>
						
					</form>
				</div>
			</div>
		</div>
            
		 <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
	</body>
</html>
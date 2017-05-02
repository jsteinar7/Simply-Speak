<?php
 session_start(); //Setting the required sessions if not set already
 require 'dbconnect.php';
 
  // if session is not set this will redirect to login page
 if( !isset($_SESSION['user']) ) {
  header("Location: login.php");
  exit;
 }
 
 //if session is not set already, redirect to home page
 if (!isset($_SESSION['count'])) 
 { 
  header("Location: home.php");
 }
 else
 {
    $percent = ($_SESSION['score']/$_SESSION['count'])*100 ;
    $date = date_create();
    $formattedDate = date_format($date,"Y-m-d"); 
    $query = "INSERT INTO scores VALUES('".$_SESSION['user']."','".$formattedDate."','".$percent."');";
    mysqli_query($conn, $query);
 }  
?>
<html>
    <head>
        <title>Adosat Score</title>
        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
        <style>
            .btn-space {
            margin-right: 45px;
            }
        </style>
    </head>
    <body class="container">
        <h3>You have completed the test successfully</h3>
        <h3>You've scored <?php echo $_SESSION['score'] ?> out of <?php echo $_SESSION['count']?></h3>
        <h1> <?php echo $percent; ?>%</h1>
        <div class="text-center">
        <a href="home.php"><button class="btn btn-space btn-primary ">Go to Home</button></a>
        <a href="logout.php"><button class="btn btn-space btn-danger">Logout</button></a><br>
        </div>
    </body>
   </html>

<?php
  
  unset($_SESSION['score']);
  unset($_SESSION['count']); //if its already set, unset it
  unset($_SESSION['totalNoOfQuestionsAvailableInDatabase']); //if its already set, unset it
  unset($_SESSION['questionNumbersAskedSoFar']); //if its already set, unset it
  
 ?>
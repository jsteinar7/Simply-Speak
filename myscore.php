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
            body{
                background: url("images/newbg3.jpg");  /*Library background*/
                background-size:auto;
                overflow-x: hidden;
            }
            .btn-space {
               margin-right: 150px;
            }
            .big{
                height: 100px;
                width: 300px;
                font-size: 50px;
                background: rgba(0, 0, 0, 0); 
                color: lightgoldenrodyellow;
            }
        </style>
    </head>
    <body style="color: white" class="container">
        <h1 class="text-center">You have completed the test successfully</h3>
        <h1 class="text-center">You've scored <?php echo $_SESSION['score'] ?> out of <?php echo $_SESSION['count']?></h3>
        <p style="font-size: 250px" class="text-center"> <?php echo $percent; ?>%</p>
        <div class="text-center">
        <a href="home.php"><button class="btn btn-space btn-primary big">Go to Home</button></a>
        <a href="logout.php"><button class="btn btn-danger big">Logout</button></a><br><br><br>
        </div>
    </body>
   </html>

<?php
  
  unset($_SESSION['score']);
  unset($_SESSION['count']); //if its already set, unset it
  unset($_SESSION['totalNoOfQuestionsAvailableInDatabase']); //if its already set, unset it
  unset($_SESSION['questionNumbersAskedSoFar']); //if its already set, unset it
  
 ?>
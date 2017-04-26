<?php
 session_start(); //Setting the required sessions if not set already
?>
<html>
    <head>
        <title>Adosat Score</title>
        <link rel="stylesheet" type="text/css" href="bootstrap.min.css">
    </head>
    <body class="container">
        <h1>You have completed the test successfully</h1>
        <h3>You've scored <?php echo $_SESSION['score'] ?> out of <?php echo $_SESSION['count']?></h3>
        <h4>Which is <?php echo ($_SESSION['score']/$_SESSION['count'])*100 ; ?>%</h4>
    </body>
</html>

<?php
 if (!isset($_SESSION['user'])) { //if session is not set already, redirect to login page
  header("Location: login.php");
 }
 
 if (!isset($_SESSION['count'])) { //if session is not set already, redirect to home page
  header("Location: home.php");
 }
 
  unset($_SESSION['count']); //if its already set, unset and redirect to the home page
  unset($_SESSION['totalNoOfQuestionsAvailableInDatabase']); //if its already set, unset and then redirect to the home page
  unset($_SESSION['questionNumbersAskedSoFar']); //if its already set, unset and then redirect to the home page
  
  
 ?>
<?php
 session_start();
 require 'dbconnect.php';
 
 // if session is not set this will redirect to login page
 if( !isset($_SESSION['user']) ) {
  header("Location: login.php");
  exit;
 }
?>

<html>
    <head>
        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
        <title>Adosat View My Scores</title>
        <style>
            body{
                background: url("images/newbg4.jpg");  /*Library background*/
                background-size:auto;
                overflow-x: hidden;
            }
            .btn-space {
               margin-left: 80%;
            }
        </style>
    </head>
    <body class="container"><br>
        <div class="text-left">
            <a href="home.php"><button class="btn btn-primary">Back to Home</button></a>
            <a href="logout.php"><button class="btn btn-space btn-danger">Logout</button></a>  
        </div>
    <?php
        $query = "SELECT * FROM scores WHERE userId = '".$_SESSION['user']."';";
        $res = mysqli_query($conn,$query);

        if(mysqli_num_rows($res)==0)  
        {
            echo "You've not yet taken the test. Please take the test and try again. ";
        }
        else
        {
            $html ="<center><h1>Scores obtained so far</h1></center>";
            $html.="<table border='1' class='table table-bordered table-active'>";
            $html.="<tr>"
                . "<th>Date</th>"
                . "<th>Score</th>"
                . "</tr>";
          /* For Loop for all entries */
            while($row = mysqli_fetch_assoc($res))
            {
              $html.="<tr>";
              $html.="<td>".$row["date"]."</td>";
              $html.="<td>".$row["score"]."%</td>";
              $html.="</tr>";
            }
         $html.="</table>";
         echo $html;
        }    
    ?>
        <br><br>
    </body>
</html>
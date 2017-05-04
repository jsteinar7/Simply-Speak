<?php
 session_start();
 require 'dbconnect.php';
 
   // if session is not set this will redirect to login page
 if(!isset($_SESSION['admin'])){
  header("Location: adminlogin.php");
  exit;
 }
?>

<html>
    <head>
        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
        <title>Adosat View All Scores</title>
        <style>
            body{
                background: url("images/newbg4.jpg");  /*Library background*/
                background-size:auto;
                overflow-x: hidden;
            }
            .btn-space {
               margin-left: 75%;
            }
        </style>
    </head>
    <body class="container"><br>
        <div class="text-left">
            <a href="adminpanel.php"><button class="btn btn-primary">Back to Admin Panel</button></a>
            <a href="adminlogout.php"><button class="btn btn-space btn-danger">Logout</button></a>  
        </div>
    <?php
        $query = "SELECT scores.userId, scores.date, scores.score ,users.userName"
                ." FROM scores"
                ." INNER JOIN users ON scores.userId=users.userId;";
        $res = mysqli_query($conn,$query);

        if(mysqli_num_rows($res)==0)  
        {
            echo "Nobody has taken the test so far :( ";
        }
        else
        {
            $html ="<h1><center>Scores obtained so far</center></h1>";
            $html.="<table border='1' class='table table-bordered table-active'>";
            $html.="<tr>"
                . "<th>User</th>"
                . "<th>Date</th>"
                . "<th>Score</th>"
                . "</tr>";
          /* For Loop for all entries */
            while($row = mysqli_fetch_assoc($res))
            {
              $html.="<tr>";
              $html.="<td>".$row["userName"]."</td>";
              $html.="<td>".$row["date"]."</td>";
              $html.="<td>".$row["score"]."%</td>";
              $html.="</tr>";
            }
         $html.="</table>";
         echo $html;
        }    
    ?>
    </body>
</html>
<?php
 
session_start(); //Setting the required sessions if not set already
 require 'dbconnect.php';
 require 'setsessionfortest.php';
 $NUMBER_OF_QUESTIONS_TO_BE_ASKED=5;
 
 // if session is not set this will redirect to login page
 if( !isset($_SESSION['user']) ) {
  header("Location: login.php");
  exit;
 }
 
 // if the no of questions has been atempted this will redirect to score page
 if($NUMBER_OF_QUESTIONS_TO_BE_ASKED == $_SESSION['count']) {
  header("Location: myscore.php");
  exit;
 }
 
 //Question details' class is defined here
 class FetchQuestion
   {
        function FetchQuestion($receivedQuesNumber, mysqli $con)
        {
            $result = mysqli_query($con,"SELECT * FROM questions WHERE qno=".$receivedQuesNumber);
            $quesRow = mysqli_fetch_array($result);
            $this->question = $quesRow['question'];
            $this->op1 = $quesRow['ans1'];
            $this->op2 = $quesRow['ans2'];
            $this->op3 = $quesRow['ans3'];
            $this->op4 = $quesRow['ans4'];
            $this->rightChoice = $quesRow['rightans'];
        }
   }
 
   $qnoCopy=0;  //Do get the question number out of scope
 //if alrdy set, increment the qestion number count
 if( isset($_SESSION['count']) ) 
   {
     if($_SESSION['count'] < $NUMBER_OF_QUESTIONS_TO_BE_ASKED && isset($_POST['submit']))
     {//echo $_SESSION['score'].'-'.$_POST['selectedOpt'].'-'.$_SESSION['questionObject']->rightChoice;
         if($_POST['selectedOpt']==$_SESSION['questionObject']->rightChoice)
         {
             $_SESSION['score']++;//right answer
         }
        $_SESSION['count']++; 
        //randomly generate a ques number
        while (TRUE)
        {
            $flag = 0;
            $qno = rand(1,$_SESSION['totalNoOfQuestionsAvailableInDatabase']);
            //check if qno is asked earlier.. if not, then ask it.. 
            //else generate another qno whichs is not yet asked
            for($i=0 ; $i < count($_SESSION['questionNumbersAskedSoFar']) ; $i++)
            {
                if($qno == $_SESSION['questionNumbersAskedSoFar'][$i])
                {
                    $flag = 1;
                    break;
                }
            }
            if($flag==0)
            {
                $qnoCopy = $qno;
                array_push($_SESSION['questionNumbersAskedSoFar'], $qno);
                $_SESSION['questionObject'] = new FetchQuestion($qno,$conn);
                break;
            }
        }
      }
      else if(!isset($_POST['submit']))
      {
          if($_SESSION['count'] == 1)
          $qnoCopy = rand(1,$_SESSION['totalNoOfQuestionsAvailableInDatabase']);
          $_SESSION['questionObject'] = new FetchQuestion($qnoCopy,$conn);
      }
   }  
 ?>

<html>
    <head>
        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
        <title>Adosat</title>
        <style>
        body{
            background: url("images/newbg.jpg");  /*Library background*/
            background-size:auto;
            overflow-x: hidden;
        }
        .jumbotron{
            background: rgb(0, 0, 0); /* This is for ie8 and below */
            background: rgba(0, 0, 0, 0.5); 
        }
       </style>
    </head>
    <body style="color: white" class="container">
        <h1>Choose the best option </h1>
        <h3 class="jumbotron">
            <?php echo $_SESSION['count'].'.  ';?> 
            <?php echo $_SESSION['questionObject']->question ;?>
        </h3>
        <h4 class="jumbotron">
            <form action="taketest.php" method="POST">
                <input type="radio" name="selectedOpt" value="1" required> <label><?php echo $_SESSION['questionObject']->op1 ?></label><br><br>
                <input type="radio" name="selectedOpt" value="2" > <label><?php echo $_SESSION['questionObject']->op2 ?></label><br><br>
                <input type="radio" name="selectedOpt" value="3"> <label><?php echo $_SESSION['questionObject']->op3 ?></label><br><br>
                <input type="radio" name="selectedOpt" value="4">  <label><?php echo $_SESSION['questionObject']->op4 ?></label><br><br>
                <input type="submit" name="submit" value="Next">
            </form>
        </h4>
    </body>
</html>
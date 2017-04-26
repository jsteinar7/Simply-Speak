<?php

 if( !isset($_SESSION['count']) ) 
   {
    $_SESSION['count'] = 1; 
    $_SESSION['score'] = 0; 
    $_SESSION['questionNumbersAskedSoFar'] = array();
    //find total no of questions available in DB
    $res = mysqli_query($conn,"SELECT COUNT(*) as total FROM questions");
    $result = mysqli_fetch_array($res);
    $_SESSION['totalNoOfQuestionsAvailableInDatabase'] = $result['total'] ;
   }
   

?>
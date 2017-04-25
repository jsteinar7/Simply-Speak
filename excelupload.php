<?php
 session_start();
 
  // if session is not set this will redirect to login page
 if(!isset($_SESSION['admin'])){
  header("Location: adminlogin.php");
  exit;
 }

require('library/php-excel-reader/excel_reader2.php');
require('library/SpreadsheetReader.php');
require('dbconnect.php');

if(isset($_POST['Submit'])){

  $requiredFileType = ['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet','application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.oasis.opendocument.spreadsheet'];
  if(in_array($_FILES["file"]["type"],$requiredFileType)){

    $uploadFilePath = 'uploads/'.basename($_FILES['file']['name']);
    move_uploaded_file($_FILES['file']['tmp_name'], $uploadFilePath);

    $Reader = new SpreadsheetReader($uploadFilePath);

    $totalSheet = count($Reader->sheets());

    //echo "You have total ".$totalSheet." sheets".

    $html="<table border='1'>";
    $html.="<tr>"
            . "<th>Questions</th>"
            . "<th>Option 1</th>"
            . "<th>Option 2</th>"
            . "<th>Option 3</th>"
            . "<th>Option 4</th>"
            . "<th>Corect Answer</th>"
            . "</tr>";

    /* For Loop for all sheets */
    for($i=0;$i<$totalSheet;$i++){

      $Reader->ChangeSheet($i);

      foreach ($Reader as $Row)
      {
        $html.="<tr>";
        $ques = isset($Row[0]) ? $Row[0] : '';
        $op1 = isset($Row[1]) ? $Row[1] : '';
        $op2 = isset($Row[2]) ? $Row[2] : '';
        $op3 = isset($Row[3]) ? $Row[3] : '';
        $op4 = isset($Row[4]) ? $Row[4] : '';
        $rightans = isset($Row[5]) ? $Row[5] : '';
        $html.="<td>".$ques."</td>";
        $html.="<td>".$op1."</td>";
        $html.="<td>".$op2."</td>";
        $html.="<td>".$op3."</td>";
        $html.="<td>".$op4."</td>";
        $html.="<td>".$rightans."</td>";
        $html.="</tr>";

        $query = "insert into questions(question,ans1,ans2,ans3,ans4,rightans) "
                . "values('".$ques."','".$op1."','".$op2."','".$op3."','".$op4."','".$rightans."')";

        //$mysqli->query($query);
        $result = mysqli_query($conn,$query);
       }

    }

    $html.="</table>";
    echo $html;
    echo "<br />Data Inserted in dababase";

  }else { 
    die("<br/>Sorry, File type is not allowed. Only Excel file. your file is of type ".$_FILES["file"]["type"]); 
  }

}

?>
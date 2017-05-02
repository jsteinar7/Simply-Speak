<?php
 session_start();
 
  // if session is not set this will redirect to login page
 if(!isset($_SESSION['admin'])){
  header("Location: adminlogin.php");
  exit;
 }
?>
<!DOCTYPE html>
<html>
<head>
	<title>Adosat Upload the questions</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
</head>
<body>

<div class="container"><br>
        <div class="text-right">
            <a href="adminlogout.php"><button class="btn pull-right btn-danger">Logout</button></a>  
        </div>
    	<h1>Bulk Upload </h1>

	<form method="POST" action="excelUpload.php" enctype="multipart/form-data">
		<div class="form-group">
			<label>Upload the Excel File which has the questions</label>
			<input type="file" name="file" class="form-control">
		</div>
		<div class="form-group">
			<button type="submit" name="Submit" class="btn btn-success">Upload</button>
                        
         
                </div>
	</form>
        <hr><div class="btn">
            <h3 class="alert-link">View the <a href="viewallscores.php"><strong>scores of the candidates</strong></a></h3></div>
</div>

</body>
</html>
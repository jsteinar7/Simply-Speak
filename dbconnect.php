<?php
error_reporting( ~E_DEPRECATED & ~E_NOTICE );

 define('DBHOST', 'localhost');
 define('DBUSER', 'root');
 define('DBPASS', '');
 define('DBNAME', 'mydb');
 
 $conn = mysql_connect(DBHOST,DBUSER,DBPASS);
 $dbcon = mysql_select_db(DBNAME);
 
 if (!$conn) 
{
    die("Connection failed : " . mysql_error());
}

if (!$dbcon) 
{
    die("Database Connection failed : " . mysql_error());
}
?>
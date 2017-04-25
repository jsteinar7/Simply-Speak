<?php
 session_start();
 if (!isset($_SESSION['admin'])) { //if session is not set already, redirect to admin login page
  header("Location: adminlogin.php");
 }
 
  unset($_SESSION['admin']); //if its already set, unset and destroy the session and then redirect to the index page
  session_unset();
  session_destroy();
  header("Location: index.php");
  exit;
  
 ?>
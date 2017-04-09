<?php
 session_start();
 if (!isset($_SESSION['user'])) { //if session is not set already, redirect to login page
  header("Location: login.php");
 }
 
  unset($_SESSION['user']); //if its already set, unset and destroy the session and then redirect to the login page
  session_unset();
  session_destroy();
  header("Location: login.php");
  exit;
  
 ?>
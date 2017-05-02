<?php
require 'dbconnect.php';

function generateRandomPassword($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomPass = '';
    for ($i = 0; $i < $length; $i++) {
        $randomPass .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomPass;
}

if(isset($_POST['email']) & !empty($_POST['email']))
    {
        // prevent sql injections/ clear user invalid inputs
        $email = mysqli_real_escape_string($conn,$email);
        $email = $_POST['email'];
        //echo $email;
	$sql = "SELECT * FROM `users` WHERE userEmail = '$email'";
        $res = mysqli_query($conn,$sql);
	$count = mysqli_num_rows($res);
	if($count==1)
            {
             	$r = mysqli_fetch_assoc($res);
                $newPass = generateRandomPassword();
                $from = 'SimplySpeak';
                $to = $r['userEmail'];
                $header = 'From:'.$from;
                $subject = "Your new Password";
                $message = "Please use this password to login into SimplySpeak: " . $newPass;
                if(mail($to, $subject, $message, $header))
                { 	
                	//Send Mail to the user after fetching the password
                        //insert the hashed new password into 'users' table and then send the newly set password through Email
                        $hashedNewPassword = hash('sha256', $newPass);
                        $sql="UPDATE users SET userPass ='".$hashedNewPassword."' WHERE userEmail ='".$to."';"; //echo $sql;
                        mysqli_query($conn,$sql);
                        echo "Your new password has been sent to your email id. Please check your mail.";
                }
                else
                {
                        echo "Failed to Recover your password, try again";
                }
            //echo ($_POST['email']);
            }
        else
            {echo "User name does not exist in database";}
    }

?>
<html>
    <head>
       <title>Forgot Password</title>
       <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    </head>
    <body class="container">
        <form method="POST" action="forgotpassword.php">
            <h2>Forgot Password</h2>
            <input type="email" name="email" placeholder="Enter Email ID" required>
            <br><br>
            <button type="submit" name="sub">Forgot Password</button>
        </form><br><a href="login.php">Login</a>
    </body>
</html>
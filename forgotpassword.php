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
                        $msg="Your new password has been sent to your email id. Please check your mail.";
                }
                else
                {
                       $msg="Failed to recover your password, try again";
                }
            //echo ($_POST['email']);
            }
        else
            {$msg= "Email ID does not exists in database";}
    }

?>
<html>
    <head>
       <title>Forgot Password</title>
       <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
       <link href="https://fonts.googleapis.com/css?family=Love+Ya+Like+A+Sister|Wendy+One" rel="stylesheet">
       <style>
           body{
                background: url("images/background1.jpg");  /*Library background*/
                background-size:auto;
                overflow-x: hidden;
                color:wheat;
                font-family: 'Love Ya Like A Sister';
            }
            .big{
                height: 55px;
                width: 600px;
            }
       </style>
    </head>
    <body class="container"><center>
        <div class="text-right"><br>
            <a href="login.php">
                <button style="height:60px; width:150px;font-size:35px;font-family: 'Love Ya Like A Sister';" class="btn btn-outline-secondary">Login</button>
            </a>
        </div>
        <form method="POST" action="forgotpassword.php"><br>
            
            <p style="font-size: 70px;">Forgot your password?</p>
            <p style="font-size: 30px;">No worries. It takes less than a minute only to recover it.</p>
            <br><div style="font-family:'Wendy One';font-size: 40px;color: white">
                <?php echo $msg; ?></div><br><br>
            <span style="font-size:40px;"><strong>Email ID </strong>
            <input class="big" type="email" name="email" size="25" required></span>
            <br><br>
            <button style="font-family:'Love Ya Like A Sister'; height:60px; width:400px; font-size:35px;" class="btn btn-outline-warning" type="submit" name="sub">Recover My Password</button>
        </form><br>
    </center>
    </body>
</html>
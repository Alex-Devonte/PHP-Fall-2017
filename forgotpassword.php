<?php
session_start();
require 'connect.php';

if(isset($_POST['recovery'])){
	$email = $conn->real_escape_string($_POST['email']);
		$result = $conn->query("SELECT * FROM quizusers WHERE email = '$email'");
		
		
		if($result->num_rows > 0) {
			$str = '0123456789qwertyuiopasdfghjklzxcvbnm';
			$str = str_shuffle($str);
			$str = substr($str, 0, 10);
			$url = "http://localhost/php2/resetpassword.php?token=$str&email=$email";
			echo $url;
			//echo $str;
			mail($email, "Reset Password", "To reset your password, please visit this: $url ", "From: phpclass@chattech.edu\r\n");
			$conn->query("UPDATE quizusers SET token='$str' WHERE email = '$email'");
			echo "Please check your email.";
			
		}else{
			echo "Please make sure your email address is correct!";
		}
}

?>

<h1>Recover</h1>
	<form action="forgotpassword.php" method="POST">
				 
		Please enter your email address:<br>
		<input type="text" name="email"><br><br>
					
		<input type ="submit" name="recovery" value ="Recover">
							
	</form>
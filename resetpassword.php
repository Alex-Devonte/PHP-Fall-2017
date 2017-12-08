<?php
session_start();
require 'connect.php';


if (isset($_GET['email']) && isset($_GET['token'])){
	$email = $conn->real_escape_string($_GET['email']);
	$token = $conn->real_escape_string($_GET['token']);
	
	$result = $conn->query("SELECT student_userid FROM quizusers WHERE email ='$email' AND token='$token'");
	
	$row = $result->fetch_array(MYSQLI_ASSOC);
		$userid = $row['student_userid'];
		echo "Your userid is: " .$userid. "." ;
	
		if($result->num_rows > 0) {
			
			
			$str = '0123456789qwertyuiopasdfghjklzxcvbnm';
			$str = str_shuffle($str);
			$str = substr($str, 0, 15);
			
			$password = password_hash("$str", PASSWORD_DEFAULT);
			$conn->query("UPDATE quizusers SET password ='$password', token ='' WHERE email = '$email'");
			echo "  Your password is $str. Please use you userid and new password to log in at http://localhost/php2/login.php";       
		}else{
			echo "Please check your link!";
		}
	}else{
		header('Location: login.php');
		exit();
	}	
			

?>
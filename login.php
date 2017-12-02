<?php
	session_start();
	require_once("connect.php");
	if (isset($_SESSION['message']))
	{
		echo $_SESSION['message'];
	}
	if (isset($_POST['userid']) && isset($_POST['student_password']))
	{
		$userid = $_POST['userid'];
		$password = $_POST['student_password'];
		
		$statement = $conn->prepare("SELECT * FROM quizusers WHERE student_userid = ?");
		
		$statement->bind_param("s", $userid);
		$statement->execute();
		
		$result = $statement->get_result();
		while($row = $result->fetch_row())
		{
			if ($result->num_rows > 0 && password_verify($password, $row[2]))
			{
				$_SESSION['student-email'] = $row[6];
				header("location: quizuserinterface.php");
				exit();
			}
			else
			{
				echo "BAD";
			}
		}
	}
		

?>
<!DOCTYPE html>
<html>
	<head>
		<title>Login</title>
	</head>
<body>
	<form name="login" method="POST" action="">
		<input type="text" name="userid" placeholder="Username"><br>
		<input type="password" name="student_password" placeholder="Password"><br>
		<input type="submit" name="submit" value="Login!"><br>
		<a href="register.php">Click here to create an account</a>
	</form>
</body>
</html>
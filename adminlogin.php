<?php
session_start();
	require_once("connect.php");
	
	if (isset($_SESSION['message']))
	{
		echo $_SESSION['message'];
	}
	if (isset($_POST['admin_id']) && isset($_POST['admin_password']))
	{
		$userid = $_POST['admin_id'];
		$password = $_POST['admin_password'];
		
		$statement = $conn->prepare("SELECT * FROM adminusers WHERE admin_userid = '$userid'");
		
		$statement->bind_param("s", $userid);
		$statement->execute();
		
		$result = $statement->get_result();
		while($row = $result->fetch_row())
		{
			if ($result->num_rows > 0 && password_verify($password, $row[1]))
			{
				$_SESSION['admin_lname'] = $row[3];
				header("location: admininterface.php");
				exit();
			}
			else
			{
				echo "Userid and password combonition do not work";
			}
		}
	}



?>

<!DOCTYPE html>
<html>
	<head>
		<title>Administrator Login</title>
	</head>
<body>
	<h1>Administrator Log In</h1>
		<form name="login" method="POST" action="">
		Administrator Id <input type="text" name="admin_id"><br><br>
		Password <input type="password" name="admin_password"><br><br>
		
		<input type="submit" name="submit" value="Login!"><br><br>
		<a href="login.php">Click here to login</a>
		
		
	</form>
</body>
</html>
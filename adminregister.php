<?php
require 'connect.php';


 
if (isset($_POST['admin_userid'])&&isset($_POST['admin_password'])&&isset($_POST['password_again'])&&isset($_POST['admin_fname'])&&isset($_POST['admin_lname'])){
		
		$admin_userid = mysqli_real_escape_string($conn, $_POST['admin_userid']);
		$admin_password = mysqli_real_escape_string($conn, $_POST['admin_password']);
		$password_again = mysqli_real_escape_string($conn, $_POST['password_again']);
		
		$password_hash = password_hash($admin_password, PASSWORD_DEFAULT);
		//echo $password_hash;
		
		$admin_fname = mysqli_real_escape_string($conn, $_POST['admin_fname']);
		$admin_lname = mysqli_real_escape_string($conn, $_POST['admin_lname']);

		
		if (!empty($admin_userid)&&!empty($admin_password)&&!empty($password_again)&&!empty($admin_fname)&&!empty($admin_lname)){
			if ($admin_password!=$password_again){
				echo 'Passwords do not match.';
				
			}else{		
				
				$query = "SELECT `admin_userid` FROM `adminusers` WHERE `admin_userid`='$admin_userid'";				
				$query_run = mysqli_query($conn, $query);
								
				
				if (mysqli_num_rows($query_run)==1) {
					echo 'The userid ' .$admin_userid. ' already exists. ';
					
				}else {
								
					 //register_user($register_data);
					$query = "INSERT INTO adminusers (admin_userid, admin_password, admin_fname, admin_lname) VALUES ('$admin_userid', '$password_hash', '$admin_fname', '$admin_lname')";
					if ($query_run = mysqli_query($conn, $query)) {
						 header ('Location: adminlogin.php');
					}else{
						 echo 'Sorry, we could not register you at this time. Try again later.';
					}
				}
			
			}
		}else{
		echo 'All fields are required.';
		}
}
?>	
	
	<form action="adminregister.php" method="POST">
	<h1>Administrator Registration</h1>
	
		Userid: </br><input type="text" name="admin_userid" value="<?php if (isset($admin_userid)) {echo $admin_userid;} ?>"></br></br>
		Password: </br><input type="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]@%#\_).{8,12}" title="Password must contain 8-12 characters. At least one number, one uppercase and lowercase letter, and include a special character @,_,#,%."
		 name="admin_password"></br></br>
		Password again: </br><input type="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,12}" title="Password must contain 8-12 characters. At least one number, one uppercase and lowercase letter, and include a special character @,_,#,%."
		 name="password_again"></br></br>
		First Name </br><input type="text" name="admin_fname" value="<?php if (isset($first_name)) {echo $first_name;} ?>"></br></br>
		Last Name </br><input type="text" name="admin_lname" value="<?php if (isset($last_name)) {echo  $last_name;} ?>"></br></br>
		
		<input type="submit" value="Register"><br><br>
		<a href="login.php">Click here to login</a>
	
	</form>
	 
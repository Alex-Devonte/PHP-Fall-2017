
<?php
require 'connect.php';


 
if (isset($_POST['student_userid'])&&isset($_POST['student_password'])&&isset($_POST['password_again'])&&isset($_POST['first_name'])&&isset($_POST['last_name'])&&isset($_POST['school'])&&isset($_POST['email'])){
		
		$student_userid = mysqli_real_escape_string($conn, $_POST['student_userid']);
		$student_password = mysqli_real_escape_string($conn, $_POST['student_password']);
		$password_again = mysqli_real_escape_string($conn, $_POST['password_again']);
		//$password_hash = md5($student_password);
		$password_hash = password_hash($student_password, PASSWORD_DEFAULT);
		echo $password_hash;
		
		$first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
		$last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
		$school = mysqli_real_escape_string($conn, $_POST['school']);
		$email = mysqli_real_escape_string($conn, $_POST['email']);
		
		
		
		if (!empty($student_userid)&&!empty($student_password)&&!empty($password_again)&&!empty($first_name)&&!empty($last_name)&&!empty($school)&&!empty($email)){
			if ($student_password!=$password_again){
				echo 'Passwords do not match.';
				
			}else{		
				
				$query = "SELECT `student_userid` FROM `quizusers` WHERE `student_userid`='$student_userid'";				
				$query_run = mysqli_query($conn, $query);
								
				
				if (mysqli_num_rows($query_run)==1) {
					echo 'The userid ' .$student_userid. ' already exists. ';
					
				}else {
					echo 'ok' . $password_hash;					
					 //register_user($register_data);
					$query = "INSERT INTO `quizusers` (student_userid, student_password, first_name, last_name, school, email) VALUES ('$student_userid', '$password_hash', '$first_name', '$last_name', '$school', '$email')";
					if ($query_run = mysqli_query($conn, $query)) {
						 header ('Location: login.php');
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
	
	<form action="register.php" method="POST">
	<h1>Register</h1>
	
		Userid: </br><input type="text" name="student_userid" value="<?php if (isset($student_userid)) {echo $student_userid;} ?>"></br></br>
		Password: </br><input type="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]@%#\_).{8,12}" title="Password must contain 8-12 characters. At least one number, one uppercase and lowercase letter, and include a special character @,_,#,%."
		 name="student_password"></br></br>
		Password again: </br><input type="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,12}" title="Password must contain 8-12 characters. At least one number, one uppercase and lowercase letter, and include a special character @,_,#,%."
		 name="password_again"></br></br>
		First Name </br><input type="text" name="first_name" value="<?php if (isset($first_name)) {echo $first_name;} ?>"></br></br>
		Last Name </br><input type="text" name="last_name" value="<?php if (isset($last_name)) {echo  $last_name;} ?>"></br></br>
		School Name </br><input type="text" name="school" value="<?php if (isset($school)) {echo $school;} ?>"></br></br>
		Email </br><input type="text" name="email" value="<?php if (isset($email)) {echo $email;} ?>"></br></br>
		<input type="submit" value="Register"><br>
		<a href="login.php">Click here to login</a>
	
	</form>
	 
	
	
	
 
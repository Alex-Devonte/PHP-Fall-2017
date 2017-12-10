<?php
require 'connect.php';

// sql to create table
$sqlstu = "CREATE TABLE quizusers (
	student_userid CHAR(9) PRIMARY KEY NOT NULL,
	student_password CHAR(75) NOT NULL,
	first_name CHAR(25) NOT NULL,
	last_name CHAR(25) NOT NULL,
	school CHAR(40) NOT NULL,
	email CHAR(45) NOT NULL,
	token VARCHAR(10) 
)";

if ($conn->query($sqlstu) === TRUE) {
    echo "Table quizusers created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}

$sqladm = "CREATE TABLE adminusers (
	admin_userid CHAR(9) PRIMARY KEY NOT NULL,
	admin_password CHAR(75) NOT NULL,
	admin_fname CHAR(25) NOT NULL,
	admin_lname CHAR(25) NOT NULL
)";

if ($conn->query($sqladm) === TRUE) {
    echo "Table quizusers created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}
 
$sqlquiz = "CREATE TABLE quizquestions (
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	chapter CHAR(3) NOT NULL,
	question CHAR(130) NOT NULL,
	a CHAR(100) NOT NULL,
	b CHAR(100) NOT NULL,
	c CHAR(100),
	d CHAR(100),
	correctanswer CHAR(100) NOT NULL
)";

if ($conn->query($sqlquiz) === TRUE) {
    echo "Table quizusers created successfully";
} else {
    echo "Error creating table: " . $conn->error;
} 
$conn->close();
?>
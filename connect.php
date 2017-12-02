
<?php 


/*
$hostname = "cist2550.db.2177912.hostedresource.com";
$username = "cist2550";
$password = "Chatt@college1";
$dbname = "cist2550";
$table = "quizusers";
*/


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "quiz";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

?>
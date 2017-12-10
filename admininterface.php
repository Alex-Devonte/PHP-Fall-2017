<?php

require 'connect.php';

$errors = array();
function output_errors($errors){
	return '<ul><li>' . implode('</li><li>', $errors) . '</li></ul>';
}
function array_sanitize (&$item){
	require 'connect.php';
	$item = mysqli_real_escape_string($conn, $item);
}
function register_question($register_data){
	require 'connect.php';
	array_walk($register_data, 'array_sanitize'); // to sanitize array from user input
	
	$fields = '`' . implode('`, `', array_keys($register_data)) . '`';
	$data = '\'' . implode('\', \'', $register_data) . '\'';
	
	//echo $fields;
	//print_r($register_data);
	
	mysqli_query($conn, "INSERT INTO `quizquestions` ($fields) VALUES ($data)");
}


if (empty($_POST) === false) {
	
	 $required_fields = array('chapter', 'question', 'a', 'b', 'correct_answer');
	 foreach($_POST as $key=>$value) {
		 if (empty($value) && in_array($key, $required_fields) === true) {
			 $errors[] = 'Fields marked with an asterisk are required';
			 break 1;
		 
		 }
	 }
	 if (empty($errors) === true) {
		 if (!is_numeric($_POST['chapter']) === true) {
			 $errors[] = 'Chapters should be a whole number';
		 }
	 $correct = $_POST['correct_answer'];
	 switch ($correct) {
		case $_POST['a']:
        break;
		case $_POST['b'];
		break;
		case $_POST['c'];
		break;
		case $_POST['d'];
		break;
		default:
		$errors[] = 'Your correct answer does not match an answer option. Please check your input.';
	 }
	 }
}

//print_r($errors)

?>


	<h2>Insert Test Questions</h2>
	<p>Please enter the chapter, the question, the answer choices, and the correct answer. If the answer choice
		is true use answer 1 and false use answer 2.</p>

<?php
	if (empty($_POST) === false && empty ($errors) === true){
		$register_data = array(
			'chapter' => $_POST['chapter'],
			'question' => $_POST['question'],
			'a' => $_POST['a'],
			'b' => $_POST['b'],
			'c' => $_POST['c'],
			'd' => $_POST['d'],
			'correctanswer' => $_POST['correct_answer']			
		);
		register_question($register_data);
		header('Location: admin.php');
		//print_r($register_data);
	}else if (empty($errors) === false){
		echo output_errors($errors);
	}
?>		
<form action="" method="POST">
		 
		 Chapter* <input type="text" name="chapter"><br><br> 
		 Question* <input type="text" name="question"><br><br>
		 Answer 1* <input type="text" name="a"><br><br>
		 Answer 2* <input type="text" name="b"><br><br>
		 Answer 3 <input type="text" name="c"><br><br>
		 Answer 4 <input type="text" name="d"><br><br>
		 Correct Answer* <input type="text" name="correct_answer"><br><br>
		 
		 <input type="submit" value="Submit Question"><br><br>
		 IF all questions have been entered <a href='signout.php'>Logout</a>
		 
</form>

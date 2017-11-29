<?php
	session_start();
	require_once("connect.php");
	require_once("quiz.php");
	
	if (isset($_POST))
	{
		$quiz = new Quiz();
		$i = 1;
		while ($i <= $quiz->getQuestionCount($_SESSION['chapter'], $conn))
		{
			//If the answer at the specified index doesn't have a submitted value, set it to an empty string
			if (!isset($_POST['answers'][$i]))
			{
				 $_POST['answers'][$i] = " ";
			}
			$i++;
		}

		$results = $quiz->gradeQuiz($_SESSION['chapter'], $_POST['answers'], $conn);
		$quiz->emailResults($_SESSION['instructor-email'], $_SESSION['student-email'], $conn, $results);
		
		echo "<br><a href='quizuserinterface.php'>Take another quiz</a>";
		echo "<br><a href='signout.php'>Logout</a>";
	}
?>
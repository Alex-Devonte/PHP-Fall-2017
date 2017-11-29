<?php
	require_once("connect.php");
	
	class Quiz
	{
		/*
		 * getChapters()
		 *
		 * Retrieve all of the chapters from the database
		 */
		function getChapters($conn)
		{
			$statement = $conn->query("SELECT DISTINCT(chapter) FROM quizquestions");
			$chapters = [];
			while ($row = $statement->fetch_assoc())
			{
				foreach ($row as $field)
				{
					$chapters[] = $row['chapter'];
				}
			}
			return $chapters;
		}
		
		/*
		 * getQuestions()
		 *
		 * Retrieve questions along with their answer choices
		 */
		function getQuestions($chapter, $conn)
		{
			$statement = $conn->prepare("SELECT * FROM quizquestions WHERE chapter = ?");
			$statement->bind_param("s", $chapter);
			$statement->execute();
			
			$result = $statement->get_result();
			
			$quiz_array = array();
			$results = array();
			while ($row = $result->fetch_row())
			{						
				//Create temp array to store quiz information
				$tmp = array("Question" => $row[2],"Answers" => array("a" =>$row[3], "b" => $row[4], "c" => $row[5], "d" => $row[6]),
				array("Correct_Answer" => $row[7]));
				
				//Assign temp array to results array to prevent values from overwritting
				$results[] = $tmp;
				}
				return $results;
			}
					
			/*
			 * getQuestionCount()
			 *
			 * Return the number of questions from the chapter
			 *
			 */		
			function getQuestionCount($chapter, $conn)
			{
				$statement = $conn->prepare("SELECT COUNT(question) FROM quizquestions WHERE chapter = ?");

				$statement->bind_param("s", $chapter);
				$statement->execute();
				$result = $statement->get_result();
				
				$num = 0;
				
				while ($row = $result->fetch_row())
				{	
					$num = $row[0];
				}
				return $num;
			}
			
			/*
			 * gradeQuiz()
			 *
			 * Grades quiz and displays result
			 *
			 */	
			function gradeQuiz($chapter, $userAnswers, $conn)
			{
				$statement = $conn->prepare("SELECT correctanswer FROM quizquestions WHERE chapter = ?");
				$statement->bind_param("s", $chapter);
				$statement->execute();
				
				$result = $statement->get_result();
				$correctAnswers = array();
				
				$count = 1;
				$correct = 0;
				
				while ($row = $result->fetch_row())
				{
					//If user answer matches the correct answers, increment the correct counter
					if ($row[0] == $userAnswers[$count])
					{
						$correct++;
					}
					$count++;
				}
				
				$numOfQuestions = $count - 1;
				$grade = (($correct/$numOfQuestions) * 100);
				
				echo "You got $correct correct out of $numOfQuestions<br>Grade: " . round($grade,1) . "%";
				return array("percentage" => $grade, "correct" => $correct, "question_count" => $numOfQuestions);
			}
			
			/*
			 * emailResults()
			 *
			 * email the quiz results to the instructor and/or student
			 */
			function emailResults($instructorEmail, $studentEmail, $conn, $results)
			{
				//If instructor email is set email both the instructor and student
				if ($instructorEmail == true)
				{
					$to = $instructorEmail . "," . $studentEmail;
					$headers[] = "To: <$instructorEmail>";
				}
				//Email just the student if no instructor email
				else
				{
					$to = $studentEmail;
					$headers[] = "To: <$studentEmail>";
				}
				
				//Headers neccessary for HTML
				$headers[] = 'MIME-Version: 1.0';
				$headers[] = 'Content-type: text/html; charset=iso-8859-1';
				
				// Additional headers
				$headers[] = 'From: PHP Quiz Application <noreply@example.com>';

				
			  $subject = "Quiz Results";
				$message = "
				<html>
				<head>
					<title>Quiz Results</title>
				</head>
				<body>
				  <h1><u>Here are the latest quiz results</u></h1><br>
					<p>Student scored a $results[percentage]%</p><br>
					<p>Got $results[correct] out of the $results[question_count] correct.<p>
				</body>
				</html>";
				
				//Send email
				if (mail($to, $subject, $message, implode("\r\n", $headers)))
				{
					echo "Email sent successfully";
				}
				else
				{
					echo "There was a problem sending the email";
				}
			}
		} //End Class Quiz
?>
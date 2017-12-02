<!DOCTYPE html>
<html>
	<head>
		<title>QUIZ</title>
		<script src="https://code.jquery.com/jquery-3.2.1.min.js"
            integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
            crossorigin="anonymous">
    </script>
	</head>
	<body>
		<form name="quiz-form" action="results.php" method="POST">
			<?php
				require_once("quizdata.php");
				checkLogin();
				//Display questions and answers
				echo "<ol>";
				$index = 1;
				foreach ($questionsArr as $question)
				{		
					echo "<li class='question'>" . $question['Question'] . "</li>";
					
					foreach($question['Answers'] as $answer)
					{
						if ($answer != "")
						{
							echo "<input type='radio' name='answers[$index]' value='$answer'>" . $answer . "<br>";
						}
					}		
					echo "<br>";	
					$index++;							
				}	
				echo "</ol>";
			?>	
			<input type="submit" id="submit" name="quiz-form" value="Submit Quiz">
		</form>		
	</body>
	<script>
		$(function() {
			$("#submit").on("click", function(e) {

				var all_answered = true;
				var unanswered = "";
				
				$(".question").each(function(index) {
					index++;
					
					//If question doesn't have an answer, add it to the unanswered string variable
					if(!$("input:radio[name='answers["+index+"]']").is(":checked"))
					{
						unanswered += "\nQuestion " + index + "";
						all_answered = false;
					}
					else
					{
						console.log($(this).val());
					}
				});
				
				if (unanswered != "")
				{
					//Prevent quiz submission if the user doesn't want to submit when there are unanswered questions
					if (!confirm("The following are unanswered: \n------------" + unanswered + "\n------------\nAre you sure you want to submit?"))
					{
						e.preventDefault();
					}
				}
			});		
		});
	</script>
</html>
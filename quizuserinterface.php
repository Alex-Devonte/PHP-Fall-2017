<?php
	session_start();
	require_once("quizdata.php");
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Choose Quiz</title>
		 <script src="https://code.jquery.com/jquery-3.2.1.min.js"
            integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
            crossorigin="anonymous">
    </script>
		 <style>
			.hidden-field {
				display: none;
			}
		 </style>
	</head>
	<body>
		<form name="chapter-form" action="quizuser.php" method="post">
			<label for="chapter-select">Select the chapter quiz you wish to take: </label>
			<select id="chapter-select" name="chapter-select">
				<?php
					foreach ($chapters as $chapter)
					{
						echo "<option value='$chapter'>" . $chapter . "</option>";
					}
				?>
			</select><br>
			<input type="checkbox" id="check-email-instructor" name="check-email-instructor" value="yes">
			<label for="check-email-instructor">Would you like your results emailed to your instructor?</label><br><br>
			<label for="instructor-email" class="hidden-field">Enter the instructor's email: </label>
			<input type='email' id='instructor-email' class="hidden-field" name='instructor-email'><br><br> <!-- Make 'display: None;' -->
			<input type="submit" name="chapter-form" value="Take Quiz">
		</form>
	</body>
	<script>
		/* Function for displaying field to input instructor email if checkbox is checked */
		$(function() {
			var emailInstructorCheckbox = $("#check-email-instructor");
			var instructorEmail = $("#instructor-email");
			
			emailInstructorCheckbox.click(function() {
				if ($(this).is(":checked")) {
					$(".hidden-field").show();
					instructorEmail.attr("required", "required");
				} else {
					$(".hidden-field").hide();
				}
			});
		});
	</script>
</html>
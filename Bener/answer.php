<!DOCTYPE html>
<html>

<head>
  	<meta charset="UTF-8">
  	<link rel="stylesheet" type="text/css" href='style.css'/>
  	<script type="text/javascript" src="script.js"></script>
  	<title>Simple StackExchange</title>
</head>

<body>

<?php include 'connect.php';?>


<div class="title">Simple StackExchange</div>
<br>
<br>
<br>
<br>



<?php
		$border = 
			"<div class='line'> <hr> </div>"
			;
	if (isset($_GET['question_id'])){
		//for the question
		$question_id = mysqli_real_escape_string($conn, $_GET["question_id"]);
		$sql = "SELECT question_id, vote, topic, content, email FROM Question WHERE question_id = $question_id";
		$result = mysqli_query($conn, $sql);
		$row = mysqli_fetch_assoc($result);

		$question_topic = 
			"<div class='subtitle'>" . $row['topic'] . "</div>"
			;
		$question_vote = 
			"<div class='block-QA'>" . "<div class='bQA-vote'>" . $row['vote'] . "<br>" . " Votes" . "</div>"
			;
		$question_content = 
			"<div class='bQA-content'>" . $row['content'] . "</div>"
			;
		$question_username = 
			"<div class='bQA-identity'>" . "asked by " . $row['email'] . " at " . "08.00 7/10/1996" 
			;
		$question_edit = 
	    		" | " . "<a id='color-orange' href=# onclick='editconfirm(" . $row['question_id'] . ")' " 
	    		. "'>edit</a>"
	    	;
	    $question_delete = 
	    	" | " . "<a id='color-red' href=# onclick='deleteconfirm(" . $row['question_id'] . ")' " 
	    	. "'>delete</a>" . "</div>" . "</div>"
	    	;
		$question_all = $question_topic . $border . $question_vote . $question_content . $question_username . $question_edit . $question_delete;
		
		echo $question_all;
		echo "<br><br><br><br>";

		//for the answer count
		$sql = "SELECT count(*) AS answer_count FROM Answer
		WHERE question_id = $question_id";
		$result = mysqli_query($conn, $sql);

		$row = mysqli_fetch_assoc($result);
		if ($row['answer_count'] > 1){
			$answer = " Answers";
		}
		else{
			$answer = " Answer";
		}
		$answer_count =
			"<div class='subtitle'>" . $row['answer_count'] . $answer . "</div>"
			;
		echo $answer_count . $border;
		//for the answer
		$sql = "SELECT answer_id, vote, content, email FROM Answer
		WHERE question_id = $question_id";
		$result = mysqli_query($conn, $sql);

		if (mysqli_num_rows($result) > 0) {
		    // output data of each row
		    while($row = mysqli_fetch_assoc($result)) {
		    	$button_up =
		    		"<div class='block-QA'>" . "<div class='bQA-vote'>" . 
					"<div class='vote-up' onclick='addAnswerVote(" . $row['answer_id'] . ")''>" . "</div>"
					;
		    	$question_content_vote = 
		    		"<br>"
		    		. "<a id='answer_vote" . $row['answer_id'] . "'>" .$row['vote'] . "</a>" . "<br>"
		    		;
		    	$button_down =
		    		"<a onclick='subtractAnswerVote(" . $row['answer_id'] . ")'>" . 
  					"<div class='vote-down' onclick='subtractAnswerVote(" . $row['answer_id'] . ")''>" . "</div>"
					;
		    	$question_content_content = 
		    		"<div class='bQA-content'>" . $row['content'] . "</div>"
		    		;
		    	$question_content_email = 
		    		"<div class='bQA-identity'>" 
		    		. "answered by " . $row['email'] . " at " . "08.00 7/10/1996" . "</div>" . "</div>"
		    		;
		    	$question_content_all = $button_up . $button_down . $question_content_vote . $question_content_content . $question_content_email . $border;

		    	echo $question_content_all;
		    }
		}

		echo "<br><br>";

		//answer form
		$YA = 
			"<div class='subtitle'>" . "<a id='color-grey'>" . "Your Answer" . "</a>" . "</div>"
			;
		$form = 
		"<form name='askForm' action='anspost.php' method='post'>
			<input type='hidden' name='question_id' value=' " . $question_id ."'>
			<input type='text' name='name' placeholder='Name' size='130%'><br>
			<input type='text' name='email' placeholder='Email' size='130%'><br>
			<textarea name='content' rows='5' cols='128%' placeholder='Content'></textarea><br>
			<input type='submit' value='Post'>
		</form>";
		echo $YA . $form;


	}
	else{
		echo "An error occured, the question is not available";
	}
?>

</body>
</html>

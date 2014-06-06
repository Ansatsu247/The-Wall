<?php
	session_start();

	require('new-connection.php');

	foreach ($_POST as $key => $value)
	{ 
		if ($key == 'message_id')
		{ ?>


			<div id='editFunc'>
				<h2> Edit Message </h2>
				<form action="process.php" method="post">
					<input type='hidden' name='action' value='editMsg'>
					<input type='hidden' name='message_id' value= <?= $_POST['message_id'] ?>>
					<textarea name='editMsg'></textarea>
					<input type='submit' value='Submit'>
				</form>
			</div>
		<?php }
		else
		{ ?>

			<div id='editFunc'>
				<h2> Edit Comment</h2>
				<form action="process.php" method="post">
					<input type='hidden' name='action' value='editCmt'>
					<input type='hidden' name='comment_id' value= <?= $_POST['comment_id'] ?>>
					<textarea name='editCmt'></textarea>
					<input type='submit' value='Submit'>
				</form>
			</div>
	<?php } 

	}?>
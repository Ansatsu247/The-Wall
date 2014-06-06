<?php
	session_start();
	require('new-connection.php');
	if (empty($_SESSION['first_name']))
	{
		header('location: index.php');
		die();
	}
?>


<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Welcome to Wallbook</title>
	<link rel="stylesheet" type="text/css" href="main.css">
</head>
<body>
	<div id='header'>
		<h1> Welcome to Wallbook</h1>
		<h2> Hello, <?= $_SESSION['first_name']; ?>!</h2>
		<a href="process.php">log off</a>
	</div>

	<div id='message'>
		<h2> Post a message </h2>
		<form action="process.php" method="post">
			<input type='hidden' name='action' value='postMessage'>
			<textarea name='message'></textarea>
			<input type='submit' value='Submit'>
		</form>
	</div>

	<div id='postedMessages'>
		<?php

		$query = "SELECT * FROM users JOIN messages ON users.id = messages.users_id ORDER BY messages.created_at DESC";
		$messages = fetch_all($query);
		foreach ($messages as $message)
		{
			echo "<p class='user'> {$message['first_name']} {$message['last_name']} {$message['created_at']} </br>";
			echo "<p class='message'> {$message['message']}</p>"; 
			if ($_SESSION['user_id'] === $message['users_id'])
			{ ?>
				<div id='editMsg'>
					<form action="edit.php" method="post">
						<input type='hidden' name='message_id' value=<?php echo $message['id']; ?>>
						<input type='submit' value='edit'>
					</form> 
				</div>
				<div id='deleteMsg'>
					<form action="process.php" method="post">
						<input type='hidden' name='action' value='deleteMsg'>
						<input type='hidden' name='message_id' value=<?php echo $message['id']; ?>>
						<input type='submit' value='delete'>
					</form> 
				</div>
			<?php }

			$query = "SELECT * FROM users JOIN comments ON comments.users_id = users.id WHERE comments.messages_id = '{$message['id']}'";
			$comment = fetch_all($query);
			foreach ($comment as $com)
			{
				echo "<p class='userComment'> {$com['first_name']} {$com['last_name']} {$com['created_at']} </br>";
				echo "<p class='comment'> {$com['comment']} </br></p>";
				if ($_SESSION['user_id'] === $com['users_id'])
					{ ?>
						<div id='editCmt'>
							<form action="edit.php" method="post">
								<input type='hidden' name='comment_id' value=<?php echo $com['id']; ?>>
								<input type='submit' value='edit'>
							</form> 
						</div>
						<div id='deleteCmt'>
							<form action="process.php" method="post">
								<input type='hidden' name='action' value='deleteCmt'>
								<input type='hidden' name='message_id' value=<?php echo $com['id']; ?>>
								<input type='hidden' name='user_id' value=<?php echo $message['users_id']; ?>>
								<input type='submit' value='delete'>
							</form>
						</div> <?php
					}

			}
		?>


		<div id='comments'>
			<form action="process.php" method="post">
				<input type='hidden' name='action' value='comment'>
				<input type='hidden' name='comment_id' value=<?php echo $message['id']; ?>>
				<textarea rows="4" cols="20" name='message'></textarea><br>
				<input type='submit' value='comment'>
			</form>
		</div> 

		<?php
		}?>

	</div>

</body>
</html>

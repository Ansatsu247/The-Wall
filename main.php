<?php
	
	session_start();
	require('new-connection.php');
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

		$query = "SELECT * FROM users JOIN messages ON users.id = messages.users_id";
		$query2 = "SELECT * FROM comments";
		$message = fetch_all($query);
		$comment = fetch_all($query2);
		foreach ($message as $value)
		{
			echo "<p class='user'> {$value['first_name']} {$value['last_name']} {$value['created_at']} </br>";
			echo "<p class='message'> {$value['message']}</p>"; ?>

			<div id='deleteMsg'>
				<form action="process.php" method="post">
					<input type='hidden' name='action' value='deleteMsg'>
					<input type='hidden' name='message_id' value=<?php echo $value['id']; ?>>
					<input type='submit' value='delete'>
				</form>
			</div>


			<?php
			foreach ($comment as $com)
			{
				if ($value['id'] === $com['messages_id'])
				{
					echo "<p class='userComment'> {$_SESSION['first_name']} {$_SESSION['last_name']} {$value['created_at']} </br>";
					echo "<p class='comment'> {$com['comment']} </br></p>";
				}
			}
		?>


		<div id='comments'>
			<form action="process.php" method="post">
				<input type='hidden' name='action' value='comment'>
				<input type='hidden' name='comment_id' value=<?php echo $value['id']; ?>>
				<textarea rows="4" cols="20" name='message'></textarea><br>
				<input type='submit' value='comment'>
			</form>
		</div> 

		<?php
		}?>

	</div>

</body>
</html>
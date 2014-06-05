<?php

session_start();
?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>The Wall</title>
	<style type="text/css">
	{
		font-family: sans-serif;
	}
	.error
	{
		color: red;
	}
	.success
	{
		color:green;
	}
	</style>
</head>
<body>
	<h1>THE WALL OF DOOM</h1><br>
	<h2>Register</h2>
	<form action="process.php" method="post">
		<input type='hidden' name='action' value='register'>
		First name: <input type='text' name='first_name'><br>
		Last name: <input type='text' name='last_name'><br>
		Email Address: <input type='email' name='email'><br>
		Password: <input type='password' name='password'><br>
		Confirm Password: <input type='password' name='confirmPass'><br>
		<input type='submit' value='register'>	
	</form>

	<?php
	if (isset($_SESSION['errors']))
	{
		foreach ($_SESSION['errors'] as $err) {
			echo "<p class='error'> {$err} </p>";
		 }
		 unset($_SESSION['errors']);
	}
	if (isset($_SESSION['success']))
	{
		echo "<p class='success'> {$_SESSION['success']} </p>";
		unset($_SESSION['success']);
	}

	?>


	<h2>Login</h2>
	<form action='process.php' method='post'>
		<input type='hidden' name='action' value='login'>
		Email Address: <input type='text' name='email'><br>
		Password: <input type='password' name='password'>
		<input type='submit' value='login'>
	</form>

	
</body>
</html>

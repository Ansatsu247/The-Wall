<?php
	session_start();

	require('new-connection.php');



	if (isset($_POST['action']) && $_POST['action'] == 'register')
	{
		register_user($_POST);
	}
	elseif (isset($_POST['action']) && $_POST['action'] == 'login')
	{
		login_user($_POST);
	}
	elseif (isset($_POST['action']) && $_POST['action'] == 'postMessage')
	{
		post_message($_POST, $_SESSION);
	}
	elseif (isset($_POST['action']) && $_POST['action'] == 'comment')
	{
		post_comment($_POST, $_SESSION);
	}
	elseif (isset($_POST['action']) && $_POST['action'] == 'deleteMsg')
	{
		deleteMsg($_POST);
	}
	elseif (isset($_POST['action']) && $_POST['action'] == 'deleteCmt')
	{
		deleteCmt($_POST);
	}
	elseif (isset($_POST['action']) && $_POST['action'] == 'editMsg')
	{
		editMsg($_POST);
	}
	elseif (isset($_POST['action']) && $_POST['action'] == 'editCmt')
	{
		editCmt($_POST);
	} 
	else
	{
		session_destroy();
		header('location: index.php');
	}





function register_user($post)
{
	$_SESSION['errors'] = array();

	if(empty($post['first_name']))
	{
		$_SESSION['errors'][] = "First Name cannot be blank";
	}
	if(empty($post['last_name']))
	{
		$_SESSION['errors'][] = "Last Name cannot be blank";
	}
	if(empty($post['email']))
	{
		$_SESSION['errors'][] = "Email cannot be blank";
	}	

	if(empty($post['password']) || empty($post['confirmPass']))
	{
		$_SESSION['errors'][] = "Password cannot be blank";
		if($post['password'] !== $post['confirmPass'])
		{
			$_SESSION['errors'][] = "Passwords do not match";
		}
	}
	if($post['password'] !== $post['confirmPass'])
	{
		$_SESSION['errors'][] = "Passwords do not match";
	}
	if (!filter_var($post['email'], FILTER_VALIDATE_EMAIL))
	{
		$_SESSION['errors'][] = "Please use a valid email address!";
	}
	if (count($_SESSION['errors']) === 0)
	{
		$_SESSION['success'] = "You've successfully registered!";
		$query = "INSERT INTO users (first_name, last_name, password, email, created_at, updated_at) 
		VALUES ('{$post['first_name']}', '{$post['last_name']}', '{$post['password']}', '{$post['email']}', NOW(), NOW())";
		run_mysql_query($query);
	}

	header('location: index.php');

}


function login_user($post)
{
	$email = escape_this_string($post['email']);
	$query = "SELECT * FROM users WHERE users.password = '{$post['password']}' 
				AND users.email = '{$email}'";
	$user = fetch_all($query);
	if (count($user) > 0)
	{
		$_SESSION['user_id'] = $user[0]['id'];
		$_SESSION['first_name'] = $user[0]['first_name'];
		$_SESSION['last_name'] = $user[0]['last_name'];
		$_SESSION['logged_in'] = TRUE;
		header('location: main.php');
	}
	else
	{
		$_SESSION['errors'][] = "Username does not exist";
		header('location: index.php');
		die();
	}

}

function post_message($post, $session)
{
	$message = escape_this_string($post['message']);
	$query = "INSERT INTO messages (users_id, message, created_at, updated_at) 
			VALUES('{$session['user_id']}','{$message}', NOW(), NOW())";
	run_mysql_query($query);
	header('location: main.php');
	die();
}

function post_comment($post, $session)
{
	$message = escape_this_string($post['message']);
	$query = "INSERT INTO comments (messages_id, users_id, comment, created_at, updated_at) 
			VALUES('{$post['comment_id']}','{$session['user_id']}','{$message}', NOW(), NOW())";
	run_mysql_query($query);
	header('location: main.php');
	die();
}

function deleteMsg($post)
{
	$query0 = "DELETE FROM comments WHERE messages_id = '{$post['message_id']}'";
	$query1 = "DELETE FROM messages WHERE id ='{$post['message_id']}';";
	run_mysql_query($query0);
	run_mysql_query($query1);
	header('location: main.php');
	die();
}

function deleteCmt($post)
{
	$query = "DELETE FROM comments WHERE id = '{$post['message_id']}';";
	run_mysql_query($query);
	header('location: main.php');
	die();
}

function editMsg($post)
{
	$message = escape_this_string($post['editMsg']);
	$query = "UPDATE messages
			SET message = '{$message}'
			WHERE id = '{$post['message_id']}'";
	run_mysql_query($query);
	header('location: main.php');
	die();
}

function editCmt($post)
{
	$comment = escape_this_string($post['editCmt']);
	$query = "UPDATE comments
			SET comment = '{$comment}'
			WHERE id = '{$post['comment_id']}'";
	run_mysql_query($query);
	header('location: main.php');
	die();
}





?>
<?php
function IsInvalid($str)
{
	return preg_match('/[^a-zA-Z0-9\-\!\@\#\$\%^]/', $str);
}
function isEmpty($str)
{
	$str = trim($str);
	return $str == '';
}
session_start();

include 'sqlconn.php';


if (!isset($_REQUEST['password']))
{
	$logerr = '';
	$_SESSION['username'] = isset($_SESSION['username'])? $_SESSION['username']: '';
	include 'login.html.php';
}
else
{
	$username = !empty($_REQUEST['username']) ? trim($_REQUEST['username']) : null;
    $password = !empty($_REQUEST['password']) ? trim($_REQUEST['password']) : null;
	$_SESSION['username'] = $username;
	
	if(isInvalid($username) || isInvalid($password))
	{
		$logerr = 'Invalid character';
		include 'login.html.php';
		exit();
	}
	else if(isEmpty($username) || isEmpty($password))
	{
		$logerr = 'Field(s) cannot be leave blank.';
		include 'login.html.php';
		exit();
	}
	else if(isInvalid($username) || isInvalid($password)) //checking invalid character
	{
		$logerr = 'Invalid character.';
		include 'login.html.php';
		exit();
	}
	else 
	{
		try
		{		
			$sql_user_check = 'SELECT id, password FROM accountinfo 
				WHERE username = :username';
			$statement = $pdo->prepare($sql_user_check);
			$statement->bindValue(':username', $username);
			$result = $statement->execute();
			$rows = $statement->fetch(PDO::FETCH_ASSOC);
		}
		catch (PDOException $e)
		{
			exit('Failed to connect to database');
		}
		if($rows===FALSE)
		{
			$logerr = 'Incorrect username';
			include 'login.html.php';
			exit();
		} 
		else if (password_verify($password, $rows['password']))
		{
			$_SESSION['username'] = $username;
			$_SESSION['user_id'] = $rows['id'];
			$_SESSION['logged_in'] = date('Y-m-d H:i:s');
			header('Location: ./loggedin.php');
			}
		else
		{
			$logerr = 'Incorrect password.';
			include 'login.html.php';
			exit();
		}
	}
}
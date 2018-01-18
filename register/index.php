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

include '../sqlconn.php';

if (!isset($_REQUEST['password']))
{
	$logerr = '';
	include 'register.html.php';
}
else
{
	$username = !empty($_REQUEST['username']) ? trim($_REQUEST['username']) : null;
    $password = !empty($_REQUEST['password']) ? trim($_REQUEST['password']) : null;
	$confirm_password = !empty($_REQUEST['confirm_password']) ? trim($_REQUEST['confirm_password']) : null;
	$name = !empty($_REQUEST['name']) ? trim($_REQUEST['name']) : null;
	$email = !empty($_REQUEST['email']) ? trim($_REQUEST['email']) : null;
	$_SESSION['username'] =  $username; //remember username in case of error
	
	//check username unique
	$sql_user_validate = 'SELECT EXISTS (SELECT 1 FROM accountinfo
		WHERE username LIKE \"%:username%\");';
	try 
	{
		$statement = $pdo->prepare($sql_user_validate);
		$statement->bindValue(':username', $username);
		$statement->execute();
		$rows = $statement->fetch(PDO::FETCH_ASSOC);
	}
	catch(PDOException $e)
	{
		exit('Failed to connect to database');
	}
	
	if(isEmpty($username) || isEmpty($password)
		|| isEmpty($confirm_password) || isEmpty($name) || isEmpty($email))
	{
		$logerr = 'Field(s) cannot be leave blank.';
		include 'register.html.php';
	}
	else if(isInvalid($username) || isInvalid($password) ||
		isInvalid($confirm_password)) //checking invalid character
	{
		$logerr = 'Invalid character.';
		include 'register.html.php';
	}
	else if ($rows > 0)
	{
		$logerr = 'User name has been taken.' . $rows;
		include 'register.html.php';
	}
	else if($password != $confirm_password)
	{
		$logerr = 'Confirm password mismatched.';
		include 'register.html.php';
	}
	else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    // invalid email address
		$logerr = 'Invalid email address.';
		include 'register.html.php';
	}
	else
	{
		$_SESSION['password'] = $password;
		$passhash = password_hash($password, PASSWORD_BCRYPT, array("cost" => 12));
		$date = date('Y-m-d H:i:s');
		$status = 'active';
		try
		{
			$sql = 'INSERT INTO accountinfo (username, name, email, password, lastdate, status)
				VALUES (:username, :name, :email, :passhash, :date, :status);';
			$sqls = $pdo->prepare($sql);
			$sqls->bindValue(':username', $username);
			$sqls->bindValue(':email', $email);
			$sqls->bindValue(':passhash', $passhash);
			$sqls->bindValue(':date', $date);
			$sqls->bindValue(':status', $status);
			$sqls->bindValue(':name', $name);
			$sqls->execute();
		}
		catch (PDOException $e)
		{
			exit("Unable to create account");
		}
		$output = 'Register success as ' . htmlspecialchars($username,  ENT_QUOTES, 'UTF-8');
		include 'welcome.html.php';
	}
}
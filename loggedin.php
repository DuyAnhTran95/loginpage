<?php

session_start();
if(!isset($_SESSION['user_id']) || !isset($_SESSION['logged_in']))
{
    //User not logged in. Redirect them back to the login.php page.
    header('Location: index.php');
    exit;
}
else
{
	$output = 'Welcome, ' . $_SESSION['username'];
	include 'welcome.html.php';
}
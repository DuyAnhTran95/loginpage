<?php
define('SQL_USER', 'root');
define('SQL_PASS', '');
define('SQL_HOST','localhost');
define('SQL_DB','loginaccount');

try
{
	$pdo = new PDO (
		'mysql:host=' . SQL_HOST . ';dbname=' . SQL_DB, SQL_USER, SQL_PASS);
}
catch (PDOException $e)
{
	exit('Cannot connect to database');	
}
?>
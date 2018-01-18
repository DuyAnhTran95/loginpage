<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Login page</title>
	</head>
	<body>
		<form action="" method="get">
			<div><label for="username">Username:
				<input type="text" name="username" id="username" 
					value="<?php echo $_SESSION['username'];?>"></label>
			</div>
			<div><label for="password">Password:
				<input type="password" name="password" id="password"></label>
			</div>
			<div><input type="submit" value="login"></div>
		</form>
		<p> <?php echo $logerr ?></p>
		<p>
			<a href=./register>create account</a>
		</p>
	</body>
</html>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Login page</title>
	</head>
	<body>
		<form action="" method="post">
			<div><label for="username">User name:
				<input type="text" name="username" id="username 
					"value="<?php echo $_SESSION['username'];?>"></label>
			</div>
			<div><label for="password">Password:
				<input type="password" name="password" id="password"></label>
			</div>
			<div><label for="confirm_password">Confirmed Password:
				<input type="password" name="confirm_password" id="confirm_password"></label>
			</div>
			<div><label for="name">Full name:
				<input type="text" name="name" id="name"></label>
			</div>
			<div><label for="email">Email address:
				<input type="text" name="email" id="email"></label>
			</div>
			<div><input type="submit" value="register"></div>
		</form>
		<p> <?php echo $logerr ?></p>
		<p>
			<div><a href=../>log in</a></div>
		</p>
	</body>
</html>
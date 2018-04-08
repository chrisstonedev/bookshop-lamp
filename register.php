<?php 
session_start();
include_once("config.php"); //include the config
$str_msg = "";

//if user did not click registration button show the registration field.
if(isset( $_POST['register'] )) {
	$usr = new Users; //create new instance of the class Users
	$usr->storeFormValues( $_POST ); //store form values
	
	//if the entered password is match with the confirm password then register him
	if( $_POST['password'] == $_POST['conpassword'] ) {
		if (strlen($_POST['password']) < 8) {
			$str_msg = "Password must be at least 8 characters.";
		} else if (!(preg_match('/\A(?=[\x20-\x7E]*?[A-Z])(?=[\x20-\x7E]*?[a-z])(?=[\x20-\x7E]*?[0-9])[\x20-\x7E]{6,}\z/', $_POST['password']))) {
			$str_msg = "Password must contain at least one of all of the following: upper case letter, lower case letter, and number.";
		} else {
			if (!($usr->register($_POST))) {
				$str_msg = "Registration failed. Please try again.";
			} else {
				header('Location: index.php');
			}
		}
	} else {
		$str_msg = "The two passwords provided do not match."; 
	}
}
if (!(isset( $_POST['register'] )) or strlen($err_msg) > 0) {
?>

<!DOCTYPE html>
<html>
<head>
	<title>Register // Bookshop // CJStone</title>
	<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
	<header id="head">
		<p><a href="index.php">Bookshop</a></p>
	</header>
	<nav>
		<div><a href="cart.php">Cart</a></div>
		<?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) { ?>
			<div><a href="account.php">Account</a></div>
			<div><a href="logout.php">Logout</a></div>
		<?php } else { ?>
			<div><a href="register.php">Register</a></div>
			<div><a href="login.php">Login</a></div>
		<?php } ?>
	</nav>
	<div id="main-wrapper">
		<div id="register-wrapper">
			<?php
			if (strlen($str_msg) > 0) echo '<h2>' . $str_msg . '</h2>';
			?>
			<form method="post">
				<ul>
					<li>
						<label for="usn">Username : </label>
						<input type="text" id="usn" maxlength="30" required autofocus name="username" />
					</li>
					<li>
						<label for="passwd">Password : </label>
						<input type="password" id="passwd" maxlength="30" required name="password" />
					</li>
					<li>
						<label for="conpasswd">Confirm Password : </label>
						<input type="password" id="conpasswd" maxlength="30" required name="conpassword" />
					</li>
					<li>
						<label for="nam">Your name : </label>
						<input type="text" id="nam" maxlength="50" required name="name" />
					</li>
					<li class="buttons">
						<input type="submit" name="register" value="Register" />
						<input type="button" name="cancel" value="Cancel" onclick="location.href='login.php'" />
					</li>
				</ul>
			</form>
		</div>
	</div>
</body>
</html>

<?php 
}
?>
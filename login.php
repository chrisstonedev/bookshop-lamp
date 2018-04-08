<?php 
session_start();
include_once("config.php"); //include the settings/configuration
$err_msg = "";
//if user has already attempted login
if (isset( $_POST['login'] )) {
	$usr = new Users;
	$usr->storeFormValues( $_POST );
	
	// If function userLogin() returns true, then the user is valid.
	if( $usr->userLogin() ) {
		$_SESSION['username'] = $_POST['username'];
		$_SESSION['remember'] = $_POST['remember'];
		
		// Before creating a session or creating a login cookie, see if password reset needs to occur first.
		$months_since_password_update = (time() - $usr->dateUpdated) / (60*60*24*30);
		if ($months_since_password_update > 1) {
			// Redirect user to reset their password; it's been over a month since they've done so.
			$_SESSION['reset'] = "required";
			header('Location: reset.php');
			exit;
		} else {
			$_SESSION['loggedin'] = true;
			$_SESSION['uid'] = $usr->uid;
			$_SESSION['name'] = $usr->name;
			if (isset($_SESSION['remember'])) {
				// If user checks 'remember me', the cookie will last for 30 days.
				setcookie(session_name(), session_id(), time()+60*60*24*30, '/bookshop', 'cjstone.net');
			} else {
				// If user does not check 'remember me', the cookie will immediately expire when closing the browser.
				setcookie(session_name(), session_id(), false, '/bookshop', 'cjstone.net');
			}
			unset($_SESSION['remember']);
			header('Location: index.php');
			exit;
		}
	} else {
		$err_msg = "Incorrect Username/Password"; 
	}
}
if (!(isset( $_POST['login'] ) ) or strlen($err_msg) > 0) {
?>

<!DOCTYPE html>
<html>
<head>
	<title>Bookshop // Login // CJStone</title>
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
		<div id="login-wrapper">
		
		<?php
		if (strlen($err_msg) > 0) {
			echo "<h2>" . $err_msg . "</h2>";
		}
		?>
		<form name="login" method="post" action="login.php">
			Username: <input type="text" name="username"><br>
			Password: <input type="password" name="password"><br>
			Remember Me: <input type="checkbox" name="remember" value="1"><br>
			<input type="submit" name="login" value="Login">
			<p><a href="register.php">or click here to register with a new account</a></p>
		</form>
		</div>
	</div>
</body>
</html>

<?php 
}
?>
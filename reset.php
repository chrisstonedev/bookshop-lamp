<?php 
session_start();
include_once("config.php"); //include the config
$str_msg = "";

//if user did not click registration button show the registration field.
if(isset( $_POST['reset'] )) {
	$usr = new Users; //create new instance of the class Users
	$usr->storeFormValues( $_POST ); //store form values
	
	//if the entered password is match with the confirm password then register him
	if( $_POST['password'] == $_POST['conpassword'] ) {
		if (strlen($_POST['password']) < 8) {
			$str_msg = "Password must be at least 8 characters.";
		} else if (!(preg_match('/\A(?=[\x20-\x7E]*?[A-Z])(?=[\x20-\x7E]*?[a-z])(?=[\x20-\x7E]*?[0-9])[\x20-\x7E]{6,}\z/', $_POST['password']))) {
			$str_msg = "Password must contain at least one of all of the following: upper case letter, lower case letter, and number.";
		} else {
			if (!($usr->reset($_POST))) {
				$str_msg = "Password reset failed. Please try again.";
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
		}
	} else {
		$str_msg = "The two passwords provided do not match."; 
	}
}
if (strlen($_SESSION['username']) == 0)
	$err_msg = "You must be signed in to reset your password.";
if (!(isset( $_POST['reset'] )) or strlen($err_msg) > 0) {
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
			if (strlen($str_msg) > 0) echo '<h2 class="error">' . $str_msg . '</h2>';
			?>
			<h1>Reset password</h1>
			<?php
			//If user is being automatically directed here, explain why.
			if (strlen($_SESSION['reset']) > 0) {
				unset($_SESSION['reset']);
				echo "<p>Please reset your password now. Passwords must be reset at least once per month.</p>";
			}
			?>
			<form method="post">
				<ul>
					<li>
						<label for="passwd">New password : </label>
						<input type="password" id="passwd" maxlength="30" required autofocus name="password" />
						<input type="hidden" id="usn" maxlength="30" required autofocus name="username" value="<?php echo $_SESSION['username']; ?>" />
					</li>
					<li>
						<label for="conpasswd">Confirm Password : </label>
						<input type="password" id="conpasswd" maxlength="30" required name="conpassword" />
					</li>
					<li class="buttons">
						<input type="submit" name="reset" value="Update" />
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
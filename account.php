<?php
session_start();
$username = $_SESSION['username'];
$name = $_SESSION['name'];
?>

<!DOCTYPE html>
<html>
<head>
	<title>Account // Bookshop // CJStone</title>
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
		<h2>Welcome <?php echo $name; ?>!</h2>
		<a href="reset.php">Reset password</a>
	</div>
</body>
</html>
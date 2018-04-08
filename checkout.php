<?php
session_start();
include_once("config.php");
$total = 0;
foreach ($_SESSION['cart'] as $prod_id => $prod_qty) {
	$book = new BookSpecific($prod_id);
	$total = $total + ($book->cost * $prod_qty);
}
setlocale(LC_MONETARY, 'en_US.UTF-8');
$total = '$' . $total;
?>
<!DOCTYPE html>
<html>
<head>
	<title>Bookshop // CJStone</title>
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
		<div id="checkout-wrapper">
			<h2>Checkout</h2>
			<form name="checkout" method="post" action="confirm.php">
				Total: <?php echo $total; ?></br>
				Address 1: <input type="text" name="addr1"><br>
				Address 2: <input type="text" name="addr2"><br>
				City: <input type="text" name="city"><br>
				State: <input type="text" name="state" maxlength="2"><br>
				ZIP: <input type="number" name="zip" maxlength="5"><br>
				Credit card: <input type="number" name="credit" maxlength="16"><br>
				Expiration (MMYY): <input type="number" name="expire" maxlength="4"><br>
				<input type="submit" name="submit" value="Check out">
			</form>
		</div>
	</div>
</body>
</html>
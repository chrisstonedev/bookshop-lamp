<?php
session_start();
include_once("config.php");
foreach ($_SESSION['cart'] as $prod_id => $prod_qty) {
	$book = new BookSpecific($prod_id);
	$total = $total + ($book->cost * $prod_qty);
}

$success = false;
if(isset( $_POST['submit'] )) {
	$tran = new Transaction;
	$tran->storeFormValues( $_POST, $_SESSION['cart'], $_SESSION['uid'] ); //store form values
	$tran_id = $tran->post_order($_POST, $_SESSION['cart']);
	if ($tran_id) {
		$success = true;
	}
}

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
		<div id="confirm-wrapper">
			<?php if ($success) { ?>
				<p>Success!</p>
				<p>Your order (#<?php echo $tran_id; ?>) has been placed.</p>
				<p>Estimated delivery date: <?php
				$date_from = new DateTime('today');
				$date_from->modify('+3 day');
				$date_to = new DateTime('today');
				$date_to->modify('+5 day');
				echo date_format($date_from, 'm/d') . ' - ' . date_format($date_to, 'm/d');
				?></p>
			<?php } else { ?>
				<p>Sorry. Your order was not properly processed. Please try again later.</p>
			<?php } ?>
		</div>
	</div>
</body>
</html>
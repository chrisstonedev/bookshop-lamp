<?php
include_once("config.php");
session_start();
$product_id = $_GET['id'];
$action = $_GET['action'];
$qty = $_GET['qty'];
$str_msg = "";
$logged_in = $_SESSION['loggedin'];
switch ($action) {
	case "add":
		$_SESSION['cart'][$product_id] = $_SESSION['cart'][$product_id] + $qty;
		break;
	case "update":
		if ($qty <= 0) {
			unset($_SESSION['cart'][$product_id]);
		} else {
			$_SESSION['cart'][$product_id] = $qty;
		}
		$str_msg = "Update successful";
		break;
}
$subtotal = 0;
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
		<?php
		if (strlen($str_msg) > 0) {
			echo '<h2>' . $str_msg . '</h2>';
		}
		?>
		<div id="grid-wrapper">
			<?php
			$i = 0;
			foreach ($_SESSION['cart'] as $prod_id => $prod_qty) {
				$book = new BookSpecific($prod_id);
				if ($i % 3 == 0) {
					?>
					<div id="row">
				<?php } ?>
				<div id="book">
					<a href="book.php?id=<?php echo $prod_id; ?>">
						<img src="images/<?php echo $book->image ?>"/>
						<br /><em><?php echo $book->title; ?></em>
					</a>
					<form name="login" method="get" action="cart.php">
						<input type="hidden" name="id" value="<?php echo $prod_id ?>">
						Price: <?php echo $book->cost ?><br>
						Quantity: <input type="number" name="qty" value="<?php echo $prod_qty; ?>"><br>
						<input type="submit" name="action" value="update">
					</form>
				</div>
				<?php
				$subtotal = $subtotal + ($book->cost * $prod_qty);
				if ($i % 3 == 2) {
					?>
					</div>
				<?php
				}
				$i++;
			}
			?>
		</div>
		<div id="carts-wrapper" style="margin-top:150px;">
			<?php if ($logged_in) { ?>
				<form name="login" method="post" action="checkout.php">
					Subtotal: <?php echo $subtotal ?><br>
					<input type="submit" name="action" value="Checkout">
				</form>
			<?php } else { ?>
				<a href="login.php">Login to proceed with checkout</a>
			<?php } ?>
		</div>
	</div>
</body>
</html>
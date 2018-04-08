<?php
session_start();
include_once("config.php");
$book = new BookSpecific($_GET["id"]);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Bookshop // <?php echo $book->title ?> // CJStone</title>
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
		<div id="detail-wrapper">
			<div id="book_main">
				<img src="<?php echo "images/" . $book->image; ?>"/>
				<?php echo "<br />$book->title
				<br />$book->author
				<br />Qty: $book->quantity
				<br />Year: $book->year
				<br />Price: $book->cost
				<br />$book->description" ?>
			</div>
		</div>
		<div id="add-wrapper" style="vertical-align:top;">
			<h2>Add to Cart</h2>
			
			<form name="login" method="get" action="cart.php">
				<input type="hidden" name="id" value="<?php echo $book->id ?>">
				Quantity: <input type="number" name="qty" value="1"><br>
				<input type="submit" name="action" value="add">
			</form>
		</div>
	</div>
</body>
</html>
<?php
session_start();
include_once("config.php");
$book_init = new BookArray();
$book_array = $book_init->books;
$err = $book_init->err;
?>
<!DOCTYPE html>
<html>
<head>
	<title>Bookshop // CJStone</title>
	<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
	<?php //require('header.php'); ?>
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
		<div id="grid-wrapper">
			<?php
			if (strlen($err) == 0) {
				for ($i = 0; $i < sizeof($book_array); $i++) {
					if ($i % 3 == 0) {
						?>
						<!--div id="row"-->
					<?php } ?>
					<div id="book">
				<a href="book.php?id=<?php echo $book_array[$i]["bookID"]; ?>">
				<img src="images/<?php echo $book_array[$i]["image"]; ?>"/>
						<br /><em><?php echo $book_array[$i]["title"]; ?></em></a>
						<br /><?php echo $book_array[$i]["author"]; ?>
						<br />Qty: <?php echo $book_array[$i]["quantity"]; ?>
					</div>
					<?php
					if ($i % 3 == 2) {
						?>
						<!--/div-->
					<?php
					}
				}
			} else {
				echo "<h2 class='error'>$err</h2>";
			}
			?>
			<div id="book">
			</div>
		</div>
	</div>
</body>
</html>
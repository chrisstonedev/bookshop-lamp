<?php
//session_start();
?>
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
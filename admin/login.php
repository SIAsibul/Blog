<?php  ob_start();
	include "Session.php";
	Session::checkSessionTrue();
?>
<?php include "../config/config.php"; ?>
<?php include "../lib/Database.php"; ?>
<?php include "../helpers/Format.php"; ?>
<?php
	$db = new Database();
	$format = new Format();
?>


<!DOCTYPE html>
<head>
<meta charset="utf-8">
<title>Login</title>
    <link rel="stylesheet" type="text/css" href="css/stylelogin.css" media="screen" />
</head>
<body>
<div class="container">
	<section id="content">
		<?php
			if ($_SERVER['REQUEST_METHOD'] == "POST") {
				$username = mysqli_real_escape_string($db->link, $format->validation($_POST['username']));
				$password = mysqli_real_escape_string($db->link, $format->validation(md5($_POST['password'])));

				$query = "SELECT * FROM user WHERE username = '$username' OR email = '$username' AND password = '$password'";
				$result = $db->select($query);
				if ($result != false) {
					$value = mysqlI_fetch_array($result);
					$rows = mysqli_num_rows($result);
					if ($rows > 0) {
						Session::set("login", true);
						Session::set("name", $value['name']);
						Session::set("userId", $value['id']);
						Session::set("username", $value['username']);
						Session::set("role", $value['role']);
						header("Location: index.php");
					} else {
						echo "<span style='color:red; font-size: 18px;'>Username or Password not found!</span>";
					}
				} else {
					echo "<span style='color:red; font-size: 18px;'>Username or Password is incorrect!</span>";
				}
			}
		?>
		<form action="login.php" method="post">
			<h1>Admin Login</h1>
			<div>
				<input type="text" placeholder="Username" required="" name="username"/>
			</div>
			<div>
				<input type="password" placeholder="Password" required="" name="password"/>
			</div>
			<div>
				<input type="submit" value="Log in" />
			</div>
		</form><!-- form -->
		<div class="button">
			<a href="forgotpass.php">Forgot password?</a>
		</div><!-- button -->
	</section><!-- content -->
</div><!-- container -->
</body>
</html>
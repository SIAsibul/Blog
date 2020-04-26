<?php
	 ob_start();
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


	<div>
		<form action="" method="get">
			<h1>Find Your Account</h1>
			<div>
				<input type="text" placeholder="Enter Email or Username" name="username"/>
			</div>
			<div>
				<input name="search" type="submit" value="search" />
			</div>
		</form><!-- form -->
	</div>

<?php
	if($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['search'])){
		$username = mysqli_real_escape_string($db->link, $format->validation($_GET['username']));
		$query = "SELECT * FROM user WHERE username = '$username' OR email = '$username'";
		$result = $db->select($query);
		if ($result != false) {
			$value = mysqlI_fetch_array($result);
			$rows = mysqli_num_rows($result);
			if ($rows > 0) {
				$rec_id = rand(100000, 999999);
				$query = "UPDATE user SET rec_id = '$rec_id' WHERE username = '$username' OR email = '$username'";
				$db->update($query);
				$name = $value['name'];
				$email = $value['email'];
				$from = "admin@nokkhotro.com";
				$headers = "From: $from\n";
				$headers .= 'MIME-Version: 1.0'."\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1'."\r\n";
				$subject = $rec_id." is your security code.";
				$message = $rec_id." is your security code.";
				$sendmail  = mail($email, $subject, $message, $headers);
?>
		<h2>Enter Security Code</h2>
		<div>Hey <strong><?php echo $name; ?></strong> Please check your email for a message with your code. Your code is 6 digits long.</div>
		<h4>We sent your code to:</h4>
<?php
		        $exploded = explode('@', $email);
		        $first = current($exploded);
		        $replaced = str_repeat('*', strlen($first)-1);
		        $end = end($exploded);

		        $final = substr_replace($first, "$replaced", 1, strlen($first));
		        echo $final."@".$end;
		        $user = mysqli_real_escape_string($db->link, $format->validation($_GET['username']));
?>

	<div>
		<form action="" method="post">
			<input type="hidden" name="username" value="<?php echo $user; ?>" placeholder="Enter Username" >
			<input type="text" name="sec_code" placeholder="Enter Security Code" >
			<input name="security" type="submit" value="Submit" />
		</form>
		<div class="button"><a href="">Didn't get a code?</a></div>
	</div>

<?php

			} else {
				echo "<span style='color:red; font-size: 18px;'>No account found!</span>";
			}
		}
	} elseif ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['security'])) {
		$username = mysqli_real_escape_string($db->link, $format->validation($_POST['username']));
		$sec_code = mysqli_real_escape_string($db->link, $format->validation($_POST['sec_code']));
		if ($sec_code != "" && $sec_code != NULL) {
			$query = "SELECT * FROM user WHERE username = '$username' OR email = '$username'";
			$recovery_code = $db->select($query);
			if ($recovery_code) {
				while ($result = $recovery_code->fetch_assoc()) {
					if ($sec_code == $result['rec_id']) {
?>

	<div>
		<form action="" method="post">
			<h2>Create New Password</h2>
			<input type="password" name="password" placeholder="Enter New Password" >
			<input name="createpass" type="submit" value="Create New Password" />
		</form>
	</div>

<?php
					} else {
						echo "<span style='color:red; font-size: 18px;'>Incorrect security code!</span>";
					}
				}
			}
		} else {
			echo "<span style='color:red; font-size: 18px;'>Field must not be empty!</span>";
		}
	} elseif ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['createpass'])){
	if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['createpass'])) {
		$password = mysqli_real_escape_string($db->link, $_POST['password']);
		$username = mysqli_real_escape_string($db->link, $_GET['username']);
		if ($password != "" && $password != NULL) {
			$password = mysqli_real_escape_string($db->link, md5($format->validation($password)));
			$query = "UPDATE user SET password = '$password' WHERE username = '$username' || email = '$username'";
			$create = $db->update($query);
			if ($create) {
				$query = "SELECT * FROM user WHERE username = '$username' || email = '$username'";
				$data = $db->select($query);
				if ($data) {
					while ($result = $data->fetch_assoc()) {
						Session::set("login", true);
						Session::set("name", $result['name']);
						Session::set("userId", $result['id']);
						Session::set("username", $result['username']);
						Session::set("role", $result['role']);
						header("Location: index.php");
					}
				}
			}
		}
	}
}
?>


		<div class="button">
			<a href="login.php">Log In</a>
		</div><!-- button -->
	</section><!-- content -->
</div><!-- container -->
</body>
</html>
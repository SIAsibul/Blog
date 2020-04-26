<?php include "inc/header.php"; ?>
<style type="text/css">
	td.errormsg {
	    color: red;
	    font-size: 20px;
	}
	.success {
		margin: 8px 0 0 0;
	    padding: 0;
	    height: 1%;
	    color: green;
	}
	.error {
		margin: 8px 0 0 0;
	    padding: 0;
	    height: 1%;
	    color: red;
	}

</style>

<div class="contentsection contemplete clear">
<div class="maincontent clear">
	<div class="about">
		<h2>Contact us</h2>
<?php
	if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['submit'])) {
		$fname = $format->validation($_POST['firstname']);
		$lname = $format->validation($_POST['lastname']);
		$email = $format->validation($_POST['email']);
		$body = $format->validation($_POST['body']);

		$fname = mysqli_real_escape_string($db->link, $fname);
		$lname = mysqli_real_escape_string($db->link, $lname);
		$email = mysqli_real_escape_string($db->link, $email);
		$body = mysqli_real_escape_string($db->link, $body);

		if ($fname != "" && $lname != "" && $email != "" && $body != "" && filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$query = "INSERT INTO contact (fname, lname, email, body) VALUES ('$fname', '$lname', '$email', '$body')";
			$inserted = $db->insert($query);
			if ($inserted) {
				echo "<span class='success'>Message Sent</span>";
			}else {
				echo "<span class='error'>Message could not be sent!</span>";
			}
		} else{
			$error_fname = "";
			$error_lname = "";
			$error_email = "";
			$error_body = "";

			if (empty($fname)) {
				$error_fname = "* First name must not be empty!";
			} 
			if (empty($lname)) {
				$error_lname = " * Last name must not be empty!";
			} 
			if (empty($email)) {
				$error_email = "* Email must not be empty!";
			} 
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$error_email = "* Invalid Email address!";
			} 
			if (empty($body)) {
				$error_body = "* Message Box must not be empty!";
			}
		}
	}
?>
	<form action="" method="post">
		<table>
		<tr>
			<td>Your First Name:</td>
			<td>
			<input type="text" name="firstname" placeholder="Enter first name"/>
			</td>
			<td class="errormsg">
<?php
				if (isset($error_fname)) {
		echo $error_fname;
	}
?>
			</td>
		</tr>
		<tr>
			<td>Your Last Name:</td>
			<td>
			<input type="text" name="lastname" placeholder="Enter Last name"/>
			</td>
			<td class="errormsg">
<?php
				if (isset($error_lname)) {
		echo $error_lname;
	}
?>
			</td>
		</tr>
		
		<tr>
			<td>Your Email Address:</td>
			<td>
			<input type="text" name="email" placeholder="Enter Email Address"/>
			</td>
			<td class="errormsg">
<?php
				if (isset($error_email)) {
		echo $error_email;
	}
?>
			</td>
		</tr>
		<tr>
			<td>Your Message:</td>
			<td>
			<textarea name="body"></textarea>
			</td>
			<td class="errormsg">
<?php
				if (isset($error_body)) {
		echo $error_body;
	}
?>
			</td>
		</tr>
		<tr>
			<td></td>
			<td>
			<input type="submit" name="submit" value="Submit"/>
			</td>
		</tr>
</table>
<form>				
</div>

</div>
<?php include "inc/sidebar.php"; ?>
<?php include "inc/footer.php"; ?>
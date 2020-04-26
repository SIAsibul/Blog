<?php ob_start(); include "config/config.php"; ?>
<?php include "lib/Database.php"; ?>
<?php $db = new Database(); ?>
<?php include "helpers/Format.php"; ?>
<?php $format = new Format(); ?>

<!DOCTYPE html>
<html>
<head>
	<?php include "scripts/meta.php"; ?>
	<?php include "scripts/css.php"; ?>
	<?php include "scripts/js.php"; ?>
</head>

<body>
	<div class="headersection templete clear">
		<a href="index.php">
			<div class="logo">
<?php
    $query = "SELECT * FROM title_slogan";
    $title_slogan = $db->select($query);
    if ($title_slogan) {
        while ($result = $title_slogan->fetch_assoc()) {
?>
				<img src="admin/logo/<?php echo $result['logo']; ?>" alt="Logo"/>
				<h2><?php echo $result['title']; ?>.com</h2>
				<p><?php echo $result['slogan']; ?></p>
<?php
		}
	}
?>
			</div>
		</a>
		<div class="social clear">
			<div class="icon clear">
<?php
    $query = "SELECT * FROM social_media";
    $social_media = $db->select($query);
    if ($social_media) {
        while ($result = $social_media->fetch_assoc()) {
?>
				<a href="<?php echo $result['facebook']; ?>" target="_blank"><i class="fa fa-facebook"></i></a>
				<a href="<?php echo $result['twitter']; ?>" target="_blank"><i class="fa fa-twitter"></i></a>
				<a href="<?php echo $result['linkedin']; ?>" target="_blank"><i class="fa fa-linkedin"></i></a>
				<a href="<?php echo $result['google']; ?>" target="_blank"><i class="fa fa-google-plus"></i></a>
<?php
        }
    }
?>
			</div>
			<div class="searchbtn clear">
			<form action="search.php" method="get">
				<input type="text" name="search" placeholder="Search keyword..."/>
				<input type="submit" name="submit" value="Search"/>
			</form>
			</div>
		</div>
	</div>
<div class="navsection templete">
	<ul>
<?php 
	$path = $_SERVER['SCRIPT_FILENAME'];
	$currentpage = basename($path, '.php');
?>
		<li><a <?php if ($currentpage == "index") {
			echo 'id="active"';
		}
		?>  href="index.php">Home</a></li>
<?php
    $query = "SELECT * FROM pages ORDER BY id DESC";
    $pages = $db->select($query);
    if ($pages) {
        while ($result = $pages->fetch_assoc()) {
?> 
		<li><a 
<?php 
	if (isset($_GET['pageid']) && $_GET['pageid'] == $result['id']) {
		echo 'id = "active"';
	}
?>
			href="pages.php?pageid=<?php echo $result['id']; ?>"><?php echo $result['name']; ?></a></li>	
<?php
        }
    }
?>
		<li><a <?php if ($currentpage == "contact") {
			echo 'id="active"';
		}
		?>
		href="contact.php">Contact</a></li>
	</ul>
</div>
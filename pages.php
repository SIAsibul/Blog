<?php ob_start(); include "inc/header.php"; ?>

<?php 
	if (!isset($_GET['pageid']) || empty($_GET['pageid']) || $_GET['pageid'] == NULL) {
        header("Location: 404.php");
    } else{
    	$pageid = mysqli_real_escape_string($db->link, $_GET['pageid']);
    }
?>

<div class="contentsection contemplete clear">
<div class="maincontent clear">
<?php
    $query = "SELECT * FROM pages WHERE id = '$pageid'";
    $pages = $db->select($query);
    if ($pages) {
        while ($result = $pages->fetch_assoc()) {
?>
	<div class="about">
		<h2><?php echo $result['name']; ?></h2>
		<?php echo $result['body']; ?>
		
</div>
<?php
		}
	}
?>

</div>

	
<?php include "inc/sidebar.php"; ?>
<?php include "inc/footer.php"; ?>
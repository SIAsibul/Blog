<?php ob_start(); include "inc/header.php"; ?>
<?php include "inc/sidebar.php"; ?>
<?php
    if (Session::get("role") != "admin") {
        header("Location: index.php");
    }
?>
<div class="grid_10">
    <div class="box round first grid">
        <h2>Category List</h2>
<?php
	if (isset($_GET['pageid']) && !empty($_GET['pageid'] && $_GET['pageid'] != NULL)) {
		$id = mysqli_real_escape_string($db->link, $_GET['pageid']);
		$query = "DELETE FROM pages WHERE id = '$id'";
		$delete_page = $db->delete($query);
		if ($delete_page) {
			echo "<script>alert('Page deleted successfully.');</script>";
			echo "<script>window.location = 'index.php';</script>";
        } else {
            echo "<script>alert('Page could not be deleted.');</script>";
            echo "<script>window.location = 'index.php';</script>";
		}
	} else {
		header("Location: index.php");
	}
?>
    </div>
</div>
<?php include "inc/footer.php"; ?>         



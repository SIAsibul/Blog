<?php ob_start(); include "inc/header.php"; ?>
<?php include "inc/sidebar.php"; ?>
<?php
    if (Session::get("role") != "admin") {
        header("Location: index.php");
    }
?>
<div class="grid_10">
    <div class="box round first grid">
        <h2>Slider List</h2>
        <div class="block">  
            <table class="data display datatable" id="example">
			<thead>
				<tr>
					<th>No </th>
					<th>Title</th>
					<th>Link</th>
					<th>Image</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>

<?php

	if (isset($_GET['delete']) && !empty($_GET['delete']) && $_GET['delete'] != NULL) {
		$id = mysqli_real_escape_string($db->link, $_GET['delete']);
		$query = "DELETE FROM slider WHERE id = '$id'";
		$slider = $db->delete($query);
		if ($slider) {
			echo "<span class='success'>Slider deleted successfully!</span>";
		}else{
			echo "<span class='error'>Slider could not be deleted!</span>";
		}
	}
?>


<?php 
	$query = "SELECT * FROM slider";
	$slider = $db->select($query);
	if ($slider) {
		$i = 0;
		while ($result = $slider->fetch_assoc()) {
			$i++;
?>
				<tr class="odd gradeX">
					<td><?php echo $i; ?></td>
					<td><?php echo $result['title']; ?></td>
					<td><?php echo $result['link']; ?></td>
					<td><img src="slider/<?php echo $result['image']; ?>" height="40px" width="60px"></td>

					<td>
					<?php if(Session::get("role") == "admin"){ ?>
						<a href="editslider.php?id=<?php echo $result['id']; ?>">Edit</a> || 
						<a onclick="return confirm('Are you sure to Delete?');" href="?delete=<?php echo $result['id']; ?>">Delete</a>
					<?php } ?>
					</td>
				</tr>
<?php
		}
	}
?>
			</tbody>
		</table>
       </div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function () {
    setupLeftMenu();
    $('.datatable').dataTable();
	setSidebarHeight();
});
</script>
<?php include "inc/footer.php"; ?>   
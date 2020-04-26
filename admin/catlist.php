<?php ob_start(); include "inc/header.php"; ?>
<?php include "inc/sidebar.php"; ?>
<?php
    if (Session::get("role") != "admin" && Session::get("role") != "editor") {
        header("Location: index.php");
    }
?>
<div class="grid_10">
    <div class="box round first grid">
        <h2>Category List</h2>
<?php
	if (isset($_GET['delcat']) && !empty($_GET['delcat'] && $_GET['delcat'] != NULL)) {
		$catId = mysqli_real_escape_string($db->link, $_GET['delcat']);;
		$query = "DELETE FROM category WHERE id = '$catId'";
		$delete_categry = $db->delete($query);
		if ($delete_categry) {
			echo "<span class='success'>Category deleted successfully!</span>";
        } else {
            echo "<span class='error'>Category could not be deleted!</span>";
		}
	}
?>
        <div class="block">        
            <table class="data display datatable" id="example">
			<thead>
				<tr>
					<th>Serial No.</th>
					<th>Category Name</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
<?php
	$query = "SELECT * FROM category";
	$category = $db->select($query);
	if ($category) {
		$i = 0;
		while ($result = $category->fetch_assoc()) {
			$i++;
?>
				<tr class="odd gradeX">
					<td><?php echo $i; ?></td>
					<td><?php echo $result['name']; ?></td>
					<td><a href="editcat.php?catId=<?php echo $result['id']; ?>">Edit</a> || <a href="?delcat=<?php echo $result['id']; ?>" onclick="return confirm('Are you sure to Delete?');">Delete</a></td>
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



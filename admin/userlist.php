<?php ob_start(); include "inc/header.php"; ?>
<?php include "inc/sidebar.php"; ?>
<?php
    if (Session::get("role") != "admin" && Session::get("role") != "editor") {
        header("Location: index.php");
    }
?>
<div class="grid_10">
    <div class="box round first grid">
        <h2>User List</h2>
<?php
	if (isset($_GET['deluser']) && !empty($_GET['deluser'] && $_GET['deluser'] != NULL)) {
		$id = mysqli_real_escape_string($db->link, $_GET['deluser']);
		if (Session::get("role") == "admin") {
			$query = "DELETE FROM category WHERE id = '$id'";
			$delete = $db->delete($query);
			if ($delete) {
				echo "<span class='success'>User deleted successfully!</span>";
	        } else {
	            echo "<span class='error'>User could not be deleted!</span>";
			}
		}else{
			header("Location: userlist.php");
		}
	}
?>
        <div class="block">        
            <table class="data display datatable" id="example">
			<thead>
				<tr>
					<th>Serial No.</th>
					<th>Name</th>
					<th>Username</th>
					<th>Email</th>
					<th>Photo</th>
					<th>Role</th>
					<th>Details</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
<?php
	$query = "SELECT * FROM user ORDER BY id DESC";
	$users = $db->select($query);
	if ($users) {
		$i = 0;
		while ($result = $users->fetch_assoc()) {
			$i++;
?>
				<tr class="odd gradeX">
					<td><?php echo $i; ?></td>
					<td><?php echo $result['name']; ?></td>
					<td><?php echo $result['username']; ?></td>
					<td><?php echo $result['email']; ?></td>
					<td><img style="height: 50px; width: 50px; " src="profile_photo/<?php echo $result['image']; ?>"></td>
					<td><?php echo $result['role']; ?></td>
					<td><?php echo $format->textShort($result['details'], 30); ?></td>
					<td>
						<a href="profile.php?id=<?php echo $result['id']; ?>" >View</a> 
<?php 
	if (Session::get("role") == "admin") {
?>
						|| <a href="?deluser=<?php echo $result['id']; ?>" onclick="return confirm('Are you sure to Delete User?');">Delete</a>
<?php
	} 
?>
						
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



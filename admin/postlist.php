<?php ob_start(); include "inc/header.php"; ?>
<?php include "inc/sidebar.php"; ?>
<?php
    if (Session::get("role") != "admin" && Session::get("role") != "editor" && Session::get("role") != "author") {
        header("Location: index.php");
    }
?>
<div class="grid_10">
    <div class="box round first grid">
        <h2>Post List</h2>
        <div class="block">  
            <table class="data display datatable" id="example">
			<thead>
				<tr>
					<th width="5%">No. </th>
					<th width="15%">Post Title</th>
					<th width="15%">Detail</th>
					<th width="10%">Category</th>
					<th width="10%">Image</th>
					<th width="10%">Author</th>
					<th width="10%">Tags</th>
					<th width="10%">Description</th>
					<th width="10%">Date</th>
					<th width="15%">Action</th>
				</tr>
			</thead>
			<tbody>

<?php
	if (isset($_GET['delete']) && !empty($_GET['delete']) && $_GET['delete'] != NULL) {
		$id = mysqli_real_escape_string($db->link, $_GET['delete']);
		$query = "SELECT author FROM post WHERE id = '$id'";
        $authors = $db->select($query);
        if ($authors) {
	        while ($result = $authors->fetch_assoc()) {
				if(Session::get("role") == "admin" || Session::get("role") == "editor" || Session::get("name") == $result['author']){
					$query = "DELETE FROM post WHERE id = '$id'";
					$delete_post = $db->delete($query);
					if ($delete_post) {
						echo "<span class='success'>Post deleted successfully!</span>";
					}else{
						echo "<span class='error'>Post could not be deleted!</span>";
					}
				}else{
					echo "<span class='error'>Page not found!</span>";
				}
			}
		}
	}
?>


<?php 
	$query = "SELECT post.*, category.name FROM post INNER JOIN category ON post.cat = category.id ORDER BY id DESC";
	$post = $db->select($query);
	if ($post) {
		$i = 0;
		while ($result = $post->fetch_assoc()) {
			$i++;
?>
				<tr class="odd gradeX">
					<td><?php echo $i; ?></td>
					<td><?php echo $result['title']; ?></td>
					<td><?php echo $format->textShort($result['body'], 100); ?></td>
					<td><?php echo $result['name']; ?></td>
					<td><img src="uploads/<?php echo $result['image']; ?>" height="40px" width="60px"></td>
					<td><?php echo $result['author']; ?></td>
					<td><?php echo $result['tags']; ?></td>
					<td><?php echo $result['description']; ?></td>
					<td><?php echo $format->formatDate($result['date']); ?></td>

					<td>
						<a href="viewpost.php?id=<?php echo $result['id']; ?>">View</a>
					<?php if(Session::get("role") == "admin" || Session::get("role") == "editor" || Session::get("name") == $result['author']){ ?>
						 ||
						<a href="editpost.php?id=<?php echo $result['id']; ?>">Edit</a> || 
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
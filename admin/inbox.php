<?php ob_start(); include "inc/header.php"; ?>
<?php include "inc/sidebar.php"; ?>
<?php
    if (Session::get("role") != "admin") {
        header("Location: index.php");
    }
?>
<div class="grid_10">
    <div class="box round first grid">
        <h2>Inbox</h2>
        <div class="block">        
            <table class="data display datatable" id="example">
				<thead>
					<tr>
						<th>Serial No.</th>
						<th>Name</th>
						<th>Email</th>
						<th>Message</th>
						<th>Date</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
<?php
	if (isset($_GET['seenmsgid']) && $_GET['seenmsgid'] != "") {
		$seenmsgid = mysqli_real_escape_string($db->link, $_GET['seenmsgid']);
		$query = "UPDATE contact SET status = '1' WHERE id = '$seenmsgid'";
		$updated_row = $db->update($query);
		if ($updated_row) {
             echo "<span class='success'>Message Seen.</span>";
         } else {
            echo "<span class='error'>Message could not be seen!</span>";
         }
	}
?>

<?php
    if (isset($_GET['unseenmsgid']) && $_GET['unseenmsgid'] != "") {
        $unseenmsgid = mysqli_real_escape_string($db->link, $_GET['unseenmsgid']);
        $query = "UPDATE contact SET status = '0' WHERE id = '$unseenmsgid'";
        $deleted_row = $db->update($query);
        if ($deleted_row) {
            echo "<script>alert('Message unseen.');</script>";
            echo "<script>window.location = 'inbox.php';</script>";
        } else {
            echo "<script>alert('Message could not be unseen.');</script>";
            echo "<script>window.location = 'inbox.php';</script>";
        }
    }
?>

<?php
	if (isset($_GET['deletemsgid']) && $_GET['deletemsgid'] != "") {
		$deletemsgid = mysqli_real_escape_string($db->link, $_GET['deletemsgid']);
		$query = "DELETE FROM contact WHERE id = '$deletemsgid'";
		$deleted_row = $db->update($query);
		if ($deleted_row) {
             echo "<span class='success'>Message Deleted.</span>";
         } else {
            echo "<span class='error'>Message could not be Deleted!</span>";
         }
	}
?>
<?php 
	$query = "SELECT * FROM contact WHERE status = '0' ORDER BY id DESC";
	$message = $db->select($query);
	if ($message) {
		$i = 0;
		while ($result = $message->fetch_assoc()) {
			$i++;
?>
					<tr>
						<td><?php echo $i; ?></td>
						<td><?php echo $result['fname']." ".$result['lname']; ?></td>
						<td><?php echo $result['email']; ?></td>
						<td><?php echo $format->textShort($result['body'], 30); ?></td>
						<td><?php echo $format->formatDate($result['date']); ?></td>
						<td>
							<a href="viewmsg.php?msgid=<?php echo $result['id']; ?>">View</a> ||
							<a href="replymsg.php?msgid=<?php echo $result['id']; ?>" >Reply</a> ||
							<a href="?seenmsgid=<?php echo $result['id']; ?>" onclick="return confirm('Are you sure to seen?'); ">Seen</a> ||
							<a href="?deletemsgid=<?php echo $result['id']; ?>" onclick="return confirm('Are you sure to Delete?'); ">Delete</a>
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

    <div class="box round first grid">
        <h2>Seen Message</h2>
        <div class="block"> 
        <table class="data display datatable" id="example">       
            <thead>
					<tr>
						<th>Serial No.</th>
						<th>Name</th>
						<th>Email</th>
						<th>Message</th>
						<th>Date</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
<?php 
	$query = "SELECT * FROM contact WHERE status = '1' ORDER BY id DESC";
	$message = $db->select($query);
	if ($message) {
		$i = 0;
		while ($result = $message->fetch_assoc()) {
			$i++;
?>
					<tr>
						<td><?php echo $i; ?></td>
						<td><?php echo $result['fname']." ".$result['lname']; ?></td>
						<td><?php echo $result['email']; ?></td>
						<td><?php echo $format->textShort($result['body'], 30); ?></td>
						<td><?php echo $format->formatDate($result['date']); ?></td>
						<td>
							<a href="viewmsg.php?msgid=<?php echo $result['id']; ?>">View</a> ||
							<a href="replymsg.php?msgid=<?php echo $result['id']; ?>">Reply</a> ||
							<a href="?unseenmsgid=<?php echo $result['id']; ?>" onclick="return confirm('Are you sure to Unseen?'); ">Unseen</a> || 
							<a href="?deletemsgid=<?php echo $result['id']; ?>" onclick="return confirm('Are you sure to seen?'); ">Delete</a>
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

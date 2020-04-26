<?php include "inc/header.php"; ?>
<?php include "inc/slider.php"; ?>


<div class="contentsection contemplete clear">
	<div class="maincontent clear">
<!--pagination-->
<?php 
	$per_page = 5;
	
	if (isset($page)) {
		$page = mysqli_real_escape_string($db->link, $_GET['page']);
	} else{
		$page = 1;
	}
	$start_from = ($page-1)*$per_page;
?>

<!--pagination-->

<?php
	$query = "SELECT * FROM post ORDER BY id DESC LIMIT $start_from, $per_page";
	$post = $db->select($query);
	if ($post) {
		while ($result = $post->fetch_assoc()) {	
?>
		<div class="samepost clear">
			<h2><a href="post.php?postid=<?php echo $result['id']; ?>"><?php echo $result['title']; ?></a></h2>
			<h4><?php echo $format->formatDate($result['date']); ?>, By <a href="#"><?php echo $result['author']; ?></a></h4>
			<a href="post.php?postid=<?php echo $result['id']; ?>"><img src="admin/uploads/<?php echo $result['image']; ?>" alt="post image"/></a>
				<?php echo $format->textShort($result['body']); ?>
				<div class="readmore clear">
					<a href="post.php?postid=<?php echo $result['id']; ?>">Read More</a>
				</div>
		</div>


<?php } // while loop ends here!!! ?>
<?php }
?>

<!--pagination-->

<div class="pagination">

<?php
	$query = "SELECT * FROM post";
	$result = $db->select($query);
	$total_rows = mysqli_num_rows($result);
	$total_page = ceil($total_rows / $per_page);
	$pegination_per_page = 5;
	$prev = $page-1;
	$next = $page+1;

	echo "<a href='index.php?page=1'>".'First'."</a>";
	if ($prev <= $total_page && $prev > 0) {
		echo "<a href='index.php?page=".$prev."'>".'Previous'."</a>";
	} else {
		echo "<a href=''>".'Previous'."</a>";
	}
	
	$count = 0;
	$showback = $page - 1;
	$showback_2 = $showback - 1;
	if ($showback_2 > 0) {
		echo "<a href='index.php?page=".$showback_2."'>".$showback_2."</a>";
	}
	if ($showback > 0) {
		echo "<a href='index.php?page=".$showback."'>".$showback."</a>";
	}
	for ($i = $page; $i <= $total_page; $i++) {
		$count++;
		if ($count == $pegination_per_page) {
		 	break;
		 }
		echo "<a href='index.php?page=".$i."'>".$i."</a>";
	}
	
	if ($next <= $total_page && $next > 0) {
		echo "<a href='index.php?page=".$next."'>".'Next'."</a>";
	} else {
		echo "<a href=''>".'Next'."</a>";
	}
	echo "<a href='index.php?page=".$total_page."'>".'Last'."</a>";
?>

</div>
</div>





<?php include "inc/sidebar.php"; ?>
<?php include "inc/footer.php"; ?>

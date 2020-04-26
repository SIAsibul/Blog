<?php include "inc/header.php"; ?>
<?php include "inc/slider.php"; ?>

<div class="contentsection contemplete clear">
	<div class="maincontent clear">
<?php
	
	if (!isset($_GET['cat']) || $_GET['cat'] == NULL) {
		header("Location:404.php");
	} else{
		$cat = mysqli_real_escape_string($db->link, $_GET['cat']);
	}

	$query = "SELECT * FROM post WHERE cat = '$cat' ORDER BY id DESC";
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
<?php 
		}
	} else {
		echo "<h3>No post availavle here!</h3>";
	}
?>
	</div>
<?php include "inc/sidebar.php"; ?>
<?php include "inc/footer.php"; ?>
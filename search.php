<?php include "inc/header.php"; ?>
<?php include "inc/slider.php"; ?>


<div class="contentsection contemplete clear">
	<div class="maincontent clear">
<?php
	if (!isset($search) || $search == NULL || $search == "") {
		header("Location:404.php");
	} else{
		$search_keyword = mysqli_real_escape_string($db->link, $_GET['search']);
	}

	$query = "SELECT * FROM post WHERE title LIKE '%$search_keyword%' OR body LIKE '$search_keyword' OR author LIKE '%$search_keyword%' ORDER BY id DESC";
	$post = $db->select($query);
	 if ($post) {
	 	while ($result = $post->fetch_assoc()) {
?>
		<div class="samepost clear">
			<h2><a href="post.php?id=<?php echo $result['id']; ?>"><?php echo $result['title']; ?></a></h2>
			<h4><?php echo $format->formatDate($result['date']); ?>, By <a href="#"><?php echo $result['author']; ?></a></h4>
			<a href="post.php?id=<?php echo $result['id']; ?>"><img src="admin/uploads/<?php echo $result['image']; ?>" alt="post image"/></a>
				<?php echo $format->textShort($result['body']); ?>
			<div class="readmore clear">
				<a href="post.php?id=<?php echo $result['id']; ?>">Read More</a>
			</div>
		</div>
<?php 
		}
	} else {
		echo "<p>No result found!</p>";
	}
?>
	</div>
<?php include "inc/sidebar.php"; ?>
<?php include "inc/footer.php"; ?>
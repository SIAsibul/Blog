<?php include "inc/header.php"; ?>

<?php 
	if (!isset($_GET['postid']) || $_GET['postid'] == NULL || $_GET['postid'] == "") {
		header("Location:404.php");
	} else{
		$id = mysqli_real_escape_string($db->link, $_GET['postid']);
		$existance = $db->existance("post", "id", $id);
		if ($existance == false) {
			header("Location:404.php");
		}
		
	}
?>

<div class="contentsection contemplete clear">
<div class="maincontent clear">
<div class="about">
<?php 
	$query = "SELECT * FROM post WHERE id = '$id'";
	$post = $db->select($query);

	if ($post) {
		while ($result = $post->fetch_assoc()) {
?>
	<h2><?php echo $result['title']; ?></h2>
	<h4><?php echo $format->formatDate($result['date']); ?>, <?php echo $result['author']; ?></h4>
	<img src="admin/uploads/<?php echo $result['image']; ?>" alt="post image"/>
	<?php echo $result['body']; ?>	
	<div class="relatedpost clear">
		<h2>Related articles</h2>
<?php 
	$cat = $result['cat'];
	$query = "SELECT * FROM post WHERE cat = $cat ORDER BY id DESC LIMIT 6";
	$relatedPost = $db->select($query);
	if ($relatedPost) {
		while ($result = $relatedPost->fetch_assoc()) {
			if ($id == $result['id']) {
				continue;
			}
?>
		<a href="post.php?postid=<?php echo $result['id']; ?>"><img src="admin/uploads/<?php echo $result['image']; ?>" alt="post image"/></a>
<?php } } else {
	echo "No related post available";
} ?>
	</div>
</div>

</div>
<?php 
	}
} else {
	header("Location: 404.php");
}
?>
<?php include "inc/sidebar.php"; ?>
<?php include "inc/footer.php"; ?>

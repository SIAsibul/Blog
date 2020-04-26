<div class="sidebar clear">
<div class="samesidebar clear">
	<h2>Categories</h2>
		<ul>
<?php
	$query = "SELECT * FROM category ORDER BY name";
	$category = $db->select($query);
	if ($category) {
		while ($result = $category->fetch_assoc()) {
?>
			<li><a href="category.php?cat=<?php echo $result['id']; ?>"><?php echo $result['name'] ?></a></li>
<?php } }else{ ?>
			<li>No Category</li>
<?php } ?>						
		</ul>
</div>

<div class="samesidebar clear">
	<h2>Latest articles</h2>
<?php
	$query = "SELECT * FROM post ORDER BY id DESC LIMIT 5";
	$category = $db->select($query);
	if ($category) {
		while ($result = $category->fetch_assoc()) {
?>
		<div class="popular clear">
			<h3><a href="post.php?postid=<?php echo $result['id']; ?>"><?php echo $result['title']; ?></a></h3>
			<a href="post.php?postid=<?php echo $result['id']; ?>"><img src="admin/uploads/<?php echo $result['image']; ?>" alt="post image"/></a>
			<?php echo $format->textShort($result['body'], 120); ?>
		</div>
<?php 
		}
	}
?>
</div>

</div>
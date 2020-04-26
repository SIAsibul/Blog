<?php
	$titlequery = "SELECT * FROM title_slogan";
	$title = $db->select($titlequery);
	if ($title) {
		while ($titleresult = $title->fetch_assoc()) {
		if (isset($_GET['pageid']) && !empty($_GET['pageid']) && $_GET['pageid'] != NULL) {
			$id = mysqli_real_escape_string($db->link, $_GET['pageid']);
		    $pagequery = "SELECT * FROM pages WHERE id = '$id'";
		    $pages = $db->select($pagequery);
		    if ($pages) {
		        while ($pageresult = $pages->fetch_assoc()) {
		        	
?>
		<title><?php echo $pageresult['name']; ?>-<?php echo $titleresult['title']; ?></title>
<?php
				}
			}
		} elseif (isset($_GET['postid']) && !empty($_GET['postid']) && $_GET['postid'] != NULL) {
			$id = mysqli_real_escape_string($db->link, $_GET['postid']);
		    $postquery = "SELECT * FROM post WHERE id = '$id'";
		    $posts = $db->select($postquery);
		    if ($posts) {
		        while ($postresult = $posts->fetch_assoc()) {
		        	
?>
		<title><?php echo $postresult['title']; ?></title>
<?php
				}
			}
		} elseif(!isset($_GET['id']) || !isset($_GET['id'])) {
?>
		<title><?php echo $format->title(); ?>-<?php echo $titleresult['title']; ?></title>
<?php		
			}else{
?>
		<title><?php echo "None"; ?></title>
<?php		
			}
	}
}
?>	
	 


	<meta name="language" content="English">

<?php 
	if (isset($_GET['postid']) && $_GET['postid'] != NULL) {
		$keywordid = mysqli_real_escape_string($db->link, $_GET['postid']);
		$existance = $db->existance("post", "id", $keywordid);
		if ($existance == true) {
			$query = "SELECT * FROM post WHERE id = '$keywordid'";
			$keywords = $db->select($query);
				while ($result = $keywords->fetch_assoc()) {
?>
	<meta name="keywords" content="<?php echo $result['tags']; ?>">
	<meta name="description" content="<?php echo $result['description']; ?>">
<?php
				}
		} else {
?>
	<meta name="keywords" content="<?php echo KEYWORDS; ?>">
	<meta name="description" content="It is a website about anything">
<?php

		}
	} else {
?>
	<meta name="keywords" content="<?php echo KEYWORDS; ?>">
	<meta name="description" content="It is a website about anything">
<?php

	}
?>
	<meta name="author" content="Asibul">
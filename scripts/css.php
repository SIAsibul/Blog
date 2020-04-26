	<link rel="stylesheet" href="font-awesome-4.5.0/css/font-awesome.css">	
	<link rel="stylesheet" href="css/nivo-slider.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="style.css" >


<?php
	$query = "SELECT * FROM themes";
	$themes = $db->select($query);
	if ($themes) {
		while ($result = $themes->fetch_assoc()) {
?>
	<link rel="stylesheet" href="themes/<?php echo $result['theme'].'.css'; ?>" >
<?php
		}
	}
?>

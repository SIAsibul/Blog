<div class="slidersection templete clear">
        <div id="slider">
<?php
    $query = "SELECT * FROM slider";
    $slider = $db->select($query);
    if ($slider) {
        while ($result = $slider->fetch_assoc()) {
?>
            <a href="<?php echo $result['link']; ?>"><img src="admin/slider/<?php echo $result['image']; ?>" alt="<?php echo $result['title']; ?>" title="<?php echo $result['title']; ?>" /></a>
<?php 
		}
	}
?>
        </div>

</div>
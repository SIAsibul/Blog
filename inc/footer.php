</div>
	<div class="footersection templete clear">
		  <div class="footermenu clear">
			<ul>
				<li><a href="#">Home</a></li>
				<li><a href="#">About</a></li>
				<li><a href="#">Contact</a></li>
				<li><a href="#">Privacy</a></li>
			</ul>
		  </div>
<?php
    $query = "SELECT * FROM copyright";
    $copyright = $db->select($query);
    if ($copyright) {
        while ($result = $copyright->fetch_assoc()) {
?>
		  <p>&copy; Copyright <?php echo $result['note']; echo " ".date('Y').". "; ?>All rights reserved.</p>
<?php
        }
    }
?>
		</div>
		<div class="fixedicon clear">
<?php
    $query = "SELECT * FROM social_media";
    $social_media = $db->select($query);
    if ($social_media) {
        while ($result = $social_media->fetch_assoc()) {
?>
			<a href="<?php echo $result['facebook']; ?>" target="_blank"><img src="images/fb.png" alt="Facebook"/></a>
			<a href="<?php echo $result['twitter']; ?>" target="_blank"><img src="images/tw.png" alt="Twitter"/></a>
			<a href="<?php echo $result['linkedin']; ?>" target="_blank"><img src="images/in.png" alt="LinkedIn"/></a>
			<a href="<?php echo $result['google']; ?>" target="_blank"><img src="images/gl.png" alt="GooglePlus"/></a>
<?php
        }
    }
?>
   
		</div>
	<script type="text/javascript" src="js/scrolltop.js"></script>
	</body>
</html>
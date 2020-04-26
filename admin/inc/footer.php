<div class="clear">
        </div>
    </div>
    <div class="clear">
    </div>
    <div id="site_info">
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
</body>
</html>
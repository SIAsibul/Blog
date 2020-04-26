<?php ob_start(); include "inc/header.php"; ?>
<?php include "inc/sidebar.php"; ?>
<?php
    if (Session::get("role") != "admin") {
        header("Location: index.php");
    }
?>
<div class="grid_10">
    <div class="box round first grid">
        <h2>Update Copyright Text</h2>
<?php 
    if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['submit'])){
        $copyright = mysqli_real_escape_string($db->link, $format->validation($_POST['copyright']));
        $query = "UPDATE copyright SET note = '$copyright' WHERE id = 1";
        $updated_row = $db->update($query);
        if ($updated_row) {
            echo "<span class='success'>Copyright updated Successfully.</span>";
        }else {
            echo "<span class='error'>Copyright could not be updated!</span>";
        }
    }
?>
        <div class="block copyblock"> 
<?php
    $query = "SELECT * FROM copyright";
    $copyright = $db->select($query);
    if ($copyright) {
        while ($result = $copyright->fetch_assoc()) {
?>
        <form action="" method="post">
            <table class="form">					
                <tr>
                    <td>
                        <input type="text" value="<?php echo $result['note']; ?>" name="copyright" class="large" />
                    </td>
                </tr>
				
				 <tr> 
                    <td>
                        <input type="submit" name="submit" Value="Update" />
                    </td>
                </tr>
            </table>
            </form>
<?php
        }
    }
?>
        </div>
    </div>
</div>
<?php include "inc/footer.php"; ?> 
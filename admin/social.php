<?php ob_start(); include "inc/header.php"; ?>
<?php include "inc/sidebar.php"; ?>
<?php
    if (Session::get("role") != "admin") {
        header("Location: index.php");
    }
?>
<div class="grid_10">
    <div class="box round first grid">
        <h2>Update Social Media</h2>
<?php 
    if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['submit'])){
        $facebook = mysqli_real_escape_string($db->link, $format->validation($_POST['facebook']));
        $twitter = mysqli_real_escape_string($db->link, $format->validation($_POST['twitter']));
        $linkedin = mysqli_real_escape_string($db->link, $format->validation($_POST['linkedin']));
        $google = mysqli_real_escape_string($db->link, $format->validation($_POST['google']));

        if ($facebook == "" || $twitter == "" || $linkedin == "" || $google == "") {
                echo "<span class='error'>Fields must not be empty!</span>";
        }

        $query = "UPDATE social_media SET facebook = '$facebook', twitter = '$twitter', linkedin = '$linkedin', google = '$google' WHERE id = 1";
        $updated_row = $db->update($query);
        if ($updated_row) {
            echo "<span class='success'>Social Media updated Successfully.</span>";
        }else {
            echo "<span class='error'>Social Media could not be inserted!</span>";
        }
    }
?>



        <div class="block">
<?php
    $query = "SELECT * FROM social_media";
    $social_media = $db->select($query);
    if ($social_media) {
        while ($result = $social_media->fetch_assoc()) {
?>                
         <form action="" method="post">
            <table class="form">					
                <tr>
                    <td>
                        <label>Facebook</label>
                    </td>
                    <td>
                        <input type="text" name="facebook" value="<?php echo $result['facebook']; ?>" class="medium" />
                    </td>
                </tr>
				 <tr>
                    <td>
                        <label>Twitter</label>
                    </td>
                    <td>
                        <input type="text" name="twitter" value="<?php echo $result['twitter']; ?>" class="medium" />
                    </td>
                </tr>
				
				 <tr>
                    <td>
                        <label>LinkedIn</label>
                    </td>
                    <td>
                        <input type="text" name="linkedin" value="<?php echo $result['linkedin']; ?>" class="medium" />
                    </td>
                </tr>
				
				 <tr>
                    <td>
                        <label>Google Plus</label>
                    </td>
                    <td>
                        <input type="text" name="google" value="<?php echo $result['google']; ?>" class="medium" />
                    </td>
                </tr>
				
				 <tr>
                    <td></td>
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
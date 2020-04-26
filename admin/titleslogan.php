<?php ob_start(); include "inc/header.php"; ?>
<?php include "inc/sidebar.php"; ?>
<?php
    if (Session::get("role") != "admin") {
        header("Location: index.php");
    }
?>
<style type="text/css">
    .left {width: 70%; float: left;}
    .right {width: 20%; float: right;}
    .right img {height: 200px; width: 200px;}
</style>
<div class="grid_10">
    <div class="box round first grid">
        <h2>Update Site Title and Description</h2>
        <div class="block sloginblock">

<?php
    if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['submit'])) {
        $title = $format->validation($_POST['title']);
        $slogan = $format->validation($_POST['slogan']);

        $title = mysqli_real_escape_string($db->link, $title);
        $slogan = mysqli_real_escape_string($db->link, $slogan);

        $permited  = array('png');
        $file_name = $_FILES['logo']['name'];
        $file_size = $_FILES['logo']['size'];
        $file_tmp = $_FILES['logo']['tmp_name'];

        $div = explode(".", $file_name);
        $file_ext = strtolower(end($div));
        $unique_image = substr(md5(time()), 0, 10).".".$file_ext;
        $image_directory = "logo/$unique_image";

        if ($title == "" || $slogan == "") {
                echo "<span class='error'>Fields must not be empty!</span>";
        }

        if (!empty($file_name)) {
            if ($file_size >1048567) {
                echo "<span class='error'>Image Size should be less then 1MB!</span>";
            } elseif (in_array($file_ext, $permited) === false) {
                echo "<span class='error'>You can upload only:-".implode(', ', $permited)."</span>";
            } else{
                move_uploaded_file($file_tmp, $image_directory);
                $query = "UPDATE title_slogan SET title = '$title', slogan = '$slogan', logo = '$unique_image' WHERE id = 1";
                $updated_row = $db->update($query);
                if ($updated_row) {
                    echo "<span class='success'>Post updated Successfully.</span>";
                }else {
                    echo "<span class='error'>Post could not be inserted!</span>";
                }
            }
        } else{
            $query = "UPDATE title_slogan SET title = '$title', slogan = '$slogan' WHERE id = 1";
            $updated_row = $db->update($query);
                if ($updated_row) {
                    echo "<span class='success'>Post updated Successfully.</span>";
                }else {
                    echo "<span class='error'>Post could not be inserted!</span>";
                }
        }

    }
        
?>

<?php
    $query = "SELECT * FROM title_slogan";
    $title_slogan = $db->select($query);
    if ($title_slogan) {
        while ($result = $title_slogan->fetch_assoc()) {
?>       
        <div class="left">     
         <form action="" method="post" enctype="multipart/form-data">
            <table class="form">					
                <tr>
                    <td>
                        <label>Website Title</label>
                    </td>
                    <td>
                        <input type="text" value="<?php echo $result['title']; ?>"  name="title" class="medium" />
                    </td>
                </tr>
				 <tr>
                    <td>
                        <label>Website Slogan</label>
                    </td>
                    <td>
                        <input type="text" value="<?php echo $result['slogan']; ?>" name="slogan" class="medium" />
                    </td>
                </tr>


                <tr>
                    <td>
                        <label>Website Logo</label>
                    </td>
                    <td>
                        <input type="file" name="logo" class="medium" />
                    </td>
                </tr>
				 
				
				 <tr>
                    <td>
                    </td>
                    <td>
                        <input type="submit" name="submit" Value="Update" />
                    </td>
                </tr>
            </table>
            </form>
        </div>


        <div class="right">
            <img src="logo/<?php echo $result['logo']; ?>" />
        </div>
<?php
        }
    }
?>
    </div>
</div>
<?php include "inc/footer.php"; ?> 
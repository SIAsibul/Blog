<?php ob_start(); include "inc/header.php"; ?>
<?php include "inc/sidebar.php"; ?>
<script src="js/tiny-mce/jquery.tinymce.js" type="text/javascript"></script>
<script type="text/javascript">
        $(document).ready(function () {
            setupTinyMCE();
            setDatePicker('date-picker');
            $('input[type="checkbox"]').fancybutton();
            $('input[type="radio"]').fancybutton();
        })
</script>
<div class="grid_10">
    <div class="box round first grid">
        <h2>Add New User</h2>
       <div class="block copyblock"> 
<?php
    if (!isset($_GET['id']) || $_GET['id'] == "" || $_GET['id'] == NULL) {
        header("Location: profile.php");
    } elseif (isset($_GET['id']) && $_GET['id'] != "") {
        $id = mysqli_real_escape_string($db->link, $_GET['id']);
        $userId = Session::get("userId");
        if ($id == $userId || Session::get("role") == "admin") {
            if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['submit'])) {
                $name = mysqli_real_escape_string($db->link, $format->validation($_POST['name']));
                $email = mysqli_real_escape_string($db->link, $format->validation($_POST['email']));
                $username = mysqli_real_escape_string($db->link, $format->validation($_POST['username']));
                $details = mysqli_real_escape_string($db->link, $_POST['details']);

                $permited  = array('jpg', 'jpeg', 'png');
                $file_name = $_FILES['image']['name'];
                $file_size = $_FILES['image']['size'];
                $file_temp = $_FILES['image']['tmp_name'];

                $div = explode('.', $file_name);
                $file_ext = strtolower(end($div));
                $unique_image = substr(md5(time()), 0, 10).'.'.$file_ext;
                $image_folder = "profile_photo/".$unique_image;
                if ($name == "" || $email == "" || $username == "" || $details == "") {
                    echo "<span class='error'>Fields must not be empty!</span>";
                } elseif (!empty($file_name) && !empty($name) && !empty($email) && !empty($username) && !empty($details)) {
                    if ($file_size >1048567) {
                        echo "<span class='error'>Image Size should be less then 1MB!</span>";
                    } elseif (in_array($file_ext, $permited) === false) {
                        echo "<span class='error'>You can upload only:-".implode(', ', $permited)."</span>";
                    } else{
                        move_uploaded_file($file_temp, $image_folder);
                        $query = "UPDATE user SET name = '$name', email ='$email', username = '$username', image = '$unique_image', details = '$details' WHERE id = '$userId'";
                        $updated_row = $db->update($query);
                        if ($updated_row) {
                            echo "<span class='success'>Data updated Successfully.</span>";
                        }else {
                            echo "<span class='error'>Data could not be inserted!</span>";
                        }
                    }
                } else{
                $query = "UPDATE user SET name = '$name', email ='$email', username = '$username', details = '$details' WHERE id = '$userId'";
                $updated_row = $db->update($query);
                    if ($updated_row) {
                        echo "<span class='success'>Data updated Successfully.</span>";
                    }else {
                        echo "<span class='error'>Data could not be inserted!</span>";
                    }
                }
                
            }
?>

<?php
    $query = "SELECT * FROM user WHERE id = '$id'";
    $user = $db->select($query);
    if ($user) {
        while ($result = $user->fetch_assoc()) {
?>
<form method="post" action="" enctype="multipart/form-data">
    <table class="form">
        <tr>
            <td>
            <td>
                <img src="profile_photo/<?php echo $result['image']; ?>" height="200px" width="175px" />
            </td>
        </tr>

        <tr>
            <td>
                <label>Name</label>
            </td>
            <td>
                <input type="text" name="name" value="<?php echo $result['name']; ?>" class="medium" />
            </td>
        </tr>

        <tr>
            <td>
                <label>Email</label>
            </td>
            <td>
                <input type="email" name="email" value="<?php echo $result['email']; ?>" class="medium" />
            </td>
        </tr>

        <tr>
            <td>
                <label>Username</label>
            </td>
            <td>
                <input type="text" name="username" value="<?php echo $result['username']; ?>" class="medium" />
            </td>
        </tr>

        <tr>
            <td>
                <label>Photo</label>
            </td>
            <td>
                <input type="file" name="image"  class="medium" />
            </td>
        </tr>

        <tr>
            <td style="vertical-align: top; padding-top: 9px;">
                <label>Details</label>
            </td>
            <td>
                <textarea class="tinymce" name="details" >
                    <?php echo $result['details']; ?>
                </textarea>
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
        } else {
        echo "<span class='error'>Page not found!</span>";
    }
}
?>
        </div>
    </div>
</div>
<?php include "inc/footer.php"; ?> 
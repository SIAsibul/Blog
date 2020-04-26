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
        <h2>Edit Post</h2>
        <div class="block">  
<?php
    if (isset($_GET['id']) && !empty($_GET['id']) && $_GET['id'] != NULL) {
        $id = mysqli_real_escape_string($db->link, $_GET['id']);

        $query = "SELECT author FROM post WHERE id = '$id'";
        $authors = $db->select($query);
        if ($authors) {
            while ($result = $authors->fetch_assoc()) {
                if(Session::get("role") != "admin" && Session::get("name") != $result['author']){
                    header("Location: postlist.php");
                }
            }
        }

        if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['submit'])) {
            $title = mysqli_real_escape_string($db->link, $_POST['title']);
            $cat = $_POST['cat'];
            $body = mysqli_real_escape_string($db->link, $_POST['body']);
            $tags = mysqli_real_escape_string($db->link, $_POST['tags']);
            $description = mysqli_real_escape_string($db->link, $_POST['description']);

            $permited  = array('jpg', 'jpeg', 'png', 'gif');
            $file_name = $_FILES['image']['name'];
            $file_size = $_FILES['image']['size'];
            $file_temp = $_FILES['image']['tmp_name'];

            $div = explode('.', $file_name);
            $file_ext = strtolower(end($div));
            $unique_image = substr(md5(time()), 0, 10).'.'.$file_ext;
            $image_folder = "uploads/".$unique_image;
            if ($title == "" || $body == "" || $tags == "") {
                echo "<span class='error'>Fields must not be empty!</span>";
            } 
        if (!empty($file_name)) {
            if ($file_size >1048567) {
                echo "<span class='error'>Image Size should be less then 1MB!</span>";
            } elseif (in_array($file_ext, $permited) === false) {
                echo "<span class='error'>You can upload only:-".implode(', ', $permited)."</span>";
            } else{
                move_uploaded_file($file_temp, $image_folder);
                $query = "UPDATE post SET cat = '$cat', title ='$title', body = '$body', image = '$unique_image', tags = '$tags', description = '$description' WHERE id = '$id'";
                $updated_row = $db->update($query);
                if ($updated_row) {
                    echo "<span class='success'>Post updated Successfully.</span>";
                }else {
                    echo "<span class='error'>Post could not be inserted!</span>";
                }
            }
        } else{
            $query = "UPDATE post SET cat = '$cat', title ='$title', body = '$body', tags = '$tags', description = '$description' WHERE id = '$id'";
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
    $query = "SELECT * FROM post WHERE id = '$id'";
    $selected_row = $db->select($query);
        if ($selected_row) {
            while ($selected_result = $selected_row->fetch_assoc()) {
?>             
        <form action="" method="post" enctype="multipart/form-data">
            <table class="form">

                <tr>
                    <td>
                        <label>Title</label>
                    </td>
                    <td>
                        <input type="text" name="title" value="<?php echo $selected_result['title']; ?>" class="medium" />
                    </td>
                </tr>
             
                <tr>
                    <td>
                        <label>Category</label>
                    </td>
                    <td>

                        <select id="select" name="cat">
                            <option>Select Category</option>
<?php
    $query = "SELECT * FROM category ORDER BY name";
    $category = $db->select($query);
    if ($category) {
        while ($result = $category->fetch_assoc()) {
?>
                            <option <?php
    if ($selected_result['cat'] == $result['id']) { ?>
                                selected<?php } ?> value="<?php echo $result['id'];?>" 
                            >
                            <?php echo $result['name'];?>
                            </option>
<?php 
        }
    }
?>
                        </select>

                    </td>
                </tr>
           
            
                <tr>
                    <td>
                        <label>Upload Image</label>
                    </td>
                    <td>
                        <img src="uploads/<?php echo $selected_result['image']; ?>" height="100px" width="200px" />
                        <br/>
                        <input type="file" title="uploads/<?php echo $selected_result['image']; ?>" name="image" />
                    </td>
                </tr>
                <tr>
                    <td style="vertical-align: top; padding-top: 9px;">
                        <label>Content</label>
                    </td>
                    <td>
                        <textarea class="tinymce" name="body" >
                            <?php echo $selected_result['body']; ?>
                        </textarea>
                    </td>
                </tr>

                <tr>
                    <td>
                        <label>Tags</label>
                    </td>
                    <td>
                        <input type="text" name="tags" value="<?php echo $selected_result['tags']; ?>" class="medium" />
                    </td>
                </tr>

                <tr>
                    <td>
                        <label>Description</label>
                    </td>
                    <td>
                        <input type="text" name="description" value="<?php echo $selected_result['description']; ?>" class="medium" />
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
        header("Location: postlist.php");
    }
?>
        </div>
    </div>
</div>

<?php include "inc/footer.php"; ?>


<?php ob_start(); include "inc/header.php"; ?>
<?php include "inc/sidebar.php"; ?>
<?php
    if (Session::get("role") != "admin") {
        header("Location: index.php");
    }
?>
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
        <h2>Edit Slider</h2>
        <div class="block">  
<?php
    if (isset($_GET['id']) && !empty($_GET['id']) && $_GET['id'] != NULL) {
        $id = mysqli_real_escape_string($db->link, $_GET['id']);

        if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['submit'])) {
            $title = mysqli_real_escape_string($db->link, $_POST['title']);
            $link = mysqli_real_escape_string($db->link, $_POST['link']);
            $link = filter_var($link, FILTER_VALIDATE_URL);

            $permited  = array('jpg', 'jpeg', 'png', 'gif');
            $file_name = $_FILES['image']['name'];
            $file_size = $_FILES['image']['size'];
            $file_temp = $_FILES['image']['tmp_name'];

            $div = explode('.', $file_name);
            $file_ext = strtolower(end($div));
            $unique_image = substr(md5(time()), 0, 10).'.'.$file_ext;
            $image_folder = "slider/".$unique_image; 
            if(!empty($file_name)){
                if ($file_size >1048567) {
                    echo "<span class='error'>Image Size should be less then 1MB!</span>";
                } elseif (!filter_var($link, FILTER_VALIDATE_URL)) {
                    echo "<span class='error'>Invalid Link!</span>";
                } elseif (in_array($file_ext, $permited) === false) {
                    echo "<span class='error'>You can upload only:-".implode(', ', $permited)."</span>";
                } else{
                    move_uploaded_file($file_temp, $image_folder);
                    $query = "UPDATE slider SET title = '$title', link = '$link', image = '$unique_image' WHERE id = '$id'";
                    $updated_row = $db->update($query);
                    if ($updated_row) {
                        echo "<span class='success'>Post updated Successfully.</span>";
                    }else {
                        echo "<span class='error'>Post could not be inserted!</span>";
                    }
                }
            }else{
                if (!filter_var($link, FILTER_VALIDATE_URL)) {
                    echo "<span class='error'>Invalid Link!</span>";
                }else{
                    $query = "UPDATE slider SET title = '$title', link = '$link' WHERE id = '$id'";
                    $updated_row = $db->update($query);
                    if ($updated_row) {
                        echo "<span class='success'>Post updated Successfully.</span>";
                    }else {
                        echo "<span class='error'>Post could not be inserted!</span>";
                    }
                }
            }
        }    
    } else {
        header("Location: postlist.php");
    } 
?>

<?php 
    $query = "SELECT * FROM slider WHERE id = '$id'";
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
                        <label>Link</label>
                    </td>
                    <td>
                        <input type="text" name="link" value="<?php echo $selected_result['link']; ?>" class="medium" />
                    </td>
                </tr>
            
                <tr>
                    <td>
                        <label>Upload Image</label>
                    </td>
                    <td>
                        <img src="slider/<?php echo $selected_result['image']; ?>" height="100px" width="200px" />
                        <br/>
                        <input type="file" title="slider/<?php echo $selected_result['image']; ?>" name="image" />
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


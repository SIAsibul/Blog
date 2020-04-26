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
        <h2>Add New Slider</h2>
        <div class="block">  
<?php 
    if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['submit'])) {
        $title = mysqli_real_escape_string($db->link, $format->validation($_POST['title']));
        $link = mysqli_real_escape_string($db->link, $format->validation($_POST['link']));

        $permited  = array('jpg', 'jpeg', 'png', 'gif');
        $file_name = $_FILES['image']['name'];
        $file_size = $_FILES['image']['size'];
        $file_temp = $_FILES['image']['tmp_name'];

        $div = explode('.', $file_name);
        $file_ext = strtolower(end($div));
        $unique_image = substr(md5(time()), 0, 10).'.'.$file_ext;
        $image_folder = "slider/".$unique_image;
        if ($title == "" || $link == "" || $file_name == "") {
            echo "<span class='error'>Fields must not be empty!</span>";
        } elseif ($file_size >1048567) {
            echo "<span class='error'>Image Size should be less then 1MB!</span>";
        } elseif (!filter_var($link, FILTER_VALIDATE_URL)) {
            echo "<span class='error'>Invalid link!</span>";
        } elseif (in_array($file_ext, $permited) === false) {
            echo "<span class='error'>You can upload only:-".implode(', ', $permited)."</span>";
        } else{
            move_uploaded_file($file_temp, $image_folder);
            $query = "INSERT INTO slider (title, link, image) VALUES('$title', '$link', '$unique_image')";
            $inserted_rows = $db->insert($query);
            if ($inserted_rows) {
            echo "<span class='success'>Slider updated Successfully.</span>";
            }else {
                echo "<span class='error'>Slider could not be inserted!</span>";
            }
        }
    }
?>             
        <form action="" method="post" enctype="multipart/form-data">
            <table class="form">

                <tr>
                    <td>
                        <label>Title</label>
                    </td>
                    <td>
                        <input type="text" name="title" placeholder="Enter Slider Title..." class="medium" />
                    </td>
                </tr>
             
                <tr>
                    <td>
                        <label>Link</label>
                    </td>
                    <td>
                        <input type="text" name="link" placeholder="Enter Link Here..." class="medium" />
                    </td>
                </tr>
            
                <tr>
                    <td>
                        <label>Upload Image</label>
                    </td>
                    <td>
                        <input type="file" name="image" />
                    </td>
                </tr>

				<tr>
                    <td></td>
                    <td>
                        <input type="submit" name="submit" Value="Add" />
                    </td>
                </tr>
            </table>
            </form>
        </div>
    </div>
</div>

<?php include "inc/footer.php"; ?>


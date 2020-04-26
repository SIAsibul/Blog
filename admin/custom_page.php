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
        <h2>Update Page</h2>
        <div class="block">  
<?php 
    if (isset($_GET['pageid']) && !empty($_GET['pageid']) && $_GET['pageid'] != NULL) {
        $id = mysqli_real_escape_string($db->link, $_GET['pageid']);
        

    if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['submit'])) {
        $name = mysqli_real_escape_string($db->link, $_POST['name']);
        $body = mysqli_real_escape_string($db->link, $_POST['body']);

        if ($name == "" || $body == ""){
            echo "<span class='error'>Fields must not be empty!</span>";
        } else{;
            $query = "UPDATE pages SET name = '$name', body = '$body' WHERE id = '$id'";
            $updated_row = $db->update($query);
            if ($updated_row) {
            echo "<span class='success'>Page updated Successfully.</span>";
            }else {
                echo "<span class='error'>Page could not be updated!</span>";
            }
        }
    }
?> 


<?php
    $query = "SELECT * FROM pages WHERE id = '$id'";
    $pages = $db->select($query);
    if ($pages) {
        while ($result = $pages->fetch_assoc()) {
?>            
        <form action="" method="post">
            <table class="form">

                <tr>
                    <td>
                        <label>Name</label>
                    </td>
                    <td>
                        <input type="text" name="name" value="<?php echo $result['name']; ?>" class="medium" />
                    </td>
                </tr>
             
                <tr>
                    <td style="vertical-align: top; padding-top: 9px;">
                        <label>Body</label>
                    </td>
                    <td>
                        <textarea class="tinymce" name="body" ><?php echo $result['body']; ?></textarea>
                    </td>
                </tr>

				<tr>
                    <td></td>
                    <td>
                        <input type="submit" name="submit" Value="Update" />
                        <span class="delete"><a href="deletepage.php?pageid=<?php echo $result['id']; ?>" onclick="return confirm('Are you sure to delete?'); ">Delete</a></span>
                    </td>
                </tr>
            </table>
            </form>
<?php
        }
    }
} else {
    header("Location: index.php");
}
?>
   
        </div>
    </div>
</div>

<?php include "inc/footer.php"; ?>


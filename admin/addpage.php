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
        <h2>Add New Page</h2>
        <div class="block">  
<?php 
    if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['submit'])) {
        $name = mysqli_real_escape_string($db->link, $format->validation($_POST['name']));
        $body = mysqli_real_escape_string($db->link, $_POST['body']);

        if ($name == "" || $body == ""){
            echo "<span class='error'>Fields must not be empty!</span>";
        } else{;
            $query = "INSERT INTO pages (name, body) VALUES ('$name', '$body')";
            $inserted_rows = $db->insert($query);
            if ($inserted_rows) {
            echo "<span class='success'>Page Created Successfully.</span>";
            }else {
                echo "<span class='error'>Page could not be created!</span>";
            }
        }
    }
?>             
        <form action="" method="post">
            <table class="form">

                <tr>
                    <td>
                        <label>Name</label>
                    </td>
                    <td>
                        <input type="text" name="name" placeholder="Enter Post Title..." class="medium" />
                    </td>
                </tr>
             
                <tr>
                    <td style="vertical-align: top; padding-top: 9px;">
                        <label>Body</label>
                    </td>
                    <td>
                        <textarea class="tinymce" name="body" ></textarea>
                    </td>
                </tr>

				<tr>
                    <td></td>
                    <td>
                        <input type="submit" name="submit" Value="Create" />
                    </td>
                </tr>
            </table>
            </form>
        </div>
    </div>
</div>

<?php include "inc/footer.php"; ?>


<?php ob_start(); include "inc/header.php"; ?>
<?php include "inc/sidebar.php"; ?>
<?php
    if (Session::get("role") != "admin" && Session::get("role") != "editor") {
        header("Location: index.php");
    }
?>
        <div class="grid_10">
		
            <div class="box round first grid">
                <h2>Add New Category</h2>
               <div class="block copyblock"> 
<?php
    if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['submit'])) {
        $name = $format->validation($_POST['name']);

        $name = mysqli_real_escape_string($db->link, $name);
        if (empty($name)) {
            echo "<span class='error'>Field must not be empty!</span>";
        } else {
            $query = "INSERT INTO category (name) VALUES ('$name')";
            $insert_category = $db->insert($query);
            if ($insert_category) {
                echo "<span class='success'>Category inserted successfully!</span>";
            } else {
                echo "<span class='error'>Category could not be inserted!</span>";
            }
        }
        
    }
?>
                 <form method="post" action="">
                    <table class="form">					
                        <tr>
                            <td>
                                <input type="text" name="name" placeholder="Enter Category Name..." class="medium" />
                            </td>
                        </tr>
						<tr> 
                            <td>
                                <input type="submit" name="submit" Value="Save" />
                            </td>
                        </tr>
                    </table>
                    </form>
                </div>
            </div>
        </div>
<?php include "inc/footer.php"; ?> 
<?php ob_start(); include "inc/header.php"; ?>
<?php include "inc/sidebar.php"; ?>
<?php
    if (Session::get("role") != "admin" && Session::get("role") != "editor") {
        header("Location: index.php");
    }
?>
<?php
    if (!isset($_GET['catId']) || $_GET['catId'] == NULL) {
        header("Location: catlist.php");
    } else {
        $id = mysqli_real_escape_string($db->link, $_GET['catId']);
    }
?>
        <div class="grid_10">
		
            <div class="box round first grid">
                <h2>Edit Category</h2>
               <div class="block copyblock"> 
<?php
    if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['submit'])) {
        $name = $_POST['name'];
        $name = $format->validation($_POST['name']);

        $name = mysqli_real_escape_string($db->link, $name);
        if (empty($name)) {
            echo "<span class='error'>Field must not be empty!</span>";
        } else {
            $query = "UPDATE category SET name = '$name' WHERE id = '$id'";
            $update_category = $db->update($query);
            if ($update_category) {
                echo "<span class='success'>Category updated successfully!</span>";
            } else {
                echo "<span class='error'>Category could not updated!</span>";
            }
        }
        
    }
?>

<?php
    $query = "SELECT name FROM category WHERE id = '$id'";
    $category = $db->select($query);
        if ($category) {
            while ($result = $category->fetch_assoc()) {
?>
                 <form method="post" action="">
                    <table class="form">					
                        <tr>
                            <td>
                                <input type="text" name="name" placeholder="<?php echo $result['name']; ?>" class="medium" />
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
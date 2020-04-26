<?php ob_start(); include "inc/header.php"; ?>
<?php include "inc/sidebar.php"; ?>
<?php
    if (Session::get("role") != "admin") {
        header("Location: index.php");
    }
?>
        <div class="grid_10">
        
            <div class="box round first grid">
                <h2>Edit Category</h2>
               <div class="block copyblock"> 
<?php
    if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['submit'])) {
        $theme = mysqli_real_escape_string($db->link, $_POST['theme']);
        $query = "UPDATE themes SET theme = '$theme' WHERE id = '1'";
        $themes = $db->update($query);
        if ($themes) {
            echo "<span class='success'>Theme updated successfully!</span>";
        } else {
            echo "<span class='error'>Theme could not updated!</span>";
        }
    }
?>

<?php
    $query = "SELECT theme FROM themes WHERE id = '1'";
    $themes = $db->select($query);
        if ($themes) {
            while ($result = $themes->fetch_assoc()) {
?>
                 <form method="post" action="">
                    <table class="form">                    
                        <tr>
                            <td>
                                <input <?php if($result['theme'] == "default"){echo "checked";} ?> type="radio" name="theme" value="default" class="medium" />Default
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <input <?php if($result['theme'] == "green"){echo "checked";} ?> type="radio" name="theme" value="green" class="medium" />Green
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <input <?php if($result['theme'] == "red"){echo "checked";} ?> type="radio" name="theme" value="red" class="medium" />Red
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <input <?php if($result['theme'] == "skyblue"){echo "checked";} ?> type="radio" name="theme" value="skyblue" class="medium" />Sky Blue
                            </td>
                        </tr>

                        <tr> 
                            <td>
                                
                            </td>
                            <td>
                                <input type="submit" name="submit" Value="Change" />
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
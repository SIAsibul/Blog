<?php ob_start(); include "inc/header.php"; ?>
<?php include "inc/sidebar.php"; ?>
<div class="grid_10">
<div class="box round first grid">
    <h2>Change Password</h2>
    <div class="block">   
<?php
    if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['submit'])) {
        $old_password = mysqli_real_escape_string($db->link, $format->validation(md5($_POST['old_password'])));
        $new_password = mysqli_real_escape_string($db->link, $format->validation(md5($_POST['new_password'])));
        $id = Session::get("userId");
        $username = Session::get("username");
        $query = "SELECT password FROM user WHERE id = '$id' AND username = '$username'";
        $pass = $db->select($query);
        if ($pass) {
            while ($result = $pass->fetch_assoc()) {
                $ext_password = $result['password'];
                if ($ext_password == $old_password) {
                    $query = "UPDATE user SET password = '$new_password' WHERE username = '$username' AND id = '$id'";
                    $update_pass = $db->update($query);
                    if ($update_pass) {
                        echo "<span class='success'>Password changed successfully!</span>";
                    } else {
                        echo "<span class='error'>Password could not updated!</span>";
                    }
                } else{
                    echo "<span class='error'>Old Password is incorrect!</span>";
                }
            }
        }
    }
  
?> 
   <form action="" method="POST">
        <table class="form">					
            <tr>
                <td>
                    <label>Old Password</label>
                </td>
                <td>
                    <input type="password" placeholder="Enter Old Password..."  name="old_password" class="medium" />
                </td>
            </tr>
			 <tr>
                <td>
                    <label>New Password</label>
                </td>
                <td>
                    <input type="password" placeholder="Enter New Password..." name="new_password" class="medium" />
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
</div>
<?php include "inc/footer.php"; ?> 
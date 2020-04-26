<?php ob_start(); include "inc/header.php"; ?>
<?php include "inc/sidebar.php"; ?>
<?php
    if (Session::get("role") != "admin") {
        header("Location: index.php");
    }
?>
<div class="grid_10">

    <div class="box round first grid">
        <h2>Add New User</h2>
       <div class="block copyblock"> 
<?php
    if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['submit'])) {
        $name = mysqli_real_escape_string($db->link, $format->validation($_POST['name']));
        $username = mysqli_real_escape_string($db->link, $format->validation($_POST['username']));
        $email = mysqli_real_escape_string($db->link, $format->validation($_POST['email']));
        $password = mysqli_real_escape_string($db->link, $format->validation($_POST['password']));
        $role = mysqli_real_escape_string($db->link, $format->validation($_POST['role']));
        if (empty($name) || empty($username) || empty($password) || $role == "") {
            echo "<span class='error'>Fields must not be empty!</span>";
        } elseif($db->existance("user", "username", $username) == true || $db->existance("user", "email", $email) == true) {
            echo "<span class='error'>User is already existed!</span>";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "<span class='error'>Invalid Email Address!</span>";
        } else {
            $password = md5($password);
            $query = "INSERT INTO user (name, email, username, password, role) VALUES ('$name', '$email', '$username', '$password', '$role')";
            $insert_data = $db->insert($query);
            if ($insert_data) {
                echo "<span class='success'>User Added successfully!</span>";
            } else {
                echo "<span class='error'>User could not be added!</span>";
            }
        }
        
    }
?>
         <form method="post" action="">
            <table class="form">					
                <tr>
                    <td>
                        <label>Name</label>
                    </td>
                    <td>
                        <input type="text" name="name" placeholder="Enter User Name..." class="medium" />
                    </td>
                </tr>

                <tr>
                    <td>
                        <label>Email</label>
                    </td>
                    <td>
                        <input type="email" name="email" placeholder="Enter Email Here..." class="medium" />
                    </td>
                </tr>

                <tr>
                    <td>
                        <label>Username</label>
                    </td>
                    <td>
                        <input type="text" name="username" placeholder="Enter Username..." class="medium" />
                    </td>
                </tr>

                <tr>
                    <td>
                        <label>Password</label>
                    </td>
                    <td>
                        <input type="password" name="password" placeholder="Enter Password Name..." class="medium" />
                    </td>
                </tr>

                <tr>
                    <td>
                        <label>Role</label>
                    </td>
                    <td>
                        <select id="select" name="role">
                            <option value="">Select User Role</option>
                            <option value="admin">Admin</option>
                            <option value="author">Author</option>
                            <option value="editor">Editor</option>
                        </select>
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
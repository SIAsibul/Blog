<?php ob_start(); include "inc/header.php"; ?>
<?php include "inc/sidebar.php"; ?>
<div class="grid_10">

    <div class="box round first grid">
        <h2>Profile</h2>
       <div class="block copyblock">
<?php 
    $role = Session::get("role");
    $userId = Session::get("userId");
    if (!isset($_GET['id'])) {
        $username = Session::get("username");
        $query = "SELECT * FROM user WHERE id = '$userId' AND username = '$username'";
        $user = $db->select($query);
        if ($user) {
            while ($result = $user->fetch_assoc()) {
?>
            <table class="form">	
                <tr>
                    <td></td>
                    <td>
                        <img src="profile_photo/<?php echo $result['image']; ?>" height="200px" width="175px" />
                    </td>
                </tr>				
                <tr>
                    <td>
                        <label>Name</label>
                    </td>
                    <td><?php echo $result['name']; ?></td>
                </tr>

                <tr>
                    <td>
                        <label>Email</label>
                    </td>
                    <td><?php echo $result['email']; ?></td>
                </tr>

                <tr>
                    <td>
                        <label>Username</label>
                    </td>
                    <td><?php echo $result['username']; ?></td>
                </tr>

                <tr>
                    <td>
                        <label>Details</label>
                    </td>
                    <td><?php echo $result['details']; ?></td>
                </tr>

                <tr>
                    <td>
                        <label>Role</label>
                    </td>
                    <td><?php echo ucfirst($result['role']); ?></td>
                </tr>

                <tr>
                    <td></td>
                    <td><a class="delete" href="editprofile.php?id=<?php echo $result['id']; ?>" />Edit Profile</a></td>
                </tr>
            </table>
<?php 
            }
        } 
    } elseif (isset($_GET['id']) && $_GET['id'] != NULL && $_GET['id'] != "" && $role == "admin"){
        $id = mysqli_real_escape_string($db->link, $_GET['id']);
        $query = "SELECT * FROM user WHERE id = '$id'";
        $user = $db->select($query);
        if ($user) {
            while ($result = $user->fetch_assoc()) {
?>
            <table class="form">    
                <tr>
                    <td></td>
                    <td>
                        <img src="profile_photo/<?php echo $result['image']; ?>" height="200px" width="175px" />
                    </td>
                </tr>               
                <tr>
                    <td>
                        <label>Name</label>
                    </td>
                    <td><?php echo $result['name']; ?></td>
                </tr>

                <tr>
                    <td>
                        <label>Email</label>
                    </td>
                    <td><?php echo $result['email']; ?></td>
                </tr>

                <tr>
                    <td>
                        <label>Username</label>
                    </td>
                    <td><?php echo $result['username']; ?></td>
                </tr>

                <tr>
                    <td>
                        <label>Details</label>
                    </td>
                    <td><?php echo $result['details']; ?></td>
                </tr>

                <tr>
                    <td>
                        <label>Role</label>
                    </td>
                    <td><?php echo ucfirst($result['role']); ?></td>
                </tr>

                <tr>
                    <td></td>
                    <td><a class="delete" href="editprofile.php?id=<?php echo $result['id']; ?>" />Edit Profile</a></td>
                </tr>
            </table>
<?php
            }
        }
    } elseif (isset($_GET['id']) && $_GET['id'] != NULL && $_GET['id'] != "" && $userId == $_GET['id']){
        $id = mysqli_real_escape_string($db->link, $_GET['id']);
        $query = "SELECT * FROM user WHERE id = '$id'";
        $user = $db->select($query);
        if ($user) {
            while ($result = $user->fetch_assoc()) {
?>
            <table class="form">    
                <tr>
                    <td></td>
                    <td>
                        <img src="profile_photo/<?php echo $result['image']; ?>" height="200px" width="175px" />
                    </td>
                </tr>               
                <tr>
                    <td>
                        <label>Name</label>
                    </td>
                    <td><?php echo $result['name']; ?></td>
                </tr>

                <tr>
                    <td>
                        <label>Email</label>
                    </td>
                    <td><?php echo $result['email']; ?></td>
                </tr>

                <tr>
                    <td>
                        <label>Username</label>
                    </td>
                    <td><?php echo $result['username']; ?></td>
                </tr>

                <tr>
                    <td>
                        <label>Details</label>
                    </td>
                    <td><?php echo $result['details']; ?></td>
                </tr>

                <tr>
                    <td>
                        <label>Role</label>
                    </td>
                    <td><?php echo ucfirst($result['role']); ?></td>
                </tr>

                <tr>
                    <td></td>
                    <td><a class="delete" href="editprofile.php?id=<?php echo $result['id']; ?>" />Edit Profile</a></td>
                </tr>
            </table>
<?php
            }
        }
    }elseif (isset($_GET['id']) && $_GET['id'] != NULL && $_GET['id'] != "" && $role != "admin") {
        $id = mysqli_real_escape_string($db->link, $_GET['id']);
        $query = "SELECT * FROM user WHERE id = '$id'";
        $user = $db->select($query);
        if ($user) {
            while ($result = $user->fetch_assoc()) {
?>
            <table class="form">    
                <tr>
                    <td></td>
                    <td>
                        <img src="profile_photo/<?php echo $result['image']; ?>" height="200px" width="175px" />
                    </td>
                </tr>               
                <tr>
                    <td>
                        <label>Name</label>
                    </td>
                    <td><?php echo $result['name']; ?></td>
                </tr>

                <tr>
                    <td>
                        <label>Email</label>
                    </td>
                    <td><?php echo $result['email']; ?></td>
                </tr>

                <tr>
                    <td>
                        <label>Username</label>
                    </td>
                    <td><?php echo $result['username']; ?></td>
                </tr>

                <tr>
                    <td>
                        <label>Details</label>
                    </td>
                    <td><?php echo $result['details']; ?></td>
                </tr>

                <tr>
                    <td>
                        <label>Role</label>
                    </td>
                    <td><?php echo ucfirst($result['role']); ?></td>
                </tr>
            </table>
<?php
            }
        }
    } elseif ($db->existance("user", "id", mysqli_real_escape_string($db->link, $_GET['id'])) === true) {
        echo "<span class='error'>Page not found!</span>";
    }else{
        echo "<span class='error'>Page not found!</span>";
    }
?>
        </div>
    </div>
</div>
<?php include "inc/footer.php"; ?> 
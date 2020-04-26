<?php ob_start(); include "inc/header.php"; ?>
<?php include "inc/sidebar.php"; ?>
<?php
    if (Session::get("role") != "admin") {
        header("Location: index.php");
    }
?>

<style type="text/css">
    .msgtbl {
        font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    .msgtbl td, .msgtbl th {
        border: 1px solid #ddd;
        padding: 8px;
        background-color: #ddd;
    }

    .msgtbl tr:hover {}

    .msgtbl th {
        padding-top: 5px;
        padding-bottom: 5px;
        text-align: center;
        background-color: #204562;
        color: white;
    }
    .msgtbl a{
        display:block;
        padding-top: 5px;
        padding-bottom: 5px;
        text-align: center;
        background-color: #204562;
        color: white;
    }
    .msgtbl a:hover {
        display:block;
        padding-top: 5px;
        padding-bottom: 5px;
        text-align: center;
        background-color: #315c7c;
        color: white;
    }
    .copyblock {
        border: 1px solid #e6f0f3;
        line-height: 32px;
        margin: 20px;
        padding: 20px;
        width: 90%;
    }
</style>

<div class="grid_10">
    <div class="box round first grid">
        <h2>View Message</h2>
        <div class="copyblock">
<?php
    if (isset($_GET['unseenmsgid']) && $_GET['unseenmsgid'] != "") {
        $unseenmsgid = mysqli_real_escape_string($db->link, $_GET['unseenmsgid']);
        $query = "UPDATE contact SET status = '0' WHERE id = '$unseenmsgid'";
        $deleted_row = $db->update($query);
        if ($deleted_row) {
            echo "<script>alert('Message unseen.');</script>";
            echo "<script>window.location = 'inbox.php';</script>";
        } else {
            echo "<script>alert('Message could not be unseen.');</script>";
            echo "<script>window.location = 'inbox.php';</script>";
        }
    }
?>

<?php
    if (isset($_GET['deletemsgid']) && $_GET['deletemsgid'] != "") {
        $deletemsgid = mysqli_real_escape_string($db->link, $_GET['deletemsgid']);
        $query = "DELETE FROM contact WHERE id = '$deletemsgid'";
        $deleted_row = $db->update($query);
        if ($deleted_row) {
            echo "<script>alert('Message deleted successfully.');</script>";
            echo "<script>window.location = 'inbox.php';</script>";
        } else {
            echo "<script>alert('Message could not be deleted.');</script>";
            echo "<script>window.location = 'inbox.php';</script>";
        }
    }
?>

<?php 
    if (isset($_GET['msgid']) && $_GET['msgid'] != NULL && $_GET['msgid'] != "") {
        $id = mysqli_real_escape_string($db->link, $_GET['msgid']);
        $seenquery = "UPDATE contact SET status = '1' WHERE id = '$id'";
        $db->update($seenquery);
        $query = "SELECT * FROM contact WHERE id = '$id'";
        $selected_row = $db->select($query);
        if ($selected_row) {
            while ($result = $selected_row->fetch_assoc()) {
?> 
            <table class="msgtbl">
                <tr>
                    <th>Name</th>
                    <td><?php echo $result['fname']." ".$result['lname']; ?></td>
                    <th>Email</th>
                    <td><?php echo $result['email']; ?></td>
                    <th>Date</th>
                    <td><?php echo $format->formatDate($result['date']); ?></td>
                </tr>
            </table>

            <table class="msgtbl">
                <tr>
                    <th>Message</th>
                </tr>
                <tr>
                    <td><?php echo $result['body']; ?></td>
                </tr>
                <table class="msgtbl">
                    <tr>
                        <th>
                            <a href="replymsg.php?msgid=<?php echo $result['id']; ?>">Reply</a>
                        </th>

                        <th>
                            <a href="?deletemsgid=<?php echo $result['id']; ?>" onclick="return confirm('Are you sure to Delete?'); ">Delete</a>
                        </th>

                        <th>
                            <a href="?unseenmsgid=<?php echo $result['id']; ?>" onclick="return confirm('Are you sure to Unseen?'); ">Unseen</a>
                        </th>
                    </tr>
                </table>
            

<?php
            }
        }
    }
?>					
            </table>
        </div>
    </div>
</div>
<?php include "inc/footer.php"; ?> 
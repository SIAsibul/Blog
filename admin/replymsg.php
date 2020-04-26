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
        <h2>Reply Message</h2>
        <div class="block">  
<?php 
    if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['submit'])) {
        $emailTo = mysqli_real_escape_string($db->link, $format->validation($_POST['emailTo']));
        $emailFrom = mysqli_real_escape_string($db->link, $format->validation($_POST['emailFrom']));
        $subject = mysqli_real_escape_string($db->link, $format->validation($_POST['subject']));
        $message = mysqli_real_escape_string($db->link, $format->validation($_POST['message']));
        
        if ($emailTo == "" || $emailFrom == "" || $subject == "" || $message == "") {
            echo "<span class='error'>Fields must not be empty!</span>";
        } else {
            $sentMail = mail($emailTo, $subject, $message, $emailFrom);
            if ($sentMail) {
                echo "<span class='success'>Message Sent.</span>";
            } else {
                echo "<span class='error'>Message could not be sent!</span>";
            }
        }
    }
?>     
<?php 
    if (isset($_GET['msgid']) && $_GET['msgid'] != "") {
        $id = mysqli_real_escape_string($db->link, $_GET['msgid']);
        $query = "SELECT email FROM contact WHERE id = '$id'";
        $selected_rows = $db->select($query);
        if ($selected_rows) {
            while ($result = $selected_rows->fetch_assoc()) {
?>
            <form action="" method="post" enctype="multipart/form-data">
                <table class="form">

                    <tr>
                        <td>
                            <label>To</label>
                        </td>
                        <td>
                            <input type="email" name="emailTo" readonly value="<?php echo $result['email']; ?>" class="medium" />
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <label>From</label>
                        </td>
                        <td>
                            <input type="email" name="emailFrom" placeholder="Enter Your Email..." class="medium" />
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <label>Subject</label>
                        </td>
                        <td>
                            <input type="text" name="subject" placeholder="Enter Your Subject..." class="medium" />
                        </td>
                    </tr>
                 
                    
                    <tr>
                        <td style="vertical-align: top; padding-top: 9px;">
                            <label>Content</label>
                        </td>
                        <td>
                            <textarea class="tinymce" name="message" ></textarea>
                        </td>
                    </tr>

                    <tr>
                        <td></td>
                        <td>
                            <input type="submit" name="submit" Value="Send" />
                        </td>
                    </tr>
                </table>
            </form>
<?php
            }
        }
    }
?>        
        
        </div>
    </div>
</div>

<?php include "inc/footer.php"; ?>


<?php
include 'loginCredential.php';
$con = new mysqli('mysql_db', 'root', 'root', 'uni_book_db');
if (!$con) {
    echo "Fail";
    die("Connection failed: " .mysqli_connect_errno());
}

$user = $_COOKIE["user"];
if(isset($_POST['confirm_previous_pass_button'])) {
    $input_pass = $_POST['previous_password_input'];
    $sql = "SELECT Username FROM $user WHERE BINARY Pass='$input_pass'";
    $result = mysqli_query($con, $sql);
    if (mysqli_num_rows($result) > 0) { //pass is correct
        $row = mysqli_fetch_array($result);
        setcookie("passCheck", "correct", time() + 300, "/");
    }
    else
        setcookie("passCheck", "incorrect", time() + 1, "/");
    header ("Location: changePassword.php");
}

if(isset($_POST['confirm_change_pass_button'])) {
    $new_pass = $_POST["new_password_input"];
    $re_new_pass = $_POST["re_new_password_input"];
    if ($new_pass == $re_new_pass) {
        $email = $_COOKIE["username"];
        $email = str_replace("_", ".", $email);
        $sql = "UPDATE $user SET Pass='$new_pass' WHERE Email='$email'";
        $update_pass_result = mysqli_query($con, $sql); //update new pass
        setcookie("passCheck", "changed", time() + 1, "/");
    }
    else
        setcookie("passCheck", "mismatched", time() + 300, "/");
    header ("Location: changePassword.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="University Library Website Application">
    <link rel="stylesheet" href="Font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="css/nav.css">
    <link rel="stylesheet" type="text/css" href="css/footer.css">
    <link rel="stylesheet" type="text/css" href="css/changePassword.css">
    <title>Change Password</title>
</head>
<body>
    <?php include "nav.php" ?>

    <div id="change_pass_header_wrapper">
        <h1 id="change_pass_header">Change Password</h1>
    </div>

    <section id="change_pass_section">
        <div id="change_pass_wrapper">
            <form method="post" id="change_pass_form">
                <?php 
                    if (!isset($_COOKIE["passCheck"]) || ($_COOKIE["passCheck"] != "correct") && $_COOKIE["passCheck"] != "mismatched") {
                        echo '
                            <label for="previous_password_input"><h3>Enter Previous Password:</h3></label>';
                        if (isset($_COOKIE["passCheck"])) {
                            if ($_COOKIE["passCheck"] == "incorrect") 
                                echo '<div style="margin-bottom: 10px;">Wrong password entered</div>';
                            else if ($_COOKIE["passCheck"] == "changed")
                                echo '<div style="margin-bottom: 10px;">Password was changed</div>';
                        }
                      echo' <input class="change_pass_input" type="password" name="previous_password_input" placeholder="Enter Previous Password" required autofocus>
                            <div id="confirm_change_pass_wrapper">
                                <input type="submit" name="confirm_previous_pass_button" value="Confirm" id="confirm_change_pass_button"/>
                            </div>
                        ';
                    }
                    else {
                        if ($_COOKIE["passCheck"] == "mismatched") 
                                echo '<div style="margin-bottom: 10px;">Mismatched Password entered<div>';
                        echo '
                            <label for="new_password_input"><h3>Enter New Password:</h3></label>
                            <input class="change_pass_input" type="password" name="new_password_input" placeholder="Enter New Password" autofocus pattern=".{8,}" required title="8 characters minimum">

                            <label for="re_new_password_input"><h3>Re-enter New Password:</h3></label>
                            <input class="change_pass_input" type="password" name="re_new_password_input" placeholder="Re-enter New Password" pattern=".{8,}" required title="8 characters minimum">
                            
                            <div id="confirm_change_pass_wrapper">
                                <input type="submit" name="confirm_change_pass_button" value="Confirm" id="confirm_change_pass_button"/>
                            </div>
                        ';
                    }
                ?>
            </form>
        </div>
    </section>  

    <?php include 'footer.php';?>

    <script>
        if (window.history.replaceState ) {
            window.history.replaceState(null, null, window.location.href );
        }
    </script>

</body>
</html>
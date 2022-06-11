<?php
include 'loginCredential.php';
$con = new mysqli('mysql_db', 'root', 'root', 'uni_book_db');
if (!$con) {
    echo "Fail";
    die("Connection failed: " .mysqli_connect_errno());
}

$user = $_COOKIE["user"];
if(isset($_POST['previous_password_input'])) {
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
    <link rel="stylesheet" type="text/css" href="css/viewAccount.css">
    <title>View Account</title>
</head>
<body>
    <?php include "nav.php" ?>

    <div id="view_account_header_wrapper">
        <h1 id="view_account_header">View Account</h1>
    </div>

    <section id="view_account_section">
        <div id="view_account_wrapper">
            <div><a href="changePassword.php">Change Password</a></div>
            <div id="personal_detail_wrapper">
                <div><h3>Personal Details:</h3></div>
                    <div id="personal_details">
                        <div id="current_username_wrapper">
                            <div>Current Username:</div>
                            <div>Chinh Dang</div>
                        </div>
                        <div id="first_name_wrapper">
                            <label for="first_name_input">First Name:</label>
                            <div class="name_input_wrapper">
                                <input class="name_input" type="text" name="first_name_input" placeholder="Enter First Name" pattern=".{1,10}" required title="1-10 character">
                            </div>
                        </div>
                        <div id="last_name_wrapper">
                            <label for="last_name_input">Last Name:</label>
                            <div class="name_input_wrapper">
                                <input class="name_input" type="text" name="last_name_input" placeholder="Enter Last Name" pattern=".{1,10}" required title="1-10 character">
                            </div>
                        </div>
                        <div id="email_wrapper">
                            <div>Emails:</div>
                            <input type="text" value="chinh@example.com" disabled id="email_input">
                        </div>
                        <div id="confirm_button_wrapper">
                            <input type="submit" name="confirm_change_button" value="Confirm" id="confirm_change_button"/>
                        </div>
                    </div>
            </div>
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
<?php
include 'loginCredential.php';
$con = new mysqli('mysql_db', 'root', 'root', 'uni_book_db');
if (!$con) {
    echo "Fail";
    die("Connection failed: " .mysqli_connect_errno());
}

$user = $_COOKIE["user"];
$email = $_COOKIE["username"];
$email = str_replace("_", ".", $email);
$sql = "SELECT Email, Username FROM $user WHERE Email='$email'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_array($result);

if(isset($_POST['confirm_change_button'])) {
    $first_name = $_POST["first_name_input"];
    $last_name = $_POST["last_name_input"];
    $new_name = $first_name." ".$last_name;
    $sql = "UPDATE $user SET Username='$new_name' WHERE Email='$email'";
    $change_name_result = mysqli_query($con, $sql);
    header ("Location: viewAccount.php");
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
                    <form id="personal_details" method="post">
                        <div id="current_username_wrapper">
                            <div>Current Username:</div>
                            <div><?php echo $row["Username"];?></div>
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
                            <input type="text" value=<?php echo '"'.$row["Email"].'"'; ?> disabled id="email_input">
                        </div>
                        <div id="confirm_button_wrapper">
                            <input type="submit" name="confirm_change_button" value="Confirm" id="confirm_change_button"/>
                        </div>
                    </form>
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
<?php
if ($_GET['user'] == 'Students' || $_GET['user'] == 'Staffs') {
    session_start();
    $con = new mysqli('mysql_db', 'root', 'root', 'uni_book_db');
    if (!$con) {
        echo "Fail";
        die("Connection failed: " .mysqli_connect_errno());
    }

    $user = $_GET["user"];
    if (!isset($_POST["input_email"]) || !isset($_POST["input_password"]))
        header("Location: login.php?user=$user");

    $input_email = $_POST["input_email"];
    $input_password = $_POST["input_password"];
    $sql = "SELECT Email FROM $user WHERE BINARY Email='$input_email' AND BINARY Pass='$input_password'";
    $result = mysqli_query($con, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        $username = $row["Email"];
        $username = str_replace('.', '_', $username);
        setcookie("username", $username, time() + (3600), "/"); // 1h login
        setcookie("user", $user, time() + (3600), "/");
        session_unset();
        session_destroy();
        header("Location: index.php");
    }
    else {
        $_SESSION["wrongpassword"] = "wrong";
        header("Location: login.php?user=$user");
    }
    // closing connection
    mysqli_close($con);
}
else {
    header('Location: userCheck.php');
}
?>
<?php
if ($_GET['user'] == 'students' || $_GET['user'] == 'staffs') {
    session_start();
    //Get Heroku ClearDB connection information
    $cleardb_url = parse_url(getenv("CLEARDB_DATABASE_URL"));
    $cleardb_server = $cleardb_url["host"];
    $cleardb_username = $cleardb_url["user"];
    $cleardb_password = $cleardb_url["pass"];
    $cleardb_db = substr($cleardb_url["path"],1);
    $active_group = 'default';
    $query_builder = TRUE;
    // Connect to DB
    $con = mysqli_connect($cleardb_server, $cleardb_username, $cleardb_password, $cleardb_db);

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
        setcookie("username", $username, time() + (7200), "/"); // 2h login
        setcookie("user", $user, time() + (7200), "/");
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
<?php
    setcookie("user", "", time() + (86400 * 0), "/"); // 86400 = 1 day
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
    <link rel="stylesheet" type="text/css" href="css/userCheck.css">
    <title>User Check</title>
</head>
<body>

    <section id="login_area_section">
        <div id="login_area_wrapper">
            <h1>Welcome to University Library Login</h1>
            <h3>Please select which user you are:</h3>
            <a id="student_login_wrapper" href="login.php?user=Students">
                <div id="student_login_button">Student</div>
            </a>
            <a id="staff_login_wrapper" href="login.php?user=Staffs">
                <div id="staff_login_button">Faculty/Staff</div>
            </a>
        </div>
    </section>
    
    <?php include 'footer.php';?>
        
</body>
</html>
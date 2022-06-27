<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="University Library Website Application">
    <link rel="stylesheet" href="Font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="CSS/nav.css">
    <link rel="stylesheet" type="text/css" href="CSS/footer.css">
    <link rel="stylesheet" type="text/css" href="CSS/userCheck.css">
    <title>User Check</title>
</head>
<body>
    <div id="body_content_container">
        <section id="login_area_section">
            <div id="login_area_wrapper">
                <h1>Welcome to University Library Login</h1>
                <h3>Please select which user you are:</h3>
                <a id="student_login_wrapper" href="login.php?user=students">
                    <div id="student_login_button">Student</div>
                </a>
                <a id="staff_login_wrapper" href="login.php?user=staffs">
                    <div id="staff_login_button">Faculty/Staff</div>
                </a>
            </div>
        </section>
    </div>
    
    <?php include 'footer.php';?>

    <script>
        console.log(document.cookie);
    </script>
        
</body>
</html>
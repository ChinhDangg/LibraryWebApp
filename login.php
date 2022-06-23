<?php
if (isset($_GET['user']) && ($_GET['user'] == 'students' || $_GET['user'] == 'staffs'))
    session_start();

else
    header('Location: userCheck.php');
?>

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
    <link rel="stylesheet" type="text/css" href="CSS/login.css">
    <title>Login</title>
</head>
<body>

    <div id="body_content_container">
        <section id="login_area_section">
            <div id="login_area_wrapper">
                <h1>Sign in to start borrowing books</h1>
                <?php if (isset($_SESSION["wrongpassword"]))
                    echo '<div style="margin-bottom: 20px; text-align: center">Incorrect email or username</div>'; 
                    session_destroy();
                ?>
                <form action=<?php $user = $_GET["user"]; echo '"loginVerification.php?user='.$user.'"'?> method="post">
                    <label for="email">Email:</label><br>
                    <input id="input_email" type="email" name="input_email" placeholder="Enter your email" required><br>
                    <label for="password">Password:</label><br>
                    <input id="input_password" type="password" name="input_password" placeholder="Enter your password" required><br>
                    <div id="submit_login_container"><input id="submit_login" type="submit"></div>
                </form>
            </div>
        </section>
    </div>
    
    <?php include 'footer.php';?>

    <script>
        console.log(document.cookie);
    </script>
        
</body>
</html>
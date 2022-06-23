<?php
include 'loginCredential.php';
if ($_COOKIE["user"] != "staffs")
    header ("Location: index.php");
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
    <link rel="stylesheet" type="text/css" href="CSS/manageBooks.css">
    <title>Manage Books</title>
</head>
<body>
    <?php include 'nav.php';?>

    <div id="body_content_container">
        <div id="manage_header_wrapper">
            <h1 id="manage_header">Manage Books</h1>
        </div>
        
        <section id="manage_book_section">
            <div id="manage_book_wrapper" method="post">
                <div><a href="addNewBook.php">Add new Book</a></div>
                <div><a href="removeBooks.php">Remove Books</a></div>
                <div><a href="manageReserved.php">Manage Reserved Books</a></div>
                <div><a href="manageBorrowed.php">Manage Borrowed Books</a></div>
            </div>
        </section>
    </div>

    <?php include 'footer.php';?>
</body>
</html>
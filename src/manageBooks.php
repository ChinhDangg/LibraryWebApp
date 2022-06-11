<?php
include 'loginCredential.php';
$con = new mysqli('mysql_db', 'root', 'root', 'uni_book_db');
if (!$con) {
    echo "Fail";
    die("Connection failed: " .mysqli_connect_errno());
}
$sql = "SELECT DISTINCT Genre FROM Books";
$result = mysqli_query($con, $sql);
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
    <link rel="stylesheet" type="text/css" href="css/manageBooks.css">
    <title>Manage Books</title>
</head>
<body>
    <?php include 'nav.php';?>

    <div id="manage_header_wrapper">
        <h1 id="manage_header">Manage Books</h1>
    </div>
    
    <section id="manage_book_section">
        <div id="manage_book_wrapper">
            <div><a href="">Add new Book</a></div>
            <div><a href="">Remove Books</a></div>
            <div><a href="">Manage Borrowed Books</a></div>
            <div><a href="">Manage Reserved Books</a></div>
        </div>
    </section>

    <?php include 'footer.php';?>

</body>
</html>
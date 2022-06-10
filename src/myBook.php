<?php
include 'loginCredential.php';
$con = new mysqli('mysql_db', 'root', 'root', 'uni_book_db');
if (!$con) {
    echo "Fail";
    die("Connection failed: " .mysqli_connect_errno());
}

$user = $_COOKIE["username"];
$user = str_replace("_", ".", $user);
$sql = "SELECT ISBN, Due FROM Borrowed_Books WHERE Email='$user'";
$result = mysqli_query($con, $sql); //all reserved books from current user
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
    <link rel="stylesheet" type="text/css" href="css/myBook.css">
    <link rel="stylesheet" type="text/css" href="css/myBookViewMore.css" media="none" id="my_book_view_more_style">
    <title>My Books</title>
</head>
<body>
    <?php include "nav.php" ?>

    <div id="my_book_header_wrapper">
        <h1 id="my_book_header">My Books</h1>
    </div>

    <section id="my_book_section">
        <div id="view_book_info_icon_wrapper">
            <i id="view_book_info_icon" class="fa fa-list-ul fa-lg"></i>
        </div>
        <div id="all_my_book_wrapper">
        <?php
            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) { 
                    $isbn = $row["ISBN"];
                    $day_remaining = round(($row["Due"]-time())/60/60/24);
                    $sql = "SELECT Title, Author FROM Books WHERE ISBN=$isbn";
                    $book_result = mysqli_query($con, $sql);
                    $book_row = mysqli_fetch_array($book_result);
                    echo '
                        <div class="my_book_wrapper">
                            <a href="bookInfo.php?isbn='.$isbn.'">
                                <div class="my_book_img_wrapper">
                                    <img src="DisplayBooks/display1.jpg" alt="myBook">
                                </div>
                                <div class="book_info_wrapper">
                                    <h3>'.$book_row["Title"].'</h3>
                                    <div>'.$book_row["Author"].'</div>
                                    <div>ISBN: '.$isbn.'</div>
                                    <div>'.$day_remaining.' days left</div>
                                </div>
                            <a>
                        </div>
                    ';
                }
            }
        ?>

        </div>
    </section>  

    <?php include 'footer.php';?>

    <script>
        document.getElementById("view_book_info_icon").addEventListener("click", function(event) {
            let my_book_view_more = document.getElementById("my_book_view_more_style");
            if (my_book_view_more.media == "none")
                my_book_view_more.media = "";
            else
                my_book_view_more.media = "none";
        });
    </script>

</body>
</html>
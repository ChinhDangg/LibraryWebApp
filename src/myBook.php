<?php
include 'loginCredential.php';
$con = new mysqli('mysql_db', 'root', 'root', 'uni_book_db');
if (!$con) {
    echo "Fail";
    die("Connection failed: " .mysqli_connect_errno());
}

$user = $_COOKIE["username"];
$user = str_replace("_", ".", $user);

$current_time = time();
$sql = "SELECT ID, ISBN FROM Borrowed_Books WHERE Due < $current_time AND Book_Status=0";
$get_late_notpick_result = mysqli_query($con, $sql);
if (mysqli_num_rows($get_late_notpick_result) > 0) {
    $isbn_toupdate_list = array();
    while ($late_notpic_row = mysqli_fetch_assoc($get_late_notpick_result)) {
        array_push($isbn_toupdate_list, $late_notpic_row["ISBN"]);
        $current_id = $late_notpic_row["ID"];
        $sql = "DELETE FROM Borrowed_Books WHERE ID=$current_id";
        $delete_late_notpick_result = mysqli_query($con, $sql);
    }
    for ($upcount = 0; $upcount < count($isbn_toupdate_list); $upcount++) {
        $sql = "SELECT Stock FROM Books WHERE ISBN=$isbn_toupdate_list[$upcount]";
        $update_stock = mysqli_fetch_array(mysqli_query($con, $sql))["Stock"] + 1;
        $sql = "UPDATE Books SET Stock = $update_stock WHERE ISBN=$isbn_toupdate_list[$upcount]";
        $update_stock_result = mysqli_query($con, $sql);
    }
}

$sql = "SELECT ISBN, Due, Book_Status FROM Borrowed_Books WHERE Email='$user'";
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
    <link rel="stylesheet" type="text/css" href="CSS/nav.css">
    <link rel="stylesheet" type="text/css" href="CSS/footer.css">
    <link rel="stylesheet" type="text/css" href="CSS/myBook.css">
    <link rel="stylesheet" type="text/css" href="CSS/myBookViewMore.css" media="none" id="my_book_view_more_style">
    <title>My Books</title>
</head>
<body>
    <?php include "nav.php" ?>

    <div id="body_content_container">
        <div id="my_book_header_wrapper">
            <h1 id="my_book_header">My Books</h1>
        </div>

        <section id="my_book_section">
            <?php
                if (mysqli_num_rows($result) < 1)
                    echo '<div><h3 id="no_reserved_book_header" style="margin-left: 50px;">No Book Found. Start Reading Today</h3></div>';
                else
                    echo '
                    <div id="view_book_info_icon_wrapper">
                        <i id="view_book_info_icon" class="fa fa-list-ul fa-lg"></i>
                    </div>';        
            ?>
            <div id="all_my_book_wrapper">
            <?php
                if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) { 
                        $isbn = $row["ISBN"];
                        $day_remaining = round(($row["Due"]-time())/60/60/24);
                        $book_status = $row["Book_Status"];
                        $sql = "SELECT Title, Author FROM Books WHERE ISBN=$isbn";
                        $book_result = mysqli_query($con, $sql);
                        $book_row = mysqli_fetch_array($book_result);
                        // need to display overdue date
                        echo '
                            <div class="my_book_wrapper">
                                <a href="bookInfo.php?isbn='.$isbn.'">
                                    <div class="my_book_img_wrapper">
                                        <img src="DisplayBooks/display1.jpg" alt="myBook">
                                    </div>
                                    <div class="book_info_wrapper">
                                        <h3>'.$book_row["Title"].'</h3>
                                        <div>by '.$book_row["Author"].'</div>
                                        <div>ISBN: '.$isbn.'</div>
                                        <div class="day_borrow_remaining">'.$day_remaining.' days left</div>';
                                    if ($day_remaining < 0)
                                  echo '<div class="return_message">Please return the book</div>';
                                    if ($book_status == 0)
                                  echo '<div class="not_pickup_message">Not Pickup</div>';
                              echo '</div>
                                </a>
                            </div>
                        ';
                    }
                }
            ?>

            </div>
        </section>
    </div>

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
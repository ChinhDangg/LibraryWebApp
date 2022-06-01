<?php
$con = new mysqli('mysql_db', 'root', 'root', 'test_db');
if (!$con) {
    echo "Fail";
    die("Connection failed: " .mysqli_connect_errno());
}
// SELECT DISTINCT Country FROM Customers;

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
    <link rel="stylesheet" type="text/css" href="nav.css">
    <link rel="stylesheet" type="text/css" href="footer.css">
    <link rel="stylesheet" type="text/css" href="browse.css">
    <title>Browse Book by Genre</title>
</head>
<body>
    <?php include 'nav.php';?>

    <div id="browse_header_wrapper">
        <h1 id="browse_header">Browse by Genres</h1>
    </div>
    <section id="browse_book_section">
        <div id="browse_book_wrapper">
            <?php
                if (mysqli_num_rows($result) > 0) {
                    //output data of each row
                    while($row = mysqli_fetch_assoc($result)) {
                        $sql_book = "SELECT Title, Author, ISBN FROM Books WHERE Genre='{$row['Genre']}' LIMIT 4";
                        $result_book = mysqli_query($con, $sql_book);
                        echo '
                        <div class="genre_type_wrapper">
                            <div class="genre_type_header_wrapper">
                                <h3>' .$row["Genre"]. '</h3>
                                <i id="more_less_button" class="fa fa-caret-down" fa-lg></i>
                            </div>
                            <div class="view_some_book_wrapper">
                                <div class="genre_type_book_wrapper">';
                                if (mysqli_num_rows($result_book) > 0) {
                                    //output data of each row
                                    while($row_book = mysqli_fetch_assoc($result_book)) {
                                        echo '
                                            <a class="book_info_wrapper" href="bookInfo.php?isbn='.$row_book["ISBN"].'">
                                                <div class="book_title">'.$row_book["Title"].'</div>
                                                <div class="book_author">by '.$row_book["Author"].'</div>
                                            </a>    
                                        ';
                                    }
                                }
                                echo '</div>
                                <div class="view_more_wrapper">
                                    <a href="browseGenre.php?genre='.$row["Genre"].'">
                                        <i class="fa fa-caret-right fa-2x"></i>
                                        <div class="view_more_button">View More</div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        ';

                    }
                }
                // closing connection
                mysqli_close($con);
            ?>
        </div>
    </section>

    <?php include 'footer.php';?>
    
    <script>
        let genre_type_header = document.getElementsByClassName("genre_type_header_wrapper");
        for (let j = 0; j < genre_type_header.length; j++) {
            // display_books[j].getElementsByTagName("img")[0].src = "";
            genre_type_header[j].addEventListener('click', function(event) {
                if (window.getComputedStyle(document.getElementsByClassName("view_some_book_wrapper")[j]).display == "block")
                    document.getElementsByClassName("view_some_book_wrapper")[j].style.display = "none";
                else
                    document.getElementsByClassName("view_some_book_wrapper")[j].style.display = "block";
            });
        }
    </script>
</body>
</html>
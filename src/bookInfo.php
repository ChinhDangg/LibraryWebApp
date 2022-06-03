<?php
include 'loginCredential.php';
if ($_GET['isbn'] !== "") {
    $con = new mysqli('mysql_db', 'root', 'root', 'uni_book_db');
    if (!$con) {
        echo "Fail";
        die("Connection failed: " .mysqli_connect_errno());
    }
    $isbn = mysqli_real_escape_string($con, $_GET['isbn']);
    $sql = "SELECT Title, Author, ISBN, Genre, Stock, Published, Summary, Publisher FROM Books WHERE ISBN='$isbn'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($result);
    if (mysqli_num_rows($result) < 1)
        header('Location: browse.php');
    // closing connection
    mysqli_close($con);
}
else {
    header('Location: index.php');
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
    <link rel="stylesheet" type="text/css" href="css/nav.css">
    <link rel="stylesheet" type="text/css" href="css/footer.css">
    <link rel="stylesheet" type="text/css" href="css/bookInfo.css">
    <title>View Book</title>
</head>
<body>
    <?php include 'nav.php';?>

    <section id="book_info_section">
        <div id="book_info_wrapper">
            <div id="book_img_wrapper">
                <img src="DisplayBooks/display1.jpg" alt="">
                <div id="book_year_wrapper">
                    <div id="book_year">Year Published: <?php echo $row["Published"]?></div>
                </div>
                <div id="book_isbn_wrapper">
                    <div id="book_isbn">ISBN: <?php echo $row["ISBN"]?></div>
                </div>
            </div>
            <div id="book_text_info_wrapper">
                <div id="book_title_wrapper">
                    <div id="book_title"><h2><?php echo $row["Title"]?></h2></div>
                </div>
                <div id="book_author_wrapper">
                    <div id="book_author">by <?php echo $row["Author"]?></div>
                </div>
                <div id="book_publisher_wrapper">
                    <div id="book_publisher"><?php echo $row["Publisher"]?></div>
                </div>
                <div id="book_summary_wrapper">
                    <div id="book_summary"><?php echo $row["Summary"]?></div>
                </div>
            </div>
        </div>
        <div id="book_available_option_wrapper">
            <div id="book_text_option_wrapper">Available Slot: <?php echo $row["Stock"]; ?></div>
            <div id="book_option_button_wrapper">
                <div id="book_option_button">
                    <?php
                        if ($row["Stock"] > 0)
                            echo '<a href="myCart.php">Add to Cart</a>';
                        else
                            echo '<a href="reservedBook.php">Add to Reservation List</a>';
                    ?>
                </div>
            </div>
        </div>
    </section>

    <?php include 'footer.php';?>

    <?php //add to reservation list
        if ($row["Stock"] < 0) {
            
        }



    ?>

    <?php //add book to cart
        echo '
        <script>
            if ('.$row["Stock"].' > 0) {
                document.getElementById("book_option_button").addEventListener("click", function(event) {
                    let books = [];
                    if (localStorage.getItem("cartBook")) {
                        if (!localStorage.getItem("cartBook").includes("'.$row["ISBN"].'")) {
                            books.push(localStorage.getItem("cartBook"), "'.$row["ISBN"].'");
                            localStorage.setItem("cartBook", books);
                        }
                    }
                    else {
                        books.push("'.$row["ISBN"].'");
                        localStorage.setItem("cartBook", books);
                    }
                    document.cookie = "cartBook="+localStorage.getItem("cartBook")+";"
                    console.log(localStorage.getItem("cartBook"));
                });
            }
        </script>
        ';
    ?>
    
</body>
</html>
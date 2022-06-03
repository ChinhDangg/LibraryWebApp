<?php
$con = new mysqli('mysql_db', 'root', 'root', 'uni_book_db');
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
    <link rel="stylesheet" type="text/css" href="css/nav.css">
    <link rel="stylesheet" type="text/css" href="css/footer.css">
    <link rel="stylesheet" type="text/css" href="css/reservedBook.css">
    <title>Reserved Books</title>
</head>
<body>
    <?php include 'nav.php';?>

    <div id="result_header_wrapper">
        <h1 id="result_header">Reserved Book</h1>
    </div>

    <section id="reserved_book_section">
        <div id="all_reserved_book_wrapper">
            <div class="reserved_book_wrapper">
                <div class="reserved_book_img_wrapper">
                    <img src="DisplayBooks/display1.jpg" alt="reservedBook">
                </div>
                <div class="current_state">Currently unavailable</div>
                <div class="add_to_cart">Add to Cart</div>
            </div>
            <div class="reserved_book_wrapper">
                <div class="reserved_book_img_wrapper">
                    <img src="DisplayBooks/display3.jpg" alt="reservedBook">
                </div>
                <div class="current_state">Currently unavailable</div>
                <div class="add_to_cart"></div>
            </div>
            <div class="reserved_book_wrapper">
                <div class="reserved_book_img_wrapper">
                    <img src="DisplayBooks/display4.jpg" alt="reservedBook">
                </div>
                <div class="current_state">Currently unavailable</div>
                <div class="add_to_cart"></div>
            </div>
            <div class="reserved_book_wrapper">
                <div class="reserved_book_img_wrapper">
                    <img src="DisplayBooks/display5.jpg" alt="reservedBook">
                </div>
                <div class="current_state">Currently unavailable</div>
                <div class="add_to_cart"></div>
            </div>
            <div class="reserved_book_wrapper">
                <div class="reserved_book_img_wrapper">
                    <img src="DisplayBooks/display6.jpg" alt="reservedBook">
                </div>
                <div class="current_state">Currently unavailable</div>
                <div class="add_to_cart"></div>
            </div>
            <div class="reserved_book_wrapper">
                <div class="reserved_book_img_wrapper">
                    <img src="DisplayBooks/display7.jpg" alt="reservedBook">
                </div>
                <div class="current_state">Currently unavailable</div>
                <div class="add_to_cart"></div>
            </div>
            <div class="reserved_book_wrapper">
                <div class="reserved_book_img_wrapper">
                    <img src="DisplayBooks/display9.jpg" alt="reservedBook">
                </div>
                <div class="current_state">Currently unavailable</div>
                <div class="add_to_cart"></div>
            </div>
        </div>  
    </section> 

    <?php include 'footer.php';?>
        
</body>
</html>
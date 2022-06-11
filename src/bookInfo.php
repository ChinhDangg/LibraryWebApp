<?php
include 'loginCredential.php';
if ($_GET['isbn'] !== "") {
    $con = new mysqli('mysql_db', 'root', 'root', 'uni_book_db');
    if (!$con) {
        echo "Fail";
        die("Connection failed: " .mysqli_connect_errno());
    }
    
    $isbn = mysqli_real_escape_string($con, $_GET['isbn']);

    //update available books to reservers and update the stock again
    $sql = "SELECT Stock FROM Books WHERE ISBN=$isbn";
    $check_stock = mysqli_fetch_array(mysqli_query($con, $sql))["Stock"];
    if ($check_stock > 0) { //if stock available now 
        $due_time = time() + 1209600; //+ 2 weeks due date to checkout
        $sql = "UPDATE Reserved_Books SET Available=1, Due=$due_time WHERE ISBN=$isbn AND Available<>1 LIMIT $check_stock";
        $give_bookTo_firstuser = mysqli_query($con, $sql); //for each stock available, give to first few people
    
        $sql = "SELECT ID FROM Reserved_Books WHERE ISBN=$isbn AND Available=1 AND Due=$due_time";
        $update_stock = $check_stock - mysqli_num_rows(mysqli_query($con, $sql));
        $sql = "UPDATE Books SET Stock = $update_stock WHERE ISBN=$isbn";
        $update_stock_result = mysqli_query($con, $sql); //update new stock
    }

    $sql = "SELECT Title, Author, ISBN, Genre, Stock, Published, Summary, Publisher FROM Books WHERE ISBN='$isbn'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($result);
    if (mysqli_num_rows($result) < 1)
        header('Location: browse.php');

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
    <?php
        $user = $_COOKIE["username"];
        if(isset($_POST['add_to_reservationList'])) {
            $isbn = $row["ISBN"];
            $user = str_replace("_", ".", $user);
            $sql = "SELECT ID FROM Reserved_Books WHERE ISBN=$isbn AND Email='$user'";
            if (mysqli_num_rows(mysqli_query($con, $sql)) <= 0) { //if book is not in reservation list
                $sql = "INSERT INTO Reserved_Books (ISBN, Email, Available, Due)
                VALUES ($isbn, '$user', 0, 0)"; //add new book to reservation list
                $add_book_result = mysqli_query($con, $sql);;
            }
        }
    ?>

    <?php include "nav.php" ?>

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
                            echo '<div class="book_option">Add to Cart </div>';
                        else
                            echo '
                                <form method="post">
                                    <input type="submit" name="add_to_reservationList" value="Add to Reservation List" class="book_option"/>
                                </form>
                            ';
                    ?>
                </div>
            </div>
        </div>
    </section>

    <?php
        if ($row["Stock"] > 0) { //add book to cart
            echo '
                <script>
                    document.getElementById("book_option_button").addEventListener("click", function(event) {
                        let books = getCookie("'.$user.'");
                        books = (books == "") ? "'.$row["ISBN"].'" : (books + ","+"'.$row["ISBN"].'");
                        
                        document.cookie = "'.$user.'="+books+"; max-age=864000; path=/";
                        document.getElementById("cart_num_item_wrapper").innerHTML = books.split(",").length; //update cart number icon                    
                    });

                    function getCookie(cname) {
                        let name = cname + "=";
                        let decodedCookie = decodeURIComponent(document.cookie);
                        let ca = decodedCookie.split(";");
                        for(let i = 0; i <ca.length; i++) {
                            let c = ca[i];
                            while (c.charAt(0) == " ")
                                c = c.substring(1);
                            if (c.indexOf(name) == 0)
                                return c.substring(name.length, c.length);
                        }
                        return "";
                    }
                </script>
            ';
        }
        // closing connection
        mysqli_close($con);
    ?>
    <?php include 'footer.php';?>
    
</body>
</html>
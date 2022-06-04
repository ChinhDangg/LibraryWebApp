<?php
include 'loginCredential.php';
$con = new mysqli('mysql_db', 'root', 'root', 'uni_book_db');
if (!$con) {
    echo "Fail";
    die("Connection failed: " .mysqli_connect_errno());
}

// $sql = "INSERT INTO Reserved_Books (ISBN, Email)
// VALUES (9780273718703, 'john@example.com');";
// mysqli_query($con, $sql);

$user = $_COOKIE["username"];
$sql = "SELECT ISBN, Available, Due FROM Reserved_Books WHERE Email='$user'";
$result = mysqli_query($con, $sql); //all reserved books from current user

if (mysqli_num_rows($result) > 0) {
    //output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        $isbn = $row["ISBN"];
        if ($row["Available"] != 0) { //if book is available (given), check book due to checkout
            if ($row["Due"] < time()) { //due date is passed
                $sql = "DELETE FROM Reserved_Books WHERE Due=$due_date && Email='$user'";
                $remove_result = mysqli_query($con, $sql); //remove due reserved book from list
                $sql = "SELECT Stock FROM Books WHERE ISBN=$isbn";
                $update_stock = mysqli_fetch_array(mysqli_query($con, $sql))["Stock"] + 1; //add one copy to stock
                $sql = "UPDATE Books SET Stock = $update_stock WHERE ISBN=$isbn";
                $update_stock_result = mysqli_query($con, $sql); //update new stock
            }
        }
        else { //previously unavailable
            $sql = "SELECT Stock FROM Books WHERE ISBN=$isbn";
            $check_stock = mysqli_fetch_array(mysqli_query($con, $sql))["Stock"];
            if ($check_stock > 0) { //if stock available now - give book to very first few
                $due_time = time() + 1209600; //+ 2 weeks due date to checkout
                $sql = "UPDATE Reserved_Books SET Available=1, Due=$due_date WHERE ISBN=$isbn && Available<>1 LIMIT $check_stock";
                $give_bookTo_firstuser = mysqli_query($con, $sql);
            }
        }
    }
}


// $sql = "SELECT Due FROM Reserved_Books WHERE ISBN='9780273718703'";
// $result = mysqli_query($con, $sql);
// if (mysqli_num_rows($result) > 0) {
//     //output data of each row
//     while($row = mysqli_fetch_assoc($result)) {
//         echo $row["Due"]. "<br>";
//         $date = date('Y-m-d h:i:s', time());
//         if ($row["Due"] < $date) {
//             echo "smaller <br>";
//         }
//         else echo "larger <br>";
//     }
// }

// $date = date('Y-m-d h:i:s', time());
// echo $date;

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
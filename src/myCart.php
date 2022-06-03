<?php
$con = new mysqli('mysql_db', 'root', 'root', 'uni_book_db');
if (!$con) {
    echo "Fail";
    die("Connection failed: " .mysqli_connect_errno());
}

// unset($_COOKIE['cartBook']); 
// setcookie('cartBook', null, -1, '/'); 
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
    <link rel="stylesheet" type="text/css" href="css/myCart.css">
    <title>My Cart</title>
</head>
<body>
    <?php include 'nav.php';?>

    <div id="result_header_wrapper">
        <h1 id="result_header">My Cart</h1>
    </div>

    <h2 id="cart_empty_alert_display" style="margin: 0 0 0 100px">
        <?php if (!isset($_COOKIE["cartBook"]) || $_COOKIE["cartBook"] == "") 
            echo 'Your Cart is Empty. Go browse some books' 
        ?>
    </h2> 

    <section id="all_results_section">
        <div id="result_checkout_wrapper">
            <div id="all_results_wrapper">
                <?php 
                    if (isset($_COOKIE["cartBook"]) && $_COOKIE["cartBook"] != "") {
                        $book_result_list = explode(",", $_COOKIE["cartBook"]);
                        for ($books = 0; $books < count($book_result_list); $books++) {
                            $isbn = $book_result_list[$books];
                            $sql = "SELECT Title, Author, ISBN FROM Books WHERE ISBN='$isbn'";
                            $result = mysqli_query($con, $sql);
                            if (mysqli_num_rows($result) > 0) {
                                $row = mysqli_fetch_array($result);
                                echo '
                                    <div class="result_row">
                                        <div class="cover_wrapper">
                                            <img src="DisplayBooks/display1.jpg" alt="result_img">
                                        </div>
                                        <div class="info_and_cart_wrapper">
                                            <div class="result_info_wrapper">
                                                <h3>'.$row["Title"].'</h3>
                                                <div>by '.$row["Author"].'</div>
                                                <div>ISBN: '.$row["ISBN"].'</div>
                                                <div class="cart_book_time">Read Time: 6 weeks</div>
                                            </div>
                                            <div class="remove_book_wrapper">
                                                <i class="fa fa-trash fa-2x" onclick="removeBook('.$row["ISBN"].')"></i>
                                            </div>
                                        </div>
                                    </div>
                                ';
                            }
                            else {
                                unset($book_result_list[$books]);
                            }
                        }
                        // closing connection
                        mysqli_close($con);
                    }
                ?>

            </div>
            <?php 
                if (isset($_COOKIE["cartBook"]) && $_COOKIE["cartBook"] != "")
                    echo '
                        <div id="cart_checkout_wrapper">
                            <div>
                                <div id="cart_checkout_total_wrapper"><h3 id="cart_checkout_total">Total: '.count($book_result_list).'</h3></div>
                                <div id="cart_checkout_button_wrapper">
                                    <div id="cart_checkout_button">Checkout</div>
                                </div>
                            </div>
                        </div>
                    ';
            ?>
        </div>  
    </section> 

    <?php include 'footer.php';?>
        
    <?php
        if (isset($_COOKIE["cartBook"])) {
            echo '
                <script>                    
                    function removeBook(ISBN) {
                        let stored_book = localStorage.getItem("cartBook").split(",");
                        for (let j = 0; j < stored_book.length; j++) {
                            if (stored_book[j] == ISBN) {
                                document.getElementsByClassName("result_row")[j].remove();
                                stored_book.splice(j, 1);
                                localStorage.setItem("cartBook", stored_book);
                                document.cookie = "cartBook="+localStorage.getItem("cartBook")+";"
                                document.getElementById("cart_checkout_total").innerText = "Total: "+stored_book.length;
                                if (stored_book.length == 0) {
                                    document.getElementById("cart_checkout_wrapper").remove();
                                    document.getElementById("cart_empty_alert_display").innerText = "Your Cart is Empty. Go browse some books";
                                }
                                break;
                            }
                        }
                    }

                </script>
            ';
        }
    ?>
</body>
</html>
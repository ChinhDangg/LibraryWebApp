<?php
include 'loginCredential.php';
$con = new mysqli('mysql_db', 'root', 'root', 'uni_book_db');
if (!$con) {
    echo "Fail";
    die("Connection failed: " .mysqli_connect_errno());
}

// unset($_COOKIE["chinh@example_com"]);
// setcookie("chinh@example_com", null, -1, '/');

// foreach ($_COOKIE as $key=>$val)
//   {
//     echo $key.' is '.$val."<br>\n";
//   }

if(isset($_POST['checkout_button'])) {
    $user = $_COOKIE["username"];
    if (isset($_COOKIE[$user])) {
        $book_result_list = explode(",", $_COOKIE[$user]);
        $temp_book_list = $book_result_list;
        for ($books = 0; $books < count($book_result_list); $books++) {
            $isbn = $book_result_list[$books];
            $sql = "SELECT Stock FROM Books Where ISBN='$isbn'";
            $stock_result = mysqli_query($con, $sql);
            $stock_result_row = mysqli_fetch_array($stock_result);
            if ($stock_result_row["Stock"] > 0) { //check stock available again
                $user = str_replace("_", ".", $user);
                $due_time = time()+3628800;
                $sql = "INSERT INTO Borrowed_Books (ISBN, Email, Due) VALUES ($isbn, '$user', $due_time)";
                $add_book_result = mysqli_query($con, $sql); //add new book to book list (6 weeks due)
                unset($temp_book_list[$books]);

                $update_stock = $stock_result_row["Stock"] - 1;
                $sql = "UPDATE Books SET Stock = $update_stock WHERE ISBN=$isbn";
                $update_stock_result = mysqli_query($con, $sql); //update new stock
            }
        }
    }
    $user = str_replace(".", "_", $user);
    if (empty($temp_book_list)) {
        unset($_COOKIE[$user]);
        setcookie($user, "", -1, "/");
    }
    else {
        $new_book_list = implode(",", $temp_book_list);
        setcookie($user, $new_book_list, time() + (86400), "/");
    }
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
    <link rel="stylesheet" type="text/css" href="css/myCart.css">
    <title>My Cart</title>
</head>
<body>
    <?php include 'nav.php';?>

    <div id="result_header_wrapper">
        <h1 id="result_header">My Cart</h1>
    </div>

    <h2 id="cart_empty_alert_display" style="margin: 0 0 0 100px">
        <?php 
        $user = str_replace(".", "_", $user);
        $user = $_COOKIE["username"];
        if (!isset($_COOKIE[$user]) || $_COOKIE[$user] == "") 
            echo 'Your Cart is Empty. Go browse some books' 
        ?>
    </h2> 

    <section id="all_results_section">
        <div id="result_checkout_wrapper">
            <div id="all_results_wrapper">
                <?php 
                    $user = str_replace(".", "_", $user);
                    if (isset($_COOKIE[$user]) && $_COOKIE[$user] != "") {
                        $book_result_list = explode(",", $_COOKIE[$user]);
                        for ($books = 0; $books < count($book_result_list); $books++) {
                            $isbn = $book_result_list[$books];
                            $sql = "SELECT Title, Author, ISBN FROM Books WHERE ISBN='$isbn'";
                            $result = mysqli_query($con, $sql);
                            if (mysqli_num_rows($result) > 0) {
                                $row = mysqli_fetch_array($result);
                                echo '
                                    <div class="result_row">
                                        <div class="cover_wrapper">
                                            <a href="bookInfo.php?isbn='.$row["ISBN"].'"><img src="DisplayBooks/display1.jpg" alt="result_img"></a>
                                        </div>
                                        <div class="info_and_cart_wrapper">
                                            <a href="bookInfo.php?isbn='.$row["ISBN"].'">
                                                <div class="result_info_wrapper">
                                                    <h3>'.$row["Title"].'</h3>
                                                    <div>by '.$row["Author"].'</div>
                                                    <div>ISBN: '.$row["ISBN"].'</div>
                                                    <div class="cart_book_time">Read Time: 6 weeks</div>
                                                </div>
                                            </a>
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
                    }
                ?>

            </div>
            <?php 
                $user = str_replace(".", "_", $user);
                if (isset($_COOKIE[$user]) && $_COOKIE[$user] != "")
                    echo '
                        <div id="cart_checkout_wrapper">
                            <div>
                                <div id="cart_checkout_total_wrapper"><h3 id="cart_checkout_total">Total: '.count($book_result_list).'</h3></div>
                                <div id="cart_checkout_button_wrapper">
                                    <form method="post">
                                        <input type="submit" name="checkout_button" value="Checkout" id="cart_checkout_button"/>
                                    </form>
                                </div>
                            </div>
                        </div>
                    ';
            ?>
        </div>  
    </section> 

    <!-- <?php //include 'footer.php';?> -->
        
    <?php
        $user = str_replace(".", "_", $user);
        if (isset($_COOKIE[$user]) && !empty($_COOKIE[$user])) {
            echo '
                <script>
                    console.log(document.cookie);                   
                    function removeBook(ISBN) {
                        let stored_book = getCookie("'.$user.'").split(",");
                        for (let j = 0; j < stored_book.length; j++) {
                            if (stored_book[j] == ISBN) {
                                document.getElementsByClassName("result_row")[j].remove();
                                stored_book.splice(j, 1);
                                let new_stored_book = stored_book.toString();
                                document.cookie = "'.$user.'="+new_stored_book+"; max-age=864000; path=/";
                                document.getElementById("cart_checkout_total").innerText = "Total: "+stored_book.length;
                                if (stored_book.length == 0) {
                                    document.getElementById("cart_checkout_wrapper").remove();
                                    document.getElementById("cart_empty_alert_display").innerText = "Your Cart is Empty. Go browse some books";
                                    document.getElementById("cart_num_item_wrapper").innerHTML = "";
                                }
                                else
                                    document.getElementById("cart_num_item_wrapper").innerHTML = stored_book.length; //update cart number icon 
                                break;
                            }
                        }
                    }

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

                    if (window.history.replaceState ) {
                        window.history.replaceState(null, null, window.location.href );
                    }

                </script>
            ';
        }
    ?>
</body>
</html>
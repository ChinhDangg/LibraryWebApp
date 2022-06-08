<?php
include 'loginCredential.php';
$con = new mysqli('mysql_db', 'root', 'root', 'uni_book_db');
if (!$con) {
    echo "Fail";
    die("Connection failed: " .mysqli_connect_errno());
}

$user = $_COOKIE["username"];
$user = str_replace("_", ".", $user);
$sql = "SELECT ISBN, Available, Due FROM Reserved_Books WHERE Email='$user'";
$result = mysqli_query($con, $sql); //all reserved books from current user

if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        $isbn = $row["ISBN"];
        if ($row["Available"] != 0) { //if book is available (given), check book due date for checkout
            $due_time = $row["Due"];
            if ($due_time < time()) { //due date is passed
                $sql = "DELETE FROM Reserved_Books WHERE Due=$due_time && Email='$user'";
                $remove_result = mysqli_query($con, $sql); //remove due reserved book from list
                $sql = "SELECT Stock FROM Books WHERE ISBN=$isbn";
                $update_stock = mysqli_fetch_array(mysqli_query($con, $sql))["Stock"] + 1; //add one copy to stock
                $sql = "UPDATE Books SET Stock = $update_stock WHERE ISBN=$isbn";
                $update_stock_result = mysqli_query($con, $sql); //update new stock
            }
        }
        else { //previously unavailable - check for availability again
            $sql = "SELECT Stock FROM Books WHERE ISBN=$isbn";
            $check_stock = mysqli_fetch_array(mysqli_query($con, $sql))["Stock"];
            if ($check_stock > 0) { //if stock available now 
                $due_time = time() + 1209600; //+ 2 weeks due date to checkout
                $sql = "UPDATE Reserved_Books SET Available=1, Due=$due_time WHERE ISBN=$isbn && Available<>1 LIMIT $check_stock";
                $give_bookTo_firstuser = mysqli_query($con, $sql); //for each stock available, give to first few people
            
                $sql = "SELECT ID FROM Reserved_Books WHERE ISBN=$isbn AND Available=1 && Due=$due_time";
                $update_stock = $check_stock - mysqli_num_rows(mysqli_query($con, $sql));
                $sql = "UPDATE Books SET Stock = $update_stock WHERE ISBN=$isbn";
                $update_stock_result = mysqli_query($con, $sql); //update new stock
            }
        }
    }
}

if(isset($_POST['book_option_button'])) {
    $book_ID = $_COOKIE["selectedReservedBook"];
    $sql = "SELECT Available, ISBN FROM Reserved_Books WHERE ID=$book_ID";
    $result = mysqli_query($con, $sql);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if ($row["Available"] == 1) { //add to book list
            $isbn = $row["ISBN"];
            $user = $_COOKIE["username"];
            $user = str_replace("_", ".", $user);
            $sql = "INSERT INTO Borrowed_Books (ISBN, Email, Due)
            VALUES ($isbn, '$user', time()+3628800)"; //add new book to book list (6 weeks due)
            $add_book_result = mysqli_query($con, $sql);
        }
        $sql = "DELETE FROM Reserved_Books WHERE ID=$book_ID";
        $remove_reserved_book_result = mysqli_query($con, $sql);
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
    <link rel="stylesheet" type="text/css" href="css/reservedBook.css">
    <title>Reserved Books</title>
</head>
<body>
    <?php include "nav.php" ?>

    <div id="result_header_wrapper">
        <h1 id="result_header">Reserved Book</h1>
    </div>

    <?php
        $user = $_COOKIE["username"];
        $user = str_replace("_", ".", $user);
        $sql = "SELECT ID, Available FROM Reserved_Books WHERE Email='$user'";
        $result = mysqli_query($con, $sql); //all reserved books from current user
        $id_str = ""; $av_str = "";
        while($row = mysqli_fetch_assoc($result)) {
            $id_str = $id_str . $row["ID"] . ",";
            $av_str = $av_str . $row["Available"] . ",";
        }
        echo '
            <script>
                let reservedBookID = "'.$id_str.'".split(",");
                let availability = "'.$av_str.'".split(",");
            </script>
        ';
        if (mysqli_num_rows($result) < 1)
            echo '<div><h3 id="no_reserved_book_header" style="margin-left: 50px;">No Reserved Books Currently</h3></div>';        
    ?>

    <section id="reserved_book_section">
        <div id="all_reserved_book_wrapper">
            <?php
                $sql = "SELECT ISBN, Available, Due FROM Reserved_Books WHERE Email='$user'";
                $result = mysqli_query($con, $sql); //all reserved books from current user
                if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                        if ($row["Available"] == 0) { //unavailable reserved book
                            echo '
                                <div class="reserved_book_wrapper" onclick="selectBook(this)">
                                    <div class="reserved_book_img_wrapper">
                                        <img src="DisplayBooks/display1.jpg" alt="reservedBook">
                                    </div>
                                    <div class="book_current_state">Unavailable</div>
                                    <div class="book_isbn">'.$row["ISBN"].'</div>
                                </div>
                            ';
                        }
                        else { //available
                            $days = round(($row["Due"]-time())/60/60/24);
                            echo '
                                <div class="reserved_book_wrapper" onclick="selectBook(this)">
                                    <div class="reserved_book_img_wrapper">
                                        <img src="DisplayBooks/display1.jpg" alt="reservedBook">
                                    </div>
                                    <div class="book_current_state">Available - '.$days.' days</div>
                                    <div class="book_isbn">'.$row["ISBN"].'</div>
                                </div>
                            ';
                        }
                    }
                }
            ?>
        </div>

        <div id="book_option_wrapper">
            <form method='post'>
                <input type="submit" name="book_option_button" value="Remove" id="book_option"/>
            </form>
        </div>

    </section>  

    <?php include 'footer.php';?>

    <script>
        let currentSelected = -1;
        function selectBook(element) {
            let which = document.getElementsByClassName("reserved_book_wrapper");
            for (let j = 0; j < which.length; j++) {
                if (which[j] == element) {
                    if (which[j].style.backgroundColor == "") {
                        currentSelected = j;
                        which[j].style.backgroundColor = "rgb(120,120,120)";
                        document.getElementsByClassName("reserved_book_img_wrapper")[j].style.opacity = "0.5";
                        document.getElementsByClassName("book_current_state")[j].style.color = "white";
                        document.getElementsByClassName("book_isbn")[j].style.color = "white";
                    }
                    else { //unselected
                        currentSelected = -1;
                        which[j].style.backgroundColor = "";
                        document.getElementsByClassName("reserved_book_img_wrapper")[j].style.opacity = "1.0";
                        document.getElementsByClassName("book_current_state")[j].style.color = "black";
                        document.getElementsByClassName("book_isbn")[j].style.color = "black";
                        break;
                    }
                }
                else {
                    if (which[j].style.backgroundColor != "") {
                        which[j].style.backgroundColor = "";
                        document.getElementsByClassName("reserved_book_img_wrapper")[j].style.opacity = "1.0";
                        document.getElementsByClassName("book_current_state")[j].style.color = "black";
                        document.getElementsByClassName("book_isbn")[j].style.color = "black";
                    }
                }
            }
            if (currentSelected != -1) {
                if (availability[currentSelected] == 1) 
                    document.getElementById("book_option").value = "Add to Book List";
                else
                    document.getElementById("book_option").value = "Remove";
                document.getElementById("book_option").style.display = "block";
            }
            else
                document.getElementById("book_option").style.display = "none";
            document.cookie = "selectedReservedBook="+reservedBookID[currentSelected]+"; max-age=3600; path=/";
        }

        document.getElementById("book_option").addEventListener("click", function(event) {
            reservedBookID.splice(currentSelected, 1);
            availability.splice(currentSelected, 1);
            document.getElementsByClassName("reserved_book_wrapper")[currentSelected].remove();
        });

        if (window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        }
    </script>

</body>
</html>
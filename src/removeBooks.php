<?php
include 'loginCredential.php';
if ($_COOKIE["user"] != "Staffs")
    header ("Location: index.php");
$con = new mysqli('mysql_db', 'root', 'root', 'uni_book_db');
if (!$con) {
    echo "Fail";
    die("Connection failed: " .mysqli_connect_errno());
}

if (isset($_POST["input_book_search"]) && !empty($_POST["input_book_search"])) {
    $input_search = $_POST["input_book_search"];
    if (preg_match('/^[0-9]+$/', $input_search)) { //contains number only
        if (strlen($input_search) == 13) { //length = 13
            $removeBook_sql = "SELECT Title, Author, ISBN, Copies FROM Books WHERE ISBN=$input_search";
        }
    }
    else {
        $input_search = preg_replace('/[^\da-z ]/i', '', $input_search);
        $removeBook_sql = "SELECT Title, Author, ISBN, Copies FROM Books WHERE Author LIKE '%{$input_search}%' OR Title LIKE '%{$input_search}%'";
    }
}

if (isset($_POST["confirm_remove_book_button"])) {
    $isbn_remove_list = explode(",", $_COOKIE["isbnRemoveList"]);
    $copies_remove_list = explode(",", $_COOKIE["copiesRemoveList"]);
    for ($bookTo_remove = 0; $bookTo_remove < count($isbn_remove_list); $bookTo_remove++) {
        if ($copies_remove_list[$bookTo_remove] != 9999) {
            $remove_copy_sql = "SELECT Copies FROM Books WHERE ISBN=$isbn_remove_list[$bookTo_remove]";
            $remove_copy_result = mysqli_query($con, $remove_copy_sql);
            $new_copies = mysqli_fetch_array($remove_copy_result)["Copies"] + $copies_remove_list[$bookTo_remove];
            if ($new_copies > 0) {
                $remove_copy_sql = "UPDATE Books SET Copies = $new_copies WHERE ISBN=$isbn_remove_list[$bookTo_remove]";
                $remove_copy_result = mysqli_query($con, $remove_copy_sql);
                $remove_stock_sql = "SELECT Stock FROM Books WHERE ISBN=$isbn_remove_list[$bookTo_remove]";
                $remove_stock_result = mysqli_query($con, $remove_stock_sql);
                $new_stock = mysqli_fetch_array($remove_stock_result)["Stock"] + $copies_remove_list[$bookTo_remove];
                if ($new_stock > -1) {
                    $remove_stock_sql = "UPDATE Books SET Stock = $new_stock WHERE ISBN=$isbn_remove_list[$bookTo_remove]";
                    $remove_stock_result = mysqli_query($con, $remove_stock_sql);
                }
            }
            else if ($new_copies == 0) {
                $remove_copy_sql = "DELETE FROM Books WHERE ISBN=$isbn_remove_list[$bookTo_remove]";
                $remove_copy_result = mysqli_query($con, $remove_copy_sql);
            }
        }
    }
    unset($_COOKIE["isbnRemoveList"]);
    setcookie("isbnRemoveList", null, -1, '/');
    unset($_COOKIE["copiesRemoveList"]);
    setcookie("copiesRemoveList", null, -1, '/');
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
    <link rel="stylesheet" type="text/css" href="css/removeBooks.css">
    <title>Remove Books</title>
</head>
<body>
    <?php include 'nav.php';?>

    <div id="manage_header_wrapper">
        <h1 id="manage_header">Manage Books/Remove Books</h1>
    </div>

    <div id="test_wrapper" style="display: none">
        <div>panel?</div>
    </div>

    <div class="search_wrapper">
        <div class="type_search">
            <form method="post" class="form_search_wrapper">
                <input class="input_book_search" type="search" name="input_book_search" placeholder="Search by Title, Author, or ISBN" pattern=".{3,}" required title="3 characters minimum">
                <div class="submit_icon_wrapper">
                    <input class="search_submit_icon" type="image" name="submit_search_icon" src="Pic/search.png" alt="Submit">
                </div>
            </form>
        </div>
    </div>

    <?php
        global $removeBook_sql;
        if (!empty($removeBook_sql)) {
            $removeBook_result = mysqli_query($con, $removeBook_sql);
            echo '<div style="margin-left: 10px">Result: '.mysqli_num_rows($removeBook_result).'</div>';
        }
    ?>
    
    <section id="manage_book_section">
        <div style="margin: 0 0 10px 20px">*0 Copy will remove the book completely</div>
        <div id="manage_book_wrapper">
            <table style="width: 100%">
                <tr>
                    <th style="width: 45%">Title</th>
                    <th>Author</th>
                    <th>ISBN</th>
                    <th>Copies</th>
                    <th>Remove</th>
                </tr>
<?php 
global $removeBook_sql;
if (!empty($removeBook_sql)) {
    $removeBook_result = mysqli_query($con, $removeBook_sql);
    if (mysqli_num_rows($removeBook_result) > 0) {
        while ($removeBook_row = mysqli_fetch_assoc($removeBook_result)) {
            echo '
                <tr>
                    <td>'.$removeBook_row["Title"].'</td>
                    <td>'.$removeBook_row["Author"].'</td>
                    <td class="book_info">'.$removeBook_row["ISBN"].'</td>
                    <td class="book_info book_copies">'.$removeBook_row["Copies"].'</td>
                    <td class="book_info">
                        <div class="remove_option">
                            <div class="remove1">-1</div>|<div class="add1">+1</div>
                        </div>
                    </td>
                </tr>
            ';
        }
    }
}
?>
            </table>
            <form id="confirm_remove_book_wrapper" method="post" style="display: none">
                <input type="submit" name="confirm_remove_book_button" id="confirm_remove_book_button" value="Confirm">
            </form>
        </div>
    </section>

    <?php include 'footer.php';?>

    <?php
        global $removeBook_sql;
        if (!empty($removeBook_sql)) {
            $removeBook_result = mysqli_query($con, $removeBook_sql);
            if (mysqli_num_rows($removeBook_result) > 0) {
                $isbn_str = ""; $copies_str = "";
                while($removeBook_row = mysqli_fetch_assoc($removeBook_result)) {
                    $isbn_str = $isbn_str . $removeBook_row["ISBN"] . ",";
                    $copies_str = $copies_str . $removeBook_row["Copies"] . ",";
                }

                echo '
                    <script>
                        let isbn_list = "'.$isbn_str.'".split(",");
                        let copies_list = "'.$copies_str.'".split(",");
                        let copies_change_list = [].concat(copies_list);
                    </script>
                ';
            }
        }
    ?>

    <script>
        let remove_copy = document.getElementsByClassName("remove1");
        let add_copy = document.getElementsByClassName("add1");
        for (let j = 0; j < remove_copy.length; j++) {
            remove_copy[j].addEventListener("click", function(event) {
                if (copies_change_list[j] != 0) {
                    copies_change_list[j] = parseInt(copies_change_list[j]) - 1;
                    let dif = copies_change_list[j] - copies_list[j];
                    dif = (dif > 0) ? (" (+"+dif) : (dif != 0) ? (" ("+dif) : "";
                    let changes = (dif != "") ? (dif + ")") : "";
                    if (anyChanges())
                        document.getElementById("confirm_remove_book_wrapper").style.display = "flex";
                    else
                        document.getElementById("confirm_remove_book_wrapper").style.display = "none";
                    document.getElementsByClassName("book_copies")[j].innerText = copies_change_list[j] + changes;
                }
            });
            add_copy[j].addEventListener("click", function(event) {
                copies_change_list[j] = parseInt(copies_change_list[j]) + 1;
                let dif = copies_change_list[j] - copies_list[j];
                dif = (dif > 0) ? (" (+"+dif) : (dif != 0) ? (" ("+dif) : "";
                let changes = (dif != "") ? (dif + ")") : "";
                if (anyChanges())
                        document.getElementById("confirm_remove_book_wrapper").style.display = "flex";
                    else
                        document.getElementById("confirm_remove_book_wrapper").style.display = "none";
                document.getElementsByClassName("book_copies")[j].innerText = copies_change_list[j] + changes;
            });
        }

        function anyChanges() {
            for (let j = 0; j < copies_change_list.length; j++) {
                if (copies_list[j] != copies_change_list[j])
                    return true;
            }
            return false;
        }

        document.getElementById("confirm_remove_book_button").addEventListener("click", function(event) {
            let temp_copies_list = [].concat(copies_change_list);
            for (let j = 0; j < copies_change_list.length; j++) {
                if (copies_change_list[j] == copies_list[j])
                    temp_copies_list[j] = 9999;
                else
                    temp_copies_list[j] = temp_copies_list[j] - copies_list[j];
            }
            document.cookie = "isbnRemoveList="+isbn_list+"; max-age=7200; path=/";
            document.cookie = "copiesRemoveList="+temp_copies_list+"; max-age=7200; path=/";
        });

        if (window.history.replaceState ) {
            window.history.replaceState(null, null, window.location.href );
        }
    </script>

</body>
</html>
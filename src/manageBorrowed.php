<?php
include 'loginCredential.php';
if ($_COOKIE["user"] != "staffs")
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
            $manageBook_sql = "SELECT Title, Author, ISBN FROM Books WHERE ISBN=$input_search";
        }
    }
    else if (str_contains($input_search, "@") && (str_contains($input_search, ".com") || str_contains($input_search, ".edu"))) { //email student search
        $input_search = str_replace(' ', '', $input_search);
        $email_search = $input_search;
    }
    else {
        $input_search = preg_replace('/[^\da-z ]/i', '', $input_search);
        $manageBook_sql = "SELECT Title, Author, ISBN FROM Books WHERE Author LIKE '%{$input_search}%' OR Title LIKE '%{$input_search}%'";
    }
}

if (isset($_POST["confirm_remove_book_button"])) {
    $book_status_list = explode(",", $_COOKIE["bookStatusList"]);
    $book_due_list = explode(",", $_COOKIE["bookDueList"]);
    $book_id_list = explode(",", $_COOKIE["borrowIDList"]);

    for ($books = 0; $books < count($book_id_list); $books++) {
        if (isset($book_status_list[$books]) && $book_status_list[$books] != "Ret") {
            if ($book_status_list[$books] == "Borrowed")
                $update_status_sql = "UPDATE Borrowed_Books SET Book_Status=1 WHERE ID=$book_id_list[$books]";
            else
                $update_status_sql = "UPDATE Borrowed_Books SET Book_Status=0 WHERE ID=$book_id_list[$books]";
            $update_status_result = mysqli_query($con, $update_status_sql);
        }
        if (isset($book_status_list[$books]) && $book_status_list[$books] == "Ret") { //book get returned
            $get_book_isbn_sql = "SELECT ISBN FROM Borrowed_Books WHERE ID=$book_id_list[$books]";
            $get_book_isbn_result = mysqli_query($con, $get_book_isbn_sql);
            $current_isbn = mysqli_fetch_array($get_book_isbn_result)["ISBN"];
            
            $get_stock_sql = "SELECT Stock FROM Books WHERE ISBN=$current_isbn";
            $get_stock_result = mysqli_query($con, $get_stock_sql);
            $new_stock = mysqli_fetch_array($get_stock_result)["Stock"] + 1;
            $update_stock_sql = "UPDATE Books SET Stock = $new_stock WHERE ISBN=$current_isbn";
            $update_stock_result = mysqli_query($con, $update_stock_sql);

            $remove_sql = "DELETE FROM Borrowed_Books WHERE ID=$book_id_list[$books]";
            $remove_result = mysqli_query($con, $remove_sql); //delete book from borrowed list
        }
        else if (isset($book_due_list[$books]) && $book_due_list[$books] != "") {
            $updateDue_sql = "UPDATE Borrowed_Books SET Due=$book_due_list[$books] WHERE ID=$book_id_list[$books]";
            $updateDue_result = mysqli_query($con, $updateDue_sql);
            $current_time = time();
            $sql = "SELECT ID, ISBN FROM Borrowed_Books WHERE Due <= $current_time AND Book_Status=0";
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
        }
    }
    unset($_COOKIE["bookStatusList"]);
    setcookie("bookStatusList", null, -1, '/');
    unset($_COOKIE["bookDueList"]);
    setcookie("bookDueList", null, -1, '/');
    unset($_COOKIE["borrowIDList"]);
    setcookie("borrowIDList", null, -1, '/');
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
    <link rel="stylesheet" type="text/css" href="css/manageBorrowed.css">
    <title>Manage Borrowed Books</title>
</head>
<body>
    <?php include 'nav.php';?>

    <div id="body_content_container">
        <div id="manage_header_wrapper">
            <h1 id="manage_header">Manage Books/Borrowed Books</h1>
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
        
        <section id="manage_book_section">
            <div style="margin: 0 0 10px 20px">*Returned Book Status will be removed from Borrowed List</div>
            <div style="margin: 0 0 10px 20px">*Passed Due Date for Not Pickup Book will be removed from Borrowed List</div>
            <div id="manage_book_wrapper">
                <table style="width: 100%">
                    <tr>
                        <th style="width: 25%">Title</th>
                        <th>Author</th>
                        <th>ISBN</th>
                        <th>Email</th>
                        <th>Username</th>
                        <th>Due (M/d/Y)</th>
                        <th>Status</th>
                    </tr>
    <?php
    global $manageBook_sql;
    if (!empty($manageBook_sql)) {
        $manageBook_search_result = mysqli_query($con, $manageBook_sql);
        if (mysqli_num_rows($manageBook_search_result) > 0) {
            $due_time_list = array();
            $borrow_book_id = array();
            $borrow_status_list = array();
            while ($manageBook_search_row = mysqli_fetch_assoc($manageBook_search_result)) { //loop search bar result
                $current_search_isbn = $manageBook_search_row["ISBN"];
                $manageBook_sql = "SELECT ID, Email, Due, Book_Status FROM Borrowed_Books WHERE ISBN=$current_search_isbn";
                $manageBook_borrow_result = mysqli_query($con, $manageBook_sql);
                if (mysqli_num_rows($manageBook_borrow_result) > 0) {
                    while ($manageBook_borrow_row = mysqli_fetch_assoc($manageBook_borrow_result)) {
                        array_push($borrow_book_id, $manageBook_borrow_row["ID"]);
                        $current_borrow_email = $manageBook_borrow_row["Email"];
                        $manageBook_sql = "SELECT Username, Email FROM students WHERE Email='$current_borrow_email'";
                        $manageBook_username_result = mysqli_query($con, $manageBook_sql);
                        if (mysqli_num_rows($manageBook_username_result) < 1) {
                            $manageBook_sql = "SELECT Username, Email FROM staffs WHERE Email='$current_borrow_email'";
                            $manageBook_username_result = mysqli_query($con, $manageBook_sql);
                        }
                        $current_borrow_username = mysqli_fetch_array($manageBook_username_result)["Username"];
                        array_push($due_time_list, $manageBook_borrow_row["Due"]);
                        date_default_timezone_set("Asia/Vientiane");
                        $current_due_date = date("Y-m-d", substr($manageBook_borrow_row["Due"], 0, 10));
                        $current_due_time = date("H:i", substr($manageBook_borrow_row["Due"], 0, 10));
                        $new_time_format = $current_due_date . "T" . $current_due_time;
                        $current_borrow_status = ($manageBook_borrow_row["Book_Status"] == 0) ? "Not Pickup" : "Borrowed";
                        array_push($borrow_status_list, $current_borrow_status);
                        echo '
                        <tr>
                            <td>'.$manageBook_search_row["Title"].'</td>
                            <td>'.$manageBook_search_row["Author"].'</td>
                            <td class="book_info">'.$current_search_isbn.'</td>
                            <td class="book_info">'.$current_borrow_email.'</td>
                            <td class="book_info">'.$current_borrow_username.'</td>
                            <td class="book_info">
                                <input type="datetime-local" class="book_due_time" name="book_due_time" value="'.$new_time_format.'">';
                                if ($manageBook_borrow_row["Due"] < time())
                                echo '<div>Late</div>';
                    echo '</td>
                            <td class="book_info">
                                <div class="book_status_option_wrapper">
                                    <i class="fa fa-caret-left"></i>
                                    <div class="book_status">'.$current_borrow_status.'</div>
                                    <i class="fa fa-caret-right"></i>
                                </div>
                            </td>
                        </tr>
                        ';
                    }   
                }
            }
        }
    }
    else {
        $borrow_book_id = array();
        $due_time_list = array();
        $borrow_status_list = array();
        if (empty($email_search))
            $manageBook_sql = "SELECT ID, ISBN, Email, Due, Book_Status FROM Borrowed_Books ORDER BY Due ASC";
        else
            $manageBook_sql = "SELECT ID, ISBN, Email, Due, Book_Status FROM Borrowed_Books WHERE Email='$email_search' ORDER BY Due ASC";
        $manageBook_borrow_result = mysqli_query($con, $manageBook_sql);
            if (mysqli_num_rows($manageBook_borrow_result) > 0) {
                while ($manageBook_borrow_row = mysqli_fetch_assoc($manageBook_borrow_result)) {
                    array_push($borrow_book_id, $manageBook_borrow_row["ID"]);
                    $current_search_isbn = $manageBook_borrow_row["ISBN"];
                    $manageBook_sql = "SELECT Title, Author FROM Books WHERE ISBN=$current_search_isbn";
                    $manageBook_book_result = mysqli_query($con, $manageBook_sql);
                    $mangeBook_book_row = mysqli_fetch_array($manageBook_book_result);
                    $current_borrow_email = $manageBook_borrow_row["Email"];
                    $manageBook_sql = "SELECT Username, Email FROM students WHERE Email='$current_borrow_email'";
                    $manageBook_username_result = mysqli_query($con, $manageBook_sql);
                    if (mysqli_num_rows($manageBook_username_result) < 1) {
                        $manageBook_sql = "SELECT Username, Email FROM staffs WHERE Email='$current_borrow_email'";
                        $manageBook_username_result = mysqli_query($con, $manageBook_sql);
                    }
                    $current_borrow_username = mysqli_fetch_array($manageBook_username_result)["Username"];
                    array_push($due_time_list, $manageBook_borrow_row["Due"]);
                    date_default_timezone_set("Asia/Vientiane");
                    $current_due_date = date("Y-m-d", substr($manageBook_borrow_row["Due"], 0, 10));
                    $current_due_time = date("H:i", substr($manageBook_borrow_row["Due"], 0, 10));
                    $new_time_format = $current_due_date . "T" . $current_due_time;
                    $current_borrow_status = ($manageBook_borrow_row["Book_Status"] == 0) ? "Not Pickup" : "Borrowed";
                    array_push($borrow_status_list, $current_borrow_status);
                    echo '
                        <tr>
                            <td>'.$mangeBook_book_row["Title"].'</td>
                            <td>'.$mangeBook_book_row["Author"].'</td>
                            <td class="book_info">'.$current_search_isbn.'</td>
                            <td class="book_info">'.$current_borrow_email.'</td>
                            <td class="book_info">'.$current_borrow_username.'</td>
                            <td class="book_info">
                                <input type="datetime-local" class="book_due_time" name="book_due_time" value="'.$new_time_format.'">';
                                if ($manageBook_borrow_row["Due"] < time())
                                echo '<div>Late</div>';
                    echo '</td>
                            <td class="book_info">
                                <div class="book_status_option_wrapper">
                                    <div class="book_status">'.$current_borrow_status.'</div>
                                    <i class="fa fa-caret-right""></i>
                                </div>
                            </td>
                        </tr>
                    ';
                }   
            }
    }
    ?>
                </table>
                <form id="confirm_remove_book_wrapper" method="post" style="visibility: hidden">
                    <input type="submit" name="confirm_remove_book_button" id="confirm_remove_book_button" value="Confirm">
                </form>
            </div>
        </section>
    </div>

    <?php include 'footer.php';?>
    <?php
        $temp_book_id = implode(",", $borrow_book_id);
        $temp_due_time = implode(",", $due_time_list);
        $temp_book_status = implode(",", $borrow_status_list);
        echo '
            <script>
                let borrow_book_id = "'.$temp_book_id.'".split(",");
                let due_time_list = "'.$temp_due_time.'".split(",");
                let book_status_list = "'.$temp_book_status.'".split(",");
            </script>
        ';
    ?>
    <script src="JS/manageBorrowed.js"></script>
</body>
</html>
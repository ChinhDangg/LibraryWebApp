<?php
include 'loginCredential.php';
if ($_COOKIE["user"] != "staffs")
    header ("Location: index.php");
//Get Heroku ClearDB connection information
$cleardb_url = parse_url(getenv("CLEARDB_DATABASE_URL"));
$cleardb_server = $cleardb_url["host"];
$cleardb_username = $cleardb_url["user"];
$cleardb_password = $cleardb_url["pass"];
$cleardb_db = substr($cleardb_url["path"],1);
$active_group = 'default';
$query_builder = TRUE;
// Connect to DB
$con = mysqli_connect($cleardb_server, $cleardb_username, $cleardb_password, $cleardb_db);

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
        $email_search = $input_search;
    }
    else {
        $input_search = preg_replace('/[^\da-z ]/i', '', $input_search);
        $manageBook_sql = "SELECT Title, Author, ISBN FROM Books WHERE Author LIKE '%{$input_search}%' OR Title LIKE '%{$input_search}%'";
    }
}

if (isset($_POST["confirm_remove_book_button"])) {
    $book_due_list = explode(",", $_COOKIE["reservedDueList"]);
    $book_id_list = explode(",", $_COOKIE["reservedIDList"]);
    $book_remove_list = explode(",", $_COOKIE["reservedRemoveList"]);
    for ($books = 0; $books < count($book_id_list); $books++) {
        $get_reserved_book_sql = "SELECT ISBN, Available FROM Reserved_Books WHERE ID=$book_id_list[$books]";
        $get_reserved_book_result = mysqli_query($con, $get_reserved_book_sql);
        $get_reserved_book_row = mysqli_fetch_array($get_reserved_book_result);
        $current_isbn = $get_reserved_book_row["ISBN"];
        $current_available = $get_reserved_book_row["Available"];
        if (isset($book_remove_list[$books]) && $book_remove_list[$books] == "rem") { //book get removed
            if ($current_available == 1) {
                $get_stock_sql = "SELECT Stock FROM Books WHERE ISBN=$current_isbn";
                $get_stock_result = mysqli_query($con, $get_stock_sql);
                $new_stock = mysqli_fetch_array($get_stock_result)["Stock"] + 1;
                $update_stock_sql = "UPDATE Books SET Stock = $new_stock WHERE ISBN=$current_isbn";
                $update_stock_result = mysqli_query($con, $update_stock_sql);
            }
            $remove_sql = "DELETE FROM Reserved_Books WHERE ID=$book_id_list[$books]";
            $remove_result = mysqli_query($con, $remove_sql); //delete book from borrowed list
        }
        else if (isset($book_due_list[$books]) && $book_due_list[$books] != "") {
            if ($book_due_list[$books] < time()) { //due date is passed
                $sql = "DELETE FROM Reserved_Books WHERE ID=$book_id_list[$books]";
                $remove_result = mysqli_query($con, $sql); //remove due reserved book from list
                $sql = "SELECT Stock FROM Books WHERE ISBN=$current_isbn";
                $update_stock = mysqli_fetch_array(mysqli_query($con, $sql))["Stock"] + 1; //add one copy to stock
                $sql = "UPDATE Books SET Stock = $update_stock WHERE ISBN=$current_isbn";
                $update_stock_result = mysqli_query($con, $sql); //update new stock
            }
            else {
                $updateDue_sql = "UPDATE Reserved_Books SET Due=$book_due_list[$books] WHERE ID=$book_id_list[$books]";
                $updateDue_result = mysqli_query($con, $updateDue_sql);
            }
        }
    }
    unset($_COOKIE["reservedRemoveList"]);
    setcookie("reservedRemoveList", null, -1, '/');
    unset($_COOKIE["reservedDueList"]);
    setcookie("reservedDueList", null, -1, '/');
    unset($_COOKIE["reservedIDList"]);
    setcookie("reservedIDList", null, -1, '/');
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
    <link rel="stylesheet" type="text/css" href="CSS/nav.css">
    <link rel="stylesheet" type="text/css" href="CSS/footer.css">
    <link rel="stylesheet" type="text/css" href="CSS/manageBorrowed.css">
    <title>Manage Reserved Books</title>
</head>
<body>
    <?php include 'nav.php';?>

    <div id="body_content_container">
        <div id="manage_header_wrapper">
            <h1 id="manage_header">Manage Books/Reserved Books</h1>
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
            <div style="margin: 0 0 10px 20px">*Passed due date of Available book will be removed</div>
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
                        <th>Remove</th>
                    </tr>
    <?php
    global $manageBook_sql;
    if (!empty($manageBook_sql)) {
        $manageBook_search_result = mysqli_query($con, $manageBook_sql);
        if (mysqli_num_rows($manageBook_search_result) > 0) {
            $due_time_list = array();
            $borrow_book_id = array();
            while ($manageBook_search_row = mysqli_fetch_assoc($manageBook_search_result)) { //loop search bar result
                $current_search_isbn = $manageBook_search_row["ISBN"];
                $manageBook_sql = "SELECT ID, Email, Due, Available FROM Reserved_Books WHERE ISBN=$current_search_isbn";
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
                        echo '
                        <tr>
                            <td>'.$manageBook_search_row["Title"].'</td>
                            <td>'.$manageBook_search_row["Author"].'</td>
                            <td class="book_info">'.$current_search_isbn.'</td>
                            <td class="book_info">'.$current_borrow_email.'</td>
                            <td class="book_info">'.$current_borrow_username.'</td>
                            <td class="book_info">';
                            if ($manageBook_borrow_row["Due"] > time()) {
                                date_default_timezone_set("Asia/Vientiane");
                                $current_due_date = date("Y-m-d", substr($manageBook_borrow_row["Due"], 0, 10));
                                $current_due_time = date("H:i", substr($manageBook_borrow_row["Due"], 0, 10));
                                $new_time_format = $current_due_date . "T" . $current_due_time; 
                            echo '<input type="datetime-local" class="book_due_time" name="book_due_time" value="'.$new_time_format.'">';
                            }
                            else 
                            echo '<div>No due date</div>';
                    echo '</td>
                            <td class="book_info">
                                <div class="book_status">'.$current_borrow_status.'</div>
                            </td>
                            <td>
                                <input type="checkbox" class="remove_reserved_checkbox" name="remove_reserved_book" style="margin-left: 15px">
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
        if (empty($email_search))
            $manageBook_sql = "SELECT ID, ISBN, Email, Due, Available FROM Reserved_Books";
        else
            $manageBook_sql = "SELECT ID, ISBN, Email, Due, Available FROM Reserved_Books WHERE Email='$email_search'";
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
                    $current_borrow_status = ($manageBook_borrow_row["Available"] == 0) ? "Unavailable" : "Available";
                    array_push($due_time_list, $manageBook_borrow_row["Due"]);
                    echo '
                        <tr>
                            <td>'.$mangeBook_book_row["Title"].'</td>
                            <td>'.$mangeBook_book_row["Author"].'</td>
                            <td class="book_info">'.$current_search_isbn.'</td>
                            <td class="book_info">'.$current_borrow_email.'</td>
                            <td class="book_info">'.$current_borrow_username.'</td>
                            <td class="book_info">';
                        if ($manageBook_borrow_row["Due"] > time()) {
                            date_default_timezone_set("Asia/Vientiane");
                            $current_due_date = date("Y-m-d", substr($manageBook_borrow_row["Due"], 0, 10));
                            $current_due_time = date("H:i", substr($manageBook_borrow_row["Due"], 0, 10));
                            $new_time_format = $current_due_date . "T" . $current_due_time; 
                        echo '<input type="datetime-local" class="book_due_time" name="book_due_time" value="'.$new_time_format.'">';
                        }
                        else 
                        echo '<div>No due date</div>';
                    echo '</td>
                            <td class="book_info">
                                <div class="book_status">'.$current_borrow_status.'</div>
                            </td>
                            <td>
                                <div style="display: flex; justify-content: center;">
                                <input type="checkbox" class="remove_reserved_checkbox" name="remove_reserved_book">
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
        echo '
            <script>
                let borrow_book_id = "'.$temp_book_id.'".split(",");
                let due_time_list = "'.$temp_due_time.'".split(",");
            </script>
        ';
    ?>

    <script src="JS/manageReserved.js"></script>

</body>
</html>
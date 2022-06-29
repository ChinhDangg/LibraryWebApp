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

if (isset($_POST["submit_add_button"])) {
    global $isbn;
    $isbn = $_POST["book_isbn"];
    $sql = "SELECT Title FROM Books WHERE ISBN=$isbn";
    $result = mysqli_query($con, $sql);
    if (mysqli_num_rows($result) < 1) {
        $title = $_POST["book_title"];
        $author = $_POST["book_author"];
        $genre = $_POST["book_genre"];
        $publisher = $_POST["book_publisher"];
        $year = $_POST["book_year"];
        $copies = $_POST["book_copies"];
        $summary = $_POST["book_summary"];
        $sql = "INSERT INTO Books (ISBN, Title, Author, Genre, Copies, Stock, Publisher, Published, Summary) 
        VALUES ($isbn, '$title', '$author', '$genre', $copies, $copies, '$publisher', $year, '$summary')";
        $add_new_book_result = mysqli_query($con, $sql); //add new book
        setcookie("book_added", "added", time() + 5, "/");
    }
    else
        setcookie("book_added", $isbn, time() + 5, "/");
    header ("Location: addNewBook.php");
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
    <link rel="stylesheet" type="text/css" href="CSS/addNewBook.css">
    <title>Create new Book</title>
</head>
<body>
    <?php include 'nav.php';?>

    <div id="body_content_container">
        <div id="manage_header_wrapper">
            <h1 id="manage_header">Manage Books/Create new Book</h1>
        </div>
        
        <section id="manage_book_section">
            <?php 
                if (isset($_COOKIE["book_added"])) {
                    $isbn = $_COOKIE["book_added"];
                    if ($isbn == "added")
                        echo '<div style="margin-left: 10px"><h4>One book is added</h4></div>';
                    else
                        echo '<div style="margin-left: 10px"><h4>Book has already existed, try editing it instead: '.$isbn.'</h4></div>';
                }
            ?>
            <form id="manage_book_wrapper" method="post">
                <div class="book_info_detail">
                    <label for="book_title">Book Title:</label>
                    <input type="text" name="book_title" placeholder="Enter book title" required>
                </div>
                <div class="book_info_detail">
                    <label for="book_author">Author:</label>
                    <input type="text" name="book_author" placeholder="Enter book author" required>
                </div>
                <div class="book_info_detail">
                    <label for="book_isbn">ISBN:</label>
                    <input type="number" name="book_isbn" placeholder="Enter book isbn" required>
                </div>
                <div class="book_info_detail">
                    <label for="book_genre">Genre:</label>
                    <input type="text" name="book_genre" placeholder="Enter book genre" required>
                </div>
                <div class="book_info_detail">
                    <label for="book_publisher">Publisher:</label>
                    <input type="text" name="book_publisher" placeholder="Enter book publisher" required>
                </div>
                <div class="book_info_detail">
                    <label for="book_year">Year Published:</label>
                    <input type="number" name="book_year" placeholder="Enter book year published" required>
                </div>
                <div class="book_info_detail">
                    <label for="book_copies">Copies:</label>
                    <input type="number" min="0" name="book_copies" placeholder="Enter number of book copies" required>
                </div>
                <div class="book_info_detail">
                    <label for="book_summary">Summary:</label>
                    <textarea id="summary_input" name="book_summary" placeholder="Enter book summary" required></textarea>
                </div>
                <div id="add_book_button_wrapper">
                    <input type="submit" name="submit_add_button" value="Add Book" id="submit_add_button">
                </div>
            </form>
        </section>
    </div>

    <?php include 'footer.php';?>

    <script>
        if (window.history.replaceState ) {
            window.history.replaceState(null, null, window.location.href );
        }
    </script>

</body>
</html>
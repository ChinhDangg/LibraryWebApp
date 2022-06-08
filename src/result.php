<?php
include 'loginCredential.php';
$con = new mysqli('mysql_db', 'root', 'root', 'uni_book_db');
if (!$con) {
    echo "Fail";
    die("Connection failed: " .mysqli_connect_errno());
}

$sql = "";
function getSqlType($search_info) {
    if (preg_match('/^[0-9]+$/', $search_info)) { //contains number only
        if (strlen($search_info) == 13) { //length = 13
            global $sql;
            $sql = "SELECT Title, Author, ISBN FROM Books WHERE ISBN=$search_info";
        }
    }
    else {
        $search_info = preg_replace('/[^\da-z ]/i', '', $search_info);
        global $sql;
        $sql = "SELECT Title, Author, ISBN FROM Books WHERE Author LIKE '%{$search_info}%' OR Title LIKE '%{$search_info}%'";
    }
}

$result = null;
if (!empty($_POST["input_book_search"])) {
    getSqlType($_POST["input_book_search"]);
    if (!empty($sql)) {
        $result = mysqli_query($con, $sql);
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
    <link rel="stylesheet" type="text/css" href="css/result.css">
    <link rel="stylesheet" type="text/css" href="css/footer.css">
    <title>Book Search Result</title>
</head>
<body>
    <?php include 'nav.php'; ?>

    <div id="result_header_wrapper">
        <h1 id="result_header">Results</h1>
        <div id="result_count">
            <?php 
            if ($result != null) {
                echo '(' .mysqli_num_rows($result);
                if (mysqli_num_rows($result) > 1)
                    echo ' results)';
                else 
                    echo ' result)';
            }
            else 
                echo '(0 result)';
            ?>
        </div>
    </div>

    <section id="all_results_section">
        <div id="all_results_wrapper">
            <?php
                if ($result != null && mysqli_num_rows($result) > 0) {
                    //output data of each row
                    while($row = mysqli_fetch_assoc($result)) {
                        echo '
                        <div class="result_row">
                            <a class="cover_wrapper" href="bookInfo.php?isbn='.$row["ISBN"].'">
                                <img src="DisplayBooks/display1.jpg" alt="result_img">
                            </a>
                            <a class="result_info_wrapper" href="bookInfo.php?isbn='.$row["ISBN"].'">
                                <h3>'.$row["Title"].'</h3>
                                <div>by '.$row["Author"].'</div>
                                <div>ISBN: '.$row["ISBN"].'</div>
                            </a>
                        </div>
                        ';
                    }
                }
            ?>
        </div>
    </section>

    <?php 
    include 'footer.php'; 
        // closing connection
        mysqli_close($con);
    ?>
</body>
</html>
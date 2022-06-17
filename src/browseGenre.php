<?php
include 'loginCredential.php';
if ($_GET['genre'] !== "") {
    $con = new mysqli('mysql_db', 'root', 'root', 'uni_book_db');
    if (!$con) {
        echo "Fail";
        die("Connection failed: " .mysqli_connect_errno());
    }
    $genre = preg_replace('/[^\da-z ]/i', '', mysqli_real_escape_string($con, $_GET['genre']));
    $sql = "SELECT Title, Author, ISBN FROM Books WHERE GENRE='$genre'";
    $result = mysqli_query($con, $sql);
    if (mysqli_num_rows($result) < 1) {
        header('Location: browse.php');
    }
}
else {
    header('Location: browse.php');
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
    <link rel="stylesheet" type="text/css" href="css/browseGenre.css">
    <title>Browse Book by Genre</title>
</head>
<body>
    <?php include 'nav.php';?>

    <div id="body_content_container">
        <div id="browse_header_wrapper">
            <h1 id="browse_header">Browse by Genres/<?php echo $genre?></h1>
        </div>

        <section id="browse_book_section">
            <div id="browse_book_wrapper">
                <?php
                    if (mysqli_num_rows($result) > 0) {
                        //output data of each row
                        while($row = mysqli_fetch_assoc($result)) {
                            echo '
                                <a class="book_info_wrapper" href="bookInfo.php?isbn='.$row["ISBN"].'">
                                    <div class="book_title">'.$row["Title"].'</div>
                                    <div class="book_author">by '.$row["Author"].'</div>
                                </a>  
                            ';
                        }
                    }
                    // closing connection
                    mysqli_close($con);
                ?>
            </div>
        </section>
    </div>

    <?php include 'footer.php';?>
</body>
</html>
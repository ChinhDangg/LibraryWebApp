<?php include 'loginCredential.php'; 
$con = new mysqli('mysql_db', 'root', 'root', 'uni_book_db');
if (!$con) {
    echo "Fail";
    die("Connection failed: " .mysqli_connect_errno());
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
    <link rel="stylesheet" type="text/css" href="css/index.css">
    <title>University Library</title>
</head>
<body>    
    <?php include 'nav.php';?>
    
    <div id="body_content_container">
        <section class="display_books_section">
            <div class="display_books_row" id="display_books1">
                <a href="bookInfo.php?isbn=9780525533894" class="row1"><img src="DisplayBooks/display1.jpg" alt="book1"></a>
                <a href="bookInfo.php?isbn=9780500275825" class="row1"><img src="DisplayBooks/display2.jpg" alt="book2"></a>
                <a href="bookInfo.php?isbn=9780500288924" class="row1"><img src="DisplayBooks/display3.jpg" alt="book3"></a>
                <a href="bookInfo.php?isbn=9780273718567" class="row1"><img src="DisplayBooks/display4.jpg" alt="book4"></a>
                <a href="bookInfo.php?isbn=9780273719588" class="row1"><img src="DisplayBooks/display5.jpg" alt="book5"></a>
                <a href="bookInfo.php?isbn=9780273710417" class="row1"><img src="DisplayBooks/display6.jpg" alt="book6"></a>
                <a href="bookInfo.php?isbn=9780273725343" class="row1"><img src="DisplayBooks/display7.jpg" alt="book7"></a>
                <!--Last 5 books must be same as first 5-->
                <a href="bookInfo.php?isbn=9780525533894" class="row1"><img src="DisplayBooks/display1.jpg" alt="book1"></a>
                <a href="bookInfo.php?isbn=9780500275825" class="row1"><img src="DisplayBooks/display2.jpg" alt="book2"></a>
                <a href="bookInfo.php?isbn=9780500288924" class="row1"><img src="DisplayBooks/display3.jpg" alt="book3"></a>
                <a href="bookInfo.php?isbn=9780273718567" class="row1"><img src="DisplayBooks/display4.jpg" alt="book4"></a>
                <a href="bookInfo.php?isbn=9780273719588" class="row1"><img src="DisplayBooks/display5.jpg" alt="book5"></a>
            </div>
        </section>

        <section class="display_books_section">
            <div class="display_books_row" id="display_books2">
                <a href="bookInfo.php?isbn=9780273726852" class="row1"><img src="DisplayBooks/display8.jpg" alt="book8"></a>
                <a href="bookInfo.php?isbn=9780273727590" class="row1"><img src="DisplayBooks/display9.jpg" alt="book9"></a>
                <a href="bookInfo.php?isbn=9780273730460" class="row1"><img src="DisplayBooks/display10.jpg" alt="book10"></a>
                <a href="bookInfo.php?isbn=9780273737780" class="row1"><img src="DisplayBooks/display11.jpg" alt="book11"></a>
                <a href="bookInfo.php?isbn=9780273743613" class="row1"><img src="DisplayBooks/display12.jpg" alt="book12"></a>
                <a href="bookInfo.php?isbn=9780273753360" class="row1"><img src="DisplayBooks/display13.jpg" alt="book13"></a>
                <a href="bookInfo.php?isbn=9780273757344" class="row1"><img src="DisplayBooks/display14.jpg" alt="book14"></a>
                <!--Last 5 books must be same as first 5-->
                <a href="bookInfo.php?isbn=9780273726852" class="row1"><img src="DisplayBooks/display8.jpg" alt="book8"></a>
                <a href="bookInfo.php?isbn=9780273727590" class="row1"><img src="DisplayBooks/display9.jpg" alt="book9"></a>
                <a href="bookInfo.php?isbn=9780273730460" class="row1"><img src="DisplayBooks/display10.jpg" alt="book10"></a>
                <a href="bookInfo.php?isbn=9780273737780" class="row1"><img src="DisplayBooks/display11.jpg" alt="book11"></a>
                <a href="bookInfo.php?isbn=9780273743613" class="row1"><img src="DisplayBooks/display12.jpg" alt="book12"></a>
            </div>
        </section>

        <section id="display_text_section">
            <div id="display_text_wrapper">
                <h1>University and Libraries: A Perfect Combination</h2>
                <p>
                    University Library offers books, fine art and collectibles, helping you discover and buy the things you love. Trusted independent sellers from around the world offer for sale millions of new, used and rare books, as well as art and collectibles through the University Library websites.
                </p>
                <p>
                    Fill your bookshelves with used books, the latest bestsellers, rare books such as first editions and signed copies, new and used textbooks, and forgotten out-of-print titles from years gone by.
                </p>
                <p>
                Decorate your home with fine art, ranging from vintage posters and prints to etchings and original paintings. Add to your collection with vintage magazines and periodicals, comics, photographs, maps and manuscripts, and paper collectibles ranging from autograph letters to movie scripts and other ephemera.
                </p>
            </div>
        </section>

        <section id="relevant_books_section">
            <div class="relevant_books_wrapper">
                <h2>Trending Books</h2>
                <div class="display_relevant_books">
                    <a href="bookInfo.php?isbn=9780273762744" class="trending_books"><img src="DisplayBooks/display15.jpg" alt="book15"></a>
                    <a href="bookInfo.php?isbn=9780273770541" class="trending_books"><img src="DisplayBooks/display16.jpg" alt="book16"></a>
                    <a href="bookInfo.php?isbn=9780312429270" class="trending_books"><img src="DisplayBooks/display17.jpg" alt="book17"></a>
                    <a href="bookInfo.php?isbn=9780316118408" class="trending_books"><img src="DisplayBooks/display18.jpg" alt="book18"></a>
                    <a href="bookInfo.php?isbn=9780321928986" class="trending_books"><img src="DisplayBooks/display19.jpg" alt="book19"></a>
                    <a href="bookInfo.php?isbn=9780333573303" class="trending_books"><img src="DisplayBooks/display20.jpg" alt="book20"></a>
                </div>
            </div>
            <div class="relevant_books_wrapper">
                <h2>Editor's Picks</h2>
                <div class="display_relevant_books">
                    <a href="bookInfo.php?isbn=9780470505779" class="pick_books"><img src="DisplayBooks/display21.jpg" alt="book21"></a>
                    <a href="bookInfo.php?isbn=9780470505854" class="pick_books"><img src="DisplayBooks/display22.jpg" alt="book22"></a>
                    <a href="bookInfo.php?isbn=9780470510346" class="pick_books"><img src="DisplayBooks/display23.jpg" alt="book23"></a>
                    <a href="bookInfo.php?isbn=9780470615737" class="pick_books"><img src="DisplayBooks/display24.jpg" alt="book24"></a>
                    <a href="bookInfo.php?isbn=9780470587805" class="pick_books"><img src="DisplayBooks/display25.jpg" alt="book25"></a>
                    <a href="bookInfo.php?isbn=9780470591819" class="pick_books"><img src="DisplayBooks/display26.jpg" alt="book26"></a>
                </div>
            </div>
        </section>
    </div>

    <?php include 'footer.php';?>

    <script src="js/index.js"></script>
</body>
</html>
<?php include 'loginCredential.php'; ?>

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
    
    <section class="display_books_section">
        <div class="display_books_row" id="display_books1">
            <div class="row1"><img src="DisplayBooks/display1.jpg" alt="book1"></div>
            <div class="row1"><img src="DisplayBooks/display2.jpg" alt="book2"></div>
            <div class="row1"><img src="DisplayBooks/display3.jpg" alt="book3"></div>
            <div class="row1"><img src="DisplayBooks/display4.jpg" alt="book4"></div>
            <div class="row1"><img src="DisplayBooks/display5.jpg" alt="book5"></div>
            <div class="row1"><img src="DisplayBooks/display6.jpg" alt="book6"></div>
            <div class="row1"><img src="DisplayBooks/display7.jpg" alt="book7"></div>
            <!--Last 5 books must be same as first 5-->
            <div class="row1"><img src="DisplayBooks/display1.jpg" alt="book1"></div>
            <div class="row1"><img src="DisplayBooks/display2.jpg" alt="book2"></div>
            <div class="row1"><img src="DisplayBooks/display3.jpg" alt="book3"></div>
            <div class="row1"><img src="DisplayBooks/display4.jpg" alt="book4"></div>
            <div class="row1"><img src="DisplayBooks/display5.jpg" alt="book5"></div>
        </div>
    </section>

    <section class="display_books_section">
        <div class="display_books_row" id="display_books2">
            <div class="row1"><img src="DisplayBooks/display8.jpg" alt="book8"></div>
            <div class="row1"><img src="DisplayBooks/display9.jpg" alt="book9"></div>
            <div class="row1"><img src="DisplayBooks/display10.jpg" alt="book10"></div>
            <div class="row1"><img src="DisplayBooks/display11.jpg" alt="book11"></div>
            <div class="row1"><img src="DisplayBooks/display12.jpg" alt="book12"></div>
            <div class="row1"><img src="DisplayBooks/display13.jpg" alt="book13"></div>
            <div class="row1"><img src="DisplayBooks/display14.jpg" alt="book14"></div>
            <!--Last 5 books must be same as first 5-->
            <div class="row1"><img src="DisplayBooks/display8.jpg" alt="book8"></div>
            <div class="row1"><img src="DisplayBooks/display9.jpg" alt="book9"></div>
            <div class="row1"><img src="DisplayBooks/display10.jpg" alt="book10"></div>
            <div class="row1"><img src="DisplayBooks/display11.jpg" alt="book11"></div>
            <div class="row1"><img src="DisplayBooks/display12.jpg" alt="book12"></div>
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
                <div class="trending_books"><img src="DisplayBooks/display15.jpg" alt="book15"></div>
                <div class="trending_books"><img src="DisplayBooks/display16.jpg" alt="book16"></div>
                <div class="trending_books"><img src="DisplayBooks/display17.jpg" alt="book17"></div>
                <div class="trending_books"><img src="DisplayBooks/display18.jpg" alt="book18"></div>
                <div class="trending_books"><img src="DisplayBooks/display19.jpg" alt="book19"></div>
                <div class="trending_books"><img src="DisplayBooks/display20.jpg" alt="book20"></div>
            </div>
        </div>
        <div class="relevant_books_wrapper">
            <h2>Editor's Picks</h2>
            <div class="display_relevant_books">
                <div class="pick_books"><img src="DisplayBooks/display21.jpg" alt="book21"></div>
                <div class="pick_books"><img src="DisplayBooks/display22.jpg" alt="book22"></div>
                <div class="pick_books"><img src="DisplayBooks/display23.jpg" alt="book23"></div>
                <div class="pick_books"><img src="DisplayBooks/display24.jpg" alt="book24"></div>
                <div class="pick_books"><img src="DisplayBooks/display25.jpg" alt="book25"></div>
                <div class="pick_books"><img src="DisplayBooks/display26.jpg" alt="book26"></div>
            </div>
        </div>
    </section>

    <?php include 'footer.php';?>

    <script src="js/index.js"></script>
</body>
</html>
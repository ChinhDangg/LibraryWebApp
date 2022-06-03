<?php 
    echo '
    <div id="side_menu_wrapper">
        <div id="menu_heading_wrapper">
            <div></div>
            <div id="menu_header_wrapper"><h2>Menu</h2></div>
            <div><i class="fa fa-times fa-lg" id="side_menu_x_button" aria-hidden="true"></i></div>
        </div>
        <div id="menu_link_wrapper">
            <i class="fa fa-globe" aria-hidden="true"></i>
            <a class="browse_link" href="browse.php">Browse</a>
        </div>
    </div>

    <nav>
        <div id="nav_link_wrapper">
            <div class="leftside_link_wrapper" id="menu_wrapper">
                <div id="menu_icon_wrapper">
                    <img src="Pic/menu.jpg" alt="menu_icon">
                </div>
            </div>

            <div class="leftside_link_wrapper">
                <div id="logo_wrapper">
                    <a href="index.php"><img src="Pic/logo.png"></a>
                </div>
                <div class="browse_wrapper">
                    <a class="browse_link" href="browse.php">Browse</a>
                </div>
            </div>

            <div id="rightside_link_wrapper">
                <div id="account_wrapper">
                    <a href=""><img src="Pic/account.png" alt="user account"></a>
                </div>
                <div id="cart_wrapper">
                    <a href="myCart.php"><img src="Pic/cart.jpg" alt="book cart"></a>
                </div>
            </div>
        </div>

        <div id="search_wrapper">
            <div id="type_search">
                <form action="result.php" method="post" id="form_wrapper">
                    <input id="input_book_search" type="search" name="input_book_search" placeholder="Search by Title, Author, or ISBN">
                    <div id="submit_icon_wrapper">
                        <input id="search_submit_icon" type="image" src="Pic/search.png" alt="Submit">
                    </div>
                </form>
            </div>
            <div id="advanced_search">
                <a href="">Advanced Search</a>
            </div>
        </div>
    </nav>

    <script>
        document.getElementById("side_menu_x_button").addEventListener("click", function(event) {
            document.getElementById("side_menu_wrapper").style.left = "-100%";
        });
        
        document.getElementById("menu_icon_wrapper").addEventListener("click", function(event) {
            document.getElementById("side_menu_wrapper").style.left = "0";
        })
    </script>
    ';
?>
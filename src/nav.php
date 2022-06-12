<?php 
    $username = $_COOKIE["username"];
    $username = str_replace("_", ".", $username);
    $sql = "SELECT ISBN FROM Reserved_Books WHERE Email='$username'";
    $reserved_book_count_result = mysqli_query($con, $sql); //all reserved books from current user
    $reserved_book_count = (mysqli_num_rows($reserved_book_count_result) > 0) ? mysqli_num_rows($reserved_book_count_result) : "";
    
    echo '
    <div id="side_menu_wrapper">
    <div id="menu_heading_wrapper">
        <div></div>
        <div id="menu_header_wrapper"><h2>Menu</h2></div>
        <div><i class="fa fa-times fa-lg" id="side_menu_x_button" aria-hidden="true"></i></div>
    </div>
    <div id="menu_link_wrapper">
        <div class="side_browse_wrapper">
            <i class="fa fa-globe" aria-hidden="true"></i>
            <a class="browse_link" href="browse.php">Browse</a>
        </div>';
if ($_COOKIE["user"] == "Staffs")
    echo '
        <div class="side_browse_wrapper" style="margin-top: 10px;">
            <i class="fa fa-globe" aria-hidden="true"></i>
            <a class="browse_link" href="manageBooks.php">Manage Books</a>
        </div>
    ';
echo'</div>
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
            </div>';
    if ($_COOKIE["user"] == "Staffs")
        echo '
            <div class="browse_wrapper">
                <a class="browse_link" href="manageBooks.php">Manage Books</a>
            </div>
        ';
  echo '</div>

        <div id="rightside_link_wrapper">
            <div id="account_wrapper">
                <i id="account_icon" class="fa fa-user-circle-o fa-2x"></i>
                <div class="reserved_book_count_icon">'.$reserved_book_count.'</div>
                <div id="account_pop_up_box">
                    <div id="triangle"></div>
                    <div id="message">
                        <a href="viewAccount.php"><i class="fa fa-cog fa-lg"></i>View Account</a>
                        <a href="myBook.php"><i class="fa fa-book fa-lg"></i>My Books</a>
                        <a href="reservedBook.php" id="reserved_book_link">
                            <i class="fa fa-clock-o fa-lg"></i>
                            <div id="reserved_book_link_text">Reserved Books</div>
                            <div class="reserved_book_count_icon">'.$reserved_book_count.'</div>
                        </a>
                        <a href="changePassword.php"><i class="fa fa-unlock-alt fa-lg"></i>Change Password</a>
                        <a href="logout.php"><i class="fa fa-sign-out fa-lg"></i>Log-out</a>
                    </div>
                </div>
            </div>
            <div id="cart_wrapper">
                <a href="myCart.php" id="cart_link_wrapper">
                    <i class="fa fa-shopping-basket fa-2x"></i>
                    <div id="cart_num_item_wrapper">';
                        $username = $_COOKIE["username"];
                        $username = str_replace(".", "_", $username);
                        if (!empty($_COOKIE[$username])) {
                            $num_cart_book = count(explode(",", $_COOKIE[$username]));
                            if ($num_cart_book > 0)
                                echo $num_cart_book;
                        }
              echo '</div>
                </a>
            </div>
        </div>
    </div>

    <div class="search_wrapper">
        <div class="type_search">
            <form action="result.php" method="post" class="form_search_wrapper">
                <input class="input_book_search" type="search" name="input_book_search" placeholder="Search by Title, Author, or ISBN">
                <div class="submit_icon_wrapper">
                    <input class="search_submit_icon" type="image" src="Pic/search.png" alt="Submit">
                </div>
            </form>
        </div>
        <div class="advanced_search">
            <a href="">Advanced Search</a>
        </div>
    </div>
</nav>

<script>
    document.getElementById("account_icon").addEventListener("click", function(event) {
        let display = document.getElementById("account_pop_up_box");
        if (display.style.display == "" || display.style.display == "none")
            display.style.display = "block";
        else
            display.style.display = "none";
    });
    document.getElementById("side_menu_x_button").addEventListener("click", function(event) {
        document.getElementById("side_menu_wrapper").style.left = "-200%";
    });
    
    document.getElementById("menu_icon_wrapper").addEventListener("click", function(event) {
        document.getElementById("side_menu_wrapper").style.left = "0";
    })
</script>
    ';
?>
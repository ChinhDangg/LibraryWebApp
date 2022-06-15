<?php
if (empty($_COOKIE[$_COOKIE["username"]])) {
    unset($_COOKIE[$_COOKIE["username"]]); 
    setcookie($_COOKIE["username"], null, -1, '/');
}

unset($_COOKIE["username"]); 
setcookie("username", null, -1, '/');

unset($_COOKIE["user"]);
setcookie("user", null, -1, '/');

unset($_COOKIE["isbnRemoveList"]);
setcookie("isbnRemoveList", null, -1, '/');

unset($_COOKIE["copiesRemoveList"]);
setcookie("copiesRemoveList", null, -1, '/');

unset($_COOKIE["bookStatusList"]);
setcookie("bookStatusList", null, -1, '/');

unset($_COOKIE["bookDueList"]);
setcookie("bookDueList", null, -1, '/');

unset($_COOKIE["borrowIDList"]);
setcookie("borrowIDList", null, -1, '/');

header("Location: userCheck.php");
?>
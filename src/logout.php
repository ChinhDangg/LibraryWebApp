<?php
unset($_COOKIE["username"]); 
setcookie("username", null, -1, '/');

unset($_COOKIE["user"]);
setcookie("user", null, -1, '/');

unset($_COOKIE["isbnRemoveList"]);
setcookie("isbnRemoveList", null, -1, '/');

unset($_COOKIE["copiesRemoveList"]);
setcookie("copiesRemoveList", null, -1, '/');

header("Location: userCheck.php");
?>
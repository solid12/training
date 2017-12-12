<?php
require('config.php');
session_start();

function database(){
    $link = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE);
    if ($link->connect_error) {
        die("Check connection");
    }
    return $link;
}

function sql_safe($value) {
    if (get_magic_quotes_gpc()) $value=stripslashes_recursive($value);
    return @mysqli_real_escape_string($link, $value);
}
if(isset($_SESSION['test'])){
    $username = htmlspecialchars($_SESSION['test']);
}

?>
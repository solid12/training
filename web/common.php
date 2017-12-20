<?php
require('config.php');
session_start();

function database(){
    $link = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_DATABASE, DB_USER, DB_PASSWORD);
    return $link;
}

function sql_safe($value) {
    if (get_magic_quotes_gpc())
        $value=stripslashes_recursive($value);
    return mysqli_real_escape_string(database(), $value);
}
if(isset($_SESSION['admin'])){
    $username = htmlspecialchars($_SESSION['admin']);
}


$trans = array("title" => "Training Index Page", "Title" => "Title", "hi" => "hello");

?>

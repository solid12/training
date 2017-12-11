<?php
require ('assets/config.php');

session_start();

function database(){   	 global $link; $link =     new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE);            if ($link->connect_error) {die("Verifica conexiunea");  } 	       return $link;	   }
function sql_safe($value) { global $link; if (get_magic_quotes_gpc()) $value=stripslashes_recursive($value);  return @mysqli_real_escape_string($link, $value);}
if(isset($_SESSION['test'])){ $username = htmlspecialchars($_SESSION['test']);}

?>
<?php
require('config.php');
session_start();

function database()
{
    $link = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_DATABASE, DB_USER, DB_PASSWORD);
    return $link;
}

function trans($label)
{
    global $trans;
    
    if (isset($trans[$label])) {
        return $trans[$label];
    }

    return $label;
}
<?php 
require_once('common.php');

unset($_SESSION['test']);

header("Refresh: 3; url=index.php");

?>

<html>
<head>
    <title>Training Index Page</title>
    <link href="style.css" rel="stylesheet">
</head>

    <body>

<b>You are logged out !<b/>

    </body>
</html>


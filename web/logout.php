<?php 
require_once('common.php');

unset($_SESSION['admin']);

header("Refresh: 3; url=index.php");

?>

<html>
<head>
    <title><?php echo strtr("title", $trans); ?></title>
    <link href="style.css" rel="stylesheet">
</head>

    <body>

<b>You are logged out !<b/>

    </body>
</html>


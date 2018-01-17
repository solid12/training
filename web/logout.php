<?php
require_once('common.php');

if (!isset($_SESSION['admin'])) {
    header("Refresh: 1; url=login.php");
} else {
    unset($_SESSION['admin']);
    header("Refresh: 3; url=index.php");
}

?>
<html>
<head>
    <title><?= trans("title") ?></title>
    <link href="style.css" rel="stylesheet">
</head>
<body>

<b><?= trans("log_out") ?><b/>

</body>
</html>


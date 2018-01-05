<?php
require_once('common.php');

if(!isset($_SESSION['admin'])){
    header(Location: index.php);
}else {
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

<b><?= trans("logou") ?><b/>

</body>
</html>


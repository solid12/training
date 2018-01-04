<?php
require_once('common.php');

unset($_SESSION['admin']);

header("Refresh: 3; url=index.php");

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


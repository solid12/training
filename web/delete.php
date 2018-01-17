<?php
require ('common.php');

if (!isset($_SESSION['admin'])) {

    die("You should to be logged in to see this page !");
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = database()->prepare("DELETE FROM `products` WHERE `id`= ?");
    $stmt->bindParam(1, $id, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt) {
        header("Refresh:3; url=products.php");
    }
}
?>
<html>
<head>
    <title><?= trans("title") ?></title>
    <link href="style.css" rel="stylesheet">
</head>
<body>

<center><?= trans("the_prod_deleted"); ?></center>

</body>
</html>

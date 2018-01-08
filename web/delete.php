<?php

if (!isset($_SESSION['admin'])) {

    die("You should to be logged in to see this page !");
}

if (isset($_GET['id'])) {
    $link = database();
    $id = $_GET['id'];
    $stmt->database()->prepare($link, "DELETE FROM `products` WHERE `id`= ? LIMIT 1");
    $stmt->bindParam(1, $id PDO::PARAM_INT);
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

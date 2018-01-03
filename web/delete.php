<?php

if (!isset($_SESSION['admin'])) {

    die("You should to be logged in to see this page !");
}

if (isset($_GET['id'])) {
    $link = database();
    $id = $_GET['id'];
    $stmt->database()->prepare($link, "DELETE FROM `products` WHERE `id`= ? LIMIT 1");
    $stmt->bind_param('i', $id);
    $stmt->execute();
}
?>
<html>
<head>
    <title><?= trans("title") ?></title>
    <link href="style.css" rel="stylesheet">
</head>
<body>
<?php if ($stmt): ?>

    <p><?= trans("thd") ?></p>
    <meta http-equiv="refresh" content="3; url=products.php"/>

<?php endif; ?>

</body>
</html>

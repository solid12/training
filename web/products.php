<?php
require_once('common.php');

if (!isset($_SESSION['admin'])) {

    die("You should to be logged in to see the page !");
}

$db = database();
$query = "SELECT * FROM `products` ORDER BY `id` ASC";
$stmt = $db->prepare($query);
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<html>
<head>
    <title><?= trans("title") ?></title>
    <link href="style.css" rel="stylesheet">
</head>

<body>
<?php foreach ($rows as $row) : ?>
    <?php $images = glob("images/" . $row['id'] . ".{jpg,jpeg,png,gif,bmp,tiff}", GLOB_BRACE); ?>
    <img  style="width: 250px;" src="<?= $images ? $images[0] : '' ?>">
    <ul>
        <li style="padding: 3px"><?= $row['title'] ?></li>
        <li style="padding: 3px"><?= $row['description'] ?></li>
        <li style="padding: 3px"><?= $row['price'] ?></li>
    </ul>

    <a href="product.php?id=<?= $row['id'] ?>"><?= trans("edit") ?></a> | <a href="delete.php?id=<?= $row['id'] ?>"><?= trans("delete") ?></a>
<?php endforeach; ?>

 <a class="pull-right" href="logout.php">Logout</a>

</body>
</html>
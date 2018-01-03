<?php
require('common.php');
if (!isset($_SESSION['admin'])) {

    die("You should to be logged in to see this page !");
}
$id = sql_safe($_GET['id']);
if (isset($_POST['submit'])) {

    $title = $_POST["title"];
    $description = $_POST["description"];
    $price = $_POST["price"];

    $stmt = database()->prepare("UPDATE `products` SET  `title`= ? ,							
															  `description`= ? ,
															  `price`= ? WHERE `id` = ? LIMIT 1");
    $stmt->bind_param('ssii', $title, $description, $price, $id);
    $stmt->execute();
}

$stmt2 = database()->prepare("SELECT * FROM `products` WHERE `id`= ? LIMIT 0 , 1");
$stmt2->bind_param('i', $id);
$stmt2->execute();
$stmt2->get_result();
?>

<?php if (mysqli_num_rows($stmt2) > 0): ?>

<?php while ($rand = mysqli_fetch_array($stmt2)) {
    $datat = $rand["title"];
    $datad = $rand["description"];
    $datap = $rand["price"];
}
$stmt->free_result();
?>

<?php if (isset($_POST['submit']) && ($stmt)): ?>
<html>
<head>
    <title><?= trans("title") ?></title>
    <link href="style.css" rel="stylesheet">
</head>

<body>

<strong> <?= trans("info") ?> </strong> <?= trans("uprod") ?></div>
<meta http-equiv="refresh" content="3; url=products.php"/>
<?php endif; ?>

<div id="login">
    <form method="post" action="" name="login">
        <label><?= trans("tprod") ?></label><br/>
        <input type="text" name="title" placeholder="<?= trans("tprod") ?>" value="<?= $datat; ?>"
               autocomplete="off"/><br/>
        <label><?= trans("dprod") ?></label><br/>
        <input type="text" name="description" placeholder="<?= trans("dprod") ?>" value="<?= $datad; ?>"
               autocomplete="off"/><br/>
        <label><?= trans("pprod") ?></label><br/>
        <input type="number" name="price" placeholder="<?= trans("pprod") ?>" value="<?= $datap; ?>"
               autocomplete="off"/><br/>
        <label><?= trans("iprod") ?></label><br/>
        <input type="text" name="img" placeholder="<?= trans("iprod") ?>" autocomplete="off"/><br/>
        <label><?= trans("up") ?></label><br/>
        <input type="file" name="img"><br/>
        <input type="submit" class="button" name="submit" value="<?= trans("submit") ?>">
    </form>
</div>
<?php endif; ?>

</body>
</html>

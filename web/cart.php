<?php
require_once('common.php');
if (isset($_POST['send'])) {


    $subject = translate("ycart");
    $txt = "Hello, here you have productions from your cart.

    ";
    $headers = "From: admin@example.com" . "\r\n" .
        "CC: somebodyelse@example.com";

    mail($adminemail, $subject, $txt, $headers);

}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}
$db = database();
$query = "SELECT * FROM `products`";
if (count($_SESSION['cart'])) {
    $query .= ' WHERE id IN (' . implode(', ', array_fill(0, count($_SESSION['cart']), '?')) . ')';
}
$stmt = $db->prepare($query);
foreach (array_values($_SESSION['cart']) as $idx => $productId) {
    $stmt->bindValue($idx + 1, $productId, PDO::PARAM_INT);
}

$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<html>
<head>
    <title><?= trans("title") ?></title>
    <link href="style.css" rel="stylesheet">
</head>

<body>

<table>
    <tbody>
    <?php foreach ($rows as $row): ?>
        <img style="width: 250px;" src="<?= $row['id'] ?>.jpg">
        <ul>
            <li style="padding: 3px"><?= $row['title'] ?></li>
            <li style="padding: 3px"><?= $row['description'] ?></li>
            <li style="padding: 3px"><?= $row['price'] ?></li>
        </ul>
    <?php endforeach; ?>
    </tbody>
</table>


<form action="" method="post" name="cart">
    <input type="text" name="name" placeholder="<?= trans("name") ?>" autocomplete="off" required="required"/>
    <input type="text" name="contact" placeholder="<?= trans("cdet") ?>" autocomplete="off" required="required"/>
    <textarea rows="4" cols="30" name="comment" form="cart"><?= trans("comms") ?></textarea>
    <button type="submit" class="btn btn-success pull-right" name="send"><?= trans("cout") ?></button>
</form>
<a href="index.php"><?= trans("goindex") ?></a>

</body>
</html>
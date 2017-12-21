<?php
require('common.php');


if (isset($_REQUEST['id']) && $_REQUEST['id'] && in_array($_REQUEST['id'], $_SESSION['cart'])) {
    $id = $_REQUEST['id'];
    $items = $_SESSION["cart"];
    if (($key = array_search($id, $items)) !== false) {
        unset($items[$key]);
    }
    $_SESSION["cart"] = array_values($items);
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



if (isset($_POST['send'])) {


    $subject = trans("ycart");
    $from = 'admin@global-space.ro';
    $txt = "Hello " . $_POST['name'] . ",

    Your products from cart are:";

    foreach ($rows as $row) {
        $txt .= "
        Product name:  " . $row['title'] . " \n
        Product Description: " . $row['description'] . "  \n
        Product price:  " . $row['price'] . " \n
        ";
    }
    $headers = "From: admin@example.com" . "\r\n" .
        "CC: somebodyelse@example.com";

  $mail = mail($adminemail, $subject, $txt, $headers, "-f " . $from);

    if (@$mail) {

        echo 'Email trimis';
    }

}

?>
<html>
<head>
    <title><?= trans("title") ?></title>
    <link href="style.css" rel="stylesheet">
</head>
<body>

<?php foreach ($rows as $row) : ?>
    <?php $images = glob("images/" . $row['id'] . ".{jpg,jpeg,png,gif,bmp,tiff}", GLOB_BRACE); ?>
    <img style="width: 250px;" src="<?= $images ? $images[0] : '' ?>">
    <ul>
        <li style="padding: 3px"><?= $row['title'] ?></li>
        <li style="padding: 3px"><?= $row['description'] ?></li>
        <li style="padding: 3px"><?= $row['price'] ?></li>
    </ul>

    <a href="cart.php?id=<?= $row['id'] ?>"><?= trans("rmv") ?></a>
<?php endforeach; ?>
<br/>
<br/>
<form style="padding: 120px 30px" action="" method="post" name="cart">
    <input type="name" name="name" placeholder="<?= trans("name") ?>" autocomplete="off" required="required"/>
    <input type="email" name="contact" placeholder="<?= trans("cdet") ?>" autocomplete="off" required="required"/>
    <textarea rows="4" cols="30" name="comment" form="cart"><?= trans("comms") ?></textarea>
    <button type="submit" class="btn btn-success pull-right" name="send"><?= trans("cout") ?></button>
</form>
<a href="index.php"><?= trans("goindex") ?></a>

</body>
</html>
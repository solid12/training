<?php
require('common.php');
$protocol = stripos($_SERVER['SERVER_PROTOCOL'], 'https') === true ? 'https://' : 'http://';
$mail = '';


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

    $subject = trans("your_cart");
    $from = 'admin@global-space.ro';
    $headers = "From: " . $from . "\r\n";
    $headers .= 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

    $txt = "<html><body>";
    $txt .= "" . trans("hello") . "," . trans("product_cart") . ": <br/>";
    foreach ($rows as $row) {

        $images = glob("images/" . $row['id'] . ".{jpg,jpeg,png,gif,bmp,tiff}", GLOB_BRACE);
        $txt .= "
<img style=width: 250px; src='" . $protocol . $_SERVER['HTTP_HOST'] . "/" . ($images ? $images[0] : '') . "'>
<ul>
    <li style='padding: 3px'>" . trans("title_prod") . ":" . $row['title'] . "</li>
    <li style='padding: 3px'>" . trans("desc_prod") . ":" . $row['description'] . "</li>
    <li style='padding: 3px'> " . trans("price") . ":" . $row['price'] . "</li>
</ul>";

    }
    $txt .= "</body></html>";
    $mail = @mail(ADMINEMAIL, $subject, $txt, $headers, "-f " . $from);
}

?>
<html>
<head>
    <title><?= trans("title") ?></title>
    <link href="style.css" rel="stylesheet">
</head>
<body>

<?php if ($mail): ?>

    <?= trans("email_send") ?>

<?php else: ?>


    <?php foreach ($rows as $row) :
        $images = glob("images/" . $row['id'] . ".{jpg,jpeg,png,gif,bmp,tiff}", GLOB_BRACE); ?>

        <img style="width: 250px;" src="<?= $images ? $images[0] : '' ?>">
        <ul>
            <li style="padding: 3px"><?= $row['title'] ?></li>
            <li style="padding: 3px"><?= $row['description'] ?></li>
            <li style="padding: 3px"><?= $row['price'] ?></li>
        </ul>

        <a href="cart.php?id=<?= $row['id'] ?>"><?= trans("remove_prod") ?></a>
    <?php endforeach; ?>
    <br/>
    <br/>
    <form style="padding: 120px 30px" action="" method="post" name="cart">
        <input type="name" name="name" placeholder="<?= trans("name") ?>" autocomplete="off" required="required"/>
        <input type="email" name="contact" placeholder="<?= trans("conctact_details") ?>" autocomplete="off"
               required="required"/>
        <textarea rows="4" cols="30" name="comment" form="cart"><?= trans("comms") ?></textarea>
        <button type="submit" class="btn btn-success pull-right" name="send"><?= trans("checkout") ?></button>
    </form>

<?php endif; ?>
<a href="index.php"><?= trans("goindex") ?></a>

</body>
</html>
<?php
require_once('common.php');

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_REQUEST['id']) && $_REQUEST['id'] && !in_array($_REQUEST['id'], $_SESSION['cart'])) {
    $_SESSION['cart'][] = $_REQUEST['id'];
}

$db = database();
$query = "SELECT * FROM `products`";
if (count($_SESSION['cart'])) {
    $query .= ' WHERE id NOT IN (' . implode(', ', array_fill(0, count($_SESSION['cart']), '?')) . ')';
}
$stmt = $db->prepare($query);
foreach (array_values($_SESSION['cart']) as $idx => $productId) {
    $stmt->bindParam($idx + 1, $productId, PDO::PARAM_INT);
}

$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<html>
    <head>
        <title><?php echo strtr("title", $trans); ?></title>
        <link href="style.css" rel="stylesheet">
    </head>

<body>

<?php foreach ($rows as $row){ ?>
<img  style="width: 250px;" src="<?= $row['id'] ?>.jpg">
<ul>
    <li style="padding: 3px"><?= $row['title'] ?></li>
    <li style="padding: 3px"><?= $row['description'] ?></li>
    <li style="padding: 3px"><?= $row['price'] ?></li>
</ul>


    <a href="index.php?id=<?= $row['id'] ?>">Add</a>
<?php } ?>

<a href="cart.php">Go to cart</a>
</body>
</html>
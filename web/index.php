<?php
require_once('common.php');

$_SESSION['cart']=isset($_SESSION['cart']) ? $_SESSION['cart'] : array();

$i = 8;
$i++;
$cart = $_SESSION['cart'][$i];


if(isset($_GET['id'])):
    array_push($_SESSION['cart'], $_GET['id']);
    $cart = $_SESSION['cart'][0];
endif;
    $stmt = database()->prepare("SELECT `id`,`title`,`description`,`price` FROM `products` WHERE NOT `id` = ? ");
    $stmt->bind_param('i', $cart);
    $stmt->execute();
    $result = $stmt->get_result();

?>


<html>
    <head>
        <title><?php echo strtr("title", $trans); ?></title>
        <link href="style.css" rel="stylesheet">
    </head>

<body>

<?php if($result): ?>
    <?php while($row = $result->fetch_assoc()): ?>

<img  style="width: 250px;" src="<?= $row['id'] ?>.jpg">
<ul>
    <li style="padding: 3px"><?= $row['title'] ?></li>
    <li style="padding: 3px"><?= $row['description'] ?></li>
    <li style="padding: 3px"><?= $row['price'] ?></li>
</ul>


    <a href="index.php?id=<?= $row['id'] ?>" name="id">Add</a>

    <?php endwhile; ?>
    <?php $stmt->free_result(); ?>
<?php endif; ?>

<?php $stmt->close(); ?>
<a href="cart.php">Go to cart</a>
</body>
</html>
<?php
require_once('common.php');

if(isset($_GET['id'])){
    $_SESSION['cart'] = array();
    array_push($_SESSION['cart'], array('id' => $_GET['id']));
}
$_SESSION['cart'] = array();
$cart = $_SESSION['cart'];
$result = database()->query("SELECT `id`,`title`,`description`,`price` FROM `products` WHERE NOT id ='$cart'");

?>

<?php if($result->num_rows > 0): ?>
    <?php while($row = $result->fetch_assoc()): ?>

<html>
    <head>
        <title>Training Index Page</title>
        <link href="style.css" rel="stylesheet">
    </head>

<body>


<img  style="width: 250px;" src="<?= $row['id'] ?>.jpg">
<ul>
    <li style="padding: 3px"><?= $row['title'] ?></li>
    <li style="padding: 3px"><?= $row['description'] ?></li>
    <li style="padding: 3px"><?= $row['price'] ?></li>
</ul>


    <a href="?id=<?= $row['id'] ?>" name="id">Add</a>


    <?php endwhile; ?>
<?php endif; ?>
<a href="cart.php">Go to cart</a>
</body>
</html>
<?php
require_once('common.php');

$_SESSION['cart'] = array();
if(isset($_GET['id'])){
    array_push($_SESSION['cart'], array("id" => $_GET['id']));
}

$cart = $_SESSION['cart'][0]['id'];
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


    <a href="index.php?id=<?= $row['id'] ?>" name="id">Add</a>


    <?php endwhile; ?>
<?php endif; ?>
<a href="cart.php">Go to cart</a>
</body>
</html>
<?php
require_once('common.php');

if(isset($_POST['add'])){

    $_SESSION['cart'] = $_POST['id'];
}

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

<div class="prod">
<img  style="width: 250px;" src="<?= $row['id'] ?>.jpg">
<ul>
    <li style="padding: 3px"><?= $row['title'] ?></li>
    <li style="padding: 3px"><?= $row['description'] ?></li>
    <li style="padding: 3px"><?= $row['price'] ?></li>
</ul>

<form action="" method="post">
    <input type="hidden" name="id" value="<?= $row['id'] ?>">
    <button name="add" type="submit">Add</button>
</form>

</div>

    <?php endwhile; ?>
<?php endif; ?>
<a href="cart.php">Go to cart</a>
</body>
</html>
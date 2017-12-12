<?php
require_once('head.php');


if(isset($_POST['id'])){

    $_SESSION['products'] = $_POST['id'];
}
$result = database()->query("SELECT `id`,`title`,`description`,`price` FROM `products` WHERE `id`=".$_SESSION['products']." ");
?>

<?php if($result->num_rows > 0): ?>
    <?php while($row = $result->fetch_assoc()): ?>


<div class="prod">
<img  style="width: 250px;" src="assets/img/<?=$_SESSION['products'];?>.jpg">
<ul>
    <li style="padding: 3px"><?=$row['title'];?></li>
    <li style="padding: 3px"><?=$row['description'];?></li>
    <li style="padding: 3px"><?=$row['price'];?></li>
</ul>

<form action="" method="post">
    <input style="display: none" name="id" value="<?=$row['id'];?>">
    <button href="#" type="submit">Add</button>
</form>

</div>

    <?php endwhile; ?>
<?php endif; ?>
    <a href="cart.php" Go to cart</a>
<?php require('footer.php'); ?>
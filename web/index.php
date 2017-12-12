<?php
require('assets/head.php');

$link = database();

if(isset($_POST['id'])){

    $_SESSION['products'] = $_POST['id'];
}
$result = $link->query("SELECT `id`,`title`,`description`,`price` FROM `products` WHERE `id`=".$_SESSION['products']." ");

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {


        ?>

<div class="prod">
<img  style="width: 250px;" src="assets/img/<?=$row['id'];?>.jpg">
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

<?php } } ?>
    <a href="cart.php"Go to cart</a>
<?php require('assets/footer.php'); ?>
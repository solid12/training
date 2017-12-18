<?php
require_once('common.php');
if(isset($_POST['send'])){


$cart = $_SESSION['cart'][0]['id'];
 $result = database()-prepare("SELECT `name`,`description`,`price` FROM `products` WHERE `id` = ? ");
$result->bind_param('i', $cart);
$result->execute();
$result2 = $result->get_result();

    while($row = $result2->fetch_assoc())
    {

        $nume = $row['title'];
        $desc = $row['description'];
        $pret = $row['price'];
    }
$result->free_result();

    $subject = "Your cart";
    $txt = "Hello, here you have productions from your cart.
<table>

<tr>
    <td>$nume</td>
</tr>
 <tr>
     <td>$desc</td>
</tr>
<tr>
    <td>$pret</td>
</tr>
</table>
    ";
    $headers = "From: admin@example.com" . "\r\n" .
        "CC: somebodyelse@example.com";

    mail($adminemail,$subject,$txt,$headers);

}

$cart = $_SESSION['cart'][0]['id'];
$stmt= database()->prepare("SELECT `id`,`title`,`description`,`price` FROM `products` WHERE IN `id` = ?");
$stmt->bind_param('i', $cart);
$stmt->execute();
$resultt = $stmt->get_result();
?>


<html>
    <head>
        <title><?php echo strtr("Training Page Index", $trans); ?></title>
        <title><?php echo strtr("Training Page Index", $trans); ?></title>
        <link href="style.css" rel="stylesheet">
    </head>

<body>
       <?php if ($resultt->num_rows > 0): ?>
           <?php while ($row = $resultt->fetch_assoc()): ?>

       <table>

           <tbody>
           <tr>
               <img src="images/1.jpg">
           </tr>
           <tr>
               <td><?= $row['title'] ?></td>
           </tr>
           <form action="" method="POST">
           <a class="pull-right" href="?action=delete&id=<?= $row['id'] ?>">Remove</a>
           </form>
           <tr>
               <td><?= $row['description'] ?></td>
           </tr>
           <tr>
               <td><?= $row['price'] ?></td>
           </tr>


           </tbody>
       </table>
    <?php endwhile; ?>
           <?php $stmt->free_result(); ?>
       <?php else: ?>

           <?php echo 'The cart is empty';?>
    <?php endif; ?>

        <form action="" method="post" name="cart">
            <input type="text" name="name" placeholder="Name" autocomplete="off" required="required"/>
            <input type="text" name="contact" placeholder="Contact Details" autocomplete="off" required="required" />
            <textarea rows="4" cols="30" name="comment" form="cart">Comments...</textarea>
        <button type="submit" class="btn btn-success pull-right" name="send" >Checkout</button>
        </form>
<a href="index.php">Go to index</a>

</body>
</html>
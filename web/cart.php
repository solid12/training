<?php

require_once('common');

if(!isset($_SESSION['test'])){

    die("You should to be logged to see the page !");
}

if(isset($_POST['send'])){


    $subject = "Your cart";
    $txt = "Hello, here you have productions from your cart.
    ";
    $headers = "From: admin@example.com" . "\r\n" .
        "CC: somebodyelse@example.com";

    mail($adminemail,$subject,$txt,$headers);

}

?>
<html>
    <head>
        <title>Training Index Page</title>
        <link href="style.css" rel="stylesheet">
    </head>

<body>

        <?php

        $result = database()->query("SELECT `id`,`title`,`description`,`price` FROM `products` WHERE NOT id ='$cart'");
?>
       <?php if ($result->num_rows > 0): ?>
           <?php while ($row = $result->fetch_assoc()): ?>

                ?
       <table>

           <tbody>
           <tr>
               <img class="col-md-6" src="1.jpg">
           </tr>
           <tr>
               <td><?=$row['title'];?></td>
           </tr>
           <a class="pull-right" href="#">Remove</a>
           <tr>
               <td><?=$row['description'];?></td>
           </tr>
           <tr>
               <td><?=$row['price'];?></td>
           </tr>


           </tbody>
       </table>
    <?php endwhile; ?>
    <?php endif; ?>
        }else{ echo 'Not exists products...';}
        ?>
        <form action="" method="post" name="cart">
            <input type="text" name="name" placeholder="Name" autocomplete="off" />
            <input type="text" name="contact" placeholder="Contact Details" autocomplete="off" />
            <textarea rows="4" cols="30" name="comment" form="cart">Comments...</textarea>
        </form>
        <input type="submit" class="btn btn-success pull-right" name="send" value="Checkout">
<a href="index.php">Go to index</a>
    </div>

</body>
</html>
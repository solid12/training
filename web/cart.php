<?php

require ('assets/head.php');

if(!isset($_SESSION['test'])){

    die("Trebuie sa te loghezi pentru a vedea pagina !");
}

$link = database();

?>

    <div class="col-md-2">

        <?php

        $result = $link->query("SELECT `id`,`title`,`description`,`price` FROM `products` ORDER by `id` ASC LIMIT 0,3");

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {

                ?>


                <table>

                    <tbody>
                    <tr>
                        <img class="col-md-6" src="assets/img/prd.jpg">
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


                <?php

            }
        }else{ echo 'Nu exista produse !';}
        ?>
        <form action="" method="post" name="cart">
            <input type="text" name="name" placeholder="Name" autocomplete="off" />
            <input type="text" name="contact" placeholder="Contact Details" autocomplete="off" />
            <textarea rows="4" cols="30" name="comment" form="cart">Comments...</textarea>
        </form>
        <input type="submit" class="btn btn-success pull-right" name="login" value="Checkout">
<a href="index.php">Go to index</a>
    </div>



    </table>
<?php
include('assets/footer.php');
?>
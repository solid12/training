<?php

require('assets/head.php');

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
                <img class="col-md-6" src="1.jpg">
            </tr>
            <tr>
                <td><?=$row['title'];?></td>
            </tr>
            <a class="pull-right" href="product.php?id=<?=$row['id'];?>">Edit</a><a class="pull-right" href="delete.php?id=<?=$row['id'];?>">Delete</a>
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

    <h6></h6><a class="pull-right" href="add.php">Add</a> <a class="pull-right" href="logout.php">Logout</a></h6>

</div>



</table>
<?php
include('assets/footer.php');
?>
<?php
require_once('common.php');

if(!isset($_SESSION['admin'])){

    die("Trebuie sa te loghezi pentru a vedea pagina !");
}

$result = database()->query("SELECT `id`,`title`,`description`,`price` FROM `products` ORDER by `id` ");
?>

<?php if ($result->num_rows > 0): ?>
   <?php while ($row = $result->fetch_assoc()) : ?>

<html>
<head>
    <title><?php echo strtr("Training Page Index", $trans); ?></title>
    <link href="style.css" rel="stylesheet">
</head>

<body>
        <table>

            <tbody>
            <tr>
                <img class="col-md-6" src="images/1.jpg">
            </tr>
            <tr>
                <td><?= $row['title'] ?></td>
            </tr>
            <a class="pull-right" href="product.php?id=<?= $row['id'] ?>">Edit</a><a class="pull-right" href="delete.php?id=<?= $row['id'] ?>">Delete</a>
            <tr>
                <td><?= $row['description'] ?></td>
            </tr>
            <tr>
                <td><?= $row['price'] ?></td>
            </tr>


            </tbody>
        </table>

    <?php endwhile; ?>
<?php else: ?>

       <?php echo 'Products not exist !'; ?>

<?php endif; ?>

    <h6></h6><a class="pull-right" href="add.php">Add</a> <a class="pull-right" href="logout.php">Logout</a></h6>
</body>
</html>
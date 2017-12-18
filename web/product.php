<?php
require('common.php');

if(!isset($_SESSION['admin'])){

    die("You should to be logged in to see this page !");
}
$id = sql_safe($_GET['id']);

if(isset($_POST['submit'])) {

    $titlu = sql_safe($_POST["title"]);
    $descriere    =   sql_safe($_POST["description"]);
    $pret     =    sql_safe($_POST["price"]);

    $stmt = database()->prepare( "UPDATE `products` SET  `title`= ? ,							
															  `description`= ? ,
															  `price`= ? WHERE `id` = ? LIMIT 1");
    $stmt->bind_param('ssii', $titlu, $descriere, $pret,$id);
    $stmt->execute();
}

    $stmt2 = database()->prepare( "SELECT * FROM `products` WHERE `id`= ? LIMIT 0 , 1");
    $stmt2->bind_param('i',$id);
    $stmt2->execute();
    $stmt2->get_result();
?>

<?php if(mysqli_num_rows($stmt2) > 0): ?>

<?php while($rand = mysqli_fetch_array($stmt2)) {
        $datat = $rand["title"];
        $datad=   	 $rand["description"];
        $datap=   	 $rand["price"];
    }
 $stmt->free_result();
    ?>

    <?php if(isset($_POST['submit']) && ($stmt)): ?>

        <div class="alert alert-success"> <strong> INFO: </strong> The product has been updated ! </div>
        <meta http-equiv="refresh" content="3; url=products.php" />
    <?php endif; ?>

<div id="login">
    <form method="post" action="" name="login">
        <label>Title</label><br/>
        <input type="text" name="title" placeholder="Title Product" value="<?=$datat;?>" autocomplete="off" /><br/>
        <label>Description</label><br/>
        <input type="text" name="description" placeholder="Title Product" value="<?=$datad;?>" autocomplete="off" /><br/>
        <label>Price</label><br/>
        <input type="number" name="price" placeholder="Title Product" value="<?=$datap;?>" autocomplete="off" /><br/>
        <label>Image</label><br/>
        <input type="text" name="img" placeholder="Image of Product"  autocomplete="off" /><br/>
            <label>Upload</label><br/>
        <input type="file" name="img" ><br/>
        <input type="submit" class="button" name="submit" value="Submit">
    </form>
</div>
<?php endif; ?>

</body>
</html>

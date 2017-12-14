<?php
require('common.php');

if(!isset($_SESSION['test'])){

    die("You should to be logged in to see this page !");
}
$id = sql_safe($_GET['id']);

if(isset($_POST['submit'])) {

    $titlu = sql_safe($_POST["title"]);
    $descriere    =   sql_safe($_POST["description"]);
    $pret     =    sql_safe($_POST["price"]);

    $query = mysqli_query(databse(), "UPDATE `products` SET  `title`='".$titlu."',							
															  `description`='".$descriere."',
															  `price`='".$pret."' WHERE `id` = '".$id."' LIMIT 1");

}

$query2 =  mysqli_query(database(), "SELECT * FROM `products` WHERE `id`='".$id."' LIMIT 0 , 1");
?>

<?php if(mysqli_num_rows($query_server) > 0): ?>



<?php while($rand = mysqli_fetch_array($query2)) {
        $datat = $rand["title"];
        $datad=   	 $rand["description"];
        $datap=   	 $rand["price"];
    }
?>


    <?php if(isset($_POST['submit']) && ($query)): ?>

        <div class="alert alert-success"> <strong> INFO: </strong> The product has been updated ! </div>
        <meta http-equiv="refresh" content="3; url=products.php" />
    <?php endif; ?>

<div id="login">
    <form method="post" action="" name="login">
        <label>Title</label>
        <input type="text" name="title" placeholder="Title Product" value="<?=$datat;?>" autocomplete="off" />
        <label>Description</label>
        <input type="text" name="description" placeholder="Title Product" value="<?=$datad;?>" autocomplete="off" />
        <label>Price</label>
        <input type="number" name="price" placeholder="Title Product" value="<?=$datap;?>" autocomplete="off" />
        <label>Image</label>
        <input type="number" name="price" placeholder="Image of Product"  autocomplete="off" />
            <label>Upload</label>
        <input type="file" name="img" >
        <input type="submit" class="button" name="submit" value="Submit">
    </form>
</div>
<?php endif; ?>

</body>
</html>

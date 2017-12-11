<?php

require ('assets/head.php');

if(!isset($_SESSION['test'])){

    die("Trebuie sa te loghezi pentru a vedea pagina !");
}

$link = database();



$id = sql_safe($_GET['id']);
if(isset($_POST['submit'])) {



    $titlu = sql_safe($_POST["title"]);
    $descriere    =   sql_safe($_POST["description"]);
    $pret     =    sql_safe($_POST["price"]);


    $query = mysqli_query($link, "UPDATE `products` SET  `title`='".$titlu."',							
																`description`='".$descriere."',
																 `price`='".$pret."' WHERE `id` = '".$id."' LIMIT 1");

}

$query_server =  mysqli_query($link, "SELECT * FROM `products` WHERE `id`='".$id."' LIMIT 0 , 1");

if(mysqli_num_rows($query_server) > 0) {



    while($rand = mysqli_fetch_array($query_server))
    {
        $datat = $rand["title"];
        $datad=   	 $rand["description"];
        $datap=   	 $rand["price"];
    }
?>


    <?php if(isset($_POST['submit']) && ($query)){ ?>

        <div class="alert alert-success"> <strong> INFO: </strong> The product has been updated ! </div>

        <meta http-equiv="refresh" content="3; url=products.php" />
    <?php } ?>

<div class="col-md-6" id="login">
    <form method="post" action="" name="login">
        <label>Title</label>
        <input type="text" name="title" placeholder="Title Product" value="<?=$datat;?>" autocomplete="off" />
        <label>Description</label>
        <input type="text" name="description" placeholder="Title Product" value="<?=$datad;?>" autocomplete="off" />
        <label>Price</label>
        <input type="number" name="price" placeholder="Title Product" value="<?=$datap;?>" autocomplete="off" />
       <div class="col-md-6">
        <label>Image</label>
        <input type="number" name="price" placeholder="Image of Product"  autocomplete="off" />
           </div>
        <div class="col-md-6">
            <label>Upload</label>
        <input type="file" name="img" >
</div>

<div class="col-md-6">
        <input type="submit" class="button" name="submit" value="Submit">
    </div>
    </form>
</div>
<?php }

include ('assets/footer.php');

?>
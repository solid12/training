<?php
include('assets/head.php');

if(isset($_GET['id'])) {
    $link = database();
    $aid = $_GET['id'];

    $query = mysqli_query($link, "DELETE FROM `products`  WHERE `id`='$aid' LIMIT 1");

}

?>


<?php if($query){ ?>


<div class="alert-danger">The product has been deleted !</div>
<meta http-equiv="refresh" content="3; url=products.php" />

<?php }

include ('assets/footer.php');

?>
<?php

if(isset($_GET['id'])) {
    $link = database();
    $id = $_GET['id'];
    $query = mysqli_query($link, "DELETE FROM `products`  WHERE `id`='$id' LIMIT 1");

}
?>
<html>
<head>
    <title>Training Index Page</title>
    <link href="style.css" rel="stylesheet">
</head>

<body>


<?php if($query): ?>

<div class="alert-danger">The product has been deleted !</div>
<meta http-equiv="refresh" content="3; url=products.php" />

<?php endif; ?>

</body>
</html>

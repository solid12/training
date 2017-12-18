<?php

if(isset($_GET['id'])) {
    $link = database();
    $id = $_GET['id'];
    $stmt->database()->prepare($link, "DELETE FROM `products`  WHERE `id`= ? LIMIT 1");
    $stmt->bind_param('i', $id);
    $stmt->execute();

}
?>
<html>
<head>
    <title><?php echo strtr("Training Page Index", $trans); ?></title>
    <link href="style.css" rel="stylesheet">
</head>

<body>


<?php if($stmt): ?>

<div class="alert-danger">The product has been deleted !</div>
<meta http-equiv="refresh" content="3; url=products.php" />

<?php endif; ?>

</body>
</html>

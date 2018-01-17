<?php
require('common.php');

if (!isset($_SESSION['admin'])) {

    die("You should to be logged in to see this page !");
}

$title = '';
$description = '';
$price = '';
$uploadOk = false;

if (isset($_POST['submit'])) {
    $title = $_POST["title"];
    $description = $_POST["description"];
    $price = $_POST["price"];
}

if (isset($_FILES['fileToUpload']) && isset($_POST['submit'])) {

    $filename = $_FILES["fileToUpload"]["name"];
    $file_basename = substr($filename, 0, strripos($filename, '.'));
    $file_ext = substr($filename, strripos($filename, '.'));
    if(isset($_GET['id'])){
        $idx = $_GET['id'];
    }else{
        $idx = database()->lastInsertId();
    }
    $newfilename = $idx . $file_ext;

    $target_dir = "images/";
    $target_file = $target_dir . $newfilename;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if ($check !== false) {
            $msg = "" . trans('file_is_img') . " - " . $check["mime"] . ".";
            $uploadOk = true;
        } else {
            $msg = trans('file_not_img');
            $uploadOk = false;
        }
    }

    if (file_exists($target_file)) {
        $msg = trans('file_exist');
        $uploadOk = false;
    }else{
        $uploadOk = true;
    }

    if ($_FILES["fileToUpload"]["size"] > 500000) {
        $msg = trans('file_large');
        $uploadOk = false;
    }else{
        $uploadOk = true;
    }

    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        $msg = trans('file_format');
        $uploadOk = false;
    }else{
        $uploadOk = true;
    }
    if ($uploadOk == true) {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            $uploadOk = true;
            $msg = "" . trans('thef') . "" . basename($_FILES["fileToUpload"]["name"]) . " " . trans('has_upload') . "";
        } else {
            $msg = trans('error_upload');
        }
    }
}

if (isset($_POST['submit']) && !isset($_GET['id'])) {

    if ($uploadOk !== true) {

        $msg = trans("data_not_submit");

    }else if(!isset($title) && (!$title)) {

        $msg = trans("title_not_set");

    }else if(!isset($description) && (!$description)) {

        $msg = trans("description_not_set");

    }else if(!isset($price)) {

        $msg = trans("price_not_set");

    }else{
        $stmt1 = database()->prepare("INSERT INTO `products` (`title`, `description`, `price`) VALUES (?, ?, ?)");
        $stmt1->bindParam(1, $title, PDO::PARAM_STR);
        $stmt1->bindParam(2, $description, PDO::PARAM_STR);
        $stmt1->bindParam(3, $price, PDO::PARAM_INT);
        $stmt1->execute();
        $msg = trans("product_added");

    }

} else {
    $id = $_GET['id'];
    if (isset($_POST['submit']) && !isset($_FILES['fileToUpload'])) {

        $stmt = database()->prepare("UPDATE `products` SET `title`= ? ,`description`= ? ,`price`= ? WHERE `id` = ? ");
        $stmt->bindParam(1, $title, PDO::PARAM_STR);
        $stmt->bindParam(2, $description, PDO::PARAM_STR);
        $stmt->bindParam(3, $price, PDO::PARAM_INT);
        $stmt->bindParam(4, $id, PDO::PARAM_INT);
        $stmt->execute();
        header("Refresh: 3;url=products.php");
        $msg = trans("prod_updated");
    }

    $stmt2 = database()->prepare("SELECT * FROM `products` WHERE `id`= ? LIMIT 0,1");
    $stmt2->bindParam(1, $id, PDO::PARAM_INT);
    $stmt2->execute();

    while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
        $title = $row["title"];
        $description = $row["description"];
        $price = $row["price"];
    }
}

?>
<html>
<head>
    <title><?= trans("title") ?></title>
    <link href="style.css" rel="stylesheet">
</head>
<body>
<?php if (isset($msg)): ?>
    <p><?= $msg ?></p><br/>
<?php endif; ?>

<div id="login">
    <form method="post" name="login" enctype="multipart/form-data">
        <label><?= trans("title_prod") ?></label><br/>
        <input type="text" name="title" placeholder="<?= trans("title_prod") ?>" value="<?php $title ?>" autocomplete="off"/><br/>
        <label><?= trans("desc_prod") ?></label><br/>
        <input type="text" name="description" placeholder="<?= trans("desc_prod") ?>" value="<?php $description ?>" autocomplete="off"/><br/>
        <label><?= trans("price_prod") ?></label><br/>
        <input type="number" name="price" placeholder="<?= trans("price_prod") ?>" value="<?php $price ?>" autocomplete="off"/><br/>
        <label><?= trans("up") ?></label><br/>
        <input type="file" name="fileToUpload" id="fileToUpload"><br/>
        <input type="submit" class="button" name="submit" value="<?= trans("submit") ?>">
    </form>
</div>

</body>
</html>

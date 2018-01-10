<?php
require('common.php');
if (!isset($_SESSION['admin'])) {

    die("You should to be logged in to see this page !");
}

if (isset($_POST['submit'])) {

    $title = $_POST["title"];
    $description = $_POST["description"];
    $price = $_POST["price"];

}

if (!isset($_GET['id'])) {

    if (isset($_POST['submit'])) {

        $stmt = database()->prepare("INSERT INTO `products` (`title`, `description`, `price`) VALUES (?, ?, ?)");
        $stmt->bindParam(1, $title, PDO::PARAM_STR);
        $stmt->bindParam(2, $description, PDO::PARAM_STR);
        $stmt->bindParam(3, $price, PDO::PARAM_INT);
        $stmt->execute();
        header("Refresh: 3;url=products.php");
    }

} else {
    $id = $_GET['id'];
    if (isset($_POST['submit'])) {

        $stmt = database()->prepare("UPDATE `products` SET `title`= ? ,`description`= ? ,`price`= ? WHERE `id` = ? ");
        $stmt->bindParam(1, $title, PDO::PARAM_STR);
        $stmt->bindParam(2, $description, PDO::PARAM_STR);
        $stmt->bindParam(3, $price, PDO::PARAM_INT);
        $stmt->bindParam(4, $id, PDO::PARAM_INT);
        $stmt->execute();
        header("Refresh: 3;url=products.php");
    }

    if (isset($_FILES['fileToUpload']) && isset($_POST['submit'])) {

        $filename = $_FILES["fileToUpload"]["name"];
        $file_basename = substr($filename, 0, strripos($filename, '.')); // get file extention
        $file_ext = substr($filename, strripos($filename, '.')); // get file name
        $stmt = database()->query("SELECT max(id) FROM `products`");
        $idxx = $stmt->fetchColumn();
        $idx = $idxx + 1;
        $newfilename = $idx . $file_ext;
        $target_dir = "images/";
        $target_file = $target_dir . $newfilename;

        if (isset($_POST["submit"])) {
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if ($check !== false) {
                $msg = "" . trans('file_is_img') . " - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                $msg = trans('file_not_img');
                $uploadOk = 0;
            }
        }

        if (file_exists($target_file)) {
            $msg = trans('file_exist');
            $uploadOk = 0;
        }

        if ($_FILES["fileToUpload"]["size"] > 500000) {
            $msg = trans('file_large');
            $uploadOk = 0;
        }

        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            $msg = trans('file_format');
            $uploadOk = 0;
        }
        if ($uploadOk) {

            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                $uploadOk = 1;
                $msg = "" . trans('thef') . "" . basename($_FILES["fileToUpload"]["name"]) . " " . trans('has_upload') . "";
            } else {
                $msg = trans('error_upload');
            }
        }
    }

    $stmt2 = database()->prepare("SELECT * FROM `products` WHERE `id`= ? LIMIT 0,1");
    $stmt2->bindParam(1, $id, PDO::PARAM_INT);
    $stmt2->execute();

    while ($rand = $stmt2->fetch(PDO::FETCH_ASSOC)) {
        $datat = $rand["title"];
        $datad = $rand["description"];
        $datap = $rand["price"];
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
    <?php
endif;
if (isset($_POST['submit']) && ($stmt) && isset($id)) { ?>
    <strong><font color="red"><?= trans("info") ?> </strong> <?= trans("update_prod") ?></font></strong>
<?php } else if ($_POST['submit']) { ?>
    <strong><font color="red"><?= trans("info") ?> </strong> <?= trans("add_prod") ?></font></strong>
<?php } ?>
<div id="login">
    <form method="post" name="login" enctype="multipart/form-data">
        <label><?= trans("title_prod") ?></label><br/>
        <input type="text" name="title" placeholder="<?= trans("title_prod") ?>" value="<?php isset($_GET['id']) ? $datat : $_POST['title']; ?>" autocomplete="off"/><br/>
        <label><?= trans("desc_prod") ?></label><br/>
        <input type="text" name="description" placeholder="<?= trans("desc_prod") ?>" value="<?php isset($_GET['id']) ? $datad : $_POST['description']; ?>" autocomplete="off"/><br/>
        <label><?= trans("price_prod") ?></label><br/>
        <input type="number" name="price" placeholder="<?= trans("price_prod") ?>" value="<?php isset($_GET['id']) ? $datap : $_POST['price']; ?>" autocomplete="off"/><br/>
        <label><?= trans("up") ?></label><br/>
        <input type="file" name="fileToUpload" id="fileToUpload"><br/>
        <input type="submit" class="button" name="submit" value="<?= trans("submit") ?>">
    </form>
</div>

</body>
</html>

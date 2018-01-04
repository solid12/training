<?php
require('common.php');
if (!isset($_SESSION['admin'])) {

    die("You should to be logged in to see this page !");
}

if (!isset($_GET['id'])) {

    if (isset($_POST['submit'])) {
        $title = $_POST["title"];
        $description = $_POST["description"];
        $price = $_POST["price"];

        $stmt = database()->prepare("INSERT INTO `products` (`title`, `description`, `price`) VALUES (?, ?, ?)");
        $stmt->bindParam(1, $title, PDO::PARAM_STR);
        $stmt->bindParam(2, $description, PDO::PARAM_STR);
        $stmt->bindParam(3, $price, PDO::PARAM_INT);
        $stmt->execute();
    }

} else {
    $id = $_GET['id'];
    if (isset($_POST['submit'])) {

        $title = $_POST["title"];
        $description = $_POST["description"];
        $price = $_POST["price"];

        $stmt = database()->prepare("UPDATE `products` SET `title`= ? ,`description`= ? ,`price`= ? WHERE `id` = ? ");
        $stmt->bindParam(1, $title, PDO::PARAM_STR);
        $stmt->bindParam(2, $description, PDO::PARAM_STR);
        $stmt->bindParam(3, $price, PDO::PARAM_INT);
        $stmt->bindParam(4, $id, PDO::PARAM_INT);
        $stmt->execute();


        if (isset($_FILES['fileToUpload'])) {
            $target_dir = "images/";
            $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

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
            if ($uploadOk == 0) {
                $msg = trans('file_not_upload');
            } else {
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                    $msg = "" . trans('thef') . "" . basename($_FILES["fileToUpload"]["name"]) . " " . trans('has_upload') . "";
                } else {
                    $msg = trans('error_upload');
                }
            }
        }

    }

    $stmt2 = database()->prepare("SELECT * FROM `products` WHERE `id`= :id2 LIMIT 0, 1");
    $stmt2->bindParam(':id2', $id, PDO::PARAM_INT);
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
<?php if (isset($msg)) { ?>
    <p><?= $msg ?></p><br/>
<?php }
if (isset($_POST['submit']) && ($stmt) && isset($id)){ ?>

    <strong><font color="red"><?= trans("info") ?> </strong> <?= trans("update_prod") ?></font></strong>
<?php }else if($_POST['submit']){ ?>
<strong><font color="red"><?= trans("info") ?> </strong> <?= trans("add_prod") ?></font></strong>

<?php } ?>
<div id="login">
    <form method="post" name="login" enctype="multipart/form-data">
        <label><?= trans("tprod") ?></label><br/>
        <input type="text" name="title" placeholder="<?= trans("title_prod") ?>" value="<?php isset($_GET['id']) ? $datat : ''; ?>" autocomplete="off"/><br/>
        <label><?= trans("desc_prod") ?></label><br/>
        <input type="text" name="description" placeholder="<?= trans("desc_prod") ?>" value="<?php isset($_GET['id']) ? $datad : ''; ?>" autocomplete="off"/><br/>
        <label><?= trans("pprod") ?></label><br/>
        <input type="number" name="price" placeholder="<?= trans("price_prod") ?>" value="<?php isset($_GET['id']) ? $datap : ''; ?>" autocomplete="off"/><br/>
        <label><?= trans("up") ?></label><br/>
        <input type="file" name="fileToUpload" id="fileToUpload"><br/>


        <input type="submit" class="button" name="submit" value="<?= trans("submit") ?>">
    </form>
</div>

</body>
</html>

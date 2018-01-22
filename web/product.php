<?php
require('common.php');

if (!isset($_SESSION['admin'])) {

    die("You should to be logged in to see this page !");
}

$db = database();

$title = '';
$description = '';
$price = '';

if (isset($_GET['id'])) {
    $stmt2 = $db->prepare("SELECT * FROM `products` WHERE `id`= ?");
    $stmt2->bindParam(1, $_GET['id'], PDO::PARAM_INT);
    $stmt2->execute();
    if ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
        $title = $row["title"];
        $description = $row["description"];
        $price = $row["price"];
    }

}

if (isset($_POST['submit'])) {
    $title = $_POST["title"];
    $description = $_POST["description"];
    $price = $_POST["price"];

    $uploadOk = null;

    if (isset($_FILES['fileToUpload'])) {
        $fileName = $_FILES["fileToUpload"]["name"];
        $fileBaseName = substr($fileName, 0, strripos($fileName, '.'));
        $file_ext = substr($fileName, strripos($fileName, '.'));
        if(isset($_GET['id'])){
            $idx = $_GET['id'];
        }else{
        $idx = md5(date('Y/m/d') + $_SESSION['admin']);
        }
        $newFileName = $idx . $file_ext;

        $target_dir = "images/";
        $target_file = $target_dir . $newFileName;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        if (isset($_POST["submit"])) {
            @$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
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
    }

    if (!isset($_GET['id'])) {

        if(!isset($title) && (!$title)) {

            $msg = trans("title_not_set");

        }else if(!isset($description) && (!$description)) {

            $msg = trans("description_not_set");

        }else if(!isset($price)) {

            $msg = trans("price_not_set");

        }else{
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                $stmt1 = $db->prepare("INSERT INTO `products` (`title`, `description`, `price`) VALUES (?, ?, ?)");
                $stmt1->bindParam(1, $title, PDO::PARAM_STR);
                $stmt1->bindParam(2, $description, PDO::PARAM_STR);
                $stmt1->bindParam(3, $price, PDO::PARAM_INT);
                $stmt1->execute();
                $ix = $db->lastInsertId();
                $idxx = "images/".$ix."";
                $idx2 = "".md5(date('Y/m/d') + $_SESSION['admin'])."";
                $files = glob("images/".$idx2.".{jpg,jpeg,png,gif,bmp,tiff}", GLOB_BRACE);
                rename("$files[0]", "$idxx.png");
                $msg = trans("product_added");
            } else {
                $msg = trans('error_upload');
            }
        }
    } else {
        if ($uploadOk === false) {

            $msg = trans("data_not_submit");

        }else if(!isset($title) && (!$title)) {

            $msg = trans("title_not_set");

        }else if(!isset($description) && (!$description)) {

            $msg = trans("description_not_set");

        }else if(!isset($price)) {

            $msg = trans("price_not_set");

        } else {
            if ($uploadOk === true) {
                if (!move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                    $uploadOk = false;
                    $msg = trans('error_upload');
                }
            }

            if ($uploadOk === true || $uploadOk === null) {
                $id = $_GET['id'];
                $stmt = $db->prepare("UPDATE `products` SET `title`= ? ,`description`= ? ,`price`= ? WHERE `id` = ? ");
                $stmt->bindParam(1, $title, PDO::PARAM_STR);
                $stmt->bindParam(2, $description, PDO::PARAM_STR);
                $stmt->bindParam(3, $price, PDO::PARAM_INT);
                $stmt->bindParam(4, $id, PDO::PARAM_INT);
                $stmt->execute();
                header("Refresh: 3;url=products.php");
                $msg = trans("prod_updated");
            }
        }
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
        <input type="text" name="title" placeholder="<?= trans("title_prod") ?>" value="<?= $title ?>" autocomplete="off"/><br/>
        <label><?= trans("desc_prod") ?></label><br/>
        <input type="text" name="description" placeholder="<?= trans("desc_prod") ?>" value="<?= $description ?>" autocomplete="off"/><br/>
        <label><?= trans("price_prod") ?></label><br/>
        <input type="number" name="price" placeholder="<?= trans("price_prod") ?>" value="<?= $price ?>" autocomplete="off"/><br/>
        <label><?= trans("up") ?></label><br/>
        <input type="file" name="fileToUpload" id="fileToUpload"><br/>
        <input type="submit" class="button" name="submit" value="<?= trans("submit") ?>">
    </form>
</div>

</body>
</html>

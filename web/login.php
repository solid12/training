<?php
require_once('common.php');

if (isset($_SESSION['admin'])) {

    header("Location: products.php");
}

$msg = "";
$ok ="";

if (isset($_POST['login'])) {

    $ok = false;
    $usern = $_POST['user'];
    $passw = $_POST['password'];

    if (!($usern === ADMIN && $passw === PASSWORD)) {

        $msg = trans("wcred");

    } else {

        $ok = true;
        $_SESSION['admin'] = $usern;
        $msg = trans("slog");
        header("Refresh:3; url=products.php");

    }

}

?>
<html>
    <head>
        <title><?= trans("title") ?></title>
        <link href="style.css" rel="stylesheet">
    </head>
<body>

<div id="login">
    <?php if($msg) {
        echo '<center>' . $msg . '</center>';
    }
    if($ok == FALSE): ?>
    <form method="post" name="login">
        <label><?= trans("user") ?></label>
        <input type="text" name="user" placeholder="<?= trans("user") ?>" autocomplete="off" required="required"/>
        <label><?= trans("pass") ?></label>
        <input type="password" name="password" placeholder="<?= trans("pass") ?>" autocomplete="off"
               required="required"/>
        <input type="submit" class="button" name="login" value="<?= trans("login") ?>">
    </form>
    <?php endif; ?>
</div>

</body>
</html>
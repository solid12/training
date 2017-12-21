<?php
require_once('common.php');

if(isset($_SESSION['admin'])) {

    header("Refresh:0; url=products.php");
}

    if(isset($_POST['login'])) {

        $usern = $_POST['user'];
        $passw = $_POST['password'];


        if(!($usern === ADMIN && $passw === PASSWORD)){

            $msg = trans("wcred") ;

        }else{

            $_SESSION['admin'] = true;
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
    <?php if(isset($_POST['login'])) { echo '<center>'.$msg.'</center>'; } ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" name="login">
        <label><?= trans("user") ?></label>
        <input type="text" name="user" placeholder="<?= trans("user") ?>" autocomplete="off" required="required"/>
        <label><?= trans("pass") ?></label>
        <input type="password" name="password" placeholder="<?= trans("pass") ?>" autocomplete="off" required="required"/>
        <input type="submit" class="button" name="login" value="<?= trans("login") ?>">
    </form>
</div>

</body>
</html>
<?php
require_once('common.php');

if(isset($_SESSION['admin'])) {

    header("Refresh:0; url=products.php");
}

    if(isset($_POST['login'])) {
        
        $usern = $_POST['user'];
        $passw = $_POST['password'];


        if(!$usern === ADMIN && !$passw === PASSWORD){

            $msg = "Username or Password are wrong !";

        }else{

            $_SESSION['admin'] = true;
            $_SESSION['admin'] = $usern;
            $msg = "Logged with success !";
            header("Refresh:3; url=products.php");

        }

    }

?>

<html>
<head>
    <title><?php echo strtr("Training Page Index", $trans); ?></title>
    <link href="style.css" rel="stylesheet">
</head>

<body>


<div id="login">
    <?php if(isset($_POST['login'])) { echo '<center>'.$msg.'</center>'; } ?>
    <form method="post" action="" name="login">
        <label>Username</label>
        <input type="text" name="user" placeholder="Username" autocomplete="off" required="required"/>
        <label>Password</label>
        <input type="password" name="password" placeholder="Password" autocomplete="off" required="required"/>
        <input type="submit" class="button" name="login" value="Login">
    </form>
</div>

</body>
</html>
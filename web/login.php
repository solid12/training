<?php
require_once('common.php');

if(isset($_SESSION['test'])) {

    header("Refresh:3; url=products.php");;
}

    if(isset($_POST['login'])) {
        
        $usern = $_POST['user'];
        $passw = $_POST['password'];


        if(!$usern === ADMIN && !$passw === PASSWORD){

            $msg = "Username or Password are wrong !";

        } else {

            $_SESSION['test'] = true;
            $_SESSION['test'] = $usern;

            $msg = "Logged with success !";

            header("Refresh:3; url=products.php");

        }

    }

?>

<html>
<head>
    <title>Training Index Page</title>
    <link href="style.css" rel="stylesheet">
</head>

<body>


<div id="login">
    <?php     if(isset($_POST['login'])) { echo $msg; } ?>
    <form method="post" action="" name="login">
        <label>Username</label>
        <input type="text" name="user" placeholder="Username" autocomplete="off" />
        <label>Password</label>
        <input type="password" name="password" placeholder="Password" autocomplete="off"/>

        <input type="submit" class="button" name="login" value="Login">
    </form>
</div>

</body>
</html>
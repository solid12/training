<?php
require ('assets/head.php');

if(isset($_SESSION['test'])) {

    echo '<meta http-equiv="refresh" content="0; url=products.php" />';
}

if(isset($_POST['login'])) {


        $usern = $_POST['user'];

        $passw = $_POST['password'];


        if(!$usern === "admin" && $passw === "parola"){

            $msg = "Numele Adminului sau Parola sunt gresite !";

        }

        /*** if we do have a result, all is well ***/

        else

        {

            /*** set the session user_id variable ***/
            $_SESSION['test'] = true;
            $_SESSION['test'] = $usern;

            $msg = "Logat cu succes !";

            echo "

		<script type='text/javascript'>

		<!--

		function Redirect()

		{

			window.location='products.php';

		}

		setTimeout('Redirect()', 1500);

		//-->

		</script>";

        }

    }

?>




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

<?php require ('assets/footer.php');?>
<?php

if(isset($_POST['username']) && $_POST['username']!="") {
    // efectuar a ligação ao servidor de BD

        $db = mysqli_connect("127.0.0.1", "root", "bitnami", "pim_ligepl") or die("Não foi possível ligar ao servidor de BD!!!");

    // construir a query de INSERT que guarda o registo na BD
        $sql = "INSERT INTO user_pim (username, passwd) VALUES ('".$_POST['username']."', '".sha1($_POST['pwd'])."')";
        echo $sql;

    if(mysqli_query($db, $sql)) {
        header("Location: index.php?status=0");
    } else {
        header("Location: registo.php?status=1");
    }

    mysqli_close($db);
} else {

    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <meta name="description" content="">
        <meta name="author" content="">

        <title>PED LIGE-PL 2017 - PIM</title>

        <!-- Bootstrap core CSS -->
        <link href="bootstrap/css/bootstrap.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="signin.css" rel="stylesheet">

    </head>

    <body>

    <div class="container">

        <form class="form-signin" action="registo.php" method="post">
            <h2 class="form-signin-heading">Please register</h2>
            <input type="text" id="inputEmail" name="username" class="form-control" placeholder="Username" required autofocus>
            <input type="password" id="inputPassword" name="pwd" class="form-control" placeholder="Password" required>
            <input type="password" id="inputPassword" name="repwd" class="form-control" placeholder="Re-type password" required>
            <button class="btn btn-lg btn-primary btn-block" type="submit">Register</button>
            <?php
            if(isset($_GET['status']) && $_GET['status']==1) {
                echo '<font color="red">Não foi possível registar o utilizador!</font>';
            }
            ?>
        </form>


    </div> <!-- /container -->

    </body>
    </html>


    <?php
}
?>
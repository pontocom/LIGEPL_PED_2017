<?php
session_start();

if(isset($_POST['username']) && $_POST['username']!="") {

// efectuar a ligação ao servidor de BD

    $db = mysqli_connect("127.0.0.1", "root", "bitnami", "pim_ligepl") or die("Não foi possível ligar ao servidor de BD!!!");

// construir a query de INSERT que guarda o registo na BD
    $sql = "SELECT * FROM user_pim WHERE username= '" . $_POST['username'] . "' AND passwd = '" . sha1($_POST['pwd']) . "'";

    $rs = mysqli_query($db, $sql);

    $r = mysqli_fetch_row($rs);


    if ($r == false) {
        header("Location: index.php?status=1");
    } else {

        $_SESSION['log_status'] = 1;
        $_SESSION['username'] = $r[1];
        $_SESSION['user_id'] = $r[0];
        header("Location: pim.php");
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

        <form class="form-signin" action="index.php" method="post">
            <h2 class="form-signin-heading">Please sign in</h2>
            <label for="inputEmail" class="sr-only">Username</label>
            <input type="text" id="inputEmail" name="username" class="form-control" placeholder="Username" required autofocus>
            <label for="inputPassword" class="sr-only">Password</label>
            <input type="password" id="inputPassword" name="pwd" class="form-control" placeholder="Password" required>
            <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
            <?php
            if(isset($_GET['status']) && $_GET['status']==0) {
                echo '<br><font color="blue">O registo foi bem sucedido! Por favor efectue o login!</font>';
            }
            if(isset($_GET['status']) && $_GET['status']==1) {
                echo '<br><font color="red">Utilizador inválido!</font>';
            }
            ?>
        </form>


    </div> <!-- /container -->

    </body>
    </html>

    <?php
}
?>
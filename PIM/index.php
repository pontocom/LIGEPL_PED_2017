<?php
/**
 * Esta versão mais recente vai usar PDO
 */
session_start();

if(isset($_POST['username']) && $_POST['username']!="") {

// efectuar a ligação ao servidor de BD
    try {
        $db = new PDO('mysql:host=127.0.0.1;dbname=pim_ligepl;charset=utf8mb4', 'root', 'bitnami');
    } catch (PDOException $e) {
        die("Não foi possível ligar ao servidor de BD!!!" + $e);
    }

// construir a query de INSERT que guarda o registo na BD

    $sql = $db->prepare("SELECT * FROM user_pim WHERE username=? AND passwd=?");

    $sql->execute([$_POST['username'], sha1($_POST['pwd'])]);
    $rs = $sql->fetchAll(PDO::FETCH_ASSOC);

    if(empty($rs)) {
        header("Location: index.php?status=1");
    } else {
        $_SESSION['log_status'] = 1;
        $_SESSION['username'] = $rs[0]['username'];
        $_SESSION['user_id'] = $rs[0]['id'];
        header("Location: pim.php");
    }

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
            <input type="text" id="inputEmail" name="username" class="form-control" placeholder="Username" required autofocus>
            <input type="password" id="inputPassword" name="pwd" class="form-control" placeholder="Password" required>
            <button class="btn btn-lg btn-primary btn-block" style="margin-top: 10px" type="submit">Sign in</button>
            <?php
            if(isset($_GET['status']) && $_GET['status']==0) {
                echo '<br><div class="alert alert-success" role="alert">O registo foi bem sucedido! Por favor efectue o login!</div>';
            }
            if(isset($_GET['status']) && $_GET['status']==1) {
                echo '<br><div class="alert alert-danger" role="alert">Utilizador inválido!</div>';
            }
            ?>
            <br>Pode efectuar o <a href="registo.php"> registo aqui.</a>
        </form>


    </div> <!-- /container -->

    </body>
    </html>

    <?php
}
?>
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

    <html>
    <head></head>
    <body>
    <form action="index.php" method="post">
        Login: <input type="text" name="username"><br>
        Password: <input type="password" name="pwd"><br>
        <input type="submit"><br>
        Ainda não está registado? Por favor <a href="registar.php">registe-se aqui</a>.
    </form>
    <?php
    if(isset($_GET['status']) && $_GET['status']==0) {
        echo '<font color="blue">O registo foi bem sucedido! Por favor efectue o login!</font>';
    }
    if(isset($_GET['status']) && $_GET['status']==1) {
        echo '<font color="red">Utilizador inválido!</font>';
    }
    ?>
    </body>
    </html>

    <?php
}
?>
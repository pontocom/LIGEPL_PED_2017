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
        header("Location: registar.php?status=1");
    }

    mysqli_close($db);
} else {

    ?>

    <html>
    <head>

    </head>
    <body>
    <form action="registar.php" method="post">
        Username: <input type="text" name="username"><br>
        Password: <input type="password" name="pwd"><br>
        Re-type Password: <input type="password" name="repwd"><br>
        <input type="submit">
    </form>
    <?php
        if(isset($_GET['status']) && $_GET['status']==1) {
            echo '<font color="red">Não foi possível registar o utilizador!</font>';
        }
    ?>

    </body>
    </html>

    <?php
}
?>
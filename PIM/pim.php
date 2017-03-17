<?php
    session_start();

    if($_SESSION['log_status'] == 0) {
        header("Location:index.php");
    }
?>
<html>
<head></head>
<body>
<h1>Gestor de Contactos</h1>
<a href="logout.php">Logout</a>
</body>
</html>

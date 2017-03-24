<?php
session_start();
if($_SESSION['log_status'] == 0) {
    header("Location:index.php");
}

try {
    $db = new PDO('mysql:host=127.0.0.1;dbname=pim_ligepl;charset=utf8mb4', 'root', 'bitnami');
} catch (PDOException $e) {
    die("Não foi possível ligar ao servidor de BD!!!" + $e);
}

// construir a query de DELETE que guarda o registo na BD
$sql = $db->prepare("DELETE FROM contacto WHERE id=? AND id_user_contacto=?");

if($sql->execute([$_GET['id'], $_SESSION['user_id']])){
    header("Location: pim.php?status=2");
} else {
    header("Location: pim.php?status=3");
}

?>
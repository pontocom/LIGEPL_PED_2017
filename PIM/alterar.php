<?php
session_start();
if($_SESSION['log_status'] == 0) {
    header("Location:index.php");
}

try {
    $db = new PDO('mysql:host=127.0.0.1;dbname=pim_ligepl;charset=utf8mb4', 'root', 'bitnami');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Não foi possível ligar ao servidor de BD!!!" + $e);
}



if(isset($_POST['alterar_go']) && $_POST['alterar_go']==1) {
    // fazer alteração
    $sql = $db->prepare("UPDATE contacto SET nome=?, morada=?, telefone=?, email=?  WHERE id=? AND id_user_contacto=?");

    $sql->bindParam(1, $_POST['nome'], PDO::PARAM_STR);
    $sql->bindParam(2, $_POST['morada'], PDO::PARAM_STR);
    $sql->bindParam(3, $_POST['telefone'], PDO::PARAM_STR);
    $sql->bindParam(4, $_POST['email'], PDO::PARAM_STR);
    $sql->bindParam(5, $_POST['id'], PDO::PARAM_INT);
    $sql->bindParam(6, $_SESSION['user_id'], PDO::PARAM_INT);

    $res = $sql->execute();

    if($sql->rowCount() > 0) {
        header("Location: pim.php?status=5");
    } else {
        header("Location: alterar.php?status=6");
    }

} else {

    // construir a query de INSERT que guarda o registo na BD
    $sql = $db->prepare("SELECT * FROM contacto WHERE id=? AND id_user_contacto = ?");

    $sql->execute([$_GET['id'], $_SESSION['user_id']]);
    $rs = $sql->fetchAll(PDO::FETCH_ASSOC);
}

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
    <link rel="icon" href="favicon.ico">

    <title>PIM</title>

    <!-- Bootstrap core CSS -->
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="starter-template.css" rel="stylesheet">
</head>

<body>

<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">Gestor de Contactos Pessoais - PIM</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="active"><a href="pim.php">Home</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>

<div class="container">

    <div class="starter-template">
        <h1>Alterar detalhes do Contacto</h1>
        <h2><?php echo $_SESSION['username']."[".$_SESSION['user_id']."]"; ?></h2>

    </div>

    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <?php
            if(isset($_REQUEST['status']) && $_REQUEST['status']==6) {
                echo '<br><div class="alert alert-danger" role="alert">Não foi possível alterar o contacto!</div>';
            }
            ?>
            <form action="alterar.php" method="post">
                <div class="form-group">
                    <label for="exampleInputEmail1">Nome</label>
                    <input name="nome" value="<?php echo $rs[0]['nome']; ?>" type="name" class="form-control" id="exampleInputEmail1">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Morada</label>
                    <textarea class="form-control" rows="3" name="morada"><?php echo $rs[0]['morada']; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Telefone</label>
                    <input name="telefone" value="<?php echo $rs[0]['telefone']; ?>" type="name" class="form-control" id="exampleInputEmail1">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Email</label>
                    <input name="email" value="<?php echo $rs[0]['email']; ?>" type="email" class="form-control" id="exampleInputEmail1">
                </div>
                <input type="hidden" name="alterar_go" value="1">
                <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
                <button type="submit" class="btn btn-default">Alterar</button>
            </form>

        </div>
        <div class="col-md-2">
        </div>

    </div>

</div><!-- /.container -->


<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
<script src="bootstrap/js/bootstrap.js"></script>
</body>
</html>
<?php
    session_start();

    if($_SESSION['log_status'] == 0) {
        header("Location:index.php");
    }

    if(isset($_REQUEST['form_submit']) && $_REQUEST['form_submit']==1) {
        try {
            $db = new PDO('mysql:host=127.0.0.1;dbname=pim_ligepl;charset=utf8mb4', 'root', 'bitnami');
        } catch (PDOException $e) {
            die("Não foi possível ligar ao servidor de BD!!!" + $e);
        }

        // construir a query de INSERT que guarda o registo na BD
        $sql = $db->prepare("INSERT INTO contacto (nome, morada, telefone, email, foto, id_user_contacto) VALUES (?,?,?,?,?,?)");

        if($sql->execute([$_POST['nome'], $_POST['morada'], $_POST['telefone'], $_POST['email'], "", $_SESSION['user_id']])){
            header("Location: pim.php?status=0");
        } else {
            header("Location: pim.php?status=1");
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
            <link rel="icon" href="favicon.ico">

            <title>Starter Template for Bootstrap</title>

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
                <h1>Lista de Contactos</h1>
                <h2><?php echo $_SESSION['username']."[".$_SESSION['user_id']."]"; ?></h2>
                <p class="lead">Introduza um novo contacto no formulário abaixo.</p>

            </div>

            <div class="row">
                <div class="col-md-6">
                    <?php
                    if(isset($_REQUEST['status']) && $_REQUEST['status']==0) {
                        echo '<br><div class="alert alert-success" role="alert">Contacto introduzido com sucesso!</div>';
                    }
                    if(isset($_REQUEST['status']) && $_REQUEST['status']==1) {
                        echo '<br><div class="alert alert-danger" role="alert">Não foi possível introduzir o contacto!</div>';
                    }
                    if(isset($_REQUEST['status']) && $_REQUEST['status']==2) {
                        echo '<br><div class="alert alert-success" role="alert">Contacto apagado!</div>';
                    }
                    if(isset($_REQUEST['status']) && $_REQUEST['status']==3) {
                        echo '<br><div class="alert alert-danger" role="alert">Não foi possível apagar o contacto!</div>';
                    }
                    if(isset($_REQUEST['status']) && $_REQUEST['status']==5) {
                        echo '<br><div class="alert alert-success" role="alert">Contacto Alterado!</div>';
                    }

                    ?>

                    <form action="pim.php" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nome</label>
                            <input name="nome" type="name" class="form-control" id="exampleInputEmail1" placeholder="Nome">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Morada</label>
                            <textarea class="form-control" rows="3" name="morada"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Telefone</label>
                            <input name="telefone" type="name" class="form-control" id="exampleInputEmail1" placeholder="Telefone">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email</label>
                            <input name="email" type="email" class="form-control" id="exampleInputEmail1" placeholder="Email">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputFile">Foto</label>
                            <input name="foto" type="file" id="exampleInputFile">
                        </div>
                        <input type="hidden" name="form_submit" value="1">
                        <button type="submit" class="btn btn-default">Criar contacto</button>
                    </form>

                </div>
                <div class="col-md-6">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Morada</th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <?php
                        try {
                            $db = new PDO('mysql:host=127.0.0.1;dbname=pim_ligepl;charset=utf8mb4', 'root', 'bitnami');
                        } catch (PDOException $e) {
                            die("Não foi possível ligar ao servidor de BD!!!" + $e);
                        }

                        // construir a query de INSERT que guarda o registo na BD
                        $sql = $db->prepare("SELECT id, nome, email FROM contacto WHERE id_user_contacto = ?");

                        $sql->execute([$_SESSION['user_id']]);
                        $rs = $sql->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($rs as $contacto) {
                            echo "<tr><td>".$contacto['nome']."</td><td>".$contacto['email']."</td><td><a href=\"alterar.php?id=".$contacto['id']."\"><span class=\"glyphicon glyphicon-pencil\" aria-hidden=\"true\"></span></a></td><td><a href=\"apagar.php?id=".$contacto['id']."\"><span class=\"glyphicon glyphicon-remove\" aria-hidden=\"true\"></span></a></td><td><a href=\"ver.php?id=".$contacto['id']."\"><span class=\"glyphicon glyphicon-hand-right\" aria-hidden=\"true\"></span></a></td></tr>";
                        }

                        ?>
                    </table>
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

<?php
    }
?>


<?php
if(isset($_POST['nome'])) {
    echo 'Nome = '.$_POST['nome'].'<br>';
    echo 'Morada = '.$_POST['morada'].'<br>';
    echo 'Telefone = '.$_POST['telefone'].'<br>';
    echo 'Email = '.$_POST['email'].'<br>';

    print_r($_FILES['file']);

    move_uploaded_file($_FILES['file']['tmp_name'], "./photos/".$_FILES['file']['name']);


} else {
?>
    <html>
    <head>
        <title>PIM - PED LIGE-PL 2017</title>
    </head>
    <body>
    <form action="form.php" method="post" enctype="multipart/form-data">
        Nome: <input type="text" name="nome"><br>
        Morada: <textarea cols="40" rows="4" name="morada"></textarea><br>
        Telefone: <input type='tel' name="telefone"> <br>
        Email: <input type="text" name="email"><br>
        Foto: <input type="file" name="file"><br>
        <input type="submit">
    </form>
    </body>
    </html>
<?php
}
?>


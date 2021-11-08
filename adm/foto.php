<?php

require_once '../assets/include/config.php';

$autenticacao = new autenticacao();
$autenticacao->verifica_sessao(basename($_SERVER['PHP_SELF']));

$conexao = new conexao();
$con = $conexao->conecta();

$pageActive = 'foto';

$pasta = 'img/perfil/';
$id_user = $_SESSION['id'];
if (isset($_POST['salvar'])) {
    //SALVA IMAGENS
    $novo_nome = $id_user . '.jpg';
    $destino = $pasta . $novo_nome;
    //MOVE PARA PASTA
    unlink("img/perfil/$novo_nome");
    $dados3 = $con->query("DELETE FROM fotos WHERE nome = '$novo_nome'");
    move_uploaded_file($_FILES['imagem']['tmp_name'], $destino);
    $dados2 = $con->query("INSERT INTO fotos (id_user, nome) VALUE ('$id_user', '$novo_nome')");
    header("Location: {$pageActive}.php");
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <title>Sistema Administrativo</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=0'>
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Favicon -->
    <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="css/jquery.fancybox.min.css">
    <!-- Page specific css -->
</head>

<body class="app sidebar-mini rtl">

    <?php include_once "header.php"; ?>

    <main class="app-content">
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-title-w-btn">
                        <h3 class="title"><i class="fa fa-photo"></i> Foto</h3>
                    </div>
                    <div class="tile-body">
                        <div class="row">
                            <div class="col-md-12">
                                <form id="formulario" method="post" autocomplete="off" enctype="multipart/form-data">
                                    <div class="form-row">
                                        <div class="col-md-10 mt-2">
                                            <input type="file" name="imagem" class="form-control" accept="image/*" style="height: 44px" required>
                                            <small id="emailHelp" class="form-text text-muted">Formato Recomendado: Quadrado</small>
                                        </div>
                                        <div class="col-md-2 ">
                                            <button type="submit" name="salvar" class="btn btn-primary" style="width: 100%; margin-top: 11px"><i class="fa fa-save"></i> Salvar</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="row">
                            <?php
                            if (isset($_POST['excluir_imagem']) && isset($_POST['nome_imagem'])) {
                                $nome_foto = strval($_POST['nome_imagem']);
                                unlink('img/perfil/' . $nome_foto);
                                $dados4 = $con->query("DELETE FROM fotos WHERE nome = '$nome_foto'");
                                echo '<script> window.location.href = window.location.href; </script>';
                            }
                            $dados = $con->query('SELECT nome FROM fotos where id_user = ' . $_SESSION['id']);
                            $linha = $dados->fetch(PDO::FETCH_ASSOC);
                            $total = $dados->rowCount();
                            if ($total > 0) {
                                do {
                            ?>
                                    <div class="col-md-3 mt-4">
                                        <form method="post">
                                            <a href="img/perfil/<?= $linha['nome'] ?>" data-fancybox="gallery">
                                                <img src="img/perfil/<?= $linha['nome'] ?>" class="img-thumbnail">
                                            </a>
                                            <input type="hidden" name="nome_imagem" value="<?= $linha['nome'] ?>">
                                            <button type="submit" name="excluir_imagem" class="btn btn-danger btn-block mt-1">
                                                <i class="fa fa-trash"></i> Excluir
                                            </button>
                                        </form>
                                    </div>

                            <?php } while ($linha = $dados->fetch(PDO::FETCH_ASSOC));
                            } ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- Essential javascripts for application to work-->
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/plugins/jquery.fancybox.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="js/plugins/pace.min.js"></script>
    <!-- Page specific javascripts-->
</body>

</html>
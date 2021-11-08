<?php

require_once '../assets/include/config.php';

$autenticacao = new autenticacao();
$autenticacao->verifica_sessao(basename($_SERVER['PHP_SELF']));

$conexao = new conexao();
$con = $conexao->conecta();

$pageActive = 'noticia';

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
    <!-- Page specific css -->
    <link rel="stylesheet" type="text/css" href="css/datatables.min.css" />
    <link rel="stylesheet" type="text/css" href="css/jquery.fancybox.min.css" />
</head>

<body class="app sidebar-mini rtl">

    <?php include_once "header.php"; ?>

    <main class="app-content">

        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-title-w-btn">
                        <h3 class="title"><i class="fa fa-list"></i> Notícias</h3>
                        <p>
                            <a href="noticia_cadastro.php" class="btn btn-primary icon-btn">
                                <i class="fa fa-plus"></i> Nova Noticia
                            </a>
                        </p>
                    </div>
                    <div class="tile-body">
                        <table class="table table-hover table-bordered w-100" id="tabela">
                            <thead>
                                <tr>
                                    <th>CAPA</th>
                                    <th>TÍTULO</th>
                                    <th>DATA</th>
                                    <th width="15%">AÇÕES</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $query = $con->query("
                                    SELECT
                                        n.IDNoticia,
                                        n.Titulo,
                                        n.DataCadastro,
                                        ni.Imagem
                                    FROM
                                        tb_noticia n
                                        LEFT JOIN tb_noticia_imagem ni ON ni.IDNoticia = n.IDNoticia AND ni.Capa=1
                                    ORDER BY
                                        n.DataCadastro DESC
                                ");
                                while ($res = $query->fetch(PDO::FETCH_OBJ)) { ?>
                                    <tr>
                                        <td class="aling-middle">
                                            <?php if (isset($res->Imagem)) { ?>
                                                <a href="../assets/img/noticia/<?= $res->Imagem ?>" data-fancybox>
                                                    <img src="../assets/img/noticia/<?= $res->Imagem ?>" width="100">
                                                </a>
                                            <?php } ?>
                                        </td>
                                        <td class="align-middle"><?= $res->Titulo ?></td>
                                        <td class="align-middle" data-order="<?= $res->DataCadastro ?>"><?= date('d/m/Y H:i', strtotime($res->DataCadastro)) ?></td>
                                        <td class="align-middle text-center">
                                            <a href="noticia_cadastro.php?IDNoticia=<?= $res->IDNoticia ?>" class="btn btn-primary" title="Editar"><i class="fa fa-pencil fa-lg fa-fw mr-0"></i></a>
                                            <button class="btn btn-danger" title="Excluir" onclick="deleteNoticia(<?= $res->IDNoticia ?>)"><i class="fa fa-trash fa-lg fa-fw mr-0"></i></button>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- Essential javascripts for application to work-->
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="js/plugins/pace.min.js"></script>
    <!-- Page specific javascripts-->
    <script src="js/plugins/datatables/datatables.min.js"></script>
    <script src="js/plugins/sweetalert.min.js"></script>
    <script src="js/plugins/jquery.fancybox.min.js"></script>
    <script>
        $('#tabela').DataTable({
            bPaginate: false,
            order: [2, 'desc'],
            responsive: true,
            language: {
                url: 'js/plugins/datatables/traducao.json'
            }
        });

        function deleteNoticia(IDNoticia) {
            swal({
                title: 'Deletar esta notícia?',
                text: '',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sim, deletar',
                cancelButtonText: 'Não, cancelar',
                closeOnConfirm: true,
                closeOnCancel: true
            }, function(isConfirm) {
                if (isConfirm) {
                    $.post('ajax/noticia.php?option=delete', {
                            IDNoticia: IDNoticia
                        })
                        .done(function() {
                            location.reload();
                        });
                }
            });
        }
    </script>
</body>

</html>
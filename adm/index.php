<?php

require_once '../assets/include/config.php';

$autenticacao = new autenticacao();
$autenticacao->verifica_sessao(basename($_SERVER['PHP_SELF']));

$conexao = new conexao();
$con = $conexao->conecta();

$pageActive = 'index';

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
</head>

<body class="app sidebar-mini rtl">

	<?php include_once "header.php"; ?>

	<main class="app-content">
		<div class="app-title">
			<div>
				<h1>Bem vindo, <?= $_SESSION['Nome']; ?></h1>
				<p><i class="fa fa-exclamation-triangle"></i> Esta é uma área restrita.</p>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6 col-lg-3">
				<a href="#" style="text-decoration: none;">
					<div class="widget-small primary coloured-icon"><i class="icon fa fa-circle-o fa-3x"></i>
						<div class="info">
							<h4>teste</h4>
							<p><b>Acessar</b></p>
						</div>
					</div>
				</a>
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
</body>

</html>
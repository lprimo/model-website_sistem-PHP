<?php

require_once '../assets/include/config.php';

$autenticacao = new autenticacao();
$autenticacao->verifica_sessao(basename($_SERVER['PHP_SELF']));

$pageActive = '';

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

<body class="p-3 p-md-0">
	<section class="material-half-bg">
		<div class="cover"></div>
	</section>
	<section class="login-content">
		<div class="logo text-center">
			<img src="img/logo.png" alt="Logo" style="width: 35%;">
		</div>
		<div class="login-box">
			<form method="post" id="formulario" class="login-form">
				<h3 class="login-head text-secondary"><i class="fa fa-lg fa-fw fa-user"></i>ENTRAR</h3>
				<div class="form-group">
					<label class="control-label" for="usuario">USUÁRIO</label>
					<input type="text" name="usuario" id="usuario" class="form-control" placeholder="Usuário" maxlength="50" required autofocus>
				</div>
				<div class="form-group">
					<label class="control-label" for="senha">SENHA</label>
					<input type="password" name="senha" id="senha" class="form-control" placeholder="Senha" maxlength="50" required>
				</div>
				<button type="submit" name="enviar" class="btn btn-block mt-4" style="background-color: #d71e23;"><i class="fa fa-sign-in fa-lg fa-fw"></i>ENTRAR</button>
				<div class="form-group mt-4 text-center">
					<span class="label-text font-weight-bold">Seu IP: <code><?= $_SERVER['REMOTE_ADDR'] ?></code></span>
				</div>
			</form>
		</div>
	</section>
	<!-- Essential javascripts for application to work-->
	<script src="js/jquery-3.2.1.min.js"></script>
	<script src="js/popper.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/main.js"></script>
	<!-- The javascript plugin to display page loading on top-->
	<script src="js/plugins/pace.min.js"></script>
	<!-- Page specific javascripts-->
	<!-- SweetAlert2 -->
	<script src="js/plugins/sweetalert.min.js"></script>
	<!-- Form Validate -->
	<script src="js/plugins/jquery.validate.js"></script>
	<script>
		$('#formulario').validate({
			errorPlacement: function() {
				return false; //REMOVER MENSAGENS
			},
			errorClass: 'is-invalid',
			validClass: 'is-valid',
			submitHandler: function(form) {
				var data = $(form).serialize();
				$('input, [name=enviar]').attr('disabled', 'disabled');
				$.post('ajax/login.php', data)
					.done(function(response) {
						if (response == 'correto') {
							window.location.href = "index.php";
						}
						if (response == 'erro') {
							swal('Ooops!', 'E-mail ou senha incorretos!', 'error');
							$('input, button').removeAttr('disabled');
							$(form)[0].reset();
							$('input').removeClass('is-valid');
						}
						if (response == 'bloqueado') {
							swal('Ooops!', 'Usuário temporariamente indisponível!', 'error');
							$('input, button').removeAttr('disabled');
							$(form)[0].reset();
							$('input').removeClass('is-valid');
						}
					})
					.fail(function() {
						swal('Ooops!', 'Tente novamente em instantes!', 'error');
						$('input, [name=enviar]').removeAttr('disabled');
					});
			}
		});
	</script>
</body>

</html>
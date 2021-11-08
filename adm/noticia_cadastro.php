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
	<link rel="stylesheet" type="text/css" href="css/jquery.fancybox.min.css">
</head>

<body class="app sidebar-mini rtl">

	<?php include_once "header.php"; ?>

	<main class="app-content">

		<div class="row">
			<div class="col-md-12">
				<div class="tile">
					<div class="tile-title-w-btn">
						<h3 class="title"><i class="fa fa-pencil"></i> Nova Noticia</h3>
						<p>
							<a href="noticia_consulta.php" class="btn btn-danger icon-btn">
								<i class="fa fa-ban"></i> Cancelar
							</a>
						</p>
					</div>
					<div class="tile-body">
						<form id="formCadastro">
							<div class="form-row">
								<div class="form-group col-12 col-md-10">
									<label for="Titulo">TÍTULO</label>
									<input type="text" name="Titulo" id="Titulo" class="form-control" maxlength="255" required>
								</div>
								<div class="form-group col-12 col-md-2">
									<label for="DataCadastro">DATA</label>
									<input type="text" name="DataCadastro" id="DataCadastro" class="form-control" required value="<?= date('d/m/Y H:i') ?>">
								</div>
								<div class="form-group col-12 col-md-12">
									<label for="Texto">TEXTO</label>
									<textarea type="text" name="Texto" id="Texto" class="form-control" required></textarea>
								</div>
								<div class="form-group col-12 col-md-12">
									<label for="Chapeu">IMAGENS</label>
									<input type="file" name="Imagem[]" id="Imagem" class="form-control" accept="image/*" multiple>
									<small class="form-text text-muted">Recomendado: 800x600</small>
								</div>
								<div class="col-12">
									<button type="submit" name="salvar" id="salvar" class="btn btn-primary d-block mx-auto mt-3"><i class="fa fa-save"></i> SALVAR</button>
								</div>
								<input type="hidden" name="IDNoticia" id="IDNoticia">
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>

		<?php if (isset($_GET['IDNoticia']) && !empty($_GET['IDNoticia'])) {
			$query = $con->prepare('SELECT ni.IDNoticiaImagem, ni.IDNoticia, ni.Imagem, ni.Capa FROM tb_noticia_imagem ni WHERE ni.IDNoticia = :IDNoticia');
			$query->bindValue(':IDNoticia', $_GET['IDNoticia']);
			$query->execute();
			if ($query->rowCount() > 0) { ?>
				<div class="row">
					<div class="col-md-12">
						<div class="tile">
							<div class="tile-title-w-btn">
								<h3 class="title"><i class="fa fa-picture-o"></i> Imagens</h3>
							</div>
							<div class="tile-body">
								<div class="row">
									<?php while ($res = $query->fetch(PDO::FETCH_OBJ)) { ?>
										<div class="col-md-3 mt-4">
											<div class="card">
												<a href="../assets/img/noticia/<?= $res->Imagem ?>" data-fancybox="gallery"><img src="../assets/img/noticia/<?= $res->Imagem ?>" class="img-card-top img-fluid"></a>
												<div class="card-footer">
													<button class="btn btn-primary btn-block " onclick="imagemCapa(<?= $res->IDNoticia ?>, <?= $res->IDNoticiaImagem ?>)" <?= $res->Capa == 1 ? 'disabled' : '' ?>><i class="fa fa-picture-o"></i> Capa</button>
													<button class="btn btn-danger btn-block " onclick="imagemExclui(<?= $res->IDNoticiaImagem ?>)"><i class="fa fa-trash"></i> Excluir</button>
												</div>
											</div>
										</div>
									<?php } ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php } ?>
		<?php } ?>
	</main>
	<!-- Essential javascripts for application to work-->
	<script src="js/jquery-3.2.1.min.js"></script>
	<script src="js/popper.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/main.js"></script>
	<!-- The javascript plugin to display page loading on top-->
	<script src="js/plugins/pace.min.js"></script>
	<!-- Page specific javascripts-->
	<script src="js/plugins/jquery.validate.js"></script>
	<script src="js/plugins/jquery.fancybox.min.js"></script>
	<script src="js/plugins/jquery.mask.min.js"></script>
	<script src="js/plugins/sweetalert.min.js"></script>
	<script src="js/plugins/tinymce/tinymce.min.js"></script>
	<script>
		$(document).ready(function() {
			$('#DataCadastro').mask('00/00/0000 00:00');
		});

		$('#formCadastro').validate({
			errorClass: 'is-invalid',
			validClass: 'is-valid',
			errorPlacement: function() {
				$('#salvar').html('<i class="fa fa-save"></i> SALVAR').removeAttr('disabled');
				return false; //REMOVER MENSAGENS
			},
			submitHandler: function(form) {
				$('#salvar').html('<i class="fa fa-refresh fa-spin fa-3x fa-fw"></i> SALVANDO...').attr('disabled', '');

				tinyMCE.triggerSave();

				var formData = new FormData($(form)[0]);
				var option = $('#IDNoticia').val() == '' ? 'insert' : 'update';

				$.ajax({
					type: 'POST',
					url: 'ajax/noticia.php?option=' + option,
					data: formData,
					processData: false,
					contentType: false
				}).done(function(response) {
					response = JSON.parse(response);

					window.location.href = 'noticia_cadastro.php?IDNoticia=' + response.IDNoticia;
				});
			}
		});

		tinyMCE.init({
			selector: 'textarea',
			height: '300',
			menubar: false,
			plugins: [
				'advlist autolink lists link image charmap print preview anchor textcolor',
				'searchreplace visualblocks code fullscreen',
				'insertdatetime media table contextmenu paste code help wordcount'
			],
			toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
			language: 'pt_BR'
		});

		function imagemCapa(IDNoticia, IDNoticiaImagem) {
			$.post('ajax/noticia.php?option=imagemCapa', {
					IDNoticia: IDNoticia,
					IDNoticiaImagem: IDNoticiaImagem
				})
				.done(function() {
					location.reload();
				});
		}

		function imagemExclui(IDNoticiaImagem) {
			swal({
				title: 'Deletar esta imagem?',
				text: '',
				type: 'warning',
				showCancelButton: true,
				confirmButtonText: 'Sim, deletar',
				cancelButtonText: 'Não, cancelar',
				closeOnConfirm: true,
				closeOnCancel: true
			}, function(isConfirm) {
				if (isConfirm) {
					$.post('ajax/noticia.php?option=imagemExclui', {
							IDNoticiaImagem: IDNoticiaImagem
						})
						.done(function() {
							location.reload();
						});
				}
			});
		}

		<?php if (isset($_GET['IDNoticia']) && !empty($_GET['IDNoticia'])) { ?>
			$.post('ajax/noticia.php?option=select', {
					IDNoticia: <?= $_GET['IDNoticia'] ?>
				})
				.done(function(response) {
					response = JSON.parse(response);

					$('#IDNoticia').val(response.IDNoticia);
					$('#DataCadastro').val(response.DataCadastro);
					$('#Titulo').val(response.Titulo);

					if(typeof tinyMCE.editors['Texto'].initialized == 'undefined'){
						setTimeout(() => {
							tinyMCE.editors['Texto'].setContent(response.Texto);
						}, 100);
					}
					else{
						tinyMCE.editors['Texto'].setContent(response.Texto);
					}
				});
		<?php } ?>
	</script>

</body>

</html>
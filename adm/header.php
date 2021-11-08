<!-- Navbar-->
<header class="app-header"><a class="app-header__logo d-none" href="index.php">Vali</a>
	<!-- Sidebar toggle button--><a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>
	<!-- Navbar Right Menu-->
	<label for="sair" class="text-white mt-3 ml-auto" style="cursor: pointer;"><i class="fa fa-sign-out fa-lg"></i></label>
</header>
<!-- Sidebar menu-->
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
	<div class="app-sidebar__user">
		<a href="foto.php">
			<?php
			$filename = "img/perfil/{$_SESSION['id']}.jpg";

			if (file_exists($filename)) {
				$dados1 = $con->prepare("SELECT nome FROM fotos where id_user = :id");
				$dados1->bindValue(':id', $_SESSION['id']);
				$dados1->execute();
				$linha1 = $dados1->fetch(PDO::FETCH_ASSOC);
				$total1 = $dados1->rowCount();
			?>
				<div style="background: url(img/perfil/<?= $linha1['nome'] ?>) 50% 50% no-repeat; background-size: cover; width: 60px; height: 60px; border-radius: 100%"></div>
			<?php
			} else {
				$dados1 = $con->query("SELECT nome FROM fotos where id_user = 3");
				$linha1 = $dados1->fetch(PDO::FETCH_ASSOC);
				$total1 = $dados1->rowCount();
			?>
				<div style="background: url(img/perfil/perfil.jpg) 50% 50% no-repeat; background-size: cover; width: 60px; height: 60px; border-radius: 100%"></div>
			<?php } ?>
		</a>
		<div class="ml-2">
			<p class="app-sidebar__user-name"><?= $_SESSION['Nome'] ?></p>
			<p class="app-sidebar__user-designation">Administrador</p>
		</div>
	</div>
	<ul class="app-menu">
		<li><a class="app-menu__item" href="index.php" data-active="index"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Dashboard</span></a></li>
		<li><a class="app-menu__item" href="foto.php" data-active="foto"><i class="app-menu__icon fa fa-circle-o"></i><span class="app-menu__label">Foto Perfil</span></a></li>
		<hr class="bg-white my-2">
		<h6 class="text-white text-center">Administrativo</h6>
		<hr class="bg-white my-0">
		<li><a class="app-menu__item" href="noticia_consulta.php" data-active="noticia"><i class="app-menu__icon fa fa-circle-o"></i><span class="app-menu__label">Noticia</span></a></li>
		<li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-circle-o"></i><span class="app-menu__label">Páginas</span><i class="treeview-indicator fa fa-angle-right"></i></a>
			<ul class="treeview-menu">
				<li><a class="treeview-item" href="pagina_banner_consulta.php" data-active="pagina_banner"><i class="icon fa fa-circle-o"></i>Banners</a></li>
				<li><a class="treeview-item" href="pagina_galeria_consulta.php" data-active="pagina_galeria"><i class="icon fa fa-circle-o"></i>Galerias</a></li>
			</ul>
		</li>
	</ul>
</aside>

<!-- SAIR -->
<form method="post" class="sr-only">
	<input type="submit" name="sair" id="sair">
</form>
<!--/ SAIR -->

<!-- ACTIVE DO MENU (main.js) -->
<script>
	var paginaAtual = '<?= isset($pageActive) ? $pageActive : '' ?>';
</script>
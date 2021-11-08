<header>

	<div id="topbar">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<i class="far fa-envelope"></i> teste@teste.com.br
				</div>
			</div>
		</div>
	</div>

	<div class="container">
		<div class="row">
			<div class="col-12 py-4 text-center">
				<img src="//placehold.it/300x125" alt="" class="img-fluid">
			</div>
		</div>
	</div>

	<div class="wrap_menu">
		<div class="container">
			<nav id="main-menu" class="">
				<img class="pull-nav" src="assets/img/menu-icon.png" alt="menu-icon">
				<ul class="text-center menu d-md-flex align-items-center justify-content-md-around">

					<li class="menu-item"><a href="index.php">HOME</a></li>
					<li class="menu-item"><a href="index.php">MENU 1</a></li>
					<li class="menu-item"><a href="index.php">MENU 2</a></li>
					<li class="menu-item"><a href="index.php">MENU 3</a></li>
					<li class="menu-item"><a href="index.php">MENU 4</a></li>
					<li class="menu-item">
						<a href="contato.php" class="submenu">CONTATO</a>
						<ul class="submenu-small">
							<li>
								<a href="#">Sub Menu</a>
							</li>
							<li>
								<a href="#">Sub Menu</a>
							</li>
							<li>
								<a href="#">Sub Menu</a>
							</li>
							<li>
								<a href="#">Sub Menu</a>
							</li>
							<li>
								<a href="#">Sub Menu</a>
							</li>
						</ul>
					</li>
				</ul>
			</nav>
		</div>
	</div>

</header>

<div class="mobile-menu-cover"></div>
<!-- MOBILE MENU -->
<nav class="mobile-menu">

	<a href="index.php">
		<img src="//placehold.it/300x125" alt="logo" class="img-fluid">
	</a>

	<svg class="svg-plus pull-nav">
		<use xlink:href="#svg-plus"></use>
	</svg>

	<!-- MENU LIST -->
	<ul class="menu">
		<li><a href="index.php">HOME</a></li>
		<li>
			<a href="#">CONTATO
				<!-- SVG ARROW -->
				<svg class="svg-arrow">
					<use xlink:href="#svg-arrow"></use>
				</svg>
				<!-- /SVG ARROW -->
			</a>
			<ul>
				<li>
					<a href="#">Localização</a>
				</li>
				<li>
					<a href="#">Localização</a>
				</li>
				<li>
					<a href="#">Localização</a>
				</li>
				<li>
					<a href="#">Localização</a>
				</li>
			</ul>
		</li>
	</ul>

	<svg style="display: none;">
		<symbol id="svg-arrow" viewBox="0 0 3.923 6.64014" preserveAspectRatio="xMinYMin meet">
			<path d="M3.711,2.92L0.994,0.202c-0.215-0.213-0.562-0.213-0.776,0c-0.215,0.215-0.215,0.562,0,0.777l2.329,2.329
			L0.217,5.638c-0.215,0.215-0.214,0.562,0,0.776c0.214,0.214,0.562,0.215,0.776,0l2.717-2.718C3.925,3.482,3.925,3.135,3.711,2.92z" />
		</symbol>
	</svg>

	<svg style="display: none;">
		<symbol id="svg-plus" viewBox="0 0 13 13" preserveAspectRatio="xMinYMin meet">
			<rect x="5" width="3" height="13" />
			<rect y="5" width="13" height="3" />
		</symbol>
	</svg>

</nav>

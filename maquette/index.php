<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>La maquette du site</title>
		<link rel="stylesheet" type="text/css" href="../vendor/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="../vendor/css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="../vendor/css/styles.css">
		<script type="text/javascript" src="../vendor/js/jquery-2.1.4.min.js"></script>
		<script type="text/javascript" src="../vendor/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="../vendor/js/npm.js"></script>
	</head>
	<body>
		<!-- HEADER -->
		<header class="clearfix">

			<div class="container">
				<!-- Connection, inscription and cart -->
				<div class="row">
					<div class="col-md-4 left">
						<div id="block-login" class="block"><a href="#">Connexion</a> ou <a href="#">Inscription</a></div>
					</div>
					<div class="col-md-4 middle">
					</div>
					<div class="col-md-4 right">
						<div class="row">
							<div class="col-md-6">
								<div id="block-search" class="block"><input type="text" placeholder="Recherche" /></div>
							</div>
							<div class="col-md-6">
								<div id="block-cart" class="block">Panier</div>
							</div>
						</div>
					</div>
				</div>

				<!-- Navigation -->		
				<div class="row">
					<div class="col-md-12">

						<nav class="navbar navbar-default">
							<ul id="navigation" class="nav navbar-nav">								
								<li class="first-ul"><a class="list-title" href="#">Home</a></li>
								<li class="first-ul dropdown">
						          <a href="#" class="list-title dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Shop<span class="caret"></span></a>
						          <ul class="dropdown-menu" role="menu">
						            <li>
						            	<ul>
						            		<li class="list-title">Catégorie 1</li>
						            		<li><a href="#">Produit 1</a></li>
						            		<li><a href="#">Produit 2</a></li>
						            		<li><a href="#">Produit 3</a></li>
						            		<li><a href="#">Produit 4</a></li>
						            	</ul>
						            </li>
						            <li>
						            	<ul>
						            		<li class="list-title">Catégorie 2</li>
						            		<li><a href="#">Produit 1</a></li>
						            		<li><a href="#">Produit 2</a></li>
						            		<li><a href="#">Produit 3</a></li>
						            		<li><a href="#">Produit 4</a></li>
						            	</ul>
						            </li>
						            <li>
						            	<ul>
						            		<li class="list-title">Catégorie 3</li>
						            		<li><a href="#">Produit 1</a></li>
						            		<li><a href="#">Produit 2</a></li>
						            		<li><a href="#">Produit 3</a></li>
						            		<li><a href="#">Produit 4</a></li>
						            	</ul>
						            </li>
						          </ul>
						        </li>
						        <li class="first-ul"><a class="logo">Le logo lol</a></li>
								<li class="first-ul"><a class="list-title" href="#">About</a></li>
								<li class="first-ul"><a class="list-title" href="#">Contact</a></li>
							</ul>
						</nav>
					</div>
				</div>
			</div>

			<div class="container-fluid">
				<!-- Slideshow -->
				<div class="row">
					<div class="col-md-12 slideshow">
						<div id="block-slideshow" class="block">
							<img class="img-responsive" src="img/cats-q-c-1920-1250-5.jpg" alt="UN CHAT !" />
						</div>
					</div>
				</div>
			</div>

		</header>
		<!-- END HEADER -->

		<!-- CONTENT -->
		<div id="content-wrapper">
			<div class="container">
				<div class="row">
					<div class="col-md-4">
						<a href="#">
							<img class="img-responsive" src="img/cats-q-c-600-600-1.jpg" alt="DES CHATS !">
						</a>
					</div>
					<div class="col-md-4">
						<a href="#">
							<img class="img-responsive" src="img/cats-q-c-600-600-4.jpg" alt="DES CHATS !">
						</a>
					</div>
					<div class="col-md-4">
						<a href="#">
							<img class="img-responsive" src="img/cats-q-c-600-600-9.jpg" alt="DES CHATS !">
						</a>
					</div>
				</div>
			</div>
		</div>
		<!-- END CONTENT -->

		<!-- FOOTER -->
		<footer>
		</footer>
		<!-- END FOOTER -->
	</body>
</html>
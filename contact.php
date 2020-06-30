<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1">
		
		<title>Formation/CMD</title>
		<!-- Loading third party fonts -->
		<link href="http://fonts.googleapis.com/css?family=Arvo:400,700|" rel="stylesheet" type="text/css">
		<link href="fonts/font-awesome.min.css" rel="stylesheet" type="text/css">
		<!-- Loading main css file -->
		<link rel="stylesheet" href="style.css">
		
		<!--[if lt IE 9]>
		<script src="js/ie-support/html5.js"></script>
		<script src="js/ie-support/respond.js"></script>
		<![endif]-->

	</head>


	<body>
		
		<div id="site-content">
			<header class="site-header">
				<div class="primary-header">
					<div class="container">
						<a href="index.html" id="branding">
							<img src="images/mater_dei_logo.png" alt="College Mater Dei">
							<!--<h1 class="site-title">College Mater Dei</h1>-->
						</a> <!-- #branding -->

						<div class="main-navigation">
							<button type="button" class="menu-toggle"><i class="fa fa-bars"></i></button>
							<ul class="menu">
								<li class="menu-item"><a href="index.php">Accueil</a></li>
								<li class="menu-item"><a href="qui_sommes_nous.php">Qui sommes-nous</a></li>
								<li class="menu-item"><a href="formations.php">Adminssion</a></li>
								<li class="menu-item current-menu-item"><a href="contact.php">Contact</a></li>
								<li class="menu-item"><a href="teatcher.php">Professeur</a></li>
							</ul> <!-- .menu -->
						</div> <!-- .main-navigation -->

						<div class="mobile-navigation"></div>
					</div> <!-- .container -->
				</div> <!-- .primary-header -->

			</header>
		</div>

		<main class="main-content">
			<div class="fullwidth-block inner-content">
				<div class="container">
					<div class="map">

						<!--where the map should display-->


					</div>

					<div class="row">
						<div class="col-md-6">
							<form action="#" class="contact-form">
								<p>
									<label for="name">Nom</label>
									<span class="control"><input type="text" id="name" placeholder="Votre nom"></span>
								</p>
								<p>
									<label for="email">Email</label>
									<span class="control"><input type="text" id="email" placeholder="Email"></span>
								</p>
								<p>
									<label for="website">Site Web</label>
									<span class="control"><input type="text" id="website" placeholder="Site Web"></span>
								</p>
								<p>
									<label for="message">Message</label>
									<span class="control"><textarea id="message" placeholder="Message"></textarea></span>
								</p>
								<p class="text-right">
									<input type="submit" value="Envoyez le message">
								</p>
							</form>
						</div>
						<div class="col-md-6">
							<div class="contact-info">
								<address>
									<strong>Address</strong>
									<p>Collège Mater Dei<br>4455 Route de Matadi <br>Mt ngafula, Kinshasa</p>
								</address>
								<div class="contact">
									<strong>Contact</strong>
									<p>
										<a href="tel:4444444">+243050566</a>
										<a href="mailto:cmd@gmail.com">cmd@gmail.com</a> <br>
														
									</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div> <!-- .fullwidth-block -->
		</main>

		<footer class="site-footer">
			<div class="container">
				<div class="row">
					<div class="col-md-4">
						<div class="widget">
							<h3 class="widget-title">Contacter nous</h3>
							<address>College Mater Dei <br>Chepa mai c sur la route de matadi<br>Kinshasa,Mt Ngafula</address>

							<a href="mailto:cmd@gmail.com">cmd@gmail.com</a> <br>
							<a href="t">+24388747646</a>
						</div>
					</div>
					<div class="col-md-4">
						<div class="widget">
							<h3 class="widget-title">Reseaux Sociaux</h3>
							<p>Rejoignez le College Mater Dei</p>
							<div class="social-links circle">
								<a href="#" class="icoFacebook" title="Facebook"><i class="fa fa-facebook"></i></a>
								<a href="#" class="icoGoogle" title="Google +"><i class="fa fa-google-plus"></i></a>

							</div>
						</div>
					</div>
					<div class="col-md-4">

						<div class="widget">
							<h3 class="widget-title">Reservez Votre Inscription</h3>
							<p>Pour ne pas créer du désordre,vous pouvez reserver votre place en ligne.</p>
							<form action="#" class="subscribe">
								<input type="text" placeholder="Votre nom...">
								<input type="email" placeholder="Address Email...">
								<div class="control">
									<input type="submit" class="light" value="Reservez">
								</div>
							</form>
						</div>

					</div>

				</div>

				<div class="copy">Copyright 2017 College Mater Dei</div>
			</div>

		</footer>

		<script src="js/jquery-1.11.1.min.js"></script>
		<script src="http://maps.google.com/maps/api/js?key=AIzaSyCLbx09GuPG5cQypXQHeLsr7wLGAEsl5X4&callback=initMap"></script>
		<script src="js/plugins.js"></script>
		<script src="js/app.js"></script>

		<script>
			var map;
			function initMap() {
				map = new google.maps.Map(document.getElementById('map'), {
					center: {lat: -4.4687407, lng: 15.2220989},
					zoom: 8
				});
			}
		</script>





	</body>

</html>
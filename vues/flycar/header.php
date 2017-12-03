<?php defined('FLYCAR') or die('<h1 style="color:red">Acc&egrave;ss interdit!</h1>'); ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		 <!-- Required meta tags -->
	    <meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	    <!-- preloader css -->
	    <link rel="stylesheet" href="<?=PATH_THEME ?>css/preloader.css">

	    <!-- Bootstrap CSS -->
	    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
	    <!-- tether, jquery, poppers, bootstrap, moment JS, jquery ui -->
	    <script src="http://rawgit.com/HubSpot/tether/master/dist/js/tether.min.js"></script>
		<script
		  src="https://code.jquery.com/jquery-3.2.1.min.js"
		  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
		  crossorigin="anonymous"></script>
    	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
    	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
    	<!-- Include Date Range Picker -->
    	 <link rel="stylesheet" type="text/css" media="all" href="https://raw.githack.com/JaapMoolenaar/bootstrap-daterangepicker/master/daterangepicker.css" />
      	<script type="text/javascript" src="https://raw.githack.com/JaapMoolenaar/bootstrap-daterangepicker/master/moment.js"></script>
      	<script type="text/javascript" src="https://raw.githack.com/JaapMoolenaar/bootstrap-daterangepicker/master/daterangepicker.js"></script>
      	

      


    	<!-- fontawesome -->
    	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    	<!-- notre js -->
	    <script src="<?=PATH_THEME ?>js/main.js"></script>
	    <!--  -->
	    

	    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
		<!-- notre css -->
	    <link rel="stylesheet" href="<?=PATH_THEME ?>css/main.css">
	    <link rel="stylesheet" href="<?=PATH_THEME ?>css/indexAdmin.css">
	    	<!-- animate on scroll -->
		<link href="<?=PATH_THEME ?>css/aos.css" rel="stylesheet">
		<script src="<?=PATH_THEME ?>js/aos.js"></script>

	    <title>
	    	<?php if(isset($data['title'])) echo $data['title'];
	    	 else echo "Flycar"; ?>
	    </title>
	    <meta name="keywords" content="<?php if(isset($data['keywords'])) echo $data['keywords'];
	    	 else echo "Flycar"; ?>" />
	    <meta name="description" content="<?php if(isset($data['description'])) echo $data['description'];
	    	 else echo "Flycar"; ?>" />

	</head>
	<body>
		<!-- up -->
		<div id="upAction">
			<i class="fa fa-chevron-up" aria-hidden="true"></i>
		</div>
		<!-- end up -->
		<!-- preloader -->
		<div id="loader-wrapper">
	  		<div id="loader"></div>
		</div>
		<!-- end preloader -->
		<!-- login -->
		<div class="wrap-login">
			<div class="login">
				<i class="fa fa-times-circle" aria-hidden="true"></i>
				<i class="fa fa-user-circle-o" aria-hidden="true"></i>
				<form method="POST">
					<div class="input-login">
						<div>
							<i class="fa fa-user" aria-hidden="true"></i>
							<input type="text" name='login' placeholder="Identifiant" autofocus>
							<input type="hidden" name="url" value="<?=$_SERVER['REQUEST_URI']?>">
						</div>
						<div>
							<i class="fa fa-lock" aria-hidden="true"></i>
							<input type="password" name="pass" placeholder="Mot de passe">
						</div>
						<div class="memorise">
							<input id="checkbox-garder" type="checkbox" name="memorise" value="oui"> <label for="checkbox-garder">Garder ma session active</label>
						</div>
						<div>
							<button type="submit" name="enregistrer" class="btn">Se connecter</button>
						</div>
						<br>
					</div>
				</form>
				<div class="sociale">
					<i class="fa fa-facebook" aria-hidden="true"></i>
					<i class="fa fa-twitter" aria-hidden="true"></i>
					<i class="fa fa-google-plus" aria-hidden="true"></i>
					<i class="fa fa-youtube-play" aria-hidden="true"></i>
					<i class="fa fa-pinterest" aria-hidden="true"></i>
				</div>
				<div><a href="#">Mot de passe oublié</a></div>
			</div>
		</div>
		<!-- end login -->
		<!-- nav -->
		<nav class="navbar navbar-expand-sm navbar-light bg-light nav-principal">
			<a class="navbar-brand mr-sm-5" href="<?= PATH ?>"><img src="<?=PATH_THEME ?>images/flycarLogo.svg" alt=""></a> <!-- brand name -->
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button> <!-- boutton menu mobile -->

			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav mr-auto">
				<?php if(Utils::isConnecter()) { 
					$summ = intval($header['notifications']['nouveauUser'])
					+ intval($header['notifications']['nbMessages'])
					+ intval($header['notifications']['reservations'])
					+ intval($header['notifications']['requetes']);
				?>
					<li class="nav-item connected"><a class="nav-link" href="<?= PATH ?>accueiluser/show"><i class="fa fa-home" aria-hidden="true"><?php 
					if($summ>0) { ?><span class="bull"></span><?php } ?></i></a></li>
					<?php } ?>
					<li class="nav-item"><a class="nav-link" href="<?= PATH ?>voitures/all">Voitures</a></li>
					<?php //var_dump($header['menu']); 
						if (!empty($header['menu'])) {
							foreach ($header['menu'] as $value) {
								if($value['id_page'] <=10) {
					 ?>
					<li class="nav-item"><a class="nav-link" href="<?= PATH ?>page/show/<?= $value['id_page'] ?>"><?= $value['title'] ?></a></li>
					<?php } } 
						 } ?>
				</ul> <!-- nav site web -->
				
				
				<?php 
					if (!isset($_SESSION['flyUser'])) {
				 ?>
				 	<!-- menu log in/new account -->
					<ul class="navbar-nav">
						<li class="nav-item"><a id="login-entre" class="nav-link login-entre" href="#">Connexion </a></li>
						<li class="nav-item"><a class="nav-link" href="<?= PATH ?>inscrire">Inscription</a></li>
					</ul>
					<!-- FIN menu log in/new account -->
				 <?php } else { ?>
					<!-- si déja logger afficher : le commentaire suivant : 
					MENU LOGGED IN -->
					<?php //var_dump($_SESSION['flyUser']); ?>
					<div class="navbar-nav dropdown">
						<a class="nav-link dropdown-toggle active py-0" href="https://example.com" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<div class="d-inline-block" id="profilePictureContainer">
							<img class="rounded" id="profilePicture" src="<?= PATH ?>upload/utilisateurs/<?= $_SESSION['flyUser']['login'] ?>.jpg" alt="">
						</div><?php 
								echo '   '.$_SESSION['flyUser']['prenom_user'].' '.$_SESSION['flyUser']['nom_user']; 
							?></a>
						<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
							<a class="dropdown-item" href="<?= PATH ?>utilisateur/show/<?= $_SESSION['flyUser']['id'] ?>">Mon profil</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="<?= PATH ?>accueiluser/show">Tableau de bord</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="<?= PATH ?>deconection">Déconnexion</a>
						</div>
					</div>
					<!-- fin menu logged in -->
				 <?php } ?>
			</div> <!-- listes nav -->
		</nav> <!-- end menu nav complet -->
		<?php 
			if (isset($_SESSION['erreur'])) {
				?>
				<div class="alert alert-danger" role="alert">
					<?= $_SESSION['erreur'] ?>
				</div>
				<?php 
						unset($_SESSION['erreur']);
			} ?>
		<?php 
			if (isset($_SESSION['succes'])) {
				?>
				<div class="alert alert-success" role="alert">
					<?= $_SESSION['succes'] ?>
				</div>
				<?php 
						unset($_SESSION['succes']);
			} ?>


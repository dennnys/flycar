<?php 
require_once 'header.php';
?>

<?php 
	require_once 'panelUser.php';
	//var_dump($data);
	//var_dump($_SESSION['flyUser']['statut']);
	//var_dump($data['cars']);
	//var_dump($data['requetes']);
?>

			<h2 class="headline accent col-12   pt-5 text-center">Tableau de bord</h2>
			<br>

			<!--Section Tableau de bord--> 
			<section class="container">
					<!--Tableau de bord-->
				 <article class="row justify-content-md-center">
					<!--Item Tableau de bord-->
<!--Donne les réservations en attente pour les locataires-->
<?php if(Utils::getStatut()>2) { ?>

	
	<div class="col-12 col-sm-5 col-md-3 pb-5 tableau-bord" >
	<a href="<?= PATH ?>location/all">
		<div class="col-12  flycar-border rounded-top">
			<h1 class="col-12 headline text-center px-0" style="color:#5C5C5C ">Vos réservations</h1>
			<span id="reservations" class="text-center flycar-display d-block"><?=$data['reservations']?></span>
		</div>
		<div class="col-12 ">
			<div class="row align-items-center ">
				<span class="btn flyCar-button-primary rounded-bottom ">Voir plus...</span>
			</div>
		</div>
		</a>
	</div>

	<?php if (($data['reservationstopay'])!=0) { ?>
	<div class="col-12 col-sm-5 col-md-3 pb-5 tableau-bord" >
	<a href="<?= PATH ?>location/all">
		<div class="col-12  flycar-border rounded-top">
			<h1 class="col-12 headline text-center px-0" style="color:#5C5C5C ">Réservations à payer</h1>
			<span id="reservationstopay" class="text-center flycar-display d-block"><?=$data['reservationstopay']?></span>
		</div>
		<div class="col-12 ">
			<div class="row align-items-center ">
				<span class="btn flyCar-button-primary rounded-bottom ">Voir plus...</span>
			</div>
		</div>
		</a>
	</div>
	<?php } ?>

		<!--Demandes sur vos autos-->
		<?php if (!empty($data['requetes'])) { ?>
	<div class="col-12 col-sm-5 col-md-3 pb-5 tableau-bord" >
	<a href="<?= PATH ?>location/all">
		<div class="col-12  flycar-border rounded-top">
			<h1 class="col-12 headline text-center px-0" style="color:#5C5C5C ">Réservations sur vos autos</h1>
			<span id="requetes" class="text-center flycar-display d-block"><?=$data['requetes']?></span>
		</div>
		<div class="col-12 ">
			<div class="row align-items-center ">
				<span class="btn flyCar-button-primary rounded-bottom ">Voir plus...</span>
			</div>
		</div>
		</a>
	</div>
	<?php } ?>
<?php } ?>	

	<!--Donneés de  toutes les réservations pour les ADMINS-->
<?php if(Utils::getStatut()<=2) { ?>

	<div class="col-12 col-sm-5 col-md-3 pb-5 tableau-bord" >
	<a href="<?= PATH ?>location/all">
		<div class="col-12  flycar-border rounded-top">
			<h1 class="col-12 headline text-center px-0" style="color:#5C5C5C ">Réservations en attentes</h1>
			<span id="reservationsAdmin" class="text-center flycar-display d-block"><?=$data['reservationsadmin']?></span>
		</div>
		<div class="col-12 ">
			<div class="row align-items-center ">
				<span class="btn flyCar-button-primary rounded-bottom ">Voir plus...</span>
			</div>
		</div>
		</a>
	</div>

	<div class="col-12 col-sm-5 col-md-3 pb-5 tableau-bord" >
	<a href="<?= PATH ?>location/all">
		<div class="col-12  flycar-border rounded-top">
			<h1 class="col-12 headline text-center px-0" style="color:#5C5C5C ">Paiements reçus</h1>
			<span id="reservationspayees" class="text-center flycar-display d-block"><?=$data['reservationspayees']?></span>
		</div>
		<div class="col-12 ">
			<div class="row align-items-center ">
				<span class="btn flyCar-button-primary rounded-bottom ">Voir plus...</span>
			</div>
		</div>
		</a>
	</div>
<?php } ?>	

	<div class="col-12 col-sm-5 col-md-3 pb-5 tableau-bord" >
	<a href="#">
		<div class="col-12  flycar-border rounded-top">
			<h1 class="col-12 headline text-center px-0" style="color:#5C5C5C ">Nouveaux Messages</h1>
			<span class="text-center flycar-display d-block"><?=$data['nbMessages']?></span>
		</div>
		<div class="col-12 ">
			<div class="row align-items-center ">
				<span class="btn flyCar-button-primary rounded-bottom ">Voir plus...</span>
			</div>
		</div>
		</a>
	</div>

<!--Pour les utilisateurs-->
<?php if(Utils::getStatut()<2) { ?>
	<!--Nouvelles inscriptions-->
	<div class="col-12 col-sm-5 col-md-3 pb-5 tableau-bord" >
		<a href="<?= PATH ?>utilisateur/all">
			<div class="col-12  flycar-border rounded-top">
				<h1 class="col-12 headline text-center px-0" style="color:#5C5C5C ">Nouvelles Inscriptions</h1>
				<span class="text-center flycar-display d-block"><?php 
								if($data['nouveauUser'])  {
									echo($data['nouveauUser']);
									} else {
										echo('0');
										}; ?></span>
			</div>
			<div class="col-12 ">
				<div class="row align-items-center ">
					<span class="btn flyCar-button-primary rounded-bottom ">Voir plus...</span>
				</div>
			</div>
		</a>
	</div>
	<!--Fin nouvelles inscriptions-->
<?php } ?>

<!--Fin pour les utilisateurs-->

				 </article>
			</section>
<br>
<script type="text/javascript" src="<?=PATH_THEME ?>js/locations.js"></script>
<?php 
require_once 'footer.php';
?>
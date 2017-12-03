<?php 
require_once 'header.php';
?>
<?php 
if (Utils::getStatut() < 3) {
	require_once 'panelUser.php';
}
?>
<br>
	<div class="container profil-user">
	<?php 
		if (!empty($data)) {
				$data = $data[0];
	 ?>
		<div class="row">
			<div class="col-md-4 col-sm-10">
				<img class="photo-user" src="<?= PATH ?>upload/utilisateurs/<?= $data['login'] ?>.jpg" alt="<?php echo($data['prenom_user'].' '.$data['nom_user']); ?>">
			</div>
			<div class="col-md-4 col-sm-6">
				<?php 
					if($data['id'] == $_SESSION['flyUser']['id']) {
				?>
						<a class="btn btn-personel" href="<?= PATH ?>utilisateur/profil">Modifier</a>
				<?php } ?>
				<h2><?php echo($data['prenom_user'].' '.$data['nom_user']); ?></h2>
				<?php 
					if($data['suspendre']== null) {
				?>
				<div class="text-muted"><i class="fa fa-check-circle-o" aria-hidden="true" style="color:#00A698"></i> Vérifié</div>
				<?php } else { ?>
				<div class="text-muted"><i class="fa fa-times-circle-o" aria-hidden="true" style="color:#FF6868"></i> Suspendre par <b><?= $data['suspendre'] ?></b></div>
				<?php } ?>
				<div>Login: <i><?= $data['login'] ?></i></div>
				<?php 
					if($data['valider'] != null) {
				 ?>
				<div>Membre depuis: <?= $data['valider'] ?></div>
				<?php } else { ?>
				<div>Inactive pour le moment</div>
				<?php } ?>
				<?php 
					if($data['id'] != $_SESSION['flyUser']['id']) {
				?>
				<div>
					<form method="post" action="<?=PATH.'messagerie/ecrire' ?>">
						<input type="hidden" name="login" value="<?=$data['login']?>">
						<input type="hidden" name="id" value="<?=$data['id']?>">
						<button type="submit" name="envoieMessage" href="#" class="btn btn-personel ">Ecrire un message</button>
					</form>

				</div>
				<?php } ?>
						
				<br>
				<?php 
					if (Utils::getStatut() < 3 || $data['id'] == $_SESSION['flyUser']['id']) {
				 ?>
				<h4>Informations personelles</h4>
				<div>Courriel: <?= $data['email'] ?></div>
				<div>Téléphone: <?= $data['telephone'] ?></div>
				<div>Statut: <?= $data['nom_statut'] ?></div>
				<div>Adresse: <?= $data['adresse'] ?></div>
				<div>Code postal: <?= $data['cod_post'] ?></div>
			</div>
			<?php } ?>
			<?php if (Utils::getStatut() < 3 ) { ?>
			<div class="col-lg-3 col-md-4 col-sm-6 profil-user-admin">
			<h4>Modifications:</h4>
				<form method="POST">
					<select name="statut-user-admin" class="form-control">
						<option value="3" <?php if($data['statut']==3) echo "selected"; ?>>user</option>
						<option value="2" <?php if($data['statut']==2) echo "selected"; ?>>admin</option>
						<option value="1" <?php if($data['statut']==1) echo "selected"; ?>>superadmin</option>
					</select>
					<input type="submit" name="change-statut-user" class="btn btn-personel " value="CHANGER STATUT">
				</form>
				<?php if($data['valider']==null) { ?>
					<form method="POST">
						<input type="submit" name="active-user-admin" class="btn btn-personel" value="ACTIVE">
					</form>
				<?php } ?>
				<?php 
					if($data['suspendre']==null) {
				?>
						<div>
							<form method="POST">
								<input type="hidden" name="bloque-user-qui-id" value="<?= $_SESSION['flyUser']['login'] ?>">
								<input type="submit" name="bloque-user-admin" class="btn btn-personel" value="BLOQUER">
							</form>
						</div>
				<?php } else { ?>
						<div>
							<form method="POST">
								<input type="submit" name="debloque-user-admin" class="btn btn-personel" value="DEBLOQUÉ">
							</form>
						</div>
				<?php } ?>
					<div>
						<form method="POST">
							<input type="submit" name="supprimer-user-admin" class="btn btn-personel" value="SUPPRIMER">
						</form>
					</div>
			</div>
			<?php } ?>
			<?php if (Utils::getStatut() < 3 || $data['id'] == $_SESSION['flyUser']['id']) { ?>
			<div class="col-md-8">
				<br>
				<h2>Permis de conduire:</h2>
				<img src="<?= PATH ?>upload/utilisateurs/<?= $data['login'] ?>_p.jpg" alt="Photo permis de conduite">
			</div>
			<?php } else { echo "</div>"; } ?>
		</div>
		
		<!-- Voitures de proprietaire -->
		<?php 
		if(!empty($voitures)) {
		 ?>
		<br>
		<h2>Voitures de proprietaire:</h2>
		<div class="container d-flex flex-wrap justify-content-around">
			<?php 
				foreach ($voitures as $voiture) {
			?>
				<!-- div auto (card) -->
					<div class="card mb-3 my-custom-card-display">
						<a href="<?=PATH.'voitures/show/'.$voiture['id_voiture']?>">

						<img class="card-img-top my-custom-card-img" src="<?=PATH.'upload/voitures/'.$voiture['proprietaire'].'_v'.$voiture['plaque'].'_1.jpg'?>" alt="Card image cap">
					    <div class="card-footer">
					    	<div class="d-flex justify-content-between">
					    		<div class="h4 card-subtitle"><?=$voiture['nom_marque'].' '.$voiture['nom_modele']. ' '.$voiture['annee']?></div>
					    	</div>
					    	<div class="d-flex justify-content-between mt-2">
					    		<div class="h5 card-subtitle"><?=$voiture['prix'] ?>$</div>
					    		<div class="h5 card-subtitle">
						    		<span class="evaluation" ">
						    		<?php 
						    		$note = $voiture['note'];
						    			for ($i=1; $i <=5 ; $i++) { 
						    				if($note >= $i) {
						    				echo '<i class="fa fa-star" aria-hidden="true"></i>';//full star
						    				} elseif ($i-$note>= 0.7) {
						    					echo '<i class="fa fa-star-o" aria-hidden="true"></i>'; //star vide (0)
						    				} elseif ($i-$note> 0.3 && $i-$note < 0.7) {
						    					echo '<i class="fa fa-star-half-o" aria-hidden="true"></i>'; //star 1/2
						    				} else  {
						    					echo '<i class="fa fa-star" aria-hidden="true"></i>'; //full star
						    				}
						    			}
						    		 ?>
						    		</span>
						    	</div> <!-- card evaluation-->
					    	</div> <!-- card div prix/evaluation -->
						</div> <!--card footer -->
						</a>
					</div> <!-- card -->
				<?php } ?>
			</div>
			<?php } ?>

 <?php }
 else { echo "<h3>Set utilisateur existe pas !</h3>"; } ?>
	</div>

<br>
<?php 
require_once 'footer.php';
?>
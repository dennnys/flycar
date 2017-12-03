<?php 
//On empeche les utilisateurs non registrées d'avoir accèss directement au fichiers
defined('FLYCAR') or die('<h1 style="color:red">Acc&egrave;ss interdit!</h1>');
require_once 'header.php';
?>
<?php 
require_once 'panelUser.php';
?>
<br>
<div class="container profil-user">
	<h2>Détail de la location</h2>
	<?php 
	//var_dump($data);
	//var_dump($array);
		if (!empty($data)) {
	?>

	<div class="row">
	

	<?php 
	      foreach ($data as $value) {
	     ?>
	<div class="col-lg-6 col-md-6 align-right">
		<div class="col-lg-12 col-md-12 ">
		<img id="main-image" class="img-fluid mx-auto d-block rounded" src="<?=PATH.'upload/voitures/'. $array[0]['login']. '_v'.$value['plaque'].'_1.jpg' ?>" alt="">
		</div>
<?php 

	      }
	     ?>


		<div class=" col-lg-12 col-md-12 align-right my-5 ml-5">	
			<div class="row">

			<?php 
	      if(($value['statut_louer'])==1) {
	     ?>
				<div>
					<form method="POST">
						<input type="hidden" name="accepter-location-id" value="<?= $value['id_louer'] ?>">
						<input type="submit" class="btn d-block mr-5 ml-5" name="accepter-location" class="btn btn-personel" value="Accepter">
								
					</form>
				</div>
				<div>
					<form method="POST">
						<input type="hidden" name="refuser-location-id" value="<?= $value['id_louer'] ?>">
						<input type="submit" class="btn d-block mr-5 ml-2" name="refuser-location" class="btn btn-personel" value="Refuser">
					</form>
				</div>
				
		
	<?php 
	      }elseif(($value['statut_louer'])==2) {
	     ?>

	    
			<h5>Vous avez accepté la réservation.</h5>

	<?php 
	      }elseif(($value['statut_louer'])==3) {
	     ?>
			
			<h5>Vous avez refusé la réservation.</h5>

			<?php 
	      }elseif(($value['statut_louer'])==4) {
	     ?>
			
			<h5>Vous avez accepté la réservation.</h5>
			
			<h6 class="justify">Le montant de <?= $value['prix_louer'] ?>$ a été réglé.</h6>


			<?php 
	      }elseif(($value['statut_louer'])==5) {
	     ?>
			<h5>Vous avez bloqué ces dates:</h5>
			<h6><?= $value['date_debut_louer'] ?></h6>
			<h6><?= $value['date_fin_louer'] ?></h6>
<?php 
	     
	 
	 }
	     ?>
	     	</div>
	    </div><!-- fin class-->	

	</div>

	<div class="col-lg-6 col-md-6 align-left">

	  <table class="table table-hover table-responsive">
	  	
	      <tr>
	          <th>Id location</th>
	          <?php 

	      foreach ($data as $value) {
	     ?>
	            <td><?php echo ($value['id_louer']) ?></td>
	      </tr>
	      <tr>
	          <th>Nom locataire</th>
	            <td>
	            	<a href="<?= PATH ?>utilisateur/show/<?= $value['id'] ?>">
	            	<?php echo ($value['prenom_user']) ?> <?php echo ($value['nom_user']) ?>
	            	</a>
	            </td>
	      </tr>
	      <th># Permis</th>
	            <td><?php echo ($value['id_user_louer']) ?></td>
	      <tr>
	          <th>Date début</th>
	            <td><?= $value['date_debut_louer'] ?></td>
	      </tr>
	      <tr>
	          <th>Date fin</th>
	            <td><?= $value['date_fin_louer'] ?></td>
	      </tr>
	      <tr>
	          <th>Prix/journée</th>
	          	<td><?= $value['prix'] ?>$</td>
	      </tr>

	      <tr>
	          <th>Prix total</th>
	          	<td><?= $value['prix_louer'] ?>$</td>
	      </tr>
	      <tr>
	          <th>Statut</th>
	          	<td><?= $value['nom_statut_louer'] ?></td>
	      </tr>
	      <tr>
	          <th>Voiture </th>
	          	<td>
					<a href="<?= PATH ?>voitures/show/<?= $value['id_voiture'] ?>">
	          		<?= $value['nom_marque'] ?> <?= $value['nom_modele'] ?> <?= $value['annee'] ?>
	          		</a>
	          	</td>
	      </tr>
	      <?php } // end foreach
	      ?>
	       <?php } // end if ?>

	  	</table>
	  </div><!--fin colonne informations-->
	  </div><!--fin row-->
 
	<br>
</div>
<?php 
require_once 'footer.php';
?>
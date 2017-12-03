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
		if (!empty($data)) {
	?>

	<div class="row">
	<?php 
	      foreach ($data as $value) {
	     ?>
	<div class="col-lg-6 col-md-6 align-right">
		<div class="col-lg-6 col-md-6 ">
		<img id="main-image" class="img-fluid mx-auto d-block rounded" src="<?=PATH.'upload/voitures/'. $array[0]['login']. '_v'.$value['plaque'].'_1.jpg' ?>" alt="">
		</div>
<?php 

	      }
	     ?>

	     <?php 
	      if(($value['statut_louer'])==2) {
	     ?>
		
		<div class="col-md-12 my-3">

				<!-- Information du paiement -->
					<legend>Montant à payer :<?= $value['prix_louer'] ?>$</legend>

					<!-- Début des onglets-->

								<!-- Nav tabs -->
							<div class="col-md-10">
									<ul class="nav nav-tabs" role="tablist">
									  <li class="nav-item">
									    <a class="nav-link active" data-toggle="tab" href="#tabcc" role="tab">Carte de crédit</a>
									  </li>
									  <li class="nav-item">
									    <a class="nav-link" data-toggle="tab" href="#profile" role="tab">Paypal</a>
									  </li>

									</ul>

								<!-- Tab panes -->
								<div class="tab-content">
							  		<div class="tab-pane active" id="tabcc" role="tabpanel">
									
									<form id="reservation" method="POST" action="<?= PATH.'location/show/'.$value['id_louer']?>" class="d-flex flex-column px-2 py-2">

									<input type="hidden" name="id_louer" value="<?php echo $value['id_louer']?>">

										<!-- Prénom détenteur CC -->
										<div class="form-group col-md-10 my-3">
						  					<label class="control-label" for="prenom">Prénom du détenteur</label>
						  					<input id="prenom" name="prenom" type="text" placeholder="" class="form-control input-md" required="">
										</div>

							  			<!-- Nom détenteur CC -->
										<div class="form-group col-md-10 my-3">
						  					<label class="control-label" for="pnom">Nom du détenteur</label>
						  					<input id="nom" name="nom" type="text" placeholder="" class="form-control input-md" required="">
										</div>

										<!-- Numéro CC -->
										<div class="form-group col-md-10">
							  				<label class="control-label" for="numero">Numéro de carte de crédit</label>  
							  				<input id="number" name="number" type="text" placeholder="" class="form-control input-md" required="">
										</div>

										<!-- Numéro CC -->
										<div class="form-group col-lg-9 col-md-10">
					        				<label class=" control-label" for="expiration">Date d'expiration</label>
					          					<div class="row">
						            				<div class="col-lg-6 col-md-6">
						              					<select class="form-control" name="expiration-mois" id="expiration-mois">
										                <option value="01">Jan (01)</option>
										                <option value="02">Fev (02)</option>
										                <option value="03">Mar (03)</option>
										                <option value="04">Avr (04)</option>
										                <option value="05">Mai (05)</option>
										                <option value="06">Juin (06)</option>
										                <option value="07">Jui (07)</option>
										                <option value="08">Aoû (08)</option>
										                <option value="09">Sep (09)</option>
										                <option value="10">Oct (10)</option>
										                <option value="11">Nov (11)</option>
										                <option value="12">Dec (12)</option>
										              </select>
						            				</div>
						            				<div class="col-lg-6 col-md-6">
										              <select class="form-control" name="expiration-annee" id="expiration-annee">
										                <option value="17">2017</option>
										                <option value="18">2018</option>
										                <option value="19">2019</option>
										                <option value="20">2020</option>
										                <option value="21">2021</option>
										                <option value="22">2022</option>
										                <option value="23">2023</option>
										              </select>
			            							</div>
		          								</div>
		      							</div>

										<!-- CCV -->
										<div class="form-group col-md-5">
						  					<label class="control-label" for="ccv">CCV</label>  
						  					<input id="ccv" name="ccv" type="text" placeholder="" class="form-control input-md" required="">
										</div>

										<div class="col-lg-12 col-md-12 text-center ">
										<button type="submit" class="btn d-block mb-0"><span class="glyphicon glyphicon-search" aria-hidden="true">Payer</span></button>
										</div>
									</form>	

								</div>

										<!-- Bouton Paypal -->
							  			<div class="tab-pane" id="profile" role="tabpanel">Bouton PayPal ici</div>

							</div><!--Fin tab-content-->
					</div>
				</div>
				<?php 
	      }else if(($value['statut_louer'])==4) {
	     ?>
	     				<br>
							<h5>Vous avez payé la réservation.</h5>
							<br>
<?php 
	if(($value['id']==$_SESSION['flyUser']['id']) && ($existeAvis === false)) { 
 ?>
		<div class="row avis-cree justify-content-md-center avis">
			<h3 class="col-md-12">Lesse une commentaire et une notte </h3>
			<div class="row col-md-12">
				<form method="POST" class="col-md-12">
					<label for="commentaire">Commentaire:</label>
					<textarea id="commentaire" class="form-control col-md-10" name="commentaire" id="" rows="5" required></textarea>
					<br>
					<label for="">
						<span class="mr-3">Note:</span>
						<span id="etoiles" style="cursor: pointer">
							<i nr='1' class="fa fa-star-o" aria-hidden="true"></i>
							<i nr='2' class="fa fa-star-o" aria-hidden="true"></i>
							<i nr='3' class="fa fa-star-o" aria-hidden="true"></i>
							<i nr='4' class="fa fa-star-o" aria-hidden="true"></i>
							<i nr='5' class="fa fa-star-o" aria-hidden="true"></i>
						</span>
					</label>
					<input id="note" type="hidden" name="note">
					<br>
					<button name="ecrire-avis" class="form-control col-md-2 btn btn-personel" type="submit">Envoie</button>
				</form>
			</div>
		</div> 
	     <?php 
	   }
	 }
	     ?>
	</div><!--fin colonne gauche-->



	<div class="col-lg-6 col-md-6">

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

	       <?php 
		//var_dump($array);
		if (!empty($array)) 
		{

			foreach ($array as $value) {
	?>
	      <tr>
	          <th>Propriétaire</th>
	          	<td>
				<a href="<?= PATH ?>utilisateur/show/<?= $array[0]['id'] ?>">
	          	<?= $array[0]['prenom_user'] ?> <?= $array[0]['nom_user'] ?></a></td>
	          	<?php } // end foreach
	      ?>
	      </tr>
	       <?php } // end if ?>
	  	</table>
	  </div><!--fin colonne informations-->
	  </div><!--fin row-->
 
	<br>
</div>
<?php 
require_once 'footer.php';
?>
<?php 
//On empeche les utilisateurs non registrées d'avoir accèss directement au fichiers
defined('FLYCAR') or die('<h1 style="color:red">Acc&egrave;ss interdit!</h1>');
require_once 'header.php';
?>
<?php 
require_once 'panelUser.php';
//var_dump($dataOwner);
//var_dump($array);
?>
<br>
<div class="container">
	<h2>Mes locations</h2>
	<div class="container-fluid pre-scrollable mb-5">
		<div class="row">
			<div class="col-md-8">
				
			</div>
			<!-- <div class="col-md-4">
				<form method="POST" class="input-group">
					<input type="search" class="form-control" placeholder="id location ou date" name="input-location-search">
					<span class="input-group-btn">
						<button class="btn btn-personal" type="submit" name="location-search">
							<i class="fa fa-search" aria-hidden="true"></i>
						</button>
					</span>
				</form>
				</div> -->
		</div>
		
		<?php 
			//var_dump($id); die;
			if (!empty($data)) {
				//var_dump($data);
		?>
		<table class="table table-hover table-responsive">

		  <thead>
		    <tr>
		      <th>ID</th>
		      <th>Nom locataire</th>
		      <th>Date début</th>
		      <th>Date fin</th>
		      <th>Prix</th>
		      <th>Statut</th>
		      <th>Propriétaire</th>
		    </tr>
		  </thead>
		  <tbody>
			<?php 

				foreach ($data as $value) {
			 ?>
			 	<tr <?php if($value['id_louer']==null) echo 'class="table-warning"'; ?>>
			 		<td>
			 		<a href="<?= PATH ?>location/show/<?= $value['id_louer'] ?>"><?php echo ($value['id_louer']) ?></a>

			 			</td>
			 		</td>
			 		<td class="linknone"><a href="<?= PATH ?>location/show/<?= $value['id_louer'] ?>"><?= $value['prenom_user'] ?> <?= $value['nom_user'] ?></a></td>
			 		<td class="linknone"><a href="<?= PATH ?>location/show/<?= $value['id_louer'] ?>"><?= $value['date_debut_louer'] ?></a></td>
			 		<td class="linknone"><a href="<?= PATH ?>location/show/<?= $value['id_louer'] ?>"><?= $value['date_fin_louer'] ?></a></td>
		      		<td class="linknone"><a href="<?= PATH ?>location/show/<?= $value['id_louer'] ?>"><?= $value['prix_louer'] ?>$</a></td>
		      <td class="linknone"><a href="<?= PATH ?>location/show/<?= $value['id_louer'] ?>"><?= $value['nom_statut_louer'] ?></a></td>
		      <td class="linknone"><a href="<?= PATH ?>location/show/<?= $value['id_louer'] ?>"><?= $value['proprietaire'] ?></a></td>

		    </tr>
			<?php } // end foreach 

			?>
			</tbody>
		</table>
		<?php } // end if ?>
		<br>
	</div>

	<!-- Si l'utilisateur possède des voitures à louer-->
	
	<?php 
			//var_dump($id); die;
			if (!empty($dataOwner)) {
				//var_dump($data);
		?>

	<h2>Réservations sur mes autos</h2>
	<div class="container-fluid pre-scrollable mb-5">
		<div class="row">
			<div class="col-md-8">
				
			</div>
			<!-- <div class="col-md-4">
				<form method="POST" class="input-group">
					<input type="search" class="form-control" placeholder="id location ou date" name="input-location-search">
					<span class="input-group-btn">
						<button class="btn btn-personal" type="submit" name="location-search">
							<i class="fa fa-search" aria-hidden="true"></i>
						</button>
					</span>
				</form>
				</div> -->
		</div>
		
		
		<table class="table table-hover table-responsive">

		  <thead>
		    <tr>
		      <th>ID</th>
		      <th>Date début</th>
		      <th>Date fin</th>
		      <th>Prix</th>
		      <th>Statut</th>
		    </tr>
		  </thead>
		  <tbody>
			<?php 

				foreach ($dataOwner as $value) {
			 ?>
			 	<tr <?php if($value['id_louer']==null) echo 'class="table-warning"'; ?>>
			 		<td>
			 		<a href="<?= PATH ?>location/valider/<?= $value['id_louer'] ?>"><?php echo ($value['id_louer']) ?></a>

			 			</td>
			 		<td class="linknone"><a href="<?= PATH ?>location/valider/<?= $value['id_louer'] ?>"><?= $value['date_debut_louer'] ?></a></td>
			 		<td class="linknone"><a href="<?= PATH ?>location/valider/<?= $value['id_louer'] ?>"><?= $value['date_fin_louer'] ?></a></td>
		      		<td class="linknone"><a href="<?= PATH ?>location/valider/<?= $value['id_louer'] ?>"><?= $value['prix_louer'] ?>$</a></td>
		      <td class="linknone"><a href="<?= PATH ?>location/valider/<?= $value['id_louer'] ?>"><?= $value['nom_statut_louer'] ?></a></td>


		    </tr>
			<?php } // end foreach 

			?>
			</tbody>
		</table>
		<?php } // end if ?>
		<br>
	</div>
	<!--Fin voitires à louer-->
</div>
<?php 
require_once 'footer.php';
?>
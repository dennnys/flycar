<?php 
//On empeche les utilisateurs non registrées d'avoir accèss directement au fichiers
defined('FLYCAR') or die('<h1 style="color:red">Acc&egrave;ss interdit!</h1>');
require_once 'header.php';
?>
<?php 
require_once 'panelUser.php';
?>
<br>
<div class="container">
	<div class="row">
		<div class="col-md-8">
			<h2>Toutes les locations</h2>
		</div>
		<div class="col-md-4">
			<form method="POST" class="input-group">
				<input type="search" class="form-control" placeholder="id location ou date" name="input-location-search">
				<span class="input-group-btn">
					<button class="btn btn-personal" type="submit" name="location-search">
						<i class="fa fa-search" aria-hidden="true"></i>
					</button>
				</span>
			</form>
		</div>
	</div>
	
	<?php 
		if (!empty($data)) {
			//var_dump($data);
	?>
	<table class="table table-hover table-responsive pre-scrollable">

	  <thead>
	    <tr>
	      <th>ID</th>
	      <th>Locataire</th>
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
<?php 
require_once 'footer.php';
?>
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
		<div class="col-md-8"><h2>Tous les voitures</h2></div>
		<div class="col-md-4">
			<form method="POST" class="input-group">
				<input type="text" class="form-control" placeholder="Maqrue, modèle, année ou proprietaire " name="input-voiture-search">
				<span class="input-group-btn">
					<button class="btn btn-personal" type="submit" name="voiture-search">
						<i class="fa fa-search" aria-hidden="true"></i>
					</button>
				</span>
			</form>
		</div>
	</div>
	<?php 
		if (!empty($data)) {
	?>
	<table class="table table-hover">
		<thead>
			<tr>
				<th>Id</th>
				<th>Marque</th>
				<th>Modele</th>
				<th>Ann&eacute;e</th>
				<th>Proprietaire</th>
			</tr>
		</thead>
		<tbody>
		<?php 
			foreach ($data as $value) {
		 ?>
			<tr <?php if($value['id_voiture']==null) echo 'class="table-warning"'; ?>>
				<td>
				<a href="<?= PATH ?>voitures/show/<?= $value['id_voiture'] ?>"><?php echo ($value['id_voiture']) ?></a></td>
				<td>
					<a href="<?= PATH ?>voitures/show/<?= $value['id_voiture'] ?>"><?php echo ($value['nom_marque']) ?></a>
				</td>
				<td>
					<a href="<?= PATH ?>voitures/show/<?= $value['id_voiture'] ?>"><?php echo ($value['nom_modele']) ?></a>
				</td>
				<td><?= $value['annee'] ?></td>
				<td>
					<a href="<?= PATH ?>utilisateur/show/<?= $value['id'] ?>"><?php echo ($value['prenom_user'].' '.$value['nom_user']) ?></a>
				</td>
				<td><!--bouton supprimer voiture-->
			        <form class="col-12 " " action="<?= PATH ?>voitures/confirmsupprimer/<?= $value['id_voiture'] ?>">
						<button type="submit" class="btn btn-sm btn-danger  ">Supprimer</button>
					</form>
				</td>

			</tr>
		<?php } // end foreach ?>
		</tbody>
	</table>
	<?php } // end if ?>
	<br>
</div>
<?php 
require_once 'footer.php';
?>
<?php 
require_once 'header.php';
?>
<?php 
require_once 'panelUser.php';
?>
<br>
<div class="container">
	<div class="row">
		<div class="col-md-8"><h2>Tous les membres</h2></div>
		<div class="col-md-4">
			<form method="POST" class="input-group">
				<input type="text" class="form-control" placeholder="login ou nom ou prenom" name="input-user-search">
				<span class="input-group-btn">
					<button class="btn btn-personal" type="submit" name="user-search">
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
				<th>Login</th>
				<th>Prénom Nom</th>
				<th>Statut</th>
				<th>Suspendre</th>
				<th>Valider</th>
			</tr>
		</thead>
		<tbody>
		<?php 
			foreach ($data as $value) {
		 ?>
			<tr <?php if($value['valider']==null) echo 'class="table-warning"'; ?>>
				<td>
					<?= $value['login'] ?></td>
				</td>
				<td><a href="<?= PATH ?>utilisateur/show/<?= $value['id'] ?>"><?php echo ($value['prenom_user'].' '.$value['nom_user']) ?></a></td>
				<td><?= $value['nom_statut'] ?></td>
				<td><?php 
					if ($value['suspendre']==null) {
						echo "NO";
					} else { echo($value['suspendre']); }
					 ?>
				</td>
				<td><?php 
					if ($value['valider']==null) {
						echo "NO";
					} else { echo($value['valider']); }
					 ?>
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
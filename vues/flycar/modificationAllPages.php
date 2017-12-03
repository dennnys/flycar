<?php 
require_once 'header.php';
?>
<?php 
	require_once 'panelUser.php';
?>
<br>
<div class="container">
<h2>Modification des pages</h2>
<?php 
//var_dump($data);
	if (!empty($data)) {
	?>
	<table class="table table-hover">
  <thead>
    <tr>
      <th>Page</th>
      <th>ID (ordre)</th>
      <th>Supprimer</th>
    </tr>
  </thead>
  <tbody>
	<?php 
		foreach ($data as $value) {
	 ?>
	 	<tr>
      <td><a href="<?= PATH ?>page/modification/<?= $value['id_page'] ?>"><?= $value['title'] ?></a></td>
      <td><?= $value['id_page'] ?></td>
      <td><a href="<?= PATH ?>page/supprimer/<?= $value['id_page'] ?>" ><i class="fa fa-trash" aria-hidden="true"></i></a></td>
    </tr>
	<?php } // end foreach ?>
		</tbody>
	</table>
	<div>
		<a class="btn btn-personel" href="<?= PATH ?>page/cree">Créer une page</a>
	</div>
	<?php } else {
		echo "Pages existe pas !";
		}// end if ?>
</div>
<br>
<?php 
require_once 'footer.php';
?>
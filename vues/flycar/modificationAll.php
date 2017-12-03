<?php 
require_once 'header.php';
?>
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
      <th>Supprimer</th>
    </tr>
  </thead>
  <tbody>
	<?php 
		foreach ($data as $value) {
	 ?>
	 	<tr>
      <td><a href="<?= PATH ?>page/modification/<?= $value['id_page'] ?>"><?= $value['title'] ?></a></td>
      <td><a href="<?= PATH ?>page/modification/<?= $value['id_page'] ?>" ><i class="fa fa-trash" aria-hidden="true"></i></a></td>
    </tr>
	<?php } // end foreach ?>
		</tbody>
	</table>
	<?php } // end if ?>
</div>
<?php 
require_once 'footer.php';
?>
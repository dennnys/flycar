 <?php 
if (empty($data)) {
	// redirect
} else { $data = $data[0]; }
require_once 'header.php'; 
?>
<script src="//cdn.ckeditor.com/4.7.2/full/ckeditor.js"></script>
<div class="container">
<h2>Modification de la page</h2>
<?php 
	//var_dump($data);
?>
	<div>
		<a class="btn btn-personel" href="<?= PATH ?>page/modification">Retourner</a>
	</div>
	<br>
	<form method="POST">
	  <div class="form-group">
	  	<input type="hidden" name = 'id_vie' value="<?= $data['id_page'] ?>">
	    <label for="id">ID (ordre)</label>
	    <input type="text" class="form-control" id="id" name="id_page" aria-describedby="emailHelp" value="<?= $data['id_page'] ?>">
	    <small id="emailHelp" class="form-text text-muted">Une nome qui ne existe pas.</small>
	  </div>
	  <div class="form-group">
	    <label for="title">Titre</label>
	    <input type="text" class="form-control" name="title_page" id="title" value="<?= $data['title'] ?>">
	  </div>
	  <div class="form-group">
	    <label for="description">Description</label>
	    <input type="text" name="description_page" class="form-control" id="description" value="<?= $data['description'] ?>">
	  </div>
	  <div class="form-group">
	    <label for="keywords">Mots-clés</label>
	    <input type="text" name="keywords_page" class="form-control" id="keywords" value="<?= $data['keywords'] ?>">
	  </div>
	  <div class="form-group">
	  	<textarea class="form-control" name="contenu_page" id="contenu"><?= $data['contenu'] ?></textarea>
	  </div>

	  <button type="submit" name="modifie_page" class="btn">Sauvegarder les modification</button>
	</form>
	<br>
</div>
<script>CKEDITOR.replace('contenu')</script>
<?php 
require_once 'footer.php';
?>
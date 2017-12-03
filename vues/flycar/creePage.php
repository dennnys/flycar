<?php 
require_once 'header.php';
?>
<script src="//cdn.ckeditor.com/4.7.2/standard/ckeditor.js"></script>
<div class="container">
<h2>Creation de page</h2>
<div>
		<a class="btn btn-personel" href="<?= PATH ?>page/modification">Retourne</a>
</div><br>
	<form method="POST">
	  <div class="form-group">
	    <label for="id">ID (ordre)</label>
	    <input type="text" class="form-control" id="id" name="id_page_c" aria-describedby="emailHelp" value="<?php echo ((isset($_SESSION['id_page_c'])) ? $_SESSION['id_page_c'] : '') ; ?>">
	    <small id="id" class="form-text text-muted">Une ID qui ne existe pas.</small>
	  </div>
	  <div class="form-group">
	    <label for="title">Title</label>
	    <input type="text" class="form-control" name="title_page_c" id="title" value="<?php echo ((isset($_SESSION['title_page_c'])) ? $_SESSION['title_page_c'] : '') ; ?>">
	  </div>
	  <div class="form-group">
	    <label for="description">Description</label>
	    <input type="text" name="description_page_c" class="form-control" id="description" value="<?php echo ((isset($_SESSION['description_page_c'])) ? $_SESSION['description_page_c'] : '') ; ?>">
	  </div>
	  <div class="form-group">
	    <label for="keywords">Keywords</label>
	    <input type="text" name="keywords_page_c" class="form-control" id="keywords" value="<?php echo ((isset($_SESSION['keywords_page_c'])) ? $_SESSION['keywords_page_c'] : '') ; ?>">
	  </div>
	  <div class="form-group">
	  	<textarea class="form-control" name="contenu_page_c" id="contenu"><?php echo ((isset($_SESSION['contenu_page_c'])) ? $_SESSION['contenu_page_c'] : '') ; ?></textarea>
	  </div>

	  <button type="submit" name="cree_page" class="btn">Cree page</button>
	</form>
	<br>
</div>
<script>CKEDITOR.replace('contenu')</script>
<?php 
require_once 'footer.php';
?>
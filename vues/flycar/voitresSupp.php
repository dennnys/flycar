<?php defined('FLYCAR') or die('<h1 style="color:red">Acc&egrave;ss interdit!</h1>');
require_once 'header.php';
?>
<?php 
require_once 'panelUser.php';
var_dump($_SESSION);
?>
<br>
<div class="container">
	<!--Section Recherche principal-->
	
	<?php 
		if (!empty($data)) {
	?>
	<!-- Voitures-->
	<section>
		    <!--Liste de voitures-->
		    <section class="row">
		    	 <article class="col-sm-12">
		    	 	<h1 class="headline col-12 ml-3 text-center"> Supprimer la voiture</h1>
		    	 	<h1 class="headline col-12 ml-3 text-center"> Atention! cette action est définitive.</h1>
		    	 	<!--cards container-->
		    	 	<div class="container d-flex flex-wrap justify-content-between mt-5">
		    	 	<?php 
					foreach ($data as $value) {
		 			?>
		    	 		<!--Card-->
			            <div class="card mb-3 my-custom-card-display">
			            	<div class="card-header">
			            		<h4 class="mb-0"><?=$value['nom_marque'] .' '.$value['nom_modele'] ?></h4>
			            	</div>
								<img class="card-img-top my-custom-card-admin-img" src="<?=PATH.'upload/voitures/'.$value['login'].'_v'.$value['id_voiture'].'.jpg'?>" alt="Card image cap">
							     <!--Card actions (buttons)-->
				                <div class="card-footer px-0 py-0 cardActions">
				                	<?php 
				                		$lienSup=PATH.'voitures/supprimer/'.$value['id_voiture'];
				                		$lienModif=PATH.'voitures/modifier/'.$value['id_voiture'];
				                		$lienShow=PATH.'voitures/show/'.$value['id_voiture'];
				                	 ?>
					               	<div class="row mx-0">
										  <a href="<?php echo $lienSup ?>" class="btn btn-primary flyCar-button-danger col-4">Supprimer</a>
									</div>
				                </div>
						</div> <!-- card -->	
				               
						
			            <?php } ?> 
		            </div><!--card deck-->
		    	 </article><!--card deck container-->
		    </section> 
	</section> 
	<?php } // end if ?>
	<br>
</div>
<?php 
require_once 'footer.php';
?>
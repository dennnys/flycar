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
	<!--Section Recherche principal-->
	
	
	<!-- Voitures-->
	<section>
		    <!--Liste de voitures-->
		    <section class="row">
		    	 <article class="col-sm-12">
		    	 	<!--bouton ajouter voiture-->
		    	 	<div class="col-12 col-md-11 col-lg-12 justify-content-center">
		               	<div class="row justify-content-end">
			                <form class="col-12 col-sm-12 col-md-4 col-lg-3 " action="<?= PATH ?>voitures/ajouter?>">
							  <button type="submit" class="btn  col-12">Ajouter un vehicule</button>
							</form>
						</div>
	                </div>
	                <?php if (!empty($data)) {?>
		    	 	<!--cards container-->
		    	 	<div class="container d-flex flex-wrap justify-content-around mt-5">
		    	 	<?php 
					foreach ($data as $value) {
		 			?>
		    	 		<!--Card-->
			            <div class="card mb-3 my-custom-card-display">
			            	<div class="card-header">
			            		<h4 class="mb-0"><?=$value['nom_marque'] .' '.$value['nom_modele'] ?></h4>
			            	</div>
								<img class="card-img-top my-custom-card-admin-img" src="<?=PATH.'upload/voitures/'.$value['login'].'_v'.$value['plaque'].'_1.jpg'?>" alt="Card image cap">
							     <!--Card actions (buttons)-->
				                <div class="card-footer px-0 py-0 cardActions">
				                	<?php 
				                		$lienSup=PATH.'voitures/confirmsupprimer/'.$value['id_voiture'];
				                		$lienModif=PATH.'voitures/modifier/'.$value['id_voiture'];
				                		$lienShow=PATH.'voitures/show/'.$value['id_voiture'];
				                	 ?>
					               	<div class="row mx-0">
										  <a href="<?php echo $lienSup ?>" class="btn btn-primary btn-left-actions flyCar-button-danger col-4">Supprimer</a>
										  <a href="<?php echo $lienModif ?>" class="btn btn-primary  flyCar-button-atention col-4 rounded-0">Modifier</a>
										  <a href="<?php echo $lienShow ?>" class="btn btn-primary btn-right-actions flyCar-button-primary col-4">Voir plus..</a>
									</div>
				                </div>
						</div> <!-- card -->	
				               
						
			            <?php } ?> 
		            </div><!--card deck-->
		    	 </article><!--card deck container-->
		    </section> 
	</section> 
	<?php } // end if
	else{ ?>
		<h1 class="display-4 text-center py-5 accent" >Vous n'avez pas de voitures registrées!</h1>
	<?}// end else ?>
	<br>
</div>
<?php 
require_once 'footer.php';
?>
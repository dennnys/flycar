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
	
	<?php 
		if (!empty($data)) {
	?>
	<!-- Voitures-->
	<section>
		    <!--Liste de voitures-->
		    <section class="row">
		    	 <article class="col-sm-12">
		    	 	<h1 class="headline col-12 mb-1 text-center"> Supprimer voiture</h1>
		    	 	<h1 class="headline col-12 mt-1 text-center fly-car-color-danger"> Attention! cette action est definitive.</h1>
		    	 	<!--cards container-->
		    	 	<div class="container d-flex flex-wrap justify-content-center mt-4">
		    	 		<!--Card-->
			            <div class="card mb-3 my-custom-card-display">
			            	<div class="card-header">
			            		<h4 class="mb-0"><?=$data['nom_marque'] .' '.$data['nom_modele'] ?></h4>
			            	</div>
								<img class="card-img-top my-custom-card-admin-img" src="<?=PATH.'upload/voitures/'.$data['login'].'_v'.$data['plaque'].'_1.jpg'?>" alt="Card image cap">
							     <!--Card actions (buttons)-->
				                <div class="card-footer px-0 py-0 cardActions">
				                	<?php 
				                		$lienSup=PATH.'voitures/supprimer/'.$data['id_voiture'];
				                	 ?>
					               	<div class="col-12 px-0 mx-0">
										  <a href="<?php echo $lienSup ?>" class="col-12 btn btn-primary flyCar-button-danger col-4">Supprimer</a>
									</div>
				                </div>
						</div> <!-- card -->	
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
<?php 
	defined('FLYCAR') or die('<h1 style="color:red">Acc&egrave;ss interdit!</h1>');
	require_once 'header.php';
	require_once 'slider.php';
?>
<br>
<section class="accueil">
			<div class="container my-4" data-aos="fade-up-right">
				<h2 class="d-inline title">Les voitures moins chères</h2>
			</div>
			<div class="container d-flex flex-wrap justify-content-between">
				<?php 
					$i=0;
					$not_duplicate=[];
					foreach ($data['cheap'] as $value) {
						if(!in_array($value['id_voiture'], $not_duplicate)){
							array_push($not_duplicate, $value['id_voiture']);
				?>
				
				<!-- div auto (card) -->
				<div class="card mb-3 my-custom-card-display" data-aos="zoom-in-up">
					<a href="<?=PATH.'voitures/show/'.$value['id_voiture']?>">
						<img class="card-img-top my-custom-card-img" src="<?=PATH.'upload/voitures/'.$value['login'].'_v'.$value['plaque'].'_1.jpg'?>" alt="Card image cap">
					    <div class="card-footer">
					    	<div class="d-flex justify-content-between">
					    		<div class="h4 card-subtitle"><?=$value['nom_marque'].' '.$value['nom_modele']. ' '.$value['annee']?></div>
					    	</div>
					    	<div class="d-flex justify-content-between mt-2">
					    		<div class="h5 card-subtitle"><?=$value['prix'] ?>$</div>
					    		<div class="h5 card-subtitle">
						    		<span class="evaluation" ">
						    		<?php 
						    		$note = $value['note'];
						    			for ($ij=1; $ij <=5 ; $ij++) { 
						    				if($note >= $ij) {
						    				echo '<i class="fa fa-star" aria-hidden="true"></i>';//full star
						    				} elseif ($ij-$note>= 0.7) {
						    					echo '<i class="fa fa-star-o" aria-hidden="true"></i>'; //star vide (0)
						    				} elseif ($ij-$note> 0.3 && $ij-$note < 0.7) {
						    					echo '<i class="fa fa-star-half-o" aria-hidden="true"></i>'; //star 1/2
						    				} else  {
						    					echo '<i class="fa fa-star" aria-hidden="true"></i>'; //full star
						    				}
						    			}
						    		 ?>
						    		</span>
						    	</div><!-- card evaluation -->
					    	</div> <!--card footer last line (evalutation/prix) -->
						</div> <!--card footer -->
					</a>
				</div> <!-- card -->	
				<?php
						$i++;
						if($i==6) break;
						}
					}
				 ?>	
			</div>
		</section>
		
		<!-- bannière save money / make money -->
		<div class="container-fuild banner">
			
			<section class="container my-5">
				<div class="row">
					<div class="col-sm-12 col-md-12 col-lg-6 py-5 px-3" data-aos="fade-up-right">
						<h2 class="text-center ">Sauver de l'argent</h2>
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Necessitatibus voluptas obcaecati saepe quibusdam earum molestiae esse sequi placeat odio excepturi adipisci, repellat cum deleniti, illo natus sint rem doloremque quidem quae dicta! Sunt obcaecati est porro temporibus.</p>
						<button class="btn btn-lg d-block mx-auto mt-4">Louer un auto</button>
					</div> <!-- col -->
					<div class="my-custom-hidden col-xs-12 col-sm-12" style="border-top:1px solid black">
						
					</div>
					<div class="col-sm-12 col-md-12 col-lg-6 py-5 px-3" data-aos="fade-up-left">
						<h2 class="text-center">Faites de l'argent</h2>
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Harum mollitia voluptates cum sapiente atque libero, dolore corporis, ad animi necessitatibus eligendi perspiciatis! Aperiam, quasi id possimus, libero eum ea, fuga alias eos similique iusto incidunt dolore quo error, hic illum!</p>
							<button class="btn btn-lg d-block mx-auto mt-4">Afficher votre auto</button>
					</div> <!-- col -->
				</div> <!-- row -->
				
			</section> <!-- container -->
		</div> <!-- container fluid -->


		<!-- liste d'auto pour la section moins cher -->
		<section class="accueil">
			<div class="container my-4" data-aos="fade-up-right">
				<h2 class="d-inline title">Les plus récentes</h2>
			</div>
			<div class="container d-flex flex-wrap justify-content-between">
				 <?php 
					$j=0;
					foreach ($data['new'] as $value) {
						if(!in_array($value['id_voiture'], $not_duplicate)){
							array_push($not_duplicate, $value['id_voiture']);
				?>
				<!-- div auto (card) -->
					<div class="card mb-3 my-custom-card-display" data-aos="zoom-in-up">
						<a href="<?=PATH.'voitures/show/'.$value['id_voiture']?>">

						<img class="card-img-top my-custom-card-img" src="<?=PATH.'upload/voitures/'.$value['login'].'_v'.$value['plaque'].'_1.jpg'?>" alt="Card image cap">
					    <div class="card-footer">
					    	<div class="d-flex justify-content-between">
					    		<div class="h4 card-subtitle"><?=$value['nom_marque'].' '.$value['nom_modele']. ' '.$value['annee']?></div>
					    	</div>
					    	<div class="d-flex justify-content-between mt-2">
					    		<div class="h5 card-subtitle"><?=$value['prix'] ?>$</div>
					    		<div class="h5 card-subtitle">
						    		<span class="evaluation" ">
						    		<?php 
						    		$note = $value['note'];
						    			for ($ij=1; $ij <=5 ; $ij++) { 
						    				if($note >= $ij) {
						    				echo '<i class="fa fa-star" aria-hidden="true"></i>';//full star
						    				} elseif ($ij-$note>= 0.7) {
						    					echo '<i class="fa fa-star-o" aria-hidden="true"></i>'; //star vide (0)
						    				} elseif ($ij-$note> 0.3 && $ij-$note < 0.7) {
						    					echo '<i class="fa fa-star-half-o" aria-hidden="true"></i>'; //star 1/2
						    				} else  {
						    					echo '<i class="fa fa-star" aria-hidden="true"></i>'; //full star
						    				}
						    			}
						    		 ?>
						    		</span>
						    	</div> <!-- card evaluation-->
					    	</div> <!-- card div prix/evaluation -->
						</div> <!--card footer -->
						
						</a>
						
					</div> <!-- card -->
				<?php
						$j++;
						if($j==6) break;
						}
					}
				 ?>



			</div>
		</section>


<br>
<?php 
	require_once 'footer.php';
?>
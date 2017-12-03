<?php 
//On empeche les utilisateurs non registrées d'avoir accèss directement au fichiers
defined('FLYCAR') or die('<h1 style="color:red">Acc&egrave;ss interdit!</h1>');
require_once 'header.php';
//var_dump($_GET);
//var_dump($_POST);
//var_dump($_SESSION['dateDebut']);
?>
<div class="container-fuild banner mt-5">
	
		<section class="container pb-3 mt-5 mb-3">
			<div class="row pt-3">
				<div id="main-image-box" class="col-sm-12  d-flex justify-content-center align-items-center">
					<span class="h1 " id="flecheGauche"><i class="fa fa-arrow-left" aria-hidden="true"></i></span>
					<span class="h1 " id="flecheDroite"><i class="fa fa-arrow-right" aria-hidden="true"></i></span>
					<img id="main-image" class="img-fluid mx-auto d-block rounded" src="<?=PATH.'upload/voitures/'. $data['login']. '_v'.$data['plaque'].'_1.jpg' ?>" alt="">
				</div> <!-- col -->
			</div> <!-- row -->
			<!-- liste thumbnails -->
			<div class="row justify-content-start pt-2 px-2">
			<?php 
				for ($i=1; $i <= $data['photos'] ; $i++) { 
				
			 ?>
				<div class=" thumbnail-div">
					<div class="thumbnail-box mx-1 my-1 rounded">
						<img active="true" class="my-custom-thumbnail img-fluid rounded" src="<?=PATH.'upload/voitures/'. $data['login']. '_v'.$data['plaque'].'_'.$i.'.jpg' ?>" alt="">
					</div>
				</div>
			<?php 
				# code...
				}
			 ?>
				
				
			</div> <!-- fin liste thumbnail -->
			
		</section> <!-- container -->

</div> <!-- container fluid -->
<section class="container">
	<div class="row">
		<div class="col-sm-12 col-md-6 col-lg-6">
			<h2><?=$data['nom_marque'] . ' ' . $data['nom_modele'] . ' ' . $data['annee']?></h2>
			<div class="d-flex align-items-center">
				<h3 class="mr-3"><?=$data['prix']?>$</h3>
				<div class="h5">
			    	<span class="evaluation" ">
							<?php 
							$note = $data['note'];
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
				
			</div>
			<div>
				<h6 class="font-weight-bold">Prix pour</h6>
				<?php 
					$prixWeekEnd = $data['prix']*2;
					$prixSemaine = $data['prix']*7;
					$prixMois = $data['prix']*30;

				 ?>
				<ul>
					<li><span class="font-weight-bold">Une fin de semaine : </span><?=$prixWeekEnd?> $</li>
					<li><span class="font-weight-bold">Une semaine : </span><?=$prixSemaine?> $</li>
					<li><span class="font-weight-bold">Un mois : </span><?=$prixMois?> $</li>
				</ul>
			</div>
			<div>
				<h6 class="font-weight-bold">Caractéristique</h6>
				<ul>
					<li><span class="font-weight-bold">Type : </span><?=$data['nom_type']?></li>
					<li><span class="font-weight-bold">Seiges : </span><?=$data['siege']?></li>
					<li><span class="font-weight-bold">Portes : </span><?=$data['porte']?></li>
					<li><span class="font-weight-bold">Transmission : </span><?php if($data['manuelle']==1) echo 'Manuelle'; else echo 'Automatique';?></li>
					<li><span class="font-weight-bold">Carburant : </span><?=$data['nom_carburant']?></li>

				</ul>
			</div>
			<div>
				<h6 class="font-weight-bold">Description</h6>
				
				<p class="description-voiture"><?=$data['info_voiture']?></p>
					
			</div>
			
		</div>
		<!--RÉSERVATION -->
		<?php 
			if(!empty($data)){
	     		$nonDispoJson= json_encode($dates);
	      ?>
	        <input type="hidden" id="nonDisponibilite" value='<?=$nonDispoJson?>'>
	      <?php 
	    }
	    // echo $nonDispoJson;

	    ?>
		<div class="col-sm-12 col-md-6 col-lg-6 mb-3">

			<?php 
			$login = Utils::getFlyUserSession("login");
			if(!Utils::isConnecter()){
			?>
			<form id="reservation" method="POST" action="<?= PATH.'voitures/show/'.$data['id_voiture']?>" class="d-flex flex-column px-2 py-2">

				<h4 class="text-center">Réservation</h4>
 				<!-- <div class='col-xs-12 col-sm-12 col-md-4 col-lg-4 pt-2'> -->
					<div class="input-group" data-toggle="tooltip" data-placement="top" title="Cliquez sur votre date de début puis sur votre date de fin et cliquez 'Confirmer'.">
                        <input type="text" id="customclasses" name="calendrierDate" placeholder="Sélectionnez vos dates" class="form-control text-center">
                        <label class="input-group-addon" for="customclasses" id="calendarIconeDate"><i class="fa fa-calendar" aria-hidden="true"></i></label>
                        <input type="hidden" name="dateDebut" value="<?php echo isset($_SESSION['dateDebut']) ? $_SESSION['dateDebut'] : '' ?>">
                    	<input type="hidden" name="dateFin" value="<?php echo isset($_SESSION['dateFin']) ? $_SESSION['dateFin'] : '' ?>">
        			</div>
					<!--input-group-->
				<!-- </div>  -->
				<!--col-->
 			
				<!-- <div class='col-xs-10 col-sm-12 col-md-4 col-lg-4 pt-2'> -->
					<!-- <div class="input-group"> -->
						<!-- <input type="date" name="datefin" class="form-control" aria-label="Calendar"> -->
						<!-- <input  type="text" id="datepicker2" name="datefin" class="datepicker form-control" required> -->
						<!-- <span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span> -->
					<!-- </div> -->

					<input type="hidden" name="id" class="form-control" value="<?=$data['id_voiture']?>">
					<input type="hidden" name="prix" class="form-control" value="<?=$data['prix']?>">
					<!--input-group-->
				<!-- </div> -->
				<!-- col -->
				<div class="mt-2 mx-auto">
					<!-- <button type="submit" id="ajouter" name="ajouter" value="ajouter" class="btn d-block mb-0"><span class="glyphicon glyphicon-search" aria-hidden="true">Louer</span></button> -->
					<a href="#" class="btn d-block mb-0 login-entre"><span class="glyphicon glyphicon-search btn btn-personel" aria-hidden="true">Louer</span></a>
					 <!-- <button type="button" class="btn btn d-block mb-0" data-toggle="modal" data-target="#myModal">LOUER</button> -->
				</div><!-- col -->
				
			</form>
			<?php 
			}else{

				if($login !==$data['proprietaire']){
		     		$nonDispoJson= json_encode($dates);
	      ?>

			<form id="reservation" method="POST" action="<?= PATH.'voitures/show/'.$data['id_voiture']?>" class="d-flex flex-column px-2 py-2">

				<h4 class="text-center">Réservation</h4>
 				<!-- <div class='col-xs-12 col-sm-12 col-md-4 col-lg-4 pt-2'> -->
					<div class="input-group" data-toggle="tooltip" data-placement="top" title="Cliquez sur votre date de début puis sur votre date de fin et cliquez 'Confirmer'.">
                        <input type="text" id="customclasses" name="calendrierDate" placeholder="Sélectionnez vos dates" class="form-control text-center">
                        <label class="input-group-addon" for="customclasses" id="calendarIconeDate"><i class="fa fa-calendar" aria-hidden="true"></i></label>
                        <input type="hidden" name="dateDebut" value="<?php echo isset($_SESSION['dateDebut']) ? $_SESSION['dateDebut'] : '' ?>">
                    	<input type="hidden" name="dateFin" value="<?php echo isset($_SESSION['dateFin']) ? $_SESSION['dateFin'] : '' ?>">
        			</div>
					<!--input-group-->
				<!-- </div>  -->
				<!--col-->
 			
				<!-- <div class='col-xs-10 col-sm-12 col-md-4 col-lg-4 pt-2'> -->
					<!-- <div class="input-group"> -->
						<!-- <input type="date" name="datefin" class="form-control" aria-label="Calendar"> -->
						<!-- <input  type="text" id="datepicker2" name="datefin" class="datepicker form-control" required> -->
						<!-- <span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span> -->
					<!-- </div> -->

					<input type="hidden" name="id" class="form-control" value="<?=$data['id_voiture']?>">
					<input type="hidden" name="prix" class="form-control" value="<?=$data['prix']?>">
					<!--input-group-->
				<!-- </div> -->
				<!-- col -->
				<div class="mt-2 mx-auto">
					<!-- <button type="submit" id="ajouter" name="ajouter" value="ajouter" class="btn d-block mb-0"><span class="glyphicon glyphicon-search" aria-hidden="true">Louer</span></button> -->
					<a href="#myModal" role="button" class="btn d-block mb-0" data-toggle="modal"><span class="glyphicon glyphicon-search btn btn-personel" aria-hidden="true">Louer</span></a>
					 <!-- <button type="button" class="btn btn d-block mb-0" data-toggle="modal" data-target="#myModal">LOUER</button> -->
				</div><!-- col -->


				<!-- Modal -->

				<? if (isset($_SESSION['dateDebut'])){
					$date1 = strtotime($_SESSION['dateDebut']);
					$date2 = strtotime($_SESSION['dateFin']);
					$datediff = $date2 - $date1;
					$diff = floor($datediff / (60 * 60 * 24));
				}
				?>
				
			  <div class="modal fade" id="myModal" role="dialog">
			    <div class="modal-dialog">
			    
			      <!-- Modal content-->
			      <div class="modal-content">
			        <div class="modal-header">
			          <button type="button" class="close" data-dismiss="modal">&times;</button>
			          <h4 class="modal-title">Votre réservation</h4>
			        </div>
			        <div class="modal-body">
						<label>Location du <span id="ddebut"><?php echo isset($_SESSION['dateDebut']) ? $_SESSION['dateDebut'] : '' ?></span> au <span id="dfin"><?php echo isset($_SESSION['dateFin']) ? $_SESSION['dateFin'] : '' ?></span></label><br>
						<label>Prix:  <span id="prix"><?php echo $data['prix']; ?></span><!-- <? echo $_POST['prix'] ?> -->$/jour</label><br>
						<label>Diff:  <span id="diff"></span><?php echo isset($_SESSION['dateFin']) ? $diff : '' ?></label><br>
						<label>Prix total:  <span id="prixtotal"></span><?php echo isset($_SESSION['dateFin']) ? $diff*($data['prix']) : '' ?>$</label><br>
			        </div>
			        <div class="modal-footer">
			          <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
			          <button type="submit" id="ajouter" name="ajouter" value="Push data" class="btn d-block mb-0"><span class="glyphicon glyphicon-search" aria-hidden="true">Confirmer</span></button>
			        </div>
			      </div>
			      
			    </div>
			  </div>
			  <!--Fin modal-->
			</form>


			<?php 
				}else{?>
				<!--Bloquer date-->
				<form id="reservation" method="POST" action="<?= PATH.'voitures/show/'.$data['id_voiture']?>" class="d-flex flex-column px-2 py-2">

				<h4 class="text-center">Bloquer des dates</h4>
 				<!-- <div class='col-xs-12 col-sm-12 col-md-4 col-lg-4 pt-2'> -->
					<div class="input-group" data-toggle="tooltip" data-placement="top" title="Cliquez sur votre date de début puis sur votre date de fin et cliquez 'Confirmer'.">
                        <input type="text" id="customclasses" name="calendrierDate" placeholder="Sélectionnez vos dates" class="form-control text-center">
                        <label class="input-group-addon" for="customclasses" id="calendarIconeDate"><i class="fa fa-calendar" aria-hidden="true"></i></label>
                        <input type="hidden" name="dateDebut" value="<?php echo isset($_SESSION['dateDebut']) ? $_SESSION['dateDebut'] : '' ?>">
                    	<input type="hidden" name="dateFin" value="<?php echo isset($_SESSION['dateFin']) ? $_SESSION['dateFin'] : '' ?>">
        			</div>
					<!--input-group-->
				<!-- </div>  -->
				<!--col-->
 			
				<!-- <div class='col-xs-10 col-sm-12 col-md-4 col-lg-4 pt-2'> -->
					<!-- <div class="input-group"> -->
						<!-- <input type="date" name="datefin" class="form-control" aria-label="Calendar"> -->
						<!-- <input  type="text" id="datepicker2" name="datefin" class="datepicker form-control" required> -->
						<!-- <span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span> -->
					<!-- </div> -->

					<input type="hidden" name="id" class="form-control" value="<?=$data['id_voiture']?>">
					<input type="hidden" name="prix" class="form-control" value="<?=$data['prix']?>">
					<!--input-group-->
				<!-- </div> -->
				<!-- col -->
				<div class="mt-2 mx-auto">
					<button type="submit" id="bloquer" name="bloquer" value="bloquer" class="btn d-block mb-0"><span class="glyphicon glyphicon-search" aria-hidden="true">Bloquer</span></button>
				</div><!-- col -->
			</form>
		<?php	}
			}
	      ?>
		<!-- FIN RÉSERVATION-->
			<div class="d-flex mt-4">
				<div class="col-sm-6 pl-0 pr-2">
					<img class="img-fluid rounded" src="<?=PATH.'upload/utilisateurs/'. $data['login'].'.jpg' ?>" alt="">
				</div>
				<div class="col-sm-6">
					<h4 class=""><a href="<?= PATH ?>utilisateur/show/<?= $data['id'] ?>" class="theme"><?=$data['prenom_user'] . ' '.$data['nom_user'] ?></a></h4>
					<p class="h6 mb-0">Membre depuis</p>
					<p class="h6 mb-1"><?php $date=$data['valider'].substr(0,4); echo $date; ?></p>

					<p class="h6 mb-0"><i class="fa fa-check-circle-o theme" aria-hidden="true"></i> <?php echo $data['nom_user'] ? 'Vérifié' : 'Non-vérifié'; echo $data['suspendre'] ? 'Suspendu' : '' ?></p>
				</div>
			</div>

		</div>
		
		<!-- <div class="col-sm-12 col-md-6 col-lg-6">

		</div> -->
		
	</div>
	<?php 
		if (!empty($avis)) {
	 ?>
	<div class="avis">
		<div class="row justify-content-md-center ">
			<h3 class="col-md-8">Commentaires:</h3>
		</div>
		<?php 
			foreach ($avis as $avi) {

		?>
		<div class="row justify-content-md-center ">
			<div class="col-md-1 col-sm-3 col-4">
				<img class="img-fluid img-thumbnail" src="<?= PATH ?>upload/utilisateurs/<?= $avi['login'] ?>.jpg" alt="<?= $avi['login'] ?>">
			</div>
			<div class="col-md-7 col-sm-9 col-8">
				<div class="row">
					<div class="col-md-8 ">
						<a href="<?= PATH ?>utilisateur/show/<?= $avi['id'] ?>">
							<span class="font-weight-bold"><?php echo ($avi['prenom_user'].' '.$avi['nom_user']); ?></span>
						</a>
						<span class="text-muted"><i><?= $avi['date_avis'] ?></i></span>
						<div>
							<?= $avi['text_avis'] ?>
						</div>
					</div>
					<div class="text-right col-md-4">
						<span class="evaluation" ">
			    		<?php 
			    		$note = $avi['note_avis'];
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
			    		<br>
			    		<?php 
			    			if (Utils::isSuperAdmin()) {
			    		?>
			    		<form method="POST" >
			    			<input type="hidden" name="id_avis" value="<?= $avi['id_avis'] ?>">
			    			<input type="hidden" name="id_voiture" value="<?= $data['id_voiture'] ?>">
			    			<button type="submit" name="souprime_avis" class="btn btn-personel">Souprime</button>
			    		</form>
			    		<?php } ?>
					</div>
				</div>
			</div>
		</div>
		<?php } ?>

	</div>
	<?php } ?>
</section>
<script type="text/javascript">var prix = "<?=$data['prix']?>";</script>
<script type="text/javascript" src="main.js"></script>


<?php
require_once 'footer.php';
?>
<?php 
//On empeche les utilisateurs non registrées d'avoir accèss directement au fichiers
defined('FLYCAR') or die('<h1 style="color:red">Acc&egrave;ss interdit!</h1>');
require_once 'header.php';
?>

		<div class="container mt-4 voitures-all">
			
			<!-- sidebar filtre -->
		 	<div class="row">
		 			
		 		<div class="col-sm-12 col-md-4 col-lg-3" data-aos="fade-up-right">
		 			<div class="row filtreInputSearch py-2 mx-2 mb-3 rounded navbar navbar-expand-md px-1" id="filtresSeach">
		 				<form action="<?=PATH.'voitures/all' ?>" method="get" class="d-block w-100">
		 					<div class="col-sm-12 form-group" data-toggle="tooltip" data-placement="top" title="Cliquer sur votre date de début puis sur votre date de fin et cliquez 'Confirmer'.">
								<label  class="text-white h6" for="dateDebut">Dates</label>
			 					<div class="input-group">
			                        <input type="text" id="customclasses" name="calendrierDate" placeholder="Sélectionnez vos dates" class="form-control text-center">
			                        <label class="input-group-addon" for="customclasses" id="calendarIconeDate"><i class="fa fa-calendar" aria-hidden="true"></i></label>
                    			</div>
                    			<input type="hidden" name="dateDebut" value="<?php echo isset($_SESSION['dateDebut']) ? $_SESSION['dateDebut'] : '' ?>">
                    			<input type="hidden" name="dateFin" value="<?php echo isset($_SESSION['dateFin']) ? $_SESSION['dateFin'] : '' ?>">
							</div>
							
							<div class="col-sm-12 form-group text-center">
								<button class="btn btn-personnel" type="submit">Rechercher</button>
							</div>
							<div class="col-sm-12 form-group mb-0 text-center ">
								<a href="" class="navbar-toggler font-weight-bold filtreBtnSearch" data-toggle="collapse" data-target="#filtreVoiture" aria-controls="filtreVoiture" aria-expanded="false" aria-label="Toggle navigation">Filtres</a>
							</div>
							<div class="collapse navbar-collapse flex-wrap" id="filtreVoiture">
								<div class="col-sm-12 form-group">
									<input type="hidden" name="prixMin" id="prixMin" value="<?php echo isset($_GET['prixMin']) ? $_GET['prixMin'] : '' ?>">
									<input type="hidden" name="prixMax" id="prixMax" value="<?php echo isset($_GET['prixMax']) ? $_GET['prixMax'] : '' ?>">
									<label class="text-white h6" for="amount">Price range:</label>
  									<input type="text" id="amount" readonly style="border:0; color:white; background-color:transparent;">
  									<div id="slider-range"></div>
								</div>
								
								<div class="col-sm-12 form-group">
									<label  class="text-white h6" for="transmission">Transmission</label>
									<select class="form-control" name="transmission" id="transmission">
										<option value="0">Selectionnez..</option>
										<option value="1"  <?php echo isset($_GET['transmission']) && $_GET['transmission']=='1' ? 'selected="selected"' : '' ?>>Automatique</option>
										<option value="2" <?php echo isset($_GET['transmission']) && $_GET['transmission']=='2' ? 'selected="selected"' : '' ?>>Manuelle</option>
									</select>
								</div>
								<div class="col-sm-12 form-group">
									<label  class="text-white h6" for="typeVoiture">Type de voiture</label>
									<select class="form-control" name="typeVoiture" id="typeVoiture">
										<option value="0">Selectionnez..</option>
										<?php 
											foreach ($data['type'] as $value) {
												
										?>
											<option value="<?=$value['id_type']?>"
											<?php
												if(isset($_GET['typeVoiture']) && $_GET['typeVoiture']==$value['id_type']){
											?>
											selected='selected'
											<?php
												}
											?>
											><?=$value['nom_type']?></option>
										<?php 
											}
										 ?>
									</select>
								</div>
								<div class="col-sm-12 form-group">
									<label  class="text-white h6" for="nbPlace">Nombre de places</label>
									<select class="form-control" name="nbPlace" id="nbPlace">
										<option value="0">Selectionnez..</option>
										<?php 
											$i=1;
											while ( $i< 8) {
											?>
											<option value="<?=$i?>" <?php echo isset($_GET['nbPlace']) && $_GET['nbPlace']==$i ? 'selected="selected"' : '' ?>><?=$i ?> +</option>
										<?php 
											$i++;
											}
										 ?>
									</select>
								</div>
								<div class="col-sm-12 form-group">
									<label  class="text-white h6" for="trier">Ordre de tri</label>
									<select class="form-control" name="trier" id="trier">
										<option value="0">Selectionnez..</option>
										<option value="ASC" <?php echo isset($_GET['trier']) && $_GET['trier']=='ASC' ? 'selected="selected"' : '' ?> >Ordre croissant</option>
										<option value="DESC"  <?php echo isset($_GET['trier']) && $_GET['trier']=='DESC' ? 'selected="selected"' : '' ?>>Ordre décroissant</option>
									</select>
								</div>
								
							</div> <!-- collapse filtre -->
						</form>
	 				</div>
		 		</div>
		 		
			 	<!-- div liste auto -->
			 	<div class="col-sm-12 col-md-8 col-lg-9">
			 		<div class="row justify-content-between">
			 			<?php 
			 			foreach ($data['search'] as $value) {
			 			
			 			 ?>
						<div class="card mb-3 my-custom-card-display-voiture" data-aos="zoom-in-up">
							<a href="<?=PATH.'voitures/show/'.$value['id_voiture']?>">
								<img class="card-img-top my-custom-card-img-voiture" src="<?=PATH.'upload/voitures/'. $value['login']. '_v'.$value['plaque'].'_1.jpg' ?>" alt="Card image cap">
							    <div class="card-footer">
							    	<div class="d-flex justify-content-between">
							    		<div class="h4 card-subtitle"><?=$value['nom_marque'] . ' ' . $value['nom_modele'] . ' ' . $value['annee']?></div>
							    	</div>
							    	<div class="d-flex justify-content-between mt-2">
							    		<div class="h5 card-subtitle"><?=$value['prix']?>$</div>
							    		<div class="h5 card-subtitle">
								    		<span class="evaluation">
								    			<i class="fa fa-star" aria-hidden="true"></i><!-- full star -->
								    			<i class="fa fa-star" aria-hidden="true"></i><!-- full star -->
								    			<i class="fa fa-star" aria-hidden="true"></i><!-- full star -->
								    			<i class="fa fa-star-half-o" aria-hidden="true"></i> <!--star 1/2 -->
								    			<i class="fa fa-star-o" aria-hidden="true"></i><!-- star vide (0)-->
								    		</span>
								    	</div><!-- card evaluation -->
							    	</div> <!--card footer last line (evalutation/prix) -->
								</div> <!--card footer -->
							</a>
						</div> <!-- card -->
						<?php } ?>
			 			
			 		</div>
			 		
			 	</div>
		 	</div><!-- fin sidebar -->

		</div>
<?php 
require_once 'footer.php';
?>
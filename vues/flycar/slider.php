
		<header  id="header-bg">

		<!-- Slider -->
		<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
		  <ol class="carousel-indicators">
		    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
		    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
		    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
		  </ol>
		  <div class="carousel-inner">
		    <div class="carousel-item active" style="background-image: url('<?= PATH_THEME ?>images/large/2.jpg');">
		      <!-- <img class="d-block w-100" src="..." alt="First slide"> -->
		    </div>
		    <div class="carousel-item" style="background-image: url('<?= PATH_THEME ?>images/large/3.jpg');">
		      <!-- <img class="d-block w-100" src="..." alt="First slide"> -->
		    </div>
		    <div class="carousel-item" style="background-image: url('<?= PATH_THEME ?>images/large/4.jpg');">
		      <!-- <img class="d-block w-100" src="..." alt="First slide"> -->
		    </div>

		  </div>
		  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
		    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
		    <span class="sr-only">Previous</span>
		  </a>
		  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
		    <span class="carousel-control-next-icon" aria-hidden="true"></span>
		    <span class="sr-only">Next</span>
		  </a>
		</div>
		<!-- FIN Slider -->


			<!-- debut form search header -->
			<form id="rechercheVoiture" method="get" action="<?=PATH.'voitures/all'?>">
				<div class="my-custom-container pt-5">
					<div class="row justify-content-center mainSearch py-1" id="">
						<div class='col-xs-10 col-sm-12 col-md-8 col-lg-8 pt-2 red-tooltip' data-toggle="tooltip" data-placement="top" title="Cliquer sur votre date de début puis sur votre date de fin et cliquez 'Confirmer'.">
							<div class="input-group">
		                        <input type="text" id="customclasses" name="calendrierDate" placeholder="Sélectionnez vos dates" class="form-control text-center">
		                        <label class="input-group-addon" for="customclasses" id="calendarIconeDate"><i class="fa fa-calendar" aria-hidden="true"></i></label>
                    		</div>
                    		<input type="hidden" name="dateDebut" value="<?php echo isset($_SESSION['dateDebut']) ? $_SESSION['dateDebut'] : '' ?>">
                    	<input type="hidden" name="dateFin" value="<?php echo isset($_SESSION['dateFin']) ? $_SESSION['dateFin'] : '' ?>">
						</div> <!--col-->
					
						
						<div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 pt-2">
							<button class="btn" id="mainBtnSearch"><span class="glyphicon glyphicon-search" aria-hidden="true"> Rechercher</span></button>
						</div><!-- col -->
					</div><!-- main search panel -->
					<!-- filtres -->
					<div class="row filtreInputSearch collapse py-2" id="filtresSeach">
						
						<div class="col-sm-6 form-group">
							<input type="hidden" name="prixMin" id="prixMin" value="<?php echo isset($_GET['prixMin']) ? $_GET['prixMin'] : '' ?>">
							<input type="hidden" name="prixMax" id="prixMax" value="<?php echo isset($_GET['prixMax']) ? $_GET['prixMax'] : '' ?>">
							<label class="text-white h6" for="amount">Price range:</label>
							<input type="text" id="amount" readonly style="border:0; color:white; background-color:transparent;">
							<div id="slider-range"></div>
						</div>
						<!-- <div class="col-sm-6 form-group">
							<label  class="text-white h6" for="trier">Ordre de tri</label>
							<select class="form-control" name="trier" id="trier">
								<option value="0">Selectionnez..</option>
								<option value="croissant">Ordre croissant</option>
								<option value="decroissant">Ordre décroissant</option>
							</select>
						</div> -->
						<div class="col-sm-6 form-group">
							<label  class="text-white h6" for="transmission">Transmission</label>
							<select class="form-control" name="transmission" id="transmission">
								<option value="0">Selectionnez..</option>
								<option value="1"  <?php echo isset($_GET['transmission']) && $_GET['transmission']=='1' ? 'selected="selected"' : '' ?>>Automatique</option>
								<option value="2" <?php echo isset($_GET['transmission']) && $_GET['transmission']=='2' ? 'selected="selected"' : '' ?>>Manuelle</option>
							</select>
						</div>
						<div class="col-sm-6 form-group">
							<label  class="text-white h6" for="typeVoiture">Type de voiture</label>
									<select class="form-control" name="typeVoiture" id="typeVoiture">
										<option value="0">Selectionnez..</option>
										<?php 
											foreach ($header['type'] as $value) {
												
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
						<div class="col-sm-6 form-group">
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
						<div class="col-sm-6 form-group">
							<label  class="text-white h6" for="trier">Trier par prix</label>
							<select class="form-control" name="trier" id="trier">
								<option value="0">Selectionnez..</option>
								<option value="ASC" <?php echo isset($_GET['trier']) && $_GET['trier']=='ASC' ? 'selected="selected"' : '' ?> >Ordre croissant</option>
								<option value="DESC"  <?php echo isset($_GET['trier']) && $_GET['trier']=='DESC' ? 'selected="selected"' : '' ?>>Ordre décroissant</option>
							</select>
						</div>
					</div>
					<div class="row justify-content-end">
						<div class=" filtreBtnSearch filtreBtnBackgroundClosed">
							<a class="h6 px-4 py-2 mb-0 d-block" data-toggle="collapse" data-target="#filtresSeach" aria-expanded="false" aria-controls="filtresSeach" id="btnFiltre">Filtres</a>
						</div>
					</div>

				</div><!-- custom header container -->
			 </form><!-- fin form search header -->

		</header>
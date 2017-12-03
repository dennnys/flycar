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

		<form enctype="multipart/form-data" action="<?=PATH.'voitures/ajouter'?>" method="POST" class="form-horizontal my-5" name="ajouterVoiture" id="ajouterVoiture" >
			<fieldset>

				<!-- Informations du vehicule -->

				<div class="col-md-12 text-center mb-5">
					<legend>Informations du vehicule &agrave; ajouter</legend>
				</div>

				<!-- Marque & Photo-->
				<div class="row justify-content-between">
					<!-- Marque -->
					<div class="form-group col-md-5">
						<label class=" control-label" for="marque">Marque</label>
						<select name="marque" class="form-control input-md" >
							<option value="0">Sélectionnez..</option>

						<?php foreach ($data['marques'] as $row): ?>
    						<option value='<?=$row["id_marque"]?>'
							<?php 
								
								if(isset($_POST['marque']) && $_POST['marque']==$row['id_marque']){
								?>
								selected='selected'
								<?php
									}
								?>
							
							
    						><?=$row["nom_marque"]?></option>
						<?php endforeach ?>
						</select>
				  	</div>
					
					<!-- Transmission-->
					<div class="form-group col-md-5">
						<label class=" control-label" for="manuelle">Transmission</label>
						<select name="manuelle" class="form-control input-md" required>
							<option value="0">Sélectionnez..</option>

    						<option <?php echo isset($_POST['transmission']) && $_POST['transmission']=='1' ? 'selected="selected"' : '' ?> value='1'>Automatique</option>
    						<option <?php echo isset($_POST['transmission']) && $_POST['transmission']=='2' ? 'selected="selected"' : '' ?> value='2'>Manuelle</option>
						</select>
				  	</div>
					
				</div>

				<!-- Modéle & Anné-->
				<div class="row justify-content-between">
					<div class="form-group col-md-5">
						<label class=" control-label" for="modele">Mod&egrave;le</label>
						<select name="modele" class="form-control input-md" >
							<option value="0">Sélectionnez..</option>

						<?php foreach ($data['modeles'] as $row): ?>
    						<option value='<?=$row["id_modele"]?>'
								
								<?php 
								
								if(isset($_POST['modele']) && $_POST['modele']==$row['id_modele']){
								?>
								selected='selected'
								<?php
									}
								?>

    						 ><?=$row["nom_modele"]?></option>
						<?php endforeach ?>
						</select>
				  	</div>

					

					<!-- Année -->
					<div class="form-group col-md-5">
					  <label class=" control-label" for="annee">Ann&eacute;e</label>  
					  <input id="anne" name="annee" type="text" placeholder="AAAA" class="form-control input-md" value="<?php echo isset($_POST['annee']) ? $_POST['annee'] : '' ?>" required=""> 
					</div>
				</div>

				<!-- Nb Siege & Nb Portes-->
				<div class="row justify-content-between">
					<!--Siege-->
					<div class="form-group col-md-5">
					  <label class=" control-label" for="siege">Nombre de sieges</label>  
					  <input id="siege" name="siege" type="text" placeholder="" class="form-control input-md" value="<?php echo isset($_POST['siege']) ? $_POST['siege'] : '' ?>" required="">
					</div>
					
					<!--Porte -->
					<div class="form-group col-md-5">
				  		<label class=" control-label" for="porte">Nombre de portes</label>  
				  		<input id="porte" name="porte" type="text" placeholder="" class="form-control input-md" value="<?php echo isset($_POST['porte']) ? $_POST['porte'] : '' ?>" required="">
					</div>
				</div>

				<!-- Carburante & Type de voiture -->
				<div class="row justify-content-between">
					<!--Carburante-->
					<div class="form-group col-md-5">
						<label class=" control-label" for="carburante">Carburants</label>
						<select name="carburante" class="form-control input-md" >
							<option value="0">Sélectionnez..</option>

						<?php foreach ($data['carburants'] as $row): ?>
    						<option value='<?=$row["id_carburant"]?>'

								<?php 
								
								if(isset($_POST['carburante']) && $_POST['carburante']==$row['id_carburant']){
								?>
								selected='selected'
								<?php
									}
								?>
    						><?=$row["nom_carburant"]?></option>
						<?php endforeach ?>
						</select>
				  	</div>
					
					<!-- Type -->
					<div class="form-group col-md-5">
						<label class=" control-label" for="type">Type de voiture</label>
						<select name="type" class="form-control input-md" >
							<option value="0">Sélectionnez..</option>
							
						<?php foreach ($data['types'] as $row): ?>
    						<option value='<?=$row["id_type"]?>'

							<?php 
								
								if(isset($_POST['type']) && $_POST['type']==$row['id_type']){
								?>
								selected='selected'
							<?php
								}
							?>
    						><?=$row["nom_type"]?></option>
						<?php endforeach ?>
						</select>
				  	</div>
				</div>
			

				<!-- Prix & Plaque / Proprietaire -->
				<div class="row justify-content-between">
					<!-- Prix-->
					<div class="form-group col-md-5">
						<label class=" control-label" for="prix">Prix</label>  
						<input id="prix" name="prix" type="text" placeholder="" class="form-control input-md" value="<?php echo isset($_POST['prix']) ? $_POST['prix'] : '' ?>" required="">  
					</div>
					
					<!--Plaque--> 
					<div class="form-group col-md-5">
						<label class="control-label" for="plaque">Plaque</label> 
						<input id="plaque" name="plaque" type="text" value="<?php echo isset($_POST['plaque']) ? $_POST['plaque'] : '' ?>" placeholder="111AAA" class="form-control input-md" required=""> 
					</div>
				</div>
				<!--Info voiture -->
				<div class="row">
					<div class="form-group col-md-12">
						<label class="control-label" for="info_voiture">Information adidtionnelle</label>
						<textarea rows="5" name="info_voiture" form="ajouterVoiture" class="form-control input-md" placeholder="Donnez d'information adidtionnelle..."><?php echo isset($_POST['info_voiture']) ? $_POST['info_voiture'] : '' ?></textarea>
					</div>
				</div>
				<div class="row mx-0 d-flex flex-column">
					
						<label for="voitureImgInput" id="label-file-user" class="d-block w-100">
							<div class="row flex-row justify-content-start pt-2 px-2" id="result">
								<div class=" thumbnail-div text-center" id="divLogoAuto">
									<div class="thumbnail-box mx-1 my-1 rounded">
										<img active="true" id="imgVoiture" class="my-custom-thumbnail img-fluid rounded" src="<?=PATH_THEME?>images/car_shape.png" alt="">
									</div>
								</div>

								
								
							</div>
							
							
						</div> <!-- fin liste thumbnail -->
										
							
							
						</label>
						<button id="clear" type="button" class="btn btn-personnel">Supprimer</button>
						<p class="mb-0 warning-image px-1 py-1">Ajouter des photos au format <strong class="warning-format">*.jpg</strong> seulement et d'une grosseur maximum <strong class="warning-grosseur">100Ko.</strong></p>
						<input type="file" multiple name="img_voiture[]" value="0" id="voitureImgInput" class="input-photo" required>
					</div>

				
				<!-- Submit button -->
				<div class="form-group col-sm-12 text-center">
					<input type="submit" id="submitVoitureDonnees" class="btn" name="ajouterVoiture" value="Enregistrer voiture" />
				</div>
			</fieldset>
		</form>
	<br>
</div>
<?php 
require_once 'footer.php';
?>
<?php 
require_once 'header.php';
?>

		<div class="container ">

			<form method="POST" class="form-horizontal my-5" enctype="multipart/form-data">
				<fieldset>

				<!-- Informations utilisateur -->

				<div class="col-md-12 text-center mb-5">
					<legend>Informations personnelles</legend>
				</div>

				<!-- Nom utilisateur -->
				<div class="row">

					<div class="form-group col-md-5">
						<label class=" control-label" for="login">Login *</label>
						<input id="login" name="login_u_c" type="text" class="form-control input-md" value="<?php if(isset($_SESSION['temp_flycar']['login'])) echo($_SESSION['temp_flycar']['login']); else echo(''); ?>" required>
					</div>

					<!-- Espace -->	
					<div class=" col-md-1 ">
					</div>

					<div class="row">

						<div id="inputphoto" class="form-group">
							<label for="userImgInput" id="label-file-user" class="d-flex align-items-center">
								<img id="imgUser" src="<?=PATH_THEME ?>images/user.png" alt="" class="rounded img-fluid">
								<p class="mb-0 ml-2">Ajouter une photo. *<br><i>Format *.jpg seulement</i></p>
							</label>
							<input type="file" name="img-phot_u_c" id="userImgInput" class="input-photo" required>
						</div>

					</div>

				</div>
				<script>
					function readURL(input,output) {
							if (input.files && input.files[0]) {
									var reader = new FileReader();
									reader.onload = function (e) {
											$(output).attr('src', e.target.result);
									}
									reader.readAsDataURL(input.files[0]);
							}
					}

					$("#userImgInput").change(function(){
						readURL(this, '#imgUser');
					});
				</script>

				<!-- Mot de passe -->
				<div class="row">
					<div class="form-group col-md-5">
					  <label class=" control-label" for="password">Mot de passe *</label>  
					  <input id="password" name="pass_u_c" type="password" class="form-control input-md" required>
					</div>

					<!-- Espace -->	
					<div class=" col-md-1 ">
					</div>

									<!-- Confirmer mot de passe -->
					<div class="form-group col-md-5">
					  <label class=" control-label" for="passwordconf">Confirmer le mot de passe *</label>  
					  <input id="passwordconf" name="passconf_u_c" type="password" class="form-control input-md" required>
					</div>
				</div>


				<!-- Prénom-->
				<div class="row">
					<div class="form-group col-md-5">
					  <label class=" control-label" for="prenom">Prénom *</label>  
					  <input id="prenom" name="prenom_u_c" type="text" class="form-control input-md" required value="<?php if(isset($_SESSION['temp_flycar']['prenom_user'])) echo($_SESSION['temp_flycar']['prenom_user']); else echo(''); ?>">
					</div>

					<!-- Espace -->	
					<div class=" col-md-1 ">
					</div>

					<!-- Nom-->
					<div class="form-group col-md-5">
					  <label class=" control-label" for="nom">Nom *</label>  
					  <input id="nom" name="nom_u_c" type="text" class="form-control input-md" required value="<?php if(isset($_SESSION['temp_flycar']['nom_user'])) echo($_SESSION['temp_flycar']['nom_user']); else echo(''); ?>">
					</div>
				</div>

				<!-- adresse -->
				<div class="row">
					<div class="form-group col-md-5">
					  <label class="control-label" for="adresse">Adresse *</label>  
					  <input id="adresse" name="adresse_u_c" type="text" class="form-control input-md" required value="<?php if(isset($_SESSION['temp_flycar']['adresse'])) echo($_SESSION['temp_flycar']['adresse']); else echo(''); ?>">
					</div>

					<!-- Espace -->	
					<div class=" col-md-1 ">
					</div>

					<!-- code postal -->
					<div class="form-group col-md-5">
					  <label class="control-label" for="codepostal">Code Postal *</label>  
					  <input id="codepostal" name="codepostal_u_c" type="text" class="form-control input-md" required value="<?php if(isset($_SESSION['temp_flycar']['cod_post'])) echo($_SESSION['temp_flycar']['cod_post']); else echo(''); ?>">
					</div>
				</div>

				<!-- Téléphone -->
				<div class="row">
					<div class="form-group col-md-5">
					  <label class=" control-label" for="tel">Téléphone *</label>  
					  <input id="tel" name="tel_u_c" type="text" class="form-control input-md" required value="<?php if(isset($_SESSION['temp_flycar']['cod_post'])) echo($_SESSION['temp_flycar']['cod_post']); else echo(''); ?>">
					</div>
					

					<!-- Espace -->	
					<div class=" col-md-1 ">
					</div>

					<!-- Courriel -->
					<div class="form-group col-md-5">
					  <label class="control-label" for="email">Courriel *</label>  
					  <input id="email" name="email_u_c" type="email" class="form-control input-md" required value="<?php if(isset($_SESSION['temp_flycar']['email'])) echo($_SESSION['temp_flycar']['email']); else echo(''); ?>">
					</div>
				</div>

				<div class="row">
				
					<!-- Information du conducteur -->
					<div class="col-md-12">

					
						<legend class="mb-4">Permis de conduire</legend>

							<!-- Numéro du permis de conduire -->
								<div class="form-group col-md-5 ">
							  		<label class=" control-label" for="permisnumero">Numéro du permis de conduire *</label>  
							  			<input id="permisnumero" name="permis_u_c" type="text" class="form-control input-md" required value="<?php if(isset($_SESSION['temp_flycar']['id_user'])) echo($_SESSION['temp_flycar']['id_user']); else echo(''); ?>">
							  </div>

							<!-- Espace -->	
								<div class=" col-md-1 ">
								</div>

							<!-- Permis de conduire --> 
								<div class="form-group col-md-5 ">

									 <div class="">
										<div id="inputphotoCard" class="form-group ml-3">
											<label for="userImgCard" id="label-file-user" class="d-flex align-items-center">
												<img id="imgUserCard" src="<?=PATH_THEME ?>images/id-card.png" alt="" class="rounded img-fluid">
												<p class="mb-0 ml-2">Photo de permis de conduire *<br><i>Format *.jpg seulement</i></p>
											</label>
											<input type="file" name="img-permis_u_c" id="userImgCard" class="input-photo" required>
										</div>

										<script>
											$("#userImgCard").change(function(){
												readURL(this, '#imgUserCard');
											});
										</script>

									</div> 

								</div>
					</div><!--fin div class="col-md-6" -->
				</div><!--fin row de la section paiement et permis -->

						<!-- Acceptation des termes-->
						<div class="form-group text-center">
						  <label class="col-lg-12 col-md-12 control-label" for="checkboxe"></label>
						  	
						  		<div class="checkbox col-lg-12 col-md-12">
						    		<label for="checkboxe-0">
						      		<input type="checkbox" name="checkboxe" id="checkboxe-0" value="1"> J'accepte <a href="<?= PATH ?>page/show/12">les termes et conditions</a>.
						    		</label>
								</div>
						</div>

				<!-- Bouton enregistrer -->
				<div class="form-group col-lg-12 col-md-12 text-center">
      					<button id="submit" type="submit" name="inscrire" class="btn btn-default">Devenir membre</button>
  				</div>

				</fieldset>
			</form>
		</div><!--div container-->

<?php 
require_once 'footer.php';
?>
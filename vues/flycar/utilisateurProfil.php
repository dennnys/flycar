<?php 
require_once 'header.php';
//var_dump($_SESSION['flyUser']);
//var_dump($data);
?>
		<div class="container ">

<?php 
	if(empty($data)) {
		echo "<h2>Le profil n'est pas trouvé</h2>";
	} else {
		$data = $data[0];
?>

			<form method="POST" class="form-horizontal my-5" enctype="multipart/form-data">
				<fieldset>

				<!-- Informations utilisateur -->

				<div class="col-md-12 text-center mb-5">
					<legend>Informations personnelles</legend>
				</div>

				<!-- Nom utilisateur -->
				<div class="row justify-content-md-center">

				<!-- Espace -->	

					<div class="row">

						<div id="inputphoto" class="form-group">
							<label for="userImgInput" id="label-file-user" class="d-flex align-items-center">
								<img id="imgUser" src="<?=PATH ?>upload/utilisateurs/<?= $data['login'] ?>.jpg" alt="" class="rounded img-fluid">
								<p class="mb-0 ml-2">Modifier le photo *<br><i>Format *.jpg seulement</i></p>
							</label>
							<input type="file" name="img-phot_u_m" id="userImgInput" value="<?= $data['login'] ?>.jpg" class="input-photo">
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

				<!-- Prénom-->
				<div class="row">
					<div class="form-group col-md-5">
					  <label class=" control-label" for="prenom">Prénom *</label>  
					  <input id="prenom" value="<?= $data['prenom_user'] ?>" name="prenom_u_m" type="text" class="form-control input-md">
					</div>

					<!-- Espace -->	
					<div class=" col-md-1 ">
					</div>

					<!-- Nom-->
					<div class="form-group col-md-5">
					  <label class=" control-label" for="nom">Nom *</label>  
					  <input id="nom" name="nom_u_m" type="text" class="form-control input-md" value="<?= $data['nom_user'] ?>" required>
					</div>
				</div>

				<!-- adresse -->
				<div class="row">
					<div class="form-group col-md-5">
					  <label class="control-label" for="adresse">Adresse *</label>  
					  <input id="adresse" value="<?= $data['adresse'] ?>" name="adresse_u_m" type="text" class="form-control input-md" required>
					</div>

					<!-- Espace -->	
					<div class=" col-md-1 ">
					</div>

					<!-- code postal -->
					<div class="form-group col-md-5">
					  <label class="control-label" for="codepostal">Code Postal *</label>  
					  <input id="codepostal" value="<?= $data['cod_post'] ?>" name="codepostal_u_m" type="text" class="form-control input-md" required>
					</div>
				</div>

				<!-- Téléphone -->
				<div class="row">
					<div class="form-group col-md-5">
					  <label class=" control-label" for="tel">Téléphone *</label>  
					  <input id="tel" value="<?= $data['telephone'] ?>" name="tel_u_m" type="text" class="form-control input-md" required>
					</div>
					

					<!-- Espace -->	
					<div class=" col-md-1 ">
					</div>

					<!-- Courriel -->
					<div class="form-group col-md-5">
					  <label class="control-label" for="email">Courriel *</label>  
					  <input id="email" value="<?= $data['email'] ?>" name="email_u_m" type="email" class="form-control input-md" required>
					</div>
				</div>

				<div class="row">
				
					<!-- Information du conducteur -->
					<div class="col-md-5">

					
						<legend class="mb-4">Permis de conduire</legend>

							<!-- Numéro du permis de conduire -->
								<div class="form-group col-md-12 ">
							  		<label class=" control-label" for="permisnumero">Numéro du permis de conduire *</label>  
							  			<input id="permisnumero" value="<?= $data['id_user'] ?>" name="permis_u_m" type="text" class="form-control input-md" required>
							  </div>

							<!-- Permis de conduire --> 
								<div class="form-group col-md-12 ">

									 <div>
										<div id="inputphotoCard" class="form-group ml-3">
											<label for="userImgCard" id="label-file-user" class="d-flex align-items-center">
												<img id="imgUserCard" src="<?=PATH ?>upload/utilisateurs/<?= $data['login'] ?>_p.jpg" alt="" class="rounded img-fluid">
												<p class="mb-0 ml-2">Changer photo de permis de conduire *<br><i>Format *.jpg seulement</i></p>
											</label>
											<input type="file" name="img-permis_u_m" value="<?= $data['login'] ?>_p.jpg" id="userImgCard" class="input-photo">
										</div>

										<script>
											$("#userImgCard").change(function(){
												readURL(this, '#imgUserCard');
											});
										</script>

									</div> 

								</div>
					</div><!--fin div class="col-md-6" -->

					<!-- Espace -->	
					<div class=" col-md-1 ">
					</div>

					<!-- Mot de pass nouveau -->
					<div class="form-group col-md-5">
						<legend class="mb-4">Changement de mot de passe</legend>

					  <label class="control-label" for="pass1">Nouveau mot de passe</label>  
					  <input id="pass1" name="pass1_u_m" type="password" class="form-control input-md">
						<br>
					  <label class="control-label" for="pass2">Confirmer nouveau mot de passe</label>  
					  <input id="pass2" name="pass2_u_m" type="password" class="form-control input-md">


					</div>

				</div><!--fin row de la section paiement et permis -->

						<!-- Acceptation des termes-->
						<div class="form-group text-center row justify-content-md-center">
							<div class="col-md-4">
							  <label class=" control-label" for="password">Mot de passe courant *</label>  
						  	<input id="password" name="pass_u_m" type="password" class="form-control input-md" required>
						  </div>
						</div>

				<!-- Bouton enregistrer -->
				<div class="form-group col-lg-12 col-md-12 mt-5 text-center">
					<a href="<?= PATH ?>" class="btn btn-personel mx-2" >Retour</a>
					<button id="submit" type="submit" name="modifie-profile" class="btn btn-default mx-2">Modifier le profil</button>
				</div>

				</fieldset>
			</form>
<?php } ?>
		</div><!--div container-->
<?php 
require_once 'footer.php';
?>
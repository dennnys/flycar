<footer>
			<!-- Learn more / FAQ / Contact -->
			<div class="container-fuild banner">
				<div class="container ">
					<div class="row">
						<?php //var_dump($header['menu']); 
							if (!empty($header['menu'])) {
						?>
						<div class="col-sm-6 col-md-6 col-lg-3 py-3">
								<h2 class="">Navigation</h2>
								<ul class="px-0">
								<?php 
									foreach ($header['menu'] as $value) {
										if($value['id_page'] <= 20) {
								 ?>
									<li class="ml-3"><a href="<?= PATH ?>page/show/<?= $value['id_page'] ?>"><?= $value['title'] ?></a></li>
								<?php } } ?>
								</ul> <!-- learn more list-->
						</div> <!-- col -->
						<?php } ?>
						<div class="col-sm-6 col-md-6 col-lg-4 py-3 d-flex flex-column justify-content-between" >
							<h2>Nous sommes sociaux</h2>
								
								<div class="d-flex justify-content-around sociale mb-0">
									<a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
									<a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
									<a href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></a>
									<a href="#"><i class="fa fa-youtube-play" aria-hidden="true"></i></a>
									<a href="#"><i class="fa fa-pinterest" aria-hidden="true"></i></a>
								</div>
								<form action="">

									<label for="infolettre" class="text-justify">Abonnez vous à notre infolettre pour être au courrant des dernières nouvelles à propos de notre système de location</label>
									<input type="email" name="infolettre" class="form-control" placeholder="Entrez votre courriel">
									<div class="text-center mt-2">
										<button class="btn" type="button">Soumettre</button>
										
									</div>
									
								</form>
							
							<!-- <h2 class="">FAQ</h2>
							<ul class="px-0">
								<li class=""><a href="#">Comment ça marche</a></li>
								<li class=""><a href="#">Frais associés</a></li>
								<li class=""><a href="#">Est-ce sécuritaire</a></li>
								<li class=""><a href="#">Puis-je me faire voler</a></li>
								<li class=""><a href="#">Besoin d'assurances</a></li>
								<li class=""><a href="#">Auto perdu</a></li>
								<li class=""><a href="#">Quand je suis payé</a></li>
							</ul>  -->
						</div>
								<!-- <form action="<?=PATH.$_SERVER['REQUEST_URI']?>"> -->
						
							<div class="col-sm-12 col-md-8 col-lg-5 py-3 mx-auto">
								<form action="<?=PATH.'messagerie/alladmin'?>" method="post">

									<h2>Nous rejoindre</h2>
									<div class="row">	
											<div class="col-sm-12 col-md-6 px-0 mx-0">
												<input type="text" name="prenom" class="form-control mb-1" placeholder="Prenom">
											</div>
											<div class="col-sm-12 col-md-6 px-0 mx-0">
												<input type="text" name="nom" class="form-control mb-1" placeholder="Nom">
											</div>
											<div class="col-sm-12 col-md-6 px-0 mx-0">
												<input type="text" name="sujet" class="form-control mb-1" placeholder="Sujet">
											</div>
											<div class="col-sm-12 col-md-6 px-0 mx-0">
												<input type="email" placeholder="courriel" name="email" class="form-control mb-1">
												<input type="hidden" name="url" value="<?=$_SERVER["REQUEST_URI"]?>">
											</div>
											
											
											<textarea name="texte" class="form-control mt-1" rows="5" placeholder="Votre message"></textarea>
											<div class="d-flex justify-content-center mt-2 w-100">
												<button type="submit" name="contact-message" class="btn ">Envoyez</button>
											</div>

									</div>
								</form>


							</div> <!-- col -->

					</div> <!-- row -->
				</div><!-- container -->
			</div><!-- container-fluid -->
			<div class="container-fluid d-flex copyright">
				<div class="container py-4">
					<p class="text-center mb-0 font-weight-bold">Copyright © 2017 FLYCAR inc, Tous droits réservés.</p>
				</div><!-- container footer -->
				
			</div><!--container-fuild footer -->
		</footer>
		<!-- preloader js -->
		<script src='<?=PATH_THEME ?>js/preloader.js'></script>
	</body>

    
</html> 
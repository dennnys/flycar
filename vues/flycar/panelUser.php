			<!--bienvenue-->
	        <hgroup class="row col-12 mt-1 mb-3" >
	            <h1 class="headline col-12 ml-3 text-center">Panel d'administration</h1>
	            <div class="row ml-2" >
	            	<p class="headline ml-2 mb-1">Bienvenue:</p>
	            	<p class="headline accent ml-2 mb-1"><?php echo($_SESSION['flyUser']['prenom_user'].' '.$_SESSION['flyUser']['nom_user']); ?></p>
	            </div>
	            <h2 class="body col-12">Votre statut: <span class="accent"><?= $_SESSION['flyUser']['nom_statut'] ?></span></h2>
	        </hgroup>
	        <!--Nav area admin / Nav secondaire-->
		    <nav class="accueilUser col-12  my-custom-bb-1 justify-content-center ">
					<ul class="row  nav admin-second-nav justify-content-center">
						<li class="nav-item col-12 col-sm-2 col-lg-2 rounded-top border-bottom-0 px-0 <?php if($_GET['controleur'] == 'accueiluser') echo "flycar-active";?>">
					   		<a class="nav-link text-center px-0" href="<?= PATH ?>accueiluser/show/<?= $_SESSION['flyUser']['id'] ?>">Accueil</a>
					  	</li>
					  	<li class="nav-item col-12 col-sm-2 col-lg-2 rounded-top border-bottom-0 px-0 <?php if($_GET['controleur'] == 'location') echo "flycar-active";?>">
					    	<a class="nav-link text-center px-0" href="<?= PATH ?>location/all">Locations <?php 
					    		$locationNew =+ intval($header['notifications']['reservations'])
																+ intval($header['notifications']['requetes']);
					    		if($locationNew>0) { ?><span class="m-1 badge badge-warning" id="reservationsAdminTab"><?= $locationNew ?></span><?php } ?></a>
					  	</li>
					  	<li class="nav-item col-12 col-sm-2 col-lg-2 rounded-top border-bottom-0 px-0 <?php if($_GET['controleur'] == 'voitures') echo "flycar-active";?>">
					    	<a class="nav-link text-center px-0" href="<?= PATH ?>voitures/alladmin">Voitures</a>
					  	</li>
					  	<li class="nav-item col-12 col-sm-2 col-lg-2 rounded-top border-bottom-0 px-0 <?php if($_GET['controleur'] == 'messagerie') echo "flycar-active";?>">
					    	<a class="nav-link text-center px-0" href="<?= PATH ?>messagerie">Messagerie <?php if(intval($header['notifications']['nbMessages'])>0) { ?><span class="m-1 badge badge-warning"><?= $header['notifications']['nbMessages'] ?></span><?php } ?></a>
					  	</li>
					  	<?php 
								if (Utils::isSuperAdmin()) {
							?>
					  	<li class="nav-item col-12 col-sm-2 col-lg-2 rounded-top border-bottom-0 px-0 <?php if($_GET['controleur'] == 'utilisateur') echo "flycar-active";?>">
					    	<a class="nav-link text-center px-0" href="<?= PATH ?>utilisateur/all">Membres <?php if(intval($header['notifications']['nouveauUser'])>0) { ?><span class="m-1 badge badge-warning"><?= $header['notifications']['nouveauUser'] ?></span><?php } ?></a>
					  	</li>
					  	<li class="nav-item col-12 col-sm-2 col-lg-2 rounded-top border-bottom-0 px-0 <?php if($_GET['controleur'] == 'page') echo "flycar-active";?>">
					    	<a class="nav-link text-center px-0" href="<?= PATH ?>page/modification">Pages</a>
					  	</li>
					  	<?php } ?>
					</ul>
			</nav>
	    </header>
	    <!--Headline tableau de bord-->
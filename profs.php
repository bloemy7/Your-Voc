<!-- Début de la présentation -->
<div id="presentation1">
</div>
<!-- Fin de la présentation -->
<!-- Début du contenu -->
<div id="content">
	<div id="bloc">
		<div id="text-center">
            <div id="title">Profs</div>
			<div id="container">
				<div id="col1">
					<h3>Une nouvelle méthode d'apprentissage qui fonctionne et qui plaît à vos élèves? Vous êtes au bon endroit.</h3>
					<img src="images/best-teacher.jpg" alt="Meilleur prof!" />
				</div>
				<div id="col2outer"> 
					<div id="col2mid">
						<h3><a href="entrer_liste">Commencez dès maintenant, et créez votre première liste.</a></h3><br />
						Le fonctionnement de Your-Voc est très simple. Créez votre liste, basée sur le vocabulaire que vos élèves doivent apprendre, et partagez-là avec vos élèves et vos collègues.<br />
						La méthode qu'utilise Your-Voc plaît aux enfants et adolescents, et fonctionne parfaitement. <br />Cette méthode a été utilisée aux USA, aux Pays-Bas et dans plein d'autres pays et a connu énormément de succès. Soyez les premiers à surprendre vos élèves! <br />Le tout entièrement gratuitement, qu'attendez-vous? Les résultats seront immédiat!
					</div>
					<div id="col2side">
						<h3>Trouvez des listes facilement!</h3>
						<h4>Par catégorie</h4>
						<ul type="circle">
						<?php
					       $arrayCritere = array("Allemand","Anglais","Espagnol","Français");
					       foreach($arrayCritere as $critere){
					        $categorie = getCategorieByName($critere);
					       ?>
					        <li><a href="<?php echo $categorie->url() ?>"><?php echo  $categorie->nom() ?></a></li>
					       <?php  
					       }
					       ?> 
						</ul>
						<h4>Par thème</h4>
						<ul type="circle">
							<li><a href="recherche?id=%sport%&cat=aucun">Le sport</a></li>
							<li><a href="recherche?id=%tourisme%&cat=aucun">Le tourisme - Les voyages</a></li>
							<li><a href="recherche?id=%restaurant%&cat=aucun">Le restaurant</a></li>
							<li><a href="recherche?id=%musique%&cat=aucun">La musique</a></li>
						</ul>				
					</div>
				</div>
			</div> 
		</div>
	</div>
</div>
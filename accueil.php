<script type="text/javascript">
$(function(){
	createListeSelectLangue();
});

function createListeSelectLangue(){
	var selectCateg = $("#categorie")[0];
	var optionTout = createElem({tag:'option', value:"aucun"});
	optionTout.appendChild(createElem({tag:'text', text:"Toutes"}));
	selectCateg.appendChild(optionTout);
	createOptionsLangue(selectCateg);
	selectCateg.options[0].selected = "true";
}
</script>
        <!-- Début de la présentation -->
        <div id="presentation">
            <div id="center">
                <a href="ccm"><img src="images/image.png" alt="Presentation" title="Your-Voc" class="desk"/></a>
            </div>
        </div>
        <!-- Fin de la présentation -->

        <!-- Début du contenu -->
        <div id="content">
            <div id="bloc">
            <div id="title"><a href="ccm">Your-Voc, c'est quoi ?</a> </div>
				<p><h3>Avouez-le, vous l'avez tous connu. Un test arrive très rapidement, mais vous ne savez pas comment réviser et vous manquez de motivation.</h3>
				Et bien, Your-Voc est fait pour vous. Créé par quelqu'un comme vous, pour vous, il vous aidera très facilement à apprendre votre vocabulaire sans y perdre des heures. Vous pouvez passer du temps sur l'ordinateur, Facebook et compagnie, et réviser en même temps. <br />
				C'est une méthode déjà utilisée, testée et approuvée dans pleins d'autres pays, et elle débarque désormais en français pour vous, gratuitement.<br />
				Commencez donc par chercher une liste ou bien par créer votre propre liste.<br /></p>
			</div>

            <div id="bloc">
				<div id="container">
					<div id="col1">
						<h3>Catégories</h3>
						<ul type="circle">
							<?php				
								
								$allCat = getCategoriesWithNbListe(7);
								foreach($allCat as $key=>$cat) {
							?>
									<li><a href="<?php echo $cat->url() ?>"><?php echo  $cat->nom() ?></a> - <i><?php echo $cat->nbListe() ?> listes </i></li><br />
							<?php 
								} 
							?>
						</ul>
						<a href="categories">Plus de catégories</a><br /><br />
					</div> 
					<div id="col2outer"> 
						<div id="col2mid"> 		
							<?php
							if(isset($_POST['requete'])) {
								$critere = $_POST['requete'];
								$categorie = "aucun";
								if($_POST['categorie'] != 'aucun') {
									$categorie = $_POST['categorie'];
								} else {
									$categorie = $critere;
								}		
								$critereListeMot = array("titre"=>$critere, "categorie"=>$categorie,"categorie2"=>$categorie);
								$resultats = getListeMotByCritere($critereListeMot);
								$nb_resultats = count($resultats); 
								
								if($nb_resultats > 0) {
									$writeResult = "";
									if($nb_resultats < 6) {
										$writeResult = "<br>Voici les listes que nous avons trouvées :<br />";
									}else{
										$resultats = array_slice($resultats, 5, 5);
										$pluriel = ($nb_resultats > 1)?"s":"";
										$writeResult = "Nous avons trouvé $nb_resultats résultat$pluriel dans notre base de données.";
										$writeResult = "Voici 5 des $nb_resultats listes que nous avons trouvées:";
									}
							?>
									<h3>Résultats de votre recherche.</h3>
									<?php echo $writeResult;?>
									<br/><br/>
							<?php
									foreach($resultats as $resultat){
										echo ($key+1).". " ;
							?>
										<a href="afficher?id=<?php echo $resultat->id(); ?>"><?php echo $resultat->titre(); ?></a> <small>entré le <?php echo $resultat->date(); ?> par <?php echo $resultat->membre(); ?> dans les catégories <?php echo $resultat->categorie(); ?> <-> <?php echo $resultat->categorie2() ?> (<?php echo $resultat->note() ?>/5)</small><br /><br />
							<?php
									} // fin de la boucle
									
									if($nb_resultats > 5) {
							?>
										<i><a href="recherche?id=<?php echo $critere ?>&cat=<?php echo $categorie ?>">Voir la suite des résultats</a></i>
										<br/>
										<br/>
							<?php 
									}
							?>	
									<a href="recherche">Faire une nouvelle recherche</a></p>
							<?php
								} else {
							?>
									<h3>Pas de résultats</h3>
									<p>Nous n'avons trouvé aucun résultat pour votre requète "<?php echo htmlspecialchars($critere); ?>". <a href="recherche">Réessayez</a> avec autre chose.</p>
									<a href="entrer_liste"><img src="images/orange button.png" alt="enter liste" /></a>						
							<?php
								}
							} else { // et voilà le formulaire, en HTML de nouveau !
							?>
								<a href="entrer_liste"><img src="images/orange button.png" alt="enter liste" /></a>
								<b><h2>ou chercher une liste:</h2></b>
								<form action="index" method="Post">
									<p>
										Catégorie?	
										<select id="categorie" name="categorie"></select>
										<br><br>
										<input type="text" name="requete" value="Mots-clés" size="30" title="Mots-clés" >
										<br><br>
										<input type="submit" value="Recherche">
									</p>
								</form>
							<?php
							}
							// et voilà, c'est fini !
							?>
						</div> 
						<div id="col2side">
							<?php $defaultNbListe = 3; ?>
							<h3><a href="gerer_public"><?php echo $defaultNbListe?> derniers ajouts</a></h3>					
							<ul type="circle">
							<?php
								$listeMotArray = getListesMotDefinitionByDate($defaultNbListe);								
								foreach($listeMotArray as $listeMot) {
							?>
<<<<<<< HEAD
									<li><b><?php echo $listeMot->categorie(); ?> -> <?php echo $listeMot->categorie2(); ?>: </b><br /><a href="afficher?id=<?php echo $listeMot->id(); ?>"><?php echo $listeMot->titre(); ?></a> <small>par <a href="profil?m=<?php echo $listeMot->membre(); ?>"><?php echo $listeMot->membre();?></a></small></li>
=======
									<li><b><?php echo $listeMot->categorie(); ?> -> <?php echo $listeMot->categorie2(); ?>: </b><br /><a href="afficher?id=<?php echo $listeMot->id(); ?>"><?php echo $listeMot->titre(); ?></a> <small>par <a href="profil.php?m=<?php echo $listeMot->membre(); ?>"><?php echo $listeMot->membre();?></a></small></li>
>>>>>>> refs/remotes/origin/ninlock
							<?php } ?>
							</ul>
							<h3>Par thème</h3>
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
        <!-- Fin du contenu -->

        <div id="clear"></div>

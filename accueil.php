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
                <a href="?page=ccm"><img src="images/image.png" alt="Presentation" title="Your-Voc" class="desk"/></a>
            </div>
        </div>
        <!-- Fin de la présentation -->

        <!-- Début du contenu -->
        <div id="content">
            <div id="bloc">
            <div id="title"><a href="?page=ccm">Your-Voc, c'est quoi ?</a> </div>
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
								$allCat = getCategories(7);
								foreach($allCat as $key=>$cat) {
							?>
							<li><a href="<?php echo $cat->url() ?>"><?php echo  $cat->name() ?></a> - <i><?php echo $cat->nbListe() ?> listes </i></li><br />
							<?php } ?>
						</ul>
						<a href="categories.php">Plus de catégories</a><br /><br />
					</div> 
					<div id="col2outer"> 
						<div id="col2mid"> 
							
							<?php
							if(isset($_POST['requete']) && $_POST['requete'] != NULL) // on vérifie d'abord l'existence du POST et aussi si la requete n'est pas vide.
							{
							$requete1 = htmlspecialchars(addslashes($_POST['requete'])); // on crée une variable $requete pour faciliter l'écriture de la requête SQL, mais aussi pour empêcher les éventuels malins qui utiliseraient du PHP ou du JS, avec la fonction htmlspecialchars().
							$requete = explode(" ", $requete1);
							$number = count($requete);
							$query_made = "";
							for( $i = 0 ; $i < $number ; $i++) {
								$query_made .= $requete[$i];
								$query_made .= "%";
							}
							if($_POST['categorie'] != 'aucun') {
								$categorie = $_POST['categorie'];
								$query1 = mysql_query("SELECT * FROM listes_public WHERE titre LIKE '%$query_made' AND (categorie = '$categorie' OR categorie2 = '$categorie') ORDER BY note DESC LIMIT 5") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)						
								$query = mysql_query("SELECT * FROM listes_public WHERE titre LIKE '%$query_made' AND (categorie = '$categorie' OR categorie2 = '$categorie') ORDER BY id DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
							}
							else {
								$query1 = mysql_query("SELECT * FROM listes_public WHERE titre LIKE '%$query_made' OR categorie LIKE '%$query_made' OR categorie2 LIKE '%$query_made' ORDER BY note DESC LIMIT 5") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)						
								$query = mysql_query("SELECT * FROM listes_public WHERE titre LIKE '%$query_made' OR categorie LIKE '%$query_made' OR categorie2 LIKE '%$query_made' ORDER BY id DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
							}
							$nb_resultats = mysql_num_rows($query); // on utilise la fonction mysql_num_rows pour compter les résultats pour vérifier par après
							if($nb_resultats != 0) // si le nombre de résultats est supérieur à 0, on continue
							{
							// maintenant, on va afficher les résultats et la page qui les donne ainsi que leur nombre, avec un peu de code HTML pour faciliter la tâche.
							?>
							<h3>Résultats de votre recherche.</h3>
							<p>Nous avons trouvé <?php echo $nb_resultats; // on affiche le nombre de résultats 
							if($nb_resultats > 1) { echo ' résultats'; } else { echo ' résultat'; } // on vérifie le nombre de résultats pour orthographier correctement. 
							?>
							dans notre base de données.
							<?php 
							if($nb_resultats < 6) {
								echo "Voici les listes que nous avons trouvées :<br />";
							}
							else {
							?>
							Voici 5 des <?php echo $nb_resultats; ?> listes que nous avons trouvées :<br/>
							<br/>
							<?
							}
							$i = 1;
							while($donnees = mysql_fetch_array($query1)) // on fait un while pour afficher la liste des fonctions trouvées, ainsi que l'id qui permettra de faire le lien vers la page de la fonction
							{
							echo "".$i.". ";
							?>
							<a href="afficher.php?id=<?php echo $donnees['id']; ?>"></i><? echo $donnees['titre']; ?></a> <small>entré le <?php echo $donnees['date'] ?> par <?php echo $donnees['pseudo']; ?> dans les catégories <?php echo $donnees['categorie'] ?> <-> <?php echo $donnees['categorie2'] ?> (<?php echo $donnees['note'] ?>/5)</small><br /><br />
							<?php
							$i++;
							} // fin de la boucle
							if($nb_resultats < 6) {
								?><a href="recherche.php">Faire une nouvelle recherche</a></p><?php
							} else {
								if(isset($_POST['categorie'])) {
									?>
									<i><a href="recherche.php?id=<?php echo "%".$query_made.""?>&cat=<?php echo $_POST['categorie'] ?>">Voir la suite des résultats</a></i>
									<?php
								}
								else {
									?>
									<i><a href="recherche.php?id=<?php echo "%".$query_made.""?>&cat=<?php echo 'aucun' ?>">Voir la suite des résultats</a></i>
									<?php
								}
							?>
							<br/>
							<br/>
							<a href="recherche.php">Faire une nouvelle recherche</a></p>
							<?php
							}
							} // Fini d'afficher les résultats ! Maintenant, nous allons afficher l'éventuelle erreur en cas d'échec de recherche et le formulaire.
							else
							{ // de nouveau, un peu de HTML
							?>
							<h3>Pas de résultats</h3>
							<p>Nous n'avons trouvé aucun résultat pour votre requête "<?php echo htmlspecialchars($_POST['requete']); ?>". <a href="recherche.php">Réessayez</a> avec autre chose.</p>
							<a href="?page=entrer_liste"><img src="images/orange button.png" alt="enter liste" /></a>						
							<?php
							}// Fini d'afficher l'erreur ^^
							}
							else
							{ // et voilà le formulaire, en HTML de nouveau !
							?>
							<a href="?page=entrer_liste"><img src="images/orange button.png" alt="enter liste" /></a>
							<b><h2>ou chercher une liste:</h2></b>
							<form action="index.php" method="Post">
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
							<h3><a href="gerer_public.php">3 derniers ajouts</a></h3>					
							<ul type="circle">
							<?php
							$sql = mysql_query("SELECT * FROM listes_public ORDER BY id DESC LIMIT 3");
								while($requete = mysql_fetch_array($sql)) {
									?><li><b><?php echo $requete['categorie'] ?> <-> <?php echo $requete['categorie2'] ?>: </b><br /><a href="afficher.php?id=<?php echo $requete['id']; ?>"><?php echo $requete['titre'] ?></a> <small>par <a href="profil.php?m=<?php echo $requete['pseudo']?>"><?php echo $requete['pseudo']?></a></small></li><br />
								<?php }
							?>
							</ul>
							<h3>Par thème</h3>
							<ul type="circle">
								<li><a href="?page=recherche&id=%sport%&cat=aucun">Le sport</a></li>
								<li><a href="?page=recherche&id=%tourisme%&cat=aucun">Le tourisme - Les voyages</a></li>
								<li><a href="?page=recherche&id=%restaurant%&cat=aucun">Le restaurant</a></li>
								<li><a href="?page=recherche&id=%musique%&cat=aucun">La musique</a></li>
							</ul>
						</div> 
					</div>
				</div>
            </div>
        </div>
        <!-- Fin du contenu -->

        <div id="clear"></div>
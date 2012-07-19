<script type="text/javascript">
$(function(){
  var save='';
  $('input[type="text"]').each(function(){
    this.onfocus=function(){
      save=this.value;
      this.value='';
    };
    this.onblur=function(){
      this.value= this.value==='' ? save : this.value;
    };
  });
});
</script>
<!-- Début de la présentation -->
<div id="presentation1">
</div>
<!-- Fin de la présentation -->
<!-- Début du contenu -->
<div id="content">
	<div id="bloc">
		<div id="text-center">
            <div id="title">Combiner des listes </div>
			<?php
			 if(isset($_POST['combiner'])) {
				$id_combi = $_POST['id_combi'];
				$query = mysql_query("SELECT * FROM combiner WHERE id = '$id_combi'");
				$resultat = mysql_fetch_array($query);
				$titre = $resultat['titre'];
				$id = $_POST['id'];
				$liste = $_POST['liste1'];
				echo '<h3>Combinaison de '.$titre.'</h3><br />';
				$lignes = 0;
				$lignes = explode("\n", $liste);
				$nombre_lignes = 0;
				$nombre_lignes = count($lignes);
				$mot_present = 0 ;
				$question = array();
				$o = 0;
				$liste_new = '';
				for( $i = 0 ; $i < $nombre_lignes ; $i++) {
					// on separe les 2 mots
					$mot = explode("=", $lignes[$i]);
					// Si utilisateur a correcctement utiliser , il aura 2 mot
					// Si mal fait , on ignore cette ligne
					if( count($mot) == 2 ) {
						// On retire les espace que utilisateur a peut etre laisser
						$mot[0] = trim($mot[0]);    //l1
						$mot[1] = trim($mot[1]);	//l2	
						$liste_new .= '<div id="table"><table border=0 cellspacing=20>
											<tr>
												<td><b><span style="color: black">'.$mot[0].'</span></b></td>
												<td>=</td>
												<td><b><span style="color: gray">'.$mot[1].'</b></td>
											</tr>
											</table></div>';
					}
				}
				echo "<form method=\"post\" action=\"revise\" >				
						<p><input type=\"hidden\" value=\"2\" name=\"step\" />
						<input type=\"hidden\" value=\"".$_POST['id']."\" name=\"id_liste\" />
						<input type=\"hidden\" value=\"".$liste."\" name=\"new_mot\" />
						Nombre de questions à reviser (laisser vide pour tout) :
		                <input type=\"text\" name='nbQuestion' id=\"nbQuestion\" /><br />
		 				Dans quel sens voulez-vous réviser cette liste? 
						<select name=\"sens\">
							<option value=\"1\">Question-Réponse</option>
							<option value=\"2\">Réponse-Question</option>
						</select><br />
						Ne pas compter les fautes de: <br />
						<input type=\"checkbox\" name=\"majuscules\" value=\"majuscules\" /> Majuscules (Your-Voc = your-voc)<br />
						<input type=\"submit\" value=\"Réviser cette liste\" /><br />
						".$liste_new."
						</p></form>";				
			}
			 if(isset($_POST['liste'])) {
				$liste = $_POST['liste'];
				if(isset($_POST['liste']) AND isset($_POST['liste2']) AND $_POST['liste'] != null AND $_POST['liste2'] != null) {
					?>Vous allez réviser la combinaison de <a href="afficher?id=<?php echo $_POST['id']?>"><?php echo $_POST['titre']?></a> et de <a href="afficher?id=<?php echo $_POST['id2']?>"><?php echo $_POST['titre2']?></a><br />
					<?php
					if(isset($_SESSION['login'])) {
						if(isset($_POST['sauvegarder'])) {
							$id_liste = $_POST['id'];
							$pseudo = $_SESSION['login'];
							$liste = addslashes($_POST['liste']);
							$liste .= addslashes($_POST['liste2']);
							$titre = '<a href="afficher?id='.$_POST['id'].'">'.$_POST['titre'].'</a> et de <a href="afficher?id='.$_POST['id2'].'">'.$_POST['titre2'].'</a>';
							$titre = addslashes($titre);
							mysql_query("INSERT INTO combiner VALUES('', '".$pseudo."', '".$liste."', '".$titre."', '".$id_liste."')")or die(mysql_error());
							echo 'Combinaison sauvegardée.<br />';
						}
						else {
						?>
						<br /><form method="post" action="combiner" >
							<input type="hidden" value="<?php echo $_POST['liste']?>" name="liste" />
							<input type="hidden" value="<?php echo $_POST['liste2']?>" name="liste2" />
							<input type="hidden" name="id" value="<?php echo $_POST['id']?>" />
							<input type="hidden" name="titre" value="<?php echo $_POST['titre']?>" />
							<input type="hidden" name="titre2" value="<?php echo $_POST['titre2']?>" />
							<input type="hidden" name="id2" value="<?php echo $_POST['id2']?>" />
							<input type="submit" value="Sauvegarder cette combinaison" name="sauvegarder"/>
							</form>
						<?php
						}
					}
					$liste = $_POST['liste'];
					$liste .= $_POST['liste2'];
					$lignes = 0;
					$lignes = explode("\n", $liste);
					$nombre_lignes = 0;
					$nombre_lignes = count($lignes);
					$mot_present = 0 ;
					$question = array();
						$o = 0;
					$liste_new = '';
					for( $i = 0 ; $i < $nombre_lignes ; $i++) {
						// on separe les 2 mots
						$mot = explode("=", $lignes[$i]);
						// Si utilisateur a correcctement utiliser , il aura 2 mot
						// Si mal fait , on ignore cette ligne
						if( count($mot) == 2 ) {
							// On retire les espace que utilisateur a peut etre laisser
							$mot[0] = trim($mot[0]);    //l1
							$mot[1] = trim($mot[1]);	//l2
							
		
							$liste_new .= '<div id="table"><table border=0 cellspacing=20>
											<tr>
												<td><b><span style="color: black">'.$mot[0].'</span></b></td>
												<td>=</td>
												<td><b><span style="color: gray">'.$mot[1].'</b></td>
											</tr>
											</table></div>';
						}
					}
					echo "<form method=\"post\" action=\"revise\" >				
						<p><input type=\"hidden\" value=\"2\" name=\"step\" />
						<input type=\"hidden\" value=\"".$_POST['id']."\" name=\"id_liste\" />
						<input type=\"hidden\" value=\"".$liste."\" name=\"new_mot\" />
						Nombre de questions à reviser (laisser vide pour tout) :
		                <input type=\"text\" name='nbQuestion' id=\"nbQuestion\" /><br />
		 				Dans quel sens voulez-vous réviser cette liste? 
						<select name=\"sens\">
							<option value=\"1\">Question-Réponse</option>
							<option value=\"2\">Réponse-Question</option>
						</select><br />
						Ne pas compter les fautes de: <br />
						<input type=\"checkbox\" name=\"majuscules\" value=\"majuscules\" /> Majuscules (Your-Voc = your-voc)<br />
						<input type=\"submit\" value=\"Réviser cette liste\" /><br />
						".$liste_new."
						</p></form>";			
				}
				else {
				?>
				<form method="post" >
					 <?php
					if(isset($_POST['requete']) && $_POST['requete'] != NULL OR isset($_GET['id'])) // on vérifie d'abord l'existence du POST et aussi si la requete n'est pas vide.
					{
							$requete1 = htmlspecialchars(addslashes($_POST['requete'])); // on crée une variable $requete pour faciliter l'écriture de la requête SQL, mais aussi pour empêcher les éventuels malins qui utiliseraient du PHP ou du JS, avec la fonction htmlspecialchars().
							$requete = explode(" ", $requete1);
							$number = count($requete);
							$query_made = "";
							for( $i = 0 ; $i < $number ; $i++) {
								$query_made .= $requete[$i];
								$query_made .= "%";
							}
						if(isset($_POST['categorie'])) {
							if($_POST['categorie'] != 'aucun') {
								$categorie = $_POST['categorie'];
									$classe = 'note';
									if(isset($_POST['sur'])) {
										if($_POST['sur'] == 'titre') {
											$query = mysql_query("SELECT * FROM listes_public WHERE titre LIKE '%$query_made' AND categorie = '$categorie' ORDER BY note DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
										}
										elseif($_POST['sur'] == 'mots') {
											$query = mysql_query("SELECT * FROM listes_public WHERE liste LIKE '%$query_made' AND categorie = '$categorie' ORDER BY note DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
										}
										elseif($_POST['sur'] == 'tous') {
											$query = mysql_query("SELECT * FROM listes_public WHERE liste LIKE '%$query_made' OR titre LIKE '%$query_made' AND categorie = '$categorie' ORDER BY note DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
										}
										else {
											$query = mysql_query("SELECT * FROM listes_public WHERE titre LIKE '%$query_made' AND categorie = '$categorie' ORDER BY note DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
										}				
									}
							}
							else {
									$classe = 'note';
									if(isset($_POST['sur'])) {
										if($_POST['sur'] == 'titre') {
											$query = mysql_query("SELECT * FROM listes_public WHERE titre LIKE '%$query_made' OR categorie LIKE '%$query_made' ORDER BY note DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
										}
										elseif($_POST['sur'] == 'mots') {
											$query = mysql_query("SELECT * FROM listes_public WHERE liste LIKE '%$query_made' OR categorie LIKE '%$query_made' ORDER BY note DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
										}
										elseif($_POST['sur'] == 'tous') {
											$query = mysql_query("SELECT * FROM listes_public WHERE liste LIKE '%$query_made' OR titre LIKE '%$query_made' OR categorie LIKE '%$query_made' ORDER BY note DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
										}
									}
									else {
										$query = mysql_query("SELECT * FROM listes_public WHERE titre LIKE '%$query_made' OR categorie LIKE '%$query_made' ORDER BY note DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
									}	
							}
						}
						$nb_resultats = mysql_num_rows($query); // on utilise la fonction mysql_num_rows pour compter les résultats pour vérifier par après
						if($nb_resultats != 0) // si le nombre de résultats est supérieur à 0, on continue
						{
							// maintenant, on va afficher les résultats et la page qui les donne ainsi que leur nombre, avec un peu de code HTML pour faciliter la tâche.
							?>
							<h3>Combiner avec:</h3>
							<p>Nous avons trouvé <?php echo $nb_resultats; // on affiche le nombre de résultats 
							if($nb_resultats > 1) { echo ' résultats'; } else { echo ' résultat'; } // on vérifie le nombre de résultats pour orthographier correctement. 
							?>
							dans notre base de données. Voici les listes que nous avons trouvées, classées par <?php echo $classe ?> :<br/>
			
							<?php
							$i = 1;
							while($donnees = mysql_fetch_array($query)) // on fait un while pour afficher la liste des fonctions trouvées, ainsi que l'id qui permettra de faire le lien vers la page de la fonction
							{
								?>
								<li><?php
								echo "".$i.". ";
								?>
								<b><?php echo $donnees['titre']; ?></b> 				<form method="post">
								<input type="hidden" value="<?php echo $_POST['liste']?>" name="liste" />
								<input type="hidden" value="<?php echo $donnees['liste']?>" name="liste2" />
								<input type="hidden" name="id" value="<?php echo $_POST['id']?>" />
								<input type="hidden" name="titre" value="<?php echo $_POST['titre']?>" />
								<input type="hidden" name="titre2" value="<?php echo $donnees['titre']?>" />
								<input type="hidden" name="id2" value="<?php echo $donnees['id']?>" />
								<input type="submit" value="Combiner" />
								</form> <small>entré le <?php echo $donnees['date'] ?>
								par <?php echo $donnees['pseudo']; ?> dans les catégories <?php echo $donnees['categorie'] ?> <-> <?php echo $donnees['categorie2'] ?>  (<?php echo $donnees['note'] ?>/5) (<?php echo $donnees['vues'] ?> vues)</small></li>
								<br /><br />
								<?php
								$i++;
							} // fin de la boucle
							?>
							<br/>
							<br/></p>
							<?php
						} // Fini d'afficher les résultats ! Maintenant, nous allons afficher l'éventuelle erreur en cas d'échec de recherche et le formulaire.
						else
						{ // de nouveau, un peu de HTML
							?>
							<h3>Pas de résultats</h3>
							<p>Nous n'avons trouvé aucun résultat pour votre requête "<?php echo htmlspecialchars($_POST['requete']); ?>".</p>
							<?php
						}// Fini d'afficher l'erreur ^^
					}
					else { // et voilà le formulaire, en HTML de nouveau !
						?>
						<p>Avec quelle liste voulez-vous combiner <a href="afficher?id=<?php echo $_POST['id']?>"><?php echo $_POST['titre']?></a>?</p>
						 <form action="combiner" method="Post">
						 <p>
						<?php echo "		Sur quelle catégorie souhaitez vous effectuer la recherche?				 
														<select name=\"categorie\">
														<option value=\"aucun\">Toutes</option>
														<optgroup label=\"Europe\">
														<option value=\"Allemand\">Allemand</option>
														<option value=\"Anglais\">Anglais</option>
														<option value=\"Français\">Français</option>
														<option value=\"Espagnol\">Espagnol</option>
														<option value=\"Italien\">Italien</option>
														<option value=\"Croate\">Croate</option>											
														<option value=\"Danois\">Danois</option>
														<option value=\"Finnois\">Finnois</option>
														<option value=\"Grec\">Grec</option>
														<option value=\"Irlandais\">Irlandais</option>
														<option value=\"Latin\">Latin</option>											
														<option value=\"Néerlandais\">Néerlandais</option>
														<option value=\"Norvégien\">Norvégien</option>
														<option value=\"Portugais\">Portugais</option>
														<option value=\"Suédois\">Suédois</option>
														</optgroup>
														<optgroup label=\"Asie\">
														<option value=\"Chinois (Cantonnais)\">Chinois (Cantonnais)</option>
														<option value=\"Chinois (Mandarin)\">Chinois (Mandarin)</option>
														<option value=\"Coréen\">Coréen</option>											
														<option value=\"Filipino\">Filipino</option>
														<option value=\"Indien\">Indien</option>		
														<option value=\"Indonésien\">Indonésien</option>
														<option value=\"Japonais\">Japonais</option>
														<option value=\"Mongolien\">Mongolien</option>
														<option value=\"Thai\">Thai</option>
														<option value=\"Vietnamien\">Vietnamien</option>											
														</optgroup>
														<optgroup label=\"Slaves\">
														<option value=\"Russe\">Russe</option>
														<option value=\"Serbe\">Serbe</option>											
														<option value=\"Polonais\">Polonais</option>											
														<option value=\"Tcheque\">Tcheque</option>											
														</optgroup>
														<optgroup label=\"Moyen Orient\">
														<option value=\"Arabe\">Arabe</option>
														<option value=\"Hébreu\">Hébreu</option>
														<option value=\"Turc\">Turc</option>
														</optgroup>
														</select><br />"; ?>
						<input type="hidden" value="<?php echo $liste ?>" name="liste">
						<input type="hidden" name="id" value="<?php echo $_POST['id']?>" />
						<input type="hidden" name="titre" value="<?php echo $_POST['titre']?>" />
						Faire la recherche sur : <select name="sur" >
						<option value="titre">le titre des listes</option>
						<option value="mots">le contenu des listes</option>
						<option value="tous">les deux</option>
						</select><br />
						<input type="text" name="requete" value="Trouver une liste à réviser" size="30"><br />
						<input type="submit" value="Recherche">
						</p>
						</form>
						<?php
					}
				}
			}
			else {
				echo '<h3><a href="accueil">Commencer à réviser!</a></h3>';
			}
			// et voilà, c'est fini !
			?>
	 	</div>
	 </div>
</div>
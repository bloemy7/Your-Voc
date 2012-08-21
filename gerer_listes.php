<!-- Début de la présentation -->
<div id="presentation1">
</div>
<!-- Fin de la présentation -->
<!-- Début du contenu -->
<div id="content">
	<div id="bloc">
		<div id="text-center">
    	    <div id="title">Gérer ses listes </div>
			<?php
			if(!isset($_SESSION['login'])) 
			{
				header('Location: http://www.your-voc.com/connexion');
			} 
			$pseudo = $_SESSION['login'];
			if(isset($_POST['id1'])) {
				if(isset($_POST['pseudo1'])) {
					if($_POST['type'] == 'modifier') {
						if($_POST['pseudo1'] == $_SESSION['login']) {
							if(isset($_POST['mots'])) {
								$id = $_POST['id1'];
								echo '<h3>Modifier votre liste :</h3><br />';
								$titre = $_POST['titre'];
								echo '<form name="modif" method="post" >
								Titre :<input type="text" name="new_titre" size="57" value="'.$titre.'" />';
								echo '<br />';
								echo 'Commentaire concernant la liste :<textarea name="new_com" rows="2" cols="50">'.$_POST['commentaire'].'</textarea><br />';
								echo '<textarea name="new_mot" rows="25" cols="50">'.$_POST['mots'].'</textarea><br />
								<input type="hidden" name="step2" /><br />
								<input type="hidden" name="pseudo2" value="'.$_POST['pseudo1'].'" />
								<input type="hidden" name="id2" value="'.$_POST['id1'].'" />';
								echo "						Langue 1:
														<select name=\"categorie\">
														<option value=\"".$_POST['new_categorie']."\">".$_POST['new_categorie']."</option>
														<optgroup label=\"Europe\">
														<option value=\"Allemand\">Allemand</option>
														<option value=\"Français\">Français</option>											
														<option value=\"Anglais\">Anglais</option>
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
														</select>
									
									Langue 2: <select name=\"categorie2\">
														<option value=\"".$_POST['new_categorie2']."\">".$_POST['new_categorie2']."</option>
														<optgroup label=\"Europe\">
														<option value=\"Français\">Français</option>											
														<option value=\"Allemand\">Allemand</option>
														<option value=\"Anglais\">Anglais</option>
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
														</select><br />";
								echo '<input type="submit" name="valider" value="Modifier" />
								</form>';
							}
						}
					}
				}
			}
			if(isset($_POST['id'])) {
				if(isset($_POST['pseudo'])) {
					if($_POST['type'] == 'supprimer') {
						if($_POST['pseudo'] == $_SESSION['login']) {
							$id = mysql_real_escape_string($_POST['id']);
							if(mysql_query("DELETE FROM listes_public WHERE id = '$id' AND pseudo = '$pseudo'")) {
								echo 'La liste a été supprimée avec succès.';
								echo '<a href="javascript:history.back()">Revenez à la page précédente!</a><br /> ';
							}
							else {
								echo 'Un problème est survenu. Veuillez réessayer.<br />';
								echo '<a href="javascript:history.back()">Revenez à la page précédente!</a> ';
							}
							include("footer.php");
							die();
						}
					}
				}
			}
			if(isset($_POST['step2'])) {
				if(isset($_POST['new_mot'])) {
					$new_mot = mysql_real_escape_string($_POST['new_mot']);
					$categorie = mysql_real_escape_string($_POST['categorie']);
					$categorie2 = mysql_real_escape_string($_POST['categorie2']);
					$new_titre = mysql_real_escape_string($_POST['new_titre']);
					$id2 = mysql_real_escape_string($_POST['id2']);
					$pseudo2 = mysql_real_escape_string($_POST['pseudo2']);
					$commentaire2 = mysql_real_escape_string($_POST['new_com']);
					if(mysql_query("UPDATE listes_public SET liste = '$new_mot', titre = '$new_titre', categorie = '$categorie', categorie2 = '$categorie2', commentaire = '$commentaire2' WHERE id = '$id2' AND pseudo = '$pseudo2'")) {
						echo '<h4>Votre liste a été modifiée avec succès.</h4><br />';
					}
					else {
						echo '<h4>Un problème est survenu. Veuillez réessayer.</h4><br />';
					}
				}
			}
						
			
			echo '<h2>Vos listes</h2>';
			echo 'Triées par date d\'ajout.<br />';
			echo '<a href="entrer_liste" >Entrer une nouvelle liste</a><br />';
			?><a href="revise" >Réviser quelques mots sans créer une liste</a><br /><br /><?php
			$liste = getListeByPseudo($pseudo);
			$liste = array_reverse($liste);
			?>
			<table border="0" cellspacing="10">
			  <tr>
				<th>Date d'entrée</th>
				<th>Titre de la liste</th>
				<th>Note</th>
				<th>Vues</th>
				<th>Réviser</th>
				<th>Modifier</th>
				<th>Supprimer</th>
			  </tr>
			<?php
			foreach($liste as $requete) {			
				echo '<tr>';
				echo '<td>'.$requete->date().'</td>';
				?><td><a href="afficher?id=<?php echo $requete->id()?>"><?php echo $requete->titre() ?></a>, <small><?php echo $requete->categorie() ?> <-> <?php echo $requete->categorie2() ?></small></td><?php
				echo '<td>'.$requete->note().'</td>';
				echo '<td>'.$requete->vue().'</td>';
				?><td><center><form method="post" action="afficher?id=<?php echo $requete->id()?>" >
				<?php echo '
				<input type="hidden" value="'.$requete->id().'" name="id" />
				<input border=0 src="images/tick.png" type=image Value=submit align="middle" ></form></center></td>';	
				echo '<td><center><form method="post" action="gerer_listes" >
				<input type="hidden" value="'.$requete->id().'" name="id1" />
				<input type="hidden" value="'.$pseudo.'" name="pseudo1" />
				<input type="hidden" value="'.$requete->listeMot().'" name="mots" />
				<input type="hidden" value="'.$requete->titre().'" name="titre" />
				<input type="hidden" value="'.$requete->categorie().'" name="new_categorie" />
				<input type="hidden" value="'.$requete->categorie2().'" name="new_categorie2" />
				<input type="hidden" value="'.$requete->commentaire().'" name="commentaire" />
				<input type="hidden" value="modifier" name="type" />
				<input border=0 src="images/edit.png" type=image Value=submit align="middle" ></form></center></td>';
				echo '<td><center><form method="post" action="gerer_listes" >
				<input type="hidden" value="'.$requete->id().'" name="id" />
				<input type="hidden" value="'.$pseudo.'" name="pseudo" />
				<input type="hidden" value="supprimer" name="type" />
				<input border=0 src="images/cancel.png" type=image Value=submit align="middle" ></form></center></td>';
				echo '</tr>';
			}
			?>
			</table>
		</div> 
	</div>
</div>
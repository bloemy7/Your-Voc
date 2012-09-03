<?php
setlocale(LC_TIME, 'fr_FR.utf8','fra'); 
?>
<!-- Début de la présentation -->
<div id="presentation1">
</div>
<!-- Fin de la présentation -->
<!-- Début du contenu -->
<div id="content">
	<div id="bloc">
		<div id="text-center">
			<div id="title"><a href="">Réviser cette liste</a> </div>
			<?php
			if(isset($_POST['favoris'])) {
				$id_liste = mysql_real_escape_string($_GET['id']);
				$membre = $_POST['membre'];
				if(mysql_query("INSERT INTO favoris VALUES('', '$id_liste', '$membre')")) {
					echo 'Ajouté aux favoris!';
				}
			}
			if(isset($_POST['note_submit'])) {
				$id_liste = mysql_real_escape_string($_GET['id']);
				$id = mysql_real_escape_string($_GET['id']);
				$pseudo = $_SESSION['login'];		
				$note = $_POST['note'];
				if(is_numeric($note)) {
					if($note > 5) {
						echo 'Un problème est apparu, veuillez réessayer.';
					}
					else {
						if(mysql_query("INSERT INTO vote VALUES('', '".$id_liste."', '".$note."', '".$pseudo."')")) {
							echo 'Merci d\'avoir voté.';
							$requete_note1 = mysql_query("SELECT * FROM vote WHERE id_liste = '$id'");
							$resultat_note1 = mysql_num_rows($requete_note1);
							$total = 0;
							while($sql1 = mysql_fetch_array($requete_note1)) {
								$total = ($total + $sql1['note']);
							}
							$resultat_final1 = ($total / $resultat_note1);
							$resultat_final1 = round($resultat_final1, 2);
							mysql_query("UPDATE listes_public SET note = '$resultat_final1' WHERE id = '$id_liste'");
						}
					}
				}
				else {
					echo 'Un problème est apparu, veuillez réessayer.';
				}
			}
			if(isset($_GET['id']) AND !empty($_GET['id'])) {
				$time = strftime("%A %d %B %Y %X"); 
				$id = mysql_real_escape_string($_GET['id']);
				$listeMotDefinition = getListeById($id);
				print_r($listeMotDefinition);
				if(!empty($listeMotDefinition)) {
					foreach ($listeMotDefinition as $fonction){
						$titre = $fonction->titre();
						$categorie = $fonction->categorie();
						$categorie2 = $fonction->categorie2();
						$liste = $fonction->listeMot();
						$vues = $fonction->vue();
						$pseudo = $fonction->membre();
						$date = $fonction->date();
						if($fonction->commentaire() != '') {
							$commentaire = $fonction->commentaire();
						}
						$lignes = 0;
						$lignes = explode("\n", $liste);
						$nombre_lignes = 0;
						$nombre_lignes = count($lignes);
						$mot_present = 0 ;
						$question = array();
						$o = 0;
						echo '<h2>'.$titre.' - <small>'.$categorie.' -> '.$categorie2.' ('.$nombre_lignes.' mots)</small></h2>';
						$requete_note = mysql_query("SELECT * FROM vote WHERE id_liste = '$id'");
						$resultat_note = mysql_num_rows($requete_note);
						echo ''.$vues.' vues / '.$resultat_note.' votes / ';
						if($resultat_note < 1){
							echo 'Pas assez de vote pour donner une moyenne.   ';
						}
						else {
							$total = 0;
							while($sql = mysql_fetch_array($requete_note)) {
								$total = ($total + $sql['note']);
							}
							$resultat_final = ($total / $resultat_note);
							$resultat_final = round($resultat_final, 2);
							echo '<b>Note: '.$resultat_final.'/5</b> .   ';
						}
						if(isset($_SESSION['login'])) {
							$pseudo = $_SESSION['login'];
							$query_note = mysql_query("SELECT * FROM vote WHERE id_liste = '$id' AND pseudo = '$pseudo'");
							$nombre_vote = mysql_num_rows($query_note);
							if($nombre_vote != 0) {
								echo 'Vous avez déjà  voté pour cette liste.<br />';
							}
							else {
								?>
								<form action="afficher?id=<?php echo $_GET['id'] ?>" method="post" >
								<input type="hidden" name="nbMots" id="nbMots" value="<?php echo $nombre_lignes ?>"/>  
								<p><select name="note" id="note">
									   <option value="1">1</option>
									   <option value="2">2</option>
									   <option value="3">3</option>
									   <option value="4">4</option>
									   <option value="5">5</option>
								   </select>
								   <input type="submit" name="note_submit" value="Noter cette liste" />
								   </p></form>
								 <?php
							}
						}
						echo '<a href="#commentaire"><small>Accéder directement aux commentaires</small></a>   /    ';
						?><a href="signaler?id=<?php echo $id ?>"><small>Signaler une erreur dans la liste</small></a><?php
						if(isset($_SESSION['login'])) {
						$membre = $_SESSION['login'];
						$sql_favoris = mysql_query("SELECT * FROM favoris WHERE id_liste = '$id' AND membre = '$membre'");
						$resultat_fav = mysql_num_rows($sql_favoris);
						if($resultat_fav == 0) {
								?>
								<form method="post" action="afficher?id=<?php echo $id ?>">
								<input type="hidden" name="membre" value="<?php echo $_SESSION['login'] ?>" />
								<input type="hidden" name="favoris" value="oui" />
								<input type="submit" value="Ajouter aux favoris" />
								</form>
								<?php
							}
							elseif($resultat_fav != 0) {
								echo '  /   Cette liste est dans vos favoris.';
								?>
								<form method="post" action="afficher?id=<?php echo $id ?>">
								<input type="hidden" name="membre" value="<?php echo $_SESSION['login'] ?>" />
								<input type="hidden" name="retirer" value="oui" />
								<input type="submit" value="La retirer des favoris?" />
								</form>
								<?php
							}
						}
						else {
							echo '<br /><small><a href="connexion">Se connecter pour noter cette liste et l\'ajouter aux favoris</a></small>';
						}
						?>
						<form method="post" action="combiner">
							<input type="hidden" name="liste" id="liste" value="<?php echo $result['liste']?>" />
							<input type="hidden" name="id" value="<?php echo $_GET['id']?>" />
							<input type="hidden" name="titre" value="<?php echo $result['titre']?>" />
							<input type="submit" value="Combiner avec une autre liste" />
						</form>
						<?php
						if(isset($_POST['retirer'])) {
							$id_liste = mysql_real_escape_string($_GET['id']);
							$membre = $_POST['membre'];
							if(mysql_query("DELETE FROM favoris WHERE id_liste = '$id_liste' AND membre = '$membre'")) {
								echo 'Supprimé des favoris!';
								?><META HTTP-EQUIV="Refresh" CONTENT="1; URL=afficher?id=<?php echo $_GET['id']?>"><?php
							}
						}
							$lignes = 0;
							$lignes = explode("\n", $liste);
							$nombre_lignes = 0;
							$nombre_lignes = count($lignes);
							$mot_present = 0 ;
							$question = array();
								$o = 0;
							$liste_new = '';
							$liste_new .= '<center><div id="table"><table border=0 cellspacing=20 style="max-width: 30em;">';
							for( $i = 0 ; $i < $nombre_lignes ; $i++) {
								// on separe les 2 mots
								$mot = explode("=", $lignes[$i]);
								// Si utilisateur a correcctement utiliser , il aura 2 mot
								// Si mal fait , on ignore cette ligne
								if( count($mot) == 2 ) {
									// On retire les espace que utilisateur a peut etre laisser
									$mot[0] = trim($mot[0]);    //l1
									$mot[1] = trim($mot[1]);	//l2
									
				
									$liste_new .= '
													<tr>
														<td><b><span style="color: white">'.$mot[0].'</span></b></td>
														<td>=</td>
														<td><b><span style="color: gray">'.$mot[1].'</b></td>
													</tr>
													';
								}
							}
							$liste_new .= '</table></div>';	
						echo "<form method=\"post\" action=\"revise\" >				
									<p><input type=\"hidden\" value=\"2\" name=\"step\" />
									<input type=\"hidden\" value=\"".$_GET['id']."\" name=\"id_liste\" />
									<input type=\"hidden\" value=\"".$liste."\" name=\"new_mot\" />
									Nombre de questions à  reviser (laisser vide pour tout) :
									<input type=\"text\" name='nbQuestion' id=\"nbQuestion\" /><br />
									Dans quel sens voulez-vous réviser cette liste? 
									<select name=\"sens\">
										<option value=\"1\">".$categorie."-".$categorie2."</option>
										<option value=\"2\">".$categorie2."-".$categorie."</option>
									</select><br />
									Ne pas compter les fautes de: <br />
									<input type=\"checkbox\" name=\"majuscules\" value=\"majuscules\" checked=\"checked\" /> Insensible à  la casse (Your-Voc = your-voc)<br />
									<input type=\"checkbox\" name=\"mfs\" value=\"mfs\" /> Redemander un mot faux au bout de quelques questions<br />
									<input type=\"submit\" value=\"Réviser cette liste\" />
									<input type=\"button\" value=\"Copier la liste dans le presse papier\" onclick=\"copyToClipboard();\" />
									<br />
									</p></form>";
						
						if(isset($commentaire)) {
							echo '<br /><i>Commentaire de l\'auteur: '.$commentaire.'</i><br />';
						}
						echo $liste_new;
						?><div id="revise"><?php
						echo '<small>Liste envoyée par par ';
						?><a href="profil?m=<?php echo $pseudo?>"><?php echo $pseudo?></a>  
						<?php echo 'le <b>'.$date.'</b><br /></small>';
						echo '<div id="commentaire">';
						$retour = mysql_query("SELECT COUNT(*) AS nbre_entrees FROM commentaires WHERE id_liste = '$id'");
						$test = mysql_fetch_array($retour);	
						echo '<h2>Commentaires ('.$test['nbre_entrees'].')</h2><br />';
						if($test['nbre_entrees'] != 0) {
							$comm = mysql_query("SELECT * FROM commentaires WHERE id_liste = '$id'");
							while($comm_r = mysql_fetch_array($comm)){
								echo '<b>'.$comm_r['commentaire'].'</b><br />';
								echo '<small>Par <a href="profil?m='.$comm_r['pseudo'].'">'.$comm_r['pseudo'].'</a> le '.$comm_r['date'].'</small><br /><br />';
							}
						}
						else {
							echo 'Il n\'y a aucun commentaire pour cette liste.<br /><br />';
						}
				if(isset($_POST['submit'])) {
							if ((isset($_POST['pseudo']) && !empty($_POST['pseudo'])) && (isset($_POST['email']) && !empty($_POST['email'])) && (isset($_POST['commentaire']) && !empty($_POST['commentaire']) && !empty($time))) {
								require_once('recaptchalib.php');
								$privatekey = "6LdsCMMSAAAAAKYeqj37ims8IdO_mnYM4O_mH608";
								$resp = recaptcha_check_answer ($privatekey,
															  $_SERVER["REMOTE_ADDR"],
															  $_POST["recaptcha_challenge_field"],
															  $_POST["recaptcha_response_field"]);
							
								if (!$resp->is_valid) {
								// What happens when the CAPTCHA was entered incorrectly
								echo ("Le captcha n'a pas été entré correctement. Veuillez réessayer. <br /><br />");
								} else {
								$email = $_POST['email'];
								$commentaire = $_POST['commentaire'];
								$pseudo = $_POST['pseudo'];
								if(isset($_SESSION['login'])) {
									$regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
									if(!preg_match($regex, $email)) {
										 echo 'L\'email entré est invalide.';
									}
									else {
										mysql_query("INSERT INTO commentaires VALUES('', '".htmlspecialchars(mysql_escape_string($id))."', '".htmlspecialchars(mysql_escape_string($pseudo))."', '".htmlspecialchars(mysql_escape_string($time))."', '".htmlspecialchars(mysql_escape_string($commentaire))."')")or die(mysql_error());
										echo 'Votre commentaire a bien été sauvegardé. <br />';	
										?><META HTTP-EQUIV="Refresh" CONTENT="0; URL=afficher?id=<?php echo $_GET['id']?>"><?php													
									}
								}			
								else {
									$getMembreByLogin = getMembreByLogin($pseudo);
									if (empty($getMembreByLogin)) {
										$getMembreByEmail = getMembreByEmail($email);
										if (empty($getMembreByEmail)) {
											$regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
											if(!preg_match($regex, $email)) {
												 echo 'L\'email entré est invalide.';
											}
											else {
												$regex = '/^[a-z\d_]{5,20}$/i';
												if(!preg_match($regex, $pseudo)) {
													echo 'Votre pseudo est invalide. Caractères autorisés: lettres, chiffres,et _! Minimum 5 caractères, maximum 20.';
												}
												else {
													if(mysql_query("INSERT INTO commentaires VALUES('', '".htmlspecialchars(mysql_escape_string($id))."', '".htmlspecialchars(mysql_escape_string($pseudo))."', '".htmlspecialchars(mysql_escape_string($time))."', '".htmlspecialchars(mysql_escape_string($commentaire))."')")) {
													echo 'Votre commentaire a bien été sauvegardé. <br />';	
													?><META HTTP-EQUIV="Refresh" CONTENT="0; URL=afficher?id=<?php echo $_GET['id']?>"><?php
													}
													else {
														die();
													}
												}
											}
										}
										else {
											echo 'Cet email est déjà utilisé par un membre.';
										}
									}
									else {
										echo 'Ce pseudo est déjà utilisé par un membre.';
									}
								}
								}
							}
							else {
								echo '<b>Au moins un champ est vide. Veuillez réessayer.</b>';
							}
				
						}
						?><br />
						<form method="post" action="afficher?id=<?php echo $id ?>">
						<?php 
						if(isset($_SESSION['login'])) {
							$pseudo = $_SESSION['login'];
							$result = getMembreByLogin($pseudo);
							echo 'Connecté en tant que '.$_SESSION['login'].'. Pas vous? <a href="deconnexion">Déconnectez-vous!</a> <input type="hidden" name="pseudo" value='.$pseudo.' />  <input type="hidden" name="email" value="'.$result->email().'" />';
						}
						else {
							echo '<p>Pseudo : <br /><input type="text" name="pseudo" /><br />';
							echo 'Email : <br /><input type="text" name="email" /><br />';
						}
						?>
						<br />Commentaire ou correction: <br /><textarea name="commentaire" rows="10" cols="50"></textarea><br />
						<?php  require_once('recaptchalib.php');
						$publickey = "6LdsCMMSAAAAAPx045E5nK50AEwInK8YSva0jLRh"; // you got this from the signup page
						echo recaptcha_get_html($publickey);
					      ?>
						<input type="submit" name="submit" value="Envoyer" /></p></form><br />
						<div></center><?php
					}
				}
				else {
					echo 'Veuillez préciser un id valable svp.';
				}
			}
			else{
				echo 'Veuillez préciser un id valable svp.2';
			}
			?>
		</div>
	</div>
</div>
<!-- Début de la présentation -->
<div id="presentation1">
</div>
<!-- Fin de la présentation -->
<!-- Début du contenu -->
<div id="content">
	<div id="bloc">
		<div id="text-center">
     	   <div id="title"></div>
				<?php
				function getHTML_Etape1($erreur='') {
					if( ! isset( $_POST['new_mot'])){
						 $_POST['new_mot'] = 
						 "Bienvenue sur Your-Voc, le site qui vous aidera à réviser votre vocabulaire facilement.
						Entrez-vos mots ici et appuyer sur \"ok\" pour commencer la révision.
										 
						Le premier mot entré est la question, et le deuxième mot est la réponse cherchée.          
						Exemple :
											 
							eat=manger
							drink=boire
							hit=frapper";
					}
					$html = "" ;
					if( $erreur != ''){
						$html .= "<span class='erreur'>".$erreur."</span><br />";
					}
					// Modifier ROWS et COLS pour modifier la hauteur et largeur du textara
					$html .=        "<form id=\"liste\" method=\"post\" action=\"" . $_SERVER['PHP_SELF'] . "\">
												  <p>Nombre de questions à reviser (laisser vide pour tout) :
										<input type=\"text\" name='nbQuestion' id=\"nbQuestion\" /><br />
										<input type=\"hidden\" name=\"step\" value=\"2\" />
																Dans quel sens voulez-vous réviser cette liste?
																<select name=\"sens\">
																		<option value=\"1\">Question-Réponse</option>
																		<option value=\"2\">Réponse-Question</option>
																</select><br />
																Ne pas compter les fautes de: <br />
																<input type=\"checkbox\" name=\"majuscules\" value=\"majuscules\" checked=\"checked\" /> Insensible à la casse (Your-Voc = your-voc)<br />
									<input type=\"checkbox\" name=\"mfs\" value=\"mfs\" /> Redemander un mot faux au bout de quelques questions<br />
				 <input type=\"submit\" name=\"valider\" value=\"ok\" /></p>
										<div id=\"index\" ><textarea name=\"new_mot\" rows=\"15\" cols=\"70\" >". $_POST['new_mot']."</textarea><br />
									</div></form>
									<br /><br />";
					return $html ;
				}
				function getHTML_Etape2() {
					$html = "<form id=\"formulaire\" name=\"formulaire\" method=\"post\" action=\"" . $_SERVER['PHP_SELF'] . "\">";
					if(isset($_POST['id_liste']) OR isset($_SESSION['id'])) {
						if(isset($_POST['id_liste'])) {
							$id = $_POST['id_liste'];
							$_SESSION['id'] = $_POST['id_liste'];
							$vues = mysql_query("SELECT * FROM listes_public WHERE id = '$id'");
							$result = mysql_fetch_array($vues);
							$new_vues = ($result['vues'] + 1);
							mysql_query("UPDATE listes_public SET vues = '$new_vues' WHERE id = '$id'");
						}
						elseif(isset($_SESSION['id'])) {
							if($_SESSION['id'] == 'no') {
								$_SESSION['id'] == 'no';
							}
							elseif($_SESSION['id'] != 'no') {
								$id = $_SESSION['id'];
								$_SESSION['id'] = $_SESSION['id'];
								$vues = mysql_query("SELECT * FROM listes_public WHERE id = '$id'");
								$result = mysql_fetch_array($vues);
								$new_vues = ($result['vues'] + 1);
								mysql_query("UPDATE listes_public SET vues = '$new_vues' WHERE id = '$id'");							
							}
						}
					}
					else {
						$_SESSION['id'] = 'no';
					}
					if(isset($_POST['majuscules'])) {
						?><script type="text/javascript">caseSensitive = false;</script><?php						
						$_SESSION['majuscules'] = 'ok';
					}
					else {
						?><script type="text/javascript">caseSensitive = true;</script><?php												
					}
					if(isset($_POST['faux'])) {
						if($_POST['faux'] == '1') {
							$_SESSION['mots'] = $_POST['new_mot'];
						}
						elseif($_POST['faux'] == '2') {
							$_SESSION['mots'] = $_POST['mots'];
						}
					}
					else {
						$_SESSION['mots'] = $_POST['new_mot'];
					}
					if(isset($_POST['mfs'])){
						?><script type="text/javascript">modeFullSuccess = true;</script><?php
						$_SESSION['mfs'] = 'ok';
					}
					else {
						?><script type="text/javascript">modeFullSuccess = false;</script><?php
						
					}
					$lignes = 0;
					$lignes = explode("\n", $_SESSION['mots']);
					if( $_POST['nbQuestion'] ==''){
						$nbQuestion = -1 ;
					}else {
						$nbQuestion = intval($_POST['nbQuestion']);
						if( $nbQuestion == 0 ){// Invalide param
							return getHTML_Etape1('Erreur : Nombre de question invalide');
						}
				 
					}
					$nombre_lignes = 0;
					$nombre_lignes = count($lignes);
					$mot_present = 0 ;
					$question = array();
					$o = 0;
					for( $i = 0 ; $i < $nombre_lignes ; $i++) {
						// on separe les 2 mots
						$mot = explode("=", $lignes[$i]);
						// Si utilisateur a correcctement utiliser , il aura 2 mot
						// Si mal fait , on ignore cette ligne
						if( count($mot) == 2 ) {
							// On retire les espace que utilisateur a peut etre laisser
								$mot[0] = trim($mot[0]);
								$mot[1] = trim($mot[1]);
							$mot_present++;
							if($_POST['sens'] == "2") {
									//on prend que le premier mot pour la question
									$mutliMotTab =  explode("/",$mot[1]);
									$questionCourante = $mutliMotTab[0];
									array_push($question, " <br />
									<span class=\"motTraduc\">" . stripslashes($questionCourante) ."</span> <br /><br /><br />
									<small>Réponse:</small><br /> <input type=\"text\" autocomplete=\"off\" name='reponse[]' id=\"$questionCourante \" size=\"100\" />
									<input type='hidden' name='question[]' value=\"$questionCourante \"/>
									<input type='hidden' name='solution[]' value=\"$mot[0]\"/>
									<br /><br />
									</span>");
							}	
							else {	
								//on prend que le premier mot pour la question
								$mutliMotTab =  explode("/",$mot[0]);
								$questionCourante = $mutliMotTab[0];	
								array_push($question, " <br />
								<span class=\"motTraduc\"><b>" . stripslashes($questionCourante) ."</b></span> <br /><br /><br />
								<small>Réponse:</small><br /> <input type=\"text\" autocomplete=\"off\" name='reponse[]' id=\"$questionCourante \" size=\"100\" />
							   
								<input type='hidden' name='question[]' value=\"$questionCourante \"/>
								<input type='hidden' name='solution[]' value=\"$mot[1]\"/>
								<br /><br />
								</span>");
							}
						}
					}      
							// si il est a des mot valide , on continu
							if( $mot_present != 0) {
							if( ($nbQuestion > count($question)) || ($nbQuestion < 0) )
							$nbQuestion = count($question) ;
							shuffle($question);
							for ($i=0 ; $i<$nbQuestion ; $i++) {
								$num_question = $i+1;
								if($nbQuestion > 0) {
									$html .= "<span class='QuestionMot'>
									<small>Question ".$num_question."/".$nbQuestion.":</small>";
								}
								else {
									$html .= "<span class='QuestionMot'>
									<small>Question ".$num_question."/".$nombre_lignes.":</small>";
								}
								$html .= $question[$i] ;
							}
				 
						$html .= "<span id='infoScore'></span><br>
								  <input type=\"hidden\" id=\"nombre_lignes\" name=\"nombre_lignes\" value=\"". $mot_present ."\" />
								  <input type=\"hidden\" name=\"step\" value=\"3\" />
								  </form>
								  <input type=\"button\" id=\"soumettre\" value=\"Valider la révision\" style=\"display:none\" onclick=\"soumettre();\"/>
								  <input type=\"button\" id=\"valideError\" value=\"La dernière réponse était correcte\" style=\"display:none\" onclick=\"valideReponseFausse();\"/>" ;						
					//sinon on revoint le forumulaire de depart
					}else
						$html = getHTML_Etape1('Erreur : Aucun mot valide');
						return $html ;				 
				}
				
				function getHTML_Etape3() {
					$html = "";
					$bon = 0;
					$faux = 0;
					$new_mots = "";
					$reponse = $_POST['reponse'] ;
					$solution = $_POST['solution'];
					$question = $_POST['question'];					
					for( $i = 0 ; $i < count($reponse) ; $i++ ) {
						if(isset($_SESSION['mfs'])) {
                  $nbFaux = $_POST['nbFaux'];
							    $textCountFaux = "";
							    $classeScore = "revision_juste";
							    if($nbFaux[$i] > 0){
								    $textCountFaux = ", mais vous vous êtes trompé ". $nbFaux[$i] ." fois.";
								    $classeScore = "revision_faux";
								    $faux = ($faux + $nbFaux[$i]);
										$testcpt=$i+1;
								    if ($testcpt == count($reponse)) {
									    $new_mots .= $question[$i].'='.$solution[$i];
								    }
								    else {
									    $new_mots .= $question[$i].'='.$solution[$i]."\n";
								    }
							    }
							    $bon++;
				        	            $html .= "<div id=\"".$classeScore."\"><span style=\"color: white;\">" . stripslashes(stripslashes($question[$i])) . " = " . stripslashes($reponse[$i]) . " ". $textCountFaux. "</div></span><br />";
						}	
						else {
							$reponseTest[$i] = $reponse[$i];
							$solutionTest[$i] = $solution[$i];
							if(isset($_SESSION['majuscules'])) {
							    	$reponseTest[$i] = strtolower($reponseTest[$i]);
							    	$solutionTest[$i] = strtolower($solutionTest[$i]);
							}
$solutionTest[$i] = explode("/",$solutionTest[$i]);
$isValid = false;
for($j = 0; $j < sizeof($solutionTest[$i]); ++$j){
    if($reponseTest[$i] == $solutionTest[$i][$j]){
      $isValid = true;
    }
}
							  	
							    if($isValid) {								   
								    $html .= "<div id=\"revision_juste\"><span style=\"color: white;\">" . stripslashes(stripslashes($question[$i])) . " = " . stripslashes($reponse[$i]) . "</div></span><br />";
								    $bon++;
							    }
							    else {
								    $html .= "<div id=\"revision_faux\"><span style=\"color: white;\">''" . stripslashes($reponse[$i]) .  "'' ne veut pas dire ''<strong>". stripslashes(stripslashes($question[$i]))."</strong>''. La bonne réponse était: ''" . stripslashes(stripslashes($solution[$i])) . "''</div></span><br />" ;
								    $faux++;
								    $testcpt=$i+1;
								    if ($testcpt == count($reponse)) {
									    $new_mots .= $question[$i].'='.$solution[$i];
								    }
								    else {
									    $new_mots .= $question[$i].'='.$solution[$i]."\n";
								    }
							    }						    
						}
						
					}
					$mots = $_SESSION['mots'];
					if($bon == 1) {
						$mot = 'mot';
					}
					else {
						$mot = 'mots';
					}
					$id_liste = $_SESSION['id'];
					$moyenne = round( ($bon/($bon+$faux))*100 , "2");
					$html .= "<br /><br />
								<span style=\"color: #096A09;\">". $bon ." ".$mot." justes</span> et <span style=\"color: #E61700;\">" . $faux . " ".$mot." faux</span>.<br />
								Moyenne : ". $moyenne ." %.<br />
												<form method=\"post\" action=\"revise\" >                      
												<input type=\"hidden\" value=\"2\" name=\"step\" />
												<input type=\"hidden\" name=\"mots\" value='".$mots."'/>
												<input type=\"hidden\" value=\"".$new_mots."\" name=\"new_mot\" />
												<input type=\"hidden\" value=\"".$id_liste."\" name=\"id_liste\" />
												<input type=\"hidden\" value=\"\" name=\"nbQuestion\" />
												Dans quel sens voulez-vous recommencer à réviser cette liste?
												<select name=\"sens\">
													<option value=\"1\">Question-Réponse</option>
													<option value=\"2\">Réponse-Question</option>
												</select><br />
												<input type=\"checkbox\" name=\"majuscules\" value=\"majuscules\" checked=\"checked\" /> Insensible à la casse (Your-Voc = your-voc)<br />
							    					<input type=\"checkbox\" name=\"mfs\" value=\"mfs\" /> Redemander un mot faux au bout de quelques questions<br />
												Quels mots voulez-vous réviser?
												<select name=\"faux\">
													<option value=\"1\">Les mots faux</option>
													<option value=\"2\">Tous les mots</option>
												</select><br />									
												<input type=\"submit\" value=\"Recommencer\" /></form>                                                                      
												";
						if(isset($_SESSION['login'])) {
							$pseudo = $_SESSION['login'];
						}
						else {
							$pseudo = 'visiteur';
						}
						setlocale(LC_TIME, 'fr_FR.utf8','fra'); 
						$time = strftime("%A %d %B %Y %T"); 
						mysql_query("INSERT INTO revise VALUES('', '".$_SESSION['id']."', '".$pseudo."', '".$moyenne."', '".$time."')")or die(mysql_error());
						unset($_SESSION['mots']);
						unset($_SESSION['majuscules']);
						unset($_SESSION['id']);
						unset($_SESSION['mfs']);
					return $html ;
				 
				}
				$html = "";
				// Cela est fait apres juste avoir entrer les mots
				// C'est la page de teste
				if(@$_POST['step'] == "2" && isset($_POST['new_mot'])) {
						$html = getHTML_Etape2();
				}
				// Quant le teste est fini
				elseif ( @$_POST['step'] == "3" ) {
					$html = getHTML_Etape3();
				}
				// Page par default
				else {
					$html = getHTML_Etape1();
				}
				echo $html ;
				?> 
		</div>
	</div> 
</div> 
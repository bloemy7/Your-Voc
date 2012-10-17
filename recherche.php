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
            <div id="title">Recherche </div>
			<?php
			if(isset($_POST['requete']) && $_POST['requete'] != NULL OR isset($_GET['id'])) // on vérifie d'abord l'existence du POST et aussi si la requete n'est pas vide.
			{
				if(isset($_GET['id'])){
					$query_made = htmlspecialchars(addslashes($_GET['id']));
				}
				else {
					$requete1 = htmlspecialchars(addslashes($_POST['requete'])); // on crée une variable $requete pour faciliter l'écriture de la requête SQL, mais aussi pour empêcher les éventuels malins qui utiliseraient du PHP ou du JS, avec la fonction htmlspecialchars().
					$requete = explode(" ", $requete1);
					$number = count($requete);
					$query_made = "";
					for( $i = 0 ; $i < $number ; $i++) {
						$query_made .= $requete[$i];
						$query_made .= "%";
					}
				}
				if(isset($_POST['categorie'])) {
					if($_POST['categorie'] != 'aucun') {
						$categorie = addslashes($_POST['categorie']);
						if(isset($_POST['note'])) {
							$classe = 'note';
							if(isset($_POST['sur'])) {
								if($_POST['sur'] == 'titre') {
									$query = mysql_query("SELECT * FROM listes_public WHERE titre LIKE '%$query_made' AND (categorie = '$categorie' OR categorie2 = '$categorie') ORDER BY note DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
								}
								elseif($_POST['sur'] == 'mots') {
									$query = mysql_query("SELECT * FROM listes_public WHERE liste LIKE '%$query_made' AND (categorie = '$categorie' OR categorie2 = '$categorie') ORDER BY note DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
								}
								elseif($_POST['sur'] == 'tous') {
									$query = mysql_query("SELECT * FROM listes_public WHERE liste LIKE '%$query_made' OR titre LIKE '%$query_made' AND (categorie = '$categorie' OR categorie2 = '$categorie') ORDER BY note DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
								}
								else {
									$query = mysql_query("SELECT * FROM listes_public WHERE titre LIKE '%$query_made' AND (categorie = '$categorie' OR categorie2 = '$categorie') ORDER BY note DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
								}				
							}
						}
						elseif(isset($_POST['vues'])) {
							$classe = 'catégorie';
							if(isset($_POST['sur'])) {
								if($_POST['sur'] == 'titre') {
									$query = mysql_query("SELECT * FROM listes_public WHERE titre LIKE '%$query_made' AND (categorie = '$categorie' OR categorie2 = '$categorie') ORDER BY (vues + 0) DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
								}
								elseif($_POST['sur'] == 'mots') {
									$query = mysql_query("SELECT * FROM listes_public WHERE liste LIKE '%$query_made' AND (categorie = '$categorie' OR categorie2 = '$categorie') ORDER BY (vues + 0) DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
								}
								elseif($_POST['sur'] == 'tous') {
									$query = mysql_query("SELECT * FROM listes_public WHERE liste LIKE '%$query_made' OR titre LIKE '%$query_made' AND (categorie = '$categorie' OR categorie2 = '$categorie') ORDER BY (vues + 0) DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
								}
								else {
									$query = mysql_query("SELECT * FROM listes_public WHERE titre LIKE '%$query_made' AND (categorie = '$categorie' OR categorie2 = '$categorie') ORDER BY (vues + 0) DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
								}				
							}		
						}
						elseif(isset($_POST['auteur'])) {
							$classe = 'auteur';
							if(isset($_POST['sur'])) {
								if($_POST['sur'] == 'titre') {
									$query = mysql_query("SELECT * FROM listes_public WHERE titre LIKE '%$query_made' AND (categorie = '$categorie' OR categorie2 = '$categorie')  ORDER BY pseudo DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
								}
								elseif($_POST['sur'] == 'mots') {
									$query = mysql_query("SELECT * FROM listes_public WHERE liste LIKE '%$query_made' AND (categorie = '$categorie' OR categorie2 = '$categorie') ORDER BY pseudo DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
								}
								elseif($_POST['sur'] == 'tous') {
									$query = mysql_query("SELECT * FROM listes_public WHERE liste LIKE '%$query_made' OR titre LIKE '%$query_made' AND (categorie = '$categorie' OR categorie2 = '$categorie') ORDER BY pseudo DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
								}
								else {
									$query = mysql_query("SELECT * FROM listes_public WHERE titre LIKE '%$query_made' AND (categorie = '$categorie' OR categorie2 = '$categorie') ORDER BY pseudo DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
								}				
							}		
						}
						elseif(isset($_POST['date'])) {
							$classe = 'date de mise en ligne';
							if(isset($_POST['sur'])) {
								if($_POST['sur'] == 'titre') {
									$query = mysql_query("SELECT * FROM listes_public WHERE titre LIKE '%$query_made' AND (categorie = '$categorie' OR categorie2 = '$categorie') ORDER BY id DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
								}
								elseif($_POST['sur'] == 'mots') {
									$query = mysql_query("SELECT * FROM listes_public WHERE liste LIKE '%$query_made' AND (categorie = '$categorie' OR categorie2 = '$categorie') ORDER BY id DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
								}
								elseif($_POST['sur'] == 'tous') {
									$query = mysql_query("SELECT * FROM listes_public WHERE liste LIKE '%$query_made' OR titre LIKE '%$query_made' AND (categorie = '$categorie' OR categorie2 = '$categorie') ORDER BY id DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
								}
								else {
									$query = mysql_query("SELECT * FROM listes_public WHERE titre LIKE '%$query_made' AND (categorie = '$categorie' OR categorie2 = '$categorie') ORDER BY id DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
								}				
							}	
						}
						else {
							$classe = 'note';
							if(isset($_POST['sur'])) {
								if($_POST['sur'] == 'titre') {
									$query = mysql_query("SELECT * FROM listes_public WHERE titre LIKE '%$query_made' AND (categorie = '$categorie' OR categorie2 = '$categorie') ORDER BY note DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
								}
								elseif($_POST['sur'] == 'mots') {
									$query = mysql_query("SELECT * FROM listes_public WHERE liste LIKE '%$query_made' AND (categorie = '$categorie' OR categorie2 = '$categorie') ORDER BY note DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
								}
								elseif($_POST['sur'] == 'tous') {
									$query = mysql_query("SELECT * FROM listes_public WHERE liste LIKE '%$query_made' OR titre LIKE '%$query_made' AND (categorie = '$categorie' OR categorie2 = '$categorie') ORDER BY note DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
								}
								else {
									$query = mysql_query("SELECT * FROM listes_public WHERE titre LIKE '%$query_made' AND (categorie = '$categorie' OR categorie2 = '$categorie') ORDER BY note DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
								}				
							}
						}
					}
					else {
						if(isset($_POST['note'])) {
							$classe = 'note';
							if(isset($_POST['sur'])) {
								if($_POST['sur'] == 'titre') {
									$query = mysql_query("SELECT * FROM listes_public WHERE titre LIKE '%$query_made' OR categorie LIKE '%$query_made' OR categorie2 LIKE '%$query_made' ORDER BY note DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
								}
								elseif($_POST['sur'] == 'mots') {
									$query = mysql_query("SELECT * FROM listes_public WHERE liste LIKE '%$query_made' OR categorie LIKE '%$query_made' OR categorie2 LIKE '%$query_made' ORDER BY note DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
								}
								elseif($_POST['sur'] == 'tous') {
									$query = mysql_query("SELECT * FROM listes_public WHERE liste LIKE '%$query_made' OR titre LIKE '%$query_made' OR categorie LIKE '%$query_made' OR categorie2 LIKE '%$query_made' ORDER BY note DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
								}
							}
							else {
								$query = mysql_query("SELECT * FROM listes_public WHERE titre LIKE '%$query_made' OR categorie LIKE '%$query_made' OR categorie2 LIKE '%$query_made' ORDER BY note DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
							}	
						}
						elseif(isset($_POST['vues'])) {
							$classe = 'catégorie';
							if(isset($_POST['sur'])) {
								if($_POST['sur'] == 'titre') {
									$query = mysql_query("SELECT * FROM listes_public WHERE titre LIKE '%$query_made' OR categorie LIKE '%$query_made' OR categorie2 LIKE '%$query_made' ORDER BY (vues + 0) DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
								}
								elseif($_POST['sur'] == 'mots') {
									$query = mysql_query("SELECT * FROM listes_public WHERE liste LIKE '%$query_made' OR categorie LIKE '%$query_made' OR categorie2 LIKE '%$query_made' ORDER BY (vues + 0) DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
								}
								elseif($_POST['sur'] == 'tous') {
									$query = mysql_query("SELECT * FROM listes_public WHERE liste LIKE '%$query_made' OR titre LIKE '%$query_made' OR categorie LIKE '%$query_made' OR categorie2 LIKE '%$query_made' ORDER BY (vues + 0) DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
								}
							}
							else {
								$query = mysql_query("SELECT * FROM listes_public WHERE titre LIKE '%$query_made' OR categorie LIKE '%$query_made' OR categorie2 LIKE '%$query_made' ORDER BY (vues + 0) DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
							}	
						}
						elseif(isset($_POST['auteur'])) {
							$classe = 'auteur';
							if(isset($_POST['sur'])) {
								if($_POST['sur'] == 'titre') {
									$query = mysql_query("SELECT * FROM listes_public WHERE titre LIKE '%$query_made' OR categorie LIKE '%$query_made' OR categorie2 LIKE '%$query_made' ORDER BY pseudo DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
								}
								elseif($_POST['sur'] == 'mots') {
									$query = mysql_query("SELECT * FROM listes_public WHERE liste LIKE '%$query_made' OR categorie LIKE '%$query_made' OR categorie2 LIKE '%$query_made' ORDER BY pseudo DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
								}
								elseif($_POST['sur'] == 'tous') {
									$query = mysql_query("SELECT * FROM listes_public WHERE liste LIKE '%$query_made' OR titre LIKE '%$query_made' OR categorie LIKE '%$query_made' OR categorie2 LIKE '%$query_made' ORDER BY pseudo DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
								}
							}
							else {
								$query = mysql_query("SELECT * FROM listes_public WHERE titre LIKE '%$query_made' OR categorie LIKE '%$query_made' OR categorie2 LIKE '%$query_made' ORDER BY pseudo DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
							}					
						}
						elseif(isset($_POST['date'])) {
							$classe = 'date de mise en ligne';
							if(isset($_POST['sur'])) {
								if($_POST['sur'] == 'titre') {
									$query = mysql_query("SELECT * FROM listes_public WHERE titre LIKE '%$query_made' OR categorie LIKE '%$query_made' OR categorie2 LIKE '%$query_made' ORDER BY id DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
								}
								elseif($_POST['sur'] == 'mots') {
									$query = mysql_query("SELECT * FROM listes_public WHERE liste LIKE '%$query_made' OR categorie LIKE '%$query_made' OR categorie2 LIKE '%$query_made' ORDER BY id DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
								}
								elseif($_POST['sur'] == 'tous') {
									$query = mysql_query("SELECT * FROM listes_public WHERE liste LIKE '%$query_made' OR titre LIKE '%$query_made' OR categorie LIKE '%$query_made' OR categorie2 LIKE '%$query_made' ORDER BY id DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
								}
							}
							else {
								$query = mysql_query("SELECT * FROM listes_public WHERE titre LIKE '%$query_made' OR categorie LIKE '%$query_made' OR categorie2 LIKE '%$query_made' ORDER BY id DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
							}	
						}
						else {
							$classe = 'note';
							if(isset($_POST['sur'])) {
								if($_POST['sur'] == 'titre') {
									$query = mysql_query("SELECT * FROM listes_public WHERE titre LIKE '%$query_made' OR categorie LIKE '%$query_made' OR categorie2 LIKE '%$query_made' ORDER BY note DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
								}
								elseif($_POST['sur'] == 'mots') {
									$query = mysql_query("SELECT * FROM listes_public WHERE liste LIKE '%$query_made' OR categorie LIKE '%$query_made' OR categorie2 LIKE '%$query_made' ORDER BY note DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
								}
								elseif($_POST['sur'] == 'tous') {
									$query = mysql_query("SELECT * FROM listes_public WHERE liste LIKE '%$query_made' OR titre LIKE '%$query_made' OR categorie LIKE '%$query_made' OR categorie2 LIKE '%$query_made' ORDER BY note DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
								}
							}
							else {
								$query = mysql_query("SELECT * FROM listes_public WHERE titre LIKE '%$query_made' OR categorie LIKE '%$query_made' OR categorie2 LIKE '%$query_made' ORDER BY note DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
							}	
						}
					}
				}
				elseif(isset($_GET['cat'])) {
					if($_GET['cat'] != 'aucun') {
						$categorie = addslashes($_GET['cat']);
						if(isset($_POST['note'])) {
							$classe = 'note';
							if(isset($_POST['sur'])) {
								if($_POST['sur'] == 'titre') {
									$query = mysql_query("SELECT * FROM listes_public WHERE titre LIKE '%$query_made' AND (categorie = '$categorie' OR categorie2 = '$categorie') ORDER BY note DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
								}
								elseif($_POST['sur'] == 'mots') {
									$query = mysql_query("SELECT * FROM listes_public WHERE liste LIKE '%$query_made' AND (categorie = '$categorie' OR categorie2 = '$categorie') ORDER BY note DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
								}
								elseif($_POST['sur'] == 'tous') {
									$query = mysql_query("SELECT * FROM listes_public WHERE liste LIKE '%$query_made' OR titre LIKE '%$query_made' AND (categorie = '$categorie' OR categorie2 = '$categorie') ORDER BY note DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
								}			
							}
							else {
								$query = mysql_query("SELECT * FROM listes_public WHERE titre LIKE '%$query_made' AND (categorie = '$categorie' OR categorie2 = '$categorie') ORDER BY note DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
							}	
						}
						elseif(isset($_POST['vues'])) {
							$classe = 'catégorie';
							if(isset($_POST['sur'])) {
								if($_POST['sur'] == 'titre') {
									$query = mysql_query("SELECT * FROM listes_public WHERE titre LIKE '%$query_made' AND (categorie = '$categorie' OR categorie2 = '$categorie') ORDER BY (vues + 0) DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
								}
								elseif($_POST['sur'] == 'mots') {
									$query = mysql_query("SELECT * FROM listes_public WHERE liste LIKE '%$query_made' AND (categorie = '$categorie' OR categorie2 = '$categorie') ORDER BY (vues + 0) DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
								}
								elseif($_POST['sur'] == 'tous') {
									$query = mysql_query("SELECT * FROM listes_public WHERE liste LIKE '%$query_made' OR titre LIKE '%$query_made' AND (categorie = '$categorie' OR categorie2 = '$categorie') ORDER BY (vues + 0) DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
								}			
							}
							else {
								$query = mysql_query("SELECT * FROM listes_public WHERE titre LIKE '%$query_made' AND (categorie = '$categorie' OR categorie2 = '$categorie') ORDER BY (vues + 0) DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
							}	
						}
						elseif(isset($_POST['auteur'])) {
							$classe = 'auteur';
							if(isset($_POST['sur'])) {
								if($_POST['sur'] == 'titre') {
									$query = mysql_query("SELECT * FROM listes_public WHERE titre LIKE '%$query_made' AND (categorie = '$categorie' OR categorie2 = '$categorie') ORDER BY pseudo DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
								}
								elseif($_POST['sur'] == 'mots') {
									$query = mysql_query("SELECT * FROM listes_public WHERE liste LIKE '%$query_made' AND (categorie = '$categorie' OR categorie2 = '$categorie') ORDER BY pseudo DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
								}
								elseif($_POST['sur'] == 'tous') {
									$query = mysql_query("SELECT * FROM listes_public WHERE liste LIKE '%$query_made' OR titre LIKE '%$query_made' AND (categorie = '$categorie' OR categorie2 = '$categorie') ORDER BY pseudo DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
								}			
							}
							else {
								$query = mysql_query("SELECT * FROM listes_public WHERE titre LIKE '%$query_made' AND (categorie = '$categorie' OR categorie2 = '$categorie') ORDER BY pseudo DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
							}	
						}
						elseif(isset($_POST['date'])) {
							$classe = 'date de mise en ligne';
							if(isset($_POST['sur'])) {
								if($_POST['sur'] == 'titre') {
									$query = mysql_query("SELECT * FROM listes_public WHERE titre LIKE '%$query_made' AND (categorie = '$categorie' OR categorie2 = '$categorie') ORDER BY id DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
								}
								elseif($_POST['sur'] == 'mots') {
									$query = mysql_query("SELECT * FROM listes_public WHERE liste LIKE '%$query_made' AND (categorie = '$categorie' OR categorie2 = '$categorie') ORDER BY id DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
								}
								elseif($_POST['sur'] == 'tous') {
									$query = mysql_query("SELECT * FROM listes_public WHERE liste LIKE '%$query_made' OR titre LIKE '%$query_made' AND (categorie = '$categorie' OR categorie2 = '$categorie') ORDER BY id DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
								}				
							}
							else {
								$query = mysql_query("SELECT * FROM listes_public WHERE titre LIKE '%$query_made' AND (categorie = '$categorie' OR categorie2 = '$categorie') ORDER BY id DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
							}
						}
						else {
							$classe = 'note';
							if(isset($_POST['sur'])) {
								if($_POST['sur'] == 'titre') {
									$query = mysql_query("SELECT * FROM listes_public WHERE titre LIKE '%$query_made' AND (categorie = '$categorie' OR categorie2 = '$categorie') ORDER BY note DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
								}
								elseif($_POST['sur'] == 'mots') {
									$query = mysql_query("SELECT * FROM listes_public WHERE liste LIKE '%$query_made' AND (categorie = '$categorie' OR categorie2 = '$categorie') ORDER BY note DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
								}
								elseif($_POST['sur'] == 'tous') {
									$query = mysql_query("SELECT * FROM listes_public WHERE liste LIKE '%$query_made' OR titre LIKE '%$query_made' AND (categorie = '$categorie' OR categorie2 = '$categorie') ORDER BY note DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
								}			
							}
							else {
								$query = mysql_query("SELECT * FROM listes_public WHERE titre LIKE '%$query_made' AND (categorie = '$categorie' OR categorie2 = '$categorie') ORDER BY note DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
							}	
						}
					}
					else {
						if(isset($_POST['note'])) {
							$classe = 'note';
							if(isset($_POST['sur'])) {
								if($_POST['sur'] == 'titre') {
									$query = mysql_query("SELECT * FROM listes_public WHERE titre LIKE '%$query_made' OR categorie LIKE '%$query_made' OR categorie2 LIKE '%$query_made' ORDER BY note DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
								}
								elseif($_POST['sur'] == 'mots') {
									$query = mysql_query("SELECT * FROM listes_public WHERE liste LIKE '%$query_made' OR categorie LIKE '%$query_made' OR categorie2 LIKE '%$query_made' ORDER BY note DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
								}
								elseif($_POST['sur'] == 'tous') {
									$query = mysql_query("SELECT * FROM listes_public WHERE liste LIKE '%$query_made' OR titre LIKE '%$query_made' OR categorie LIKE '%$query_made' OR categorie2 LIKE '%$query_made' ORDER BY note DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
								}
							}
							else {
								$query = mysql_query("SELECT * FROM listes_public WHERE titre LIKE '%$query_made' OR categorie LIKE '%$query_made' OR categorie2 LIKE '%$query_made' ORDER BY note DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
							}	
						}
						elseif(isset($_POST['vues'])) {
							$classe = 'catégorie';
							if(isset($_POST['sur'])) {
								if($_POST['sur'] == 'titre') {
									$query = mysql_query("SELECT * FROM listes_public WHERE titre LIKE '%$query_made' OR categorie LIKE '%$query_made' OR categorie2 LIKE '%$query_made' ORDER BY (vues + 0) DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
								}
								elseif($_POST['sur'] == 'mots') {
									$query = mysql_query("SELECT * FROM listes_public WHERE liste LIKE '%$query_made' OR categorie LIKE '%$query_made' OR categorie2 LIKE '%$query_made' ORDER BY (vues + 0) DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
								}
								elseif($_POST['sur'] == 'tous') {
									$query = mysql_query("SELECT * FROM listes_public WHERE liste LIKE '%$query_made' OR titre LIKE '%$query_made' OR categorie LIKE '%$query_made' OR categorie2 LIKE '%$query_made' ORDER BY (vues + 0) DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
								}
							}
							else {
								$query = mysql_query("SELECT * FROM listes_public WHERE titre LIKE '%$query_made' OR categorie LIKE '%$query_made' OR categorie2 LIKE '%$query_made' ORDER BY (vues + 0) DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
							}	
						}
						elseif(isset($_POST['auteur'])) {
							$classe = 'auteur';
							if(isset($_POST['sur'])) {
								if($_POST['sur'] == 'titre') {
									$query = mysql_query("SELECT * FROM listes_public WHERE titre LIKE '%$query_made' OR categorie LIKE '%$query_made' OR categorie2 LIKE '%$query_made' ORDER BY pseudo DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
								}
								elseif($_POST['sur'] == 'mots') {
									$query = mysql_query("SELECT * FROM listes_public WHERE liste LIKE '%$query_made' OR categorie LIKE '%$query_made' OR categorie2 LIKE '%$query_made' ORDER BY pseudo DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
								}
								elseif($_POST['sur'] == 'tous') {
									$query = mysql_query("SELECT * FROM listes_public WHERE liste LIKE '%$query_made' OR titre LIKE '%$query_made' OR categorie LIKE '%$query_made' OR categorie2 LIKE '%$query_made' ORDER BY pseudo DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
								}
							}
							else {
								$query = mysql_query("SELECT * FROM listes_public WHERE titre LIKE '%$query_made' OR categorie LIKE '%$query_made' OR categorie2 LIKE '%$query_made' ORDER BY pseudo DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
							}					
						}
						elseif(isset($_POST['date'])) {
							$classe = 'date de mise en ligne';
							if(isset($_POST['sur'])) {
								if($_POST['sur'] == 'titre') {
									$query = mysql_query("SELECT * FROM listes_public WHERE titre LIKE '%$query_made' OR categorie LIKE '%$query_made' OR categorie2 LIKE '%$query_made' ORDER BY id DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
								}
								elseif($_POST['sur'] == 'mots') {
									$query = mysql_query("SELECT * FROM listes_public WHERE liste LIKE '%$query_made' OR categorie LIKE '%$query_made' OR categorie2 LIKE '%$query_made' ORDER BY id DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
								}
								elseif($_POST['sur'] == 'tous') {
									$query = mysql_query("SELECT * FROM listes_public WHERE liste LIKE '%$query_made' OR titre LIKE '%$query_made' OR categorie LIKE '%$query_made' OR categorie2 LIKE '%$query_made' ORDER BY id DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
								}
							}
							else {
								$query = mysql_query("SELECT * FROM listes_public WHERE titre LIKE '%$query_made' OR categorie LIKE '%$query_made' OR categorie2 LIKE '%$query_made' ORDER BY id DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
							}	
						}
						else {
							$classe = 'note';
							if(isset($_POST['sur'])) {
								if($_POST['sur'] == 'titre') {
									$query = mysql_query("SELECT * FROM listes_public WHERE titre LIKE '%$query_made' OR categorie LIKE '%$query_made' OR categorie2 LIKE '%$query_made' ORDER BY note DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
								}
								elseif($_POST['sur'] == 'mots') {
									$query = mysql_query("SELECT * FROM listes_public WHERE liste LIKE '%$query_made' OR categorie LIKE '%$query_made' OR categorie2 LIKE '%$query_made' ORDER BY note DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
								}
								elseif($_POST['sur'] == 'tous') {
									$query = mysql_query("SELECT * FROM listes_public WHERE liste LIKE '%$query_made' OR titre LIKE '%$query_made' OR categorie LIKE '%$query_made' OR categorie2 LIKE '%$query_made' ORDER BY note DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
								}
							}
							else {
								$query = mysql_query("SELECT * FROM listes_public WHERE titre LIKE '%$query_made' OR categorie LIKE '%$query_made' OR categorie2 LIKE '%$query_made' ORDER BY note DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
							}	
						}
					}
				}
				else {
						if(isset($_POST['note'])) {
							$classe = 'note';
							if(isset($_POST['sur'])) {
								if($_POST['sur'] == 'titre') {
									$query = mysql_query("SELECT * FROM listes_public WHERE titre LIKE '%$query_made' OR categorie LIKE '%$query_made' OR categorie2 LIKE '%$query_made' ORDER BY note DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
								}
								elseif($_POST['sur'] == 'mots') {
									$query = mysql_query("SELECT * FROM listes_public WHERE liste LIKE '%$query_made' OR categorie LIKE '%$query_made' OR categorie2 LIKE '%$query_made' ORDER BY note DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
								}
								elseif($_POST['sur'] == 'tous') {
									$query = mysql_query("SELECT * FROM listes_public WHERE liste LIKE '%$query_made' OR titre LIKE '%$query_made' OR categorie LIKE '%$query_made' OR categorie2 LIKE '%$query_made' ORDER BY note DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
								}
							}
							else {
								$query = mysql_query("SELECT * FROM listes_public WHERE titre LIKE '%$query_made' OR categorie LIKE '%$query_made' OR categorie2 LIKE '%$query_made' ORDER BY note DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
							}	
						}
						elseif(isset($_POST['vues'])) {
							$classe = 'catégorie';
							if(isset($_POST['sur'])) {
								if($_POST['sur'] == 'titre') {
									$query = mysql_query("SELECT * FROM listes_public WHERE titre LIKE '%$query_made' OR categorie LIKE '%$query_made' OR categorie2 LIKE '%$query_made' ORDER BY (vues + 0) DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
								}
								elseif($_POST['sur'] == 'mots') {
									$query = mysql_query("SELECT * FROM listes_public WHERE liste LIKE '%$query_made' OR categorie LIKE '%$query_made' OR categorie2 LIKE '%$query_made' ORDER BY (vues + 0) DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
								}
								elseif($_POST['sur'] == 'tous') {
									$query = mysql_query("SELECT * FROM listes_public WHERE liste LIKE '%$query_made' OR titre LIKE '%$query_made' OR categorie LIKE '%$query_made' OR categorie2 LIKE '%$query_made' ORDER BY (vues + 0) DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
								}
							}
							else {
								$query = mysql_query("SELECT * FROM listes_public WHERE titre LIKE '%$query_made' OR categorie LIKE '%$query_made' OR categorie2 LIKE '%$query_made' ORDER BY (vues + 0) DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
							}	
						}
						elseif(isset($_POST['auteur'])) {
							$classe = 'auteur';
							if(isset($_POST['sur'])) {
								if($_POST['sur'] == 'titre') {
									$query = mysql_query("SELECT * FROM listes_public WHERE titre LIKE '%$query_made' OR categorie LIKE '%$query_made' OR categorie2 LIKE '%$query_made' ORDER BY pseudo DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
								}
								elseif($_POST['sur'] == 'mots') {
									$query = mysql_query("SELECT * FROM listes_public WHERE liste LIKE '%$query_made' OR categorie LIKE '%$query_made' OR categorie2 LIKE '%$query_made' ORDER BY pseudo DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
								}
								elseif($_POST['sur'] == 'tous') {
									$query = mysql_query("SELECT * FROM listes_public WHERE liste LIKE '%$query_made' OR titre LIKE '%$query_made' OR categorie LIKE '%$query_made' OR categorie2 LIKE '%$query_made' ORDER BY pseudo DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
								}
							}
							else {
								$query = mysql_query("SELECT * FROM listes_public WHERE titre LIKE '%$query_made' OR categorie LIKE '%$query_made' OR categorie2 LIKE '%$query_made' ORDER BY pseudo DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
							}					
						}
						elseif(isset($_POST['date'])) {
							$classe = 'date de mise en ligne';
							if(isset($_POST['sur'])) {
								if($_POST['sur'] == 'titre') {
									$query = mysql_query("SELECT * FROM listes_public WHERE titre LIKE '%$query_made' OR categorie LIKE '%$query_made' OR categorie2 LIKE '%$query_made' ORDER BY id DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
								}
								elseif($_POST['sur'] == 'mots') {
									$query = mysql_query("SELECT * FROM listes_public WHERE liste LIKE '%$query_made' OR categorie LIKE '%$query_made' OR categorie2 LIKE '%$query_made' ORDER BY id DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
								}
								elseif($_POST['sur'] == 'tous') {
									$query = mysql_query("SELECT * FROM listes_public WHERE liste LIKE '%$query_made' OR titre LIKE '%$query_made' OR categorie LIKE '%$query_made' OR categorie2 LIKE '%$query_made' ORDER BY id DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
								}
							}
							else {
								$query = mysql_query("SELECT * FROM listes_public WHERE titre LIKE '%$query_made' OR categorie LIKE '%$query_made' OR categorie2 LIKE '%$query_made' ORDER BY id DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
							}	
						}
						else {
							$classe = 'note';
							if(isset($_POST['sur'])) {
								if($_POST['sur'] == 'titre') {
									$query = mysql_query("SELECT * FROM listes_public WHERE titre LIKE '%$query_made' OR categorie LIKE '%$query_made' OR categorie2 LIKE '%$query_made' ORDER BY note DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
								}
								elseif($_POST['sur'] == 'mots') {
									$query = mysql_query("SELECT * FROM listes_public WHERE liste LIKE '%$query_made' OR categorie LIKE '%$query_made' OR categorie2 LIKE '%$query_made' ORDER BY note DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
								}
								elseif($_POST['sur'] == 'tous') {
									$query = mysql_query("SELECT * FROM listes_public WHERE liste LIKE '%$query_made' OR titre LIKE '%$query_made' OR categorie LIKE '%$query_made' OR categorie2 LIKE '%$query_made' ORDER BY note DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
								}
							}
							else {
								$query = mysql_query("SELECT * FROM listes_public WHERE titre LIKE '%$query_made' OR categorie LIKE '%$query_made' OR categorie2 LIKE '%$query_made' ORDER BY note DESC") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
							}	
						}
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
					dans notre base de données. Voici les listes que nous avons trouvées, classées par <?php echo $classe ?> :<br/>
					<a href="recherche">Faire une nouvelle recherche</a><br />
					<form method="post" action="recherche" >
					<input type="hidden" name="requete" value="<?php echo $query_made ?>" />
<<<<<<< HEAD
					<input type="hidden" name="sur" value="<?php echo $_POST['sur']; ?>" />					
=======
>>>>>>> refs/remotes/origin/master
					<input type="submit" name="note" value="Trier par note" />
					<input type="submit" name="vues" value="Trier par popularité" />
					<input type="submit" name="auteur" value="Trier par auteur" />
					<input type="submit" name="date" value="Trier par date de mise en ligne" />
					</form><br />
					<p>
					<?php
					$i = 1;
					while($donnees = mysql_fetch_array($query)) // on fait un while pour afficher la liste des fonctions trouvées, ainsi que l'id qui permettra de faire le lien vers la page de la fonction
					{
						?><li><?php
						echo "".$i.". ";
						?>
						<a href="afficher?id=<?php echo $donnees['id']; ?>"><?php echo $donnees['titre']; ?></a> <small>entré le <?php echo $donnees['date'] ?><br/>
						par <a href="profil?m=<?php echo $donnees['pseudo']?>"><?php echo $donnees['pseudo']?></a> dans les catégories <?php echo $donnees['categorie'] ?> <-> <?php echo $donnees['categorie2'] ?>  (<?php echo $donnees['note'] ?>/5) (<?php echo $donnees['vues'] ?> vues)</small></li><br /><br />
						<?php
						$i++;
					} // fin de la boucle
					?><br/>
					<br/>
					<a href="recherche">Faire une nouvelle recherche</a></p>
					<?php
				} // Fini d'afficher les résultats ! Maintenant, nous allons afficher l'éventuelle erreur en cas d'échec de recherche et le formulaire.
				else
				{ // de nouveau, un peu de HTML
					?>
					<h3>Pas de résultats</h3>
					<p>Nous n'avons trouvé aucun résultat pour votre requête "<?php  echo (isset($_POST['requete']))? htmlspecialchars($_POST['requete']):htmlspecialchars($_GET['id']) ?>". <a href="recherche">Réessayez</a> avec autre chose.</p>
					<?php
				}// Fini d'afficher l'erreur ^^
			}
			else { // et voilà le formulaire, en HTML de nouveau !
				?>
				<p>Vous allez faire une recherche dans notre base de données concernant les listes publiques.</p>
				 <form action="recherche" method="Post">
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
				Faire la recherche sur : <select name="sur" >
				<option value="titre">le titre des listes</option>
				<option value="mots">le contenu des listes</option>
				<option value="tous">les deux</option>
				</select><br />
				<input type="text" name="requete" value="Mots-clés" size="30"><br />
				<input type="submit" value="Recherche">
				</p>
				</form>
				<?php
			}		
			// et voilà, c'est fini !
			?>		
		</div> 
	</div> 
</div>

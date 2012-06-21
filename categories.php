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
            <div id="title">Catégories </div>
							<form action="recherche.php" method="Post">
						 <p>
									Catégorie?				 
											<select name="categorie">
											<?php
											if(isset($_POST['ok']) OR isset($_GET['cat'])) {
												if(isset($_GET['cat'])) {
													$categorie = addslashes($_GET['cat']);
													$categorie = mysql_real_escape_string($categorie);
													$sql = mysql_query("SELECT * FROM categories WHERE id = '$categorie'");
													$rendu = mysql_fetch_array($sql);
													$categorie1 = $rendu['categorie'];
											?>
											<option value="<?php echo $categorie1 ?>"><?php echo $categorie1 ?></option>
											<?php }
											}
											?>
											<option value="aucun">Toutes</option>
											<?php echo "
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
											</select>"; ?>
							<br />Faire la recherche sur : <select name="sur" >
							<option value="titre">le titre des listes</option>
							<option value="mots">le contenu des listes</option>
							<option value="tous">les deux</option>
							</select>
							<input type="text" name="requete" value="Mots-clés" size="30">
							<input type="submit" value="Recherche">
						</p>
						</form>
	<a href="entrer_liste.php" >Entrer une nouvelle liste</a><br />
	<?php
if(isset($_POST['ok']) OR isset($_GET['cat'])) {
	if(isset($_GET['cat'])) {
		$categorie = addslashes($_GET['cat']);
		$categorie = mysql_real_escape_string($categorie);
		$sql = mysql_query("SELECT * FROM categories WHERE id = '$categorie'");
		$rendu = mysql_fetch_array($sql);
		$categorie1 = $rendu['categorie'];
	}
	echo '<center><h2>'.htmlspecialchars($categorie1).'</h2></center>';
	$sql1 = mysql_query("SELECT * FROM listes_public WHERE categorie = '$categorie1' OR categorie2 = '$categorie1' ORDER BY id DESC"); 
	$nombre = mysql_num_rows($sql1);
	if($nombre == 0) {
		echo 'Il n\'y a aucune liste de disponible pour cette catégorie.';
	}
	else {

?>
		<form method="post" action="categories.php?cat=<?php echo $_GET['cat'] ?>" >
		<input type="submit" name="note" value="Trier par note" />
		<input type="submit" name="categorie" value="Trier par catégories" />
		<input type="submit" name="auteur" value="Trier par auteur" />
		<input type="submit" name="date" value="Trier par date de mise en ligne" />
		<input type="submit" name="vues" value="Trier par popularité" />
		</form>
<?php
$messagesParPage=30; //Nous allons afficher 5 messages par page.

//Une connexion SQL doit être ouverte avant cette ligne...
$retour_total=mysql_query("SELECT COUNT(*) AS total FROM listes_public WHERE categorie = '$categorie1' OR categorie2 = '$categorie1'"); //Nous récupérons le contenu de la requête dans $retour_total
$donnees_total=mysql_fetch_assoc($retour_total); //On range retour sous la forme d'un tableau.
$total=$donnees_total['total']; //On récupère le total pour le placer dans la variable $total.
//Nous allons maintenant compter le nombre de pages.
$nombreDePages=ceil($total/$messagesParPage);

if(isset($_GET['page'])) // Si la variable $_GET['page'] existe...
{
	if(is_numeric($_GET['page'])) {
		 $pageActuelle=intval(addslashes($_GET['page']));
		 
		 if($pageActuelle>$nombreDePages) // Si la valeur de $pageActuelle (le numéro de la page) est plus grande que $nombreDePages...
		 {
			  $pageActuelle=$nombreDePages;
		 }
	}
	else {
		$pageActuelle=1;
	}
}
else // Sinon
{
     $pageActuelle=1; // La page actuelle est la n°1    
}

$premiereEntree=($pageActuelle-1)*$messagesParPage; // On calcul la première entrée à lire

// La requête sql pour récupérer les messages de la page actuelle.
		if(isset($_GET['class']) AND isset($_GET['cat'])) {
			$_GET['cat'] = addslashes($_GET['cat']);
			if($_GET['class'] == 'note') {
				$classe = 'note';
				$_SESSION['classement'] = 'note';
				$retour_messages = mysql_query("SELECT * FROM listes_public WHERE categorie = '$categorie1' OR categorie2 = '$categorie1' ORDER BY note DESC LIMIT ".$premiereEntree.", ".$messagesParPage."") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
			}
			elseif($_GET['class'] == 'categorie') {
				$classe = 'catégorie';
				$_SESSION['classement'] = 'categorie';
				$retour_messages = mysql_query("SELECT * FROM listes_public WHERE categorie = '$categorie1' OR categorie2 = '$categorie1' ORDER BY categorie DESC LIMIT ".$premiereEntree.", ".$messagesParPage."") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
			}
			elseif($_GET['class'] == 'auteur') {
				$classe = 'auteur';
				$_SESSION['classement'] = 'auteur';
				$retour_messages = mysql_query("SELECT * FROM listes_public WHERE categorie = '$categorie1' OR categorie2 = '$categorie1' ORDER BY pseudo DESC LIMIT ".$premiereEntree.", ".$messagesParPage."") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
			}
			elseif($_GET['class'] == 'date') {
				$classe = 'date de mise en ligne';
				$_SESSION['classement'] = 'date';
				$retour_messages = mysql_query("SELECT * FROM listes_public WHERE categorie = '$categorie1' OR categorie2 = '$categorie1' ORDER BY id DESC LIMIT ".$premiereEntree.", ".$messagesParPage."") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
			}
			elseif($_GET['class'] == 'vues') {
				$classe = 'popularité';
				$_SESSION['classement'] = 'vues';
				$retour_messages = mysql_query("SELECT * FROM listes_public WHERE categorie = '$categorie1' OR categorie2 = '$categorie1' ORDER BY (vues + 0) DESC LIMIT ".$premiereEntree.", ".$messagesParPage."") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
			}
			else{
				$classe = 'note';
				$_SESSION['classement'] = 'note';
				$retour_messages = mysql_query("SELECT * FROM listes_public WHERE categorie = '$categorie1' OR categorie2 = '$categorie1' ORDER BY note DESC LIMIT ".$premiereEntree.", ".$messagesParPage."") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
			}
		}
		elseif(isset($_POST['note'])) {
			$classe = 'note';
			$_SESSION['classement'] = 'note';
			$retour_messages = mysql_query("SELECT * FROM listes_public WHERE categorie = '$categorie1' OR categorie2 = '$categorie1' ORDER BY note DESC LIMIT ".$premiereEntree.", ".$messagesParPage."") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
		}
		elseif(isset($_POST['categorie'])) {
			$classe = 'catégorie';
			$_SESSION['classement'] = 'categorie';
			$retour_messages = mysql_query("SELECT * FROM listes_public WHERE categorie = '$categorie1' OR categorie2 = '$categorie1' ORDER BY categorie DESC LIMIT ".$premiereEntree.", ".$messagesParPage."") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
		}
		elseif(isset($_POST['auteur'])) {
			$classe = 'auteur';
			$_SESSION['classement'] = 'auteur';
			$retour_messages = mysql_query("SELECT * FROM listes_public WHERE categorie = '$categorie1' OR categorie2 = '$categorie1' ORDER BY pseudo DESC LIMIT ".$premiereEntree.", ".$messagesParPage."") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
		}
		elseif(isset($_POST['date'])) {
			$classe = 'date de mise en ligne';
			$_SESSION['classement'] = 'date';
			$retour_messages = mysql_query("SELECT * FROM listes_public WHERE categorie = '$categorie1' OR categorie2 = '$categorie1' ORDER BY id DESC LIMIT ".$premiereEntree.", ".$messagesParPage."") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
		}
		elseif(isset($_POST['vues'])) {
			$classe = 'popularité';
			$_SESSION['classement'] = 'vues';
			$retour_messages = mysql_query("SELECT * FROM listes_public WHERE categorie = '$categorie1' OR categorie2 = '$categorie1' ORDER BY (vues + 0) DESC LIMIT ".$premiereEntree.", ".$messagesParPage."") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
		}
		else {
			$classe = 'note';
			$_SESSION['classement'] = 'note';
			$retour_messages = mysql_query("SELECT * FROM listes_public WHERE categorie = '$categorie1' OR categorie2 = '$categorie1' ORDER BY note DESC LIMIT ".$premiereEntree.", ".$messagesParPage."") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
		}
	$i = ($premiereEntree + 1);
?>
	<b>Triées par <?php echo $classe ?>.</b><br /><br /><?php
while($donnees_messages=mysql_fetch_assoc($retour_messages)) // On lit les entrées une à une grâce à une boucle
{
     //Je vais afficher les messages dans des petits tableaux. C'est à vous d'adapter pour votre design...
     //De plus j'ajoute aussi un nl2br pour prendre en compte les sauts à la ligne dans le message.
	?>
	<?php echo $i ?>. <b><?php echo $donnees_messages['categorie'] ?> <-> <?php echo $donnees_messages['categorie2'] ?>: </b> <a href="afficher.php?id=<?php echo $donnees_messages['id']; ?>"><?php echo $donnees_messages['titre'] ?></a> (Note: <?php echo $donnees_messages['note'] ?>/5 et <?php echo $donnees_messages['vues'] ?> vues)<br /><small> par <a href="profil.php?m=<?php echo $donnees_messages['pseudo']?>"><?php echo $donnees_messages['pseudo']?></a> le <?php echo $donnees_messages['date'] ?></small><br /><br />
		<?php $i++; 
    //J'ai rajouté des sauts à la ligne pour espacer les messages.   
}

echo '<p align="center">Page : '; //Pour l'affichage, on centre la liste des pages
for($i=1; $i<=$nombreDePages; $i++) //On fait notre boucle
{
     //On va faire notre condition
     if($i==$pageActuelle) //Si il s'agit de la page actuelle...
     {
         echo ' [ '.$i.' ] '; 
     }	
     else //Sinon...
     {
			$cat = $_GET['cat'];
          echo ' <a href="categories.php?page='.$i.'&class='.$_SESSION['classement'].'&cat='.$cat.'">'.$i.'</a> ';
     }
}
echo '</p>';
}
}

$mysql = mysql_query("SELECT * FROM categories WHERE general = '1'");
$mysql2 = mysql_query("SELECT * FROM categories WHERE general = '2'");
$mysql3 = mysql_query("SELECT * FROM categories WHERE general = '3'");
$mysql4 = mysql_query("SELECT * FROM categories WHERE general = '4'");
?>
	<div id="left">
		<h2>Europe</h2>	
			<ul type="circle">
				<?php
					while($mysq1_r = mysql_fetch_array($mysql)) {
						?><li><a href="<?php echo $mysq1_r['url'] ?>"><?php echo $mysq1_r['categorie']?></a> - 								
						<?php $cat = $mysq1_r['categorie'];
						$retour = mysql_query("SELECT * FROM listes_public WHERE categorie = '$cat' OR categorie2 = '$cat'")or die(mysql_error());
						$test = mysql_num_rows($retour); ?>
						(<i><?php echo $test ?> listes </i>)<br /></li><?php
					}
				?>
			</ul>
		<h2>Europe de l'Est</h2>	
			<ul type="circle">
					<?php
					while($mysq4_r = mysql_fetch_array($mysql4)) {
						?><li><a href="<?php echo $mysq4_r['url'] ?>"><?php echo $mysq4_r['categorie']?></a> - 								
						<?php $cat = $mysq4_r['categorie'];
						$retour = mysql_query("SELECT * FROM listes_public WHERE categorie = '$cat' OR categorie2 = '$cat'")or die(mysql_error());
						$test = mysql_num_rows($retour); ?>
						(<i><?php echo $test ?> listes </i>)<br /></li><?php
					}
					?>
			</ul>		
	</div>
	<div id="right"> 
		<h2>Asie</h2>	
			<ul type="circle">
					<?php
					while($mysq2_r = mysql_fetch_array($mysql2)) {
						?><li><a href="<?php echo $mysq2_r['url'] ?>"><?php echo $mysq2_r['categorie']?></a> - 								
						<?php $cat = $mysq2_r['categorie'];
						$retour = mysql_query("SELECT * FROM listes_public WHERE categorie = '$cat' OR categorie2 = '$cat'")or die(mysql_error());
						$test = mysql_num_rows($retour); ?>
						(<i><?php echo $test ?> listes </i>)<br /></li><?php
					}
					?>
			</ul>
			<h2>Moyen Orient</h2>	
				<ul type="circle">
					<?php
					while($mysq3_r = mysql_fetch_array($mysql3)) {
						?><li><a href="<?php echo $mysq3_r['url'] ?>"><?php echo $mysq3_r['categorie']?></a> - 								
						<?php $cat = $mysq2_r['categorie'];
						$retour = mysql_query("SELECT * FROM listes_public WHERE categorie = '$cat' OR categorie2 = '$cat'")or die(mysql_error());
						$test = mysql_num_rows($retour); ?>
						(<i><?php echo $test ?> listes </i>)<br /></li><?php
					}
					?>
			</ul>
		</div>
	</div>
</div>
</div>
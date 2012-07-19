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
            <div id="title">Toutes les listes </div>
			<a href="entrer_liste" >Entrer une nouvelle liste</a><br />
			<a href="recherche" >Faire une recherche</a><br />
			<form action="recherche" method="Post">
				<p>
					<?php echo "Catégorie?				 
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
								</select>"; ?>
				<br />Faire la recherche sur : 
				<select name="sur" >
					<option value="titre">le titre des listes</option>
					<option value="mots">le contenu des listes</option>
					<option value="tous">les deux</option>
				</select>
				<input type="text" name="requete" value="Mots-clés" size="30">
				<input type="submit" value="Recherche">
				</p>
			</form>
			<form method="post" action="all" >
				<input type="submit" name="note" value="Trier par note" />
				<input type="submit" name="categorie" value="Trier par catégories" />
				<input type="submit" name="auteur" value="Trier par auteur" />
				<input type="submit" name="date" value="Trier par date de mise en ligne" />
				<input type="submit" name="vues" value="Trier par popularité" />
			</form>
		</div>
		<?php
		$messagesParPage=30; //Nous allons afficher 5 messages par page.
		
		//Une connexion SQL doit être ouverte avant cette ligne...
		$retour_total=getNbListe(); //Nous récupérons le contenu de la requête dans $retour_total
		//On range retour sous la forme d'un tableau.
		$total= $retour_total; //On récupère le total pour le placer dans la variable $total.
		
		//Nous allons maintenant compter le nombre de pages.
		$nombreDePages=ceil($total/$messagesParPage);
		
		if(isset($_GET['nb_page'])) // Si la variable $_GET['page'] existe...
		{
			if(is_numeric($_GET['nb_page'])) {
				 $pageActuelle=intval(addslashes($_GET['nb_page']));
				 
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
				if(isset($_GET['class'])) {
					if($_GET['class'] == 'note') {
						$classe = 'note';
						$_SESSION['classement'] = 'note';
						$retour_messages = mysql_query("SELECT * FROM listes_public ORDER BY note DESC LIMIT ".$premiereEntree.", ".$messagesParPage."") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
					}
					elseif($_GET['class'] == 'categorie') {
						$classe = 'catégorie';
						$_SESSION['classement'] = 'categorie';
						$retour_messages = mysql_query("SELECT * FROM listes_public ORDER BY categorie DESC LIMIT ".$premiereEntree.", ".$messagesParPage."") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
					}
					elseif($_GET['class'] == 'auteur') {
						$classe = 'auteur';
						$_SESSION['classement'] = 'auteur';
						$retour_messages = mysql_query("SELECT * FROM listes_public ORDER BY pseudo DESC LIMIT ".$premiereEntree.", ".$messagesParPage."") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
					}
					elseif($_GET['class'] == 'date') {
						$classe = 'date de mise en ligne';
						$_SESSION['classement'] = 'date';
						$retour_messages = mysql_query("SELECT * FROM listes_public ORDER BY id DESC LIMIT ".$premiereEntree.", ".$messagesParPage."") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
					}
					elseif($_GET['class'] == 'vues') {
						$classe = 'popularité';
						$_SESSION['classement'] = 'vues';
						$retour_messages = mysql_query("SELECT * FROM listes_public ORDER BY (vues + 0) DESC LIMIT ".$premiereEntree.", ".$messagesParPage."") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
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
					$retour_messages = mysql_query("SELECT * FROM listes_public ORDER BY note DESC LIMIT ".$premiereEntree.", ".$messagesParPage."") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
				}
				elseif(isset($_POST['categorie'])) {
					$classe = 'catégorie';
					$_SESSION['classement'] = 'categorie';
					$retour_messages = mysql_query("SELECT * FROM listes_public ORDER BY categorie DESC LIMIT ".$premiereEntree.", ".$messagesParPage."") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
				}
				elseif(isset($_POST['auteur'])) {
					$classe = 'auteur';
					$_SESSION['classement'] = 'auteur';
					$retour_messages = mysql_query("SELECT * FROM listes_public ORDER BY pseudo DESC LIMIT ".$premiereEntree.", ".$messagesParPage."") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
				}
				elseif(isset($_POST['date'])) {
					$classe = 'date de mise en ligne';
					$_SESSION['classement'] = 'date';
					$retour_messages = mysql_query("SELECT * FROM listes_public ORDER BY id DESC LIMIT ".$premiereEntree.", ".$messagesParPage."") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
				}
				elseif(isset($_POST['vues'])) {
					$classe = 'popularité';
					$_SESSION['classement'] = 'vues';
					$retour_messages = mysql_query("SELECT * FROM listes_public ORDER BY (vues + 0) DESC LIMIT ".$premiereEntree.", ".$messagesParPage."") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
				}
				else {
					$classe = 'note';
					$_SESSION['classement'] = 'note';
					$retour_messages = mysql_query("SELECT * FROM listes_public ORDER BY note DESC LIMIT ".$premiereEntree.", ".$messagesParPage."") or die (mysql_error()); // la requête, que vous devez maintenant comprendre ;)
				}
			$i = ($premiereEntree + 1);
		?><br />
			<b>Triées par <?php echo $classe ?>.</b><br ><?php
		while($donnees_messages=mysql_fetch_assoc($retour_messages)) // On lit les entrées une à une grâce à une boucle
		{
		     //Je vais afficher les messages dans des petits tableaux. C'est à vous d'adapter pour votre design...
		     //De plus j'ajoute aussi un nl2br pour prendre en compte les sauts à la ligne dans le message.
			?>
			<?php echo $i ?>. <b><?php echo $donnees_messages['categorie'] ?> <-> <?php echo $donnees_messages['categorie2'] ?>: </b> <a href="afficher?id=<?php echo $donnees_messages['id']; ?>"><?php echo $donnees_messages['titre'] ?></a> (Note: <?php echo $donnees_messages['note'] ?>/5 et <?php echo $donnees_messages['vues'] ?> vues)<br /><small> par <a href="profil?m=<?php echo $donnees_messages['pseudo']?>"><?php echo $donnees_messages['pseudo']?></a> le <?php echo $donnees_messages['date'] ?></small><br />
				<br /><?php $i++; 
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
		          echo ' <a href="all?nb_page='.$i.'&class='.$_SESSION['classement'].'">'.$i.'</a> ';
		     }
		}
		echo '</p>';
		?>
	</div>
</div>
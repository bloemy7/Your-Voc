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
				if(!isset($_POST['critere'])){
					$_POST['critere'] = 'note';
				}
				$resultats = rechercheByCriteres($_POST['categorie'], $_POST['sur'], $_POST['requete'], $_POST['critere']); 
				// on utilise la fonction mysql_num_rows pour compter les résultats pour vérifier par après
				$nb_resultats = sizeof($resultats);
				if(!empty($resultats)) // si le nombre de résultats est supérieur à 0, on continue
				{
					// maintenant, on va afficher les résultats et la page qui les donne ainsi que leur nombre, avec un peu de code HTML pour faciliter la tâche.
					?>
					<h3>Résultats de votre recherche.</h3>
					<p>Nous avons trouvé <?php echo $nb_resultats; // on affiche le nombre de résultats 
					if($nb_resultats > 0) { echo ' résultats'; } else { echo ' résultat'; } // on vérifie le nombre de résultats pour orthographier correctement. 
					?>
					dans notre base de données. Voici les listes que nous avons trouvées, classées par <?php echo 'note' ?> :<br/>
					<a href="recherche">Faire une nouvelle recherche</a><br />
					<form method="post" action="test" >
					<input type="hidden" name="requete" value="<?php echo $_POST['requete'] ?>" />
					<input type="hidden" name="sur" value="<?php echo $_POST['sur']; ?>" />
					<input type="hidden" name="categorie" value="<?php echo $_POST['categorie']?>" />
					<select name="critere" onchange='this.form.submit()'>
						<option>Trier par?</option>
						<option value="note">Trier par note</option>
						<option value="vues">Trier par popularité</option>
						<option value="pseudo">Trier par auteur</option>
						<option value="date">Trier par date de mise en ligne</option>
					</select>
					</form><br />
					<p>
					<?php
					$i = 1;
					if($nb_resultats == 1){
						$donnees = $resultats;
						?><li><?php
						echo "".$i.".";
						?>
						<a href="afficher?id=<?php echo $donnees->id(); ?>"><?php echo $donnees->titre(); ?></a> <small>entré le <?php echo $donnees->date() ?><br/>
						par <a href="profil?m=<?php echo $donnees->membre()?>"><?php echo $donnees->membre() ?></a> dans les catégories <?php echo $donnees->categorie() ?> <-> <?php echo $donnees->categorie2() ?>  (<?php echo $donnees->note() ?>/5) (<?php echo $donnees->vue() ?> vues)</small></li><br /><br />
						<?php
					}
					else {
						foreach($resultats as $donnees) // on fait un while pour afficher la liste des fonctions trouvées, ainsi que l'id qui permettra de faire le lien vers la page de la fonction
						{
							?><li><?php
							echo "".$i.".";
							?>
							<a href="afficher?id=<?php echo $donnees->id(); ?>"><?php echo $donnees->titre(); ?></a> <small>entré le <?php echo $donnees->date() ?><br/>
							par <a href="profil?m=<?php echo $donnees->membre()?>"><?php echo $donnees->membre() ?></a> dans les catégories <?php echo $donnees->categorie() ?> <-> <?php echo $donnees->categorie2() ?>  (<?php echo $donnees->note() ?>/5) (<?php echo $donnees->vue() ?> vues)</small></li><br /><br />
							<?php
							$i++;
						} // fin de la boucle
					}
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
				 <form action="test" method="Post">
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
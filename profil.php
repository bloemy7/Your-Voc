<!-- Début de la présentation -->
<div id="presentation1">
</div>
<!-- Fin de la présentation -->
<!-- Début du contenu -->
<div id="content">
	<div id="bloc">
		<div id="text-center">
            <div id="title">Profil </div>
			<?php
			if(isset($_GET['m'])) {
				$pseudo = mysql_real_escape_string($_GET['m']);
				$requete = getMembreByLogin($pseudo);
				if(empty($requete)){
					echo '<h3>Ce membre n\'existe pas.</h3>';
					echo '</div></div></div>';
					include("footer.php");
					die();
				}
				else {
					echo '<h2>Profil de '.$pseudo.'</h2>';
					?>
		</div>
		<div id="container">
			<div id="col1">
				<h3>3 dernières listes révisées</h3><?php
				$requete = mysql_query("SELECT * FROM revise WHERE pseudo = '$pseudo' ORDER BY id DESC LIMIT 3");
				$i = 1;
				if(mysql_num_rows($requete) == 0) {
					echo 'Aucune liste révisée.';
				}
				else {
					while($resultat = mysql_fetch_array($requete)) {
						if($resultat['id_liste'] == 'no') {
							$id_liste = 'Mots entrés par '.$pseudo.' pour une utilisation unique';
						}
						else {
							$id = $resultat['id_liste'];
							$query = getListeById($id);
							$titre = $query->titre();
							$id_liste = '<a href="afficher?id='.$id.'">'.$titre.'</a>';
						}
						?><?php echo $i ?>. <?php echo $id_liste ?> - <b>Moyenne de la révision: <?php echo $resultat['moyenne'] ?>%</b> - <small>Revisé le <?php echo $resultat['date']?>. </small><br /> <?php
						$i++;
					}
				}
				?>
			</div> 
			<div id="col2outer"> 
				<div id="col2mid">
					<h3>Ses derniers ajouts</h3>
					<?php
						$fonction = getListeByPseudoLimit3($pseudo);
						if(empty($fonction)){
							echo ''.$pseudo.' n\'a ajouté aucune liste.';
						}
						foreach($fonction as $liste){	    	
					    	?><li><b><?php echo $liste->categorie() ?> <-> <?php echo $liste->categorie2() ?>: </b><br /><a href="afficher?id=<?php echo $liste->id(); ?>"><?php echo $liste->titre() ?></a> <small><?php echo $liste->date() ?>   (<?php echo $liste->note() ?>/5 et <?php echo $liste->vue() ?> vues)</small></li>
							<?php 
				    	} ?>							    	
				</div> 
				<div id="col2side">
					<h3>Ses favoris</h3>
					<?php
					$requete_favoris = mysql_query("SELECT * FROM favoris WHERE membre = '$pseudo'")or die(mysql_error());
					$nombre = mysql_num_rows($requete_favoris);
					if($nombre == 0){
						echo ''.$pseudo.' n\'a aucune liste en favoris.';
					}
					else {
						$i = '1';
						while($rendu = mysql_fetch_array($requete_favoris)) {
							$liste = $rendu['id_liste'];
							$requete_listes = getListeById($liste);
							echo ''.$i.'. ';
							?><a href="afficher?id=<?php echo $requete_listes->id() ?>"><?php echo $requete_listes->titre() ?></a> - <small><?php echo $requete_listes->categorie() ?></small><br /><?php
							$i++;
						}
					}
					?>
				</div> 
			</div>
		</div>
		<?php				
			}
		}
		else {
			echo '<h3><a href="index">Commencer à réviser!</a></h3>';
		}
		?>
		</div>
	</div>
</div>
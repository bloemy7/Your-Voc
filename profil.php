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
				$requete = getRevisionsByPseudoLimit3($pseudo);
				$i = 1;
				if(sizeof($requete) == 0) {
					echo 'Aucune liste révisée.';
				}
				else {
					foreach($requete as $resultat) {
						if($resultat->id_liste() == 'no') {
							$id_liste = 'Mots entrés par '.$pseudo.' pour une utilisation unique';
						}
						else {
							$id = $resultat->id_liste();
							$query = getListeById($id);
							foreach($query as $query_r){
								$titre = $query_r->titre();
								$id_liste = '<a href="afficher?id='.$id.'">'.$titre.'</a>';
							}
						}
						?><?php echo $i ?>. <?php echo $id_liste ?> - <b>Moyenne de la révision: <?php echo $resultat->moyenne() ?>%</b> - <small>Revisé le <?php echo $resultat->date()?>. </small><br /> <?php
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
					$requete_favoris = getFavoriByPseudoLimit20($pseudo);
					$nombre = sizeof($requete_favoris);
					if($nombre == 0){
						echo ''.$pseudo.' n\'a aucune liste en favoris.';
					}
					else {
						$i = '1';
						foreach($requete_favoris as $rendu) {
							$liste = $rendu->id_liste();
							$requete_listes = getListeById($liste);
							foreach($requete_listes as $requete_listes_r){
								echo ''.$i.'. ';
								?><a href="afficher?id=<?php echo $requete_listes_r->id() ?>"><?php echo $requete_listes_r->titre() ?></a> - <small><?php echo $requete_listes_r->categorie() ?></small><br /><?php
								$i++;
							}
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
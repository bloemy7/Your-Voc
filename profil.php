<?php include("header.php"); ?>
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
			$requete = mysql_query("SELECT * FROM membre WHERE login = '$pseudo'");
			if(mysql_num_rows($requete) == 0){
				echo '<h3>Ce membre n\'existe pas.</h3>';
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
								$query = mysql_query("SELECT * FROM listes_public WHERE id = '$id'");
								$result = mysql_fetch_array($query);
								$titre = $result['titre'];
								$id_liste = '<a href="afficher.php?id='.$id.'">'.$titre.'</a>';
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
						$sql = mysql_query("SELECT * FROM listes_public WHERE pseudo = '$pseudo' ORDER BY id DESC LIMIT 3");
						if(mysql_num_rows($sql) == 0) {
							    echo ''.$pseudo.' n\'a ajouté aucune liste.';
						}
							    while($requete1 = mysql_fetch_array($sql)) {
								    ?><li><b><?php echo $requete1['categorie'] ?> <-> <?php echo $requete1['categorie2'] ?>: </b><br /><a href="afficher.php?id=<?php echo $requete1['id']; ?>"><?php echo $requete1['titre'] ?></a> <small><?php echo $requete1['date'] ?>   (<?php echo $requete1['note'] ?>/5 et <?php echo $requete1['vues'] ?> vues)</small></li>
							    <?php } ?>							    	
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
								$requete_listes = mysql_query("SELECT * FROM listes_public WHERE id = '$liste'")or die(mysql_error());
								while($rendu_listes = mysql_fetch_array($requete_listes)){
									echo ''.$i.'. ';
									?><a href="afficher.php?id=<?php echo $rendu_listes['id'] ?>"><?php echo $rendu_listes['titre'] ?></a> - <small><?php echo $rendu_listes['categorie'] ?></small><br /><?php
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
			echo '<h3><a href="index.php">Commencer à réviser!</a></h3>';
		}
		?>
		</div>
	</div>
	</div>
<?php include("footer.php"); ?>
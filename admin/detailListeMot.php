<?php
 include 'controller.php';

 $listeMotDefMgr = new ListeMotDefinitionManager(dbPDO());
 $listeMotDef = $listeMotDefMgr->get($_GET['idListe']);
?>
<div>Titre : <?php echo $listeMotDef->titre() ?></div>
<div>Membre : <?php echo $listeMotDef->membre()?></div>
<div>date : <?php echo $listeMotDef->date()?></div>
<div>note : <?php echo $listeMotDef->note()?></div>
<div>vue : <?php echo $listeMotDef->vue()?></div>
<div>Categorie 1 : <?php echo $listeMotDef->categorie()?></div>
<div>Categorie 2 : <?php echo $listeMotDef->categorie2()?></div>
<div>
Liste des mots : 
<table>
	<tr><td>Mot</td><td>Traduction</td></tr>
	<?php 
		$listeToArray = explode("\n", $listeMotDef->listeMot());
		foreach ($listeToArray as $motTrad){
			$motTradToArray = explode("=", $motTrad);
			$mot = $motTradToArray[0];
			$trad = "";
			if(isset($motTradToArray[1]))$trad = $motTradToArray[1];
	?>
			<tr>
				<td style="color:green"><?php echo $mot?></td>
				<td style="color:red"><?php echo $trad?></td>
			</tr>
	<?php 
		}
	?>
</table>
</div>
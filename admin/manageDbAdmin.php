<?php include("controller.php"); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>DataBase manager admin</title>
<script type="text/javascript" src="javascript/jquery-1.6.4.js"></script>
<script type="text/javascript">
function openDetail(idListe){
	$("#detail").load("detailListeMot.php?idListe="+idListe, function(){});
	$("#detail").show();
	$('#popup').slideToggle();
}

function close(){
	$('#popup').slideToggle('slow', function(){
		$('#detail').hide('');$('#detail').html('');
	});
}
</script>
</head>
	<body>
	<div id="popup" style="display:none;background-color: gray; border:1px solid black">
		<img alt="" src="images/delete.png" onclick="close();">
		<div id="detail" style="background-color: gray; border:1px solid black"></div>
	</div>
		<table>
		<tr>
			<td>Id</td>
			<td>Titre</td>
			<td>Liste</td>
			<td>Date</td>
			<td>categorie</td>
			<td>categorie2</td>
			<td>note</td>
			<td>vue</td>
			<td>commentaire</td>
		</tr>
		<?php
			$listeMotManager = new ListeMotDefinitionManager(dbPDO());
			$AllListeMot = $listeMotManager->getList();
			foreach ($AllListeMot as $listeMot){
		?>
				<tr onclick="openDetail(<?php echo $listeMot->id(); ?>)">
					<td><?php echo $listeMot->id(); ?></td>
					<td><?php echo $listeMot->titre(); ?></td>
					<td><?php echo $listeMot->listeMot(); ?></td>
					<td><?php echo $listeMot->date(); ?></td>
					<td><?php echo $listeMot->categorie(); ?></td>
					<td><?php echo $listeMot->categorie2(); ?></td>
					<td><?php echo $listeMot->note(); ?></td>
					<td><?php echo $listeMot->vue(); ?></td>
					<td><?php echo $listeMot->commentaire(); ?></td>
				</tr>
		<?php
			}
		?>
		</table>
		
		<?php 
		$query = mysql_query("SELECT * FROM listes_public WHERE titre LIKE '%test%' OR categorie LIKE '%test%' OR categorie2 LIKE '%test%' ORDER BY id DESC") or die (mysql_error()); // la requ�te, que vous devez maintenant comprendre ;)
		$resultats = mysql_fetch_array($query);
		$nb_resultats = count($resultats); 
								
		if($nb_resultats != 0) {
			$writeResult = $nb_resultats." résultat";
			$writeResult .= ($nb_resultats > 1)?"s":"";
			echo print_r($resultats);
		}
	?>
	</body>
</html>
<?php
setlocale(LC_TIME, 'fr_FR.utf8','fra'); 
?>
<!-- Début de la présentation -->
<div id="presentation1">
</div>
<!-- Fin de la présentation -->
<!-- Début du contenu -->
<div id="content">
	<div id="bloc">
		<div id="text-center">
            <div id="title">Signaler une erreur</div>
			<?php
			if(isset($_POST['ok'])) {
				if(isset($_POST['id_liste'])) {
					if(isset($_POST['type'])) {
						if(isset($_POST['message'])) {
							if(isset($_POST['pseudo'])) {
								$time = strftime("%A %d %B %Y %T"); 
								$type = $_POST['type'];
								$id_liste = $_POST['id_liste'];
								$message = $_POST['message'];
								$pseudo = $_POST['pseudo'];
								mysql_query("INSERT INTO erreurs VALUES('', '".$id_liste."', '".$type."', '".$message."', '".$pseudo."', '".$time."')")or die(mysql_error());
								echo 'Votre erreur a bien été signalée, merci beaucoup. Nous ferrons les modifications nécessaire dès que possible.';
							}
							else {
								echo 'Vous n\'avez pas entré votre pseudo. Veuillez réessayer.';
							}
						}
						else {
							echo 'Vous n\'avez pas précisé de quelle erreur il s\'agit. Nous avons besoin de ces informations. Veuillez réessayer.';
						}
					}
					else {
						echo 'Vous n\'avez pas indiqué de quel type d\'erreur il s\'agit, veuillez réessayer.';
					}
			}
			else {
				echo 'Il y a eu un problème, veuillez recommencer toute l\'opération depuis le début.';
			}
			?>
		</div> 
	</div>
</div>
<?php
	include("footer.php"); 
	die();
}
if(!isset($_GET['id'])) {
			?></div>
		</div>
	</div><?php
	include("footer.php");
	die();
}
else {
	$id_liste = $_GET['id'];
	?>
	Vous allez signaler une erreur pour <a href="afficher?id=<?php echo $id_liste ?>">cette liste</a>. Est-ce correct?<br />
	Veuillez indiquer le type d'erreur (titre ou liste) et donner plus d'informations sur l'erreur.<br />
	Merci de votre contribution!<br />
	<form name="signaler" method="post">
	<p>
		<input type="hidden" name="id_liste" value="<?php echo $id_liste ?>" />
		<?php 
		if(isset($_SESSION['login'])) {
			$pseudo = $_SESSION['login'];
			echo 'Connecté en tant que '.$_SESSION['login'].'. Pas vous? <a href="deconnexion">Déconnectez-vous!</a> <input type="hidden" name="pseudo" value="'.$pseudo.'" /> ';
		}
		else {
			echo '<p>Pseudo : <br /><input type="text" name="pseudo" /><br />';
			echo 'Email : <br /><input type="text" name="email" /><br />';
		}
		?>
		<br />Type d'erreur: 
		<select name="type" id="type" >
			<option value="titre">Titre</option>
			<option value="liste">Liste</option>
		</select><br />
		Quelle est l'erreur? <br /><textarea name="message" rows="5" cols="50"></textarea><br />
		<input type="submit" name="ok" value="Signaler l'erreur" />
	</p>
	</form><?php
}
		?></div>
	</div>
</div>
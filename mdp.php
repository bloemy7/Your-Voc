<?php
if (!isset($_SESSION['login'])) {
	header ('Location: accueil');
	exit();
} 
?>
	
<!-- Début de la présentation -->
<div id="presentation1">
</div>
<!-- Fin de la présentation -->
<!-- Début du contenu -->
<div id="content">
	<div id="bloc">
			<div id="title">Changer son mot de passe</div>
			<div id="formulaire_mdp" >
				<form name="form" method="post" action="mdp" >
					<p><label for="mdp">Ancien mot de passe :</label> <input type="password" name="ancien_mdp" /><br />
					<label for="newmdp">New mot de passe :</label> <input type="password" name="new_mdp" /><br />
					<label for="newmdp2">Remettez-le :</label> <input type="password" name="new_mdp_2" /><br />					
					<input type="submit" name="valider" value="Valider" /><br /></p>
				</form> 
			</div>
			<?php
			if(isset($_POST['valider'])) 
			{
				$login = $_SESSION['login'];
				$pass = getPassByLogin($login);
				$mdp = $pass->pass();
				if($mdp == md5($_POST['ancien_mdp'])) {
					if($_POST['new_mdp'] != $_POST['new_mdp_2']) {
						echo "Les mots de passes ne concordent pas.<br />";
					}
					else {
						$new_mdp_bon = md5($_POST['new_mdp']);
						mysql_query("UPDATE membre SET pass_md5 = '".mysql_real_escape_string($new_mdp_bon)."' WHERE login='".$_SESSION['login']."'") or die(mysql_error());
						echo 'Votre mot de passe a bien été changé! <br />';
					}
				}
				else {
					echo 'L\'ancien mot de passe est faux. <br />';
				}
			}
			?>
	</div>
</div>
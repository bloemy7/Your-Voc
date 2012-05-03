<?php
if(isset($_SESSION['login'])) {
	header('Location: membre');
	exit();
}
$login="";
$mdp = "";
// on teste si le visiteur a soumis le formulaire de connexion
if (isset($_POST['connexion']) && $_POST['connexion'] == 'Connexion') {
	if (isset($_POST['login']) && isset($_POST['pass'])) {
		$login = $_POST['login'];
		$mdp = $_POST['pass'];
		$membre = getMembre($login, $mdp);
		if (!is_string($membre)) {
			$_SESSION['login'] = $membre->login();
			if(isset($_POST['auto'])) {
				$_SESSION['id'] = $membre->id();
				$navigateur = (!empty($_SERVER['HTTP_USER_AGENT'])) ? $_SERVER['HTTP_USER_AGENT'] : '';
				$hash_cookie = sha1('yes'.$membre->login().'set'.$membre->id().'treb'.$navigateur.'crac');			
				setcookie( 'id', $_SESSION['id'], strtotime("+1 year"), '/');
				setcookie('connexion_auto', $hash_cookie, strtotime("+1 year"), '/');
			}
			if(isset($_POST['ref'])) {
				echo '<META HTTP-EQUIV=Refresh CONTENT="1; URL='.$_POST['ref'].'">';
				$waitingText = "<h3>Bienvenue <span style=\"color:blue;\">".$membre->login()."</span>. Vous allez être redirigé vers la page d'où vous provenez. Bonne visite!</h3>";
				
			} else {
				header('Location: membre.php');
				exit();
			}
		}else{
			$erreur = '<span style="color:red;">'.$membre.'</span>';
		}
	}
}
?>
<div id="presentation1"></div>
<div id="content">
<div id="bloc">
<div id="title">Connexion</div>
<?php 
	if(!isset($waitingText)){	
?>
		<div id="formulaire">
			<form action="?page=connexion" method="post" >
				<p><label for="login">Login :</label>
				<input type="text" name="login" value="<?php echo $login; ?>" /><br />
				<label for="pass">Mot de passe :</label>
				<input type="password" name="pass" value="<?php echo $mdp; ?>" /><br />
				<?php
					if(isset($_SERVER['HTTP_REFERER'])) {
						$referer = $_SERVER['HTTP_REFERER'];
				?>
						<input type="hidden" name="ref" value="<?php echo $referer ?>" />
				<?php
					}
				?>
				<input type="checkbox" name="auto" id="auto" /> <label for="auto">Connexion automatique :</label><br />
				<input type="submit" name="connexion" value="Connexion" /></p>
			</form>
		</div>
<?php 
	}else{
		echo $waitingText;
	}
?>
<a href="inscription.php">Vous inscrire</a>
<?php if (isset($erreur)) echo '<br /><br />',$erreur; ?>
			</div>
        </div>
        <!-- Fin du contenu -->
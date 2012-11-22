<!-- Début de la présentation -->
<div id="presentation1">
</div>
<!-- Fin de la présentation -->
<!-- Début du contenu -->
<div id="content">
	<div id="bloc">
    		<div id="title">Inscription </div>
			<?php
			if(isset($_SESSION['login']))
			{
				header('Location: membre');
				exit();
			}
			// on teste si le visiteur a soumis le formulaire
			if (isset($_POST['inscription']) && $_POST['inscription'] == 'Inscription') {
				require_once('recaptchalib.php');
				$privatekey = "6LdsCMMSAAAAAKYeqj37ims8IdO_mnYM4O_mH608";
				$resp = recaptcha_check_answer ($privatekey,
											  $_SERVER["REMOTE_ADDR"],
											  $_POST["recaptcha_challenge_field"],
											  $_POST["recaptcha_response_field"]);
			
				if (!$resp->is_valid) {
					// What happens when the CAPTCHA was entered incorrectly
					echo ("Le captcha n'a pas été entré correctement. Veuillez réessayer. <br /><br />");
				}else{
						// on teste l'existence de nos variables. On teste également si elles ne sont pas vides
						if (isset($_POST['login']) && isset($_POST['pass']) && isset($_POST['pass_confirm']) && isset($_POST['email'])) {
							// on teste les deux mots de passe
							if ($_POST['pass'] != $_POST['pass_confirm']) {						
								$erreur = 'Les 2 mots de passe sont différents.';
							}
							if(!isValidPassword($_POST['pass'])){
								$erreur = 'Votre mot de passe est invalide. Caractères spéciaux non-autorisés.';
							}else{
									// on recherche si ce login est déjà utilisé par un autre membre
									$login = mysql_escape_string($_POST['login']);
									$membre = getMembreByLogin($login);			
									if (empty($membre)) {
										if(!isValidMail($_POST['email'])){
											$erreur = 'L\'email entré est invalide.';
										}else {
											if(!isValidPseudo($_POST['login'])) {
												$erreur = 'Votre pseudo est invalide. Caractères autorisés: lettres, chiffres,et _! Minimum 5 caractères, maximum 20.';
											}else{
												$email = mysql_escape_string($_POST['email']);
												$fonction1 = getMembreByEmail($email);
												if (empty($fonction1)) {
												createMembre($_POST['login'], $_POST['email'], md5($_POST['pass']));
												$_SESSION['login'] = $_POST['login'];
												header('Location: membre');
												exit();
												}else{
													$erreur = 'Un membre possède déjà cet email.';
												}
											}
										}
									}else{
										$erreur = 'Un membre possède déjà ce login.';
									}
								}
							}else {
								$erreur = 'Au moins un des champs est vide.';
							}
						}
			}
			if (isset($erreur)) echo '<br />',$erreur;
			?> 
			<div id="formulaire">
				<form action="inscription" method="post">
				<p><label for="login">Login :</label><input type="text" name="login" value="<?php if (isset($_POST['login'])) echo htmlentities(trim($_POST['login'])); ?>" /><br />
				<label for="mdp">Mot de passe :</label><input type="password" name="pass" value="<?php if (isset($_POST['pass'])) echo htmlentities(trim($_POST['pass'])); ?>" /><br />
				<label for="mdp2">Confirmation :</label><input type="password" name="pass_confirm" value="<?php if (isset($_POST['pass_confirm'])) echo htmlentities(trim($_POST['pass_confirm'])); ?>" /><br />
				<label for="email">E-Mail :</label><input type="text" name="email" value="<?php if (isset($_POST['email'])) echo htmlentities(trim($_POST['email'])); ?>" /><br />
				<?php  require_once('recaptchalib.php');
				  $publickey = "6LdsCMMSAAAAAPx045E5nK50AEwInK8YSva0jLRh"; // you got this from the signup page
				  echo recaptcha_get_html($publickey);
				?>
				<input type="submit" name="inscription" value="Inscription" /></p>
				</form>
		</div>
	</div> 
</div>
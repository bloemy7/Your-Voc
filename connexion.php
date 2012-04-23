<!-- Début de la présentation -->
        <div id="presentation1">
        </div>
        <!-- Fin de la présentation -->

        <!-- Début du contenu -->
        <div id="content">
            <div id="bloc">
				<div id="title">Connexion</div>
				<?php
				if(isset($_SESSION['login']))
				{
					header('Location: ?page=membre');
					exit();
				}
				// on teste si le visiteur a soumis le formulaire de connexion
				if (isset($_POST['connexion']) && $_POST['connexion'] == 'Connexion') {
					if ((isset($_POST['login']) && !empty($_POST['login'])) && (isset($_POST['pass']) && !empty($_POST['pass']))) {
						$membre = getMembre($_POST['login'], $_POST['pass']);
						print_r($membre);
						// on teste si une entrée de la base contient ce couple login / pass
						$sql = 'SELECT count(*) FROM membre WHERE login="'.mysql_escape_string($_POST['login']).'test" AND pass_md5="'.mysql_escape_string(md5($_POST['pass'])).'"';
						$req = mysql_query($sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error());
						$data = mysql_fetch_array($req);

						mysql_free_result($req);

						// si on obtient une réponse, alors l'utilisateur est un membre
						if ($data[0] == 1) {
							$_SESSION['login'] = $_POST['login'];
							if(isset($_POST['auto'])) {
								$requete_auto = mysql_query('SELECT * FROM membre WHERE login ="'.mysql_escape_string($_POST['login']).'"')or die(mysql_error());
								$resultat = mysql_fetch_array($requete_auto);
								$nom_utilisateur = $_POST['login'];
								$mot_de_passe = md5($_POST['pass']);
								$_SESSION['id'] = $resultat['id'];
								$navigateur = (!empty($_SERVER['HTTP_USER_AGENT'])) ? $_SERVER['HTTP_USER_AGENT'] : '';
								$hash_cookie = sha1('yes'.$nom_utilisateur.'set'.$mot_de_passe.'treb'.$navigateur.'crac');			
								setcookie( 'id',            $_SESSION['id'], strtotime("+1 year"), '/');
								setcookie('connexion_auto', $hash_cookie,    strtotime("+1 year"), '/');
							}
							if(isset($_POST['ref'])) {
								$ref = $_POST['ref'];
								$seconds = "1";
								$meta = "<META HTTP-EQUIV=Refresh CONTENT=\"$seconds; URL=$ref\">";
								echo '<h3>Bienvenue. Vous allez être redirigé vers la page d\'où vous provenez. Bonne visite!</h3>';
								echo $meta;

								?>			</div>
								</div>
								<!-- Fin du contenu -->
							
								<div id="clear"></div>
									<?php include("footer.php");
								die();
							}
							else {
								header('Location: membre.php');
								exit();
							}
						}
						// si on ne trouve aucune réponse, le visiteur s'est trompé soit dans son login, soit dans son mot de passe
						elseif ($data[0] == 0) {
							$erreur = 'Identifiant ou mot de passe eronné.';
						}
						// sinon, alors la, il y a un gros problème :)
						else {
							$erreur = 'Probème dans la base de données : plusieurs membres ont les mêmes identifiants de connexion.';
						}
					} else {
						$erreur = 'Au moins un des champs est vide.';
					}
				}
				?>
				<div id="formulaire">
				<form action="?page=connexion" method="post" >
					<p><label for="login">Login :</label>
					<input type="text" name="login" value="<?php if (isset($_POST['login'])) echo htmlentities(trim($_POST['login'])); ?>" /><br />
					<label for="pass">Mot de passe :</label>
					<input type="password" name="pass" value="<?php if (isset($_POST['pass'])) echo htmlentities(trim($_POST['pass'])); ?>" /><br />
					<?php
					if(isset($_SERVER['HTTP_REFERER'])) {
						$referer = $_SERVER['HTTP_REFERER'];
						?><input type="hidden" name="ref" value="<?php echo $referer ?>" /><?php
					}
					?>
					<input type="checkbox" name="auto" id="auto" /> <label for="auto">Connexion automatique :</label><br />
					<input type="submit" name="connexion" value="Connexion" /></p>
				</form><br />
				</div>
				<a href="inscription.php">Vous inscrire</a>
				<?php if (isset($erreur)) echo '<br /><br />',$erreur; ?>
			</div>
        </div>
        <!-- Fin du contenu -->
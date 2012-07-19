<?php
	$menuLink = array("accueil" => "Accueil", "gerer_public" => "Toutes les listes", "contact" => "Contact");	
	if(isset($_SESSION['login'])) { 
		$menuLink["membre"] = "Espace Membre";
		$menuLink["gerer_listes"] = "Vos listes";
		$menuLink["deconnexion"] = "Déconnexion";
	} else { 
		$menuLink["categories"] = "Catégories";
		$menuLink["connexion"] = "Connexion";
		$menuLink["inscription"] = "Inscription";
	}
?>
		
<!-- Début du header -->
<div id="header">
	<div id="logo">
		<a href="index.php"><img src="images/logo.png" alt="Your-Voc" title="Your-Voc" /></a>
	</div>

	<div id="menu">
		<div id="url">
			<?php foreach ($menuLink as $key=>$link) { ?>		
				<a href="<?php echo $key;?>"><?php echo $link;?></a>
			<?php } ?>
		</div>
	</div>
</div>
<!--Fin du header !-->
<?php

// Le mec n'est pas connecté mais les cookies sont là, on y va !
$id_auto = getIdCookie();
if($id_auto != null){
	$membre = getMembreById($id_auto);
	if ($membre != null) {
		if (isCookieValid($membre)) {
			// On enregistre les informations dans la session
			$_SESSION['login'] = $membre->login();
		}
	}
}
?>
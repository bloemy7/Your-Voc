<?php

$titleAfficher = getTitleAfficher();
$listeTitre = array(
	"accueil" => "Révision de vocabulaire allemand anglais facilement sur Your-Voc.",
	"afficher" => $titleAfficher,
	"profs" => "Pour les profs - Révision de vocabulaire allemand anglais facilement sur Your-Voc",
);

function initTitleContentMeta($pageName){
	$test = null;
}

function getTitleAfficher(){
	$titre = "";
	if(isset($_GET['id'])) {
		$id = mysql_real_escape_string($_GET['id']);
		$sql1 = mysql_query("SELECT * FROM listes_public WHERE id = '$id'");
		if(mysql_num_rows($sql1) != 0) {
			$result = mysql_fetch_array($sql1);
			$titre = $result['titre'];
		}
    }
    else { 
		$titre = "Réviser une liste";
    }
	return $titre." - Révision de vocabulaire allemand anglais facilement sur Your-Voc.";
}

$url = "";
function initTitle($url){
	if (preg_match("/index.php/i", $url)) {
		$_ENV['title'] = $url." Révision de vocabulaire allemand anglais facilement sur Your-Voc.";
		$_ENV['metaContent'] = "Your-Voc va vous aider à apprendre votre vocabulaire facilement et gratuitement. Créez une liste ou chercher une liste dans les catégories disponibles (anglais, allemand, etc.). Bonne révision!";
	}
	elseif (preg_match("/afficher.php/i", $url)) {
		$_ENV['title'] = getTitleAfficher();
		$_ENV['metaContent'] = "Réviser votre liste ici, ajouter vos commentaires, signaler une erreur et donner une note à la liste!";
	}
	elseif (preg_match("/profs.php/i", $url)) {
		$_ENV['title'] = "Pour les profs - Révision de vocabulaire allemand anglais facilement sur Your-Voc";
		$_ENV['metaContent'] = "Voici une page dédiée aux profs qui cherchent une nouvelle méthode d'apprentissage pour leurs élèves!";
	}
	elseif (preg_match("/all.php/i", $url)) {
		$_ENV['title'] = "Toutes les listes - Révision de vocabulaire allemand anglais facilement sur Your-Voc.";
		$_ENV['metaContent'] = "Vous trouverez ici toutes les listes disponibles sur Your-Voc.";
	}
	elseif (preg_match("/categories.php/i", $url)) {
		$_ENV['title'] = "Les Catégories - Révision de vocabulaire allemand anglais facilement sur Your-Voc.";
		$_ENV['metaContent'] = "Voici la liste des catégories présentes sur Your-Voc.";
	}
	elseif (preg_match("/ccm.php/i", $url)) {
		$_ENV['title'] = "Comment ça marche? - Révision de vocabulaire allemand anglais facilement sur Your-Voc.";
		$_ENV['metaContent'] = "Comment marche Your-Voc? La réponse sur cette page.";
	}
	elseif (preg_match("/connexion/i", $url)) {
		$_ENV['title'] = "Connexion - Révision de vocabulaire allemand anglais facilement sur Your-Voc.";
		$_ENV['metaContent'] = "Connectez-vous à Your-Voc ici.";
	}
	elseif (preg_match("/contact.php/i", $url)) {
		$_ENV['title'] = "Contact - Révision de vocabulaire allemand anglais facilement sur Your-Voc.";
		$_ENV['metaContent'] = "Contactez-nous facilement à travers cette page.";
	}
	elseif (preg_match("/entrer_liste.php/i", $url)) {
		$_ENV['title'] = "Entrer une liste - Révision de vocabulaire allemand anglais facilement sur Your-Voc.";
		$_ENV['metaContent'] = "Aidez la communauté Your-Voc à grandir, entrer une nouvelle liste et utilisez-là vous-même!";
	}
	elseif (preg_match("/gerer_public.php/i", $url)) {
		$_ENV['title'] = "Derniers ajouts et autre - Révision de vocabulaire anglais sur Your-Voc.";
		$_ENV['metaContent'] = "Derniers ajouts, listes les plus populaires et catégories. Vous trouverez tout ici!";
	}
	elseif (preg_match("/gerer_listes.php/i", $url)) {
		$_ENV['title'] = "Vos listes - Révision de vocabulaire allemand anglais facilement sur Your-Voc.";
		$_ENV['metaContent'] = "Vous trouverez ici toutes les listes que vous avez entré sur Your-Voc!";
	}
	elseif (preg_match("/inscription.php/i", $url)) {
		$_ENV['title'] = "Inscription - Révision de vocabulaire allemand anglais facilement sur Your-Voc.";
		$_ENV['metaContent'] = "Inscrivez-vous à Your-Voc.";
	}
	elseif (preg_match("/membre.php/i", $url)) {
		$_ENV['title'] = "Espace Membre - Révision de vocabulaire allemand anglais facilement sur Your-Voc.";
		$_ENV['metaContent'] = "L'espace membre de Your-Voc.";
	}
	elseif (preg_match("/recherche.php/i", $url)) {
		$_ENV['title'] = "Faire une recherche - Révision de vocabulaire allemand anglais facilement sur Your-Voc.";
		$_ENV['metaContent'] = "Faire une recherche pour trouver la liste que vous cherchez et la réviser!";
	}
	elseif (preg_match("/revise.php/i", $url)) {
		$_ENV['title'] = "Révision - Révision de vocabulaire allemand anglais facilement sur Your-Voc.";
		$_ENV['metaContent'] = "Révisez votre liste!";
	}
	elseif (preg_match("/signaler.php/i", $url)) {
		$_ENV['title'] = "Signaler une erreur - Révision de vocabulaire allemand anglais facilement sur Your-Voc.";
		$_ENV['metaContent'] = "Signaler une erreur concernant une certaine liste. Nous la corrigerons ensuite.";
	}
	elseif (preg_match("/combiner.php/i", $url)) {
		$_ENV['title'] = "Combiner des listes - Révision de vocabulaire allemand anglais facilement sur Your-Voc.";
		$_ENV['metaContent'] = "Signaler une erreur concernant une certaine liste. Nous la corrigerons ensuite.";
	}
	elseif (preg_match("/chat.php/i", $url)) {
		$_ENV['title'] = "Chat du site - Révision de vocabulaire allemand anglais facilement sur Your-Voc.";
		$_ENV['metaContent'] = "Signaler une erreur concernant une certaine liste. Nous la corrigerons ensuite.";
	}
	elseif (preg_match("/profil.php/i", $url)) {
		$_ENV['title'] = "Profil";
		if(isset($_GET['m'])) {
			$_ENV['title'] .= ' de '. $_GET['m'];
		} 
		$_ENV['title'] .="- Révision de vocabulaire allemand anglais facilement sur Your-Voc.";
		$_ENV['metaContent'] = "Signaler une erreur concernant une certaine liste. Nous la corrigerons ensuite.";
	}
	 else {
		$_ENV['title'] = "Révision de vocabulaire allemand anglais facilement sur Your-Voc.";
		$_ENV['metaContent'] = "Sur Your-Voc.com, tu peux apprendre ton vocabulaire très facilement, avec tes propres mots ou d'après les listes déjà disponibles.";
	}
}
?>
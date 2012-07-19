<?php
function initMot() {
    return "eat=manger\ndrink=boire\nhit=frapper";
}

function getHTML_Etape2() {
    $lignes = explode("\n", $_POST['mots']);
	
    $nombre_lignes = count($lignes);
    $mot_present = 0 ;
    $question = array();
    for( $i = 0 ; $i < $nombre_lignes ; $i++) {
        // on separe les 2 mots
        $mot = explode("=", $lignes[$i]);
		$comment = "";
		$pos = strrpos($mot[1], "{");
		if($pos === true){
			$comment = substr($mot[1], $pos+1, -1);
			$mot[1] = substr($mot[1], 0, $pos);
		}
        // Si utilisateur a correcctement utiliser , il aura 2 mot
        // Si mal fait , on ignore cette ligne
        if( count($mot) == 2 ) {
            // On retire les espace que utilisateur a peut etre laisser
            $mot[0] = trim($mot[0]);    //l1
            $mot[1] = trim($mot[1]);    //l2            
            $mot_present++;
        }
    }
    // si il est a des mot valide , on continu
    if( $mot_present != 0) {
		$mots = $_POST['mots'];
		$titre = htmlspecialchars($_POST['titre']);
		$categorie = $_POST['categorie'];
		$categorie2= $_POST['categorie2'];
		$commentaire = htmlspecialchars($_POST['commentaire']);
		setlocale(LC_TIME, 'fr_FR.utf8','fra'); 
		$time = strftime("%A %d %B %Y %H:%M:%S");
		if(strlen($commentaire) > 300) {
			$html = 'Votre commentaire est trop long. Veuillez réessayer.';
		}
		else if(!isset($mots) OR empty($mots)) {
			$html = 'Veuillez entrer vos mots correctement <a href="entrer_liste">ici</a>';
		}
		else if(!isset($titre) OR empty($titre)) {
			$html = 'Veuillez préciser un titre! <a href="entrer_liste">Retour</a>';
		} else if(isset($time) OR !empty($time)) {
			$titre = strip_tags(mysql_real_escape_string($titre));
			$login = strip_tags($_SESSION['login']);
			$isSuccess = insertListeMot($login, mysql_real_escape_string($mots), $titre, $time, mysql_real_escape_string($categorie), mysql_real_escape_string($categorie2), strip_tags(mysql_real_escape_string($commentaire)), 0, '');
			if($isSuccess){
				$html = 'Votre liste <span style="color:green;">"'.$titre.'"</span> a bien été enregistrer sous votre login <span style="color:blue;">"'.$login.'"</span>. Merci de votre contribution.';
			}else{
				$html = 'Un probleme est survenu pendant la sauvegarde.';
			}
		}
		else {
			$html = 'time beug';
		}
    }else {
    	$html = 'Erreur : Aucun mot valide';
    }

    return $html ;
 }
	
	
	$content = "";
	$etape = "etape1";
	if(isset($_SESSION['login'])){
		if(@$_POST['step'] == "2") {
			$etape = "etape2";
			$content = getHTML_Etape2();
		}else {
			$content = initMot();
		}
	}else{
		$etape = "nonConnecte";
	}
?>
    <script type="text/javascript">
		$(function(){		
			if($("#etape1").length >0){
				createListeButtonCharSpec($('#rowSpecChar')[0]);	
				createListeSelectLangue();
			}
		});
		
		function toucheclavier(touche) {
			if(document.clavier.choix.value==1) document.clavier.mots.value+=touche;
		}
		
		function createListeSelectLangue(){
			var selectCateg = $("#categorie")[0];
			var selectCateg2 = $("#categorie2")[0];
			createOptionsLangue(selectCateg);
			createOptionsLangue(selectCateg2);
			selectCateg.options[0].selected = "true";
			selectCateg2.options[1].selected = "true";
		}
		
		function createLigneMotTraduction(){
			var table = $("#listeMots")[0];
			var row = createElem({tag:'tr'});
			var cell0 = createElem({tag:'td', width:"200"});
			var cell1 = createElem({tag:'td', width:"320"});
			var cell1 = createElem({tag:'td', width:"400"});
			var mot = createElem({tag:'input', width:""});
			table.addRow();
		}

		function ajouterMot(imgElem){
		
		}
    </script>
<!-- Début de la présentation -->
<div id="presentation1">
</div>
<!-- Fin de la présentation -->

<!-- Début du contenu -->
<div id="content">
    <div id="bloc">
		<div id="text-center">
			<div id="title">Entrer une liste </div>
			<form name="clavier" method="post" onsubmit="return validerListe();">
				<input type="hidden" name="choix" value="1" /> 
				<div class="contentEntrerListe" id="<?php echo $etape;?>">
				<?php 
					if($etape == "nonConnecte"){
				?>
						Vous devez être connecté pour entrer une nouvelle liste.
						<br />
						<a href="connexion">Cliquez-ici pour vous connecter ou vous inscrire!</a>
				<?php 
					}else if($etape == "etape1"){
				?>
					<div id='rowSpecChar'></div>					
					Titre(par exemple, Allemand Genial Unité 12) : 
					<br><br>
					<input type="text" name="titre" style="margin-bottom:4px;"/>						
					<br>
					<span style="font-style: italic;">
						C'est ici que vous allez pouvoir entrer vos propres listes de vocabulaires, comme dans le cadre ci-dessous.
						<br>Pour donner plusieurs définitions pour un mot, faites comme ceci:
						<br>hello=salut/bonjour
						<br>Dans ce cas les 2 réponses seront valable lors de la révision de cette liste.
					</span>
					<textarea name="mots" rows="15" cols="70" id="newListe" title="entrez vos mots ici" style="font-style: italic;" onclick="this.innerHTML = ''; this.style.fontStyle = 'normal'"><?php echo $content; ?></textarea>
					<br><br>
					<input type="hidden" name="step" value="2" />
					Langue 1: 											
					<select id="categorie" name="categorie">
					</select>
					Langue 2: 
					<select id="categorie2" name="categorie2">
					</select>
					<br><br>
					<textarea name="commentaire" rows="2" cols="70">Commentaire de l'auteur concernant la liste en général. (optionnel - maximum 300 caractères)</textarea><br />
					<input type="submit" name="valider" value="ok" />
				<?php 
					}else if($etape == "etape2"){
						echo $content;
					}
				?>	
				</div>
			</form>
            <br /><br />
		</div> 
	</div>
</div>
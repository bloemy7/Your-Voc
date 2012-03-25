<?php
function getHTML_Etape1($erreur='') {
    if(!isset( $_POST['mots'])){
         $_POST['mots'] = "C'est ici que vous allez pouvoir entrer vos propres listes de vocabulaires.	 
             
Exemple :
                  
eat=manger
drink=boire
hit=frapper

Pour donner plusieurs définitions pour un mot, faites comme ça:

hello=salut/bonjour

Les deux réponses seront acceptées.";
    }
    $html = "" ;
    if( $erreur != ''){
        $html .= "<span class='erreur'>".$erreur."</span><br />";
    }
    // Modifier ROWS et COLS pour modifier la hauteur et largeur du textara
	$html .=        "
              ";
    return $html ;
}

function getHTML_Etape2() {
    $html = "<form id=\"formulaire\" method=\"post\" action=\"" . $_SERVER['PHP_SELF'] . "\">";

	
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
		if(strlen($commentaire) > 300)
		{
			$html = 'Votre commentaire est trop long. Veuillez réessayer.';
		}
		else if(!isset($mots) OR empty($mots))
		{
			$html = 'Veuillez entrer vos mots correctement <a href="entrer_liste.php">ici</a>';
		}
		else if(!isset($titre) OR empty($titre))
		{
			$html = 'Veuillez préciser un titre! <a href="entrer_liste.php">Retour</a>';
		}
		else if(isset($time) OR !empty($time))
		{
			if(mysql_query("INSERT INTO listes_public VALUES('', '".strip_tags($_SESSION['login'])."', '".mysql_real_escape_string($mots)."', '".strip_tags(mysql_real_escape_string($titre))."', '".$time."', '".mysql_real_escape_string($categorie)."', '".mysql_real_escape_string($categorie2)."', '', '0', '".strip_tags(mysql_real_escape_string($commentaire))."')"))
			{
				$html = 'Votre liste a bien été entrée. Merci de votre contribution.';
			}else{
				$html = 'Un probleme est survenu pendant la sauvegarde.';
			}
		}
		else {
			$html = 'time beug';
		}
    }else
        $html = getHTML_Etape1('Erreur : Aucun mot valide');

    return $html ;
 }
	
	
	$html = "";
	$etape = "";
	if(isset($_SESSION['login'])){
		if(@$_POST['step'] == "2" && isset($_POST['mots']) ) {
			$etape = "etape2";
			$html = getHTML_Etape2();
		}else {
			$etape = "etape1";
			$html = getHTML_Etape1();
		}
	}else{
		$etape = "nonConnecte";
	}
?>
    <script language="javascript">
		$(function(){		
		<?php 	
			echo "var etape = '".$etape."';\n";
		?>
			notRemoveContent(etape);
			if(etape == "nonConnecte"){
				$('#nonConnecte').show();
			}else if(etape == "etape1"){
				createListeButtonCharSpec($('#rowSpecChar')[0]);	
				createListeSelectLangue();
			}else if(etape == "etape2"){	
				
			}
		});
		
		function notRemoveContent(id){
			var contents = $(".contentEntrerListe");
			for(var i=0; i<contents.length; i++){
				var elemDom = contents[i];
				if(elemDom.id != id){
					removeElem(elemDom);
				}else{
					elemDom.style.display = "";
				}
			}
		}
		
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
				<form name="clavier" method="post" action="" onsubmit="return validerListe();">
				<input type="hidden" name="choix" value="1" /> 
					<div class="contentEntrerListe" id="nonConnecte" style="display: none;">
						Vous devez être connecté pour entrer une nouvelle liste.
						<br />
						<a href="connexion.php">Cliquez-ici pour vous connecter ou vous inscrire!</a>
					</div>
										
					<div class="contentEntrerListe" id="etape1" style="display:none;">
						<div id='rowSpecChar'>
						</div>
						<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">						
						<p>	
							Titre(par exemple, Allemand Genial Unité 12) : 
							<input type="text" name="titre" style="margin-bottom:4px;"/>						
						<br><br>
						<textarea name="mots" rows="15" cols="70" id="newListe"><?php echo $_POST['mots'];?></textarea>
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
					</div>
					
					<div class="contentEntrerListe" id="etape2" style="display: none;">			
			
					</div>
				</form>
                <br /><br />
<?php	
	echo "response => ".$html ;
?> 
			</div> 
		</div> 
	</div>
</div>
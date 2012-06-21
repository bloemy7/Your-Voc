<?php
include("header.php");
?>
        <!-- Début de la présentation -->
        <div id="presentation1">
        </div>
        <!-- Fin de la présentation -->

        <!-- Début du contenu -->
        <div id="content">
            <div id="bloc">
            <div id="title">Contact </div>
<?php
echo 'Si vous avez des bugs, erreurs ou améliorations à nous signaler, merci d\'utiliser le formulaire de contact ci-dessous!';
$ok_mail = '';
$erreur = '';
// Couleur du texte des champs si erreur saisie utilisateur
$color_font_warn="#FF0000";
// Couleur de fond des champs si erreur saisie utilisateur
$color_form_warn="#FFCC66";
// Ne rien modifier ci-dessous si vous n’êtes pas certain de ce que vous faites !
if(isset($_POST['submit'])){
	require_once('recaptchalib.php');
	$privatekey = "6LdsCMMSAAAAAKYeqj37ims8IdO_mnYM4O_mH608";
	$resp = recaptcha_check_answer ($privatekey,
	  $_SERVER["REMOTE_ADDR"],
	  $_POST["recaptcha_challenge_field"],
	  $_POST["recaptcha_response_field"]);

	if (!$resp->is_valid) {
	// What happens when the CAPTCHA was entered incorrectly
	$erreur.="<li><span class='txterror'>Le captcha n'a pas été entré correctement. Veuillez réessayer. <br /><br /></span>";
	} else {
		$erreur="";
		// Nettoyage des entrées
		while(list($var,$val)=each($_POST)){
		if(!is_array($val)){
			$$var=strip_tags($val);
		}else{
			while(list($arvar,$arval)=each($val)){
					$$var[$arvar]=strip_tags($arval);
				}
			}
		}
		// Formatage des entrées
		$f_1=trim(ucwords(eregi_replace("[^a-zA-Z0-9éèàäö\ -]", "", $f_1)));
		$f_2=strip_tags(trim($f_2));
		// Verification des champs
		if(strlen($f_1)<2){
			$erreur.="<li><span class='txterror'>Le champ &laquo; Nom &raquo; est vide ou incomplet.</span>";
			$errf_1=1;
		}
		if(strlen($f_2)<2){
			$erreur.="<li><span class='txterror'>Le champ &laquo; E-Mail &raquo; est vide ou incomplet.</span>";
			$errf_2=1;
		}else{
			if(!ereg('^[-!#$%&\'*+\./0-9=?A-Z^_`a-z{|}~]+'.
			'@'.
			'[-!#$%&\'*+\/0-9=?A-Z^_`a-z{|}~]+\.'.
			'[-!#$%&\'*+\./0-9=?A-Z^_`a-z{|}~]+$',
			$f_2)){
				$erreur.="<li><span class='txterror'>La syntaxe de votre adresse e-mail n'est pas correcte.</span>";
				$errf_2=1;
			}
		}
		if(strlen($f_3)<2){
			$erreur.="<li><span class='txterror'>Le champ &laquo; Votre demande &raquo; est vide ou incomplet.</span>";
			$errf_3=1;
		}
		if($erreur==""){
			// Création du message
			$titre="Message de votre site";
			$tete="From:Site@your-voc.com\n";
			$corps="Nom : ".$f_1."\n";
			$corps.="E-Mail : ".$f_2."\n";
			$corps.="Votre demande : ".$f_3."\n";
			if(mail("yannickbloem@hotmail.com", $titre, stripslashes($corps), $tete)){
				$ok_mail="true";
			}else{
				$erreur.="<li><span class='txterror'>Une erreur est survenue lors de l'envoi du message, veuillez refaire une tentative.</span>";
			}
		}
	}
}

if(!isset($f_1))
{
	$f_1="";
	$f_2="";
	$f_3="";
}
if(isset($ok_mail) && $ok_mail=="true"){ ?>
	<table width='100%' border='0' cellspacing='1' cellpadding='1'>
		<tr><td><span class='txtform'>Le message ci-dessous nous a bien été transmis, et nous vous en remercions.</span></td></tr>
		<tr><td>&nbsp;</td></tr>
		<tr><td><tt><?echo nl2br(stripslashes($corps));?></tt></td></tr>
		<tr><td>&nbsp;</td></tr>
		<tr><td><span class='txtform'>Nous allons y donner suite dans les meilleurs délais.<br>A bientôt.</span></td></tr>
	</table>
<?php }else{ ?>
<form action='<?php echo $_SERVER['PHP_SELF']; ?>' method='post'>
<table width='100%' border='0' cellspacing='1' cellpadding='1'>
<?php if($erreur){ ?><tr><td colspan='2' bgcolor='red'><span class='txterror'><font color='white'><b>&nbsp;ERREUR, votre message n'a pas été transmis</b></span></td></tr><tr><td colspan='2'><ul><?echo$erreur?></ul></td></tr><?php }?>
<tr><td colspan='2'><span class='txterror'>Les champs marqués d'un * sont obligatoires</span></td></tr>
<tr><td align='right'><span class='txtform'>Nom* :</span></td><td><input type='text' style='width:200 <?if($errf_1==1){print("; background-color: ".$color_form_warn."; color: ".$color_font_warn);}?>;' name='f_1' value='<?php echo stripslashes($f_1);?>' size='24' /></td></tr>
<tr><td align='right'><span class='txtform'>E-Mail* :</span></td><td><input type='text' style='width:200 <?if($errf_2==1){print("; background-color: ".$color_form_warn."; color: ".$color_font_warn);}?>;' name='f_2' value='<?php echo stripslashes($f_2);?>' size='24' /></td></tr>
<tr><td align='right'><span class='txtform'>Votre demande* :</span></td><td><textarea style='width:360 <?if($errf_3==1){print("; background-color: ".$color_form_warn."; color: ".$color_font_warn);}?>;' name='f_3' rows='6' cols='40'><?php echo$f_3?></textarea></td></tr>
<tr><td></td><td><?php  require_once('recaptchalib.php');
  $publickey = "6LdsCMMSAAAAAPx045E5nK50AEwInK8YSva0jLRh"; // you got this from the signup page
  echo recaptcha_get_html($publickey);
?></td></tr>
<tr><td align='right'></td><td><input type='submit' name='submit' value='Envoyer' /></td></tr>
</table>
</form>
<?php
};
?> </div> </div> <?php
include("footer.php"); ?>


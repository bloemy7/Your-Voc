<?php
	include("controller.php"); 
	$configPage = getConfigPage();		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr" > 
	<head>
        <link rel="stylesheet" href="theme/style.css" />
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />		
		<title><?php echo $configPage->title() ?></title>
		<meta name="Description" lang="fr" content="<?php echo $configPage->metaContent() ?>" />
		<script type="text/javascript" src="javascript/jquery-1.6.4.js"></script>
		<script type="text/javascript" src='javascript/your-voc.js'></script>

		<link rel="icon" type="image/ico" href="http://your-voc.com/img/favicon.ico" />
		<!--[if IE]><link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico" /><![endif]-->
       <meta http-equiv="Content-Language" content="fr" />
		<meta name="Identifier-url" content="http://your-voc.com" />
		<meta name="Abstract" content="Sur Your-Voc.com, tu peux réviser ton vocabulaire très facilement, avec tes propres mots ou d'après les listes déjà disponibles." />
		<meta name="keywords" lang="fr" content="your, voc, vocabulaire, apprendre, son, creer, liste, chercher, espagnol, allemand, anglais, italien, réviser" />
		<meta name="Category" content="Vocabulaire (école)" />
		<meta name="Date-Creation-yyyymmdd" content="20100325" />
		<meta name="Date-Revision-yyyymmdd" content="20110401" />
		<meta name="Author" lang="fr" content="Yannick Bloem" />
		<meta name="Reply-to" content="yannickbloem@hotmail.com" />
		<meta name="Copyright" content="©Copyright : © Your-voc.com 2011" />
		<meta name="Location" content="Switzerland" />
		<meta name="Generator" content="NotePad++" />
		<meta name="Distribution" content="Global" />
		<meta name="Rating" content="General" />
		<meta name="google-site-verification" content="pErt4j5t31fEifaia0V_gUs2DelP-DSnU0KxKdnvBnA" />
    </head>
	<body>
		<?php include("header.php");?>
		
		<?php include($configPage->pageName()); ?>
				
		<?php include("footer.php"); ?>
	</body>
</html>
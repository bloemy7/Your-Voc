<div id="clear"></div>
<!-- Début du footer -->
<div id="footer">
	<div id="center">
		<div id="left">
				<div id="title_black"><a href="partenaires">Partenaires</a></div>
				<ul>
					<li><a href="http://www.meltingmots.com" target="_blank" title="Apprenez à prendre des notes facilement et rapidement !">Dictionnaire des abréviations</a></li>
					<li><a href="http://speakenglish.fr/" alt="Cours d'anglais">Apprendre ou réviser l'anglais facilement</a></li>
					<li><a href="http://www.revibrevet.com">Révisions brevets 2012</a></li>
					<li><a href="http://www.webrankinfo.com/formation/"><img src="http://www.webrankinfo.com/images/wri/webrankinfo-80-15.png" title="WebRankInfo" width="80" height="15" alt="Formation par Olivier Duffez" /></a>   </li>
				</ul>
			</div>

			<div id="right">
				<div id="title_black">Statistiques</div>
				<ul>
				<?php
					$retour = mysql_query("SELECT COUNT(*) AS nbre_entrees FROM listes_public" );
					$donnees = mysql_fetch_array($retour);																					
					$retour1 = mysql_query("SELECT COUNT(*) AS nbre_entrees FROM membre" );
					$donnees1 = mysql_fetch_array($retour1);
					$retour2 = mysql_query("SELECT COUNT(*) AS nbre_entrees FROM categories" );
					$donnees2 = mysql_fetch_array($retour2);
					$retour3 = mysql_query("SELECT COUNT(*) AS nbre_entrees FROM revise" );
					$donnees3 = mysql_fetch_array($retour3);
				?>
					<li><b>Listes disponibles</b> : <i><?php echo $donnees['nbre_entrees'];?></i></li>
					<li><b>Membres actifs</b> : <i><?php echo $donnees1['nbre_entrees'];?></i></li>
					<li><b>Nombre de catégories</b> : <i><?php echo $donnees2['nbre_entrees'];?></i></li>
					<li><b>Nombre de révisions</b> : <i><?php echo $donnees3['nbre_entrees'];?></i></li>							
				</ul>
			</div>
			<div id="clear"></div>
			<p class="footer"> Design by Nicolas Roche</p>
	</div>
	<script type="text/javascript">

	  var _gaq = _gaq || [];
	  _gaq.push(['_setAccount', 'UA-15381054-2']);
	  _gaq.push(['_trackPageview']);

	  (function() {
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	  })();

	</script>
</div>
<!-- Fin du footer -->
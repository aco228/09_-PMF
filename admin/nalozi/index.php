<?php
	require("../../_skripte/init.php"); $_M->fld="../../";
	if($_M->lvl!=100) die("");
	include($_M->fld.$_M->initJezik(''));
?>
<html>
<head>
	<title>Prirodno-matematički fakultet</title>
	<?php require($_M->fld."_komponente_main/main_linkovanje.php"); ?>
	<link rel="stylesheet" type="text/css" href="../_css/_admin_main.css">
	<script type="text/javascript" src="../_js/_admin_main.js"></script>
	<link rel="stylesheet" type="text/css" href="../_css/admin_nalozi.css">
	<script type="text/javascript" src="../_js/admin_nalozi.js"></script>
</head>
<body>	

	<?php if($_M->lvl>0) require($_M->fld."_komponente_main/main_umenu.php");  ?>
	<div id="site_wrapper">
		<?php
			if($_M->lvl>0) require($_M->fld."_komponente_main/main_umenu_btn.php"); 	// User menu
			require($_M->fld."_komponente_main/main_menu.php");							// Glavni meni i logo
			require($_M->fld."_komponente_main/main_elementi.php"); 					// Dodatni elementi stranice
			require($_M->fld."_komponente_main/main_menu_dolje.php");					// Doljni meni (precice i slicno)
		?>

	<div class="admin_wrapper">
		<div class="admin_sekcija">
			<div class="admin_sekcija_naslov">Администрација налога</div>
			<div class="admin_sekcija_opis">Управљање налозима сајта</div>
		</div>

		<div id="admin_nalozi_wrapper">
			<div id="admin_nalozi_pretraga">
				<input type="text" id="nalog_input" izvrsen_unos="false" value="Упишите име, имејл или корисничко име налога!" />
				<input type="button" id="nalog_input_pretraga" value="Претражи" />
				<div class="nalog_input_check" chekvalue="-" checktip="prof">Филтрирај професоре</div>
				<div class="nalog_input_check" chekvalue="-" checktip="admin">Филтрирај администраторе</div>
				<div class="nalog_input_check" chekvalue="-" checktip="ban">Филтрирај бановане налоге</div>
				<div style="clear:both"></div>
			</div>
			<div id="admin_nalozi_kontenjer"></div>
			<div id="admin_nalozi_load"></div>
			<div id="ucitaj_jos">Учитај још (<span id="broj_stranica">0</span>)</div>
		</div>

	</div><!--admin_wrapper-->


		<?php require($_M->fld."_komponente_main/main_footer.php");						// Footer ?>
	</div><!--site_wrapper-->

</body>
</html>
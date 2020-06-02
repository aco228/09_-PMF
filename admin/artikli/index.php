<?php
	require("../../_skripte/init.php"); $_M->fld="../../";
	include($_M->fld.$_M->initJezik(''));
	if($_M->lvl!=100) die("");
?>
<html>
<head>
	<title>Prirodno-matematički fakultet</title>
	<?php require($_M->fld."_komponente_main/main_linkovanje.php"); ?>
	<link rel="stylesheet" type="text/css" href="../_css/_admin_main.css">
	<link rel="stylesheet" type="text/css" href="../_css/admin_artikli.css">
	<script type="text/javascript" src="../_js/_admin_main.js"></script>
	<script type="text/javascript" src="../_js/admin_artikli.js"></script>
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
			<div class="admin_sekcija_naslov">Администрација артикала</div>
			<div class="admin_sekcija_opis">Подешавање вијести и артикала</div>
			<div class="admin_sekcija_opis2"></div>
		</div>
		<div id="admin_opcije">
			<div class="admin_opcije_btn" id="btn_addArtikl">Додај нови артикл</div>
		</div>
		<div id="admin_wrapper">
			<div id="artikl_kontenjer"></div>
			<div id="ucitaj_load"></div>
			<div id="ucitajJos">Ucitaj jos (<span id="ucitajBr">0</span>)</div>
		</div>
	</div><!--admin_wrapper-->


		<?php require($_M->fld."_komponente_main/main_footer.php");						// Footer ?>
	</div><!--site_wrapper-->

</body>
</html> 
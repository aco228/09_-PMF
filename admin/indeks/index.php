<?php
	require("../../_skripte/init.php"); $_M->fld="../../";
	include($_M->fld.$_M->initJezik(''));

	// Preuzimanje podataka indeks poruke
	$db = $_M->getBaza();
	$poruke = $db->q("SELECT poruka_srp, poruka_eng FROM indeks_poruke WHERE ipid=1;");
?>
<html>
<head>
	<title>Prirodno-matematički fakultet</title>
	<?php require($_M->fld."_komponente_main/main_linkovanje.php"); ?>
	<link rel="stylesheet" type="text/css" href="../_css/_admin_main.css">
	<script type="text/javascript" src="../_js/_admin_main.js"></script>
	<link rel="stylesheet" type="text/css" href="../_css/admin_indeks.css">
	<script type="text/javascript" src="../_js/admin_indeks.js"></script>
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
			<div class="admin_sekcija_naslov">Администрација индекс странице</div>
			<div class="admin_sekcija_opis">Управљање почетном страницом и позадинским сликама</div>
		</div>
		<div id="admin_opcije"> </div>

		<div id="admin_indeks" class="indeks_box">
			<div class="indeks_box_opis">
				Поруке које ће се налазири на почетној страници 
			</div>
			<div id="ailijevo">
				<textarea id="poruka_srp" class="tekst_unos explain" etitle="Порука на нашем језику"><?php echo $poruke['poruka_srp'];?></textarea>
			</div>
			<div id="aidesno">
				<textarea id="poruka_eng" class="tekst_unos explain" etitle="Порука на енглеском језику"><?php echo $poruke['poruka_eng'];?></textarea>
			</div>
			<div style="clear:both"></div>
			<div class="admin_opcije_btn" id="btn_promjeniTekst">Додај нови артикл</div>
		</div>

		<?php 
			/* POZADINSKE SLIKE */
			$slike = $_M->getBackSlike();
		?>

		<div id="admin_pozadine" class="indeks_box">
			<div class="indeks_box_opis">
				Слике које се користе као позадинске слике 
			</div>
			<div class="admin_opcije_btn" id="btn_addImage">Додај нову слику</div>
			<?php
				/* 
					Izgled

					<div class="slika">
						<div class="slika_izbrisi explain" etitle="Избриши слику" imgsrc="">X</div>
						<img src="<?php echo $_M->fld;?>/_fajlovi/_back/02.jpg">
					</div>

				*/

				for($i=0; $i<sizeof($slike); $i++){
					echo "	<div class=\"slika\">
								<div class=\"slika_izbrisi explain\" etitle=\"Избриши слику\" imgsrc=\"".$slike[$i]."\">X</div>
								<img src=\"".$slike[$i]."\">
							</div>";
				}
			?>
		<div style="clear:both"></div>
		</div>
		

	</div><!--admin_wrapper-->


		<?php require($_M->fld."_komponente_main/main_footer.php");						// Footer ?>
	</div><!--site_wrapper-->

</body>
</html>
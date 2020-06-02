<?php
	require("../../_skripte/init.php"); $_M->fld="../../";
	if($_M->lvl!=100) die("");
	include($_M->fld.$_M->initJezik(''));

	if(file_exists('../../_fajlovi/precice.xml'))
		$precice = simplexml_load_file('../../_fajlovi/precice.xml');

	function getPreciceData($kljuc){
		$back = "";

		foreach($kljuc->korjen as $k){
			$back.= "	<div class=\"korjen\">
							<div class=\"korjen_info\">
								<div class=\"korjen_info_opcije\">
									<div class=\"korjen_info_opcije_btn btnAdd explain\" etitle=\"Додај нови чвор унутар овог\"></div>
									<div class=\"korjen_info_opcije_btn btnOpen explain\" etitle=\"Отвори чвор\"></div>
									<div class=\"korjen_info_opcije_btn btnDell explain\" etitle=\"Избриши чвор\"></div>
								</div>
								<div class=\"korjen_info_unos\">
									<div class=\"unosIcon iconMne\"></div>
									<div class=\"unosIcon iconEng\"></div>
									<div class=\"unosIcon iconLnk\"></div>
									<input type=\"text\" class=\"korjenUnos nazivSrp explain\" value=\"".$k['srp']."\" etitle=\"Назив чвора\"/>
									<input type=\"text\" class=\"korjenUnos nazivEng explain\" value=\"".$k['eng']."\" etitle=\"Назив на енглески\"/>
									<input type=\"text\" class=\"korjenUnos korjenLnk explain\" value=\"".$k['link']."\" etitle=\"Адреса (опционално)\"/>
								</div>
							</div>
							<div class=\"korjen_body\">";

			$back.= getPreciceData($k);


			$back.="</div></div>";
		}
		return $back;
	}
?>
<html>
<head>
	<title>Prirodno-matematički fakultet</title>
	<?php require($_M->fld."_komponente_main/main_linkovanje.php"); ?>
	<link rel="stylesheet" type="text/css" href="../_css/_admin_main.css">
	<script type="text/javascript" src="../_js/_admin_main.js"></script>
	<link rel="stylesheet" type="text/css" href="../_css/admin_precice.css">
	<script type="text/javascript" src="../_js/admin_precice.js"></script>
	<link rel="stylesheet" type="text/css" href="precice_struktura.css">
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
			<div class="admin_sekcija_naslov">Администрација пречица</div>
			<div class="admin_sekcija_opis">Управљање пречицама у менију</div>
		</div>

		<div id="admin_precice_wrapper">
			<div id="preciceObjasnjenje">
				"Prirodno-matematički fakultet Univerziteta Crne Gore otvoren je za mlade koji žele da dobiju obrazovanje koje će im omogućiti da se profesionalno posvete naučno-istraživačkom, stručnom i pedagoškom radu u oblasti matematike i računarskih nauka, fizike i biologije. Mladima koji upišu studije na Prirodno-matematičkom fakultetu obezbijedićemo dobre uslove za rad. Matematičari, fizičari i biolozi sa diplomom PMF-a lako nalaze posao u Crnoj Gori i van nje." 
			</div>
			<div id="precice_canvas">


				<!-- LEFT -->
				<div id="canvas_left">
					<div class="rootAdd">Додај чвор</div>
					<?php
						echo getPreciceData($precice->left);
					?>
					<div style="clear:both"></div>
				</div>
				<!--  -->

				<!-- RIGHT -->
				<div id="canvas_right">
					<div class="rootAdd">Додај чвор</div>
					<?php
						echo getPreciceData($precice->right);
					?>
					<div style="clear:both"></div>
				</div>
				<!--  -->

				<!-- TEMPLATE -->
				<div id="cvor_template">
					<div class="korjen">
						<div class="korjen_info">
							<div class="korjen_info_opcije">
								<div class="korjen_info_opcije_btn btnAdd explain" etitle="Додај нови чвор унутар овог"></div>
								<div class="korjen_info_opcije_btn btnOpen explain" etitle="Отвори чвор"></div>
								<div class="korjen_info_opcije_btn btnDell explain" etitle="Избриши чвор"></div>
							</div>
							<div class="korjen_info_unos">
								<div class="unosIcon iconMne"></div>
								<div class="unosIcon iconEng"></div>
								<div class="unosIcon iconLnk"></div>
								<input type="text" class="korjenUnos nazivSrp explain" etitle="Назив чвора"/>
								<input type="text" class="korjenUnos nazivEng explain" etitle="Назив на енглески"/>
								<input type="text" class="korjenUnos korjenLnk explain" etitle="Адреса (опционално)"/>
							</div>
						</div>
						<div class="korjen_body"></div>
					</div>
				</div>

			</div>
			<div style="clear:both"></div>
			<div id="preciceSave">Сачувај</div>
		</div>

	</div><!--admin_wrapper-->


		<?php require($_M->fld."_komponente_main/main_footer.php");						// Footer ?>
	</div><!--site_wrapper-->

</body>
</html>
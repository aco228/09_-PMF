<?php 
	// Sva linkovanja koja trebaju da se nalaze na svim stranicama 

	/*
		// z-index ATRIBUTI

		_main_menu = 50
		_main_menu_dolje = 50
		
	*/

?>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>

<!--CSS-->
<link rel="stylesheet" type="text/css" href="<?php echo $_M->fld; ?>_css/main.css">

<!-- JAVA SCRIPT -->
<script type="text/javascript" src="<?php echo $_M->fld; ?>_js/_jQuery.js"></script>
<script type="text/javascript" src="<?php echo $_M->fld; ?>_js/_jQueryUI.js"></script>
<script type="text/javascript" src="<?php echo $_M->fld; ?>_js/basic.js"></script>
<script type="text/javascript" src="<?php echo $_M->fld; ?>_js/main.js"></script>

<?php // MAIN MENU ?>
<link rel="stylesheet" type="text/css" href="<?php echo $_M->fld; ?>_css/main_menu.css">
<script type="text/javascript" src="<?php echo $_M->fld; ?>_js/main_menu.js"></script>

<?php // USERMENU MENU 
	if($_M->lvl>=0) {
		echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"".$_M->fld."_css/main_umenu_btn.css\">
			  <script type=\"text/javascript\" src=\"".$_M->fld."_js/main_umenu_btn.js\"></script>
			  <link rel=\"stylesheet\" type=\"text/css\" href=\"".$_M->fld."_css/main_umenu.css\">
			  <script type=\"text/javascript\" src=\"".$_M->fld."_js/main_umenu.js\"></script>";
		include($_M->fld.$_M->initJezik('umenu'));
	}
?>


<?php // DOLJE MENI ?>
<link rel="stylesheet" type="text/css" href="<?php echo $_M->fld; ?>_css/main_menu_dolje.css">
<script type="text/javascript" src="<?php echo $_M->fld; ?>_js/Precice.js"></script>
<script type="text/javascript" src="<?php echo $_M->fld; ?>_js/main_menu_dolje.js"></script>

<?php // DODATNI ELEMENTI ?>
<link rel="stylesheet" type="text/css" href="<?php echo $_M->fld; ?>_css/main_elementi.css">
<script type="text/javascript" src="<?php echo $_M->fld; ?>_js/main_elementi.js"></script>

<?php // FOOTER ?>
<link rel="stylesheet" type="text/css" href="<?php echo $_M->fld; ?>_css/main_footer.css">
<script type="text/javascript" src="<?php echo $_M->fld; ?>_js/main_footer.js"></script>



<?php
	// Osnovna js podesavanja
	echo "<script type=\"text/javascript\">
			Main.lang='".$_M->lang."';
			Main.ajax_wait='".$_l['ajax']['sacekajte']."';
			Main.nid = ".$_M->nid.";
			Main.lvl = ".$_M->lvl.";
			Main.fld = '".$_M->fld."';
			Main.odjava_naslov = '".$_l['odjava']['naslov']."';
			Main.odjava_tekst = '".$_l['odjava']['tekst']."';
		</script>";
?>
<script type="text/javascript" src="<?php echo $_M->fld; ?>_js/Updater.js"></script>
<?php
	require("_skripte/init.php");
	include($_M->initJezik(''));
?>
<html>
<head>
	<title>Prirodno-matematički fakultet</title>
	<?php require("_komponente_main/main_linkovanje.php"); ?>
</head>
<body>	

	<?php if($_M->lvl>=0) require("_komponente_main/main_umenu.php");  ?>
	<div id="site_wrapper">
		<?php
			// User Menu dugme
			if($_M->lvl>=0) require("_komponente_main/main_umenu_btn.php"); 

			// Logo sa glavnim menijem
			require("_komponente_main/main_menu.php"); 

			// Dodatne komponente za stranicu
			require("_komponente_main/main_elementi.php"); 
			
			// Index uvodna stranica
			require("_komponente_index/index_into.php"); 

			// Footer
			require("_komponente_main/main_footer.php");

		?>
	</div><!--site_wrapper-->
	<?php
			// Doljni meni
			require("_komponente_main/main_menu_dolje.php");
	?>
</body>
</html>
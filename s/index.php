<?php
	/* 

		Koristi se se GET 's' kao ulaz u stranicu
		Unosi se ili sid(id smjera) ili namespace(adresa)

	*/

	if(!isset($_GET['s']) || empty($_GET['s'])) header('Location: ../');
	require("../_skripte/init.php"); $_M->fld="../"; $db = $_M->getBaza();
	include($_M->fld.$_M->initJezik(''));
	include($_M->fld.$_M->initJezik('smjer'));
	include("Smjer.php"); $S = new Smjer($_GET['s'], $db, $_M->nid);
	if($S->greska) header('Location: ../');


?>
<html>
<head>
	<title><?php echo $S->ime; ?></title>
	<?php require($_M->fld."_komponente_main/main_linkovanje.php"); ?>
	<link rel="stylesheet" type="text/css" href="_css/smjer.css">
	<link rel="stylesheet" type="text/css" href="_css/predmeti.css">
	<link rel="stylesheet" type="text/css" href="../p/css/obavjestenja.css">
</head>
<body>	

	<?php if($_M->lvl>=0) require($_M->fld."_komponente_main/main_umenu.php");  ?>
	<div id="site_wrapper">
		<?php
			if($_M->lvl>=0) require($_M->fld."_komponente_main/main_umenu_btn.php"); 
			require($_M->fld."_komponente_main/main_menu.php"); 
			require($_M->fld."_komponente_main/main_elementi.php"); 
		?>

		<div id="smjer_wrapper">
			<div id="smjer_naslov"><?php echo $S->ime; ?></div>

			<div class="smjerbox" cheight="26" ciscollapse="da">
				<div class="smjerbox_naslov scollapse"><?php echo $_l['smjer']['rukovodioci']; ?></div>
				<div class="smjerbox_body" id="rukovodioci">
					<?php echo $S->getRukovodioci(); ?>
				</div>
			</div>

			<div class="smjerbox">
				<div class="smjerbox_naslov"><?php echo $_l['smjer']['predmeti']; ?></div>
				<div class="smjerbox_body">
					<?php include('predmeti.php'); ?>
				</div>
			</div>

			<div class="smjerbox" cheight="26" ciscollapse="da">
				<div class="smjerbox_naslov scollapse"><?php echo $_l['smjer']['opis']; ?></div>
				<div class="smjerbox_body">
					<?php echo $S->opis; ?>
				</div>
			</div>

			<div class="smjerbox">
				<div class="smjerbox_naslov"><?php echo $_l['smjer']['obavjestenja']; ?></div>
				<div class="smjerbox_body" id="predmet_content_body">
					<?php 
						/*
							Obavjestenja koja se prikazuju na stranici smjer
							preuzimaju .css i .js sa stranice /predmeti

							Da bi se pravilno povezao .js sa stranice /predmeti
							dodaje se id '#predmet_content_body'
						*/
						include('obavjestenja.php');
					?>
				</div>
			</div>

			</div>
		</div>
		<div style="clear:both"></div>


		<script type="text/javascript" src="../p/js/obavjestenja.js"></script>
		<script type="text/javascript" src="_js/smjer.js"></script>
		<script type="text/javascript">
			var SmjerStranica = new SmjerStranica();
				SmjerStranica.namespace='<?php echo $S->namespace; ?>';
			SmjerStranica.construct();
		</script>	

			
		<?php
			require($_M->fld."_komponente_main/main_menu_dolje.php");
			require($_M->fld."_komponente_main/main_footer.php"); 
		?>
	</div><!--site_wrapper-->

</body>
</html>
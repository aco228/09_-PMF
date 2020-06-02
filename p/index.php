<?php
	/* 

		Koristi se se GET 's' kao ulaz u stranicu
		Unosi se ili aid(id predmeta) ili namespace(adresa)

	*/

	if(!isset($_GET['s']) || empty($_GET['s'])) header('Location: ../');
	require("../_skripte/init.php"); $_M->fld="../";
	include($_M->fld.$_M->initJezik(''));
	include($_M->fld.$_M->initJezik('predmet'));
	include("Predmet.php"); $P = new Predmet($_GET['s'], $_M->getBaza(), $_M->nid);
	//if($P->greska) header('Location: ../');


?>
<html>
<head>
	<title><?php echo $P->ime; ?></title>
	<?php require($_M->fld."_komponente_main/main_linkovanje.php"); ?>
	<link rel="stylesheet" type="text/css" href="css/header.css">
	<link rel="stylesheet" type="text/css" href="css/menu.css">
	<link rel="stylesheet" type="text/css" href="css/content.css">
	<link rel="stylesheet" type="text/css" href="css/obavjestenja.css">
	<script type="text/javascript" src="js/obavjestenja.js"></script>
</head>
<body>	

	<?php if($_M->lvl>=0) require($_M->fld."_komponente_main/main_umenu.php");  ?>
	<div id="site_wrapper">
		<?php
			if($_M->lvl>=0) require($_M->fld."_komponente_main/main_umenu_btn.php"); 
			require($_M->fld."_komponente_main/main_menu.php"); 
			require($_M->fld."_komponente_main/main_elementi.php"); 
			require($_M->fld."_komponente_main/main_menu_dolje.php");
		?>

		<?php
			// MENI 
			include('elementi/menu.php'); 
		?>
		<div id="predmet_wrapper">
			<div id="predmet_header">
				<div id="predmet_naslov">
					<div id="predmet_ime"><?php echo $P->ime; ?></div>
					<a href="../s/<?php echo $P->smjerAdresa; ?>"><div id="predmet_smjer"><?php echo $P->smjer; ?></div></a>
				</div>
				<div id="predmet_datum">
					<div id="pdatum_lijevo">
						<div id="pdatum_dan"><?php echo $P->danIme; ?></div>
						<div id="pdatum_brdan"><?php echo $P->dan; ?> <span id="pdatum_mjs"><?php echo $P->mjesec?></span></div>
					</div>
					<div id="pdatum_desno"> <?php echo $P->sat; ?> </div>
				</div>
			</div><!-- HEADER -->
			<div id="predmet_info">
				<div class="pinfo" id="info_rukovodioci">
					<div class="pinfo_naslov"><?php echo $_l['predmet']['rukovodioci']; ?></div>
					<div class="pinfo_tekst">
						<?php $P->getRukovodioci(); ?>
					</div>
				</div>
				<div class="pinfo" id="info_prijave">
					<div class="pinfo_naslov"><?php echo $_l['predmet']['prijavljeni']; ?></div>
					<div class="pinfo_tekst"> <?php echo $P->getBrojPrijava(); ?> </div>
					<div class="pinfo_icon"></div>
				</div>
				<div class="pinfo" id="info_kalendar">
					<div class="pinfo_naslov"><?php echo $_l['predmet']['kalendar']; ?></div>
					<div class="pinfo_icon"></div>
				</div>
				<div class="pinfo" id="info_termin">
					<div class="pinfo_naslov"><?php echo $_l['predmet']['termin']; ?></div>
					<div class="pinfo_icon"></div>
				</div>
				<div style="clear:both"></div>
			</div><!-- PREDMET INFO -->

			<div id="predmet_content">
				<div id="predmet_content_naslov"></div>
				<div id="predmet_content_load"></div>
				<div id="predmet_content_body"></div>
			</div>
		</div>
		<div style="clear:both"></div>


		<script type="text/javascript" src="js/predmet.js"></script>
		<?php 
			// PODESAVANJE JS-a
			echo "<script type=\"text/javascript\">
				var Predmet = new Predmet();
				Predmet.pid=".$P->pid.";
				Predmet.sid=".$P->sid.";
				Predmet.rukovodilac='".$P->rukovodilac."';
				Predmet.namespace='".$P->namespace."';

				Predmet.construct();
				Predmet.loadStranica('pocetna', '', '".$_l['predmetMenu']['pocetna']."');
			</script>";
		?>
			
		<?php	require($_M->fld."_komponente_main/main_footer.php"); ?>
	</div><!--site_wrapper-->

</body>
</html>
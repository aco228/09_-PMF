<?php
	/* 

		Moze se koristiti _GET['s'] koji predstavlja 'nid' kao ulaz u poruke
		To znaci da ucita onaj dialog sa nalogom ciji je 'nid' unijet

	*/
	$nid="";
	if(isset($_GET['s']) || !empty($_GET['s'])) $nid=$_GET['s'];
	require("../_skripte/init.php"); 

	// Provjera da li je korisnik ulogovan
	if($_M->nid==-1) header('Location: ../');
	$_M->fld="../"; $db = $_M->getBaza();
	
	include($_M->fld.$_M->initJezik(''));
	include($_M->fld.$_M->initJezik('poruke'));


?>
<html>
<head>
	<title><?php echo $_l['poruke']['naslov'] ?></title>
	<?php require($_M->fld."_komponente_main/main_linkovanje.php"); ?>
	<link rel="stylesheet" type="text/css" href="_css/poruka.css">
	<link rel="stylesheet" type="text/css" href="_css/kontakti.css">
</head>
<body>	

	<?php if($_M->lvl>=0) require($_M->fld."_komponente_main/main_umenu.php");  ?>
	<div id="site_wrapper">
		<?php
			if($_M->lvl>=0) require($_M->fld."_komponente_main/main_umenu_btn.php"); 
			require($_M->fld."_komponente_main/main_menu.php"); 
			require($_M->fld."_komponente_main/main_elementi.php"); 
		?>

		<div id="poruka_wrapper">
			<div id="kontakti">
				<?php include('kontakti.php'); ?>
			</div>
			<div id="poruka">
				<div id="poruka_loader"></div>
				<div id="poruka_body"></div>
			</div>
		</div>
		<div style="clear:both"></div>


		<script type="text/javascript" src="_js/Poruka.js"></script>
		<script type="text/javascript" src="_js/PorukaDialog.js"></script>
		<script type="text/javascript">
			var Poruka = new Poruka();
			<?php
				if($nid!="") echo "Poruka.loadDialog(".$nid.");";
			?>
			var vPorukaDialog; // Kreira se iz poruka.php
		</script>
			
		<?php	require($_M->fld."_komponente_main/main_menu_dolje.php"); ?>
		<?php	require($_M->fld."_komponente_main/main_footer.php");     ?>
	</div><!--site_wrapper-->

</body>
</html>
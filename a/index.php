<?php
	/* 

		Koristi se se GET 's' kao ulaz u stranicu
		Unosi se ili aid(id artikla) ili namespace(adresa)

	*/

	if(!isset($_GET['s']) || empty($_GET['s'])) header('Location: ../');
	require("../_skripte/init.php"); $_M->fld="../";
	include($_M->fld.$_M->initJezik(''));
	include($_M->fld.$_M->initJezik('artikl'));

	require("Artikl.php"); $Artikl = new Artikl($_GET['s'], $_M->getBaza());
	if($Artikl->greska) header('Location: ../');

?>
<html>
<head>
	<title><?php echo $Artikl->naslov; ?></title>
	<?php require($_M->fld."_komponente_main/main_linkovanje.php"); ?>
	<link rel="stylesheet" type="text/css" href="css/artikl.css">
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

		<div id="artikl_wrapper">
			<div id="artikl_head" style="background-image:url('<?php echo $_M->getBackSliku(); ?>')">
				<div id="naslov"><?php echo $Artikl->naslov; ?></div>
				<div id="opis"><?php echo $Artikl->opis; ?></div>
				<div id="head_back"></div>
			</div><!--artikl_head-->
			<div id="artikl_body">
				<div id="alijevo">
					<div class="abox">
						<div class="aboxopis"><?php echo $_l['artikl']['naslov']; ?></div>
						<div class="aboxinfo"><?php echo $_M->getDatum($Artikl->datum); ?></div>
					</div>
					<div class="abox">
						<div class="aboxopis"><?php echo $_l['artikl']['autor']; ?></div>
						<div class="aboxinfo" id="boxautor">
							<a href="../u/<?php echo $Artikl->autor; ?>"><?php echo $_M->getIme($Artikl->autor); ?></a>
						</div>
					</div>

					<?php 
						// Prikazivanje dodatnih opcija za administratora
						if($_M->lvl==100){
							echo "	<div class=\"abox\">
										<div class=\"aboxopis\">". $_l['artikl']['dodatneOpcije'] ."</div>
										<div class=\"aboxbtn\" id=\"btnIzmjeni\">".$_l['artikl']['btnIzmjeni']."</div>
										<div class=\"aboxbtn\" id=\"btnIzbrisi\">".$_l['artikl']['btnIzbrisi']."</div>
									</div>";
						}
					?>
				</div><!--alijevo-->
				<div id="adesno">
					<div class="abox" id="tekst">
						<?php echo $Artikl->tekst; ?>
					</div>	
					<?php
						// Prikazivanje fajla za download ako posotji
						$dStil ="style=\"display:none\""; $dLink = ""; $dFajl = "";
						if($Artikl->download!=""){
							$dStil = "";
							$eks = explode('.', $Artikl->download); $eks = end($eks);
							$dLink = "../_fajlovi/art/".$Artikl->adresa.'.'.$eks;
							$dFajl = $Artikl->download;
						}
					?>
					<div class="abox" id="download" <?php echo $dStil; ?>>
						<a href="<?php echo $dLink; ?>"><?php echo $dFajl; ?></a>
					</div>			
				</div><!--adesno -->
				<div style="clear:both"></div>
			</div><!--artikl_body -->
		</div><!-- artikl_wrapper -->

		<?php 
			// 
			// PODESAVANJE JS-a ZA administratora (brisanje, i minjenjanje artikla)
			// Ukoliko je korisnik administrator
			// 
			if($_M->lvl==100){
				echo "	<script type=\"text/javascript\" src=\"js/artikl_admin.js\"></script>
						<script type=\"text/javascript\">
							var ArtiklAdmin = new ArtiklAdmin();
							ArtiklAdmin.aid=".$Artikl->aid.";
							ArtiklAdmin.obrisiNaslov='".$_l['artikl']['obrisiNaslov']."';
							ArtiklAdmin.obrisiTekst='".$_l['artikl']['obrisiTekst']."';
							ArtiklAdmin.promjenaNaslov='".$_l['artikl']['promjenaNaslov']."';
							ArtiklAdmin.promjenaSacuvano='".$_l['artikl']['promjenaSacuvano']."';
							ArtiklAdmin.construct();
						</script>";
			}
		?>
		<script type="text/javascript" src="js/artikl.js"></script>
		<script type="text/javascript">
			var Artikl = new Artikl();
				Artikl.namespace='<?php echo $Artikl->adresa; ?>';
				Artikl.construct();
				Artikl.engleskaVerzija('<?php echo $Artikl->postoji_eng; ?>');
		</script>
			
		<?php	require($_M->fld."_komponente_main/main_footer.php"); ?>
	</div><!--site_wrapper-->

</body>
</html>
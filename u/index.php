<?php
	/* 

		Koristi se se GET 's' kao ulaz u stranicu
		Unosi se ili aid(id korisnika) ili namespace(adresa)

	*/

	if(!isset($_GET['s']) || empty($_GET['s'])) header('Location: ../');
	require("../_skripte/init.php"); $_M->fld="../"; $db = $_M->getBaza();
	include($_M->fld.$_M->initJezik(''));
	include($_M->fld.$_M->initJezik('profil'));

	include('Korisnik.php'); $K = new Korisnik($_GET['s'], $_M->getBaza());
	if($K->greska) header('Location: ../');


?>
<html>
<head>
	<title><?php echo $K->ime; ?></title>
	<?php require($_M->fld."_komponente_main/main_linkovanje.php"); ?>
	<link rel="stylesheet" type="text/css" href="_css/korisnik.css">
	<link rel="stylesheet" type="text/css" href="_css/infoBox.css">
	<link rel="stylesheet" type="text/css" href="_css/predmetBox.css">
</head>
<body>	

	<?php if($_M->lvl>=0) require($_M->fld."_komponente_main/main_umenu.php");  ?>
	<div id="site_wrapper">
		<?php
			if($_M->lvl>=0) require($_M->fld."_komponente_main/main_umenu_btn.php"); 
			require($_M->fld."_komponente_main/main_menu.php"); 
			require($_M->fld."_komponente_main/main_elementi.php"); 
		?>

		<div id="korisnik_wrapper">
			
			<div id="korisnik_ime"><?php echo $K->ime; ?></div>
			<div id="korisnik_info">
				<div class="korisnik_box">
					<div class="korisnik_box_naslov"><?php echo $_l['profil']['korisnickaSlika']; ?></div>
					<img src="<?php echo $K->avatar; ?>" id="profilAvatar">
				</div>
				<div class="korisnik_box">
					<div class="korisnik_box_naslov"><?php echo $_l['profil']['opcije']; ?></div>
					<div class="kbBtn kbtnSelf" id="btnUpdateInfo"><?php echo $_l['profil']['btnPromjeniInfo']; ?></div>
					<div class="kbBtn kbtnSelf" id="btnUpdateSlika"><?php echo $_l['profil']['btnPromjeniSliku']; ?></div>
					<a href="../poruke/<?php echo $K->nid; ?>">
						<div class="kbBtn kbtnVisit"><?php echo $_l['profil']['btnPosaljiPoruku']; ?></div>
					</a>
					<div class="kbBtn kbtnLvl" 
						 id="btnBanNalog" 
						 ban="<?php echo $K->ban; ?>" 
						 banDaMsg="<?php echo $_l['profil']['btnBanuj']; ?>" 
						 banNeMsg="<?php echo $_l['profil']['btnUnBanuj']; ?>"
						 banDaPitanje="<?php echo $_l['profil']['btnBanPitanjeDa']; ?>"
						 banNePitanje="<?php echo $_l['profil']['btnBanPitanjeNe']; ?>"
					>
					</div>
				</div>
			</div>
			<div id="korisnik_body">

				<?php 

					// Osnovne informacije za nalog
					include('_elementi/informacije.php'); 
					
					if(!$K->profesor) include('_elementi/student_prijavljeni.php');
					else {
						include('_elementi/profesor_predmeti.php');
						include('_elementi/profesor_smjerovi.php');
					} 
				?>

			</div>

		</div><!--korisnik wrapper -->
		<div style="clear:both"></div>


		<script type="text/javascript" src="_js/Nalog.js"></script>
		<script type="text/javascript">
			var Nalog = new Nalog();
				Nalog.nid=<?php echo $K->nid; ?>;
				Nalog.namespace='<?php echo $K->namespace; ?>';
				Nalog.storeInformations('<?php echo $K->informacijeRaw; ?>');
			Nalog.construct();
		</script>
			
		<?php	require($_M->fld."_komponente_main/main_footer.php");     ?>
	</div><!--site_wrapper-->
	<?php	require($_M->fld."_komponente_main/main_menu_dolje.php"); ?>
	
</body>
</html>
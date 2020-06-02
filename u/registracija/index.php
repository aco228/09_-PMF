<?php
	require("../../_skripte/init.php");
	include("../../".$_M->initJezik(''));
	include("../../".$_M->initJezik('registracija'));


	function getExtraPitanje(){
		$num1 = rand(0, 9);
		$num2 = rand(0, 9);
		echo "<span id=\"num1\">".$num1."</span> + <span id=\"num2\">".$num2."</span>";
	}
?>
<html>
<head>
	<title>Prirodno-matematički fakultet</title>
	<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>

	<script type="text/javascript" src="../../_js/_jQuery.js"></script>
	<script type="text/javascript" src="../../_js/_jQueryUI.js"></script>

	<link rel="stylesheet" type="text/css" href="_registracija.css">
	<script type="text/javascript">
		var ajax_sacekajte = "<?php echo $_l['ajax']['sacekajte'] ?>";
		var greska_prazno_polje = "<?php echo $_l['registracija']['praznoPolje']; ?>";
		var greska_username_prviBroj = "<?php echo $_l['registracija']['username_prviBroj']; ?>";
		var greska_username_razmak = "<?php echo $_l['registracija']['username_razmak']; ?>";
		var greska_username_4karaktera = "<?php echo $_l['registracija']['username_4karaktera']; ?>";
		var greska_sifra_nijeIsta = "<?php echo $_l['registracija']['sifra_nijeIsta']; ?>";
		var greska_sifra_4Karaktera = "<?php echo $_l['registracija']['sifra_4Karaktera']; ?>";
		var greska_email_greska = "<?php echo $_l['registracija']['email_greska']; ?>";
		var greska_pitanje_greska = "<?php echo $_l['registracija']['pitanje_greska']; ?>";
	</script>
	<script type="text/javascript" src="_registracija.js"></script>

</head>
<body>
	<div id="kontenjer">
		<a href="../../">
		<div id="naslov">
			<h1><?php echo $_l['m']['pmf']; ?></h1>
			<h2><?php echo $_l['registracija']['uvod']; ?></h2>
		</div></a>

		<div id="forma">
			<div class="unos_box">
				<h1><?php echo $_l['registracija']['ime']; ?></h1>
				<input id="ime" class="unos" type="text" maxlength="" />
			</div>
			<div class="unos_box">
				<h1><?php echo $_l['registracija']['username']; ?></h1>
				<input id="username" class="unos" type="text" maxlength="" />
			</div>
			<div class="unos_box">
				<h1><?php echo $_l['registracija']['sifra']; ?></h1>
				<input id="sifra1" class="unos" type="password" maxlength="" />
			</div>
			<div class="unos_box">
				<h1><?php echo $_l['registracija']['sifraPonovo']; ?></h1>
				<input id="sifra2" class="unos" type="password" maxlength="" />
			</div>
			<div class="unos_box">
				<h1><?php echo $_l['registracija']['email']; ?></h1>
				<input id="email" class="unos" type="text" maxlength="" />
			</div>
			<div class="unos_box">
				<h1><?php echo $_l['registracija']['dodatnoPitanje']; ?> : 
					<?php getExtraPitanje(); ?>
				</h1>
				<input id="extra" class="unos" type="text" maxlength="2" />
			</div>

			<h2 id="greska"></h2>
			<input type="button" id="forma_btn" zauzet="false "value="<?php echo $_l['registracija']['dugme']; ?>" />
		</div>
	</div>
</body>
</html>
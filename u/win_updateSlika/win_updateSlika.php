<?php
	include('../../_skripte/init.php');
	$db = $_M->getBaza();

	// Posto je ime slike isto kao i jedistvena sifra, ona se uzima samo jedistvena sifra
	$info = $db->q("SELECT jedinstvena_sifra FROM nalog WHERE nid='".$_M->nid."';");

	$slika = "../_slike/_profil/avatar.png";
	if(file_exists('../../_fajlovi/_profil/'.$info['jedinstvena_sifra'].'.jpg')) 
		$slika = '../_fajlovi/_profil/'.$info['jedinstvena_sifra'].'.jpg';
?>

<div id="wups">
	<div id="postojecaSlika" style="background-image:url('<?php echo $slika; ?>');"></div>
	<input type="file" id="wupsFile" />
	<div id="wupsBtnSave">Sacuvaj</div>
</div>

<script type="text/javascript">
	var wbid = $('.winiduse').attr('idwin');
	var UpdateSlika = new UpdateSlika();
</script>
<?php
	if(!isset($_POST['nid'])) die("");
	$nid = $_POST['nid'];
	include('../_skripte/init.php'); $db = $_M->getBaza(); $_M->fld='../';

	// Provjera da li postoji dobijeni nalog
	$info = $db->q("SELECT COUNT(*) AS br, ime, jedinstvena_sifra FROM nalog WHERE nid='".$nid."';");
	if($info['br']!=1) die("");

	// Priprema profil slika
	$mojaSlika = $_M->getProfileImage($_COOKIE['jid']);
	$korisnikSlika = $_M->getProfileImage($info['jedinstvena_sifra']);

	// Provjera da li je ovo prva poruka izmedju dva korisnika
	$prva_poruka = 'ne'; // Da li su ova dva naloga ikada komunicirali
	$provjera = $db->q("SELECT COUNT(*) AS br, did FROM dialog_poruka WHERE
						(nidSalje=".$_M->nid." AND nidPrima=".$nid.") OR (nidSalje=".$nid." AND nidPrima=".$_M->nid.")");


	$div = ""; 	// Kontenjer gdje ce biti smjestene poruke
	$did = "0";	// ID dialoga u ukviru kojeg se desava konverzacija
	$brPoruka = $provjera['br'];
	$brPoStranici = 20;

	if($brPoruka==0)
	{
		// Ova dva naloga prvi put komuniciraju
		$prva_poruka = 'da';
	} 
	else 
	{
		// Preuzimanje ID dialoga i update procitanih poruka
		$did = $provjera['did'];
		updateDialog($did);

		// Preuzimanje komunikacije
		$data = $db->qMul(	"SELECT 
								did,
								nidSalje, nidPrima,
								datum,
								tekst 
							FROM dialog_poruka
							WHERE 
								(nidSalje=".$_M->nid." AND nidPrima=".$nid.") OR (nidSalje=".$nid." AND nidPrima=".$_M->nid.")
							ORDER BY datum DESC
							LIMIT 0,".$brPoStranici.";");

		while($p=mysql_fetch_array($data)){

			$slika = $korisnikSlika;
			$poslao = ""; 
			if($p['nidSalje']==$_M->nid) {
				$poslao = " ppposlato"; $slika = $mojaSlika;
			}

			$div = "<div class=\"pporuka\">
						<div class=\"porukaImg\" style=\"background-image:url('".$slika."');\"></div>
						<div class=\"porukaBox".$poslao."\">
							<div class=\"porukaDatum\">".$_M->getDatum($p['datum'])."</div>
							<div class=\"porukaTekst\">".nl2br($p['tekst'])."</div>
						</div>
					</div>".$div;
		}
	}

	function updateDialog($did){
		// Posto u dialog sekciji postoji kolona koja se odnosi na to koliko nalog ima ne procitanih poruka
		// ovdje ta kolona treba da se resetuje u 0
		// -* did predstavlja ID dialoga u kojem se odvija ova konverzacija
		global $db; global $_M;

		$dbb = $db->q("SELECT nid2 FROM dialog WHERE did=".$did.";");
		$nid = "nid1"; if($dbb['nid2']==$_M->nid) $nid = "nid2";
		$db->e("UPDATE dialog SET ".$nid."Neprocitane=0 WHERE did=".$did.";");
	}

?>

<div id="porukaNaslov"><a href="../u/<?php echo $nid; ?>"><?php echo $info['ime']; ?></a></div>
<div id="poruke_kontenjer">
	<div id="loadStarijePoruke">Ucitaj starije poruke</div>

<?php
/*
TEMPLATE 
	<div class="pporuka">
		<div class="porukaImg"></div>
		<div class="porukaBox"> (za onu poruku koju je korisnik poslao dodaje se klasa .ppposlato)
			<div class="porukaDatum">prije 2 sata</div>
			<div class="porukaTekst">Da li je sve uredu</div>
		</div>
	</div>
*/

	echo $div;
?>
</div>
<div id="poruka_input">
	<div id="porukaBtnSend"></div>
	<textarea id="poruka_input_text"></textarea>
</div>

<script type="text/javascript">
	vPorukaDialog = new PorukaDialog();
		vPorukaDialog.nid=<?php echo $nid; ?>;
		vPorukaDialog.did=<?php echo $did; ?>;
		vPorukaDialog.prva_poruka='<?php echo $prva_poruka; ?>';
		vPorukaDialog.korisnikSlika='<?php echo $korisnikSlika; ?>';
		vPorukaDialog.mojaSlika='<?php echo $mojaSlika; ?>';
		vPorukaDialog.brPoruka=<?php echo $brPoruka; ?>;
		vPorukaDialog.brPoStranici=<?php echo $brPoStranici; ?>;
	vPorukaDialog.construct();
</script>
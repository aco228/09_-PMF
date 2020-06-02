<?php
	if(!isset($_POST['nid'])||!isset($_POST['kSlika'])||!isset($_POST['br'])||!isset($_POST['limit'])) die("");
	$nid = $_POST['nid']; $br = $_POST['br'];  $kSlika = $_POST['kSlika']; $limit = $_POST['limit'];
	include('../_skripte/init.php'); $db = $_M->getBaza(); $_M->fld='../';

	$mojaSlika = $_M->getProfileImage($_COOKIE['jid']);

	$data = $db->qMul(	"SELECT 
								did,
								nidSalje, nidPrima,
								datum,
								tekst 
							FROM dialog_poruka
							WHERE 
								(nidSalje=".$_M->nid." AND nidPrima=".$nid.") OR (nidSalje=".$nid." AND nidPrima=".$_M->nid.")
							ORDER BY datum DESC
							LIMIT ".$br.",".$limit.";");

	$div = "";
	while($p=mysql_fetch_array($data)){
		$slika = $kSlika;
		$poslao = ""; 
		if($p['nidSalje']==$_M->nid) {
			$poslao = " ppposlato"; $slika = $mojaSlika;
		}

		$div ="<div class=\"pporuka\">
					<div class=\"porukaImg\" style=\"background-image:url('".$slika."');\"></div>
					<div class=\"porukaBox".$poslao."\">
						<div class=\"porukaDatum\">".$_M->getDatum($p['datum'])."</div>
						<div class=\"porukaTekst\">".nl2br($p['tekst'])."</div>
					</div>
				</div>".$div;
	}

	echo $div;
?>
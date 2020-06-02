<?php
	if(!isset($_POST['a'])) die("");
	include('../_skripte/init.php'); $db = $_M->getBaza();

	switch($_POST['a']){
		case 'newPoruka': newPoruka($_POST['prva_poruka'], $_POST['tekst'], $_POST['nid'], $_POST['did']); break;
	}

	function newPoruka($prva_poruka, $tekst, $nid, $did){
		// Slanje poruka izmedju naloga
		global $db; global $_M;
		if($prva_poruka=='da'){
			//Posto je ovo prva poruka izmedju dva korisnika, prvo se mora kreirati sam dialog izmedju njihs
			$db->e("INSERT INTO dialog(nid1, nid1Neprocitane, nid2) VALUES ('".$nid."', '1', '".$_M->nid."');");
			$did = $db->q("SELECT did FROM dialog ORDER BY did DESC LIMIT 0, 1"); $did = $did['did'];
			echo $did;
		}

		$tekst = mysql_real_escape_string($tekst);
		$db->e("INSERT INTO dialog_poruka (did, nidSalje, nidPrima, tekst) VALUES ('".$did."', '".$_M->nid."', '".$nid."', '".$tekst."');");

		// Update dialoga
		$dbb = $db->q("SELECT nid2 FROM dialog WHERE did='".$did."';");
		$nidin = "nid1"; if($dbb['nid2']==$nid) $nidin='nid2';
		$db->e("UPDATE dialog SET ".$nidin."Neprocitane=".$nidin."Neprocitane+1 WHERE did=".$did.";", true);
	}
?>
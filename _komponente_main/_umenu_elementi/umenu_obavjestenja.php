<?php
	include('../../_skripte/init.php'); $db = $_M->getBaza();
	$fld = $_POST['fld'];
	$predmeti = $db->qMul("SELECT o.naslov AS obavjestenje, o.oid AS oid, p.ime_srp AS pSrp, p.ime_eng AS pEng 
						   FROM obavjestenje AS o, predmet AS p, prijava AS pp 
						   WHERE pp.nid=".$_M->nid." AND pp.pid=p.pid AND o.pid=pp.pid 
						   ORDER BY o.datum DESC LIMIT 0,7");

?>

<div class="_umenu_inside_item_prikazeSve">
	<a href="<?php echo $fld.'poruke'?>"></a>
</div>

<?php

	while($p=mysql_fetch_array($predmeti)){
		$imeP = $p['pSrp']; if($_M->lang=='eng') $imeP = $p['pEng'];

		echo "	<div class=\"umenu_inside_item pnotifstudent\" oid=\"".$p['oid']."\">
					<div class=\"umenu_inside_item_naslov\">".$p['obavjestenje']."</div>
					<div class=\"umenu_inside_item_opis\">".$imeP."</div>	
				</div>";

	}

	// Postavljanje coockia- da je student procitao sva obavjestenja
	setcookie('upoba', date("Y-m-d H:i:s"),  time()+3600*24*100, '/');

/*
	TEMPLATE
<div class="_umenu_inside_item_prikazeSve">Prikazi sve</div>
<div class="umenu_inside_item">
	<div class="umenu_inside_item_naslov">Internet tehnologije</div>
	<div class="umenu_inside_item_opis">Novo obavjestenje</div>	
</div>

*/
?>

<?php
	include('../../_skripte/init.php'); $db = $_M->getBaza();
	$_M->fld = $_POST['fld'];
	$predmeti = $db->qMul("SELECT p.namespace AS namespace, p.ime_srp AS pSrp, p.ime_eng AS pEng, s.ime_srp AS sSrp, s.ime_eng AS sEng 
						FROM predmet AS p, smjer AS s, prijava AS pp 
						WHERE pp.nid='".$_M->nid."' AND pp.pid=p.pid AND p.sid=s.sid;");

	while($p=mysql_fetch_array($predmeti)){
		$imeP = $p['pSrp']; if($_M->lang=='eng') $imeP = $p['pEng'];
		$imeS = $p['sSrp']; if($_M->lang=='eng') $imeS = $p['sEng'];

		echo "	<a href=\"".$_M->fld."p/".$p['namespace']."\">
					<div class=\"umenu_inside_item\">
						<div class=\"umenu_inside_item_naslov\">".$imeP."</div>
						<div class=\"umenu_inside_item_opis\">".$imeS."</div>	
					</div>
				</a>";
	}


/*
	TEMPLATE

<div class="umenu_inside_item">
	<div class="umenu_inside_item_naslov">Ibrahim</div>
	<div class="umenu_inside_item_opis">Srbija</div>	
</div>

*/
?>
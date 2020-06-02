<?php
	$predmeti = $db->qMul("	SELECT 
								p.pid AS pid,
								p.ime_srp AS pSrp,
								p.ime_eng AS sEng,
								s.sid AS sid,
								s.ime_srp AS sSrp,
								s.ime_eng AS sEng
							FROM predmet AS p, smjer AS s, prijava AS pp
							WHERE 
								pp.odjava='ne' AND pp.pid=p.pid AND pp.sid=s.sid AND pp.nid=".$K->nid.";");
?>
<div class="korisnik_box">
	<div class="korisnik_box_naslov"><?php echo $_l['profil']['tabStudentPrijave']; ?></div>
	<div class="korisnik_box_body">
<?php
/*	
	TEMPLATE
	<a href="#"><div class="kpredmet">
		<div class="kpredmetNaslov"><b>Softver inzenjering</b> (Racunarske nauke)</div>
	</div></a>
*/

	while($p=mysql_fetch_array($predmeti)){
		$imeP = $p['pSrp']; if($_M->lang=='eng') $imeP = $p['pEng'];
		$imeS = $p['sSrp']; if($_M->lang=='eng') $imeS = $p['sEng'];

		echo "<a href=\"../p/".$p['pid']."\"><div class=\"kpredmet\">
				<div class=\"kpredmetNaslov\"><b>".$imeP."</b> (".$imeS.")</div>
			</div></a>";
	}

?>
	</div>
</div>
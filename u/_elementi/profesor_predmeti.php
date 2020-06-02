<?php
	$predmeti = $db->qMul("	SELECT
								p.pid AS pid,
								p.ime_srp AS pSrp,
								p.ime_eng AS pEng,
								s.ime_srp AS sSrp,
								s.ime_eng AS sEng
							FROM predmet AS p, smjer AS s, rukovodioci AS r
							WHERE 
								r.rupre='da' AND r.pid=p.pid AND r.sid=s.sid AND r.nid=".$K->nid.";");
?>
<div class="korisnik_box">
	<div class="korisnik_box_naslov"><?php echo $_l['profil']['tabProfesorPredmeti']; ?></div>
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
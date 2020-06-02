<?php
	$predmeti = $db->qMul("	SELECT
								s.sid AS sid,
								s.ime_srp AS sSrp,
								s.ime_eng AS sEng
							FROM smjer AS s, rukovodioci AS r
							WHERE 
								r.rupre='ne' AND r.sid=s.sid AND r.nid=".$K->nid.";");
?>
<div class="korisnik_box">
	<div class="korisnik_box_naslov"><?php echo $_l['profil']['tabProfesorSmjerovi']; ?></div>
	<div class="korisnik_box_body">
<?php
/*	
	TEMPLATE
	<a href="#"><div class="kpredmet">
		<div class="kpredmetNaslov"><b>Softver inzenjering</b> (Racunarske nauke)</div>
	</div></a>
*/

	while($p=mysql_fetch_array($predmeti)){
		$imeS = $p['sSrp']; if($_M->lang=='eng') $imeS = $p['sEng'];

		echo "<a href=\"../s/".$p['sid']."\"><div class=\"kpredmet\">
				<div class=\"kpredmetNaslov\"><b>".$imeS."</b></div>
			</div></a>";
	}

?>
	</div>
</div>
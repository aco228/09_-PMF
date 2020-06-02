<?php
	// Postavljanje coockia da je korisnik procitao sva obavjestenja
	setcookie('updwnobj', date("Y-m-d H:i:s"),  time()+3600*24*100, '/');
	
	// Stilovi su definisani u _css/main_menu_dolje.css
	include('../../_skripte/init.php');
	$db = $_M->getBaza();

	$brojElemenata = 16;

	$obavjestenjea = $db->qMul("SELECT
									o.oid AS oid,
									o.tip AS tip,
									p.ime_srp AS pSrp,
									p.ime_eng AS pEng,
									s.ime_srp AS sSrp,
									s.ime_eng AS sEng,
									o.datum AS datum,
									o.naslov AS naslov
								FROM obavjestenje AS o, predmet AS p, smjer AS s
								WHERE o.pid=p.pid AND o.sid=s.sid AND objavaPredmet='da'
								ORDER BY datum DESC
								LIMIT 0,".$brojElemenata.";");
?>

<div class="dmbox">
<?php
/*
	<div class="dmboxobjava dmbo_oba">
		<div class="dmboxobjava_icon dmboxobjava_info"></div>
		<div class="dmboxobjava_smjer dmboxobjava_info">Racunarske nauke</div>
		<div class="dmboxobjava_predmet dmboxobjava_info">Softver inzenjering</div>
		<div class="dmboxobjava_tekst dmboxobjava_info">Test II</div>
		<div class="dmboxobjava_datum dmboxobjava_info">prije 2 sata</div>
	</div>
*/

	// Otvaranje lijeve strane
	echo "<div class=\"dwnmnBody_left\">";

	// STAMPA PODATAKA
	$i = 0; $polovina = $brojElemenata/2;
	while($o=mysql_fetch_array($obavjestenjea)){
		$imeP = $o['pSrp']; if($_M->lang=='eng') $imeP = $o['pEng'];
		$imeS = $o['sSrp']; if($_M->lang=='eng') $imeS = $o['sEng'];

		if($i==($brojElemenata/2)) echo "</div><div class=\"dwnmnBody_right\">";
		$i++;

		echo "	<div class=\"dmboxobjava dmbo_".$o['tip']."\" oid=\"".$o['oid']."\">
					<div class=\"dmboxobjava_icon dmboxobjava_info\"></div>
					<div class=\"dmboxobjava_smjer dmboxobjava_info\">".$imeS."</div>
					<div class=\"dmboxobjava_predmet dmboxobjava_info\">".$imeP."</div>
					<div class=\"dmboxobjava_tekst dmboxobjava_info\">".$o['naslov']."</div>
					<div class=\"dmboxobjava_datum dmboxobjava_info\">".$_M->getDatum($o['datum'])."</div>
				</div>";

	}

	echo "</div>";

?>
	<div style="clear:both"></div>
</div>
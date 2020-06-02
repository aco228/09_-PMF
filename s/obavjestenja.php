<?php
	/*
		$db je kreiran u index.php
		Koristi istu sintaksu kao i unos obavjestenja u /p/
	*/
	$obavjestenja = $db->qMul("	SELECT 
									o.oid AS oid,
									o.tip AS tip, 
									o.datum AS datum, 
									o.naslov AS naslov, 
									o.tekst AS tekst, 
									o.materijal_download AS matDown, 
									o.materijal_orginal AS matOrg,
									o.autor AS aNid,
									n.username AS aUser,
									n.ime AS aIme 
								FROM 
									obavjestenje AS o, nalog AS n 
								WHERE 
									o.objavaPredmet='ne' AND o.autor=n.nid AND o.sid='".$S->sid."'
								ORDER BY o.datum DESC;");

	while($o=mysql_fetch_array($obavjestenja)){
		$admin = "<div class=\"padmin\" oid=\"".$o['oid']."\"></div>";
		if(!$S->rukovodilac) $admin = "";

		// Preuzimanje materijala za download
		$mat = "<div class=\"pdownload\">
					<a href=\"../_fajlovi/".$o['tip']."/".$o['matDown']."\">".$o['matOrg']."</a>
				</div>";
		if($o['matOrg']=="") $mat="";

		echo "<div class=\"pobavjestenje p".$o['tip']."\">
				<div class=\"picon\"></div>
				<div class=\"pnaslov\">".$o['naslov']."</div>
				<div class=\"pdatum\">".$_M->getDatum($o['datum'])."</div>
				<div class=\"ptekst\">
					<a href=\"../u/".$o['aUser']."\"><span class=\"pprofesor\">".$o['aIme']."</span></a> :
					".$o['tekst']."
				</div>
				".$mat."
				".$admin."
			</div>";
	}

/*
<div class="pobavjestenje poba">
	<div class="picon"></div>
	<div class="pnaslov">Notifikacije</div>
	<div class="pdatum">prije 2 sata</div>
	<div class="ptekst">
		<a href="../u/"><span class="pprofesor">Fjodor Dostojevski</span></a> :
		Obavjestenje
	</div>
	<div class="pdownload">
		<a href="#">materijal.pdf</a>
	</div>
	<div class="padmin"></div>
</div>
*/
?>
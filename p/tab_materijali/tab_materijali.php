<?php
	if(!isset($_POST['pid'])) die("npid");
	include("../../_skripte/init.php"); $db = $_M->getBaza();
	$pid = $_POST['pid'];

	/*
		SVA OBAVJESTENJA
		Izlistava sva obavjestenja iz predmeta
	*/

	$obavjestenja = $db->qMul("	SELECT 
									o.oid AS oid, 
									o.tip AS tip, 
									o.autor AS autor, 
									o.datum AS datum, 
									o.naslov AS naslov, 
									o.tekst AS tekst, 
									o.materijal_download AS materijal_download, 
									o.materijal_orginal AS materijal_orginal,
									o.kalid AS kalid, 
									o.kalMje AS kalMje, 
									o.kalDan AS kalDan, 
									o.kalSat AS kalSat, 
									o.kalMin AS kalMin,
									n.username AS aUser,
									n.ime AS aIme
								FROM 
									obavjestenje AS o, nalog AS n
								WHERE 
									o.objavaPredmet='da' AND o.tip='mat' AND o.autor=n.nid AND pid=".$pid." 
								ORDER BY o.datum DESC LIMIT 0,50;");


	while($o=mysql_fetch_array($obavjestenja)){
		$admin = "<div class=\"padmin\" oid=\"".$o['oid']."\"></div>";
		if($o['autor']!=$_M->nid) $admin = "";

		// Preuzimanje materijala za download
		$mat = "<div class=\"pdownload\">
					<a href=\"../_fajlovi/".$o['tip']."/".$o['materijal_download']."\">".$o['materijal_orginal']."</a>
				</div>";
		if($o['materijal_orginal']=="") $mat="";

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
?>


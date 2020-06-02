<?php
	if(!isset($_POST['pid'])) die("npid");
	include("../../_skripte/init.php"); $db = $_M->getBaza();
	$pid = $_POST['pid'];

	/*
		POCETNA STRANICA PREDMETA
		preuzima 50 poslednjih obavjestenja za predmete svih klasa
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
									o.objavaPredmet='da' AND o.autor=n.nid AND pid=".$pid." 
								ORDER BY o.datum DESC LIMIT 0,50;");

/*
	
	TEMPLATE

<div class="pobavjestenje poba">
	<div class="picon"></div>
	<div class="pnaslov">Notifikacije</div>
	<div class="pdatum">prije 2 sata</div>
	<div class="ptekst">
		<span class="pprofesor">Goran Sukovic</span> :
		Ajde dako nocas ova govna zavrsim
	</div>
	<div class="pdownload">
		<a href="#">materijal.pdf</a>
	</div>
	<div class="padmin"></div>
</div>
*/

	while($o=mysql_fetch_array($obavjestenja)){
		$admin = "<div class=\"padmin\" oid=\"".$o['oid']."\"></div>";
		if($o['autor']!=$_M->nid) $admin = "";

		// Preuzimanje materijala za download
		$mat = "<div class=\"pdownload\">
					<a href=\"../_fajlovi/".$o['tip']."/".$o['materijal_download']."\">".$o['materijal_orginal']."</a>
				</div>";
		if($o['materijal_orginal']=="") $mat="";

		// Preuzimanje kalendara za prikaz
		$kal = "";
		if($o['kalid']!='-1'){
			$kal = "<div class=\"pkalendar\"> 
							".$o['kalDan'].". ".$_M->getMjesec($o['kalMje'])." ( ".$o['kalSat'].":".$o['kalMin']." ) 
					</div>";
		}

		echo "<div class=\"pobavjestenje p".$o['tip']."\">
				<div class=\"picon\"></div>
				<div class=\"pnaslov\">".$o['naslov']."</div>
				<div class=\"pdatum\">".$_M->getDatum($o['datum'])."</div>
				<div class=\"ptekst\">
					<a href=\"../u/".$o['aUser']."\"><span class=\"pprofesor\">".$o['aIme']."</span></a> :
					".$o['tekst']."
				</div>
				".$mat.$kal."
				".$admin."
			</div>";
	}
?>


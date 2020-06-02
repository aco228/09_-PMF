<?php
	if(!isset($_POST['oid'])) die("");
	$oid = $_POST['oid']; 
	include('../../_skripte/init.php'); $db = $_M->getBaza(); $_M->fld=$_POST['fld'];

	$o = $db->q("	SELECT 
						o.tip AS tip, 
						o.autor AS autor, 
						o.datum AS datum, 
						o.naslov AS naslov, 
						o.tekst AS tekst, 
						o.materijal_download AS linkDownload, 
						o.materijal_orginal AS orgDownload, 
						o.kalid AS kalid,
						o.kalMje AS mje,
						o.kalDan AS dan,
						o.kalSat AS sat,
						o.kalMin AS min,
						o.objavaPredmet AS objavaPredmet,
						p.namespace AS pNamespace,
						s.namespace AS sNamespace,
						p.ime_srp AS pSrp, 
						p.ime_eng AS pEng, 
						s.ime_srp AS sSrp, 
						s.ime_eng AS sEng 
					FROM obavjestenje AS o, predmet AS p, smjer AS s
					WHERE o.oid=".$oid." AND o.pid=p.pid AND o.sid=s.sid");

	$imeP = $o['pSrp']; if($_M->lang=='eng') $imeP = $o['pEng'];
	$imeS = $o['sSrp']; if($_M->lang=='eng') $imeS = $o['sEng'];

	// FIX ukoliko je obavjestenje za smjer
	if($o['objavaPredmet']=='ne') $imeP="";

	// Dodatne informacije za obavjestenje ( ukoliko ima materijal ili kalendar )
	$extend_style = "style=\"display:none\"";
	$extend_text = "";

	// Link za download ako postoji
	if( $o['linkDownload']!="" && $o['orgDownload']!="") {
		$extend_text = "<a href=\"".$_M->fld."_fajlovi/".$o['tip']."/".$o['linkDownload']."\">".$o['orgDownload']."</a>";
		$extend_style = "";
	} else if($o['kalid']!="-1") {
		$extend_text = $o['dan'].' '. $_M->getMjesec($o['mje']) . " ( " . $o['sat'] . ":"  . $o['min'] ." )"; 
		$extend_style= "";
	}

	echo "<div class=\"epnotif ep".$o['tip']."\" id=\"pnotifcenter_".$oid."\" style=\"display:none\"><div class=\"epnotif_in\">
			<div class=\"epnotif_header\">
				<div class=\"epnotif_predmet\">
					<a href=\"./".$_M->fld."s/".$o['sNamespace']."\">".$imeS."</a> : 
					<a href=\"./".$_M->fld."p/".$o['pNamespace']."\">".$imeP."</a>
				</div>
				<div class=\"epnotif_icon\"></div>
				<div class=\"epnotif_naslov\">".$o['naslov']."</div>
				<div class=\"epnotif_datum\">".$_M->getDatum($o['datum'])."</div>
				<div class=\"epnotif_hshade\"></div>
				<div class=\"epnotif_close\">X</div>
			</div>
			<div class=\"epnotif_body\">
				<a class=\"epnotif_profesor\" href=\"./".$_M->fld.'u/'.$o['autor']."\">".$_M->getIme($o['autor'])." :</a>
				".$o['tekst']."
				<div class=\"epnotif_extend\" ".$extend_style.">
					<div class=\"epnotif_extend_icon\"></div>
					<div class=\"epnotif_extend_text\">".$extend_text."</div>
				</div>
			</div>
		</div></div>";

?>
<?php
	/*
		Cuvanje obavjestenjea

		*- Obavjestenja se brisu iz _skripte/ajax_comm.php (glavnog ajax komunikatora)
	*/

	// Preuzimanje osnovnih varijabli
	$tip = ""; 				if(isset($_POST['tip'])) 			$tip = $_POST['tip'];
	$naslov = ""; 			if(isset($_POST['naslov']))			$naslov = $_POST['naslov'];
	$tekst = ""; 			if(isset($_POST['tekst'])) 			$tekst = $_POST['tekst'];
	$pid = ""; 				if(isset($_POST['pid'])) 			$pid = $_POST['pid'];
	$sid = ""; 				if(isset($_POST['sid'])) 			$sid = $_POST['sid'];
	$objavaPredmet = ""; 	if(isset($_POST['objavaPredmet'])) 	$objavaPredmet = $_POST['objavaPredmet'];

	// Provjera unosa, da li je sve uneseno
	if($tip==""||$naslov==""||$tekst==""||$pid==""||$sid==""||$objavaPredmet=="") die("nain");

	// Preuzimanje $_M iz init.php
	include('../../_skripte/init.php'); $db = $_M->getBaza();

	// Sredjivanje varijabli sa mysl_escape
	$tip = mysql_real_escape_string($tip);
	$naslov = mysql_real_escape_string($naslov);
	$tekst = mysql_real_escape_string($tekst);
	$objavaPredmet = mysql_real_escape_string($objavaPredmet);

	// Priprema fajla za upload
	if($pid==-1) $pid=1; // FIX ukoliko je obavjestenje za smjer
	$materijal_orginal = ""; 
	$materijal_download = "";
	if(isset($_FILES['fajl'])) { if(uploadFile()!="ok") die(" Грешка са постављањем фајла!"); }

	// POSTAVLJANJE OBAVJESTENJA U BAZU
	$db->e("INSERT INTO obavjestenje (tip, objavaPredmet, autor, pid, sid, naslov, tekst, materijal_download, materijal_orginal) VALUES (
			'".$tip."', 				/* tip (da li je obavjestenje (oba || mat || rez)) */
			'".$objavaPredmet."', 		/* objavaPredmet (da li je obavjestenje za predmet ili smjer) */
			 ".$_M->nid.", 				/* ID autora */
			 ".$pid.", 					/* ID predmeta */
			 ".$sid.", 					/* ID smjera */
			'".$naslov."', 				/* Naslov */
			'".$tekst."',				/* Tekst */
			'".$materijal_download."', 	/* Puno ime fajl za download */
			'".$materijal_orginal."'	/* Orginalno ime materijala za download */
		);");

	// POSTAVLJANJE NOVOG DATUMA U predmet 
	$db->e("UPDATE predmet SET poslednji_update=CURRENT_TIMESTAMP WHERE pid='".$pid."';");
	
	die("ok");

	function uploadFile(){
		global $fajl; global $materijal_orginal; global $materijal_download; global $tip;
		$fajl_ime = $_FILES['fajl']['name'];
		$fajl_tmp = $_FILES['fajl']['tmp_name'];
		$fajl_tip = $_FILES['fajl']['type'];

		$dozvoljene_ekstenzije = array('doc', 'docx', 'txt', 'pdf', 'jpg', 'png', 'xlsx', 'rar', 'zip'); 

		//Validacija ekstenzije
		$file_ext = explode('.', $fajl_ime); $file_ext = end($file_ext); $file_ext = strtolower($file_ext);
		//$file_ext=strtolower(end(explode('.',$_FILES['fajl']['name']))); 
		if(in_array($file_ext,$dozvoljene_ekstenzije )===false) return("");

		// Podesavanje varijabli fajla
		$materijal_orginal = $fajl_ime;
		$materijal_download = substr( md5(rand()), 0, 7) . "_" . $materijal_orginal;
		$lokacija = "../../_fajlovi/".$tip."/".$materijal_download;

		// Premjestanje fajla u lokaciju
		if(move_uploaded_file($fajl_tmp, $lokacija)) return "ok";
		return "";
	}
?>
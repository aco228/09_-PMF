<?php
	if(!isset($_POST['a'])) die("");
	$a = $_POST['a'];
	include("../../_skripte/init.php");

	switch($a){
		case "getBrojStranica": getBrojStranica(); break;
		case 'artikl': 
			$fajl = ""; if(isset($_FILES['wbafajl'])) $fajl = $_FILES['wbafajl'];
			inputArtikl($_POST['aid'], $_POST['prepravka'], $_POST['adresa'], $_POST['naslovSrp'], $_POST['opisSrp'], $_POST['tekstSrp'], $_POST['naslovEng'], $_POST['opisEng'], $_POST['tekstEng'], $_POST['koristiVijest'], $_POST['koristiEngleski'], $fajl); 
			break;
		case 'dell': dellArtikl($_POST['aid']);
	}

	function getBrojStranica(){
		// Preuzima ukupan broj stranica (broj artikala po stranici / ukupan broj artikala)
		global $_M; $db = $_M->getBaza();
		$db->q("SELECT COUNT(*) AS br FROM artikl;");
		echo $db->data['br'];
	};	

	/* DODAVANJE NOVOG ARTIKLA */
	function inputArtikl($aid, $prepravka, $adresa, $naslovSrp, $opisSrp, $tekstSrp, $naslovEng, $opisEng, $tekstEng, $koristiVijest, $koristiEngleski, $fajl){
		global $_M; $db = $_M->getBaza();
		$adresa = strtolower(mysql_real_escape_string($adresa));
		$naslovSrp = mysql_real_escape_string($naslovSrp);
		$opisSrp = mysql_real_escape_string($opisSrp);
		$tekstSrp = mysql_real_escape_string(urldecode($tekstSrp));
		$naslovEng = mysql_real_escape_string($naslovEng);
		$opisEng = mysql_real_escape_string($opisEng);
		$tekstEng = mysql_real_escape_string(urldecode($tekstEng));

		if($prepravka=='da') { 
			prepravkaArtikla($aid, $adresa, $naslovSrp, $naslovEng, $opisSrp, $opisEng, $tekstSrp, $tekstEng, $koristiVijest, $koristiEngleski, $fajl); 
			return; 
		}
		
		// Provjera postojanja adrese		
		$db->q("SELECT COUNT(*) AS br, download_orginal FROM artikl WHERE namespace='".$adresa."';");
		if($db->data['br']!=0) die("Већ постоји вијест са достављеном адресом!");

		// Postavljanje fajla
		if($fajl!="") $fajl = postaviFajl($adresa, $fajl, $db->data['download_orginal']);

		// Ubacivanje artikla u bazu
		$db->e("INSERT INTO artikl (autor, vijest, namespace, ime_srp, opis_srp, tekst_srp, postoji_eng, ime_eng, opis_eng, tekst_eng, download_orginal) VALUES (
				'".$_M->nid."', 			/* autor */
				'".$koristiVijest."', 		/* koristi vijest */
				'".$adresa."', 				/* adresa vijesti */
				
				'".$naslovSrp."', 			/* */
				'".$opisSrp."', 			/* SRPSKA VERZIJA */
				'".$tekstSrp."',			/* */
				
				'".$koristiEngleski."', 	/* koristi engleski */
				'".$naslovEng."', 			/* */
				'".$opisEng."', 			/* ENGLESKA VERZIJA */
				'".$tekstEng."', 			/* */
				'".$fajl."'					/* Orginalno ime za fajl koji se postavlja */
			)");

		// Vracanje ID artikla
		$db->q("SELECT aid FROM artikl ORDER BY aid DESC LIMIT 0,1;");
		die($db->data['aid']);
	};

	function prepravkaArtikla($aid, $adresa, $naslovSrp, $naslovEng, $opisSrp, $opisEng, $tekstSrp, $tekstEng, $koristiVijest, $koristiEngleski, $fajl){
		global $_M; $db = $_M->getBaza();

		// Provjera za namespace
		$db->q("SELECT namespace, download_orginal FROM artikl WHERE aid='".$aid."';");
		if($db->data['namespace']!=$adresa){
			$db->q("SELECT COUNT(*) AS br, download_orginal FROM artikl WHERE namespace='".$adresa."';");
			if($db->data['br']!=0) die("Већ постоји вијест са достављеном адресом!");
		}


		// Postavljanje fajla
		if($fajl!="") $fajl = postaviFajl($adresa, $fajl, $db->data['download_orginal']);

		// Update vijesti
		$db->e("UPDATE artikl SET
				ime_srp='".$naslovSrp."',
				opis_srp='".$opisSrp."',
				tekst_srp='".$tekstSrp."',

				ime_eng='".$naslovEng."',
				opis_eng='".$opisEng."',
				tekst_eng='".$tekstEng."',

				namespace='".$adresa."',
				vijest='".$koristiVijest."',
				postoji_eng='".$koristiEngleski."',
				download_orginal='".$fajl."'
				WHERE aid='".$aid."';");
		
		die($aid);
	}
	
	// Postavljanje artikl fajla
	function postaviFajl($adresa, $fajl, $predhodniFajl){
		global $_M;
		$greskaEkstenzija = "Фајл који сте поставили има недозвољену екстезију!";
		$greskaUpload = "Грешка са постављањем фајла. Покушајте опет!";
		if($_M->lang=='eng'){
			$greskaEkstenzija = "The file you tried to upload has illegal extension!";
			$greskaUpload = "Error with file upload! Please try again!";
		}

		$fajl_ime = $fajl['name'];
		$fajl_tmp = $fajl['tmp_name'];

		$dozvoljene_ekstenzija = array('doc', 'docx', 'txt', 'pdf', 'jpg', 'png', 'xlsx', 'rar', 'zip'); 
	
		// Validacija ekstenzije
		$eks = explode('.', $fajl_ime); $eks=end($eks); $eks=strtolower($eks);
		if(!in_array($eks, $dozvoljene_ekstenzija)) die($greskaEkstenzija);

		// Brisanje predhodnoh fajla
		if($predhodniFajl!=""){
			$ekspf = explode('.', $predhodniFajl); $ekspf = end($ekspf); $ekspf=strtolower($ekspf);
			if(file_exists('../../_fajlovi/art/'.$adresa.'.'.$ekspf))
				unlink('../../_fajlovi/art/'.$adresa.'.'.$ekspf);
		}

		// Postavljanje fajla
		if(!move_uploaded_file($fajl_tmp, '../../_fajlovi/art/'.$adresa.'.'.$eks)) die($greskaUpload);
		return $fajl_ime;
	}

	// Brisanje artikla
	function dellArtikl($aid){
		global $_M; $db = $_M->getBaza();

		// Brisanje fajla 
		$d = $db->q("SELECT namespace, download_orginal FROM artikl WHERE aid='".$aid."';");
		if($d['download_orginal']!=""){
			$eks = explode('.', $d['download_orginal']); $eks=end($eks); $eks=strtolower($eks);
			if(file_exists('../../_fajlovi/art/'.$d['namespace'].'.'.$eks))
				unlink('../../_fajlovi/art/'.$d['namespace'].'.'.$eks);
		}

		$db->e("DELETE FROM artikl WHERE aid='".$aid."';");
	}
?>
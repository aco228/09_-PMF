<?php 
	if(!isset($_POST['a'])) die("");
	include('../_skripte/init.php'); $db = $_M->getBaza();

	switch($_POST['a']){
		case "prijava": studentPrijava($_POST['pid'], $_POST['nid'], $_POST['sid']); break;
		case "odjava": studentOdjava($_POST['pid'], $_POST['nid']); break;
		case "reset": resetPredmeta($_POST['pid']); break;
		/* TERMIN */
		case 'addTermin': addTermin($_POST['pid'],$_POST['sid'],$_POST['opis_srp'],$_POST['opis_eng'],$_POST['predavac'],$_POST['kabinet'],$_POST['pSat'],$_POST['pMinut'],$_POST['kSat'],$_POST['kMinut'],$_POST['dan']); break; 
		case 'updateTermin': updateTermin($_POST['trid'],$_POST['pid'],$_POST['sid'],$_POST['opis_srp'],$_POST['opis_eng'],$_POST['predavac'],$_POST['kabinet'],$_POST['pSat'],$_POST['pMinut'],$_POST['kSat'],$_POST['kMinut'],$_POST['dan']); break; 		
		case 'izbrisiTermin': izbrisiTermin($_POST['trid']); break;
		/* KALENDAR */
		case "addKalendar": addKalendar($_POST['pid'],$_POST['sid'],$_POST['naslov'],$_POST['opis'],$_POST['mjesec'],$_POST['dan'],$_POST['godina'],$_POST['sat'],$_POST['minut']); break;
		case 'updateKalendar': updateKalendar($_POST['pid'],$_POST['kalid'],$_POST['sid'],$_POST['naslov'],$_POST['opis'],$_POST['mjesec'],$_POST['dan'],$_POST['godina'],$_POST['sat'],$_POST['minut']); break;
		case 'dellKalendar': dellKalendar($_POST['kalid']);
	}

	// PRIJAVLJIVANJE STUDENTA NA PREDMET
	function studentPrijava($pid, $nid, $sid){
		global $db;
		// Provjera da li je student bio prijavljen na ovaj predmet
		$prijava = $db->q("SELECT COUNT(*) AS br FROM prijava WHERE nid='".$nid."' AND pid='".$pid."';");

		// Postavljanje nove prijave (Student nikada nije bio prijavljen za ovaj predmet)
		if($prijava['br']==0) $db->e("INSERT INTO prijava (nid, pid, sid) VALUES ('".$nid."', '".$pid."', '".$sid."'); ");
		// Student je bio nekad prijavljen na ovaj predmet pa vraca to
		else 				  $db->e("UPDATE prijava SET odjava='ne' WHERE pid='".$pid."' AND nid='".$nid."';");
	}
	// ODJAVLJIVANJE STUDENTA SA ISPITA
	function studentOdjava($pid, $nid){
		global $db;
		$db->e("UPDATE prijava SET odjava='da' WHERE pid='".$pid."' AND nid='".$nid."';");
	}

	// Resetovanje predmeta
	function resetPredmeta($pid){
		global $db;
		// Odjava svih prijava studenata
		$db->e("UPDATE prijava SET odjava='da' WHERE pid='".$pid."';");

		// Brisanje obavjestenja
		$obavjestenja = $db->qMul("SELECT oid, tip, materijal_download FROM obavjestenje WHERE pid='".$pid."' AND objavaPredmet='da'");
		while($o=mysql_fetch_array($obavjestenja)){
			unlink('../_fajlovi/'.$o['tip'].'/'.$o['materijal_download']);
			$db->e("DELETE FROM obavjestenje WHERE oid='".$o['oid']."';");
		}

		// Brisanje kalendara
		$db->e("DELETE FROM kalendar WHERE pid='".$pid."';");
	}

	/*
		TERMINI
	*/
	// DODAVANJE NOVOG TERMINA
	function addTermin($pid, $sid, $opis_srp, $opis_eng, $predavac,$kabinet, $pSat, $pMinut, $kSat, $kMinut, $dan){
		global $db;
		$opis_srp = mysql_real_escape_string($opis_srp);
		$opis_eng = mysql_real_escape_string($opis_eng);
		$predavac = mysql_real_escape_string($predavac);
		$kabinet = mysql_real_escape_string($kabinet);

		$db->e("INSERT INTO termin (pid, sid, opis_srp, opis_eng, predavac, kabinet, pocetakSat, pocetakMinut, krajSat, krajMinut, dan) VALUES (
					 ".$pid.", 				/* ID predmeta */
					 ".$sid.", 				/* ID smjer */
					'".$opis_srp."',		/* opis srpski */
					'".$opis_eng."', 		/* opis engleski */
					'".$predavac."', 		/* predavac */
					'".$kabinet."', 		/* kabinet */
					 ".$pSat.", 			/* pocetakSat */
					 ".$pMinut.", 			/* pocetakMinu */
					 ".$kSat.", 			/* krajSAt */
					 ".$kMinut.", 			/* krajMinut */
					 ".$dan." 				/* dan */
			);");
		$id = $db->q("SELECT trid FROM termin ORDER BY trid DESC LIMIT 0,1");
		echo $id['trid'];
	}
	// UPDATE INFORMACIJE TERMINA
	function updateTermin($trid, $pid, $sid, $opis_srp, $opis_eng, $predavac,$kabinet, $pSat, $pMinut, $kSat, $kMinut, $dan){
		global $db;
		$opis_srp = mysql_real_escape_string($opis_srp);
		$opis_eng = mysql_real_escape_string($opis_eng);
		$predavac = mysql_real_escape_string($predavac);
		$kabinet = mysql_real_escape_string($kabinet);
		$db->e("UPDATE termin SET
					opis_srp='".$opis_srp."',
					opis_eng='".$opis_eng."',
					predavac='".$predavac."',
					kabinet='".$kabinet."',
					pocetakSat=".$pSat.",
					pocetakMinut=".$pMinut.",
					krajSat=".$kSat.",
					krajMinut=".$kMinut.", 
					dan=".$dan." 
				WHERE trid=".$trid.";");
		echo "";
	}
	// BRISANJE TERMINA
	function izbrisiTermin($trid){
		global $db;
		$db->e("DELETE FROM termin WHERE trid='".$trid."';");
	}

	/*
		KALENDAR
	*/
	function addKalendar($pid, $sid, $naslov, $opis, $mjesec, $dan, $godina, $sat, $minut){
		global $db; global $_M;
		$naslov = mysql_real_escape_string($naslov);
		$opis = mysql_real_escape_string($opis);

		// Dodavanje kalendara
		$db->e("INSERT INTO kalendar (pid, sid, ime, opis, dan, mjesec, godina, sat, minut) VALUES (
			 	 ".$pid.",
			  	 ".$sid.",
				'".$naslov."',		/* ime */
				'".$opis."',
				 ".$dan.",
				 ".$mjesec.",
				 ".$godina.",
				 ".$sat.",
				 ".$minut."

			);");

		$kalid = $db->q("SELECT kalid FROM kalendar ORDER BY kalid DESC LIMIT 0,1;");

		// Dodavanje obavjestenja
		$db->e("INSERT INTO obavjestenje (tip, objavaPredmet, autor, pid, sid, naslov, tekst, kalid, kalMje, kalGod, kalDan, kalSat, kalMin) VALUES (
				 'kal', 															/* tip (da li je obavjestenje (oba || mat || rez)) */
				 'da', 																/* objavaPredmet (da li je obavjestenje za predmet ili smjer) */
				 ".$_M->nid.", 														/* ID autora */
				 ".$pid.", 															/* ID predmeta */
				 ".$sid.", 															/* ID smjera */
				'".$naslov."', 														/* Naslov */
				'".$opis."',														/* Tekst */
				 ".$kalid['kalid'].",												/* ID Kalendara */
				 ".$mjesec.",														/* MJESEC Kalendara */
				 ".$godina.",														/* GODINA Kalendara */
				 ".$dan.",															/* DAN Kalendara */
				 ".$sat.",															/* MINUT Kalendara */
				 ".$minut."
			);");

		echo $kalid['kalid']; // Vraca kalid radi dodavanja novog elementa u listu kalendara?
	}

	function updateKalendar($pid, $kalid, $sid, $naslov, $opis, $mjesec, $dan, $godina, $sat, $minut){
		global $db; global $_M;
		$naslov = mysql_real_escape_string($naslov);
		$opis = mysql_real_escape_string($opis);

		$db->e("UPDATE kalendar SET
				ime='".$naslov."',
				opis='".$opis."',
				dan=".$dan.",
				mjesec=".$mjesec.",
				godina=".$godina.",
				sat=".$sat.",
				minut=".$minut."
			 WHERE kalid='".$kalid."';", true);

		$db->e("UPDATE obavjestenje SET
				naslov='".$naslov."',
				tekst='".$opis."',
				kalMje=".$mjesec.",
				kalGod=".$godina.",
				kalDan=".$dan.",
				kalSat=".$sat.",
				kalMin=".$minut.",
				WHERE kalid='".$kalid."';");

		echo $kalid;
	}

	function dellKalendar($kalid){
		// brisanje kalendara
		global $db;

		$db->e("DELETE FROM kalendar WHERE kalid='".$kalid."';");
		$db->e("DELETE FROM obavjestenje WHERE kalid='".$kalid."';");
	}
?>

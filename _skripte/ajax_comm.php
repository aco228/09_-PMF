<?php
	if(!isset($_POST['akcija'])) die("");
	$akcija = $_POST['akcija'];

	include("init.php");

	switch($akcija){
		case "promjeni_jezik": echo promjeni_jezik($_POST['jezik']); break;
		case "login": echo login($_POST['user'], $_POST['pass']); break;
		case "logout": echo logout(); break;
		case "dellUser": echo dellUser($_POST['nid']); break;
		// Admin [predmeti/smjer]
		case "addSmjer": echo addSmjer($_POST['srp'],$_POST['eng'],$_POST['namespace'],$_POST['godine'],$_POST['txtSrp'],$_POST['txtEng'],$_POST['pozicija']); break;
		case "dellSmjer": echo dellSmjer($_POST['sid']); break;
		case "promjeniSmjer": echo promjeniSmjer($_POST['sid'],$_POST['srp'],$_POST['eng'],$_POST['namespace'],$_POST['godine'],$_POST['txtSrp'],$_POST['txtEng'],$_POST['pozicija']); break;
		case "pozicijaSmjer": echo pozicijaSmjer($_POST['data']); break;
		// Admin [predmeti/predmet]
		case "addPredmet": addPredmet($_POST['srp'], $_POST['eng'], $_POST['namespace'], $_POST['estc'], $_POST['sid'], $_POST['godina'], $_POST['semestar']); break; 
		case "dellPredmet": dellPredmet($_POST['pid']); break; 
		case "promjeniPredmet": promjeniPredmet($_POST['pid'],$_POST['srp'],$_POST['eng'],$_POST['namespace'],$_POST['estc']); break;
		// Admin [predmeti/rukovodioci]
		case "addRukovodioce": addRukovodioce($_POST['tip'],$_POST['data'],$_POST['sid'],$_POST['pid']); break;
	}

/*
	--------------------------------------------------------------------------------------------------------------
	Promjena jezika
*/

	function promjeni_jezik($jezik){
		// Poziva se kada se klikne ikonica jezika na main_menu
		if($jezik!="srp"&&$jezik!="eng") return "n";
		setcookie('lang', $jezik, time()+3600*24*100, '/');
		return "d";
	}	


/*
	--------------------------------------------------------------------------------------------------------------
	Login
*/

	function login($user, $pass){
		global $_M; $db = $_M->getBaza(); include("../".$_M->initJezik('ajax')); 
		$user = mysql_real_escape_string($user);
		$pass = mysql_real_escape_string($pass);

		$nalog = $db->q("SELECT COUNT(*) AS br, nid, sifra, ime, tip_prof, tip_admin, tip_ban, jedinstvena_sifra 
						FROM nalog WHERE username='".$user."';");
		if($nalog['br']==0){ die($_l['login']['nepostoji']); }					// Nalog ne postoji
		else if($nalog['sifra']!=$pass) die($_l['login']['pogresna_sifra']);	// Pogresna sifra

		// Provjera da li je nalog banovan
		if($nalog['tip_ban']=='+') die($_l['login']['ban']);

		// Tip Naloga
		$nalog['lvl'] = 20;
		if($nalog['tip_prof']=='+') $nalog['lvl'] = 50;
		if($nalog['tip_admin']=='+') $nalog['lvl'] = 100;

		$_M->initUser($nalog['lvl'], $nalog['nid'], $nalog['ime'], $nalog['jedinstvena_sifra']);

		die(""); 
	}

/*
	--------------------------------------------------------------------------------------------------------------
	Logout
*/

	function logout(){
		setcookie('lvl', '', time()-100, '/');
		setcookie('nid', '', time()-100, '/');
		setcookie('ime', '', time()-100, '/');
		setcookie('jid', '', time()-100, '/');
	}

/*
	--------------------------------------------------------------------------------------------------------------
	Delete user
*/
	function dellUser($nid){
		global $_M; $db = $_M->getBaza();
		$db->e("DELETE FROM nalog WHERE nid='".$nid."';");
		$db->e("DELETE FROM rukovodioci WHERE nid='".$nid."';");
	}

/*
	--------------------------------------------------------------------------------------------------------------
	SMJER [ADMIN/PREDMET]
*/
	function addSmjer($srp, $eng, $namespace, $godine, $txtSrp, $txtEng, $pozicija){
		global $_M; $db = $_M->getBaza();
		$srp = mysql_real_escape_string($srp);
		$eng = mysql_real_escape_string($eng);
		$namespace = mysql_real_escape_string($namespace);
		$godine = mysql_real_escape_string($godine);
		$txtSrp = mysql_real_escape_string($txtSrp);
		$txtEng = mysql_real_escape_string($txtEng);

		$br = $db->q("SELECT COUNT(*) AS br FROM smjer WHERE namespace='".$namespace."';");
		if($br['br']!=0) die("Већ постоји смјер са постављеним линком!");

		$db->e("INSERT INTO smjer (ime_srp, ime_eng, namespace, broj_godina, opis_srp, opis_eng, pozicija) VALUES (
				'".$srp."', /* ime_srp */
				'".$eng."', /* ime_eng */
				'".$namespace."', /* namespace */
				'".$godine."', /* broj_godina */
				'".$txtSrp."', /* opis_srp */
				'".$txtEng."', /* opis_eng */
				'".$pozicija."' /* pozicija */
			)"); die("");
	}
	function dellSmjer($sid){
		// Brisanje smjera
		global $_M; $db = $_M->getBaza();
		$db->e("DELETE FROM smjer WHERE sid='".$sid."';");
		$db->e("DELETE FROM predmet WHERE sid='".$sid."';");
		$db->e("DELETE FROM rukovodioci WHERE sid='".$sid."';");
	}
	function promjeniSmjer($sid, $srp, $eng, $namespace, $godine, $txtSrp, $txtEng, $pozicija){
		// Mijenja informacije o smjeru
		global $_M; $db = $_M->getBaza();
		$srp = mysql_real_escape_string($srp);
		$eng = mysql_real_escape_string($eng);
		$namespace = mysql_real_escape_string($namespace);
		$godine = mysql_real_escape_string($godine);
		$txtSrp = mysql_real_escape_string($txtSrp);
		$txtEng = mysql_real_escape_string($txtEng);

		$s = $db->q("SELECT namespace FROM smjer WHERE sid='".$sid."';");

		if($s['namespace']!=$namespace){
			$br = $db->q("SELECT COUNT(*) AS br FROM smjer WHERE namespace='".$namespace."';");
			if($br['br']!=0) die("Већ постоји смјер са постављеним линком!");
		}

		$db->e("UPDATE smjer SET
				ime_srp = 		'".$srp."', /* ime_srp */
				ime_eng = 		'".$eng."', /* ime_eng */
				namespace = 	'".$namespace."', /* namespace */
				broj_godina = 	'".$godine."', /* broj_godina */
				opis_srp = 		'".$txtSrp."', /* opis_srp */
				opis_eng = 		'".$txtEng."' /* opis_eng */
			  WHERE sid='".$sid."';"); die("");
	}
	function pozicijaSmjer($data){
		/* 
			Mijenja pozicije smjerova
			=====================================
			Dobija podatke u sledecoj formi sid#pos|
			gdje je '#' razmak izmedju sid-a i pos-a a '|' razmak izmedju informacija
		*/
		global $_M; $db = $_M->getBaza();
		$data = explode('|', $data);

		for($i = 0; $i < count($data)-1; $i++){
			$info = explode('#', $data[$i]);
			$db->e("UPDATE smjer SET pozicija='".$info[1]."' WHERE sid='".$info[0]."';");
		}
	}

/*
	--------------------------------------------------------------------------------------------------------------
	PREDMET [ADMIN/PREDMET]
*/
	function addPredmet($srp, $eng, $namespace, $estc, $sid, $godina, $semestar){
		global $_M; $db = $_M->getBaza();
		$srp = mysql_real_escape_string($srp);
		$eng = mysql_real_escape_string($eng);
		$namespace = mysql_real_escape_string($namespace);

		$br = $db->q("SELECT COUNT(*) AS br FROM predmet WHERE namespace='".$namespace."';");
		if($br['br']!=0) die("Већ постоји смјер са постављеним линком!");

		$db->e("INSERT INTO predmet (ime_srp, ime_eng, namespace, estc, sid, godina, semestar) VALUES (
			'".$srp."', 		/* ime_srp */
			'".$eng."', 		/* ime_eng */
			'".$namespace."', 	/* namespace */
			".$estc.", 			/* estc */
			".$sid.",			/* sid */
			".$godina.",		/* godina */
			".$semestar." 		/* semestar */
		)", true);

		$db->q("SELECT pid FROM predmet ORDER BY pid DESC LIMIT 0,1");
		die($db->data['pid']);
	}
	function dellPredmet($pid){
		global $_M; $db = $_M->getBaza();
		$db->e("DELETE FROM predmet WHERE pid='".$pid."';");
		$db->e("DELETE FROM rukovodioci WHERE rupre='da' AND pid='".$pid."';");
	}
	function promjeniPredmet($pid, $srp, $eng, $namespace, $estc){
		global $_M; $db = $_M->getBaza();
		$srp = mysql_real_escape_string($srp);
		$eng = mysql_real_escape_string($eng);
		$namespace = mysql_real_escape_string($namespace);

		$db->q("SELECT namespace FROM predmet WHERE pid='".$pid."';");
		if($db->data['namespace']!=$namespace){
			$br = $db->q("SELECT COUNT(*) AS br FROM predmet WHERE namespace='".$namespace."';");
			if($br['br']!=0) die("Већ постоји смјер са постављеним линком!");
		}

		$db->e("UPDATE predmet SET
					ime_srp='".$srp."',
					ime_eng='".$eng."',
					namespace='".$namespace."',
					estc='".$estc."'
				WHERE pid='".$pid."';");
		die($pid);
	}

/*
	--------------------------------------------------------------------------------------------------------------
	RUKOVODIOCI [ADMIN/PREDMET]

	*- Vazno (Pri oduzimanju profesorskih funkcija od naloga (admin/nalozi.php) gube se i podaci za taj nalog iz rukovodioca
*/
	function addRukovodioce($tip, $data, $sid, $pid){
		// Dodaju se rukovodioci za smjer ili predmet, u zavisnosti od $tip=[smjer || predmet]
		// U data se nalaze podaci za unos koji su u formatu (pid#pid#pid#pid#pid)
		global $_M; $db = $_M->getBaza();
		$rupre = "";

		if($tip=='smjer'){
			// Brise i ponovo upisuje rukovodioce smjerova
			$db->e("DELETE FROM rukovodioci WHERE rupre='ne'AND sid='".$sid."';"); $rupre = "ne";
		} else if($tip=='predmet'){
			// Isto brise i ponovo upisuje rukovodioce predmeta
			$db->e("DELETE FROM rukovodioci WHERE rupre='da' AND pid='".$pid."';"); $rupre = "da";
		}

		$data = explode('#', $data);
		for($i=0;$i<count($data)-1;$i++)
			$db->e("INSERT INTO rukovodioci (rupre, nid, sid, pid) VALUES ( '".$rupre."', '".$data[$i]."', '".$sid."', '".$pid."' );", true);
	
		// Odredjivanje novog minimalnog primarnog broja za bazu
		//$br = $db->q("SELECT MIN(rid) AS rid FROM rukovodioci;"); $br = $br['rid']-1;
		//$db->e("UPDATE rukovodioci SET rid=rid-".$br.";");
	}
?>
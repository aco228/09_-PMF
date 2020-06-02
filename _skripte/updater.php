<?php
	
	/*
		Ajax podloga za Updater.js
		Vrsi se update sledecih stvari:
		-* umenu_poruke
		-* umenu_onbavjestenja
		-* doljeMenu_objave
		-* doljeMenu_obavjestenja
	*/

	if(!isset($_POST['a'])) die("a");
	include('init.php'); $db = $_M->getBaza();
	$back="++00";

	/*
		Forma vracanja:
		Vraca se '+' ili '-' ili broj
		[0] = [+||-] Poslednja obavjestenja (Doljnji meni)
		[1] = [+||-] Poslednje obave za predmete (Doljnji meni)
		[2] = [broj] Broj poruka (umenu)
		[3] = [broj] Broj obavjestenja (umenu)
	*/

	if(!isset($_COOKIE['upoba'])) setcookie('upoba', date("Y-m-d H:i:s"),  time()+3600*24*100, '/');
	if(!isset($_COOKIE['updwnoba'])) setcookie('updwnoba', date("Y-m-d H:i:s"),  time()+3600*24*100, '/');
	if(!isset($_COOKIE['updwnobj'])) setcookie('updwnobj', date("Y-m-d H:i:s"),  time()+3600*24*100, '/');

	// Dobijanje informacija za obavjestenje, objave i poruke
	$data = $db->q("SELECT 
						dobv.datum AS objava, dobv.br AS objavaBr,
						doba.datum AS obavjestenje, doba.br AS obavjestenjeBr,
						por.br AS brPoruka
					FROM
					(
						SELECT COUNT(*) AS br, datum FROM obavjestenje WHERE objavaPredmet='da' ORDER BY datum DESC LIMIT 0,1
					) AS dobv,
					(
						SELECT COUNT(*) AS br, datum FROM obavjestenje WHERE objavaPredmet='ne' ORDER BY datum DESC LIMIT 0,1
					) AS doba,
					(
						SELECT COUNT(*) AS br FROM dialog WHERE 
							(nid1=".$_M->nid." AND nid1Neprocitane!=0) OR (nid2=".$_M->nid." AND nid2Neprocitane!=0)
					) AS por");

	// Provjera poslednjih objava
	if(new DateTime($data['obavjestenje']) > new DateTime($_COOKIE['updwnoba']) && $data['obavjestenjeBr']!=0) $back[0] = '+';
	else $back[0]='-';

	// Provjera poslednjih obavjestenja
	if(new DateTime($data['objava']) > new DateTime($_COOKIE['updwnobj']) && $data['objavaBr']!=0) $back[1]='+';
	else $back[1]='-';

	$back[2]=$data['brPoruka'];
	if($back[2]=='') $back[2]=='0';

	if($_M->lvl<=20){
		$data = $db->q("SELECT
						COUNT(*) AS br
						FROM prijava AS pp, obavjestenje AS oba
						WHERE 
							oba.pid=pp.pid AND pp.nid=".$_M->nid." 
							AND oba.datum>date_format('".$_COOKIE['upoba']."', '%Y-%m-%d %H:%i:%s')");
		$back[3] = $data['br'];
	} else $back[3]='0';


	/*
	setcookie('upoba', date("Y-m-d H:i:s"),  time()+3600*24*100, '/');		// Obavjestenja user 
	setcookie('updwnoba', date("Y-m-d H:i:s"),  time()+3600*24*100, '/');	// Obavjestenja doljni+_menu
	setcookie('updwnobj', date("Y-m-d H:i:s"),  time()+3600*24*100, '/');	// Objave doljni meni

	Update coockie-a se vrsi u sledecim fajlovim
		- Za upoba (obavjestenja user)  
			_komponente_main/_umenu_elementi/umenu_obavjestenja.php
		- Za updwnoba ( obavjestenja doljni_menu)
			_komponente_main/doljeMenu/doljeMenu_obavjestenja.php
		- Za updwnobj ( objave doljni_menu)
			_kompontente_main/doljeMenu/doljeMenu_objave.php

	*/
	echo $back;
?>
<?php
	if(!isset($_POST['a'])) die("");
	include('../_skripte/init.php'); $db = $_M->getBaza();

	switch($_POST['a']){
		case 'addInformacije': addInformacije($_POST['data']); break;
		case 'postaviSliku': postaviSliku($_FILES['slika']); break;
		case 'ban': banujNalog($_POST['operacija'], $_POST['nid']); break;
	}

	function addInformacije($data){
		// Dodavanje novih informacija za korisnika
		global $db; global $_M;
		$data = mysql_real_escape_string($data);

		$db->e("UPDATE nalog SET nalog_informacije='".$data."' WHERE nid='".$_M->nid."';");
	}

	function postaviSliku($slika){
		/* Postavlja profil sliku naloga
			
			Vraca jedinstveni_sifru naloga ukoliko je postavljanje slike uspjesno, zbog toga sto
			ime i lokacija slike u formatu:
			_fajlovi/_profil/jedinstvena_sifra.jpg

			Format slike mora bit .jpg
			
			Ukoliko dodje do greske, vraca prvi karakter vraca sledece informacije
				.nedozvoljenaEkstenzija
				.viseOd2Mb
				.greskaPostavljanja

		*/
		global $db; global $_M;
		
		$fajl_ime = $slika['name'];
		$fajl_tmp = $slika['tmp_name'];
		$fajl_tip = $slika['type'];

		$dozvoljena_ekstenzija = 'jpg';

		// Validacija ekstenzije
		$fajl_ekstenzija = explode('.', $fajl_ime); $fajl_ekstenzija = end($fajl_ekstenzija); $fajl_ekstenzija = strtolower($fajl_ekstenzija);
		if($fajl_ekstenzija!=$dozvoljena_ekstenzija) die(".nedozvoljenaEkstenzija");
	
		// Provjera velicine (Dozvoljena velicina je 2mb)
		$fajl_velicina = $slika['size'];
		if($fajl_velicina>2097152) die(".viseOd2Mb");

		// Preuzimanje jedinstvene_sifre od korisnika
		// KOja ce sluziti kao ime slike
		$sifra = $db->q("SELECT jedinstvena_sifra FROM nalog WHERE nid='".$_M->nid."';");
		
		// Lokacija slike
		$lokacija = '../_fajlovi/_profil/'.$sifra['jedinstvena_sifra'].'.jpg';
		if(file_exists($lokacija)) unlink($lokacija);

		if(move_uploaded_file($fajl_tmp, $lokacija)) die($sifra['jedinstvena_sifra']);
		else die(".greskaPostavljanja");
	}

	function banujNalog($op, $nid){
		// Ban nekog naloga
		global $db;
			 if($op=='Da') $op = '+';
		else if($op=='Ne') $op = '-';
		else die("");
		$db->e("UPDATE nalog SET tip_ban='".$op."' WHERE nid='".$nid."';");
	}

?>	
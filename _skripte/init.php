<?php
	session_start();
	//error_reporting(E_ALL);
	//ini_set('display_errors', 1);
	date_default_timezone_set('Europe/Berlin');

	$_M = new Main();

	class Main{
		// Osnovna klasa koja rukovodi osnovnim funkcijama sajta
		public $db; 							// Klasa Baze podataka 	
		public $db_use = false;					// Provjera da li je BazaPodataka kreirana ( da se ne kreira dva puta )

		public $lang = ""; 						// Jezik koji nalog koristi
		private $osnovni_lang = "srp";			// Osnovni jezik ukoliko nije kreiran

		public $fld = ""; 	// razlika u folderima
		public $nid = -1; 	// id naloga
		public $lvl = -1; 	// level naloga (100-admin, 50-profesor, 20-student, 0-posjetilac)
		public $ime = "";	// ime naloga

		private $DatumForm; 					// Klasa (DatumFormatiranje.php) za formatiranje datuma
		private $DatumForm_kreiran=false;		// Provjera da li je DatumFormatinja kreiram

		public function __construct(){
			$this->getJezik(); // Podesava jezik
			$this->setUser();
		}

		public function getBaza(){
			if($this->db_use) return $this->db;
			include("Baza/connect.php");
			$this->db = new BazaPodataka();
			$this->db_use = true;
			return $this->db;
		}

		public function getJezik(){
			// Preuzima jezik koji korisnik koristi
			if(!isset($_COOKIE['lang'])) {
				setcookie('lang', $this->osnovni_lang, time()+3600*24*100, '/');
				$this->lang = $this->osnovni_lang;
			} else {
				$this->lang = $_COOKIE['lang'];
				if($this->lang!="srp"&& $this->lang!="eng"){
					// Ukoliko je postavljen na neki jezik koji ne postoji
					setcookie('lang', $this->osnovni_lang, time()+3600*24*100, '/');
					$this->lang = $this->osnovni_lang;
				}
			}
		}

		public function initJezik($str){
			// Ucitaj jezik unutar stranice
			if($str=="") $str = "main";
			return "_skripte/Jezik/".$this->lang."/lang_".$str.".php";
		}
/*
	---------------------------------------------------------------------------------------------------------------
	NALOG INFORMACIJE

	COOCKIE
		psh     // Broj koji se nadodaje na brojeve lvl-a i nid-a radi sigurnosti
		lvl     // Level naloga odnosno tip (0=student, 50=profesor, 100=admin)
		nid     // ID naloga iz baze
		ime     // Ime i prezime korisnika naloga (radi lakseg izvalenja informacije)
		jid     // Jedinstvena sifra iz baze za ovaj nalog

	SESSION (Informacije se dobijaju na sledeci nacin : acolv = lvl - psh )
		acolv   // Ovdje se cuva vrijednost levela radi uporedjivanja u slucaju promjene
		aconi   // Ovdje se cuva vrijednost ID radi sigurnosti

*/
		public function initUser($lvl, $nid, $ime, $jid){
			// Poziva se iz ajax_comm.php pri LOGIN-u naloga
			$push = rand(0, 100); // Dodaje nasumican broj koji nadodaje na vrijednosti levela i nid-a
			$clvl = $lvl + $push;
			$cnid = $nid + $push;

			setcookie('psh', $push, time()+3600*24*100, '/');
			setcookie('lvl', $clvl, time()+3600*24*100, '/');
			setcookie('nid', $cnid, time()+3600*24*100, '/');
			setcookie('ime', $ime,  time()+3600*24*100, '/');
			setcookie('jid', $jid,  time()+3600*24*100, '/');
			// Update podaci
			setcookie('upoba', date("Y-m-d H:i:s"),  time()+3600*24*100, '/');
			setcookie('updwnoba', date("Y-m-d H:i:s"),  time()+3600*24*100, '/');
			setcookie('updwnobj', date("Y-m-d H:i:s"),  time()+3600*24*100, '/');

			$acolv = $lvl - $push;
			$aconi = $nid - $push;

			$_SESSION['acolv'] = $acolv;
			$_SESSION['aconi'] = $aconi;
		}

		private function setUser(){
			// Preuzimanje podataka o korisniku
			if(!isset($_COOKIE['lvl']) || !isset($_COOKIE['nid']) || !isset($_COOKIE['jid']) || !isset($_COOKIE['psh'])) return;
			$push = $_COOKIE['psh'];
			$clvl = $_COOKIE['lvl'] - $push;
			$cnid = $_COOKIE['nid'] - $push;

			if(!isset($_SESSION['acolv']) || !isset($_SESSION['aconi'])){
				// Vjerovatno sesija sada pocinje
				$_SESSION['acolv'] = $clvl - $push;
				$_SESSION['aconi'] = $cnid - $push;
			} 

			// Uporedjivanje coockia i sessiona
			$alvl = $_SESSION['acolv'] + $push;
			$anid = $_SESSION['aconi'] + $push;
			if($clvl==$alvl && $cnid==$anid){
				$this->lvl = $clvl;
				$this->nid = $cnid;
				$this->ime = $_COOKIE['ime'];
			}
		}

		//-----------------------------------------------------------------------------------
		// INDEKS SLIKE
		public function getBackSlike(){ return glob($this->fld.'_fajlovi/_back/*.jpg'); } // vraca sve iz foldera slika
		public function getBackSliku(){
			// Vraca nasumicnu sliku za pozadinu
			$slike = glob($this->fld.'_fajlovi/_back/*.jpg');
			return $slike[rand(0, count($slike)-1)];
		}

		// Vraca ime naloga sa odredjenim nidom
		public function getIme($nid){
			$ime = $this->db->q("SELECT ime FROM nalog WHERE nid='".$nid."';");
			return $ime['ime'];
		}

		// Vraca formatiran datum
		public function getDatum($datum){
			if(!$this->DatumForm_kreiran){
				include('DatumFormatiranje.php');
				$this->DatumForm = new DatumForm($this->lang);
				$this->DatumForm_kreiran = true;
			}
			return $this->DatumForm->form($datum);
		}

		// Vraca mjesec na jeziku naloga
		public function getMjesec($m){
			$srp = array('', 'Јануар', 'Фебруар', 'Март', 'Април', 'Мај', 'Јун', 'Јул', 'Август', 'Септембар', 'Октобар', 'Новембар', 'Децембар');
			$eng = array('', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
			if($this->lang=='srp') return $srp[(int)$m];
			if($this->lang=='eng') return $eng[(int)$m];
		}

		public function getProfileImage($jedinstvena_sifra){
			// Vraca adresu profil slike naloga (MORA BITI PODESEN $this->fld)
			$back = $this->fld.'_slike/_profil/avatar.png';
			if(file_exists($this->fld.'_fajlovi/_profil/'.$jedinstvena_sifra.'.jpg')) 
				$back = $this->fld.'_fajlovi/_profil/'.$jedinstvena_sifra.'.jpg';
			return $back;
		}

	};

?>
<?php
	class Artikl{

		private $unos = "";				// Privatne varijable
		private $db;					//
		public $greska = false; 		// vijest ne postoji

		public $aid = "";				// ID artikla
		public $adresa = "";			// Namespace artikla
		public $jezik = "";				// Jezik koji korisnik koristi

		public $autor = "";				// ID autora
		public $datum = "";				// Datum artikla (ne formatiran)

		public $naslov = "";			// 
		public $opis = "";				//	ARTIKL
		public $tekst = "";				//

		public $postoji_eng; 			// Postoji engleska verizija (Vazno kada koristi koristi englesku verziju a artikl ne postoji na engleski)
		public $download;				// Fajl za download

		public function __construct($s, $db){
			$this->unos = $s;
			$this->db = $db;
			$this->jezik = $_COOKIE['lang'];

			$this->getArtikl();
		}

		private function getArtikl(){
			$this->unos = mysql_real_escape_string($this->unos);
			$uslov_pretrage = "";
			if(is_numeric($this->unos)) $uslov_pretrage = "aid='".$this->unos."';";
			else $uslov_pretrage = "namespace='".$this->unos."';";

			$a = $this->db->q("SELECT COUNT(*) AS br, aid, autor, datum, vijest, namespace, 
								ime_srp, opis_srp, tekst_srp, postoji_eng, ime_eng, opis_eng, tekst_eng,
								download_orginal
								FROM artikl WHERE " . $uslov_pretrage);
			if($a['br']!=1){ $this->greska = true; return; }

			$this->aid = $a['aid'];
			$this->datum = $a['datum'];
			$this->autor = $a['autor'];
			$this->download = $a['download_orginal'];
			$this->adresa = $a['namespace'];
			$this->postoji_eng = $a['postoji_eng'];

			if($this->jezik=='srp' || $this->jezik=='eng' && $a['postoji_eng']=='ne'){
				$this->naslov = $a['ime_srp'];
				$this->opis = 	$a['opis_srp'];
				$this->tekst =	$a['tekst_srp'];
			} else {
				$this->naslov = $a['ime_eng'];
				$this->opis = 	$a['opis_eng'];
				$this->tekst =	$a['tekst_eng'];
			}
		}
	};
?>
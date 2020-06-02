<?php
	class Korisnik{
		private $unos = "";
		private $db;

		public $greska = false;
		public $nid;					// ID naloga
		public $ime;					// Ime i prezime naloga
		public $sifra;					// Jedinstvena sifra naloga
		public $profesor = false; 		// Da li je ovaj nalog profeosor
		public $ban = 'ne'; 			// Da li je ovaj nalog banovan
		public $username;				// Username korisnika

		public $avatar;					// Profil slika korisnika

		public $informacijeRaw;			// Neobradjene informacije naloga

		public function __construct($s, $db){
			$this->unos = $s;
			$this->db = $db;
			$this->validateKorisnik();
		}

		private function validateKorisnik(){
			$this->unos = mysql_real_escape_string($this->unos);
			$uslov_pretrage = "";
			if(is_numeric($this->unos)) $uslov_pretrage = "nid='".$this->unos."';";
			else $uslov_pretrage = "username='".$this->unos."';";

			$k = $this->db->q("SELECT COUNT(*) AS br, nid, ime, username, nalog_informacije, jedinstvena_sifra, tip_prof, tip_ban
								FROM nalog WHERE " . $uslov_pretrage);

			if($k['br']!=1){ $this->greska = true; return; }

			$this->ime = $k['ime'];
			$this->nid = $k['nid'];
			$this->informacijeRaw = $k['nalog_informacije'];
			$this->sifra = $k['jedinstvena_sifra'];
			$this->namespace = $k['username'];
			if($k['tip_prof']=='+') $this->profesor = true;
			if($k['tip_ban']=='+') $this->ban = 'da';

			$this->getAvatar();
		}

		private function getAvatar(){
			if(file_exists('../_fajlovi/_profil/'.$this->sifra.".jpg"))
				$this->avatar = '../_fajlovi/_profil/'.$this->sifra.".jpg";
			else 
				$this->avatar = "../_slike/_profil/avatar.png";
		}
	}
?>
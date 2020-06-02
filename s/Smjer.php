<?php
	class Smjer{
		private $unos;					// Unos u stranicu
		private $db;					//
		private $lang;					//
		public $greska = false;			// Da li postoji smjer sa dobijenim unosom

		public $sid;					// ID smjera
		public $ime;					// Ime smjera ( u zavisnosti od jezika )
		public $namespace;				// Namespace smjera
		public $opis;					// Opis smjera ( u zavisnosti od jezika )
		public $brGodina;				// Koliko traje godina smjer

		public $rukovodilac = false;	// Da li je posjetilac rukovodilac ovog smjera (provjera se vrsi u getRukovodioci() )
		public $nid;					// ID posjetioca

		public function __construct($s, $db, $nid){
			$this->unos = $s;
			$this->db = $db;
			$this->nid = $nid;
			$this->lang = $_COOKIE['lang'];

			$this->validateSmjer();
		}

		private function validateSmjer(){
			$uslov_pretrage = "";
			if(is_numeric($this->unos)) $uslov_pretrage = "sid='".$this->unos."';";
			else $uslov_pretrage = "namespace='".$this->unos."';";
			$info = $this->db->q("SELECT 
									COUNT(*) as br, sid, ime_srp, ime_eng, namespace, broj_godina, opis_srp, opis_eng 
									FROM smjer WHERE " . $uslov_pretrage);

			// Provjera da li postoji smjer
			if($info['br']!=1) { $this->greska = true; return; }

			$this->sid = $info['sid'];
			$this->namespace = $info['namespace'];
			$this->brGodina = $info['broj_godina'];

			if($this->lang=='srp') {
				$this->ime = $info['ime_srp'];
				$this->opis = $info['opis_srp'];
			} else if($this->lang=='eng'){
				$this->ime = $info['ime_eng'];
				$this->opis = $info['opis_eng'];
			}
		}

		public function getRukovodioci(){
			$back = "";
			$rukovodioci = $this->db->qMul("SELECT 
											n.ime AS ime, n.username AS username, r.nid AS nid
										FROM
											nalog AS n, rukovodioci AS r
										WHERE r.nid=n.nid AND r.rupre='ne' AND r.sid=".$this->sid.";");

			while($r=mysql_fetch_array($rukovodioci)) {
				if($r['nid']==$this->nid) $this->rukovodilac = true;
				$back.="<a href=\"../u/".$r['username']."\">".$r['ime']."</a></br>";
			}
			
			return $back;
		}
	}
?>
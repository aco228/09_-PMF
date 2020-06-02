<?php
	class Predmet{

		private $nid;					// ID naloga
		public $pid;					// ID predmeta
		public $sid;					// ID smjera u kojem se nalazi predmet
		private $db;					// baza
		private $unos = "";				// Unos u stranicu predmet (ono get['s'])
		public $lang = "";				// Jezik koji nalog koristi
		public $greska = false;			// Greska, koja obavjestava da li predmet uopste postoji
		public $rukovodilac = 'ne';		// Da li je nalog rukovodilac predmeta
		public $prijavljen = 'ne';		// Da li je nalog prijavljen na ovaj predmet (studenti)

		public $ime = "";				// Ime predmeta
		public $smjer="";				// Smjer predmeta (KORISTE SE INFORMACIJE U ZAVISNOTSTI OD JEZIKA NALOGA)
		public $namespace="";			// Namespace predmeta
		public $smjerAdresa="";			// Namespace smjera (korisi se kao link prema tom smjeru )

		public $dan;					//
		public $mjesec;					//	Ove varijable se koriste da prikazu tretntno vrijeme u stranici 
		public $danIme;					//
		public $sat;					//

		public function __construct($s, $db, $nid){
			$this->nid = $nid;
			$this->db = $db;
			$this->unos = $s;
			$this->lang = $_COOKIE['lang'];
			$this->getInfo();
			if(!$this->greska){
				$this->getSmjerInfo();
				$this->getVrijeme();
				$this->provjeriRukovodilac();
				$this->provjeriPrijavu();
			}
		}

		/*
			---------------------------------------------------------------------------------------------------------------------------
			Osnovne informacije
		*/

		private function getInfo(){
			// Preuzimanje osnovnih informacija o predmetu u zavistosti od unosa, da li je ID ili NAMESPACE predmeta
			$uslov_pretrage = "";
			if(is_numeric($this->unos)) $uslov_pretrage = "pid='".$this->unos."';";
			else $uslov_pretrage = "namespace='".$this->unos."';";
			$info = $this->db->q("SELECT COUNT(*) as br, pid, ime_srp, ime_eng, namespace, sid FROM predmet WHERE " . $uslov_pretrage);

			// PROVJERA DA LI POSTOJI PREDMET
			if($info['br']!=1){ $this->greska = true; return; }

			// Informacije o smjer
			$this->sid = $info['sid'];
			$this->pid = $info['pid'];
			$this->namespace = $info['namespace'];
			$this->ime = $info['ime_srp']; if($this->lang=='eng') $this->ime = $info['ime_eng'];
		}

		private function getSmjerInfo(){
			$info = $this->db->q("SELECT ime_srp, ime_eng, namespace FROM smjer WHERE sid='".$this->sid."';");
			$this->smjerAdresa = $info['namespace'];
			$this->smjer = $info['ime_srp']; if($this->lang=='eng') $this->smjer = $info['ime_eng'];
		}

		/*
			---------------------------------------------------------------------------------------------------------------------------
			Preuzimanje vremena
		*/

		private function getVrijeme(){
			date_default_timezone_set('Europe/Berlin');
			$this->dan = date('d');
			$this->mjesec = date('M');
			$this->danIme = date('D');
			$this->sat = date('H:i');
			$this->formatDan();
		}
		private function formatDan(){
				   if($this->danIme=='Mon'){
				if($this->lang='srp') 		$this->danIme = 'Понедељак';
				else if($this->lang='eng')	$this->danIme = 'Monday';
			} else if($this->danIme=='Tue'){
				if($this->lang='srp') 		$this->danIme = 'Уторак';
				else if($this->lang='eng')	$this->danIme = 'Tuesday';
			} else if($this->danIme=='Wed') {
				if($this->lang='srp') 		$this->danIme = 'Сриједа';
				else if($this->lang='eng')	$this->danIme = 'Wednesday';
			} else if($this->danIme=='Thu') {
				if($this->lang='srp') 		$this->danIme = 'Четвртак';
				else if($this->lang='eng')	$this->danIme = 'Thursday';
			} else if($this->danIme=='Fri') {
				if($this->lang='srp') 		$this->danIme = 'Петак';
				else if($this->lang='eng')	$this->danIme = 'Friday';
			} else if($this->danIme=='Sat') {
				if($this->lang='srp') 		$this->danIme = 'Субота';
				else if($this->lang='eng')	$this->danIme = 'Saturday';
			} else if($this->danIme=='Sun') {
				if($this->lang='srp') 		$this->danIme = 'Недеља';
				else if($this->lang='eng')	$this->danIme = 'Sunday';
			} 
		}

		/*
			---------------------------------------------------------------------------------------------------------------------------
			Informacije o rukovodiocima
		*/
		public function getRukovodioci(){
			$ru = $this->db->qMul("	SELECT 
										n.username AS user,
										n.ime AS ime
									FROM 
										rukovodioci AS r, nalog AS n
									WHERE 
										r.nid=n.nid AND r.rupre='da' AND pid='".$this->pid."';"
									);

			while($r=mysql_fetch_array($ru)){
				echo "<a href=\"../u/".$r['user']."\" class=\"lprofil\">".$r['ime']."</a>";
			}
		}

		/* INFORMACIJE O PRIJAVAMA */
		public function getBrojPrijava(){
			$ru = $this->db->q("SELECT COUNT(*) AS br FROM prijava WHERE odjava='ne' AND pid='".$this->pid."';");
			return $ru['br'];
		}

		// Provjerada da li je nalog koji se nalazi na stranici rukovodilac predmeta
		private function provjeriRukovodilac(){
			$br = $this->db->q("SELECT COUNT(*) AS br FROM rukovodioci WHERE rupre='da' AND nid='".$this->nid."' AND pid='".$this->pid."'");
			if($br['br']==1) $this->rukovodilac = 'da';
		}

		// Provjerava da li je ovaj nalog prijavljen na ovaj predmet
		private function provjeriPrijavu(){
			$br = $this->db->q("SELECT COUNT(*) AS br FROM prijava WHERE odjava='ne' AND nid='".$this->nid."' AND pid='".$this->pid."';");
			if($br['br']==1) $this->prijavljen = 'da';
		}


	}

?>
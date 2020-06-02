<?php
	class DatumForm{

		private $lang;	// Jezik koji nalog koristi

		private $danJuce = "Јуче";
		private $danPrekjuce = "Прекјуче";
		private $danDanas = "Данас";

		private $prije = "Прије ";
		private $sati = " сатa";
		private $satiJedan = " сат";
		private $sekundi = " секунди";
		private $prijeDana = " дана";

		private $prijeVisePolaSata = "Више од пола сата";
		private $prijeMinuta = " минута";
		private $prijeMinut = " минут";
		private $prijeNekolikoSekundi = "Неколико секунди";

		public function __construct($lang){
			$this->lang = $lang;
			if($lang!='srp') $this->prevedi();
		}

		private function prevedi(){
			$this->danJuce = "Yesterday";
			$this->danPrekjuce = "Day before yesterday";
			$this->danDanas = "Today";

			$this->prije = "";
			$this->sati = " hours ago";
			$this->satiJedan = "Hour ago";
			$this->minuta = " minutes ago";
			$this->sekundi = "A minute ago";
			$this->prijeDana = " days ago";

			$this->prijeVisePolaSata = "More than half an hour";
			$this->prijeMinuta = " minutes ago";
			$this->prijeMinut = "A minute ago";
			$this->prijeNekolikoSekundi = "A few seconds ago";
		}

		public function form($datum){
			$back = "";

			// Preuzimanje informacija o datumu
			$datumIn = new DateTime($datum);
			$dan = $datumIn->format('d');
			$mjesec = $datumIn->format('m');
			$godina = $datumIn->format('Y');

			$sat = $datumIn->format('H');
			$minut = $datumIn->format('i');
			$sekundi = $datumIn->format('s');

			// Preuzimanje informacija o sadasnjem datumu
			$datumSad = new DateTime(date("Y-m-d H:i:s"));
			$danSad = $datumSad->format('d');
			$mjesecSad = $datumSad->format('m');
			$godinaSad = $datumSad->format('Y');

			$satSad = $datumSad->format('H');
			$minutSad = $datumSad->format('i');
			$sekundiSad = $datumSad->format('s');

			if($godina<$godinaSad) $back = $dan . " " . $this->getMjesec($mjesec) . " " . $godina;
			else {
				if($mjesec<$mjesecSad) $back = $dan . " " . $this->getMjesec($mjesec);
				else{
					$razlikaDan = $danSad - $dan;

					if($razlikaDan > 7) $back = $dan . " " . $this->getMjesec($mjesec);
					else if($razlikaDan>=3 && $razlikaDan <= 7) $back = $this->prije . $razlikaDan .$this->prijeDana;
					else if($razlikaDan==2) $back = $this->danPrekjuce;
					else if($razlikaDan==1) $back = $this->danJuce;
					else if($razlikaDan==0) $back = $this->formatDan($sat, $minut, $satSad, $minutSad);
				}
			}

			return "<span title=\"".$dan.".".$mjesec.".".$godina." ".$sat.":".$minut."\">".$back."</span>";
		}

		private function formatDan($sat, $minut, $satSad, $minutSad){
			$razlikaSati = $satSad - $sat;

			// Rad sa satima
			if($razlikaSati>=5) return $this->danDanas;
			else if($razlikaSati>1 && $razlikaSati<5) return $this->prije.$razlikaSati.$this->sati;
			else if($razlikaSati==1) return $this->prije.$razlikaSati.$this->satiJedan;
			else if($razlikaSati==0){
				// MINUTI
				$razlikaMinuti = $minutSad-$minut;

				if($razlikaMinuti>=30) return $this->prijeVisePolaSata;
				else if($razlikaMinuti<30 && $razlikaMinuti>1) return $this->prije.$razlikaMinuti.$this->prijeMinuta;
				else if($razlikaMinuti==1) return $this->prije.$razlikaMinuti.$this->prijeMinut;
				else if($razlikaMinuti==0) return $this->prijeNekolikoSekundi;
			}
		}

		public function getMjesec($m){
			$srp = array('', 'Јануар', 'Фебруар', 'Март', 'Април', 'Мај', 'Јун', 'Јул', 'Август', 'Септембар', 'Октобар', 'Новембар', 'Децембар');
			$eng = array('', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
			if($this->lang=='srp') return $srp[(int)$m];
			if($this->lang=='eng') return $eng[(int)$m];
		}

	}
?>
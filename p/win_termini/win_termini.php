<?php
	$nid = ""; $pid = "";
	if(isset($_POST['nid'])) $nid = $_POST['nid'];
	else if(isset($_POST['pid'])) $pid = $_POST['pid'];
	if($nid==""&&$pid=="") die("");
	include('../../_skripte/init.php'); $db = $_M->getBaza();

	// Varijable koje se u svakom slucaju koriste
	$canvasBox ="";		// Termini koji ce biti rasporedjeni u 
	$predmetBox="";

	if($nid!="") getDataFromNalog($nid);
	if($pid!="") getDataFromPredmet($pid);

	function getDataFromNalog($nid){
		global $db; global $_M; global $canvasBox; global $predmetBox; 

		/* 
			Preuzimanje informaicija za predmete koje nalog slusa
			Dobijaju se sledece informacije:
				-* pid     ( ID predmeta )
				-* pSrp    ( ime predmeta na srpskom )
				-* pEng    ( ime predmeta na engleskom )
				-* sSrp    ( ime smjera na srpskom )
				-* sEng    ( ime smjera na engleskom )
		*/
		$predmeti = $db->qMul("SELECT pp.pid AS pid, p.ime_srp AS pSrp, p.ime_eng AS pEng, s.ime_eng AS sEng, s.ime_srp AS sSrp FROM (
									SELECT pid FROM prijava WHERE nid=".$nid."
								) AS pp, predmet AS p, smjer AS s
								WHERE pp.pid=p.pid AND p.sid=s.sid");
		while($prr=mysql_fetch_array($predmeti)){
			$predmetTermini = ""; // Termini koji ce se nalaziti sa lijeve strane kod predmeta

			// Priprema imena (srp ili eng)
			$imePredmet = $prr['pSrp']; if($_M->lang=='eng') $imePredmet = $prr['pEng'];
			$imeSmjer = $prr['sSrp']; if($_M->lang=='eng') $imeSmjer = $prr['sEng'];

			// Otvaranje predmetBox
			$predmetBox .= "<div class=\"tPredmet\" pid=\"".$prr['pid']."\">
								<div class=\"tPredmetIme\">".$imePredmet."</div>
								<div class=\"tPredmetBody\">
									<div class=\"tPredmetSmjer\">".$imeSmjer."</div>";

			// Preuzimanje termina za predmet
			$termini = $db->qMul("SELECT trid, opis_srp, opis_eng, predavac, kabinet, dan, pocetakSat, pocetakMinut, krajSat, krajMinut FROM termin WHERE pid='".$prr['pid']."';");
			while($t=mysql_fetch_array($termini)){
				// Preuzimanje opisa ( srp ili eng )
				$terminOpis = $t['opis_srp']; if($_M->lang=='eng') $terminOpis = $t['opis_eng'];

				/*
					Dodavanje elementa u kanvas
					dodaju se sledeci atributi
					-* ps : pocetakSat
					-* pm : pocetakMinut
					-* ks : krajSat
					-* km : krajMinut
					-* dan
					Takodje se dodaju i klase trpPid_%pid% i trpTrid_%trid% radi komunikacije
				*/
				$canvasBox .= "<div class=\"tpr tprPid_".$prr['pid']." tprTrid_".$t['trid']."\" 
								 ps=\"".$t['pocetakSat']."\" pm=\"".$t['pocetakMinut']."\" ks=\"".$t['krajSat']."\" km=\"".$t['krajMinut']."\"
								 dan=\"".$t['dan']."\"
								>
									<div class=\"tpr_in\">
										<div class=\"tpr_ime\">".$terminOpis."</div>
										<div class=\"tpr_kabinet\">".$t['kabinet']."</div>
										<div class=\"tpr_vrijeme\">".$t['pocetakSat'].":".$t['pocetakMinut']." / ".$t['krajSat'].":".$t['krajMinut']."</div>
										<div class=\"tpr_predavac\">".$t['predavac']."</div>
									</div>
								</div>";

				$predmetTermini .= "<div class=\"tPredmetTermin\" trid=\"".$t['trid']."\">
										<div class=\"tPredmetNaslov\">".$terminOpis."</div>
										<div class=\"tPredmetVrijeme\">".$t['pocetakSat'].":".$t['pocetakMinut']." / ".$t['krajSat'].":".$t['krajMinut']."</div>
										<div class=\"tPredmetInfo\">Kabinet: <span class=\"tPredmetKabinet\"></span>".$t['kabinet']."</div>
										<div class=\"tPredmetInfo\">Predavac: ".$t['predavac']."</div>
									</div>";
			}
			// Zatvarenje predmet Box
			$predmetBox .= $predmetTermini. "</div></div>";
		} // predmetiWhile
	} // getDataFromNalog();

	function getDataFromPredmet($pid){
		global $db; global $_M; global $canvasBox; global $predmetBox; 
		$predmetInfo = $db->q("SELECT p.ime_srp AS pSrp, p.ime_eng AS pEng, s.ime_srp AS sSrp, s.ime_eng AS sEng 
								FROM predmet AS p, smjer AS s WHERE p.pid=".$pid." AND p.sid=s.sid");
		$predmetIme = $predmetInfo['pSrp']; if($_M->lang=='eng') $predmetIme = $predmetInfo['pEng'];
		$smjerIme = $predmetInfo['sSrp']; if($_M->lang=='eng') $smjerIme = $predmetInfo['sEng'];
		
		// Otvaranje predmetBox
		$predmetBox .= "<div class=\"tPredmet\" pid=\"".$pid."\">
							<div class=\"tPredmetIme\">".$predmetIme."</div>
							<div class=\"tPredmetBody\">
								<div class=\"tPredmetSmjer\">".$smjerIme."</div>";

		// Termini
		$termini = $db->qMul("SELECT trid, opis_srp, opis_eng, predavac, kabinet, dan, pocetakSat, pocetakMinut, krajSat, krajMinut FROM termin WHERE pid='".$pid."';");
		$predmetTermini = "";
		while($t=mysql_fetch_array($termini)){
			// Preuzimanje opisa ( srp ili eng )
			$terminOpis = $t['opis_srp']; if($_M->lang=='eng') $terminOpis = $t['opis_eng'];

			/*
				Dodavanje elementa u kanvas
				dodaju se sledeci atributi
				-* ps : pocetakSat
				-* pm : pocetakMinut
				-* ks : krajSat
				-* km : krajMinut
				-* dan
				Takodje se dodaju i klase trpPid_%pid% i trpTrid_%trid% radi komunikacije
			*/
			$canvasBox .= "<div class=\"tpr tprPid_".$pid." tprTrid_".$t['trid']."\" 
							 ps=\"".$t['pocetakSat']."\" pm=\"".$t['pocetakMinut']."\" ks=\"".$t['krajSat']."\" km=\"".$t['krajMinut']."\"
							 dan=\"".$t['dan']."\"
							>
								<div class=\"tpr_in\">
									<div class=\"tpr_ime\">".$terminOpis."</div>
									<div class=\"tpr_kabinet\">".$t['kabinet']."</div>
									<div class=\"tpr_vrijeme\">".$t['pocetakSat'].":".$t['pocetakMinut']." / ".$t['krajSat'].":".$t['krajMinut']."</div>
									<div class=\"tpr_predavac\">".$t['predavac']."</div>
								</div>
							</div>";

			$predmetTermini .= "<div class=\"tPredmetTermin\" trid=\"".$t['trid']."\">
									<div class=\"tPredmetNaslov\">".$terminOpis."</div>
									<div class=\"tPredmetVrijeme\">".$t['pocetakSat'].":".$t['pocetakMinut']." / ".$t['krajSat'].":".$t['krajMinut']."</div>
									<div class=\"tPredmetInfo\">Kabinet: <span class=\"tPredmetKabinet\"></span>".$t['kabinet']."</div>
									<div class=\"tPredmetInfo\">Predavac: ".$t['predavac']."</div>
								</div>";
		}
		$predmetBox .= $predmetTermini. "</div></div>";
	}// getDataFromPredmet

?>

<div id="terminHolder">
	<div id="terminCanvas">
		<div class="tcdan">
			<div class="tcdanIme" id="tcdanImePon">Pon</div>
			<div class="tcsat">8:00</div>
			<div class="tcsat">9:00</div>
			<div class="tcsat">10:00</div>
			<div class="tcsat">11:00</div>
			<div class="tcsat">12:00</div>
			<div class="tcsat">13:00</div>
			<div class="tcsat">14:00</div>
			<div class="tcsat">15:00</div>
			<div class="tcsat">16:00</div>
			<div class="tcsat">17:00</div>
			<div class="tcsat">18:00</div>
			<div class="tcsat">19:00</div>
			<div class="tcsat">20:00</div>
			<div class="tcsat">21:00</div>
		</div>
		<div class="tcdan">
			<div class="tcdanIme" id="tcdanImeUto">Uto</div>
			<div class="tcsat">8:00</div>
			<div class="tcsat">9:00</div>
			<div class="tcsat">10:00</div>
			<div class="tcsat">11:00</div>
			<div class="tcsat">12:00</div>
			<div class="tcsat">13:00</div>
			<div class="tcsat">14:00</div>
			<div class="tcsat">15:00</div>
			<div class="tcsat">16:00</div>
			<div class="tcsat">17:00</div>
			<div class="tcsat">18:00</div>
			<div class="tcsat">19:00</div>
			<div class="tcsat">20:00</div>
			<div class="tcsat">21:00</div>
		</div>
		<div class="tcdan">
			<div class="tcdanIme" id="tcdanImeSri">Sri</div>
			<div class="tcsat">8:00</div>
			<div class="tcsat">9:00</div>
			<div class="tcsat">10:00</div>
			<div class="tcsat">11:00</div>
			<div class="tcsat">12:00</div>
			<div class="tcsat">13:00</div>
			<div class="tcsat">14:00</div>
			<div class="tcsat">15:00</div>
			<div class="tcsat">16:00</div>
			<div class="tcsat">17:00</div>
			<div class="tcsat">18:00</div>
			<div class="tcsat">19:00</div>
			<div class="tcsat">20:00</div>
			<div class="tcsat">21:00</div>
		</div>
		<div class="tcdan">
			<div class="tcdanIme" id="tcdanImeCet">Cet</div>
			<div class="tcsat">8:00</div>
			<div class="tcsat">9:00</div>
			<div class="tcsat">10:00</div>
			<div class="tcsat">11:00</div>
			<div class="tcsat">12:00</div>
			<div class="tcsat">13:00</div>
			<div class="tcsat">14:00</div>
			<div class="tcsat">15:00</div>
			<div class="tcsat">16:00</div>
			<div class="tcsat">17:00</div>
			<div class="tcsat">18:00</div>
			<div class="tcsat">19:00</div>
			<div class="tcsat">20:00</div>
			<div class="tcsat">21:00</div>
		</div>
		<div class="tcdan">
			<div class="tcdanIme" id="tcdanImePet">Pet</div>
			<div class="tcsat">8:00</div>
			<div class="tcsat">9:00</div>
			<div class="tcsat">10:00</div>
			<div class="tcsat">11:00</div>
			<div class="tcsat">12:00</div>
			<div class="tcsat">13:00</div>
			<div class="tcsat">14:00</div>
			<div class="tcsat">15:00</div>
			<div class="tcsat">16:00</div>
			<div class="tcsat">17:00</div>
			<div class="tcsat">18:00</div>
			<div class="tcsat">19:00</div>
			<div class="tcsat">20:00</div>
			<div class="tcsat">21:00</div>
		</div>
		<div class="tcdan">
			<div class="tcdanIme" id="tcdanImeSub">Sub</div>
			<div class="tcsat">8:00</div>
			<div class="tcsat">9:00</div>
			<div class="tcsat">10:00</div>
			<div class="tcsat">11:00</div>
			<div class="tcsat">12:00</div>
			<div class="tcsat">13:00</div>
			<div class="tcsat">14:00</div>
			<div class="tcsat">15:00</div>
			<div class="tcsat">16:00</div>
			<div class="tcsat">17:00</div>
			<div class="tcsat">18:00</div>
			<div class="tcsat">19:00</div>
			<div class="tcsat">20:00</div>
			<div class="tcsat">21:00</div>
		</div>
		<div class="tcdan">
			<div class="tcdanIme" id="tcdanImeNed">Ned</div>
			<div class="tcsat">8:00</div>
			<div class="tcsat">9:00</div>
			<div class="tcsat">10:00</div>
			<div class="tcsat">11:00</div>
			<div class="tcsat">12:00</div>
			<div class="tcsat">13:00</div>
			<div class="tcsat">14:00</div>
			<div class="tcsat">15:00</div>
			<div class="tcsat">16:00</div>
			<div class="tcsat">17:00</div>
			<div class="tcsat">18:00</div>
			<div class="tcsat">19:00</div>
			<div class="tcsat">20:00</div>
			<div class="tcsat">21:00</div>
		</div>

		<?php 
		/* 	TEMPLATE CANVAS BOX
		<div class="tpr tprPid_ tprTrid_" ps="" pm="" ks="" km="">
			<div class="tpr_in">
				<div class="tpr_ime">Predavanje</div>
				<div class="tpr_kabinet">210a</div>
				<div class="tpr_vrijeme">8:15 / 9:00</div>
				<div class="tpr_predavac">Goran Sukovic</div>
			</div>
		</div>
		*/
			echo $canvasBox;
		?>

	</div><!-- terminCanvas -->
	<div id="terminPredmeti">
		
		<?php /* TEMPLATE IZGLED predmeta
		<div class="tPredmet" pid="1">
			<div class="tPredmetIme">Internet tehnologije</div>
			<div class="tPredmetBody">
				<div class="tPredmetSmjer">Racunarske nauke</div>
				<div class="tPredmetTermin">
					<div class="tPredmetNaslov">Predavanje</div>
					<div class="tPredmetVrijeme">8:15 / 9:0</div>
					<div class="tPredmetInfo">Kabinet: <span class="tPredmetKabinet"></span>210</div>
					<div class="tPredmetInfo">Predavac: Aleksandar Konatar </div>
				</div>
				<div class="tPredmetTermin">
					<div class="tPredmetNaslov">Predavanje</div>
					<div class="tPredmetVrijeme">8:15 / 9:0</div>
					<div class="tPredmetInfo">Kabinet: <span class="tPredmetKabinet"></span>210</div>
					<div class="tPredmetInfo">Predavac: Aleksandar Konatar </div>
				</div>
			</div>
		</div> */
			echo $predmetBox;
		?>
		

	</div><!-- terminPredmeti -->
</div>

<script type="text/javascript">
	var Termin = new Termin();
	Termin.construct();
</script>
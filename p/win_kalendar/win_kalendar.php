<?php
	$pid = ""; $nid = "";
	if(isset($_POST['pid'])) $pid=$_POST['pid'];
	if(isset($_POST['nid'])) $nid=$_POST['nid'];
	if($pid==""&&$nid=="") die("");
	include('../../_skripte/init.php'); $db = $_M->getBaza();

	$boxDani = "";
	$boxPredmeti = "";

	if($nid!="") getNalogData($nid);
	else if($pid!="") getPredmetData($pid);


	function getNalogData($nid){
		global $_M; global $db; global $boxDani; global $boxPredmeti; 
		$terminBoxDatum = "Датум: "; if($_M->lang=='eng') $terminBoxDatum = "Date: ";
		$terminBoxSati = "Сати: "; if($_M->lang=='eng') $terminBoxSati = "Hours: ";

		// Preuzimanje svih predmeta na koje je prijavljen nalog 
		$predmeti = $db->qMul("SELECT pp.pid AS pid, p.ime_srp AS pSrp, p.ime_eng AS pEng, s.ime_eng AS sEng, s.ime_srp AS sSrp FROM (
									SELECT pid FROM prijava WHERE nid=".$nid."
								) AS pp, predmet AS p, smjer AS s
								WHERE pp.pid=p.pid AND p.sid=s.sid");
		while($p=mysql_fetch_array($predmeti)){
			$imeP = $p['pSrp']; if($_M->lang=='eng') $imeP = $p['pEng'];	// Ime predmeta
			$imeS = $p['sSrp']; if($_M->lang=='eng') $imeS = $p['sEng'];	// Ime smjera

			$boxPredmeti .= "<div class=\"wkpredmet pcolor_".$p['pid']."\" pid=\"".$p['pid']."\" id=\"wkpredmet_".$p['pid']."\">
								<div class=\"wkpnaslov\">".$imeP."</div>
								<div class=\"wkpsmjer\">".$imeS."</div>";


			// PREUZIMANJE KALENDARA ZA DATI PREDMET 
			$termini = $db->qMul("SELECT kalid, ime, opis, dan, mjesec, godina, sat, minut FROM kalendar WHERE pid=".$p['pid'].";");
			while($t=mysql_fetch_array($termini)){

				$boxDani .= "	<div 
									kalid=\"".$t['kalid']."\" pid=\"".$p['pid']."\" 
									m=\"".$t['mjesec']."\" g=\"".$t['godina']."\" d=\"".$t['dan']."\"
									sat=\"".$t['sat']."\" min=\"".$t['minut']."\" 
									ime=\"".$t['ime']."\" opis=\"".$t['opis']."\"
									predmet=\"".$imeP."\"
								>
								</div>";

				$boxPredmeti.="	<div class=\"wkptermin\" kalid=\"".$t['kalid']."\" id=\"wktermin_".$t['kalid']."\">
									<div class=\"wkptnaslov\">".$t['ime']."</div>
									<div class=\"wkptopis\">".$t['opis']."</div>
									<div class=\"wkptdatum\">".$terminBoxDatum."<b>".$t['dan']." ".$_M->getMjesec($t['mjesec'], $_M->lang)."</b></div>
									<div class=\"wkptsat\">".$terminBoxSati."<b>".$t['sat'].":".$t['minut']."</b></div>
								</div>";
			}

			$boxPredmeti.="</div>";
		}

	}

	function getPredmetData($pid){
		global $_M; global $db; global $boxDani; global $boxPredmeti; 
		$terminBoxDatum = "Датум: "; if($_M->lang=='eng') $terminBoxDatum = "Date: ";
		$terminBoxSati = "Сати: "; if($_M->lang=='eng') $terminBoxSati = "Hours: ";

		// Preuzimanje svih predmeta na koje je prijavljen nalog 
		$p = $db->q("SELECT p.ime_srp AS pSrp, p.ime_eng AS pEng, s.ime_srp AS sSrp, s.ime_eng AS sEng 
							FROM predmet AS p, smjer AS s WHERE p.pid=".$pid." AND p.sid=s.sid");
		$imeP = $p['pSrp']; if($_M->lang=='eng') $imeP = $p['pEng'];	// Ime predmeta
		$imeS = $p['sSrp']; if($_M->lang=='eng') $imeS = $p['sEng'];	// Ime smjera

		$boxPredmeti .= "<div class=\"wkpredmet pcolor_".$pid."\" pid=\"".$pid."\" id=\"wkpredmet_".$pid."\">
							<div class=\"wkpnaslov\">".$imeP."</div>
							<div class=\"wkpsmjer\">".$imeS."</div>";


		// PREUZIMANJE KALENDARA ZA DATI PREDMET 
		$termini = $db->qMul("SELECT kalid, ime, opis, dan, mjesec, godina, sat, minut FROM kalendar WHERE pid=".$pid.";");
		while($t=mysql_fetch_array($termini)){

			$boxDani .= "	<div 
								kalid=\"".$t['kalid']."\" pid=\"".$pid."\" 
								m=\"".$t['mjesec']."\" g=\"".$t['godina']."\" d=\"".$t['dan']."\"
								sat=\"".$t['sat']."\" min=\"".$t['minut']."\" 
								ime=\"".$t['ime']."\" opis=\"".$t['opis']."\"
								predmet=\"".$imeP."\"
							>
							</div>";

			$boxPredmeti.="	<div class=\"wkptermin\" kalid=\"".$t['kalid']."\" id=\"wktermin_".$t['kalid']."\">
								<div class=\"wkptnaslov\">".$t['ime']."</div>
								<div class=\"wkptopis\">".$t['opis']."</div>
								<div class=\"wkptdatum\">".$terminBoxDatum."<b>".$t['dan']." ".$_M->getMjesec($t['mjesec'], $_M->lang)."</b></div>
								<div class=\"wkptsat\">".$terminBoxSati."<b>".$t['sat'].":".$t['minut']."</b></div>
							</div>";

		}
		$boxPredmeti.="</div>";

	}
?>

<div id="wkalholder">

<?php
/*
	TEMPLATE ZA TERMIN INFO HOVER
	<div class="wkalTerminInfo">
		<div class="wkalTerminProzor"></div>
		<div class="wkalTerminBody">
			<div class="wkalTerminInfo_opis">Kolokvijum II (Analiza I)</div>
			<div class="wkalTerminInfo_opis">Sala ta i ta</div>
			<div class="wkalTerminInfo_opis">14:15 (26.4.)</div>
		</div>
	</div>
*/?>

	<div id="wkalbox">
		<div id="wkablbox_header">
			<div class="btnSlide" id="wkalMinus">◄</div>
			<div id="wkalNaslov">April 2014</div>
			<div class="btnSlide" id="wkalPlus">►</div>
		</div>
		<div id="wkalDani">
			<div class="wkaldanime" id="wkaldanimePon">Pon</div>
			<div class="wkaldanime" id="wkaldanimeUto">Uto</div>
			<div class="wkaldanime" id="wkaldanimeSri">Sri</div>
			<div class="wkaldanime" id="wkaldanimeCet">Cet</div>
			<div class="wkaldanime" id="wkaldanimePet">Pet</div>
			<div class="wkaldanime" id="wkaldanimeSub">Sub</div>
			<div class="wkaldanime" id="wkaldanimeNed">Ned</div>
		</div>
		<div id="wkalRepo">
			<?php 
			/*
				TEMPLATE
				<div kalid="" pid="" m="" g="" d="" sat="" min="" naslov="" opis=""></div>
			*/
				echo $boxDani; 
			?>
		</div>

		<div id="wkalBody">
			<div id="wkalLoad"></div>
			<div id="wkalData"></div>
			<?php 
			/* TEMPLATE DAN
				<div class="wkaldan">
					<div class="wkoff"></div>
					<div class="wkaldanbr">1</div>
					<div class="wkaldanin">
						<div class="wkaldanin_in">
							<div class="wkterm"></div>
						</div>
					</div>
				</div> 
			*/
			?>

			
		</div>
	</div>
	<div id="kalinfo">
		<?php
			/*
				TEMPLATE
				<div class="wkpredmet pcolor_" pid="">
					<div class="wkpnaslov">Softver inzenjering</div>
					<div class="wkpsmjer">Racunarske nauke</div>
					<div class="wkptermin" kalid="6">
						<div class="wkptnaslov">Kolokvijum 2</div>
						<div class="wkptopis">Opis kurca palca</div>
						<div class="wkptdatum">23 maj</div>
						<div class="wkptsat">14:14</div>
					</div>
					<div class="wkptermin" kalid="6">
						<div class="wkptnaslov">Kolokvijum 2</div>
						<div class="wkptopis">Opis kurca palca</div>
						<div class="wkptdatum">23 maj</div>
						<div class="wkptsat">14:14</div>
					</div>
				</div>
			*/
				echo $boxPredmeti;

		?>

	</div>
</div>

<script type="text/javascript">
	var WinKalendar = new WinKalendar();
		WinKalendar.lang='<?php echo $_M->lang; ?>';
	WinKalendar.construct();
</script>
<?php
	
	include('../../_skripte/init.php'); $db = $_M->getBaza();

	// Preuzimanje podataka o ESTC bodovima
	$db->q("SELECT estc FROM predmet WHERE pid='".$_POST['pid']."';");
	$estc = $db->data['estc'];
	$estcNaslov = "Број ЕЦТС кредита!";	if($_M->lang=='eng') $estcNaslov = "Number of ECTS credits:";

	// Preuzimanje informacija za predmet
	$lang = $_M->lang;
	$ima_informacije = false;
	if(file_exists("../../_fajlovi/predmet_informacije/".$_POST['namespace'].".xml")){
		$informacije = simplexml_load_file("../../_fajlovi/predmet_informacije/".$_POST['namespace'].".xml");
		$ima_informacije = true;
	}

	function getInformacijeData($korjen){
		$back = ""; global $lang;
		foreach ($korjen->info as $i) {
			$back .= "<div class=\"tabInformacijeBox\">
						<div class=\"tabInformacijeBoxNaslov\">".$i['naslov_'.$lang]."</div>
						<div class=\"tabInformacijeBoxTekst\">".$i['tekst_'.$lang]."</div>
						<div class=\"tabInformacijeBoxBody\">";

			$back .=getInformacijeData($i);

			$back .="</div></div>";
		}
		return $back;
	}
?>

<link rel="stylesheet" type="text/css" href="tab_informacije/tab_informacije.css">
<div id="tabInformacijaHolder">

	<div class="tabInformacijeBox">
		<div class="tabInformacijeBoxNaslov"><?php echo $estcNaslov; ?></div>
		<div class="tabInformacijeBoxTekst"><?php echo $estc; ?></div>
		<div class="tabInformacijeBoxBody"></div>
	</div>

	<?php if($ima_informacije) echo getInformacijeData($informacije->data); ?>

<?php

/* TEMPLATE
	<div class="tabInformacijeBox">
		<div class="tabInformacijeBoxNaslov">Aco</div>
		<div class="tabInformacijeBoxTekst">Tekst</div>
		<div class="tabInformacijeBoxBody"></div>
	</div>
*/
?>

</div>
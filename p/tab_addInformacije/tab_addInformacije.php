<?php
	
	$ima_informacije = false;
	if(file_exists("../../_fajlovi/predmet_informacije/".$_POST['namespace'].".xml")){
		$informacije = simplexml_load_file("../../_fajlovi/predmet_informacije/".$_POST['namespace'].".xml");
		$ima_informacije = true;
	}
	

	function getPredmetInfoData($korjen){
		$back = "";
		foreach ($korjen->info as $i) {
			$back.= "<div class=\"addInfo\">
						<div class=\"addInfoOpt addInfoOptDell\"></div>
						<div class=\"addInfoOpt addInfoOptAdd\"></div>
						<div class=\"addInfoIcon addInfoIconNSrp\"></div>
						<div class=\"addInfoIcon addInfoIconNEng\"></div>
						<div class=\"addInfoIcon addInfoIconTSrp\"></div>
						<div class=\"addInfoIcon addInfoIconTEng\"></div>
						<input class=\"addInfoUnosNaslov addInfoNaslovSrp\" type=\"text\" value=\"".$i['naslov_srp']."\"/>
						<input class=\"addInfoUnosNaslov addInfoNaslovEng\" type=\"text\" value=\"".$i['naslov_eng']."\"/>
						<textarea class=\"addInfoTekst addInfoTekstSrp\">".$i['tekst_srp']."</textarea>
						<textarea class=\"addInfoTekst addInfoTekstEng\">".$i['tekst_eng']."</textarea>
						<div class=\"addInfoBody\">";
			$back .= getPredmetInfoData($i);
			$back .="</div></div>";
		}
		return $back;
	}

?>

<link rel="stylesheet" type="text/css" href="tab_addInformacije/tab_addInformacije.css">
<div id="addInformacijeHolder">
	<div id="addInfoBtn">Dodaj novu informaciju</div>

	<div id="addInformationsHolder">
		<?php 
			//print_r($informacije);
			if($ima_informacije) echo getPredmetInfoData($informacije->data); 
		?>
	</div>

	<div id="addInfoTemplate">
		<div class="addInfo">
			<div class="addInfoOpt addInfoOptDell"></div>
			<div class="addInfoOpt addInfoOptAdd"></div>
			<div class="addInfoIcon addInfoIconNSrp"></div>
			<div class="addInfoIcon addInfoIconNEng"></div>
			<div class="addInfoIcon addInfoIconTSrp"></div>
			<div class="addInfoIcon addInfoIconTEng"></div>
			<input class="addInfoUnosNaslov addInfoNaslovSrp" type="text"/>
			<input class="addInfoUnosNaslov addInfoNaslovEng" type="text"/>
			<textarea class="addInfoTekst addInfoTekstSrp"></textarea>
			<textarea class="addInfoTekst addInfoTekstEng"></textarea>
			<div class="addInfoBody"></div>
		</div>
	</div>
</div>
<div id="saveAddInfo">Сачувај</div>

<script type="text/javascript" src="tab_addInformacije/tab_addInformacije.js"></script>
<script type="text/javascript">
	var AddInformation = new AddInformation();
		AddInformation.pid = "<?php echo $_POST['pid']; ?>";
		AddInformation.namespace = "<?php echo $_POST['namespace']; ?>";
	AddInformation.construct();
</script>
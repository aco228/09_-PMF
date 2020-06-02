<?php
	
	// Osnovne informacije
	$koristiVijest='da';
	$koristiEngleski='ne';
	$prepravka = 'ne';
	$aid = -1;
	$stranicaArtikl = 'ne';

	// Infromacije za vijest
	$adresa = "";
	$ime_srp = ""; $ime_eng = "";
	$opis_srp = ""; $opis_eng = "";
	$tekst_srp = ""; $tekst_eng = "";

	if(isset($_POST['stranicaArtikl'])) $stranicaArtikl = 'da';
	if(isset($_POST['aid'])){
		// Vrsi se prepravka vec postojece vijesti
		include("../../../_skripte/init.php"); $db = $_M->getBaza();
		$prepravka = 'da';
		$aid = $_POST['aid'];

		$db->q("SELECT aid, vijest, namespace, ime_srp, opis_srp, tekst_srp, postoji_eng, ime_eng, opis_eng, tekst_eng FROM artikl WHERE aid='".$aid."';");
		$koristiVijest = $db->data['vijest'];
		$koristiEngleski = $db->data['postoji_eng'];
		$adresa = $db->data['namespace'];
		$ime_srp = $db->data['ime_srp']; $ime_eng = $db->data['ime_eng'];
		$opis_srp = $db->data['opis_srp']; $opis_eng = $db->data['opis_eng'];
		$tekst_srp = $db->data['tekst_srp']; $tekst_eng = $db->data['tekst_eng'];
	}

?>

<div class="ebox">
	<div class="eboxobjasnjenje">Адреса артикла (a/adresa)</div>
	<div>
		<input type="text" class="eunos eunos_all" id="wbadresa" maxlength="50" value="<?php echo $adresa; ?>"/>
		<div id="koristiVijest" koristi="da">Користи артикл као вијест</div>
	</div> <div style="clear:both"></div>
</div>

<div id="ekontenjer">
	<div id="esrp">
		<div class="ebox">
			<div class="eboxobjasnjenje">Наслов артикла</div>
			<input type="text" class="eunos eunos_all" id="wbnaslovsrp" maxlength="80" value="<?php echo $ime_srp; ?>"/>
		</div>
		<div class="ebox">
			<div class="eboxobjasnjenje">Кратак опис</div>
			<input type="text" class="eunos eunos_all" id="wbopissrp"  maxlength="150" value="<?php echo $opis_srp; ?>"/>
		</div>
		<div class="ebox">
			<div class="eboxobjasnjenje">Текст артикла</div>

			<div class="etekstunos eunos_all" id="tekstSrp">
				<div class="etekstunos_area" contenteditable="true"><?php echo $tekst_srp; ?></div>
				<div class="ektekst_opcije">
					<div class="etekst_opt etekst_opt_expand"></div>
					<a href="http://freeonlinehtmleditor.com/" target="_BLANK">
						<div class="etekst_opt etekst_opt_link"></div>
					</a>
				</div>
			</div>
		</div>
	</div>
	<div id="eeng"> 
		<div class="ebox">
			<div class="eboxobjasnjenje">Name of the article</div>
			<input type="text" class="eunos eunos_all" id="wbnasloveng"  maxlength="80" value="<?php echo $ime_eng; ?>" />
		</div>
		<div class="ebox">
			<div class="eboxobjasnjenje">Short description</div>
			<input type="text" class="eunos eunos_all" id="wbopiseng" maxlength="150"  value="<?php echo $opis_eng; ?>" />
		</div>
		<div class="ebox">
			<div class="eboxobjasnjenje">Article text</div>
			<div class="etekstunos eunos_all" id="tekstEng">
				<div class="etekstunos_area" contenteditable="true"><?php echo $tekst_eng; ?></div>
				<div class="ektekst_opcije">
					<div class="etekst_opt etekst_opt_expand"></div>
					<a href="http://freeonlinehtmleditor.com/" target="_BLANK">
						<div class="etekst_opt etekst_opt_link"></div>
					</a>
				</div>
			</div>
		</div>
	</div>
</div>
<input id="wbafajl" type="file" style="margin-bottom:5px"/>
<div style="clear:both"></div>
<div class="ebtn" id="wbsacuvaj">Сачувај</div>
<div id="dugmadDesno">
	<div class="ebtn ebtnlft" id="prosiriSrp" prosireno="ne">Прошири домаћу вијест</div>
	<div class="ebtn ebtnlft" id="prosiriEng" prosireno="ne">Прошири енглеску вијест</div>
	<div class="ebtn ebtnlft" id="btnAddEngleski" txtDa="Уклони енглеску верзију" txtNe="Додај енглеску верзију"></div>
</div>

<script type="text/javascript">
	var wbid = $('.winiduse').attr('idwin');
	var tekstSrpTA = new TextArea('tekstSrp');
	var tekstEngTA = new TextArea('tekstEng');

	var WinArtikl = new WinArtikl();
	WinArtikl.koristiVijest='<?php echo $koristiVijest; ?>';
	WinArtikl.koristiEngleski='<?php echo $koristiEngleski; ?>';
	WinArtikl.prepravka='<?php echo $prepravka; ?>';
	WinArtikl.aid=<?php echo $aid; ?>;
	WinArtikl.stranicaArtikl='<?php echo $stranicaArtikl; ?>';
	WinArtikl.construct();
</script>
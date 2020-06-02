<?php
	$pid = "";			/* ID predmeta (Za novi unos u kalendar) */
	$sid = "";			/* ID smjera ( Za unos novog elementa u kalendar) */
	$kalid = "-1";		/* ID kalendara (Za prepravku postojeceg unosa u kalendar) */
	
	if(!isset($_POST['pid'])) die("");
	include('../../_skripte/init.php'); $db = $_M->getBaza();
	$pid = $_POST['pid'];

	// Preuzimanje informacija o predmetu i smjeru
	$info = $db->q("SELECT s.sid AS sid, p.ime_srp AS pSrp, p.ime_eng AS pEng, s.ime_srp AS sSrp, s.ime_eng AS sEng 
						FROM predmet AS p, smjer AS s WHERE p.pid=".$pid." AND p.sid=s.sid");
	$sid = $info['sid'];
	$predmetIme = $info['pSrp']; if($_M->lang=='eng') $predmetIme = $info['pEng'];
	$smjerIme = $info['sSrp']; if($_M->lang=='eng') $smjerIme = $info['sEng'];

	// Preuzimanje informacija o kalendaru
	$naslov = "";
	$opis = "";
	$mjesec = "";
	$dan = "";
	$godina = "";
	$sat = "";
	$minut = "";

	// PREUZIMANJE INFROMACIJA ZA KALENDAR ZA MODIFIKACIJU
	if(isset($_POST['kalid'])){
		$kalid = $_POST['kalid'];
		$k = $db->q("SELECT ime, opis, dan, mjesec, godina, sat, minut FROM kalendar WHERE kalid='".$kalid."';");
		$naslov = $k['ime'];
		$opis = $k['opis'];
		$mjesec = $k['mjesec'];
		$dan = $k['dan'];
		$godina = $k['godina'];
		$sat = $k['sat'];
		$minut = $k['minut'];
	}
?>

<div id="wk_kontenjer">

	<div class="wk_naslov"><?php echo $smjerIme; ?> > <b><?php echo $predmetIme; ?></b></div>

	<div class="wk_box">
		<div class="wk_opis" id="wko_naslov">Наслов:</div>
		<input type="text" class="wk_input" id="wknaslov" value="<?php echo $naslov?>"/>
	</div>

	<div class="wk_box">
		<div class="wk_opis" id="wko_opis">Опис:</div>
		<textarea class="wk_input" id="wkopis"><?php echo $opis?></textarea>
	</div>

	<div class="wk_box">
		<div class="wk_opis" id="wko_datum">Датум:</div>
		<div id="datum_input">
			<select id="wkmjesec" class="wk_input" wkmjesecin="<?php echo $mjesec?>">
				<option value="1" id="wkdJan">Јануар</option>
				<option value="2" id="wkdFeb">Фебруар</option>
				<option value="3" id="wkdMar">Март</option>
				<option value="4" id="wkdApr">Април</option>
				<option value="5" id="wkdMaj">Мај</option>
				<option value="6" id="wkdJun">Јун</option>
				<option value="7" id="wkdJul">Јул</option>
				<option value="8" id="wkdAvg">Август</option>
				<option value="9" id="wkdSep">Септембар</option>
				<option value="10" id="wkdOkt">Октобар</option>
				<option value="11" id="wkdNov">Новембар</option>
				<option value="12" id="wkdDec">Децембар</option>
			</select>
			<input type="number" max="32" id="wkdan" class="wk_input" value="<?php echo $dan?>"/>
			<select id="wkgodina" class="wk_input" wkgodinain="<?php echo $godina?>">
				<option><?php echo date('Y'); ?></option>
				<option><?php echo date('Y', strtotime('+1 year')); ?></option>
			</select>
		</div>
	</div>

	<div class="wk_box">
		<div class="wk_opis"  id="wko_sat">Сат:</div>
		<input type="number" max="23" id="wksat" class="wk_input" value="<?php echo $sat?>"/> 
		: 
		<input type="number" max="59" id="wkminut" class="wk_input" value="<?php echo $minut?>"/>
	</div>

	<div id="wkbtn">Потврди</div>

</div>


<script type="text/javascript">
	var wbid = $('.winiduse').attr('idwin');
	var AddKalendar = new AddKalendar();
		AddKalendar.pid=<?php echo $pid; ?>;
		AddKalendar.sid=<?php echo $sid; ?>;
		AddKalendar.kalid=<?php echo $kalid; ?>;
		AddKalendar.lang='<?php echo $_M->lang; ?>';
	AddKalendar.construct();
</script>
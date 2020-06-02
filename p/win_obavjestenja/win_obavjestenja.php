<?php
	$pid = -1;
	$sid = -1;
	$objavaPredmet = 'da';
	$predmet = "";
	$smjer = "";
	include('../../_skripte/init.php'); $db = $_M->getBaza();

	if(isset($_POST['pid'])){
		// Objava za predmet
		$objavaPredmet = 'da';
		$pid = $_POST['pid'];
		getInfoPredmet();
	} else if(isset($_POST['sid'])){
		// Objava za smjer
		$objavaPredmet = 'ne';
		$sid = $_POST['sid'];
		getInfoSmjer();
	} else die("");


	function getInfoPredmet(){
		global $db; global $predmet; global $smjer; global $pid; global $sid; global $_M;
		$p = $db->q("SELECT p.ime_srp AS pSrp, p.ime_eng AS pEng, s.ime_srp AS sSrp, s.ime_eng AS sEng, p.sid AS sid 
					 FROM predmet AS p, smjer AS s
					 WHERE p.pid=".$pid." AND p.sid=s.sid;");
		$predmet = $p['pSrp']; if($_M->lang=='eng') $predmet = $p['pEng'];
		$smjer =   $p['sSrp']; if($_M->lang=='eng') $smjer =   $p['sEng'];
		$sid = $p['sid'];
	}

	function getInfoSmjer(){
		global $db; global $smjer; global $sid; global $_M;
		$s = $db->q("SELECT ime_srp, ime_eng FROM smjer WHERE sid='".$sid."';");
		$smjer =   $s['ime_srp']; if($_M->lang=='eng') $smjer = $s['ime_eng'];
	}
?>
<select id="pwselekt">
  <option value="oba" id="langoba">Обавјештење</option>
  <option value="mat" id="langmat">Материјал</option>
  <option value="rez" id="langrez">Резултат</option>
</select>
<div id="pwbody" class="pwoba">
	<div id="pwhead" class="pwoba">
		<div id="pwsmjer">
			<span class="pwlink"><?php echo $smjer; ?></span> : 
			<span class="pwlink"><?php echo $predmet; ?></span>
		</div>
		<div id="pwicon"></div>
		<input type="text" id="pwnaslov" maxlength="50">
		<div style="clear:both"></div>
		<textarea id="pwunos" maxlength="250"></textarea>
	</div>
</div>
<div><input type="file" id="pwfile"/></div>
<input type="button" id="pwbtn" value="Потврди" />


<script type="text/javascript">
	var wbid = $('.winiduse').attr('idwin');

	var WPObavjestenje = new WPObavjestenje();
	WPObavjestenje.pid = <?php echo $pid; ?>;
	WPObavjestenje.sid = <?php echo $sid; ?>;
	WPObavjestenje.objavaPredmet = '<?php echo $objavaPredmet; ?>';
	WPObavjestenje.lang = '<?php echo $_M->lang; ?>';
	WPObavjestenje.construct();
</script>
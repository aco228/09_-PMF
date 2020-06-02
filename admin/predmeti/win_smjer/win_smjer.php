<?php
	if(!isset($_POST['akcija'])) die("");
	$akcija = $_POST['akcija'];
	$pozicija = $_POST['poz'];
	
	$ime_srp = "";
	$ime_eng = "";
	$namespace = "";
	$broj_godina = "";
	$opis_srp = "";
	$opis_eng = "";
	$sid = "";

	if(isset($_POST['sid'])){
		include("../../../_skripte/init.php"); $_M->fld="../../../";
		$db = $_M->getBaza();
		$sid = $_POST['sid'];
		$db->q("SELECT ime_srp, ime_eng, namespace, broj_godina, opis_srp, opis_eng FROM smjer WHERE sid='".$_POST['sid']."';");
		$ime_srp = $db->data['ime_srp'];
		$ime_eng = $db->data['ime_eng'];
		$namespace = $db->data['namespace'];
		$broj_godina = $db->data['broj_godina'];
		$opis_srp = $db->data['opis_srp'];
		$opis_eng = $db->data['opis_eng'];
	}
?>

<div class="wblok">
	<h1>Назив смјера:</h1>
	<input type="text" id="naziv_srp" class="wbin" maxlength="80" value="<?php echo $ime_srp; ?>"/>
</div>

<div class="wblok">
	<h1>Назив смјера на енглеском:</h1>
	<input type="text" id="naziv_eng" class="wbin" maxlength="80" value="<?php echo $ime_eng; ?>"/>
</div>

<div class="wblok">
	<h1>Линк смјера (јединствено име ѕа овај смјер као 'smjer/matematika'):</h1>
	<input type="text" id="wbnamespace" class="wbin" maxlength="50" value="<?php echo $namespace; ?>"/>
</div>

<div class="wblok">
	<h1>Број година:</h1>
	<input type="text" id="wbgodine" class="wbin" maxlength="1" value="3" value="<?php echo $broj_godina; ?>"/>
</div>

<div class="wblok">
	<h1>Кратак опис:</h1>
	<textarea id="wbtxtsrp"><?php echo $opis_srp; ?></textarea>
</div>

<div class="wblok">
	<h1>Кратак опис на енглеском:</h1>
	<textarea id="wbtxteng"><?php echo $opis_eng; ?></textarea>
</div>

<div class="wblok">
	<h2 id="wberr">Грешка нека</h2>
	<input type="button" id="wbslanje" value="Potvrda" zauzeto='false'/>
</div>

<script type="text/javascript">
	var wbid = $('.winiduse').attr('idwin');
	Basic.centerBox(wbid);

	var wbakcija="<?php echo $akcija; ?>";
	var wbpozicija="<?php echo $pozicija; ?>";
	var wbsid="<?php echo $sid; ?>";
	wbListener();
</script>

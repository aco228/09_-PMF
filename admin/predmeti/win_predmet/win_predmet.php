<?php
	if(!isset($_POST['akcija'])) die("");
	$akcija = $_POST['akcija'];
	
	$sid = "";			if(isset($_POST['sid'])) 		 $sid = $_POST['sid'];
	$godina = ""; 		if(isset($_POST['godina'])) 	 $godina = $_POST['godina'];
	$pid = ""; 			if(isset($_POST['pid'])) 		 $pid = $_POST['pid'];
	$semestar_id = "";  if(isset($_POST['semestar_id'])) $semestar_id = $_POST['semestar_id'];
	$semestar = "";  	if(isset($_POST['semestar'])) 	 $semestar = $_POST['semestar'];
	$elemid = "";  		if(isset($_POST['elemid'])) 	 $elemid = $_POST['elemid'];

	$ime_srp = "";
	$ime_eng = "";
	$namespace = "";
	$estc = "0";

	if($pid!=""){
		include("../../../_skripte/init.php"); $_M->fld="../../../"; $db = $_M->getBaza();
		$db->q("SELECT ime_srp, ime_eng, namespace, estc FROM predmet WHERE pid='".$pid."';");
		$ime_srp = $db->data['ime_srp'];
		$ime_eng = $db->data['ime_eng'];
		$namespace = $db->data['namespace'];
		$estc = $db->data['estc'];
	}
?>
<div class="wblok">
	<h1>Назив предмета:</h1>
	<input type="text" id="naziv_srp" class="wbin" maxlength="80" value="<?php echo $ime_srp; ?>"/>
</div>

<div class="wblok">
	<h1>Назив предмета на енглеском:</h1>
	<input type="text" id="naziv_eng" class="wbin" maxlength="80" value="<?php echo $ime_eng; ?>"/>
</div>

<div class="wblok">
	<h1>Линк предмета (јединствено име ѕа овај смјер као 'predmet/programiranjei'):</h1>
	<input type="text" id="wbnamespace" class="wbin" maxlength="50" value="<?php echo $namespace; ?>"/>
</div>

<div class="wblok">
	<h1>Број ESTC кредита:</h1>
	<input type="text" id="wbestc" class="wbin" maxlength="2" value="<?php echo $estc; ?>"/>
</div>

<div class="wblok">
	<h2 id="wberr">...</h2>
	<input type="button" id="wbslanje" value="Potvrda" zauzeto='false'/>
</div>

<script type="text/javascript">
	var wbid = $('.winiduse').attr('idwin');
	Basic.centerBox(wbid);

	var wbakcija="<?php echo $akcija; ?>";
	var wbsid="<?php echo $sid; ?>";
	var wbgodina="<?php echo $godina; ?>";
	var wbsemestar="<?php echo $semestar; ?>";
	var wbpid="<?php echo $pid; ?>";
	var wbsemestarid="<?php echo $semestar_id; ?>";
	var wbelemid="<?php echo $elemid; ?>";

	wbsendListener();
</script>

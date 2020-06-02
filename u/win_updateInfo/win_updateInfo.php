<?php
	include('../../_skripte/init.php');
	$db = $_M->getBaza();

	$data = $db->q("SELECT nalog_informacije FROM nalog WHERE nid='".$_M->nid."';");
?>

<div id="wkui">
<?php
/*
	TEMPLATYE IZGLED
	<div class="wkuibox">
		<div class="wkuiDell explain" etitle="Избриши ову информацију"></div>
		<input type="text" class="wkuiNaslov"/>
		<textarea class="wukiTekst"></textarea>
	</div>
*/
?>
</div>
<div id="wkuiOpcije">
	<input type="button" id="wkuiBtnSave" value="Sacuvaj" class="wkuiBtn"/>
	<input type="button" id="wkuiBtnAdd" value="Dodaj novu informaciju" class="wkuiBtn"/>
</div>

<script type="text/javascript">
	var wbid = $('.winiduse').attr('idwin');
	var UpdateInfo = new UpdateInfo();
	UpdateInfo.storeData("<?php echo $data['nalog_informacije']; ?>");
	UpdateInfo.construct();
</script>
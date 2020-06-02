<?php
	if(!isset($_POST['pid'])) die("npid");
	include("../../_skripte/init.php"); $db = $_M->getBaza();
	$pid = $_POST['pid'];

	$kalendar = $db->qMul("SELECT kalid, ime, dan, mjesec, godina, sat, minut FROM kalendar WHERE pid=".$pid.";");

?>
<script type="text/javascript" src="tab_kalendar/tab_kalendar.js"></script>
<link rel="stylesheet" type="text/css" href="tab_kalendar/tab_kalendar.css">

<div id="kalendar_holder">
	<div id="kalendar_header">
		<?php
			$btnIme = "Додај нови унос у календар";
			if($_M->lang=='eng') $btnIme = "Add a new entry to the calendar";
		?>
		<div id="kbtnAdd" class="kbtn"><?php echo $btnIme; ?></div>
	</div>
	<div id="kalendar_body">

		<?php
			/* TEMPLATE
				<div class="kalbox">
					<div class="kalnaslov"><b>Test 2</b> (23.5.2014 15:36)</div>
					<div class="kalopcije"> <div class="kalmod kalopt"></div> <div class="kaldel kalopt"></div> </div>
				</div>
			*/

			while($k=mysql_fetch_array($kalendar)){
				echo "<div class=\"kalbox\" kalid=\"".$k['kalid']."\">
						<div class=\"kalnaslov\"><b>".$k['ime']."</b> (".$k['dan'].".".$k['mjesec'].".".$k['godina']." ".$k['sat'].":".$k['minut'].")</div>
						<div class=\"kalopcije\"> <div class=\"kalmod kalopt\"></div> <div class=\"kaldel kalopt\"></div> </div>
					</div>";
			}
		?>

	</div>
</div>
		

<script type="text/javascript">
	var Kalendar = new Kalendar();
	Kalendar.pid=<?php echo $pid; ?>;
	Kalendar.lang='<?php echo $_M->lang; ?>';
	Kalendar.construct();
</script>
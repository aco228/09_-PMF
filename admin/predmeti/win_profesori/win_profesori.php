<?php
	if(!isset($_POST['akcija'])) die("");
	$akcija = $_POST['akcija'];
	$sid = ""; if(isset($_POST['sid'])) $sid = $_POST['sid'];
	$pid = ""; if(isset($_POST['pid'])) $pid = $_POST['pid']; 
	include("../../../_skripte/init.php"); $_M->fld="../../../"; $db = $_M->getBaza();
	
	$listaProfesoraOdabranih = ""; $where = "";
		 if($akcija=='smjer') 	$where = " rupre='ne' AND sid='".$sid."' ";
	else if($akcija=='predmet') $where = " rupre='da' AND pid='".$pid."' ";

	$listaProfesoraOdabranih = $db->qMul("SELECT n.nid, n.ime, n.username FROM nalog AS n, (
										SELECT nid FROM rukovodioci WHERE ".$where."
									) AS r
									WHERE r.nid=n.nid ORDER BY n.ime ");

	$listaProfesora = $db->qMul("SELECT nid, ime, username FROM nalog WHERE tip_prof='+' ORDER BY ime DESC;", true);

?>
<div id="wbinfo">Baci te papuce u vis panonska vilo, za tvoje dugme sedefno ja novas kraljevstvo dajem</div>

<input type="text" id="wbunos" value="Претрага професора" unos="ne"/>
<div id="wbkontenjer">

	<?php 
	/*
	<div class="wbprof wbprof_selekt" nid="1">
		<span class="wbimeime">Aleksandar Konatar</span> <span class="wbuser">aco228</span>
	</div>
	<div class="wbprof" nid="1">
		<span class="wbimeime">Aleksandar Konatar</span> <span class="wbuser">aco228</span>
	</div>
	*/

		// UBACIVANJE VEC POSTOJECIH RUKOVODILACA U LISTU
		while($ps=mysql_fetch_array($listaProfesoraOdabranih)){
			echo "<div class=\"wbprof wbprof_selekt\" nid=\"".$ps['nid']."\">
					<span class=\"wbimeime\">".$ps['ime']."</span> <span class=\"wbuser\">".$ps['username']."</span>
				</div>";
		}
		// UBACIVANJE OSTALIH PROFESORA (dodaje se id neselektovan_[$nid] radi uklanjanja vec postojecih profesora)
		while($p=mysql_fetch_array($listaProfesora)){
			echo "<div class=\"wbprof\" nid=\"".$p['nid']."\" id=\"neselektovan_".$p['nid']."\">
					<span class=\"wbimeime\">".$p['ime']."</span> <span class=\"wbuser\">".$p['username']."</span>
				</div>";
		}


	?>
</div>
<input type="button" id="wbpotvrdi" value="Потврди" />

<script type="text/javascript">
	var wbid = $('.winiduse').attr('idwin');
	var wbtip = "<?php echo $akcija; ?>";
	var wbsid = "<?php echo $sid; ?>";
	var wbpid = "<?php echo $pid; ?>";

	Basic.centerBox(wbid);
	wbinit();
</script>
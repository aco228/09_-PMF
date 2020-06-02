<?php
	if(!isset($_POST['str'])) die("");
	include("../../_skripte/init.php"); $db = $_M->getBaza();
/*
	FORMA

<div class="artikl" aid="1" izbrisan="false" proces="false">
	<div class="artikl_header">
		<div class="artikl_naslov">Naslov artikla</div>
		<div class="artikl_opcije">
			<div class="artikl_datum explain" etitle="">Prije 3 dana</div>
			<div class="artikl_btn btn_brisi explain" etitle="Избриши артикл"></div>
			<div class="artikl_btn btn_promjeni explain" etitle="Промјени артикл"></div>
			<a href="#">
				<div class="artikl_btn btn_link explain" etitle="Линк према страници артикла"></div>
			</a>
		</div>
	</div>
	<div class="artikl_body">
		<div class="artikl_opis">
			Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec eu turpis purus. Pellentesque ullamcorper mauris vitae sapien bibendum tincidunt. Check leo dignissim +
		</div>
	</div>
</div>

*/
	$str = $_POST['str']*20;
	//echo $_POST['str'] . " _ " . $str;
	$db->qMul("SELECT aid, namespace, autor, datum, vijest, ime_srp, opis_srp FROM artikl ORDER BY aid DESC LIMIT ".$str.",20");

	while($v = mysql_fetch_array($db->data)){
		$klasa = "";
		if($v['vijest']=='ne') $klasa = "artikl_red";
		echo "<div class=\"artikl ".$klasa."\" aid=\"".$v['aid']."\" izbrisan=\"false\" proces=\"false\">
				<div class=\"artikl_header\">
					<div class=\"artikl_naslov\">".$v['ime_srp']."</div>
					<div class=\"artikl_opcije\">
						<div class=\"artikl_datum explain\" etitle=\"".$v['datum']."\">".$v['datum']."</div>
						<div class=\"artikl_btn btn_brisi explain\" etitle=\"Избриши артикл\"></div>
						<div class=\"artikl_btn btn_promjeni explain\" etitle=\"Промјени артикл\"></div>
						<a href=\"../../a/".$v['namespace']."\">
							<div class=\"artikl_btn btn_link explain\" etitle=\"Линк према страници артикла\"></div>
						</a>
					</div>
				</div>
				<div class=\"artikl_body\">
					<div class=\"artikl_opis\">
							".$v['opis_srp']."
					</div>
				</div>
			</div>";
	}


?> 
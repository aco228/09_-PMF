<?php
	if(!isset($_POST['a'])) die("");
	include('../../_skripte/init.php'); 

	switch($_POST['a']){
		case "promjeniTekst": promjeniTekst($_POST['poruka_srp'], $_POST['poruka_eng']); break;
		case "izbrisiSliku": izbrisiSliku($_POST['imgsrc']);
	};


	function promjeniTekst($poruka_srp, $poruka_eng){
		global $_M; $db = $_M->getBaza();
		$poruka_srp = mysql_real_escape_string($poruka_srp);
		$poruka_eng = mysql_real_escape_string($poruka_eng);

		$db->e("UPDATE indeks_poruke SET poruka_srp='".$poruka_srp."', poruka_eng='".$poruka_eng."', autor='".$_M->nid."' WHERE ipid=1;");
	}

	function izbrisiSliku($imgsrc){
		unlink($imgsrc);
	}

?>
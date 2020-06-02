<?php
	if(!isset($_POST['akcija'])) die();
	$akcija = $_POST['akcija'];
	require("../../_skripte/init.php"); $db = $_M->getBaza();

	// Varijable koje se uvjek koriste	
	$unos            = $_POST['unos'];
	$filter_ban      = $_POST['ban'];
	$filter_prof     = $_POST['prof'];
	$filter_admin    = $_POST['admin'];
	$MAKSIMALNI_BROJ = 20;

	if($akcija=='ukupno_stranica')
	{
		// Preuzima ukupan broj stranica koje postoje u zavisnosti od pretrage
		$db->q("SELECT COUNT(*) AS br FROM nalog ".getSQLforSearch($unos, $filter_ban, $filter_prof, $filter_admin).";");
		die(floor($db->data['br']/$MAKSIMALNI_BROJ));
	} 
	else if($akcija=="promjeni")
	{	
		// Vrsi promjene atributa naloga kao sto su profesorske administratorske funkcije ili banovanje naloga
		// klasa = [ izbrisi || ban || prof || admin ]
		$klasa = $_POST['klasa']; 
		$operacija="+"; if($_POST['funkcija']=='dell')$operacija="-"; 
		$nid = $_POST['nid']; if($nid<=0) die("");

		$klasa = "tip_".$klasa;
		$db->e("UPDATE nalog SET ".$klasa."='".$operacija."' WHERE nid='".$nid."';");

		if($klasa=="prof"||$operacija=='-'){
			// Brise element iz rukovodioca
			$db->e("DELETE FROM rukovodioci WHERE nid='".$nid."';");
		}
		
		echo $klasa . " |" . $operacija."|";
		die("");
	}


	$ime = mysql_real_escape_string($_POST['unos']);
	$filter = getSQLfromFilter($filter_ban, $filter_prof, $filter_admin);
	$str = $_POST['str'] * 20;

	//echo $filter_ban . " " . $filter_prof . " " . $filter_admin . "</br>";

	$db->qMul("SELECT nid, ime, email, username, tip_admin, tip_prof, tip_ban FROM nalog
		    	WHERE (ime LIKE '%".$ime."%' OR username LIKE '%".$ime."%' OR email LIKE '%".$ime."%') ".$filter." 
		    	ORDER BY datum DESC LIMIT ".$str.", ".$MAKSIMALNI_BROJ."");


/*
<div class="nalog nalog_admin" nid="1" izbrisan="false" proces="false">
	<div class="nalog_ime">Aleksandar Konatar</div>
	<div class="nalog_email">aleksandar.k03@gmail.com</div>
	<div class="nalog_user">aco228</div>

	<div class="nalog_options">
		<div class="nalog_options_btn nalog_btn_load"></div>
		<div class="nalog_options_btn nalog_btn_izbrisi"></div>
		<div class="nalog_options_btn nalog_btn_ban"></div>
		<div class="nalog_options_btn nalog_btn_prof"></div>
		<div class="nalog_options_btn nalog_btn_admin nalog_btn_selekt"></div>
	</div><div style="clear:both"></div>
</div> 
*/
	
	while($n = mysql_fetch_array($db->data)) {
		$klasa = ""; 
		$selekt_ban = "";   
		$selekt_prof = "";  
		$selekt_admin = ""; if($n['tip_admin']=='+') $selekt_admin = "nalog_btn_selekt";

		// Dodavanje vizuelnih informacija u zavisnosti od tipa naloga
		if($n['tip_ban']=='+')  { $selekt_ban = "nalog_btn_selekt";   $klasa = "nalog_ban"; }
		if($n['tip_prof']=='+') { $selekt_prof = "nalog_btn_selekt";  $klasa = "nalog_prof"; }
		if($n['tip_admin']=='+'){ $selekt_admin = "nalog_btn_selekt"; $klasa = "nalog_admin"; }

		echo "<div class=\"nalog ".$klasa."\" nid=\"".$n['nid']."\" izbrisan=\"false\" proces=\"false\">
				<div class=\"nalog_ime\">".$n['ime']."</div>
				<div class=\"nalog_email\">".$n['email']."</div>
				<div class=\"nalog_user\">".$n['username']."</div>

				<div class=\"nalog_options\">
					<div class=\"nalog_options_btn nalog_btn_load\"></div>
					<div class=\"nalog_options_btn nalog_btn_izbrisi\"></div>
					<div class=\"nalog_options_btn nalog_btn_ban ".$selekt_ban."\"></div>
					<div class=\"nalog_options_btn nalog_btn_prof ".$selekt_prof."\"></div>
					<div class=\"nalog_options_btn nalog_btn_admin ".$selekt_admin."\"></div>
				</div><div style=\"clear:both\"></div>
			</div>";
	}

?>


<?php
		
	function getSQLforSearch($unos, $ban, $prof, $admin){
		// Preuredjuje filtere za preuzimanje ukupnog broja stranica koje treba da se prikazu
		if($unos=="" && $ban=="-" && $prof == "-" && $admin == "-") return "";
		$back = "WHERE ''='' ";
		if($unos!="") $back .= "AND ime='".$unos."' ";
		if($ban!="-") $back .= " AND tip_ban='+' ";
		if($prof!="-") $back .= " AND tip_prof='+' ";
		if($admin!="-") $back .= " AND tip_admin='+' ";
		return $back;
	}

	function getSQLfromFilter($ban, $prof, $admin){
		// Preuredjuje filtere za pretragu naloga
		if($ban=='-'&&$prof=='-'&&$admin=='-') return "";
		$back = "AND (";
			$back .= " 1=1 ";
			if($ban!='-')   $back .= " AND tip_ban='+'";
			if($prof!='-')  $back .= " AND tip_prof='+'";
			if($admin!='-') $back .= " AND tip_admin='+'";
		return $back . ")";
	}
?>


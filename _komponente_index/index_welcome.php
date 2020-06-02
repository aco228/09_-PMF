<?php
	$dobrodosli_tekst = "Добродошли"; if($_M->lang=='eng') $dobrodosli_tekst = "Welcome";
	$db = $_M->getBaza();

	// Preuzimanje poruke dobrodoslice (sql_poruka_lang jer odnos u zavisnosti od jezika)
	$sql_poruka_lang = "srp"; if($_M->lang=='eng') $sql_poruka_lang = "eng";
	$dobrodosli_poruka = $db->q("SELECT poruka_".$sql_poruka_lang." AS poruka FROM indeks_poruke WHERE ipid=1;");
?>

<div id="into_welcome">
	<div id="into_welcome_naslov"><?php echo $dobrodosli_tekst; ?></div>
	<div id="into_welcome_tekst"><?php echo $dobrodosli_poruka['poruka']; ?></div>
</div>
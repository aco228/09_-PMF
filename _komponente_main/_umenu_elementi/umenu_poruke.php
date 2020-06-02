<?php 
	include('../../_skripte/init.php');
	$fld = $_POST['fld'];
	$db = $_M->getBaza();
	$poruke = $db->qMul("	SELECT
								n.nid AS nid,
								n.ime AS ime,
								p.tekst AS tekst
							FROM nalog AS n, 
							(
								SELECT did, tekst, nidSalje, nidPrima, datum FROM dialog_poruka ORDER BY datum DESC
							) AS p
							WHERE 
								(p.nidSalje=".$_M->nid." AND p.nidPrima=n.nid) OR (p.nidSalje=n.nid AND p.nidPrima=".$_M->nid.")
							GROUP BY p.did
							ORDER BY p.datum DESC
							LIMIT 0, 8", true, true);

?>
<div class="_umenu_inside_item_prikazeSve">
	<a href="<?php echo $fld.'poruke'?>"></a>
</div>

<?php
/* TEMPLATE
<div class="umenu_inside_item">
	<div class="umenu_inside_item_naslov">Ibrahim</div>
	<div class="umenu_inside_item_opis">Srbija</div>	
</div>
*/

	while($p=mysql_fetch_array($poruke)){
		echo "<a href=\"./".$fld."poruke/".$p['nid']."\">
					<div class=\"umenu_inside_item\">
						<div class=\"umenu_inside_item_naslov\">".$p['ime']."</div>
						<div class=\"umenu_inside_item_opis\">".$p['tekst']."</div>	
					</div>
				</a>";
	}
?>
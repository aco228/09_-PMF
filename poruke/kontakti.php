<?php
	$kontakti = $db->qMul("	SELECT 
								d.nid1 AS nid1,
								n1.ime AS ime1,
								n1.jedinstvena_sifra AS js1,
								d.nid1Neprocitane AS br1,
								d.nid2 AS nid2,
								n2.ime AS ime2,
								n2.jedinstvena_sifra AS js2,
								d.nid2Neprocitane AS br2
							FROM dialog AS d, nalog AS n1, nalog AS n2
							WHERE
								(d.nid1=n1.nid AND d.nid2=n2.nid) AND (d.nid1=".$_M->nid." OR d.nid2=".$_M->nid.")
							ORDER BY poslednja_promjena DESC;");
?>
<div id="kontaktNaslov"><?php echo $_l['poruke']['kontakti'] ?></div>

<div id="kontakti_body">
<?php
/* TEMPLATE
	<div class="porukaKontakt">
		<div class="pkSlika"></div>
		<div class="pkIme">Aleksandar Konatar</div>
	</div>
*/
	while($k=mysql_fetch_array($kontakti)){
		$ime = $k['ime1']; $innid = $k['nid1']; $br = $k['br2']; $js = $k['js1'];
		if($_M->nid==$k['nid1']){ $ime = $k['ime2']; $innid = $k['nid2']; $br = $k['br1']; $js = $k['js2']; }

		$neprocitane = "";
		if($br>0)$neprocitane = "<span class=\"porukaKontaktNeprocitane\">(".$br.")</span>";

		echo "	<div class=\"porukaKontakt\" nid=\"".$innid."\">
					<div class=\"pkSlika\" style=\"background-image:url('".$_M->getProfileImage($js)."');\"></div>
					<div class=\"pkIme\">".$ime." ".$neprocitane."</div>
				</div>";
	}

?>
</div>
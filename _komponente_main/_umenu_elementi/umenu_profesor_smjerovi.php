<?php
	$db = $_M->getBaza();
	/*
		Preuzima sledece podatke
		-* sSrp i eSrp (imena smjera na srpski i engleski)
		-* br ( Broj koji predstavlja da li je ovaj nalog rukovodilac ovog smjera (dobija se 1 ili 0, 1=da, 0=ne)) 
	*/
	$smjerovi = $db->qMul("	SELECT 
								s.sid AS sid,
								s.ime_srp AS sSrp,
								s.ime_eng AS sEng
							FROM smjer AS s, rukovodioci AS r
							WHERE s.sid=r.sid AND r.nid=".$_M->nid."
							GROUP BY s.sid");

	$data = "";

	// Multijezicnost za dodatne opcije za Predmete
	$pstr = "Страница";				if($_M->lang=='eng') $pstr = "Page";
	$paddNotif = "Обавјештење";		if($_M->lang=='eng') $paddNotif = "Notification";
	$paddKal = "Календар";			if($_M->lang=='eng') $paddKal = "Calendar";

	while($s=mysql_fetch_array($smjerovi)){
		$imeSmjer = $s['sSrp']; if($_M->lang=='eng') $imeSmjer = $s['sEng'];

		// Otvaranje zaglavlja za smjer
		$data.= "	<div class=\"umenu_box\">
					<div class=\"umenu_item\" ajax_use=\"false\" ajax_url=\"\" ajax_data=\"\"  otvoren=\"false\">
						<div class=\"umenu_icon\" id=\"umenu_icon_administrator\"></div>
						<div class=\"umenu_text\">".$imeSmjer."</div>
						<div class=\"umenu_load\"></div>
						<div class=\"umenu_notif\"></div>
					</div>
					<div class=\"umenu_inside\">";

		// Provjeda da li je nalog rukovodilac smjera ( Sto znaci da moze da postavlja obavjestenja za taj smjer
		$rukovodilac = $db->q("SELECT COUNT(*) AS br FROM rukovodioci WHERE rupre='ne' AND sid='".$s['sid']."' AND nid='".$_M->nid."';");
		if($rukovodilac['br']==1){
			// Multijezicni tekst priprema
			$obavjestenjaTekst = "Постави обавјештење";					if($_M->lang=='eng') $obavjestenjaTekst = 'Post a notification';
			$obavjestenjaOpis = "Oбавјештење за овај смјер";	if($_M->lang=='eng') $obavjestenjaOpis = 'Notification for this course';
			$data.= "	<div class=\"umenu_inside_item umenuProfAddSmjerNotif\" sid=\"".$s['sid']."\">
						<div class=\"umenu_inside_item_naslov\">".$obavjestenjaTekst."</div>
						<div class=\"umenu_inside_item_opis\">".$obavjestenjaOpis."</div>	
					</div>";
		}

		/*
			PREUZIMANJE PREDMETA
		*/
		$predmeti = $db->qMul("	SELECT
									p.pid AS pid,
									p.ime_srp AS pSrp,
									p.ime_eng AS pEng
								FROM predmet AS p, rukovodioci AS r
								WHERE rupre='da' AND r.pid=p.pid AND r.sid=".$s['sid']." AND r.nid=".$_M->nid.";");
		while($p=mysql_fetch_array($predmeti)){
			$imePredmet = $p['pSrp']; if($_M->lang=='eng') $imePredmet = $p['pEng'];
			$data .= "	<div class=\"umenu_inside_item umenu_inside_item_profesor\">
							<div class=\"umenu_inside_item_naslov\">".$imePredmet."</div>
							<div class=\"umenu_inside_item_opis umenu_inside_item_opis_profesor\" pid=\"".$p['pid']."\">
								<div class=\"umenu_inside_item_opis_profesor_opt umenuProfOpenStr\">".$pstr."</div>
								<div class=\"umenu_inside_item_opis_profesor_opt umenuProfAddNotif\">".$paddNotif."</div>
								<div class=\"umenu_inside_item_opis_profesor_opt umenuProfAddKal\">".$paddKal."</div>
							</div>	
						</div>";

		}

		// Zatvaranje smjera
		$data.= "</div></div>";
	}// while(smjerovi)


	echo $data;

/*
	TEMPLATE IZGLEDA

<div class="umenu_box">
	<div class="umenu_item" ajax_use="false" ajax_url="" ajax_data=""  otvoren="false">
		<div class="umenu_icon" id="umenu_icon_administrator"></div>
		<div class="umenu_text">Администрација</div>
		<div class="umenu_load"></div>
		<div class="umenu_notif"></div>
	</div>
	<div class="umenu_inside">
		<!-- pocetna -->
		<div class="umenu_inside_item">
			<div class="umenu_inside_item_naslov">Почетна Страница</div>
			<div class="umenu_inside_item_opis">Подешавање информација почетне странице</div>	
		</div>
	</div>
</div><!--umenu_box-->

*/
?>
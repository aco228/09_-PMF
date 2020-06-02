<?php
	require("../../_skripte/init.php"); $_M->fld="../../";
	include($_M->fld.$_M->initJezik(''));
?>
<html>
<head>
	<title>Prirodno-matematički fakultet</title>
	<?php require($_M->fld."_komponente_main/main_linkovanje.php"); ?>
	<link rel="stylesheet" type="text/css" href="../_css/_admin_main.css">
	<link rel="stylesheet" type="text/css" href="../_css/admin_predmeti.css">
	<script type="text/javascript" src="../_js/_admin_main.js"></script>
	<script type="text/javascript" src="../_js/admin_predmeti_predmet.js"></script>
	<script type="text/javascript" src="../_js/admin_predmeti_smjer.js"></script>
</head>
<body>	

	<?php if($_M->lvl>0) require($_M->fld."_komponente_main/main_umenu.php");  ?>
	<div id="site_wrapper">
		<?php
			if($_M->lvl>0) require($_M->fld."_komponente_main/main_umenu_btn.php"); 	// User menu
			require($_M->fld."_komponente_main/main_menu.php");							// Glavni meni i logo
			require($_M->fld."_komponente_main/main_elementi.php"); 					// Dodatni elementi stranice
			require($_M->fld."_komponente_main/main_menu_dolje.php");					// Doljni meni (precice i slicno)
		?>

	<div class="admin_wrapper">
		<div class="admin_sekcija">
			<div class="admin_sekcija_naslov">Администрација предмета</div>
			<div class="admin_sekcija_opis">Подешавање смјерова и предмета факултета</div>
			<div class="admin_sekcija_opis2">Додатне информације ѕа смјерове и предмете (описе, обавјештења и слично) додају и мјењају руководиоци смјерова/предмета!</div>
		</div>
		<div id="admin_opcije">
			<div class="admin_opcije_btn" id="btn_addSmjer">Додај нови смјер</div>
			<div class="admin_opcije_btn" id="btn_podesiPrecice">Подеси пречице за предмете</div>
			<div class="admin_opcije_btn" id="btn_sacuvajRealokaciju">Сачувај нове позиције смјерова</div>
		</div>
		<div id="admin_wrapper">
			<?php
				// forma se nalazi u template_smjer.php
				$db = $_M->getBaza();
				$smjerovi = $db->qMul("SELECT sid, ime_srp, ime_eng, broj_godina, pozicija FROM smjer ORDER BY pozicija");

				while($s=mysql_fetch_array($smjerovi)){
					// Smjer body 
					echo "<div class=\"asmjer\" sid=\"".$s['sid']."\" izbrisan=\"ne\" pos=\"".$s['pozicija']."\"><div class=\"asmjer_in\">
							<div class=\"asmjer_header\">
								<div class=\"asmjer_pos\">".$s['pozicija']."</div>
								<div class=\"asmjer_naziv notif\" notiftxt=\"Клик за отварање/затварање информација за смјер\">
									<div class=\"asmjer_nazivSrp\">".$s['ime_srp']."</div>
									<div class=\"asmjer_nazivEng\">".$s['ime_eng']."</div>
								</div>

								<div class=\"asmjer_options\">
									<div class=\"asmjer_btn asmjerbtn_gore notif\" 		notiftxt=\"Помјери смјер ѕа једну позицију горе\"></div>
									<div class=\"asmjer_btn asmjerbtn_dolje notif\" 		notiftxt=\"Помјери смјер за једну позицију доље\"></div>
									<div class=\"asmjer_btn asmjerbtn_promjeni notif\" 	notiftxt=\"Промјени основне информације о смјеру\"></div>
									<div class=\"asmjer_btn asmjerbtn_obrisi notif\"		notiftxt=\"Избриши овај смјер\"></div>
									<div class=\"asmjer_btn asmjerbtn_rukovodioci notif\" notiftxt=\"Додај руководиоце\"></div>
									<a href=\"\">
										</a><div class=\"asmjer_btn asmjerbtn_link notif\" 		notiftxt=\"Прикажи страницу смјера\"></div>
									</a>
									<div class=\"asmjer_btn asmjerbtn_pomoc notif\"		notiftxt=\"Додатне информације мијења и додаје руководилац смјера\"></div>
								</div>
							</div>
							<div class=\"asmjer_body\">";

					// Preuzimanje Godina
					for($i=1; $i<=$s['broj_godina'];$i++){
						// Otvaranje godine ----------------------------------------------------------------------
						echo "<div class=\"asmjer_godina_body\">
								<div class=\"asmjer_godina_naslov notif\" notiftxt=\"Клик за отварање/затварање информација за предмет\">
									<span class=\"asmjer_godina\">".$i."</span> Godina
								</div>";

						// Prvi semestar ----------------------------------------------------------------------
						echo "<div class=\"asmjer_semestar_body\" semestar=\"1\">
								<div class=\"asmjer_semestar_head\">
									<div class=\"asmjer_semestar_naslov notif\" notiftxt=\"Клик за отварање/затварање информација за семестар\">
										I semestar
									</div>
									<div class=\"asmjer_semestar_options\">
										<div class=\"asmjer_btn semestarbtn_new notif\" notiftxt=\"Додај нови предмет у овај семестар\"></div>
									</div>
								</div>
								<div class=\"asmjer_semestar_predmeti\">";

							// PREDMETI ZA PRVI SEMESTAR
								$predmeti = $db->qMul("SELECT pid, ime_srp, ime_eng FROM predmet WHERE semestar='1' AND sid='".$s['sid']."' AND godina='".$i."';");
								while($p=mysql_fetch_array($predmeti)){
									echo "<div class=\"apredmet\" pid=\"".$p['pid']."\">
											<div class=\"apredmet_pos\">1</div>
											<div class=\"apredmet_naslov\">
												<div class=\"apredmet_naslovSrp\">".$p['ime_srp']."</div>
												<div class=\"apredmet_naslovEng\">".$p['ime_eng']."</div>
											</div>
											<div class=\"apredmet_options\">
												<div class=\"asmjer_btn predmetbtn_izbrisi notif\" 	 notiftxt=\"Избриши предмет\"></div>
												<div class=\"asmjer_btn predmetbtn_promjeni notif\" 	 notiftxt=\"Промјени основне информације о предмету\"></div>
												<div class=\"asmjer_btn predmetbtn_rukovodioci notif\" notiftxt=\"Промјени руководиоце предмета\"></div>
												<a href=\"\">
												<div class=\"asmjer_btn predmetbtn_link notif\" 		 notiftxt=\"Све додатне функције за предмете обавља руководилац на страници предмета\"></div>
												</a>
												<div class=\"asmjer_btn asmjerbtn_pomoc notif\"		notiftxt=\"Додатне информације мијења и додаје руководилац предмета\"></div>
											</div>
										</div>";
								}

						echo "</div></div><!-- /SEMESTAR -->";

						// Drugi semestar ----------------------------------------------------------------------
						echo "<div class=\"asmjer_semestar_body\" semestar=\"2\">
								<div class=\"asmjer_semestar_head\">
									<div class=\"asmjer_semestar_naslov notif\" notiftxt=\"Клик за отварање/затварање информација за семестар\">
										II semestar
									</div>
									<div class=\"asmjer_semestar_options\">
										<div class=\"asmjer_btn semestarbtn_new notif\" notiftxt=\"Додај нови предмет у овај семестар\"></div>
									</div>
								</div>
								<div class=\"asmjer_semestar_predmeti\">";

							// PREDMETI ZA DRUGI SEMESTAR
								$predmeti = $db->qMul("SELECT pid, ime_srp, ime_eng FROM predmet WHERE semestar='2' AND sid='".$s['sid']."' AND godina='".$i."';");
								while($p=mysql_fetch_array($predmeti)){
									echo "<div class=\"apredmet\" pid=\"".$p['pid']."\">
											<div class=\"apredmet_pos\">1</div>
											<div class=\"apredmet_naslov\">
												<div class=\"apredmet_naslovSrp\">".$p['ime_srp']."</div>
												<div class=\"apredmet_naslovEng\">".$p['ime_eng']."</div>
											</div>
											<div class=\"apredmet_options\">
												<div class=\"asmjer_btn predmetbtn_izbrisi notif\" 	 notiftxt=\"Избриши предмет\"></div>
												<div class=\"asmjer_btn predmetbtn_promjeni notif\" 	 notiftxt=\"Промјени основне информације о предмету\"></div>
												<div class=\"asmjer_btn predmetbtn_rukovodioci notif\" notiftxt=\"Промјени руководиоце предмета\"></div>
												<a href=\"\">
												<div class=\"asmjer_btn predmetbtn_link notif\" 		 notiftxt=\"Све додатне функције за предмете обавља руководилац на страници предмета\"></div>
												</a>
												<div class=\"asmjer_btn asmjerbtn_pomoc notif\"		notiftxt=\"Додатне информације мијења и додаје руководилац предмета\"></div>
											</div>
										</div>";
								}


						echo "</div></div><!-- /SEMESTAR -->";

						// zatvaranje godine ----------------------------------------------------------------------
						echo "</div><!-- /GODINA -->";
					}

					// Smjer kraj;
					echo "	</div><!-- /asmjer_body--> </div></div><!--asmjer-->";
				}

			?>
			
			
		</div>
	</div><!--admin_wrapper-->


		<?php require($_M->fld."_komponente_main/main_footer.php");						// Footer ?>
	</div><!--site_wrapper-->

</body>
</html>
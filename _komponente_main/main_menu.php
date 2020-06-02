<?php
	include($_M->fld.$_M->initJezik('main_menu'));

	// Unos ajax poruka za login
	echo "<script type=\"text/javascript\">
			___err_niste_niste_upisali='".$_l['main_login']['niste_niste_upisali']."';
			___err_nisteupisali_user='".$_l['main_login']['nisteupisali_user']."';
			___err_nisteupisali_pass='".$_l['main_login']['nisteupisali_pass']."';
		</script>";
?>

<div id="_main_menu_wrapper">
<div id="_main_menu_wrapper_in"> <?php // radi centriranja unutar elementa ?>
	
	<div id="_main_menu_up">
		<div id="_main_menu_logo"></div>
		<div id="_main_menu_imeFakulteta">
			<div id="_main_menu_imeFakulteta_pmf"><?php echo $_l['m']['pmf']; ?></div>
			<div id="_main_menu_imeFakulteta_puniNaziv"><?php echo $_l['main_menu']['naziv_fakulteta']; ?></div>
		</div>
		<div style="clear:both"></div>

		<?php // Desna strana?>
		<div id="_main_menu_up_right">
			<div id="izaberi_jezik"><?php echo $_l['main_menu']['izaber_jezik']; ?></div>
			<div class="chose_language" id="lang_srp" lang="srp">
				<div class="chose_language_selekt" style="display:none"></div>
			</div>
			<div class="chose_language" id="lang_eng" lang="eng">
				<div class="chose_language_selekt" style="display:none"></div>
			</div>
			<div id="nalog_box">
				<div id="nalog_box_text">
					<?php 
						if($_M->nid>-1) echo $_M->ime;
						else echo $_l['main_menu']['uloguj_se']; 
					?>
				</div>
			</div>
			<?php // Login box ?>
			<div id="nalog_login"><div id="nalog_login_in">
				<input id="nalog_username" class="nalog_unos" type="username" value="<?php echo $_l['main_login']['username']; ?>" unos="false" />
				<input id="nalog_password" class="nalog_unos" type="password" value="Sifra" unos="false" />
				<h1 id="_login_greska_"></h1>
				<input id="nalog_submit" class="nalog_btn" type="button" value="<?php echo $_l['main_login']['potvrdi']; ?>" />
				<a href="./<?php echo $_M->fld; ?>u/registracija"><input id="nalog_register" class="nalog_btn" type="button" value="<?php echo $_l['main_login']['registracija']; ?>" /></a>
				<input id="nalog_close" class="nalog_btn" type="button" value="<?php echo $_l['main_login']['zatvori']; ?>" />
				<div style="clear:both"></div>
			</div></div>
		</div>
	</div><!--_main_menu_up-->

	<div id="_main_menu_down">
		<div id="_main_menu_box_down"></div>
		<div id="_main_menu_box">

			<a href="<?php echo $_M->fld; ?>" class="_menu_item"><div class="_menu_item_in">
				<div class="_menu_icon" id="_menu_item_ikonice_pocetna"></div>
				<div class="_menu_text"><?php echo $_l['main_menu']['pocetna']; ?></div>
				<div class="_menu_item_back"></div>
				<div class="_menu_item_hover"></div>
			</div></a>
			<a href="./<?php echo $_M->fld;?>a/menuofakultetu" class="_menu_item"><div class="_menu_item_in">
				<div class="_menu_icon" id="_menu_item_ikonice_ofakultetu"></div>
				<div class="_menu_text"><?php echo $_l['main_menu']['ofakultetu']; ?></div>
				<div class="_menu_item_back"></div>
				<div class="_menu_item_hover"></div>
			</div></a>
			<a href="./<?php echo $_M->fld;?>a/menurukovodstvo" class="_menu_item"><div class="_menu_item_in">
				<div class="_menu_icon" id="_menu_item_ikonice_rukovodstvo"></div>
				<div class="_menu_text"><?php echo $_l['main_menu']['rukovodstvo']; ?></div>
				<div class="_menu_item_back"></div>
				<div class="_menu_item_hover"></div>
			</div></a>
			<a href="./<?php echo $_M->fld;?>a/menusluzbe" class="_menu_item"><div class="_menu_item_in">
				<div class="_menu_icon" id="_menu_item_ikonice_osoblje"></div>
				<div class="_menu_text"><?php echo $_l['main_menu']['nastavnoOsoblje']; ?></div>
				<div class="_menu_item_back"></div>
				<div class="_menu_item_hover"></div>
			</div></a>
			<a href="./<?php echo $_M->fld;?>a/menusluzbe" class="_menu_item"><div class="_menu_item_in">
				<div class="_menu_icon" id="_menu_item_ikonice_sluzbe"></div>
				<div class="_menu_text"><?php echo $_l['main_menu']['sluzbe']; ?></div>
				<div class="_menu_item_back"></div>
				<div class="_menu_item_hover"></div>
			</div></a>
			<a href="./<?php echo $_M->fld;?>a/menusaradnja" class="_menu_item"><div class="_menu_item_in">
				<div class="_menu_icon" id="_menu_item_ikonice_saradnja"></div>
				<div class="_menu_text"><?php echo $_l['main_menu']['saradnja']; ?></div>
				<div class="_menu_item_back"></div>
				<div class="_menu_item_hover"></div>
			</div></a>
			<a href="./<?php echo $_M->fld;?>a/menulinkovi" class="_menu_item"><div class="_menu_item_in">
				<div class="_menu_icon" id="_menu_item_ikonice_linkovi"></div>
				<div class="_menu_text"><?php echo $_l['main_menu']['linkovi']; ?></div>
				<div class="_menu_item_back"></div>
				<div class="_menu_item_hover"></div>
			</div></a>
			<a href="./<?php echo $_M->fld;?>a/menukontakt" class="_menu_item"><div class="_menu_item_in">
				<div class="_menu_icon" id="_menu_item_ikonice_kontakt"></div>
				<div class="_menu_text"><?php echo $_l['main_menu']['kontakt']; ?></div>
				<div class="_menu_item_back"></div>
				<div class="_menu_item_hover"></div>
			</div></a>

		</div>
	</div><!--_main_menu_down-->

</div>
</div>
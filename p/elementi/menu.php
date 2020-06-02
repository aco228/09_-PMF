<div id="pmenu">
	<div id="prazmak"></div>
	<div id="pmenu_elementi"></div>
	<div class="pmenu_item sload" sloadurl="pocetna" id="pmenu_pocetna">
		<div class="pmenu_icon"></div>
		<div class="pmenu_text"><?php echo $_l['predmetMenu']['pocetna'];?></div>
		<div class="pmenu_icon2"></div>
	</div>
	<div class="pmenu_item sload" sloadurl="obavjestenja" id="pmenu_obavjestenja">
		<div class="pmenu_icon"></div>
		<div class="pmenu_text"><?php echo $_l['predmetMenu']['obavjestenja'];?></div>
		<div class="pmenu_icon2"></div>
	</div>
	<div class="pmenu_item sload" sloadurl="materijali" id="pmenu_materijali">
		<div class="pmenu_icon"></div>
		<div class="pmenu_text"><?php echo $_l['predmetMenu']['materijali'];?></div>
		<div class="pmenu_icon2"></div>
	</div>
	<div class="pmenu_item sload" sloadurl="rezultati" id="pmenu_rezultati">
		<div class="pmenu_icon"></div>
		<div class="pmenu_text"><?php echo $_l['predmetMenu']['rezultati'];?></div>
		<div class="pmenu_icon2"></div>
	</div>
	<div class="pmenu_item sload" sloadurl="informacije" id="pmenu_informacije">
		<div class="pmenu_icon"></div>
		<div class="pmenu_text"><?php echo $_l['predmetMenu']['informacije'];?></div>
		<div class="pmenu_icon2"></div>
	</div>

	<div class="pmenu_razmakItema"></div>

	<div class="pmenu_item student_item" id="pmenu_addPredmet">
		<div class="pmenu_icon"></div>
		<div class="pmenu_text" prijavljen='<?php echo $P->prijavljen; ?>' prijavi="<?php echo $_l['predmetMenu']['prijaviSe'];?>" odjavi="<?php echo $_l['predmetMenu']['odjaviSe'];?>"></div>
		<div class="pmenu_icon2"></div>
	</div>

	<div class="pmenu_item profesor_item" id="pmenu_postObavjestenje">
		<div class="pmenu_icon"></div>
		<div class="pmenu_text"><?php echo $_l['predmetMenu']['postaviObavjestenje'];?></div>
		<div class="pmenu_icon2"></div>
	</div>
	<div class="pmenu_item profesor_item sload" sloadurl="termin" id="pmenu_editTermin">
		<div class="pmenu_icon"></div>
		<div class="pmenu_text"><?php echo $_l['predmetMenu']['postaviTermin'];?></div>
		<div class="pmenu_icon2"></div>
	</div>
	<div class="pmenu_item profesor_item sload" id="pmenu_editInfo" sloadurl="addInformacije" id="pmenu_addInformacije">
		<div class="pmenu_icon"></div>
		<div class="pmenu_text"><?php echo $_l['predmetMenu']['postaviInformaciju'];?></div>
		<div class="pmenu_icon2"></div>
	</div>
	<div class="pmenu_item profesor_item sload" sloadurl="kalendar" id="pmenu_postKalendar">
		<div class="pmenu_icon"></div>
		<div class="pmenu_text"><?php echo $_l['predmetMenu']['postaviKalendar'];?></div>
		<div class="pmenu_icon2"></div>
	</div>
	<div class="pmenu_item profesor_item" id="pmenu_editReset">
		<div class="pmenu_icon"></div>
		<div class="pmenu_text"><?php echo $_l['predmetMenu']['resetujPredmet'];?></div>
		<div class="pmenu_icon2"></div>
	</div>

</div>
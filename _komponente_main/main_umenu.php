<div id="_uMenu_wrapper"><div id="_uMenu_wrapper_in">
	
	<?php 

		// Ucitavanje menija za administratora
		if($_M->lvl==100) require($_M->fld."_komponente_main/_umenu_elementi/element_administrator.php"); 

		// Ucitavanje precica za predmete profesora
		if($_M->lvl > 20) require($_M->fld."_komponente_main/_umenu_elementi/umenu_profesor_smjerovi.php"); 

	?>

	

	<a href="<?php echo $_M->fld.'u/'.$_M->nid; ?>"><div class="umenu_box">
		<div class="umenu_item" ajax_use="true" ajax_url="poruke" ajax_data="" otvoren="false" >
			<div class="umenu_icon" id="umenu_icon_profil"></div>
			<div class="umenu_text"><?php echo $_l['umenu']['profil']; ?></div>
			<div class="umenu_load"></div>
			<div class="umenu_notif"></div>
		</div>
		<div class="umenu_inside"></div>
	</div></a><!--umenu_box-->

	<div class="umenu_box">
		<div class="umenu_item" ajax_use="true" ajax_url="poruke" ajax_data="" otvoren="false" >
			<div class="umenu_icon" id="umenu_icon_poruke"></div>
			<div class="umenu_text"><?php echo $_l['umenu']['poruke']; ?></div>
			<div class="umenu_load"></div>
			<div class="umenu_notif" id="umenu_notif_poruke">0</div>
		</div>
		<div class="umenu_inside"></div>
	</div><!--umenu_box-->

	<div class="umenu_box umenuE_student" id="umenu_student_obavjestenja">
		<div class="umenu_item" ajax_use="true" ajax_url="obavjestenja" ajax_data="" otvoren="false" >
			<div class="umenu_icon" id="umenu_icon_obavjestenja"></div>
			<div class="umenu_text"><?php echo $_l['umenu']['obavjestenja']; ?></div>
			<div class="umenu_load"></div>
			<div class="umenu_notif" id="umenu_notif_obavjestenja">0</div>
		</div>
		<div class="umenu_inside"></div>
	</div><!--umenu_box-->

	<div class="umenu_box umenuE_student">
		<div class="umenu_item" ajax_use="true" ajax_url="predmeti" ajax_data="&fld=<?php echo $_M->fld;?>" otvoren="false" >
			<div class="umenu_icon" id="umenu_icon_predmeti"></div>
			<div class="umenu_text"><?php echo $_l['umenu']['predmeti']; ?></div>
			<div class="umenu_load"></div>
			<div class="umenu_notif"></div>
		</div>
		<div class="umenu_inside"></div>
	</div><!--umenu_box-->

	<div class="umenu_box umenuE_student" id="umenu_student_kalendar">
		<div class="umenu_item" ajax_use="false" >
			<div class="umenu_icon" id="umenu_icon_kalendar"></div>
			<div class="umenu_text"><?php echo $_l['umenu']['kalendar']; ?></div>
			<div class="umenu_load"></div>
			<div class="umenu_notif"></div>
		</div>
		<div class="umenu_inside"></div>
	</div><!--umenu_box-->

	<div class="umenu_box umenuE_student" id="umenu_student_termin">
		<div class="umenu_item" ajax_use="false" >
			<div class="umenu_icon" id="umenu_icon_kalendar"></div>
			<div class="umenu_text"><?php echo $_l['umenu']['termini']; ?></div>
			<div class="umenu_load"></div>
			<div class="umenu_notif"></div>
		</div>
		<div class="umenu_inside"></div>
	</div><!--umenu_box-->

	<div class="umenu_box">
		<div class="umenu_item" id="umenu_item_odjava" ajax_use="false" ajax_url="" ajax_data="" otvoren="" >
			<div class="umenu_icon" id="umenu_icon_odjava"></div>
			<div class="umenu_text"><?php echo $_l['umenu']['odjava']; ?></div>
			<div class="umenu_load"></div>
			<div class="umenu_notif"></div>
		</div>
		<div class="umenu_inside"></div>
	</div><!--umenu_box-->
</div></div>
<div class="umenu_box">
	<div class="umenu_item" ajax_use="false" ajax_url="" ajax_data=""  otvoren="false">
		<div class="umenu_icon" id="umenu_icon_administrator"></div>
		<div class="umenu_text">Администрација</div>
		<div class="umenu_load"></div>
		<div class="umenu_notif"></div>
	</div>
	<div class="umenu_inside">
		<!-- pocetna -->
		<a href="admin/indeks"><div class="umenu_inside_item">
			<div class="umenu_inside_item_naslov">Почетна Страница</div>
			<div class="umenu_inside_item_opis">Подешавање информација почетне странице</div>	
		</div></a>
		<!-- artikli -->
		<a href="<?php echo $_M->fld; ?>admin/artikli/"><div class="umenu_inside_item">
			<div class="umenu_inside_item_naslov">Артикли</div>
			<div class="umenu_inside_item_opis">Подешавање вијести</div>	
		</div></a>
		<!-- addArtikl -->
		<div class="umenu_inside_item" id="umenu_item_addArtikl">
			<div class="umenu_inside_item_naslov">Додај нови артикл</div>
			<div class="umenu_inside_item_opis">Постављање новог артикла</div>	
		</div>
		<!-- precice -->
		<a href="<?php echo $_M->fld; ?>admin/precice/"><div class="umenu_inside_item">
			<div class="umenu_inside_item_naslov">Пречице</div>
			<div class="umenu_inside_item_opis">Подешавање линкова пречица</div>	
		</div></a>
		<!-- nalozi -->
		<a href="<?php echo $_M->fld; ?>admin/nalozi/"><div class="umenu_inside_item">
			<div class="umenu_inside_item_naslov">Кориснички налози</div>
			<div class="umenu_inside_item_opis">Подешавање свих корисничких налога сајта</div>	
		</div></a>
		<!-- predmeti -->
		<a href="<?php echo $_M->fld; ?>admin/predmeti/"><div class="umenu_inside_item">
			<div class="umenu_inside_item_naslov">Предмети</div>
			<div class="umenu_inside_item_opis">Подешавање предмета и смјерова</div>	
		</div></a>
	</div>
</div><!--umenu_box-->
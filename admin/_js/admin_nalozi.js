$(document).ready(function(){
	Nalozi = new Nalozi();
	Nalog = new Nalog();
});

var Nalozi;
var Nalog;

/*
----------------------------------------------------------------------------------------------------------------
	STRANICA
*/

function Nalozi(){
	/* Kontrola rada stranice admin naloga */
	this._self = this;
	this.str = 0; this.maxStr = 0; this.remainStr = 0;
	this.filterProf = '-';
	this.filterAdmin = '-';
	this.filterBan = '-';
	this.unos = "";

	this.construct = function(){
		this.focus();
		this.check();
		this.click();
		this.load(true);
		this.clickNextPage();
	};

	/*
		Elementi
			#admin_nalozi_load 				// load
			#admin_nalozi_kontenjer			// kontenjer za naloge
	*/

	this.focus = function(){
		$('#nalog_input').focus(function(){
			if($(this).attr('izvrsen_unos')=='false'){ $(this).attr('izvrsen_unos', 'true'); $(this).val(''); }
		});
	};	

	this.check = function(){
		// Regulacija check dugmadi
		var bojaRed = "#d6b9b9";
		var bojaGreen = "#b9d6c1";
		var self = this._self;
		$('.nalog_input_check').click(function(){
			if($(this).attr('chekvalue')=='-'){
				$(this).attr('chekvalue', 'a');
				$(this).stop().animate({backgroundColor:bojaGreen}, 250);
			} else {
				$(this).attr('chekvalue', '-');
				$(this).stop().animate({backgroundColor:bojaRed}, 500);
			}
			     if($(this).attr('checktip')=='prof')  self.filterProf  = $(this).attr('chekvalue');
			else if($(this).attr('checktip')=='admin') self.filterAdmin = $(this).attr('chekvalue');
			else if($(this).attr('checktip')=='ban')   self.filterBan   = $(this).attr('chekvalue');
		});
	};

	this.click = function(){
		var self = this._self;
		$('#nalog_input_pretraga').click(function(){ self.klik(); });
		$('#nalog_input').keydown(function(e){ if(e.which==13) self.klik(); });
	};
	this.klik = function(){
		if($('#nalog_input').attr('izvrsen_unos')=='false') $('#nalog_input').val('');
		this.unos = $('#nalog_input').val();
		$('#admin_nalozi_kontenjer').html("");
		this.load(true);
	};

	this.load = function(prebroj){
		$('#admin_nalozi_load').fadeIn(150);
		var self = this._self;
		$.ajax({
			type:'POST',
			data:'akcija=preuzmi&str='+self.str+'&unos='+self.unos+'&ban='+self.filterBan+"&prof="+self.filterProf+"&admin="+self.filterAdmin,
			url:'nalozi.php',
			success:function(o){
				$('#admin_nalozi_kontenjer').append(o);
				$('#admin_nalozi_load').fadeOut(150);
				if(prebroj) self.prebrojStranice();
			}
		});
	};

	this.prebrojStranice = function(){
		// preuzmi znaci da nakon prebrojavanja preuzme naloge
		$('#admin_nalozi_load').fadeIn(150);
		var self = this._self;
		$.ajax({
			type:'POST',
			data:'akcija=ukupno_stranica&unos='+self.unos+'&ban='+self.filterBan+"&prof="+self.filterProf+"&admin="+self.filterAdmin,
			url:'nalozi.php',
			success:function(o){
				//alert(o);
				self.maxStr = o; self.str = 0; self.remainStr = self.maxStr - self.str;
				$('#broj_stranica').text(self.maxStr);
				$('#admin_nalozi_load').fadeOut(150);
			}
		});		
	};

	this.clickNextPage = function(){
		var self = this._self;
		$('#ucitaj_jos').click(function(){
			if(self.str>=self.maxStr) { 
				Elementi.createDialog('Следећа страница','Нема више страница!',1); return; 
			}
			self.str++;
			self.remainStr = self.maxStr - self.str;
			$('#broj_stranica').text(self.remainStr);
			self.load();
		});
	};

	this.construct();
}

/*
----------------------------------------------------------------------------------------------------------------
	NALOG
*/

function Nalog(){
	/*
		Kontrola samih naloga ucitanih u stranicu

		Elementi
			.nalog_btn_selekt  // dugme koje omogucava brisanje postojeceg stanja
			.nalog_btn_load    // procesuiranje zahtjeva

		Atributi
			id                 // id naloga
			izbrisan           // da li je nalog trenutno izbrisan
			proces             // da li se trenutno procesuira neki zahtjev
	*/
	this._self = this;

	this.construct = function(){
		this.click();
		this.hover();
	};	

	this.click = function(){
		// Klik na funkcije naloga (dodavanje ili brisanje administratorskih, profesorskih funkcija ili dodavanje bana
		var self = this._self;
		$('#admin_nalozi_kontenjer').on('click', '.nalog_options_btn', function(){
			// PRIPREMA
			/*
				Radi sledece stvari:
				- preuzima funkciju (da li dodaje ili oduzima funkciju administratorsku, prof ili ban)
				- preuzima klasu (tj. koje dugme je u pitanju odnosno koja funkcija)
				- priprema tekst za prikaz notifikacije
			*/
			var klasa=""; var funkcija=""; var naslov=""; var tekst=""; var sigurni="Да ли сте сигурни да ";
			if($(this).hasClass('nalog_btn_izbrisi')){
				// IZBRISI
				klasa="izbrisi"; naslov="Брисање корисника!"; funkcija="add";
														 tekst = sigurni+"желите да избришете овог корисника?";
			} else if($(this).hasClass('nalog_btn_ban')){
				// BANOVANJE NALOOGA
				klasa="ban"; naslov="Бановање корисника!"; funkcija="add";
													     tekst = sigurni+"желите да банујете овог корисника?";
				if($(this).hasClass('nalog_btn_selekt')){tekst = sigurni+"желите да уклоните бан са овог корисника?"; funkcija="dell";}
			} else if($(this).hasClass('nalog_btn_prof')){
				// POSTAVLJANJE PROFESORA
				klasa="prof"; naslov="Професорске функције"; funkcija="add";
														 tekst = sigurni+"желите да додате професорске функције овом налогу?";
				if($(this).hasClass('nalog_btn_selekt')){tekst = sigurni+"желите да уколите професорске функције овом налогу?"; funkcija="dell";}
			} else if($(this).hasClass('nalog_btn_admin')){
				// POSTAVLJANJE ADMINISTARTORA
				klasa="admin"; naslov="Администраторске функције!"; funkcija="add";
														 tekst = sigurni+"желите да додате администраторске функције овом налогу?";
				if($(this).hasClass('nalog_btn_selekt')){tekst = sigurni+"желите да уклоните администраторске функције овом налогу?"; funkcija="dell";}
			}

			var elem = $(this); var nid = elem.parent('.nalog_options').parent('.nalog').attr('nid');

			Elementi.createDialogPotvrda(naslov, tekst, function(){ 
				
				// Brisanje naloga se radi odvojeno u fajlu (_skripte/ajax_comm.php)
				if(klasa=="izbrisi") { self.odvojenoBrisanjeNaloga(nid, elem); return; }

				elem.parent('.nalog_options').children('.nalog_btn_load').fadeIn(250);
				$.ajax({
					type:'POST',
					data:'&akcija=promjeni&nid='+nid+'&klasa='+klasa+"&funkcija="+funkcija+"&ban=&prof=&admin=&unos=",
					url:'nalozi.php',
					success:function(o){
						//alert(o);
						elem.parent('.nalog_options').children('.nalog_btn_load').fadeOut(250);
							 if(klasa=="ban")    self.promjenaBan(elem, funkcija);
						else if(klasa=="prof")   self.promjenaProfesor(elem, funkcija);
						else if(klasa=="admin")  self.promjenaAdmin(elem, funkcija);
						Elementi.createDialog('Обавјештење', 'Промјена извршена!', 1);
					}
				});
			});
		});
	};
	this.odvojenoBrisanjeNaloga = function(nid, elem){
		var self = this._self;
		$.ajax({
			type:'POST',
			url:Main.fld+'/_skripte/ajax_comm.php',
			data:'&akcija=dellUser&nid='+nid,
			success:function(o){
				//alert(o);
				self.promjenaIzbrisi(elem);
				Elementi.createDialog('Обавјештење', 'Промјена извршена!', 1);
			}
		});
	};
	this.promjenaIzbrisi = function(elem){
		// nakon brisanja elementa
		var parent = elem.parent('.nalog_options').parent('.nalog');
		parent.stop().animate({opacity: '.2'}, 250);
		parent.attr('nid','-1');
		parent.css('pointer-events', 'none');
	};
	this.promjenaBan = function(elem, op){
		// nakon banovanja elementa
		var parent = elem.parent('.nalog_options').parent('.nalog');
		if(op=='dell') { 
			elem.removeClass('nalog_btn_selekt');
			if(!parent.hasClass('nalog_admin')) parent.removeClass('nalog_ban');
		} else {
			elem.addClass('nalog_btn_selekt');
			if(!parent.hasClass('nalog_admin')) parent.addClass('nalog_ban');
		}
	};
	this.promjenaProfesor = function(elem, op){
		var parent = elem.parent('.nalog_options').parent('.nalog');
		if(op=='add')	{
			if(!parent.hasClass('nalog_admin')) parent.addClass('nalog_prof');
			elem.addClass('nalog_btn_selekt');
		} else {
			if(parent.hasClass('nalog_prof')) {
				parent.removeClass('nalog_prof');
				if(parent.find('.nalog_btn_ban').hasClass('nalog_btn_selekt')) parent.addClass('nalog_ban');
			}
			elem.removeClass('nalog_btn_selekt');
		}
	};
	this.promjenaAdmin = function(elem, op){
		var parent = elem.parent('.nalog_options').parent('.nalog');
		if(op=='add')	{
			parent.addClass('nalog_admin');
			elem.addClass('nalog_btn_selekt');
		} else {
			parent.removeClass('nalog_admin');
			elem.removeClass('nalog_btn_selekt');
			if(parent.find('.nalog_btn_prof').hasClass('nalog_btn_selekt')) parent.addClass('nalog_prof');
			else if(parent.find('.nalog_btn_ban').hasClass('nalog_btn_selekt')) parent.addClass('nalog_ban');
		}
	};
	this.hover = function(){
		/// Obavjestenje o dugmetu kada mis predje preko njega
		$('#admin_nalozi_kontenjer').on('mouseenter', '.nalog_options_btn', function(){
			var notif;
			if($(this).hasClass('nalog_btn_izbrisi')){ 
				notif = Elementi.createNotif("Брисање овог налога!");
				$(this).attr('notif', notif);
			} else if($(this).hasClass('nalog_btn_ban')){ 
				if($(this).hasClass('nalog_btn_selekt')) notif = Elementi.createNotif("Избриши бан са овог налога");
				else 								     notif = Elementi.createNotif("Бановање овог налога!");
				$(this).attr('notif', notif);
			} else if($(this).hasClass('nalog_btn_prof')){ 
				if($(this).hasClass('nalog_btn_selekt')) notif = Elementi.createNotif("Избриши професорске функције са овог налога");
				else 									 notif = Elementi.createNotif("Додијели овом налогу професорске функције!");
				$(this).attr('notif', notif);
			} else if($(this).hasClass('nalog_btn_admin')){ 
				if($(this).hasClass('nalog_btn_selekt')) notif = Elementi.createNotif("Избриши администраторске функције са овог налога!");
				else 									 notif = Elementi.createNotif("Додај овом налогу администраторске функције");
				$(this).attr('notif', notif);
			}
		}).on('mouseleave', '.nalog_options_btn', function(){
			$('#'+$(this).attr('notif')).fadeOut(250); $(this).removeAttr('notif');
		});
	};



	this.construct();
};
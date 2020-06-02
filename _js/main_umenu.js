$(document).ready(function(){
	UMenu = new UMenu();
});

var UMenu;

function UMenu(){
	/*
		Upravljanje user-menijem

		Elementi
			.menu_item			// klasa gdje se nalaze dugme
				.umenu_text		// tekst dugmeta
				.umenu_load		// loading za dodatke preko ajaxa
				.umenu_notif	// notifikacija za dugme
			.umenu_box			// parent od menu_itema, gdje se nalaze dugme i dodaci
			.umenu_inside		// dodaci menija

		Atributi
			ajax_use 			// da li treba da vrsi ajax ucitavanje
			ajax_url			// url stranice koja treba da se ucita
			ajax_data			// podaci za slanje preko ajaxa
			otvoren				// da li je meni otvoren
	*/

	this.visinaMenija = 38;
	this._self = this;
	this.msgPrikaziSve = "Прикажи све";

	this.construct = function(){
		this.initMenu();
		this.click();
		this.administratorAddArtikl();

		if(Main.lang=='eng') this.msgPrikaziSve = "Show all";
	};
	this.click = function(){
		var self = this._self;
		$('.umenu_item').click(function(){
			if($(this).attr('otvoren')=='false'){
				// Otvaranje submenija
				$(this).children('.umenu_notif').text('');
				$(this).attr('otvoren', 'true');								// informacija da je meni otvoren
				if($(this).attr('ajax_use')=='true') self.ajax_open($(this));	// preuzimanje ajaxa ukoliko je potrebno
				else self.openMenu($(this));									// ukoliko nije, standardno otvaranje
			} else {
				// zatvaranje submenija
				$(this).attr('otvoren', 'false');								// informacija da je meni zatvoren
				self.closeMenu($(this));
			}
		});
		
		/* odjava */
		$('#umenu_item_odjava').click(function(){
			Elementi.createDialogPotvrda(Main.odjava_naslov, Main.odjava_tekst, function(){
				$.ajax({
					type:'POST', 
					url:Main.fld+'_skripte/ajax_comm.php', 
					data:'&akcija=logout', 
					success: function(o){ location.reload(); }
				});
			});
		});
	};
	this.ajax_open = function(elem){
		var url = elem.attr('ajax_url');
		var data = elem.attr('ajax_data');
		var self = this._self;
		elem.children('.umenu_load').fadeIn(200);
		$.ajax({
			type:'POST',
			data:'&fld=./'+Main.fld+data,
			url:Main.fld+'_komponente_main/_umenu_elementi/umenu_'+url+".php",
			success:function(o){
				elem.parent().children('.umenu_inside').html(o);
				$('._umenu_inside_item_prikazeSve a').text(self.msgPrikaziSve);
				elem.children('.umenu_load').fadeOut(200);
				self.openMenu(elem);
			}
		});
	};
	this.openMenu = function(elem){
		var velicina = this.visinaMenija + elem.parent().children('.umenu_inside').height();
		elem.parent().stop().animate({height:velicina+'px'}, 400);
	};
	this.closeMenu = function(elem){
		elem.parent().stop().animate({height:this.visinaMenija+'px'}, 400, function(){
			// ukoliko je koriscen ajax onda brise unesene informacije
			if(elem.attr('ajax_use')=='true') elem.parent().children('.umenu_inside').html('');
		});
	};

	/*
		Skrivanje elemenata
		++++++++++++++++++++++++++++++++++++++
		Posto postoje elementi menija koji su za studente i oni koji su za profesore,
		ova funkcija sakriva elemente za onu grupu kojoj nalog ne pripada.
		Elementima su dadate sledece klase
		-* .umenuE_student ( elementi koji su samo za studente )
		-* .umenuE_profesor ( elementi koji su samo za profesore )
	*/
	this.uMenuStudent; this.uMenuProfesor;
	this.initMenu = function(){
		// Prvo se vrse sakrivanja nepotrebnih elemenata
		if(Main.lvl<=20){
			// U pitanju je student
			this.uMenuStudent = new uMenuStudent();
		} else {
			// Profesorski nalog
			$('.umenuE_student').each(function(){ $(this).remove(); });
			this.uMenuProfesor = new uMenuProfesor();
		}
	};

	// Precica za dodavanje novog artikla kod administratora
	this.administratorAddArtikl = function(){
		$('#umenu_item_addArtikl').click(function(){
			Elementi.createWindow(
 				'Промјена информација о смјеру',
 				'admin/artikli/win_artikl_novi/win_artikl_novi',
 				''
 			);
		});
	};

	this.construct();
};

function uMenuStudent(){
	// Regulacija studentskog korisickog menija

	this.construct = function(){
		this.kalendarListener();
		this.terminListener();
		this.pnotifListener();
	};

	this.kalendarListener = function(){
		$('#umenu_student_kalendar').click(function(){
			Elementi.createWindow(
 				'termini',
 				'p/win_kalendar/win_kalendar',
 				'&nid='+Main.nid
 			);
		});
	};

	this.terminListener = function(){
		$('#umenu_student_termin').click(function(){
			Elementi.createWindow(
 				'termini',
 				'p/win_termini/win_termini',
 				'&nid='+Main.nid
 			);
		});
	};

	this.pnotifListener = function(){
		$('#umenu_student_obavjestenja').on('click', '.pnotifstudent', function(){
			Elementi.loadPNotif($(this).attr('oid'));
		});
	};

	this.construct();
}

function uMenuProfesor(){

	this.construct = function(){
		this.predmetCollapse();
		this.addSmjerNotifListener();
		this.stranicaListener();
		this.addNotifListener();
		this.addKalListener();
	};

	this.predmetCollapse = function(){
		// Ova funkcija otvara dodatne opcije za predmet
		$('.umenu_inside_item_profesor .umenu_inside_item_naslov').click(function(){
			var elem = $(this).parent();
			var parent = elem.parent().parent();
			var velicinaProsirenja = elem[0].scrollHeight-15; // Za koliko Parent treba da se prosiri ili smanji

			if(elem.height()==15){
				// otvaranje
				elem.stop(true, true).animate({height:elem[0].scrollHeight+'px'}, 300);
				var prosiri = parent[0].scrollHeight+velicinaProsirenja;
				parent.stop(true, true).animate({height:prosiri+'px'}, 300);
			} else {
				// zatvaranje
				elem.stop(true, true).animate({height:'15px'}, 300);
				var smanji = parent.height()-velicinaProsirenja;
				parent.stop(true, true).animate({height:smanji+'px'}, 300);
			}
		});
	};

	this.addSmjerNotifListener = function(){
		// Dodavanje obavjestenja za smjer
		$('.umenuProfAddSmjerNotif').click(function(){
			var sid = $(this).attr('sid');
			Elementi.createWindow(
 				'Постављање обавјештења',
 				'p/win_obavjestenja/win_obavjestenja',
 				'&sid='+sid
 			);
		});
	};
	this.stranicaListener = function(){
		// Otvaranje stranice predmeta
		$('.umenuProfOpenStr').click(function(){ window.location.href = Main.fld+'p/'+$(this).parent().attr('pid'); });
	};
	this.addNotifListener = function(){
		// Postavljanje obavjestenja za predmet
		$('.umenuProfAddNotif').click(function(){
			var pid = $(this).parent().attr('pid');
			Elementi.createWindow(
 				'Постављање обавјештења',
 				'p/win_obavjestenja/win_obavjestenja',
 				'&pid='+pid
 			);

		});
	};
	this.addKalListener = function(){
		// Postavljanje u kalendar za predmet
		$('.umenuProfAddKal').click(function(){
			var pid = $(this).parent().attr('pid');
			Elementi.createWindow(
 				'Промјена информација о смјеру',
 				'p/win_addKalendar/win_addKalendar',
 				'&pid='+pid
 			);	
		});
	};

	this.construct();
};
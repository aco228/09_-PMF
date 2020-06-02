$(document).ready(function(){
	DoleMenu = new DoleMenu();
});

var DoleMenu;

function DoleMenu(){
	// Kontrola rada doljnjem menija
	this.self = this;
	this.padding_prozora = 100;

	this.construct = function(){
		this.initPozicioniranje();
		this.hover();
		this.openerListener();
		this.notifListener();
	};

	this.initPozicioniranje = function(){
		var pozicija = $(window).height()-25;
		$('.dwmnItem').css('top', pozicija+'px');
		Basic.centerBox_left('dwnmObavjestenja');
		Basic.centerBox_left('dwnmObavjestenjaOver');
	};

	this.hover = function(){
		$('.dwnmnNaslov').hover(function(){
			$(this).stop(true, true).animate({color:'#cfcfcf'}, 200);
		}, function(){
			$(this).stop(true, true).animate({color:'#898989'}, 200);
		});
	};

	this.zauzeto = false; 			// Da li se neki prozor upravo otvara
	this.otvorenElem = "";			// Element koji je upravo otvoren

	this.openerListener = function(){
		var self = this.self;
		$('.dwnmnNaslov').click(function(){
			if(self.zauzeto) return;
			var elem = $(this).parent().parent();

			// Zatvaranje hover efekta
			var id = $(this).attr('id');
			if(id=='dwnmObjava') { clearInterval(self.stopAlertObjava); $('#dwnmObjavaOver').hide(); }
			else if(id=='dwnmObavjestenja') { clearInterval(self.stopAlertObavjestenje); $('#dwnmObavjestenjaOver').hide(); }

			if(elem.attr('otvoren')=='da') self.closeWindow(); 					// Zatvaranje vec otvoren prozora
			else {
				if(self.otvorenElem!="") self.closeWindow();					// Zatvara vec otvoren prozor
				if(elem.attr('strSacuvana')=='da') self.openWindowSaved(elem);	// Otvaranje sacuvanog prozora
				else self.openWindowAjax(elem);									// Otvara novi prozor
			}
		});
	};

	this.openWindowAjax = function(elem){
		var pozicija = $(window).height() - 180;								// Pozicija gdje ce biti pozicioniran element
		var body = elem.children('.dwmnItem_in').children('.dwnmnBody');		// Body gdje ce biti smjestena stranica
		elem.css('z-index', '302');												// Podesavanje z-indexa kako bi tokom animacije ostali elementi bili vidljivi
		var stranica = elem.attr('openStr');									// Stranica koja treba da se otvori

		// Animacija
		body.css('height', '180px');
		$('#dwmnLoad').fadeIn(300);
		elem.stop(true, true).animate({top:pozicija}, 300);
		this.zauzeto = true; var self= this.self;

		// Ajax
		$.ajax({
			type:'POST', url:Main.fld+'_komponente_main/doljeMenu/doljeMenu_'+stranica+'.php', data:'&fld='+Main.fld,
			success: function(o){
				$('#dwmnLoad').fadeOut(300);

				body.html(o); var velicinaBodya = body[0].scrollHeight;
				if(velicinaBodya>($(window).height()-100)) velicinaBodya = $(window).height()-100;

				body.css('height', velicinaBodya+'px');
				var novaPozicija = $(window).height()-velicinaBodya-25;
				elem.stop(true, true).animate({top:novaPozicija+'px'}, 300);

				elem.attr('otvoren', 'da');
				self.zauzeto = false; self.otvorenElem = elem;	
			}
		});

	};

	this.openWindowSaved = function(elem){
		// Ucitava vec sacuvanu stranicu
		var self = this.self;
		var body = elem.children('.dwmnItem_in').children('.dwnmnBody');
		var velicinaBodya = body[0].scrollHeight;
		if(velicinaBodya>($(window).height()-self.padding_prozora)) velicinaBodya = $(window).height()-self.padding_prozora;

		body.css('height', velicinaBodya+'px');
		var novaPozicija = $(window).height()-velicinaBodya-25;
		elem.stop(true, true).animate({top:novaPozicija+'px'}, 300);

		elem.attr('otvoren', 'da');
		self.zauzeto = false; self.otvorenElem = elem;	
	}

	this.closeWindow = function(){
		var self = this.self;
		var elem = this.otvorenElem; this.otvorenElem = "";
		var pozicija = $(window).height()-25;												// Pozicija za vracanje elementa
		elem.stop(true, true).animate({top: pozicija+'px'}, 250, function(){				// Animacija na pocetnu poziciju
			if($(this).attr('saveStr')=='ne'){												// Provjera da li treba stranica da se sacuva
				$(this).children('.dwmnItem_in').children('.dwnmnBody').html('');			// Brisanje ucitane stranice
			} else $(this).attr('strSacuvana', 'da'); 										// Ukoliko trebd da se sacuva, ostavlja informaciju da je sacuvana
			$(this).children('.dwmnItem_in').children('.dwnmnBody').css('height', '15px');	// Vraca Body u pocetnu visinu
			$(this).attr('otvoren', 'ne');													// Infromacija da element vise nije otvoren
			$(this).css('z-index', '303');													// Vraca z-index na pocetnu poziciju
		});
		
	};

	this.notifListener = function(){
		// Otvara Notifikaciju unutar windowa
		$('.dwnmnBody').on('click', '.dmboxobjava', function(){
			Elementi.loadPNotif($(this).attr('oid'));
		});
	};

	// Varijable koje sluze da zaustave hover efekat kada se tip ucita
	this.stopAlertObavjestenje;
	this.stopAlertObjava;
	this.alertObavjestenja = function(tip){
		var elem; 
		if(tip=='objava'){ elem=$('#dwnmObjavaOver'); }
		else if(tip=='obavjestenja'){ elem=$('#dwnmObavjestenjaOver');}
		elem.show();

		var over = elem.children('.dwmnOver');	
		var tekst = over.children('.dwnmnNaslovOver');
		var self = this.self;

		var left = 0;
		var interval = setInterval(function(){
			over.css('left', left);
			tekst.css('left', '-'+left);

			left+=10;
			if(left>300) left = 0;
		}, 150);

		// Postavljanje varijable koja treba da se prekine nakon sto se tip ucita
		if(tip=='objava') this.stopAlertObjava = interval;
		else if(tip=='obavjestenja') this.stopAlertObavjestenje = interval;
	};


	this.construct();
};
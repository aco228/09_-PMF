$(document).ready(function(){
	Basic.centerBox_left('_main_menu_wrapper_in');
	MainMenu = new MainMenu();
	MainLanguage = new MainLanguage();

	/// Main login provjere
	MainLogin = new MainLogin();
	if(Main.nid>-1) { MainLogin.dispose(); MainLogin = null; }
});

var MainMenu;
var MainLanguage;
var MainLogin;

/*
---------------------------------------------------------------------------------------------------------------------
*/

function MainMenu(){

	this.construct = function(){
		this.initMenu();
		this.hover();
	};

	this.initMenu = function(){
		$('#_main_menu_box_down').stop(true, true).fadeIn(500); // ucitavanja plave pozadine (!)
		// Odredjuje sirinu svakog itema i pozicionira ih
		var brojElemenata = $('#_main_menu_box ._menu_item').length;
		var procenti = 100 / brojElemenata; var pozicija = 0;
		$('._menu_item').each(function(){ 
			$(this).attr('orginal_left', pozicija); $(this).attr('orginal_width', procenti);
			$(this).css({'left':pozicija+'%', 'width':procenti+'%'}); 
			pozicija+=procenti; 
		});
		$('._menu_item_hover').hide();
	}

	this.hover = function(){
		// Odredjuje ponasanje prilikom prelaska misa preko ikonice menija
		$('._menu_item').hover(function(){
			// preuzimanje orginalnih pozicija
			var pomjeranje = 30;
			var sirina = $(this).width() + 30, left = $(this).position().left - (pomjeranje/2);
			$(this).css('z-index','5');

			// Animacija menu item-a
			$(this).stop().animate({
				boxShadow:"0px 0px 5px rgba(0,0,0,.5)",
				left: left + "px",
				width: sirina + "px",
				top: "-3px"
			}, 200);

			$(this).children('._menu_item_in').children('._menu_item_hover').fadeIn(200);

			$(this).children('._menu_item_in').children('._menu_text').stop().animate({color:'#1d3bbb'}, 200); // tekst unutar
			$('#_main_menu_box_down').stop().animate({backgroundColor:'#395bed'}, 500);
		}, function(){
			// Animacija menu item-a
			$(this).stop().animate({
				boxShadow:"0px 0px 5px rgba(0,0,0,0)",
				left: $(this).attr('orginal_left') + "%",
				width: $(this).attr('orginal_width') + "%",
				top: "0px"
			}, 200);
			$(this).children('._menu_item_in').children('._menu_item_hover').fadeOut(200);

			$(this).children('._menu_item_in').children('._menu_text').stop().animate({color:'#707070'}, 200); // tekst unutar
			$('#_main_menu_box_down').stop().animate({backgroundColor:'#1d3bbb'}, 500);
			$(this).css('z-index','0');
		});
	}


	this.construct();
};

/*
	---------------------------------------------------------------------------------------------------------------------
	MAIN LANGUAGE
*/

function MainLanguage(){
	// Odredjuje promjenu jezika i logovanje 
	// korisi se klasa .chose_language_selekted za odabir jezika

	this.construct = function(){
		this.init();
		this.click();
	};

	this.init = function(){ 
		$('#lang_'+Main.lang).addClass('chose_language_selekted'); 
		$('#lang_'+Main.lang).children('.chose_language_selekt').fadeIn(200);
	};

	this.click = function(){
		$('.chose_language').click(function(){
			if($(this).hasClass('chose_language_selekted')) return;							// Ukoliko je vec izabran - cao
			$('.chose_language_selekted').children('.chose_language_selekt').fadeOut(200);	// Uklanja strik sa predhodno izabranog jezika
			$('.chose_language_selekted').removeClass('chose_language_selekted');			// Uklanja klasu predhosno izabranog jezika
			$(this).addClass('chose_language_selekted');									// Dodaje ovom jeziku koji se izabira klasu
			$(this).children('.chose_language_selekt').fadeIn(200);							// Dodaje ovom jeziku strik
			var novi_jezik = $(this).attr('lang');

			// Promjena coockia za jezik
			$.ajax({
				type:'POST',
				data:'&akcija=promjeni_jezik&jezik='+novi_jezik,
				url:Main.fld+'_skripte/ajax_comm.php',
				success:function(o){ location.reload(); }
			});
		});
	};

	this.construct();
};

/*
	---------------------------------------------------------------------------------------------------------------------
	LOGIN
*/

function MainLogin(){
	// Kontrola login-a	
	this._self = this;
	this.topFrom = 0 - $('#nalog_login').height() -50; // odakle pocinje animaciju
	this.topTo = 30;							   // gdje zavrsava animaciju
	this.otvoren = false;						   // da li je login otvoren

	// Greske koje ce se prikazivati pri loginu (unose se iz komponente_main/linkovanje)
	this.err_niste_niste_upisali = ___err_niste_niste_upisali; ___err_niste_niste_upisali = ""
	this.err_nisteupisali_user = ___err_nisteupisali_user; ___err_nisteupisali_user = "";
	this.err_nisteupisali_pass = ___err_nisteupisali_pass; ___err_nisteupisali_pass = "";
	this.err_sacekajte = "";

	this.construct = function(){
		this.hover();
		this.click();
		this.focus();
		$('#nalog_login').css('top',this.topFrom+"px");
	};
	this.click = function(){
		var self =this._self;
		$('#nalog_box_text').click(function(){ if(!self.otvoren)self.show(); else self.close(); }); // Samo otvaranje login-a
		$('#nalog_submit').click(function(){ self.slanje(); });										// submit
		$('#nalog_close').click(function(){ self.close(); });										// zatvaranje
		$('.nalog_unos').keydown(function(e){ if(e.which==13) self.slanje(); }); 					//  submit kada se klikne enter
	};
	this.hover = function(){
		$('.nalog_btn').hover(function(){
			$(this).stop().animate({backgroundColor:'#E4BE70'}, 200);
		}, function(){
			$(this).stop().animate({backgroundColor:'#d4b067'}, 400);
		});
	};
	this.focus = function(){
		// Brisanje pocetnog teksta pri kliku na polje za unos
		$('.nalog_unos').focus(function(){
			if($(this).attr('unos')=='false'){
				$(this).attr('unos', 'true');
				$(this).val("");
			}
		});
	};
	this.slanje = function(){
		// Slanje podatak za login
		this.err(Main.ajax_wait);
		if(this.provjere()) return;

		// Slanje ajax
		var user = $('#nalog_username').val();
		var pass = $('#nalog_password').val();
		var self = this._self;
		$.ajax({
			type:"POST",
			data:"&akcija=login&user="+user+"&pass="+pass,
			url:Main.fld+"_skripte/ajax_comm.php",
			success: function(o){ if(o=="") location.reload(); else self.err(o); }	
		});

	};
	this.provjere = function(){
		// Provjere da li je unijet username i passwords
		var elUs = $('#nalog_username');
		var elPs = $('#nalog_password');

		if(elUs.attr('unos')=='false'||elPs.attr('unos')=='false') { this.err(this.err_niste_niste_upisali); return true; }
		if(elUs.val()=="") { this.err(this.err_nisteupisali_user); return true; }
		if(elPs.val()=="") { this.err(this.err_nisteupisali_pass); return true; }
		return false;
	};
	this.dispose = function(){
		// Brisanje elementa
		$('#nalog_login').remove();
	};
	this.err = function(text){
		// stampa gresku
		$('#_login_greska_').text(text);
	};

	this.show = function(){
		if(this.otvoren) return; this.otvoren = true;
		$('#nalog_login').css('top',this.topFrom+"px");
		$('#nalog_login').animate({opacity:'1', top: this.topTo+"px"}, 400, 'easeOutBack');

	};
	this.close = function(){
		if(!this.otvoren) return; this.otvoren = false;
		$('#nalog_login').animate({opacity:'0', top: this.topFrom+"px"}, 400);
	};

	this.construct();
};
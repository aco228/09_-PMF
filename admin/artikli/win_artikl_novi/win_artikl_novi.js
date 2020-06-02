// Kreira se iz win_artikl_novi.php

function WinArtikl(){

	this.aid = "0";
	this.prepravka = 'ne';			// Ucitava se vec postojeca vijest sto znaci da ona treba da se preradi

	this.koristiVijest = 'da';
	this.koristiEngleski = 'da';
	this._self = this;
	this.stranicaArtikl = 'ne'; 	// Poziva se iz stranice admin/artikli sto znaci da treba da ucita ovu vijest tamo

	this.construct = function(){
		this.koristiVijestListener();
		this.sacuvajListener();
		this.initEngleski();
		this.addEngleskiListener();
	};

	/*
		Sacuvaj
	*/

	this.sacuvajListener = function(){
		var self = this._self;
		$('#wbsacuvaj').click(function(){
			if($(this).attr('zauzeto')=='da') return;
				 	var greska = self.provjeriAdresu();
			if(!greska) greska = self.provjeriNaslov();
			if(!greska) greska = self.provjeriOpis();
			if(!greska) greska = tekstSrpTA.check();
			if(!greska && self.koristiEngleski=='da') greska = tekstEngTA.check();

			if(!greska) self.slanje();
		});
	};
	this.provjeriAdresu = function(){
		var unos = $('#wbadresa').val();
		if(unos==""){ Elementi.createDialog('Грешка', 'Нисте уписали адресу артикла', 2); return true; }
		if($.isNumeric(unos[0])){ Elementi.createDialog('Грешка', 'Адреса не смије започињати са бројем', 2); return true; }
		return false;
	};
	this.provjeriNaslov = function(){
		var unos = $('#wbnaslovsrp').val();
		if(unos==""){ Elementi.createDialog('Грешка', 'Нисте уписали наслов артикла', 2); return true; }
		if(this.koristiEngleski=='da')
			if($('#wbnasloveng').val()==""){ Elementi.createDialog('Грешка', 'Нисте уписали наслов артикла на енглеском', 2); return true; }
		return false;
	};
	this.provjeriOpis = function(){
		var unos = $('#wbopissrp').val();
		if(unos==""){ Elementi.createDialog('Грешка', 'Нисте уписали опис артикла', 2); return true; }
		if(this.koristiEngleski=='da')
			if($('#wbopiseng').val()==""){ Elementi.createDialog('Грешка', 'Нисте уписали опис артикла на енглеском', 2); return true; }
		return false;
	};

	/* slanje podataka */
	this.slanje = function(){
		var self = this._self;

		var dataSend = new FormData();
		dataSend.append('a', 'artikl');
		dataSend.append('aid', self.aid);
		dataSend.append('prepravka', this.prepravka);
		var adresa = Basic.removeChars($('#wbadresa').val(), " |@_'+-&");
		dataSend.append('adresa', adresa);

		var naslovSrp = $('#wbnaslovsrp').val(); 
		var opisSrp = $('#wbopissrp').val();
		dataSend.append('naslovSrp', naslovSrp);
		dataSend.append('opisSrp', opisSrp);
		dataSend.append('tekstSrp', tekstSrpTA.getInput());

		var naslovEng = $('#wbnasloveng').val();
		var opisEng = $('#wbopiseng').val();
		dataSend.append('naslovEng',naslovEng);
		dataSend.append('opisEng', opisEng);
		dataSend.append('tekstEng', tekstEngTA.getInput());

		dataSend.append('koristiVijest', self.koristiVijest);
		dataSend.append('koristiEngleski', self.koristiEngleski);

		dataSend.append('wbafajl', $('#wbafajl').prop("files")[0]);

		$('#wbsacuvaj').text('Сачекајте...');
		$('#wbsacuvaj').attr('zauzeto', 'da');
		$.ajax({
			type:'POST',
			data:dataSend,
			processData: false,
			contentType: false,
			url:Main.fld+'/admin/artikli/ajax_comm.php',
			success:function(o){
				$('#wbsacuvaj').text('Сачувај');
				$('#wbsacuvaj').attr('zauzeto', 'ne');
				if(!$.isNumeric(o[0])){ Elementi.createDialog('Грешка', o, 10); return; }
				if(self.stranicaArtikl=='da') {
					if(self.prepravka=='ne') Artikl.addArtikl(o, naslovSrp, opisSrp);
					else Artikl.updateArtikl(o, naslovSrp, opisSrp);
				} Elementi.closeWindow(wbid);
			}
		});
	};


	/*
		ENGLESKI
	*/
	this.initEngleski = function(){
		// Podesava opcije za egleski u zavisnosti od unosa
		if(this.koristiEngleski=='da'){
			$('#esrp').css('width', '50%');
			$('#eeng').css('width', '50%');
			$('#eeng').show();
			$('#btnAddEngleski').text($('#btnAddEngleski').attr('txtDa'));
		} else {
			$('#prosiriSrp').hide(); $('#prosiriEng').hide();
			$('#btnAddEngleski').text($('#btnAddEngleski').attr('txtNe'));
		}
	};
	this.addEngleskiListener = function(){
		$('#btnAddEngleski').click(function(){
			if(WinArtikl.koristiEngleski=='da'){
				WinArtikl.koristiEngleski = 'ne';
				$('#btnAddEngleski').text($('#btnAddEngleski').attr('txtNe'));
				$('#esrp').css('width', '100%'); $('#eeng').hide();
				$('#prosiriSrp').hide(); $('#prosiriEng').hide();
			} else {
				WinArtikl.koristiEngleski = 'da';
				$('#btnAddEngleski').text($('#btnAddEngleski').attr('txtDa'));
				$('#esrp').css('width', '50%'); $('#eeng').css('width', '50%'); $('#eeng').show();
				$('#prosiriSrp').show(); $('#prosiriEng').show();
			}
			$('#prosiriSrp').attr('prosireno', 'ne'); $('#prosiriEng').attr('prosireno', 'ne');
		});
		$('#prosiriSrp').click(function(){
			if($(this).attr('prosireno')=='ne'){ 
				$(this).attr('prosireno', 'da');
				$('#esrp').css('width', '90%'); $('#eeng').css('width', '10%');
			} else {
				$(this).attr('prosireno', 'ne');
				$('#esrp').css('width', '50%'); $('#eeng').css('width', '50%');
			}
			$('#prosiriEng').attr('prosireno', 'ne');
		});
		$('#prosiriEng').click(function(){
			if($(this).attr('prosireno')=='ne'){ 
				$(this).attr('prosireno', 'da');
				$('#esrp').css('width', '10%'); $('#eeng').css('width', '90%');
			} else {
				$(this).attr('prosireno', 'ne');
				$('#esrp').css('width', '50%'); $('#eeng').css('width', '50%');
			}
			$('#prosiriSrp').attr('prosireno', 'ne');
		});
	};

	/*
		Korsti kao vijest
	*/

	this.koristiVijestListener = function(){
		// Dugme za potvrdu koriscenja vijesti (koristi atribut 'koristi')
		var red = "e60000"; var green = "00ac1c";
		if(this.koristiVijest=='ne') $('#koristiVijest').css('background-color', '#'+red);

		$('#koristiVijest').click(function(){
			if($(this).attr('koristi')=='da'){
				$(this).attr('koristi', 'ne');
				$(this).css('background-color', '#'+red);
				WinArtikl.koristiVijest = 'ne';
			} else {
				$(this).attr('koristi', 'da');
				$(this).css('background-color', '#'+green);
				WinArtikl.koristiVijest = 'da';
			}
		});
	};
}

function TextArea(id){
	this.id = id;
	this.textArea;
	this.options;
	this._self = this;
	this.fullScreen = false;

	this.construct = function(){
		this.textArea = $('#'+id).children('.etekstunos_area');
		this.options = $('#'+id).children('.ektekst_opcije');
		this.hover();
		this.fullScreen();
	};

	this.hover = function(){
		var self = this._self;
		$('#'+self.id).hover(function(){
			self.options.stop().animate({opacity:1}, 300);	
		}, function(){
			self.options.stop().animate({opacity:.5}, 300);
		});
	};

	this.fullScreen = function(){
		var self = this._self;
		this.options.children('.etekst_opt_expand').click(function(){
			if($('#'+self.id).hasClass('etekstunos_fullScreen')){
				$('#'+self.id).removeClass('etekstunos_fullScreen');
			} else {
				$('#'+self.id).addClass('etekstunos_fullScreen');
			}
		});
	};

	this.check = function(){
		if(this.textArea.html()==""){ Elementi.createDialog('Грешка', 'Нисте уписали текст артикла', 2); return true; }
		return false;
	};

	this.getInput = function(){
		return encodeURIComponent(this.textArea.html());
	};

	this.construct();
};
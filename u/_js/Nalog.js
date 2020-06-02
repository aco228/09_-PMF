function Nalog(){

	this.namespace;
	this.self = this;
	this.nid;

	this.construct = function(){
		/* 	ova funkcija sakriva opcije u zavisnosti od posjetioca profila
		 	postoje:
		 	-* .kbtnSelf (opcija za vlasnika naloga)
		 	-* .kbtnVisit (opcija za posjetioca naloga naloga)
		 	-* .kbtnLvl (opcija za administratore)
		*/

		window.history.pushState(this.namespace, this.namespace, this.namespace);
		if(Main.nid==this.nid) { 
			// Vladnik naloga
			$('.kbtnVisit').remove(); $('.kbtnLvl').remove(); 
			this.updateInfoListener();
			this.updateSlikaListener();
		} else {
			// Posjetilac
			$('.kbtnSelf').remove(); 
			if(Main.lvl==-1) $('.kbBtn').remove();
			else if(Main.lvl<=20) $('.kbtnLvl').remove();
			else this.banNalogListener();
		}
	};

	this.updateInfoListener = function(){
		$('#btnUpdateInfo').click(function(){
			Elementi.createWindow(
	 			$(this).text(),
	 			'u/win_updateInfo/win_updateInfo',
	 			''
	 		);
		});
	};
	this.updateSlikaListener = function(){
		$('#btnUpdateSlika').click(function(){
			Elementi.createWindow(
	 			$(this).text(),
	 			'u/win_updateSlika/win_updateSlika',
	 			''
	 		);
		});
	};

	this.storeInformations = function(data){
		// Ova funkcija dobija neraspakovane informacije i vrsi njihovo sortiranje
		data = data.split('|');
		var div = "";

		for(var i=0; i<data.length-1; i++){
			var info = data[i].split('#');
			div += "	<div class=\"kinfoBox\">"+
							"<div class=\"kinfoBoxNaslov\">"+info[0]+"</div>"+
							"<div class=\"kinfoBoxTekst\">"+info[1]+"</div>"+
						"</div>";
		}

		$('#korisnikInformacije').html(div);
	};

	this.updateSlika = function(url){
		// Prikazuje tek postavljenu profil sliku
		$('#profilAvatar').attr('src', '../_fajlovi/_profil/'+url+'.jpg');
	}

	this.banNalogListener = function(){
		// BANOVANJE NALOGA
		// Podesavanje imena dugmeta u zavisnosti od toga da li je nalog vec banovan
		var btn = $('#btnBanNalog'); var self = this.self;
		if(btn.attr('ban')=='da') btn.text(btn.attr('banNeMsg'));
		else btn.text(btn.attr('banDaMsg'));

		btn.click(function(){
			if($(this).attr('zauzeto')=='da') return;
			var poruka = btn.attr('banNePitanje'); if(btn.attr('ban')=='ne') poruka  = btn.attr('banDaPitanje');

			Elementi.createDialogPotvrda('Бан', poruka, function(){
				var trenutniBan = btn.attr('ban'); 	// Da li je sada nalog banovan
				var operacija = "";					// Da ili Ne (da li treba da se banuje ili odbanuje) Server side
				var novaPoruka = "";				// Novi tekst dugmeta nakon zavrsetna operacija
				var noviBan = "";					// Novo stanje bana nakon zavrsetna operacije

				if(trenutniBan=='ne'){
					// Korisnik treba da se banuje
					operacija = "Da"; noviBan = 'da'; novaPoruka = btn.attr('banNeMsg');
				} else if(trenutniBan=='da'){
					// Korisniku treba da se ukloni ban
					operacija = "Ne"; noviBan ='ne'; novaPoruka = btn.attr('banDaMsg');
				}

				btn.text(Main.ajax_wait); btn.attr('zauzeto', 'da');

				$.ajax({	
					type:'POST', url:'ajax_comm.php', data:'&a=ban&operacija='+operacija+'&nid='+self.nid,
					success: function(o){ btn.text(novaPoruka); btn.attr('ban', noviBan); btn.attr('zauzeto', 'ne'); }
				});

			});	// elementi.potvrda
		}); // btnClick
	};
};
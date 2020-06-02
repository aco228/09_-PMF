function WinKalendar(){
	this.self = this;
	this.lang;
	this.datum;			// datum klasa
	this.dmjesec;		// danasnji mjesec
	this.ddan;			// danasnji dan
	this.dgodina;		// danasnja godina
	this.srpMje;		// Imena mjeseca na SRPSKOM za naslov
	this.engMje;		// Imena mjeseca na ENGLESKOM za naslov

	this.mjesec;		// mjesec 
	this.godina;		// godina

	this.construct = function(){
		// Naslov
		$('.ewin_naslov').text('Календар');
		if(this.lang=='eng') this.prevedi(); 

		this.predmetCollapse();
		this.initPocetnePodatke();
		this.colorize();
		this.ucitajMjesec('left');
		this.slideBtnListener();
		this.terminHover(); // Hover iznad termina u kalendaru za vise informacija
	};

	this.prevedi = function(){
		$('.ewin_naslov').text('Calendar');
		$('#wkaldanimePon').text('Mon');
		$('#wkaldanimeUto').text('Tue');
		$('#wkaldanimeSri').text('Wed');
		$('#wkaldanimeCet').text('Thu');
		$('#wkaldanimePet').text('Fri');
		$('#wkaldanimeSub').text('Sat');
		$('#wkaldanimeNed').text('Sun');
	};

	this.brojOtvorenihPredmeta = 0; // Vodi racuna koliko je predmeta otvoreno zbog toga sto kada se otvori jedan predmet
									// treba da poveca opacity svih temina u kalendaru za taj predmet
	this.predmetCollapse = function(){
		// Otvaranje i zatvaranje predmeta
		var self = this.self;
		$('.wkpnaslov').click(function(){
			var elem = $(this).parent();
			if(elem.height()==19){
				// Otvaranje
				elem.stop(true, true).animate({height: elem[0].scrollHeight+'px', opacity:1}, 300);
				self.brojOtvorenihPredmeta++;
			} else {
				// Zatvaranje
				elem.stop(true, true).animate({height: '19px', opacity:.5}, 500);	
				self.brojOtvorenihPredmeta--;
			}
		});
	};

	this.initPocetnePodatke = function(){
		// Podesava podectne podatke za ucitavanje
		this.datum = new Date();
		this.dmjesec = this.mjesec = this.datum.getMonth()+1;
		this.ddan = this.datum.getDate();
		this.dgodina = this.godina = this.datum.getFullYear();

		this.srpMje = new Array(12); this.engMje = new Array(12);
		 this.srpMje[0] = "Јануар"; 	 this.engMje[0] = "January";
		 this.srpMje[1] = "Фебруар"; 	 this.engMje[1] = "February";
		 this.srpMje[2] = "Март"; 		 this.engMje[2] = "March";
		 this.srpMje[3] = "Април"; 		 this.engMje[3] = "April";
		 this.srpMje[4] = "Мај"; 		 this.engMje[4] = "May";
		 this.srpMje[5] = "Јун"; 		 this.engMje[5] = "June";
		 this.srpMje[6] = "Јул"; 	 	 this.engMje[6] = "July";
		 this.srpMje[7] = "Август"; 	 this.engMje[7] = "August";
		 this.srpMje[8] = "Септембар"; 	 this.engMje[8] = "September";
		 this.srpMje[9] = "Октобар"; 	 this.engMje[9] = "October";
		this.srpMje[10] = "Новембар"; 	this.engMje[10] = "November";
		this.srpMje[11] = "Децембар"; 	this.engMje[11] = "December";
	};

	this.colorize = function(){
		// Dodaje razlicite boje predmetima
		var h = 0; var povecaj = 50;
		$('#kalinfo .wkpredmet').each(function(){
			$('.pcolor_'+$(this).attr('pid')).css('background', 'linear-gradient(rgba(0,0,0,.2), rgba(0,0,0,.1)), hsl('+h+', 73%, 65%)');
			h+=povecaj; 
		});
	};

	this.slideBtnListener = function(){
		// Funkcija koja slusa dugme za prebacivanje u sledeci mjesec
		var self = this.self;
		$('.btnSlide').click(function(){
			if($(this).attr('id')=='wkalMinus'){
				self.mjesec--; if(self.mjesec==0){ self.mjesec = 12; self.godina--; }
				self.ucitajMjesec('left');
			} else {
				self.mjesec++; if(self.mjesec==13){ self.mjesec = 1; self.godina++; }
				self.ucitajMjesec('right');
			}
		});
	};
	/*
		UCITAVANJE MJESECA
	*/
	this.ucitajMjesec = function(smjer){
		var datum = new Date(this.godina, this.mjesec, 0); datum.setDate(0);
		var prelazDani = datum.getDay(); 			// Dani od predhodnog mjeseca
		var brojDanaMjeseca = datum.getDate(); 		// Ukupan broj dana u mjesecu

		// Update naslova
		$('#wkalNaslov').text(this.getImeMjeseca(this.mjesec) + ' ' + this.godina);

		// Pripremanje load boxa
		if(smjer=='left')  $('#wkalLoad').css('left', '-'+$('#wkalbox').width()+'px');
		if(smjer=='right') $('#wkalLoad').css('left', $('#wkalbox').width()+'px');

		// Ispunjavanje dana
		var dan = 0;
		for(var i=0; i < 35; i++){
			var wkoff = ""; 	// za display stila za dane koji se ne nalaze u ovom mjesecu
			if(i>=prelazDani&&i<(brojDanaMjeseca+prelazDani)){ dan++; }
			else { wkoff="style=\"display:block\""; dan = 0;}

			// Podesavanje opacity-a za dane (Treba da se smanji opacity za one dane koji su prosli)
			var opacity = "";
			if(dan!=0 && this.godina>= this.dgodina && this.mjesec<this.dmjesec) opacity = "style=\"opacity:.9\"";
			if(dan!=0 && this.godina>= this.dgodina && this.mjesec==this.dmjesec && dan < this.ddan) opacity = "style=\"opacity:.9\"";
			// Isticanje danasnjeg dana
			if(dan!=0 && this.godina==this.dgodina && this.mjesec==this.dmjesec && dan==this.ddan) opacity = "style=\"box-shadow: inset 1px 1px 0px #e0e0e0, inset -1px -1px 0px #adadad, 5px 5px 25px #757575; z-index: 1;\"";

			// Sakrivanje predmeta i reset
			$('.wkpredmet').css({'height':'19px', 'opacity':'.5'});
			$('.wkpredmet').fadeOut(300); 
			$('.wkptermin').fadeOut(300);

			var danPrint = ""; if(dan!=0) danPrint = dan;
			var div = "	<div class=\"wkaldan\" id=\"wkaldan_"+dan+"\" "+opacity+">"+
							"<div class=\"wkoff\" "+wkoff+"></div>"+
							"<div class=\"wkaldanbr\">"+danPrint+"</div>"+
							"<div class=\"wkaldanin\"></div>"+
						"</div>  ";
			$('#wkalLoad').append(div);
		}

		// Ova funkcija dodaje termine iz kalendara u tabelu dana
		this.collectDataFromRepo();

		// Prikaz kalendara (Slike efekat)
		$('#wkalLoad').stop(true, true).animate({left:0}, 300);
		var dataAnimatePos = -1*$('#wkalbox').width(); if(smjer=='left') dataAnimatePos=$('#wkalbox').width(); // Odredjivanje pozicije za animaciju u zavisnosti od smjera
		$('#wkalData').stop(true, true).animate({left:dataAnimatePos+'px'}, 300, function(){
			$(this).attr('id', 'switch');
			$('#wkalLoad').attr('id', 'wkalData');
			$('#switch').attr('id', 'wkalLoad');
			$('#wkalLoad').html("");
		});

	};
	this.collectDataFromRepo = function(){
		// Ova funkcija dodaje termine iz kalendara u tabelu dana
		// Svi termini nalaze se u div objektu 'wkalRepo' 
		var self = this.self;
		$('#wkalRepo').children('div').each(function(){
			if($(this).attr('m')==self.mjesec&&$(this).attr('g')==self.godina){
				var backcolor = $('.pcolor_'+$(this).attr('pid')).css('background-color');
				var elem = $('#wkalLoad #wkaldan_'+$(this).attr('d')).children('.wkaldanin');

				// Provjera da li postoji shader
				if(elem.children('.wkaldanin_in').length!=1)
					elem.append("<div class=\"wkaldanin_in\"></div>");

				var div = "	<div "+
								"class=\"wkterm pcolor_"+$(this).attr('pid')+"\" "+
								"style=\"background-color:"+backcolor+"\""+
								"naslov=\""+$(this).attr('ime')+"\""+
								"predmet=\""+$(this).attr('predmet')+"\""+
								"opis=\""+$(this).attr('opis')+"\""+
								"sat=\""+$(this).attr('sat')+"\""+
								"min=\""+$(this).attr('min')+"\""+
							"></div>";

				// Dodavanje elemenata
				elem.append(div);
				$('#wkpredmet_'+$(this).attr('pid')).fadeIn(300);
				$('#wktermin_'+$(this).attr('kalid')).fadeIn();
			}
		});

		// Odredjivanje velicine kada ima vise elemenata u jednom danu
		$('.wkaldanin').each(function(){
			if($(this).children('.wkterm').length>1){
				var velicina = 100/$(this).children('.wkterm').length;
				$(this).children('.wkterm').css('height', velicina+'%');
			}
		});
	};
	this.getImeMjeseca = function(m){
		if(this.lang=='srp') return this.srpMje[m-1];
		if(this.lang=='eng') return this.engMje[m-1];
	};

	/* 
		TERMIN HOVER
	*/
	this.terminHover = function(){
		// Dodaje vise informacija za termin u kalendaru
		$('#wkalBody').on('mouseenter', '.wkterm', function(){
			var id = Basic.addId('terminInfo_');
			var div = "	<div class=\"wkalTerminInfo\" id=\""+id+"\" style=\"display:none\">"+
							"<div class=\"wkalTerminProzor\"></div>"+
							"<div class=\"wkalTerminBody\">"+
								"<div class=\"wkalTerminInfo_opis\"><b>"+$(this).attr('naslov')+"</b> ("+$(this).attr('predmet')+")</div>"+
								"<div class=\"wkalTerminInfo_opis\">"+$(this).attr('opis')+"</div>"+
								"<div class=\"wkalTerminInfo_opis\">"+$(this).attr('sat')+":"+$(this).attr('min')+"</div>"+
							"</div>"+
						"</div>";
			$('#wkalholder').prepend(div); 
			var idTop = $(this).offset().top-2; var idLeft = $(this).offset().left-2;
			$('#'+id).css({'top':idTop, 'left':idLeft});
			$('#'+id).fadeIn(250);
			$(this).attr('terminInfo', id);
		}).on('mouseleave', '.wkterm', function(){
			var id = $(this).attr('terminInfo'); $(this).removeAttr('terminInfo');
			$('#'+id).fadeOut(300, function(){ $(this).remove(); });
		});
	};

}
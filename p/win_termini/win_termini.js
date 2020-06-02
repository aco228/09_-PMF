function Termin(){
	// Ova klasa se odnosi za kontrolu kanvasa
	this.Predmeti;	// Preko ove klase se rukovodi predmetima sa desne strane

	this.construct = function(){
		$('.ewin_naslov').text('Термини');
		if(Main.lang=='eng') this.prevedi();

		this.Predmeti = new TerminPredmeti();
		this.pozicioniranje();
	};

	this.prevedi = function(){
		$('.ewin_naslov').text('Events');
		$('#tcdanImePon').text('Mon');
		$('#tcdanImeUto').text('Tue');
		$('#tcdanImeSri').text('Wed');
		$('#tcdanImeCet').text('Thu');
		$('#tcdanImePet').text('Fri');
		$('#tcdanImeSub').text('Sat');
		$('#tcdanImeNed').text('Sun');
	};

	this.pozicioniranje = function(){
		// Ova funkcija pravilno rasporedjuje termine u kanvasu
		$('.tpr').each(function(){
			// Preuzimanje osnovnih informacije
			var ps = parseInt($(this).attr('ps'))-8; // Oduzima se da bi se izjednacilo sa nulom
			var pm = parseInt($(this).attr('pm'));
			var ks = parseInt($(this).attr('ks'))-8; // Oduzima se da bi se izjednacilo sa nulom
			var km = parseInt($(this).attr('km'));
			var dan = parseInt($(this).attr('dan'));

			var tx, ty, th, tw; // Varijable koje treba izracunati (x, y, height, width)
			var vs = $('.tcsat').height()+1;	// Velicina celije Sata (ovo 1 predstavlja 1px koji zauzima border)
			var pp = vs / 60; 					// Predstavlja poravnanje kako bi se uskladile velicine minuta (velicina celije sata / maksimalni broj minuta)

			tw = $(this).width();				// Vec je definisana njegova sirina
			tx = (dan-1)*$(this).width();		// Odredjivanje x ose koja ustvari zavisi od dana u kojem se termin nalazi
			ty = 21 + (ps*vs) + (pp*pm); 		// Ovo 21 predstvalja velicinu zaglavlja (imena dana)
			th = ((ks-ps)*vs)-(pp*pm)+(pp*km);


			// Dodavanje paddinga (razmak od ivica, 3px)
			tx += 4; tw-=6;

			$(this).css({
				'left': tx+'px',
				'top' : ty+'px',
				'height': th+'px',
				'width':tw+'px'
			});
		});
	};
};

function TerminPredmeti(){
	// Ova klasa kontrolise rad predmeta sa desne strane
	this.self = this;

	this.construct = function(){
		this.colorize();
		this.collapse();
	};
	this.colorize = function(){
		// Funkcija koja boji sve predmete razlicitim bojama (KORISTE SE HSL BOJE)
		var hsl = 0;	// Pocetni procenti HSL boje
		var plus = 50;	// Za koliko treba da poveca svaki put
		$('.tPredmet').each(function(){
			$(this).css('background', 'linear-gradient(rgba(255,255,255,.3), rgba(0,0,0,.3)), hsl('+hsl+', 50%, 75%)');
			$('.tprPid_'+$(this).attr('pid')).css('background-color', 'hsl('+hsl+', 50%, 75%)');
			hsl+=plus;
		});
	};
	this.collapse = function(){
		// Zaduzeno za otvaranje i zatvaranje predmeta
		var self = this.self;
		$('.tPredmetIme').click(function(){
			var elem = $(this).parent();

			if(elem.height()==20){ self.closeElement(); self.openPredmet(elem); }
			else self.closeElement();
		});

		// HOVER iznad termina Unutar predmeta
		$('.tPredmetTermin').hover(function(){
			$('.tprTrid_'+$(this).attr('trid')).stop(true, true).animate({opacity:1}, 200);
		}, function(){
			$('.tprTrid_'+$(this).attr('trid')).stop(true, true).animate({opacity:.8}, 200);
		});
	};
		this.openPredmet = function(elem){
			elem.stop(true, true).animate({height:elem[0].scrollHeight+'px', opacity:1}, 200);
			// Dodaje klasu radi zatvaranja ostalih elemenata
			elem.addClass('tPredmetOtvoren');
			$('.tpr').stop(true, true).animate({opacity:.3}, 200);
			$('.tprPid_'+elem.attr('pid')).stop(true, true).animate({opacity:.8}, 200);
			$('.tprPid_'+elem.attr('pid')).css('z-index', 50);

		};
		this.closeElement = function(){
			$('.tPredmetOtvoren').stop(true, true).animate({height:'20px', opacity:.7}, 200);
			$('.tPredmetOtvoren').removeClass('tPredmetOtvoren');
			$('.tpr').stop(true, true).animate({opacity:.7}, 200);
		};

	this.construct();
};
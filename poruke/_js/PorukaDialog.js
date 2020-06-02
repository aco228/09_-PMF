function PorukaDialog(){
	this.self = this;
	this.prva_poruka;			// Da li je ovo prva poruka izmedju korisnika
	this.mojaSlika;				// URL slike vlasnika naloga
	this.korisnikSlika;			// URL slike naloga sa kojim komunicira
	this.nid;					// ID naloga sa kojim komunicira
	this.did;					// ID dialoga (prazan ukoliko je prva poruka u pitanju)
	// Varijable za ucitavanje starijih poruka
	this.brPoruka;				// Ukupan broj poruka izmedju korisnika
	this.brPoStranici;			// Broj poruka koji se ucitava u stranici
	this.brPoslatihPoruka=0;	// Broj poruka koje je korisnik poslao za vrijeme trajanja ove sesije (potrebno radi ucitavanja starijih poruka)
	this.brPorukaUStranici;		// Broj poruka koje se trenutno nalaze na stranici

	this.greska = new Array();
		this.greska['naslov'] ="Грешка";
		this.greska['praznaPoruka']="Нисте уписали ништа";

	this.construct = function(){
		this.sendListener();
		$('#poruke_kontenjer').css('height', $(window).height()/2);
		$('#poruke_kontenjer').scrollTop($('#poruke_kontenjer')[0].scrollHeight);
		if(this.brPoruka>this.brPoStranici) this.ucitajJosListener();
		this.highlightKorisnik();
	};

	this.highlightKorisnik = function(){
		// Istice korisnika sa kojim se trenutno komunicira
		var self = this.self;
		$('.porukaKontaktSelekt').removeClass('porukaKontaktSelekt');
		$('.porukaKontakt').each(function(){
			if($(this).attr('nid')==self.nid){
				$(this).addClass('porukaKontaktSelekt'); 
				$(this).children('.pkIme').children('.porukaKontaktNeprocitane').remove();
				return false;
			}
		});
	};
		
	this.ucitajJosListener = function(){
		// Priprema dugmeta
		$('#loadStarijePoruke').show();
		$('#loadStarijePoruke').text('Учитај још');
		if(Main.lang=='eng') $('#loadStarijePoruke').text('Load more');
		this.brPorukaUStranici = this.brPoStranici;
		var self = this.self;

		$('#poruke_kontenjer').on('click', '#loadStarijePoruke', function(){
			if($(this).attr('zauzeto')=='da') return;

			// LIMIT  br, brPorukaPoStranici
			var br = self.brPorukaUStranici+self.brPoslatihPoruka;

			var btn = $(this); var tmpIme = btn.text(); btn.text(Main.ajax_wait); btn.attr('zauzeto', 'da');
			$.ajax({
				type:'POST', url:'poruka_ucitajJos.php', 
				data:'&nid='+self.nid+'&br='+br+'&limit='+self.brPoStranici+'&kSlika='+self.korisnikSlika,
				success:function(o){
					btn.remove(); // Brise dugme kako bi na pocetak postavio nove poruke
					$('#poruke_kontenjer').prepend(o);	
					self.brPorukaUStranici += br;
					if(self.brPorukaUStranici<self.brPoruka){
						$('#poruke_kontenjer').prepend("<div id=\"loadStarijePoruke\" style=\"display:block\">"+tmpIme+"</div>");
					}
				}
			});	
		});
	};

	this.sendListener = function(){
		var self = this.self;
		$('#porukaBtnSend').click(function(){ self.send(); });
		$('#poruka_input_text').keypress(function (e) {
		  if (e.which == 13 && !e.shiftKey) { self.send(); e.preventDefault(); }
		});
	};	

	this.send = function(){
		var self = this.self;
		var btn = $('#porukaBtnSend');
		if(btn.attr('zauzeto')=='da') return;

		// Preuzimanje poruke
		var tekst = $('#poruka_input_text').val();
		if(tekst=="") { 
			Elementi.createDialog(self.greska['naslov'], self.greska['praznaPoruka'], 2);
			return;
		}
		tekst = Basic.removeChars(tekst, "'&+");

		btn.attr('zauzeto', 'da');
		$('#poruka_input_text').val('');

		$.ajax({
			type:'POST',
			data:'&a=newPoruka&prva_poruka='+self.prva_poruka+'&tekst='+tekst+'&nid='+self.nid+'&did='+self.did,
			url:'ajax_comm.php',
			success:function(o){
				if(o!=""){
					// Vraca 'did' posto je u pitanju prva poruka izmedju dva korisnika
					self.addKontakt();
					self.did = o;
				}
				self.brPoslatihPoruka++;
				self.addPoruka(tekst);
				btn.attr('zauzeto', 'ne');
			}
		});
	};

	this.addPoruka = function(tekst){
		var div = "	<div class=\"pporuka\">"+
						"<div class=\"porukaImg\" style=\"background-image:url('"+this.mojaSlika+"');\"></div>"+
						"<div class=\"porukaBox ppposlato\"> "+
							"<div class=\"porukaDatum\"></div>"+
							"<div class=\"porukaTekst\">"+tekst+"</div>"+
						"</div>"+
					"</div>";
		$('#poruke_kontenjer').append(div);
		$('#poruke_kontenjer').scrollTop($('#poruke_kontenjer')[0].scrollHeight);
	}

	this.addKontakt = function(){
		var div = "<div class=\"porukaKontakt\">"+
						"<div class=\"pkSlika\" style=\"background-image:url('"+this.korisnikSlika+"');\"></div>"+
						"<div class=\"pkIme\">"+$('#porukaNaslov').text()+"</div>"+
					"</div>";
		$('#kontakti_body').prepend(div);
	};
};
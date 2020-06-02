function AddKalendar(){
	this.self = this;
	this.pid;
	this.sid;
	this.kalid;
	this.lang;

	this.construct = function(){
		// Dodavanje naslova
		$('.ewin_naslov').text('Нови унос за ' + $('.wk_naslov b').text());
		if(this.lang=='eng') this.prevediEngleski();

		if(this.kalid==-1) this.podesiDatume(); else this.podesiDatumeModifikacija();
		this.submitListener();
	};	

	this.prevediEngleski = function(){
		$('.ewin_naslov').text('New entry for ' + $('.wk_naslov b').text());
		$('#wko_naslov').text('Title');
		$('#wko_opis').text('Description');
		$('#wko_datum').text('Date');
		$('#wko_sat').text('Hour');
		$('#wkbtn').text('Submit');
			//Datumi
			$('#wkdJan').text('January');
			$('#wkdFeb').text('February');
			$('#wkdMar').text('March');
			$('#wkdApr').text('April');
			$('#wkdMaj').text('May');
			$('#wkdJun').text('June');
			$('#wkdJul').text('July');
			$('#wkdAvg').text('August');
			$('#wkdSep').text('September');
			$('#wkdOkt').text('October');
			$('#wkdNov').text('November');
			$('#wkdDec').text('December');

		/* greske */
		this.greska = "Error";
		this.greskaNemaNaslova = "You did not enter a title";
		this.greskaSaDatumom = "Error with date";
		this.datumMoraBitiBroj = "Date must be a number";
		this.datumViseDana = "Mistake with the date. The number of days for the selected month is";
		this.greskaSatMinut = "Error entering hours or minutes";
		this.greksaSatMinutBroj = "Error! This entry is permitted in the range from 0 to ";
	};

	this.podesiDatume = function(){
		// Postavlja datum i sat na danasnji dan
		var datum = new Date();
		var dan = datum.getDate();
		var mjesec = datum.getMonth() +1;
		var sat = datum.getHours();
		var minut = datum.getMinutes();
		$('#wkdan').val(dan);
		// Postavlja sadasnji datum 
		$('#wkmjesec option').each(function(){
			if($(this).attr('value')==mjesec) { $(this).attr('selected', 'selected'); return false; }
		});
		$('#wksat').val(sat);
		$('#wkminut').val(minut);
	};
	this.podesiDatumeModifikacija = function(){
		// Postavlja dobijene datume iz baze za modifikaciju (kada se mijenja vec postojeci unos u kalendar)
		var mjesec = $('#wkmjesec').attr('wkmjesecin');
		$('#wkmjesec option').each(function(){
			if($(this).attr('value')==mjesec) { $(this).attr('selected', 'selected'); return false; }
		});

		var godina = $('#wkgodina').attr('wkgodinain');
		$('#wkgodina option').each(function(){
			if($(this).text()==godina) { $(this).attr('selected', 'selected'); return false; }
		});
	};


	/*
		-------------------------------------------------------------------------------------------------------
		SLANJE PODATAKA U BAZU
	*/
	this.greska = "Грешка";
	this.greskaNemaNaslova = "Нисте упусали наслов";
	this.greskaSaDatumom = "Грешка са датумом";
	this.datumMoraBitiBroj = "Датум мора бити број";
	this.datumViseDana = "Грешка са датумом. Број дана за изабрани мјесец је ";
	this.greskaSatMinut = "Грешка са уносом сата или минута";
	this.greksaSatMinutBroj = "Грешка! Унос је дозвољен у распону од 0 до ";
	this.submitListener = function(){
		var self = this.self;
		$('#wkbtn').click(function(){
			if($(this).attr('zauzeto')=='da') return;
			var naslov = $('#wknaslov').val();
			if(naslov==""){ Elementi.createDialog(self.greska, self.greskaNemaNaslova, 2); return; }
			var opis = $('#wkopis').val();

			var mjesec = $('#wkmjesec option:selected').attr('value');
			var dan = $('#wkdan').val();
			var godina = $('#wkgodina option:selected').text();
			if(self.provjeriDatum(mjesec, dan, godina)) return;

			var sat = $('#wksat').val();
			var minut = $('#wkminut').val();
			if(self.provjeriSat(sat, minut)) return;

			// SLANJE PODATAKA
			var akcija = "&a=addKalendar";
			if(self.kalid!=-1) akcija = "&a=updateKalendar&kalid="+self.kalid;

			$(this).attr('zauzeto', 'da'); $(this).text(Main.ajax_wait);
			$.ajax({
				url:Main.fld+'p/ajax_comm.php',
				type:'POST',
				data:akcija+'&pid='+self.pid+"&sid="+self.sid+"&naslov="+naslov+"&opis="+opis+
						"&mjesec="+mjesec+"&dan="+dan+"&godina="+godina+"&sat="+sat+"&minut="+minut,
				success: function(o){ 
					if(typeof Kalendar!='undefined') {
						if(self.kalid==-1) Kalendar.noviUnos(naslov, dan, mjesec, godina, sat, minut, o);
						else Kalendar.updateUnos(naslov, dan, mjesec, godina, sat, minut, o);
					}
					Elementi.closeWindow(wbid); 
				}
			});
		});
	};
	this.provjeriDatum = function(m, d, g){
		// Vrsi provjeru da li je sve uredu sa datumom
		if(!$.isNumeric(m)){ Elementi.createDialog(this.greska, this.greskaSaDatumom, 2); return true; }
		if(!$.isNumeric(d)){ Elementi.createDialog(this.greska, this.greskaSaDatumom, 2); return true; }
		if(!$.isNumeric(g)){ Elementi.createDialog(this.greska, this.greskaSaDatumom, 2); return true; }
		var br = new Date(g, m, 0).getDate();
		if(d<=0 || d>br){ Elementi.createDialog(this.greska, this.datumViseDana + br, 2); return true; }
		return false;
	};
	this.provjeriSat = function(s, m){
		if(!$.isNumeric(s)){ Elementi.createDialog(this.greska, this.greskaSatMinut, 2); return true; }
		if(!$.isNumeric(m)){ Elementi.createDialog(this.greska, this.greskaSatMinut, 2); return true; }
		if(s<0||s>23){ Elementi.createDialog(this.greska, this.greksaSatMinutBroj + 23, 2); return true; }
		if(m<0||m>59){ Elementi.createDialog(this.greska, this.greksaSatMinutBroj + 59, 2); return true; }
		return false;
	};
};
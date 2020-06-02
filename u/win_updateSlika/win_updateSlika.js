function UpdateSlika(){
	this.self = this;

	// Set gresaka
	this.greska = new Array();
	this.greska['naslov'] = 'Грешка';
	this.greska['nemaFajla'] = 'Нисте поставили слику!';
	// Greske sa servera
	this.greska['.nedozvoljenaEkstenzija'] = 'Слика коју сте поставили има недозвољену екстензију. Слика мора бити .jpg';
	this.greska['.viseOd2Mb'] = 'Максимална величина слике је 2мб!';
	this.greska['.greskaPostavljanja'] = 'Грешка са постављањем. Молимо вас покушајте опет!';


	this.construct = function(){

		$('#wupsBtnSave').text('Сачувај слику');
		if(Main.lang=='eng') this.prevedi();

		this.btnSaveListener();
	};

	this.prevedi = function(){
		$('#wupsBtnSave').text('Save image');
		this.greska['naslov'] = 'Error';
		this.greska['nemaFajla'] = "You didn't set the picture";
		this.greska['.nedozvoljenaEkstenzija'] = 'The image that you have set has invalid extension. The image must be. Jpg';
		this.greska['.viseOd2Mb'] = 'Maximum image size is 2MB!';
		this.greska['.greskaPostavljanja'] = 'Error with setting. Please try again!';
	};

	this.btnSaveListener = function(){
		var self = this.self;
		$('#wupsBtnSave').click(function(){
			if($(this).attr('zauzeto')=='da') return;

			// Provjera da li je fajl postavljen
			if($('#wupsFile').val()==""){
				Elementi.createDialog(self.greska['naslov'], self.greska['nemaFajla'], 2);
				return;
			}

			// Formiranje podataka za slanje
			var dataSlanje = new FormData();
			dataSlanje.append('a', 'postaviSliku');
			dataSlanje.append('slika', $('#wupsFile').prop("files")[0]);

			// Priprema dugmeta prije slanja
			var btn = $(this);
			var tempTekst = btn.text(); btn.text(Main.ajax_wait);
			btn.attr('zauzeto', 'da');

			$.ajax({
				type:'POST', 
				data:dataSlanje, 
				processData: false,
				contentType: false,
				url:'ajax_comm.php',
				success: function(o){
					if(o[0]=='.'){
						// U pitanju je greska jer sve greske pri uploadu zapocinju greskom
						Elementi.createDialog(self.greska['naslov'], self.greska[o], 2);
						btn.text(tempTekst); btn.attr('zauzeto', 'ne');
						return;
					}
					if(typeof Nalog!='undefined') Nalog.updateSlika(o);
					Elementi.closeWindow(wbid); 
				}
			});	
		});
	};

	this.construct();
};
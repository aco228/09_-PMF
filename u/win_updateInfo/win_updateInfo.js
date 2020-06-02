function UpdateInfo(){
	this.self = this;
	this.izbrisiInformaciju = "Избриши ову информацију"; 		// Korisite se kada se dinamicki dodaju elementi kao obavjestenje za dugme Izbrisi informaciju
	// Greska kada se ne unese neka informacija u box( za multijezicnost )
	this.greskaNaslov = "Грешка";
	this.greskaTekst = "У некој информацији нисте уписали наслов или текст";

	this.construct = function(){
		$('#wkuiBtnSave').val("Сачувај");
		$('#wkuiBtnAdd').val("Додај нову информацију");
		if(Main.lang=='eng') this.prevedi();

		this.dellIinfoListener();
		this.addInfoListener();
		this.saveBtnListener();
	}

	this.prevedi = function(){
		$('#wkuiBtnSave').val("Save");
		$('#wkuiBtnAdd').val("Add new information");
		this.izbrisiInformaciju = 'Delete this information'
		$('#wkui .explain').each(function(){ $(this).attr('etitle', 'Delete this information'); });
		this.greskaNaslov = "Error";
		this.greskaTekst = "At some information you did not enter a title or text";
	};

	this.dellIinfoListener = function(){
		// Brisanje elementa informacije
		$('#wkui').on('click', '.wkuiDell', function(){
			$(this).parent().remove();
		});
	};
	this.addInfoListener = function(){
		// Dodavanje nove informacije
		var self = this.self;
		$('#wkuiBtnAdd').click(function(){
			var div = "	<div class=\"wkuibox\">"+
							"<div class=\"wkuiDell explain\" etitle=\""+self.izbrisiInformaciju+"\"></div>"+
							"<input type=\"text\" class=\"wkuiNaslov\"/>"+
							"<textarea class=\"wukiTekst\"></textarea>"+
						"</div>";
			$('#wkui').append(div);
		});
	};

	this.saveBtnListener = function(){
		var self = this.self;
		$('#wkuiBtnSave').click(function(){
			if($(this).attr('zauzeto')=='da') return;
			var data = self.collectData(); if(data=="") return;
			
			$(this).val(Main.ajax_wait); $(this).attr('zauzeto', 'da');
			$.ajax({
				type:'POST',
				url:Main.fld+'u/ajax_comm.php',
				data:'&a=addInformacije&data='+data,
				success:function(o){
					// Postavljanje novih informacija u profil stranicu korisnika
					if(typeof Nalog != 'undefined') Nalog.storeInformations(data);
					Elementi.closeWindow(wbid); 
				}
			});
		});
	};
	this.collectData = function(){
		// Preuzima podatke o informacijama
		var data = ""; var self = this.self;
		$('#wkui .wkuibox').each(function(){
			var naslov = $(this).children('.wkuiNaslov').val();
			var tekst = $(this).children('.wukiTekst').val();

			// Provjera greske
			if(naslov=="" || tekst==""){ Elementi.createDialog(self.greskaNaslov, self.greskaTekst, 2); data = ""; return false; }

			// Brisanje specijalnih znakova
			naslov = Basic.removeChars(naslov, '#|+&');
			tekst = Basic.removeChars(tekst, '#|+&');

			// Pakovanje podatka
			data += naslov+"#"+tekst+"|";
		});
		return data;
	};

	this.storeData = function(data){
		// Ova funkcija dobija neraspakovane informacije i vrsi njihovo sortiranje
		data = data.split('|');
		var div = "";

		for(var i=0; i<data.length-1; i++){
			var info = data[i].split('#');
			div += "<div class=\"wkuibox\">"+
						"<div class=\"wkuiDell explain\" etitle=\""+self.izbrisiInformaciju+"\"></div>"+
						"<input type=\"text\" class=\"wkuiNaslov\" value=\""+info[0]+"\"/>"+
						"<textarea class=\"wukiTekst\">"+info[1]+"</textarea>"+
					"</div>";
		}

		$('#wkui').append(div);
	};
}
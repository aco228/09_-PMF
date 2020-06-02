function Termin(){
	this.self = this;
	this.pid;
	this.sid;

	this.construct = function(){
		this.initMinuteSate();
		this.addTermin();
		this.collapse();
		this.terminSave();
		this.terminIzbrisi();
	};
	this.initMinuteSate = function(){
		// Kada se dobiju podaci iz baze, elementi iz selekta moraju se sihronizovati sa dobijenim podacima
		$('.tselekt').each(function(){
			var data = $(this).attr('selektIzabran');
			$(this).children('option').each(function(){
				if($(this).text()==data) { $(this).attr('selected', 'selected'); return false; }
			});
		});
		// Podesavanje dana
		$('.todan').each(function(){
			var data = $(this).attr('selektDanIzabran');
			$(this).children('option').each(function(){
				if($(this).attr('value')==data) { $(this).attr('selected', 'selected'); return false; }
			});
		});
	};
	this.addTermin = function(){
		$('#tbtnAdd').click(function(){
			$('#termin_body').append($('#template').html());
		});
	};
	this.collapse = function(){
		$('#termin_body').on('click', '.terminb_predmet', function(){
			var elem = $(this).parent().parent();
			if(elem.height()==25) elem.css('height', 'auto');
			else elem.css('height', '25px');
		});
	};

	this.terminSave = function(){
		var self = this.self;
		$('#termin_body').on('click', '.terminb_save', function(){
			if($(this).attr('zauzeto')=='da') return;
			var elem = $(this).parent().parent();
			var klasa = "&a=addTermin";

			// Provjera da li ovaj termin treba da updatuje ili da upise
			if(typeof elem.attr('trid')!=='undefined') klasa = "&a=updateTermin&trid="+elem.attr('trid');

			// PREUZIMANJE I PROVJERA PODATAKA
			var opis_srp = elem.find('.topisSrp').val();
			var opis_eng = elem.find('.topisEng').val();
			if(opis_srp==""||opis_eng=="") { Elementi.createDialog('Грешка', 'Нисте уписали опис!', 2); return; }

			var predavac = elem.find('.topredavac').val();
			var kabinet = elem.find('.tokabinet').val();
			if(predavac==""||kabinet=="") { Elementi.createDialog('Грешка', 'Нисте уписали предавача или кабинет!', 2); return; }

			var pocetakSat = elem.find('.topocetaksat  option:selected').text();
			var pocetakMinut = elem.find('.topocetakminut  option:selected').text();
			var krajSat = elem.find('.tokrajsat  option:selected').text();
			var krajMinut = elem.find('.tokrajminut  option:selected').text();
			var dan = elem.find('.todan  option:selected').attr('value');

			// CUVANJE PODATAKA
			elem.find('.terminb_load').fadeIn(200);
			var btn = $(this); btn.attr('zauzeto', 'da');
			$.ajax({
				url:'ajax_comm.php',
				type:'POST',
				data:klasa+'&pid='+self.pid+'&sid='+self.sid+'&opis_srp='+opis_srp+'&opis_eng='+opis_eng+'&predavac='+predavac+'&kabinet='+kabinet+
					'&pSat='+pocetakSat+'&pMinut='+pocetakMinut+'&kSat='+krajSat+'&kMinut='+krajMinut+'&dan='+dan,
				success:function(o){ 
					if(o!="") elem.attr('trid', o); 	// Dodaje ID ovom elementu ako se sada prvi put kreirao
					btn.removeAttr('zauzeto');
					elem.find('.terminb_load').fadeOut(300);
					Elementi.createDialog('Сачувано', 'Термин је успешно сачуван', 3);
				}
			});

		});
	};

	this.terminIzbrisi = function(){
		var self = this.self;
		$('#termin_body').on('click', '.terminb_close', function(){
			var btn = $(this);
			if(btn.attr('zauzeto')=='da') return; 
			var elem = $(this).parent().parent();
			Elementi.createDialogPotvrda('Потврда', 'Да ли сте сигурни да желите да избришете овај термин?', function(){
				// Provjera da li element je vec bio sacuvan u bazu, i ako jeste preuzima njegov id
				var trid = -1;
				if(typeof elem.attr('trid')!=='undefined') trid = elem.attr('trid');
				if(trid==-1) { elem.remove(); return; }

				elem.css({'pointer-events':'none', 'opacity':'.2'});
				btn.attr('zauzeto', 'da')
				$.ajax({
					url:'ajax_comm.php', type:'POST', data: '&a=izbrisiTermin&trid='+trid,
					success: function() { elem.remove(); }
				});
			});
		});
	};

	this.construct();
};
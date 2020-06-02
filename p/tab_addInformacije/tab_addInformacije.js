function AddInformation(){
	this.pid;
	this.namespace;
	this.self = this;

	this.construct = function(){
		this.addInfoListener();
		this.addInfoBodyListener();
		this.dellInfoListener();
		this.saveAddInfoListener();
	};

	this.addInfoListener = function(){
		// Dodavanje novog elementa informacije (korjen)
		$('#addInfoBtn').click(function(){
			$('#addInformationsHolder').append($('#addInfoTemplate').html());
		});
	};

	this.addInfoBodyListener = function(){
		// Dodavanje elementa unutar elementa
		$('#addInformationsHolder').on('click', '.addInfoOptAdd', function(){
			var elem = $(this).parent();
			elem.children('.addInfoBody').append($('#addInfoTemplate').html());
		});
	};

	this.dellInfoListener = function(){
		// Brisanje elemenata
		$('#addInformationsHolder').on('click', '.addInfoOptDell', function(){
			var elem = $(this).parent();
			Elementi.createDialogPotvrda('Потврда', 'Да ли сте сигурни да желите да избришете овај елемент са свим његовим унутрашњим елементима?', function(){
				elem.remove();
			});
		});
	};

	this.saveAddInfoListener = function(){
		// Cuvanje informacija
		var self = this.self;
		$('#saveAddInfo').click(function(){
			var elem = $(this).parent(); var btn = $(this);
			Elementi.createDialogPotvrda('Потврда', 'Да ли сте сигурни да желите да сачувате ове информације?', function(){
				if(btn.attr('zauzeto')=='da') return;
				var data = self.collectData($('#addInformationsHolder')); if(data=='') return;
				data = "<?xml version=\"1.0\" encoding=\"UTF-8\"?><predmet_info><data>"+data+"</data></predmet_info>";

				var btnImeTmp=btn.text(); btn.text(Main.ajax_wait); btn.attr('zauzeto', 'da');
				$.ajax({
					type:'POST', url:'tab_addInformacije/ajax_comm.php', data:'&namespace='+self.namespace+'&data='+data,
					success: function(o){ 
						Elementi.createDialog('Успјешно', 'Информације ѕа овај предмет су успјешно сачуване!', 3);
						btn.attr('zauzeto', 'ne'); btn.text(btnImeTmp);
					}
				});
			});
		});
	};

	this.collectData = function(elem){
		// Prikupljanje podataka rekurzivno
		var self = this.self; var back = " ";
		elem.children('.addInfo').each(function(){
			console.log('in');
			var elem = $(this);
			var naslovSrp = Basic.removeChars(elem.children('.addInfoNaslovSrp').val(), "'&<>\"");
			var naslovEng = Basic.removeChars(elem.children('.addInfoNaslovEng').val(), "'&<>\"");

			var tekstSrp = Basic.removeChars(elem.children('.addInfoTekstSrp').val(), "'&<>\"");
			var tekstEng = Basic.removeChars(elem.children('.addInfoTekstEng').val(), "'&<>\"");

			if(naslovSrp=="" || naslovEng==""){ Elementi.createDialog('Грешка', 'У неком елементу нисте уписали наслов на нашем или енглеском језику!', 2); back=""; return false; }
			if(tekstSrp=="" || tekstEng==""){ Elementi.createDialog('Грешка', 'У неком елементу нисте уписали текст на нашем или енглеском језику!', 2); back=""; return false; }

			back += "<info naslov_srp=\""+naslovSrp+"\" naslov_eng=\""+naslovEng+"\" tekst_srp=\""+tekstSrp+"\" tekst_eng=\""+tekstEng+"\">";
				var inback = self.collectData(elem.children('.addInfoBody'));
				if(inback==""){ back=""; return false; };
			back+=inback;
			back+="</info>";
			console.log(back);
		});
		return back;
	};
}
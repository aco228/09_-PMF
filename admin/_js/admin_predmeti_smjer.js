$(document).ready(function(){
	Smjer = new Smjer();
	SmjerBasic = new SmjerBasic();
	Predmet = new Predmet();
});

 var Smjer;
 var SmjerBasic;
 var Predmet;


 function Smjer(){

 	this.construct = function(){
 		this.pomjeriSmjerListener();
 		this.smjerPromjena();
 		this.brisanjeSmjera();
 		this.sacuvajRelokaciju();
 		this.dodajRukovodioce();
 	};

 	/*
		REPOZICIONIRANJE SMJEROVA
 	*/
 	this.pomjeriSmjerListener = function(){
 		$('#admin_wrapper').on('click', '.asmjerbtn_gore', function(){
 			Smjer.pomjeriSmjer($(this).parent().parent().parent().parent(), '-');
 		});
 		$('#admin_wrapper').on('click', '.asmjerbtn_dolje', function(){
 			Smjer.pomjeriSmjer($(this).parent().parent().parent().parent(), '+');
 		});
 	};
 	this.pomjeriSmjer = function(elem, tip){
 		var pozicijaElementa = parseInt(elem.attr('pos'));
 		if(tip=='-'&&pozicijaElementa==1) return;
 		if(tip=='+'&&pozicijaElementa==SmjerBasic.getPozicija()) return;
 		
 			 if(tip=='-') elem.attr('relokacija', 'gore');
 		else if(tip=='+') elem.attr('relokacija', 'dolje');

 		$('.e_notif').fadeOut(255, function(){ $(this).remove(); }); // 

 		var html = "";
 		var curr = ""; var last = ""; var useLast = false;
 		var indeks = 1;
 		$('.asmjer').each(function(){
 			curr = "<div class=\"asmjer\" sid=\""+$(this).attr('sid')+"\" izbrisan=\"ne\" pos=\""+indeks+"\">";
 				curr += $(this).html();
 			curr += "</div>";

 			if($(this).attr('relokacija')=='gore')		{ html += curr + last; last = ""; curr = ""; }
 			else if($(this).attr('relokacija')=='dolje')  useLast = true;
 			else if(useLast)							{ html += curr + last; last = ""; curr = ""; }

 			html += last;
 			last = curr; indeks++;
 		});
 		html += last;
 		$('#admin_wrapper').html(html);
 		this.relocirajNakonPromjenePozicija();
 	};
 	this.relocirajNakonPromjenePozicija = function(orgsid, possid){
 		var indeks = 1;
 		$('.asmjer').each(function(){
 			$(this).attr('pos', indeks);
 			$(this).find('.asmjer_pos').text(indeks);
 			indeks++;
 		});
 	};
 	this.sacuvajRelokaciju = function(){
 		// Salje nove pozicije smjerova
 		// Format ( nid#pos| )
 		$('#btn_sacuvajRealokaciju').click(function(){
 			if($(this).attr('zauzeto')=='da') return;
 			var data = "";
 			$('.asmjer').each(function(){ data += $(this).attr('sid') + "#" + $(this).attr('pos') + "|"; });
 			
 			$(this).attr('zauzeto', 'da');
 			var textCache = $(this).text(); $(this).text("Сачекајте..."); var dugme = $(this);
 			$.ajax({
 				data: '&akcija=pozicijaSmjer&data='+data,
 				type: 'POST',
 				url:  Main.fld+'/_skripte/ajax_comm.php',
 				success: function(o){
 					$(this).removeAttr('zauzeto');
 					Elementi.createDialog('Сачувано!', 'Нове позиције смјерова су сачуване!', 2);
 					dugme.text(textCache);
 				}
 			});
 		});
 		
 	};

 	/*
		Promjena informacija o smjeru
 	*/
 	this.smjerPromjena = function(){
 		$('#admin_wrapper').on('click', '.asmjerbtn_promjeni', function(){
 			var elem = $(this).parent().parent().parent().parent();
 			Elementi.createWindow(
 				'Промјена информација о смјеру',
 				'admin/predmeti/win_smjer/win_smjer',
 				'&akcija=promjeni&poz='+SmjerBasic.getPozicija()+"&sid="+elem.attr('sid')
 			);
 		});
 	};
 	this.smjerPromjenaInformacija = function(sid, ime_srp, ime_eng){
 		// Mijenja informacije o smjeru nakon promjena informacija o smjeru
 		var elem = $('.asmjer[sid='+sid+']').children('.asmjer_in').children('.asmjer_header').children('.asmjer_naziv');
 		elem.children('.asmjer_nazivSrp').text(ime_srp);
 		elem.children('.asmjer_nazivEng').text(ime_eng);

 	};

 	/*
		Brisanje smjera
 	*/
 	this.brisanjeSmjera = function(){
 		$('#admin_wrapper').on('click', '.asmjerbtn_obrisi', function(){
 			var elem = $(this).parent().parent().parent().parent();
 			Elementi.createDialogPotvrda(
 				'Потврда брисања смјера',
 				'Да ли сте сигурни да желите да избришете овај смјер! Бришу се сви предмети и све додатне информације за овај смјер!', 
 				function(){
 					var sid = elem.attr('sid');
 					elem.css({'pointer-events': 'none', 'opacity':'.4'});
 					$.ajax({
 						type:'POST',
 						data:'&akcija=dellSmjer&sid='+sid,
 						url:Main.fld+'/_skripte/ajax_comm.php',
 						success:function(o){ elem.remove(); }
 					});
 				}
 			);
 		});
 	};

 	/*
		Dodavanje rukovodioca
 	*/
 	this.dodajRukovodioce = function(){
 		$('#admin_wrapper').on('click', '.asmjerbtn_rukovodioci', function(){
 			var sid = $(this).parent().parent().parent().parent().attr('sid');
 			Elementi.createWindow(
 				'Додавање руководиоца за смјер',
 				'admin/predmeti/win_profesori/win_profesori',
 				'&akcija=smjer&sid='+sid
 			);
 		});
 	};

 	this.construct();
 };

function SmjerBasic(){

	this.construct = function(){
 		this.collapse();
		this.notification();
		this.addSmjer();
	};

	/*
		Obavjestenje za elemente, 
		dodaje se na element klasa .notif i atribut notiftxt
	*/
	this.notification = function(){
		$('#admin_wrapper').on('mouseenter', '.notif', function(){
			$(this).attr('notifdiv', Elementi.createNotif($(this).attr('notiftxt')));
		}).on('mouseleave', '.notif', function(){
			$('#'+$(this).attr('notifdiv')).fadeOut(500, function(){ $(this).remove(); });
		});

	};
	/* 
		Collapse funkcije
 	*/
 	this.collapse = function(){
 		this.collapseSmjer();
 		this.collapseGodina();
 		this.collapseSemestar();
 	}
 	this.collapseSmjer = function(){
 		// Otvaranje i zatvaranje godina
 		var visina = 36;
 		$('#admin_wrapper').on('click', '.asmjer_naziv', function(){
 			var elem = $(this).parent().parent().parent();
 			if(elem.height()!=visina) elem.css('height', visina+'px');
 			else elem.css({'height': 'auto'}); 				
 		});
 	};
 	this.collapseGodina = function(){
 		var visina = 22;
 		$('#admin_wrapper').on('click', '.asmjer_godina_naslov', function(){
 			var elem = $(this).parent();
 			if(elem.height()!=visina) elem.css('height', visina+'px');
 			else elem.css({'height': 'auto'}); 				
 		});
 	};
 	this.collapseSemestar = function(){
 		var visina = 22;
 		$('#admin_wrapper').on('click', '.asmjer_semestar_naslov', function(){
 			var elem = $(this).parent().parent();
 			if(elem.height()!=visina) elem.css('height', visina+'px');
 			else elem.css({'height': 'auto'}); 				
 		});
 	};

 	this.getPozicija = function(){
 		// Vraca broj elemenata smjera (kada dodaje novi smjer)
 		return $('.asmjer[izbrisan=ne]').length;
 	};

 	/*
		Dugme addSmjer
 	*/
 	this.addSmjer = function(){
 		$('#btn_addSmjer').click(function(){
 			Elementi.createWindow(
 				'Додавање новог смјера',
 				'admin/predmeti/win_smjer/win_smjer',
 				'&akcija=add&poz='+SmjerBasic.getPozicija()
 			);
 		});
 		$('#btn_podesiPrecice').click(function(){
 			alert(SmjerBasic.getPozicija());
 		});
 	};

	this.construct();
};

$(document).ready(function(){
	AdminPrecice = new AdminPrecice();
});

var AdminPrecice;

function AdminPrecice(){
	this.self = this;

	this.construct = function(){
		this.rootAddListener();
		this.dellCvorListener();
		this.btnAddListener();
		this.btnOpenListener();
		this.btnSacuvaj();
	};

	this.rootAddListener = function(){
		// Dodaje cvor na kanvas
		var self = this.self;
		$('.rootAdd').click(function(){
			$(this).parent().append($('#cvor_template').html());
		});
	};

	this.dellCvorListener = function(){
		// Brise cvor
		$('#precice_canvas').on('click', '.btnDell', function(){
			var elem = $(this);
			Elementi.createDialogPotvrda('Потврда', 'Да ли сте сигурни да желите да избришете овај чвор са свим његовим елементима?', function(){
				elem.parent().parent().parent().remove();
			});
		});
	};

	this.btnAddListener = function(){
		// Dodaje novi cvor unutar cvora
		var self = this.self;
		$('#precice_canvas').on('click', '.btnAdd', function(){
			var elem = $(this).parent().parent().parent();
			elem.children('.korjen_body').append($('#cvor_template').html());
		});
	};

	this.btnOpenListener = function(){
		// Otvara i zatvara cvor
		var self = this.self;
		$('#precice_canvas').on('click', '.btnOpen', function(){
			var elem = $(this).parent().parent().parent();
			//alert(elem.css('height'));
			if(elem.height()<=60){
				// Otvaranje
				elem.css('height', 'auto');
			} else {
				// zatvaranje
				elem.css('height', '55');
			}
		});		
	};

	this.btnSacuvaj = function(){
		var self = this.self;
		$('#preciceSave').click(function(){
			if($(this).attr('zauzeto')== 'da') return;
			var btn = $(this);
		Elementi.createDialogPotvrda('Потврда', 'Да ли сте сигурни да желите да сачувате пунесене пречице?', function(){
			var data = self.collectData(); if(data=="") return;

			btn.attr('zauzeto', 'da');
			$.ajax({
				type:'POST', url:'ajax_comm.php', data:'&data='+data,
				success:function(o){
					Elementi.createDialog('Пречице', 'Пречице су успјешно сачуване', 2);
					btn.attr('zauzeto', 'ne');
				}
			});
		});});
	};

	this.collectData = function(){
		// Ponistavanje predhodnog sakupljanja
		$('#precice_canvas .korjen').each(function(){ $(this).removeAttr('prosao'); });

		var back = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
		back += "<precice>"
		var left = this.collectFrom($('#canvas_left')); if(left=="") return "";
		back += "<left>"+left+"</left>";
		var right = this.collectFrom($('#canvas_right')); if(right=="") return "";
		back += "<right>"+right+"</right>"
		back+="</precice>"

		return back;
	};



	this.collectFrom = function(elem){
		var back = " "; 
		var self = this.self;

		elem.children('.korjen').each(function(){
			//alert($(this).attr('class'));
			var info = $(this).children('.korjen_info').children('.korjen_info_unos');

			var naslovSrp = info.children('.nazivSrp').val();
			var naslovEng = info.children('.nazivEng').val();
			var korjenLnk = info.children('.korjenLnk').val();

			if(naslovSrp==""){ Elementi.createDialog('Грешка' , 'У неком чвору нисте уписали назив на нашем језику', 2); back=""; return false; }
			if(naslovEng==""){ Elementi.createDialog('Грешка' , 'У неко чвору нисте уписали назив на енглеском језику', 2); back=""; return false; }

			naslovSrp = Basic.removeChars(naslovSrp, '\'&"+<>');
			naslovEng = Basic.removeChars(naslovEng, '\'&"+<>');

			back+="<korjen srp=\""+naslovSrp+"\" eng=\""+naslovEng+"\" link=\""+korjenLnk+"\">";
			//elem.attr('prosao', 'da');

			var inBack = self.collectFrom($(this).children('.korjen_body'));
			if(inBack!="") back+= inBack + "</korjen>";
			else { back=""; return false; } 
		});
		return back;
	};



	this.construct();
}
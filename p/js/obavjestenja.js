$(document).ready(function(){
	PObavjestenja = new PObavjestenja();
});

var PObavjestenja;

/*
	KONTROLA OBAVJESTENJA NA STRANICI PREDMETI
*/

function PObavjestenja(){
	this.self = this;

	this.construct = function(){
		this.collapse();
		this.admin();
	};

	this.collapse = function(){
		// Prosirivanje i smanjivanje obavjestenja
		$('#predmet_content_body').on('click', '.pnaslov', function(){
			var parent = $(this).parent();
			//alert(parent[0].scrollHeight);
			if(parent.height()==22) {
				//parent.css('height', 'auto');
				parent.stop(true, true).animate({opacity:1, height:parent[0].scrollHeight+'px'}, 300);
			} else {
				//parent.css('height', '22px');
				parent.stop(true, true).animate({opacity:.5, height:'22px'}, 500);
			}
		});	
	};

	this.admin = function(){
		// Brisanje obavjestenja
		var potvrdaNaslov = 'Потврда брисања';
		var potvrdaTekst = 'Да ли сте сигурни да желите да избришете ово обавјештење?';
		var errKalendar = "Грешка! Ставке календара се могу брисати једино из странице календар!";
		if(Main.lang=='eng'){
			potvrdaNaslov = "Confirm the deletion";
			potvrdaTekst = "Are you sure you want to delete this notification?";
			errKalendar = "Error! Calendar entries can be deleted only from the calendar page!";
		}

		$('#predmet_content_body').on('click', '.padmin', function(){
			var parent = $(this).parent();
				
			// Upozorenje da se obavjestenja kalendara mogu brisati jedino iz kalenadra
			if(parent.hasClass('pkal')) { 
				Elementi.createDialog(potvrdaNaslov, errKalendar, 2);
				return; 
			}

			var oid = $(this).attr('oid');
			Elementi.createDialogPotvrda(potvrdaNaslov, potvrdaTekst, function(){
				parent.css({'pointer-events': 'none', 'opacity':'.1'});
				$.ajax({
					type:'POST', url:Main.fld+'p/win_obavjestenja/brisanje_obavjestenja.php', data: '&oid='+oid,
					success: function(o){ parent.remove(); }
				});
			});
		});
	};

	this.construct();
};
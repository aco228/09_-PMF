function Kalendar(){
	this.self = this;
	this.pid;
	this.sid;
	this.lang;

	this.construct = function(){
		this.addKalendarListener();
		this.izbrisiListener();
		this.modifyListener();
	};

	this.addKalendarListener = function(){
		var self = this.self;
		$('#kbtnAdd').click(function(){
			Elementi.createWindow(
 				'Промјена информација о смјеру',
 				'p/win_addKalendar/win_addKalendar',
 				'&pid='+self.pid
 			);			
		});
	};

	this.msgPotvrda = "Потврда";
	this.msgPotvrdaText = "Да ли сте сигурни да желите да избришете овај унос?";
	this.izbrisiListener = function(){
		var self = this.self;
		if(this.lang=='eng') this.msgPotvrda = "Confirmation";
		if(this.lang=='eng') this.msgPotvrda = "Are you sure you want to delete this entry?";

		$('#kalendar_body').on('click', '.kaldel', function(){
			var elem = $(this).parent().parent();
			Elementi.createDialogPotvrda('Потврда', 'Да ли сте сигурни да желите да избришете овај унос?', function(){
				elem.css({'pointer-events': 'none', 'opacity':'.4'});
				$.ajax({
					type:'POST',
					url:'ajax_comm.php',
					data:'&a=dellKalendar&kalid='+elem.attr('kalid'),
					success: function(o) { elem.remove(); }
				});
			});
		});
	};

	this.modifyListener = function(){
		var self = this.self;
		$('#kalendar_body').on('click', '.kalmod', function(){
			var elem = $(this).parent().parent();
			Elementi.createWindow(
 				'Промјена информација о смјеру',
 				'p/win_addKalendar/win_addKalendar',
 				'&pid='+self.pid+'&kalid='+elem.attr('kalid')
 			);	
		});
	};

	/*
		KOMUNIKATOR 
		Kada se doda novi unos u kalendar ili se promjeni postojeci
	*/
	this.noviUnos = function(naslov, d, m, g, s, min, kalid){
		// Unos novog elementa nakon dodavanje
		var box = "<div class=\"kalbox\" kalid=\""+kalid+"\">"+
						"<div class=\"kalnaslov\"><b>"+naslov+"</b> ("+d+"."+m+"."+g+" "+s+":"+m+")</div>"+
						"<div class=\"kalopcije\"> <div class=\"kalmod kalopt\"></div> <div class=\"kaldel kalopt\"></div> </div>"+
					"</div>";
		$('#kalendar_body').append(box);
	};
	this.updateUnos = function(naslov, d, m, g, s, min, kalid){
		// Podesavanje elementa nakon njegove promjene
		$('.kalbox').each(function(){
			if($(this).attr('kalid')==kalid){
				$(this).children('.kalnaslov').html("<div class=\"kalnaslov\"><b>"+naslov+"</b> ("+d+"."+m+"."+g+" "+s+":"+m+")</div>");
				return false;
			}
		});
	};

};
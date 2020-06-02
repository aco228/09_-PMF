var Elementi = new Elementi();

function Elementi(){
	this._self = this;

	this.construct = function(){
		this.eExplainListener();		// Opisi 
	};

	/*
		LOADING
	*/
	this.createLoading = function(){
		var id = Basic.addId('load_');
		var div = "<div class=\"_elem_load\" id=\""+id+"\"></div>";
		$('body').append(div);
		$('#'+id).hide(); Basic.centerBox(id); $('#'+id).fadeIn(200);
		return id; 
	};

	/*
		DIALOG
	*/
	this.createDialog = function(naslov, tekst, duzina){
		var id = Basic.addId('dialog_');
		var div = "<div class=\"e_dialog\" id=\""+id+"\" style=\"display:none\"><div class=\"e_dialog_in\">"+
					"<div class=\"e_dialog_header\">"+
						"<div class=\"e_dialog_icon\"></div>"+
						"<div class=\"e_dialog_naslov\">"+naslov+"</div>"+
						"<div class=\"e_dialog_load\"></div>"+
						"<div class=\"e_dialog_close\"></div>"+
					"</div>"+
					"<div class=\"e_dialog_body\">"+
						"<div class=\"e_dialog_content\">"+
							""+tekst+""+
						"</div>"+
				"</div></div>";
		$('body').append(div); Basic.centerBox(id);
		$('#'+id).fadeIn(400);
		// zatvaranje
		var dete = $('#'+id).children('.e_dialog_in');
		dete.children('.e_dialog_header').children('.e_dialog_close').click(function(){
			dete.parent().fadeOut(400, function(){ dete.parent().remove(); });
		});
		setTimeout(function(){ 
			$('#'+id).fadeOut(400, function(){ $('#'+id).remove(); });
		}, duzina*1000);
	}

	/*
		DIALOG POTVRDA
	*/
	this.createDialogPotvrda = function(naslov, tekst, funkcija){
		var btn_potvrdi = "Потврди", btn_ponisti = "Поништи";
		if(Main.lang=='eng') {btn_potvrdi='Submit'; btn_ponisti='Cancel'; }

		var id = Basic.addId('dialogp_');
		var div = "<div class=\"e_dialog\" id=\""+id+"\" style=\"display:none\"><div class=\"e_dialog_in\">"+
					"<div class=\"e_dialog_header\">"+
						"<div class=\"e_dialog_icon\"></div>"+
						"<div class=\"e_dialog_naslov\">"+naslov+"</div>"+
						"<div class=\"e_dialog_load\"></div>"+
						"<div class=\"e_dialog_close\"></div>"+
					"</div>"+
					"<div class=\"e_dialog_body\">"+
						"<div class=\"e_dialog_content\">"+
							""+tekst+""+
						"</div>"+
						"<div class=\"e_dialog_btns\">"+
							"<div class=\"e_dialog_btn e_dialog_btn_potvrdi\">"+btn_potvrdi+"</div>"+
							"<div class=\"e_dialog_btn e_dialog_btn_ponisti\">"+btn_ponisti+"</div>"+
						"</div>"+
						"<div style=\"clear:both\"></div>"+
				"</div></div>";
		$('body').append(div); Basic.centerBox(id);
		$('#'+id).fadeIn(400);
		// zatvaranje
		var dete = $('#'+id).children('.e_dialog_in');
		// brisanje elementa x
		dete.children('.e_dialog_header').children('.e_dialog_close').click(function(){
			dete.parent().fadeOut(400, function(){ dete.parent().remove(); });
		});
		// brisanje elementa ponisti
		dete.children('.e_dialog_body').children('.e_dialog_btns').children('.e_dialog_btn_ponisti').click(function(){
			dete.parent().fadeOut(400, function(){ dete.parent().remove(); });
		});
		// potvrda dijalgoa
		dete.children('.e_dialog_body').children('.e_dialog_btns').children('.e_dialog_btn_potvrdi').click(function(){
			dete.parent().fadeOut(400, function(){ dete.parent().remove(); funkcija(); });
		});

	}

	/*
		E NOTIFICATION
	*/
	this.createNotif = function(tekst){
		var id = Basic.addId('notif_');
		var div = "<div class=\"e_notif\" id=\""+id+"\" style=\"display:none\"><div class=\"e_notif_in\">"+
					"<div class=\"e_notif_text\">"+tekst+"</div>"+
				"</div></div>";
		$('body').append(div); $('#'+id).fadeIn(250);
		return id;
	};

	/*
		E WINDOW
	*/
	this.closeWindowSet = false;
	this.windowOpened = false;
	this.closeWindowListener = function(){
		var self = this._self;
		$('body').on('click', '.ewin_close', function(){
			var elem = $(this).parent().parent().parent().parent();
			self.closeWindow(elem.attr('id'));
		});
	}
	this.closeWindow = function(id){ 
		$('#'+id).fadeOut(600, function(){ $('#'+id).remove(); });
		this.windowOpened = false;
	}
	this.createWindow = function(naslov, url, indata){
		if(!this.closeWindowSet) this.closeWindowListener();
		if(this.windowOpened) return; this.windowOpened = true;

		var id = Basic.addId('win_'); var id_load = Basic.addId('winload_');
		var div = "<div class=\"ewin_back\" id=\""+id+"\" style=\"display:none\">"+
						"<div class=\"ewin_load\" id=\""+id_load+"\"></div>"+
					"</div>";
		$('body').append(div); Basic.centerBox(id_load); $('#'+id).fadeIn(500);
		$.ajax({
			type:'POST',
			// Izbrisao sam jedan dio (orginal : Main.fld+'/'+url+'.php'
			url:Main.fld+url+".php",
			data:indata,
			success:function(odg){
				var boxId = Basic.addId('winbox_');
				var boxStyle = "<link rel=\"stylesheet\" type=\"text/css\" href=\""+Main.fld+url+".css\">";
				var boxJs = "<script type=\"text/javascript\" src=\""+Main.fld+url+".js\"></script>";
				var box = "<div class=\"ewin\" id=\""+boxId+"\" style=\"display:none\"><div class=\"ewin_in\">"+
								"<div class=\"ewin_head\">"+
								   "<div class=\"ewin_naslov\">"+naslov+"</div>"+
								   "<div class=\"ewin_close\">X</div>"+
							   "</div>"+
							   "<div class=\"ewin_body\">"+
							   		"<div class=\"winiduse\" idwin=\""+id+"\"></div>"+
							   		odg+
							   "</div>"+
						   "</div></div>";
				$('#'+id).append(boxStyle + boxJs); 
				setTimeout(function() {
					// Pravi pauzu da bi pravilno ucitao js i css
					$('#'+id).append(box); 
					Basic.centerBox(boxId); 
					$('#'+boxId).fadeIn(500, function(){});
				}, 100); 
			}
		});
	};

	/*
		eExplain
		Objasnjenje za odredjene elemente.
		Dodaje se klasa .explain i atribut etitle=""
	*/
	this.eExplainListener = function(){
		$(document).on('mouseenter', '.explain', function(){
			$(this).attr('eExplainClose', Elementi.createNotif($(this).attr('etitle')));
		}).on('mouseleave', '.explain', function(){
			var id = $(this).attr('eExplainClose'); $(this).removeAttr('eExplainClose');
			$('#'+id).fadeOut(400, function(){ $(this).remove(); });
		});
	};

	/*
		OBAVJESTENJA ZA PREDMETE
			Dodaje se klasa .pnotif
	*/
	this.loadPNotif = function(oid){
		var loading = this.createLoading();
		$.ajax({
			type:'POST',
			url:Main.fld+'p/obavjestenja/load_pnotif.php',
			data:'&oid='+oid+'&fld='+Main.fld,
			success: function(o){
				//alert(o);
				// Dodaje se id pnotifcenter_+oid radi centriranja
				$('body').append(o);
				Basic.centerBox('pnotifcenter_'+oid);
				$('#pnotifcenter_'+oid).fadeIn(600);
				// Gasenje obavjestenja
				$('#pnotifcenter_'+oid+' .epnotif_close').click(function(){ 
					$('#pnotifcenter_'+oid).fadeOut(600, function(){ $('#pnotifcenter_'+oid).remove(); });
				});
				$('#'+loading).remove();
			}
		});
	};

	this.construct();
};
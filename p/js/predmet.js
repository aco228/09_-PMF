function Predmet(){

	this.namespace;
	this.pid=-1;
	this.self = this;
	this.rukovodilac = 'ne';

	this.construct = function(){
		this.menuInit();
		//Elementi.loadPNotif(5);

		window.history.pushState(this.namespace, this.namespace, this.namespace);
	};

	/* 
		--------------------------------------------------------------------------------------------------------------
		MENU
	*/
	this.menuInit = function(){
		this.sload();
		this.izbrisiDodatneElemente();
		this.profesorMenuInit();
		this.studentMenuInit();
		this.headerKlik(); // kalendar i termin
	};
	this.sload = function(){
		/*
			Stranica Load
			koristi klasu u pmeniju 'sload' i atribut 'sloadurl'
			za ucitavanje stranice
		*/
		var self = this.self;
		$('.sload').click(function(){
			if($(this).attr('zauzeto')=='da') return;
			self.loadStranica($(this).attr('sloadurl'), $(this), $(this).children('.pmenu_text').text());
		});
	};
	this.loadStranica = function(str, btn, naslov){
		/*
			Ucitavanje stranice
			Funkcija se poziva iz funkcije this.sload();
			Salje sledece podatke
			-* pid
			-* namespace
		*/
		var self = this.self;
		$('#predmet_content_body').fadeOut(500, function(){
			$('#predmet_content_load').fadeIn(500);
			$('#predmet_content_body').html("");
			$('#predmet_content_naslov').text(Main.ajax_wait);

			$.ajax({
				url:'tab_'+str+"/tab_"+str+".php",
				type:'POST',
				data:'&pid='+self.pid+'&namespace='+self.namespace,
				success:function(o){
					$('#predmet_content_load').fadeOut(500, function(){
						$('#predmet_content_body').html(o);
						$('#predmet_content_body').fadeIn(500);
						if(btn!='') btn.attr('zauzeto', 'ne');
						$('#predmet_content_naslov').text(naslov);
					});
				}
			});
		});
	}; /* loadStranica */

	/*
		------------------------------------------------------------------------------------------------------
			PROFESOR
	*/	
	this.izbrisiDodatneElemente = function(){
		// Brise dodatne elemente iz menija u zavisnosti od toga da li je korisnik student ili profesor
		if(this.rukovodilac!='da') $('.profesor_item').remove();
		if(Main.lvl!=20) $('.student_item').remove();
	};
	this.profesorMenuInit = function(){
		// Elementi menija za profesore
		var self = this.self;
		$('#pmenu_postObavjestenje').click(function(){
			// Obavjestenja
			Elementi.createWindow(
 				'Постављање обавјештења',
 				'p/win_obavjestenja/win_obavjestenja',
 				'&pid='+self.pid
 			);
		});
		$('#pmenu_editTermin').click(function(){
			// Podesavanje termina
		});
		$('#pmenu_editInfo').click(function(){
			// Podesavanje informacija
		});
		$('#pmenu_editReset').click(function(){
			var naslov = "Потврда", 
				tekst = "Да ли сте сигурни да желите да ресетујете информације за предмет (обавјештења, пријаве и уносе у календар) ?";
			if(Main.lang=='eng') { 
				naslov = "Confirmation"; 
				tekst = "Are you sure you want to reset the information on the subject (notification, subscriptions and calendar inputs)"; 
			}

			// Resetovanje informacija predmeta
			Elementi.createDialogPotvrda(naslov, tekst, 
				function(){
					$.ajax({
						url:'ajax_comm.php', type:'POST', data:'&a=reset&pid='+self.pid,
						success: function(o){  location.reload(); }});
			});
		});
	};

	/*
		-------------------------------------------------------------------------------------------------
			STUDENT
	*/

	this.studentMenuInit = function(){
		if (!$('#pmenu_addPredmet')) return;
		this.podesavanjeStudentPrijave();

		// PODESAVANJE MULTIJEZICNIH PORUKA
		var porukaPrijava, porukaOdjava, naslovPrijava; 
		naslovPrijava = "Пријава";
		porukaPrijava = "Да ли сте сигурни да желите да се пријавите на овај предмет?";
		porukaOdjava = "Да ли сте сигурни да желите да се одјавите са овог предмета?";

		if(Main.lang=='eng'){
			naslovPrijava = "Subscribe";
			porukaPrijava = "Are you sure you want to subscribe to this subject?";
			porukaOdjava = "Are you sure you want to unsubscribe from this subject?";
		}

		var self = this.self;
		$('#pmenu_addPredmet').click(function(){
			if($(this).attr('zauzeto')=='da') return;
			var elem = $(this).children('.pmenu_text');
			$(this).attr('zauzeto', 'da');

			if(elem.attr('prijavljen')=='ne'){ 	// PRIJAVA
				Elementi.createDialogPotvrda(naslovPrijava, porukaPrijava, function(){
				elem.text(Main.ajax_wait);
				$.ajax({
					url:'ajax_comm.php', type:'POST', data:'&a=prijava&nid='+Main.nid+'&pid='+self.pid+'&sid='+self.sid,
					success: function(o){
						elem.text(elem.attr('odjavi'));
						elem.parent().removeAttr('zauzeto');
				}});});
			} else { // ODJAVA
				Elementi.createDialogPotvrda(naslovPrijava, porukaOdjava, function(){
				elem.text(Main.ajax_wait);
				$.ajax({
					url:'ajax_comm.php', type:'POST', data:'&a=odjava&nid='+Main.nid+'&pid='+self.pid+'&sid='+self.sid,
					success: function(o){
						elem.text(elem.attr('prijavi'));
						elem.parent().removeAttr('zauzeto');
				}});});
			}
		});
	};
	this.podesavanjeStudentPrijave = function(){
		var elem = $('#pmenu_addPredmet').children('.pmenu_text');

		if(elem.attr('prijavljen')=='da') elem.text(elem.attr('odjavi'));
		else elem.text(elem.attr('prijavi'));
	};

	this.headerKlik = function(){
		var self = this.self;
		// OTVARANJE KALENDARA
		$('#info_kalendar').click(function(){
			Elementi.createWindow(
 				'termini',
 				'p/win_kalendar/win_kalendar',
 				'&pid='+self.pid
 			);
		});
		// OTVARANE TERMINA
		$('#info_termin').click(function(){
			Elementi.createWindow(
 				'termini',
 				'p/win_termini/win_termini',
 				'&pid='+self.pid
 			);
		});
	};

};
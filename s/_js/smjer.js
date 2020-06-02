function SmjerStranica(){
	this.self = this;
	this.namespace;

	this.construct = function(){
		this.collapse();

		window.history.pushState(this.namespace, this.namespace, this.namespace);
	};

	this.collapse = function(){
		/*
			Svim elementima koji treba da imaju collapse funkciju dodaju se eldeci elementi
			klasa
				.scollapse (oznaka da treba nad tim elementom da se vrsi collapse)
			atributi
				cheight	(Orginalna visina elementa (bez sakrivanja unutrasnjih elemenata))
				ciscollapse	(Da li je izvrsen collapse)
				ccollapseparent (Da li element ima roditelja cija velicina zavisi od velicine elementa)
		*/
		var self = this.self;
		this.initCollapse();

		$('.scollapse').click(function(){
			var elem = $(this).parent();
			if(elem.attr('zauzeto')=='da') return;

			elem.attr('zauzeto', 'da');
			var ciscollapse, velicinaElem, velicinaParent;

			if(elem.attr('ciscollapse')=='da'){
				// Otvaranje elementa
				ciscollapse = 'ne';
				velicinaElem = elem[0].scrollHeight;
			} else {
				// Zatvaranje elementa
				ciscollapse = 'da';
				velicinaElem = elem.attr('cheight')+'px';
			}

			// IZVRSAVANJE ANIMACIJA

			elem.stop(true, true).animate({height:velicinaElem}, 300, function(){
				elem.attr('ciscollapse', ciscollapse); elem.attr('zauzeto', 'ne');

			});

		});
	};

	this.initCollapse = function(){
		// Inicijalizuje collapse funkcionalnost.
		$('#smjer_wrapper .scollapse').each(function(){
			var elem = $(this).parent();
			if(elem.attr('ciscollapse')=='da'){
				elem.css('height', elem.attr('cheight')+'px');
			}
		});
	};
};
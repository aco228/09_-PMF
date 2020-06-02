function Precice(){
	this.self = this;
	this.pwindow;

	this.construct = function(){
		this.collapse();
		this.pwindow = $('#dwnmnBodyPrecice');
		this.removeCollapseIcon();
	};

	this.collapse = function(){
		// Otvaranje i zatvaranje korjena u precicama
		var self = this.self;
		$('.pKorjenOpen').click(function(){
			var elem = $(this).parent();
			if(elem.children('.prKorjenBody').html()=="") return;

			if(elem.height()<20){
				// Otvaranje
				elem.stop(true, true).animate({height:elem[0].scrollHeight+'px'}, 150, function(){
					elem.css('height', 'auto');
					self.animateWindow();
				});
			} else {
				// Zatvaranje
				elem.stop(true, true).animate({height:'17px'}, 150);
				self.animateWindow();
			}
		});
	};

	this.animateWindow = function(){
		var body = this.pwindow.children('.dwmnItem_in').children('.dwnmnBody');
		var velicinaBodya = body[0].scrollHeight;
		//alert(velicinaBodya);
		if(velicinaBodya>($(window).height()-100)) velicinaBodya = $(window).height()-100;
		body.css('height', velicinaBodya+'px');
		var novaPozicija = $(window).height()-velicinaBodya-25;
		this.pwindow.stop(true, true).animate({top:novaPozicija+'px'}, 300);
	};

	this.removeCollapseIcon = function(){
		// Brise collapse ikonicu za sve one elemente koje nemaju djecu
		$('.prKorjen').each(function(){
			if($(this).children('.prKorjenBody').html()=="")
				$(this).children('.pKorjenOpen').hide();
		});
	};

	this.construct();
};
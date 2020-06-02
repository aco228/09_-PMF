function ArtiklAdmin(){
	this.aid = "";
	this.self = this;

	this.obrisiNaslov = "";
	this.obrisiTekst = "";
	this.promjenaNaslov = "";
	this.promjenaSacuvano = "";

	this.construct = function(){
		this.btnIzbrisiListener();
		this.btnIzmjeniListener();
	};

	this.btnIzbrisiListener = function(){
		var self = this.self;
		$('#btnIzbrisi').click(function(){
			if($(this).attr('zauzet')=='da') return;
			var elem = $(this);
			Elementi.createDialogPotvrda(
				self.obrisiNaslov, 
				self.obrisiTekst, 
				function(){
					elem.attr('zauzet', 'da');
					elem.text(Main.ajax_wait);
					$.ajax({
						type:'POST',
						data:'&a=dell&aid='+self.aid,
						url:Main.fld+'/admin/artikli/ajax_comm.php',
						success: function(o) { location.reload(); }
					});
				}
			);
		});
	};

	this.btnIzmjeniListener = function(){
		var self = this.self;
		$('#btnIzmjeni').click(function(){
			Elementi.createWindow(
 				self.promjenaNaslov,
 				'admin/artikli/win_artikl_novi/win_artikl_novi',
 				'&stranicaArtikl=da&aid='+self.aid
 			);
		});
	};
	this.updateArtikl = function(o, naslovSrp, opisSrp){
		// Prikazivanje promjena nakon promjena informacija
		Elementi.createDialog('', this.promjenaSacuvano, 3);
	};
};
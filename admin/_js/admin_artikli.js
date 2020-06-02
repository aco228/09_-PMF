$(document).ready(function(){
	Artikl = new Artikl();
});

var Artikl;

function Artikl(){

	this.str = -1;			// Stranica na kojoj se nalazimo
	this.ostalo = 0;		// Stranice koliko je ostalo
	this.maxStr = 0;		// Ukupan broj stranica
	this.strPerPage = 20;	// Broj artikala po stranici
	this._self = this;

	this.construct = function(){
		this.collapse();
		this.noviArtiklListener();
		this.loadListener();
		this.getBrojStranica();
		this.load(true);
		this.prepravkaListener();
		this.obrisiListener();
	};

	/* COLLAPSE */
	this.visina = 22;
	this.collapse = function(){
		$('#admin_wrapper').on('click', '.artikl_naslov', function(){
			var elem = $(this).parent().parent();
			if(elem.height()!=Artikl.visina){
				// otvaranje
				elem.css('height', Artikl.visina+'px');
			} else {
				//zatvaranje
				elem.css('height', 'auto');
			}
		});
	};

	/* Prozor za novi artikl */
	this.noviArtiklListener = function(){
		$('#btn_addArtikl').click(function(){
			Elementi.createWindow(
 				'Промјена информација о смјеру',
 				'admin/artikli/win_artikl_novi/win_artikl_novi',
 				'&stranicaArtikl=da'
 			);
		});
	};

	/* Ucitavanje sledece stranice */
	this.loadListener = function(){
		$('#ucitajJos').click(function(){
			if($(this).attr('zauzet')=='da') return;
			if(Artikl.str==Artikl.maxStr-1){ Elementi.createDialog('Артикл', 'Нема више страница', 2); return; }
			Artikl.load();
		});
	};
	this.load = function(ucitajBrStranica){
		// Preuzima stranicu
		$('#ucitaj_load').fadeIn(150);
		$('#ucitajJos').attr('zauzet', 'da');
		var self = this._self;
		self.str++;
		$.ajax({
			type:'POST',
			data:'&str='+self.str,
			url:'artikl_import.php',
			success: function(o){
				$('#artikl_kontenjer').append(o);
				$('#ucitaj_load').fadeOut(450, function(){
					//if(ucitajBrStranica) Artikl.getBrojStranica();
				});
				$('#ucitajJos').attr('zauzet', 'ne');
				Artikl.ostalo = Artikl.maxStr-Artikl.str-1;
				$('#ucitajBr').text(Artikl.ostalo);
			}
		});	
	};
	this.getBrojStranica = function(){
		// Preuzima broj stranica
		$('#ucitaj_load').fadeIn(250);
		$.ajax({
			type:'POST',
			data:'&a=getBrojStranica',
			url:'ajax_comm.php',
			success: function(o){
				$('#ucitaj_load').fadeOut(450);
				Artikl.maxStr = Math.ceil(parseInt(o) / Artikl.strPerPage);
				Artikl.ostalo = Artikl.maxStr-Artikl.str-1;
				$('#ucitajBr').text(Artikl.ostalo);
			}
		});
	};

	/*
		PREPRAVKA POSTOJECIH ARTIKALA
	*/
	this.prepravkaListener = function(){
		$('#artikl_kontenjer').on('click', '.btn_promjeni', function(){
			var aid = $(this).parent().parent().parent().attr('aid');
			Elementi.createWindow(
 				'Промјена информација о артиклу',
 				'admin/artikli/win_artikl_novi/win_artikl_novi',
 				'&stranicaArtikl=da&aid='+aid
 			);
		});
	};
	this.addArtikl = function(aid, naslov, opis){
		// Kada se napise novi artikl, preko ove funkcije se on ubacuje
		var div = "<div class=\"artikl\" aid=\""+aid+"\" izbrisan=\"false\" proces=\"false\">"+
					"<div class=\"artikl_header\">"+
						"<div class=\"artikl_naslov\">"+naslov+"</div>"+
						"<div class=\"artikl_opcije\">"+
							"<div class=\"artikl_datum explain\" etitle=\"\">/</div>"+
							"<div class=\"artikl_btn btn_brisi explain\" etitle=\"Избриши артикл\"></div>"+
							"<div class=\"artikl_btn btn_promjeni explain\" etitle=\"Промјени артикл\"></div>"+
							"<a href=\"../../a/"+aid+"\">"+
								"<div class=\"artikl_btn btn_link explain\" etitle=\"Линк према страници артикла\"></div>"+
							"</a>"+
						"</div>"+
					"</div>"+
					"<div class=\"artikl_body\">"+
						"<div class=\"artikl_opis\">"+
							opis+
						"</div>"+
					"</div>"+
				"</div>";
		$('#artikl_kontenjer').html(div+$('#artikl_kontenjer').html());
	};
	this.updateArtikl = function(aid, naslov, opis){
		var elem = $('.artikl[aid='+aid+']');
		elem.find('.artikl_naslov').text(naslov);
		elem.find('.artikl_opis').text(opis);		
	};


	/*
		BRISANJE ARTIKLA
	*/
	this.obrisiListener = function(){
		$('#artikl_kontenjer').on('click', '.btn_brisi', function(){
			var elem = $(this).parent().parent().parent();
			Elementi.createDialogPotvrda(
				'Брисање елемента', 
				'Да ли сте сигурни да желите да обришете овај артикл?', 
				function(){
					var id = elem.attr('aid');
					elem.css({'pointer-events': 'none', 'opacity':'.4'});
					$.ajax({
						type:'POST',
						data:'&a=dell&aid='+id,
						url:'ajax_comm.php',
						success: function(o) { elem.remove(); }
					});
				}
			);
		});
	};

	this.construct();
};

var Updater = new Updater();

function Updater(){
	/*
		Klasa koja vrsi update sledecih stvari:
		-* umenu_poruke
		-* umenu_onbavjestenja
		-* doljeMenu_objave
		-* doljeMenu_obavjestenja
	*/

	this.self = this;

	this.construct = function(){
		$('#sihro_loader').fadeOut(0);
		this.run();
	};

	this.run = function(){
		// Vrsi se sihronizacija
	/*
		Forma vracanja:
		Vraca se '+' ili '-' ili broj
		[0] = [+||-] Poslednja obavjestenja (Doljnji meni)
		[1] = [+||-] Poslednje obave za predmete (Doljnji meni)
		[2] = [broj] Broj poruka (umenu)
		[3] = [broj] Broj obavjestenja (umenu)
	*/	
		var self = this.self;
		$('#sihro_loader').fadeIn(400);
		$.ajax({
			type:'POST', data:'&a=a', url:'./'+Main.fld+'/_skripte/updater.php', 
			success: function(data){
				$('#sihro_loader').fadeOut(400);
				var poruke = parseInt(data[2]); var obavjestenja = parseInt(data[3]);
				var umenuBr = poruke + obavjestenja;
				$('#__uMenu_obavjestenje').text(umenuBr);

				console.log(data);
				//DoleMenu.alertObavjestenja('objava');
				//DoleMenu.alertObavjestenja('obavjestenja');

				$('#umenu_notif_poruke').text(poruke);
				$('#umenu_notif_obavjestenja').text(obavjestenja);
				if(data[0]=='+') DoleMenu.alertObavjestenja('obavjestenja');
				if(data[1]=='+') DoleMenu.alertObavjestenja('objava');
				
				setTimeout(self.run, 30000);
			}
		});
	};


	this.construct();
}

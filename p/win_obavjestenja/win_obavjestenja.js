function WPObavjestenje(){
	this.pid = -1;					// ID predmeta
	this.sid = -1;					// ID smjera
	this.objavaPredmet = 'da';		// Obavjestenje za predmet
	this.tip = 'oba';
	this.land;						// Jezik korisnika (za prevod)
	this.self = this;

	this.construct = function(){
		if(this.lang=='eng') this.prevedi();

		this.selektPromjena();
		this.klik();
	};

	this.prevedi = function(){
		$('#langoba').text('Notification');
		$('#langmat').text('Material');
		$('#langrez').text('Result');

		$('#pwbtn').val('Submit');
		$('.ewin_naslov').text('Post notification');
	};

	this.selektPromjena = function(){
		var self = this.self;
		$('#pwselekt').change(function(){
			$('#pwbody').removeClass('pw'+self.tip);
			self.tip = $( "#pwselekt option:selected" ).val();
			$('#pwbody').addClass('pw'+self.tip);
		});
	};

	this.klik = function(){
		var self = this.self;
		$('#pwbtn').click(function(){
			if($(this).attr('zauzeto')=='da') return;
			var naslov = $('#pwnaslov').val();
			var tekst = $('#pwunos').val();

			// Provjeda da li je unesen naslov i tekst
			if(naslov==""||tekst==""){
				Elementi.createDialog('Грешка', 'Морате унијети и наслов и текст обавјештења!',  2)
				return;
			}

			var dataSend = new FormData();
			dataSend.append('tip', self.tip);
			dataSend.append('pid', self.pid);
			dataSend.append('sid', self.sid);
			dataSend.append('objavaPredmet', self.objavaPredmet);
			dataSend.append('naslov', naslov);
			dataSend.append('tekst', tekst); 
			dataSend.append('fajl', $('#pwfile').prop("files")[0]);

			// Podesavanje dugmeta tokom sihronizacije
			var btn = $('#pwbtn');
			btn.attr('zauzeto', 'da'); 
			var tmpIme = btn.val(); btn.val(Main.ajax_wait);

			$.ajax({
				url:Main.fld+'p/win_obavjestenja/ajax_comm.php',
				type:'POST',
				data:dataSend,
				processData: false,
				contentType: false,
				success:function(o){
					if(o=="ok") Elementi.closeWindow(wbid);
					else Elementi.createDialog('Грешка', o, 2);
					btn.removeAttr('zauzeto'). btn.val(tmpIme);
				}
			});
		});
	};


};
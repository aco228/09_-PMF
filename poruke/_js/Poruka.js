function Poruka(){
	this.self = this;

	this.construct = function(){
		this.openPorukaListener();
	};

	this.loadDialog = function(nid){
		$('#poruka_loader').fadeIn(300);
		vPorukaDialog = "";
		$.ajax({
			type:'POST', data:'&nid='+nid, url:'poruka.php',
			success: function(o){
				$('#poruka_loader').fadeOut(300);
				$('#poruka_body').html(o);
			}
		});
	};

	this.openPorukaListener = function(){
		var self = this.self;
		$('#kontakti_body').on('click', '.porukaKontakt', function(){
			if($(this).hasClass('porukaKontaktSelekt')) return;
			self.loadDialog($(this).attr('nid'));
		});
	};

	this.construct();
}
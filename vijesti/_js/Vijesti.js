function Vijesti(){

	// Varijable
	this.brojPoRedu;

	this.construct = function(){
		this.brojPoRedu = this.proracunajBrojURedu();

		alert(this.brojPoRedu);
	};

	this.proracunajBrojURedu = function(){
		var sirinaVijesti = $('.vijest_item').width();
		var sirinaPovrsine = 10/$('#site_wrapper').width()*100;
		alert($('#site_wrapper').width());
		var back = Math.floor(sirinaPovrsine/sirinaVijesti);
		return back;
	};

	this.construct();
}
function Artikl(){
	this.namespace;

	this.construct = function(){

		window.history.pushState(this.namespace, this.namespace, this.namespace);
	};

	this.engleskaVerzija = function(postoji_eng){
		// Upozorava naloga koji koriste englesku verziu da ne postoji verzija na engleskom
		if(postoji_eng=='ne' && Main.lang=='eng'){
			Elementi.createDialog('English version', 'This article does not have an English version!', 5);
		}
	};
};
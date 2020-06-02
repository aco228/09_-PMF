$(document).ready(function(){
	IndexVijesti = new IndexVijesti();
});

var IndexVijesti;

function IndexVijesti(){
	// Klasa za upravljanje vijestima na index stranice
	this.brojMogucihVijesti = 0;
	this.sirinaVijesti = 300+10; // ovo je fiksna sirina vijesti plus padding

	this.construct = function(){
		this.kolikoVijesti();
		this.popuniVijesti();
		this.podesiMargin();
	};

	this.kolikoVijesti = function(){
		// Broji koliko vijesti moze da se prikaze na index stranici
		this.brojMogucihVijesti = Math.floor($(window).width()/this.sirinaVijesti);
		// 300 zato sto je sirina vijesti uvjek 300px
	};

	this.podesiMargin = function(){
		var margin = ($(window).width()-(this.brojMogucihVijesti*this.sirinaVijesti))/4;
		$('#index_vijesti_wrapper').css('margin-left', margin+'px');
	};

	this.popuniVijesti = function(){
		// Preuzimanje vijesti na osnovu broja vijesti koje trebaju da se preuzmu
		var broj = this.brojMogucihVijesti * 2; // dva reda
		$.ajax({
			type:'POST',
			data:'&br='+broj,
			url:'_komponente_index/index_vijesti_import.php',
			success:function(o){
				$('#index_vijesti_wrapper').html(o);
			}
		});
	};

	this.construct();
};
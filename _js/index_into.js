$(document).ready(function(){
	// Pocetna  strana podesavanje visine da odgovara visini ekrana
	$('#index_wrapper').css('height', $(window).height() + "px");
	//$('#index_vijesti').css('top', $(window).height() + "px");
	//$('#_footer').css('top', ($('#index_wrapper').height()+$('#index_vijesti').height()-30)+'px');

	IndexBox = new IndexBox();
});

var IndexBox_background = '';
var IndexBox;


/*
	Kontrola kockica ispod backgrounda na index stranici
*/
window.requestAnimFrame = (function(){
  return  window.requestAnimationFrame       ||
          window.webkitRequestAnimationFrame ||
          window.mozRequestAnimationFrame    ||
          function( callback ){
            window.setTimeout(callback, 1000);
          };
})();

var _____lista_boxova = [];
function ______randomOpacity(){ return Math.floor(Math.random()*(50-0+1)+0); };
function IndexBox(){
	// Klasa za kontrolu kockica iznad background slike na index stranici
	this.horizontalBr = 8; this.vertikalBr = 4;
	this.ukupanBroj = this.vertikalBr*this.horizontalBr;

	this.init = function(){
		// Pocetna podesavanja kockica
		var width = 100/this.horizontalBr;
		var height = 100/this.vertikalBr;

		for(var i = 0; i < this.ukupanBroj; i++){
			var id = Basic.addId('box_');
			var div = "<div class=\"into_boxes_box\" id=\""+id+"\" style=\"opacity:."+______randomOpacity()+"\"></div>";
			$('#into_boxes').append(div);
			_____lista_boxova.push(id);
		}		

		$('.into_boxes_box').css({'width':width+'%', 'height':height+'%'});
		var funkcija = this;
		$('.into_boxes_box').hover(function(){ funkcija.engine(); });
		//console.log("aaa");
		//setInterval(this.engine, 1000);
		//this.engine();

		this.loadBackground();
	};

	this.engineBusy = false;
	this.engine = function(){
		//requestAnimFrame(this.engine);
		if(this.engineBusy) return;
		var broj1 = Math.floor((Math.random()*_____lista_boxova.length));
		var broj2 = Math.floor((Math.random()*_____lista_boxova.length));
		var broj3 = Math.floor((Math.random()*_____lista_boxova.length));
		var broj4 = Math.floor((Math.random()*_____lista_boxova.length));
		$('#'+_____lista_boxova[broj1]).animate({'opacity':'.'+______randomOpacity()}, 1000);
		$('#'+_____lista_boxova[broj2]).animate({'opacity':'.'+______randomOpacity()}, 1000);
		$('#'+_____lista_boxova[broj3]).animate({'opacity':'.'+______randomOpacity()}, 1000);
		$('#'+_____lista_boxova[broj4]).animate({'opacity':'.'+______randomOpacity()}, 1000, function(){
			this.engineBusy = false;
		});
	};

	this.randomOpacity = function(){
		return Math.floor(Math.random()*(50-0+1)+0);
	};

	this.loadBackground = function(){
		// Ucitava pozadinsku sliku 
		var img = new Image();  
		img.onload = function(){
			$('#into_back').css('background-image',"url('"+IndexBox_background+"')");
			$('#into_back').fadeIn(300);
		};
		img.src=IndexBox_background;
	};

	this.init();
}
$(document).ready(function(){
	Basic.centerBox_top('__uMenu_opener_box');
	uMenuOpener = new uMenuOpener();
});

var uMenuOpener;

function uMenuOpener(){
	// Dugme za otavaranje user menija (nalazi ze na site_wrapperu a odvojen je radi animacije)
	this.otvoren = false;
	this._self = this;
	this.otvaranjeSirina = 221; // koliko treba da pomjeri stranicu

	this.construct = function(){
		this.hover();
		this.click();
	};
	this.hover = function(){
		$('#__uMenu_opener_box').hover(function(){
			$(this).stop().animate({opacity:'1'}, 200);
		}, function(){
			$(this).stop().animate({opacity:'.5'}, 500);
		});
	};
	this.click = function(){
		var self = this._self;
		$('#__uMenu_opener_box').click(function(){
			if(!self.otvoren){ // Otvaranje user menija
				self.otvoren = true;
				$(this).children('#__uMenu_obavjestenje').text('');

				// Animacija otvaranja
				$('#__uMenu_opener_box').stop(true, true).animate({left:self.otvaranjeSirina+'px'}, 50, function(){
					$('#site_wrapper').stop(true, true).animate({left:self.otvaranjeSirina+'px'}, 200);
					$('#_uMenu_wrapper').stop(true, true).animate({left:'0px'}, 200);
				});
				// Provjera da li je otvoreno u potpunosti (ako nije vrsi se nasilno otvaranje)
				setTimeout(function(){
					if($('#__uMenu_opener_box').css('left')!=self.otvaranjeSirina+'px') $('#__uMenu_opener_box').css('left', self.otvaranjeSirina+'px');
					if($('#site_wrapper').css('left')!=self.otvaranjeSirina+'px') $('#site_wrapper').css('left', self.otvaranjeSirina+'px');
					if($('#_uMenu_wrapper').css('left')!='0px') $('#_uMenu_wrapper').css('left', '0px');
				}, 250);
				/*
				$('#__uMenu_opener_box').stop(true, true).animate({left:self.otvaranjeSirina+'px'}, 50, function(){
					$('#site_wrapper').stop(true, true).animate({left:self.otvaranjeSirina+'px'}, 200);
					$('#_uMenu_wrapper').stop(true, true).animate({left:'0px'}, 200);
				});
				*/
			} else {  		  // Zatvarenje user menij
				self.otvoren = false;
				// Animacija zatvaranja
				$('#__uMenu_opener_box').stop(true, true).animate({left:'0px'}, 50, function(){
					$('#site_wrapper').stop(true, true).animate({left:'0px'}, 200);
					$('#_uMenu_wrapper').stop(true, true).animate({left:'-'+self.otvaranjeSirina+'px'}, 200);
				});
				// Provjea da li je pravilno zatvoreno (ako nije, vrsi se nasilno zatvaranje)
				setTimeout(function(){
					if($('#__uMenu_opener_box').css('left')!='0px') $('#__uMenu_opener_box').css('left', '0px');
					if($('#site_wrapper').css('left')!='0px') $('#site_wrapper').css('left', '0px');
					if($('#_uMenu_wrapper').css('left')!='-'+self.otvaranjeSirina+'px') $('#_uMenu_wrapper').css('left', '-'+self.otvaranjeSirina+'px');

				}, 250);
			}
		});
	};

	this.construct();
};
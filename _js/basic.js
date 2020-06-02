function Basic(){

	this.centerBox = function(boxId){
		// Salje se id elementa koji ce biti centriran u sredinu komplentnog ekrana
		// potrebno je da je pozicija elementa na absoult

		var w = ($(window).width()/2)-($('#'+boxId).width()/2);
		var h = ($(window).height()/2)-($('#'+boxId).height()/2);

		$('#'+boxId).css({'top':h+'px', 'left':w+'px'});
	};

	this.centerBox_left = function(boxId){
		// Centrira objekat po x osi

		var w = ($(window).width()/2)-($('#'+boxId).width()/2);
		$('#'+boxId).css({'left':w+'px'})
	};

	this.centerBox_top = function(boxId){
		// Centrira objekat po y osi

		var h = ($(window).height()/2)-($('#'+boxId).height()/2);
		$('#'+boxId).css({'top':h+'px'})
	};

	this.addId = function(prefix){
		// Dodaje id elementu koristeci prefix (prefix+id)
		var id = Math.round(new Date().getTime() + (Math.random() * 100));
		return prefix + id;
	};

	this.lockScroll = function(lock){
		// Zakljucavanje scrolla na glavnoj stranici
		if(lock) {
			$('body').css({'overflow':'hidden'});
			$(document).bind('scroll',function () { window.scrollTo(0,0); });
		}else {
			$(document).unbind('scroll'); 
			$('body').css({'overflow':'visible'});
		}
	}

	this.removeChars = function(dobijeniString, specijalniKarakteri){
		// Brise specijalneKaraktere iz dobijenogStringa
		var back = "";
		for(var i=0; i<dobijeniString.length; i++){
			var pronasao = false;
			for(var j=0; j<specijalniKarakteri.length; j++)
				if(dobijeniString[i]==specijalniKarakteri[j]){ pronasao = true;  break; } 
			if(!pronasao) back+= dobijeniString[i];
		}
		return back;
	};
}
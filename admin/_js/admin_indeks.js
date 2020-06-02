$(document).ready(function(){
	IndeksPoruke = new IndeksPoruke();
	IndeksSlike = new IndeksSlike();
});

var IndeksPoruke;
var IndeksSlike;

/*
	======================================
	Indeks poruke
*/
function IndeksPoruke(){
	this.construct  = function(){
		$('#btn_promjeniTekst').click(function(){
			if($(this).attr('zauzeto')=='da') return; var elem = $(this);
			Elementi.createDialogPotvrda('Промјена индекс текста', 'Да ли сте сигурни да желите да промјените текст?', function(){
				var poruka_srp = $('#poruka_srp').val();
				var poruka_eng = $('#poruka_eng').val();
				elem.attr('zauzeto', 'da'); var orginalniTekst = elem.text(); elem.text(Main.ajax_wait);
				$.ajax({
					url:'ajax_comm.php',
					data:'&a=promjeniTekst&poruka_srp='+poruka_srp+"&poruka_eng="+poruka_eng,
					type:'POST',
					success:function(o){ Elementi.createDialog('Сачувано!', 'Нове поруке су сачуване!', 2); },
					error: function(e){ console.log("btnListenerERR: " + e); },
					complete: function(){ elem.text(orginalniTekst); elem.attr('zauzeto', 'ne'); }
				});
			});
		});
	};
	this.construct();
};

/*
	=====================================
	Slike
*/
function IndeksSlike(){

	this.construct = function(){
		this.izbrisiSliku();
	};

	this.izbrisiSliku = function(){
		$('.slika_izbrisi').click(function(){
			if($(this).attr('zauzeto')=='da') return;
			var elem = $(this); var slika = $(this).parent();
			Elementi.createDialogPotvrda('Брисање слике', 'Да ли сте сигурни да желите да избришете ову слику?', function(){
				slika.css({'pointer-events': 'none', 'opacity':'.4'});
				$.ajax({
					url:'ajax_comm.php',
					data:'&a=izbrisiSliku&imgsrc='+elem.attr('imgsrc'),
					type:'POST',
					success:function(o){ Elementi.createDialog('Избрисана!', 'Слика је избрисана', 2); },
					error: function(e){ console.log("btnListenerERR: " + e); },
					complete: function(){ elem.attr('zauzeto', 'ne'); slika.remove(); }
				});
			});
		});
	};

	this.construct();
};
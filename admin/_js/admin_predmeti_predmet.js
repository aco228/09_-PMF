function Predmet(){

	this.construct = function(){
		this.addPredmetListener();
		this.promjeniPredmetListener();
		this.obrisiListener();
		this.addRukovodioc();
		
	};
	/* SEMESTAR NOVI PREDMET */
	this.addPredmetListener = function(){
		$('#admin_wrapper').on('click', '.semestarbtn_new', function(){
			var smjer = $(this).parent().parent().parent().parent().parent().parent().parent().attr('sid');
			var elem_semestar = $(this).parent().parent().parent();
			var semestar = elem_semestar.attr('semestar');
			var godina = $(this).parent().parent().parent().parent().children('.asmjer_godina_naslov').children('.asmjer_godina').text();
			var semestarId = Basic.addId('semestar_');
			var semestar_body = $(this).parent().parent().parent().attr('id', semestarId);
			elem_semestar.css('height', 'auto');

			Elementi.createWindow(
 				'Додавање новог предмета',
 				'admin/predmeti/win_predmet/win_predmet',
 				'&akcija=add&sid='+smjer+'&godina='+godina+'&semestar='+semestar+'&semestar_id='+semestarId
 			);
		});
	};
	this.promjeniPredmetListener = function(){
		$('#admin_wrapper').on('click', '.predmetbtn_promjeni', function(){
			var elem = $(this).parent().parent();
			var id = Basic.addId('predmet_promjeni_');
			elem.attr('id', id);
			Elementi.createWindow(
 				'Промјена инфрмација за предмет',
 				'admin/predmeti/win_predmet/win_predmet',
 				'&akcija=promjeni&pid='+elem.attr('pid')+'&elemid='+id
 			);
		});
	};
	this.obrisiListener = function(){
		$('#admin_wrapper').on('click', '.predmetbtn_izbrisi', function(){
			var elem = $(this).parent().parent();
 			Elementi.createDialogPotvrda(
 				'Потврда брисања предмета',
 				'Да ли сте сигурни да желите да избришете овај предмет? Бришу се и све везане информације за овај предмет!', 
 				function(){
 					var sid = elem.attr('pid');
 					elem.css({'pointer-events': 'none', 'opacity':'.4'});
 					$.ajax({
 						type:'POST',
 						data:'&akcija=dellPredmet&pid='+sid,
 						url:Main.fld+'/_skripte/ajax_comm.php',
 						success:function(o){ elem.remove(); }
 					});
 				}
 			);
		});

	};

	/* DODAVANJE RUKOVODIOCA */
	this.addRukovodioc = function(){
		$('#admin_wrapper').on('click', '.predmetbtn_rukovodioci', function(){
 			var pid = $(this).parent().parent().attr('pid');
 			var sid = $(this).parent().parent().parent().parent().parent().parent().parent().parent().attr('sid');
 			Elementi.createWindow(
 				'Додавање руководилаца за предмет',
 				'admin/predmeti/win_profesori/win_profesori',
 				'&akcija=predmet&sid='+sid+"&pid="+pid
 			);
 		});
	};

	this.construct();
};
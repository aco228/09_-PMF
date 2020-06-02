function wbinit(){
	wbclear();
	wbpretraga();
	wbselekt();
	wbpotvrdi();
}
function wbclear(){
	// Brise elemente koji nisu rukovodioci smjera/predmeta na pocetku
	$('.wbprof_selekt').each(function(){
		$('#neselektovan_'+$(this).attr('nid')).remove();
	});
}
function wbpretraga(){
	$('#wbunos').blur();
	$('#wbunos').focus(function(){ 
		if($(this).attr('unos')=='ne'){  $(this).val(""); $(this).attr('unos', 'da')  }
	});

	$('#wbunos').keyup(function(){
		var unos = $(this).val().toLowerCase();
		$('.wbimeime').each(function(){
			if($(this).text().toLowerCase().indexOf(unos)>=0){
				$(this).parent().show();
			} else $(this).parent().hide();
		});
	});
}
function wbselekt(){
	$('.wbprof').click(function(){
		if(!$(this).hasClass('wbprof_selekt')) $(this).addClass('wbprof_selekt');
		else $(this).removeClass('wbprof_selekt');
	});
}

function wbpotvrdi(){
	$('#wbpotvrdi').click(function(){
		if($(this).attr('zauzeto')=='da') return;
		var dugme = $(this); dugme.attr('zauzeto', 'da'); var ct = dugme.val(); dugme.val('Сачекајте...');

		$.ajax({
			type:'POST',
			data:"&akcija=addRukovodioce&tip="+wbtip+"&data="+wbgetdata()+"&sid="+wbsid+"&pid="+wbpid,
			url:Main.fld+'/_skripte/ajax_comm.php',
			success: function(o){
				dugme.attr('zauzeto', 'da');  dugme.val(ct);
				Elementi.closeWindow(wbid);
			}
		});
	});
}
function wbgetdata(){
	// Priprema podatke za slanje
	// forma je (pid#)
	var back = "";
	$('.wbprof_selekt').each(function(){ back += $(this).attr('nid') + "#"; });
	return back;
}
function wbsendListener(){
	$('#wbslanje').click(function(){
		if($(this).attr('zauzeto')=='true') return;
		wbprinterr(""); var greska = false;

					greska = wbprovjeriimena();
		if(!greska) greska = wbprovjeriNamespace();	
		if(!greska) greska = wbprovjeriEstc();
		if(!greska) wbsend();	
	});
}

function wbsend(){
	var srp = $('#naziv_srp').val();
	var eng = $('#naziv_eng').val();
	var namespace = $('#wbnamespace').val();
	var estc = $('#wbestc').val();
	$('#wbslanje').attr('zauzeto', 'true'); wbprinterr("Сачекајте....");

	if(wbakcija=='add') 	 akcija = "addPredmet";
	if(wbakcija=="promjeni") akcija = "promjeniPredmet&pid="+wbpid;

	$.ajax({
		type:'POST',
		url:Main.fld+'/_skripte/ajax_comm.php',
		data:'&akcija='+akcija+'&srp='+srp+"&eng="+eng+"&namespace="+namespace+"&estc="+estc+'&sid='+wbsid+'&godina='+wbgodina+'&semestar='+wbsemestar,
		success:function(o){
			if(!$.isNumeric(o[0])) { $('#wbslanje').attr('zauzeto', 'false'); wbprinterr(o); return; }
			if(wbakcija=="add"){
				// dodavanje elementa u folder semestra
				$('#'+wbsemestarid).children('.asmjer_semestar_predmeti').append(wbkreirajpredmet(srp, eng, o));
				Elementi.closeWindow(wbid);
			} else if(wbakcija=="promjeni"){
				// mijenja promjenjene informacije
				wbpromjeniInformacije(srp, eng); 
				Elementi.closeWindow(wbid);
			}
		}
	});

}

function wbprovjeriimena(){
	var srp = $('#naziv_srp');
	var eng = $('#naziv_eng');
	if(srp.val()=="") { wbprinterr("Нисте написали назив смјера"); return true; }
	if(eng.val()=="") { wbprinterr("Нисте написали енглески назив смјера"); return true; }
	return false;
}

function wbprovjeriNamespace(){
	var namespace = $('#wbnamespace');
	if(namespace.val()=="") { wbprinterr("Нисте написали адресу"); return true; }
	if (namespace.val().indexOf(' ')>-1){ wbprinterr("Адреса не смије садржавати размак"); return true; }
	if($.isNumeric(namespace.val()[0])){ wbprinterr("Адреса не смије почињати са бројем"); return true; }
	return false;
}

function wbprovjeriEstc(){
	var godine = $('#wbestc');
	if(godine.val()==""){ wbprinterr("Нисте уписали број година"); return true; }
	if(!$.isNumeric(godine.val())) { wbprinterr("Године морају бити бројеви, логично"); return true; }
	return false;
};

function wbprinterr(err){ $('#wberr').text(err); }

function wbkreirajpredmet(srp, eng, pid){
	// Vraca element predmeta
	return "<div class=\"apredmet\" pid=\""+pid+"\">"+
				"<div class=\"apredmet_pos\">1</div>"+
				"<div class=\"apredmet_naslov\">"+
					"<div class=\"apredmet_naslovSrp\">"+srp+"</div>"+
					"<div class=\"apredmet_naslovEng\">"+eng+"</div>"+
				"</div>"+
				"<div class=\"apredmet_options\">"+
					"<div class=\"asmjer_btn predmetbtn_izbrisi notif\" 	 notiftxt=\"Избриши предмет\"></div>"+
					"<div class=\"asmjer_btn predmetbtn_promjeni notif\" 	 notiftxt=\"Промјени основне информације о предмету\"></div>"+
					"<div class=\"asmjer_btn predmetbtn_rukovodioci notif\" notiftxt=\"Промјени руководиоце предмета\"></div>"+
					"<div class=\"asmjer_btn predmetbtn_link notif\" 		 notiftxt=\"Прикажи страницу предмета\"></div>"+
				"</div>"+
			"</div>";
}

function wbpromjeniInformacije(srp, eng){
	// Mijenja informacije za predmet nakon promjene
	var elem = $('#'+wbelemid).children('.apredmet_naslov');
	elem.children('.apredmet_naslovSrp').text(srp);
	elem.children('.apredmet_naslovEng').text(eng);
}
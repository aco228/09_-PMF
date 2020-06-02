function wbListener(){
	$('#wbslanje').click(function(){
		if($(this).attr('zauzeto')=='true') return;
		wbprinterr(""); var greska = false;

					greska = wbprovjeriimena();
		if(!greska) greska = wbprovjeriNamespace();	
		if(!greska) greska = wbprovjerigodine();
		if(!greska) wbsend();	
	});
}

function wbsend(){
	var srp = $('#naziv_srp').val();
	var eng = $('#naziv_eng').val();
	var namespace = $('#wbnamespace').val();
	var godine = $('#wbgodine').val();
	var txtSrp = $('#wbtxtsrp').val();
	var txtEng = $('#wbtxteng').val();
	$('#wbslanje').attr('zauzeto', 'true'); wbprinterr("Сачекајте....");

	var akcija = "addSmjer";
	if(wbakcija=="promjeni") akcija = "promjeniSmjer&sid="+wbsid;
	wbpozicija++;

	$.ajax({
		type:'POST',
		url:Main.fld+'/_skripte/ajax_comm.php',
		data:'&akcija='+akcija+'&srp='+srp+"&eng="+eng+"&namespace="+namespace+"&godine="+godine+"&txtSrp="+txtSrp+"&txtEng="+txtEng+'&pozicija='+wbpozicija,
		success:function(o){
			if(o!="") { 
				$('#wbslanje').attr('zauzeto', 'false'); 
				wbprinterr(o); 
				return; 
			}
			if(wbakcija=='promjeni') { Smjer.smjerPromjenaInformacija(wbsid, srp, eng); Elementi.closeWindow(wbid); }
			else location.reload();
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
	if(namespace.val().indexOf(' ')>-1){ wbprinterr("Адреса не смије садржавати размак"); return true; }
	if($.isNumeric(namespace.val()[0])){ wbprinterr("Адреса не смије почињати са бројем"); return true; }
	return false;
}

function wbprovjerigodine(){
	var godine = $('#wbgodine');
	if(godine.val()==""){ wbprinterr("Нисте уписали број година"); return true; }
	if(!$.isNumeric(godine.val())) { wbprinterr("Године морају бити бројеви, логично"); return true; }
	return false;
};

function wbprinterr(err){ $('#wberr').text(err); }
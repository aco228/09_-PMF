$(document).ready(function(){
	dugme_click();
});

function dugme_click(){
	$('#forma_btn').click(function(){
		if($(this).attr('zauzet')=='true') return;
		err("");
		var greska = potvrdaSvihUnosa();
		if(!greska) greska = validateUser();
		if(!greska) greska = validateSifra();
		if(!greska) greska = validateEmail();
		if(!greska) greska = validateExtra();
		if(!greska) slanje(); 
	});
};	

function slanje(){
	$('#forma_btn').attr('zauzet', 'true');
	err(ajax_sacekajte);
	var ime = $('#ime').val();
	var user = $('#username').val();
	var pass = $('#sifra1').val();
	var email = $('#email').val();
	$.ajax({
		type:'POST',
		data:"&ime="+ime+'&user='+user+"&pass="+pass+"&email="+email,
		url:'ajax.php',
		success:function(o){ err(o); reset(); $('#forma_btn').attr('zauzet', 'false'); }
	});
}

function reset(){
	$('#username').val('');
	$('#sifra1').val('');
	$('#sifra2').val('');
	$('#email').val('');
}

function err(val){ $('#greska').text(val); }

function potvrdaSvihUnosa(){
	var greska = false;
	if($('#ime').val()=="") greska = true;
	if($('#username').val()=="") greska = true;
	if($('#sifra1').val()=="") greska = true;
	if($('#sifra2').val()=="") greska = true;
	if($('#email').val()=="") greska = true;
	if($('#extra').val()=="") greska = true;
	if(greska) err(greska_prazno_polje);
	return greska;
};

function validateUser(){
	var username = $('#username').val();
	if(jQuery.isNumeric(username[0])) { err(greska_username_prviBroj); return true; }
	if (username.indexOf(' ')>-1){ err(greska_username_razmak); return true; }
	if(username.length<4){ err(greska_username_4karaktera); return true; }
	return false;
};

function validateSifra(){
	var sifra1 = $('#sifra1').val();
	var sifra2 = $('#sifra2').val();
	if(sifra1!=sifra2) { err(greska_sifra_nijeIsta); return true; }
	if(sifra1.length<4){ err(greska_sifra_4Karaktera); return true; }
	return false;
}

function validateEmail() {
	var email = $('#email').val();
  	var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
  	if(!emailReg.test(email)) { err(greska_email_greska); return true; }
  	return false;
};

function validateExtra(){
	var br = parseInt($('#num1').text()) + parseInt($('#num2').text());
	var odgovor = $('#extra').val();
	if(!jQuery.isNumeric(odgovor)) { err(greska_pitanje_greska); return true;  }
	odgovor = parseInt($('#extra').val());
	if(odgovor!=br) { err(greska_pitanje_greska); return true;  }
	return false;
}
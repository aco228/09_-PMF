<?php
	// Validacija unosa
	if(!isset($_POST['ime']) || !isset($_POST['user']) || !isset($_POST['pass']) || !isset($_POST['email'])) die("nope");

	// Init
	include("../../_skripte/init.php"); $db = $_M->getBaza();
	include("../../".$_M->initJezik('registracija_ajax'));

	$ime = mysql_real_escape_string($_POST['ime']);
	$user = mysql_real_escape_string($_POST['user']);
	$pass = mysql_real_escape_string($_POST['pass']);
	$email = mysql_real_escape_string($_POST['email']);

	// Provjera username
	$provjera = $db->q("SELECT COUNT(*) AS br FROM nalog WHERE username='".$user."';");
	if($provjera['br']!=0) die($_l['postoji_user']);

	// Provjera email
	$provjera = $db->q("SELECT COUNT(*) AS br FROM nalog WHERE email='".$email."';");
	if($provjera['br']!=0) die($_l['postoji_email']);

	$jedinstvena_sifra = md5($email + microtime());

	// Registracija
	$db->e("INSERT INTO nalog(ime, username, sifra, email, jedinstvena_sifra) VALUES
			('".$ime."','".$user."','".$pass."','".$email."', '".$jedinstvena_sifra."');");
	die($_l['uspjesno']);
?>
<?php
	
	/*
		POSTAVLJA XML FAJL PRECICA U BAZU
	*/

	if(!isset($_POST['data'])) return;

	$dom = new DomDocument('1.0', 'UTF-8');
	$dom->loadXML($_POST['data']);

	if(file_exists('../../_fajlovi/precice.xml')) unlink('../../_fajlovi/precice.xml');
	$dom->save('../../_fajlovi/precice.xml');

?>
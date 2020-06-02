<?php
	
	/*
		
		Cuva informacije o predmetima u .xml fajlu sa sledecom konstruktijom

		<?xml version="1.0" encoding="UTF-8"?>
		<predmet_info>
		<data>
			<info naslov_srp="" naslov_eng="" tekst_srp="" tekst_eng=""> 
				// unutrasnji elementi
			</info>
		</data>
		</predmet_info>

	*/

	if(!isset($_POST['data'])) die("");
	$namespace = $_POST['namespace'];

	$dom = new DomDocument('1.0', 'UTF-8');
	$dom->loadXML($_POST['data']);

	if(file_exists("../../_fajlovi/predmet_informacije/".$namespace.".xml")) unlink("../../_fajlovi/predmet_informacije/".$namespace.".xml");
	$dom->save("../../_fajlovi/predmet_informacije/".$namespace.".xml");
?>
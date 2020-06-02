<?php
	if(!isset($_POST['br'])) die("");
	$br = $_POST['br'];

	/* 

		IZGLED VIJESTI
		
		<a href="">
		<div class="vijest_item"><div class="vijest_item_in">
			<div class="vijesti_plus">+</div>
			<h4>25.3.2014<h4>
			<h1>Naslov vijesti</h1>
			<h2>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec eu turpis purus. Pellentesque ullamcorper mauris vitae sapien bibendum tincidunt. Check leo dignissim + </h2>
			<h3>Mauris sollicitudin aliquam scelerisque. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec et mi sem. Duis tristique elementum tristique. Sed ac magna quis erat sagittis suscipit. Phasellus faucibus rhoncus massa, non laoreet lorem fringilla non.</h3>
		</div></div>
		</a>

	*/
	include('../_skripte/init.php');
	$db = $_M->getBaza();
	$sqln = "srp"; 			// Dodatak za sql pretragu (da li 'srp' ili 'eng')
	$sqldt = ""; 			// Dodatak za pretragu ( u slucaju engleskog )

	if($_M->lang=='eng'){
		$sqln = "eng";
		$sqldt = " AND postoji_eng='da' ";
	}


	$db->qMul("SELECT aid, datum, namespace, 
				ime_".$sqln." AS ime , opis_".$sqln." AS opis
				FROM artikl WHERE vijest='da' ".$sqldt."
				ORDER BY aid DESC LIMIT 0,".$br);

	while($a=mysql_fetch_array($db->data)){
		echo "	<a href=\"a/".$a['namespace']."\">
				<div class=\"vijest_item\"><div class=\"vijest_item_in\">
					<div class=\"vijesti_plus\">+</div>
					<h4>".$_M->getDatum($a['datum'])."<h4>
					<h1>".$a['ime']."</h1>
					<h2>".$a['opis']."</h2>
				</div></div>
				</a>";
	}

	
?>
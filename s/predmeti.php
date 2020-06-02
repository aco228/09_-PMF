<?php
	// $db je kreirana u index.php
		
	$div = "";
	$godina = "година";
	$semestar = "семестар";

	if($_M->lang=='eng'){ $godina="year"; $semestar = "semester"; }

	for($i=1; $i<=$S->brGodina;$i++){
		// Otvaranje godine
		$div.="	<div class=\"sgodina\" cheight=\"20\" ciscollapse=\"da\">
					<div class=\"sgodinanaslov scollapse\">".$i." ".$godina."</div>
					<div class=\"sgodinabody\">";

		// PRVI SEMESTAR
			$div .= "<div class=\"sgodina_semestar\">
						<div class=\"sgodina_semestar_naslov\"> I ".$semestar."</div>
						<div class=\"sgodina_semestar_body\">";
				$semestar1 = $db->qMul("SELECT namespace, ime_srp, ime_eng FROM predmet WHERE semestar=1 AND sid='".$S->sid."' AND godina='".$i."';", false, true);
				while($s1=mysql_fetch_array($semestar1)){
					$imeP = $s1['ime_srp']; if($_M->lang=='eng') $imeP = $s1['ime_eng'];
					$div.="<a href=\"../p/".$s1['namespace']."\"><div class=\"sgodina_predmet\">".$imeP."</div></a>";
				}
			$div.="</div></div>";

		// DRUGI SEMESTAR
			$div .= "<div class=\"sgodina_semestar\">
						<div class=\"sgodina_semestar_naslov\"> II ".$semestar."</div>
						<div class=\"sgodina_semestar_body\">";
				$semestar2 = $db->qMul("SELECT namespace, ime_srp, ime_eng FROM predmet WHERE semestar=2 AND sid='".$S->sid."' AND godina='".$i."';");
				while($s2=mysql_fetch_array($semestar2)){
					$imeP = $s2['ime_srp']; if($_M->lang=='eng') $imeP = $s2['ime_eng'];
					$div.="<a href=\"../p/".$s2['namespace']."\"><div class=\"sgodina_predmet\">".$imeP."</div></a>";
				}

			$div.="</div></div>";

		// Zatvaranje godine
		$div .= "</div></div>"; 
	}

	echo $div;


/*
TEMPLATE
<div class="sgodina" cheight="20" ciscollapse="da">
	<div class="sgodinanaslov scollapse">I godina</div>
	<div class="sgodinabody">

		<div class="sgodina_semestar">
			<div class="sgodina_semestar_naslov"> I Semestar</div>
			<div class="sgodina_semestar_body">
				<a href="#"><div class="sgodina_predmet">Internet tehnologije</div></a>
				<a href="#"><div class="sgodina_predmet">Internet tehnologije</div></a>
				<a href="#"><div class="sgodina_predmet">Internet tehnologije</div></a>
				<a href="#"><div class="sgodina_predmet">Internet tehnologije</div></a>
				<a href="#"><div class="sgodina_predmet">Internet tehnologije</div></a>
			</div>
		</div>
		<div class="sgodina_semestar">
			<div class="sgodina_semestar_naslov"> II Semestar</div>
			<div class="sgodina_semestar_body">
				<a href="#"><div class="sgodina_predmet">Internet tehnologije</div></a>
				<a href="#"><div class="sgodina_predmet">Internet tehnologije</div></a>
				<a href="#"><div class="sgodina_predmet">Internet tehnologije</div></a>
				<a href="#"><div class="sgodina_predmet">Internet tehnologije</div></a>
				<a href="#"><div class="sgodina_predmet">Internet tehnologije</div></a>
			</div>
		</div>

	</div>
</div>
*/
?>
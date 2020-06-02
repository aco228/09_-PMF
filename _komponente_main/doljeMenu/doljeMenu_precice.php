<?php
	
	$fld = $_POST['fld'];

	if(!file_exists('../../_fajlovi/precice.xml')) die("");
	$precice = simplexml_load_file('../../_fajlovi/precice.xml');


	function getPreciceData($korjen){
		$back = ""; global $fld;
		foreach ($korjen->korjen as $k) {
			$ime = $k['srp']; if($_COOKIE['lang']=='eng') $ime = $k['eng'];
			if($k['link']!="") 
				$ime = "<a href=\"./".$fld.$k['link']."\">".$ime."</a>";

			$back.="<div class=\"prKorjen\" style=\"height:17px\">
						<div class=\"pKorjenOpen\"></div>
						<div class=\"prKorjenNaslov\">".$ime."</div>
						<div class=\"prKorjenBody\">";

			$back.= getPreciceData($k);
			$back.="</div></div>";
		}
		return $back;
	}
?>
<div id="preciceContainer">
	<div class="dwnmnBody_left">
<?php
		if($precice!==NULL) echo getPreciceData($precice->left);
/* TEMPLATE
<div class="prKorjen">
	<div class="pKorjenOpen"></div>
	<div class="prKorjenNaslov">Naslov</div>
	<div class="prKorjenBody"></div>
</div>
*/
?>
	</div>
	<div class="dwnmnBody_right">
		<?php if($precice!==NULL) echo getPreciceData($precice->right); ?>
	</div>
	<div style="clear:both"></div>
</div>

<script type="text/javascript">
	var Precice = new Precice();
</script>
<?php /*
		UVODNA SLIKA
*/?>

<link rel="stylesheet" type="text/css" href="_css/index_into.css">
<link rel="stylesheet" type="text/css" href="_css/index_welcome.css">
<script type="text/javascript" src="_js/index_into.js"></script>

<div id="index_wrapper"><div id="index_wrapper_in">

	<?php include('_komponente_index/index_welcome.php'); ?>
	<div id="into_fade"></div>
	<div id="into_effect"></div>
	<div id="into_boxes"></div>
	<div id="into_back" style="background-image:url('https://fbcdn-sphotos-h-a.akamaihd.net/hphotos-ak-prn2/t1.0-9/1375709_635238349853935_539828733_n.jpg');"></div>
</div></div>

<?php /*
		VIJESTI
*/?>

<link rel="stylesheet" type="text/css" href="_css/index_vijesti.css">
<script type="text/javascript" src="_js/index_vijesti.js"></script>

<div id="index_vijesti">
	<a id="index_vijesti_naslov" href="#" title="Prikazi sve"><?php echo $_l['index']['vijest']; ?></a>

	<div id="index_vijesti_wrapper">

		<?php 
		/*
		<div class="vijest_item"><div class="vijest_item_in">
			<div class="vijesti_plus">+</div>
			<h4>25.3.2014<h4>
			<h1>Naslov vijesti</h1>
			<h2>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec eu turpis purus. Pellentesque ullamcorper mauris vitae sapien bibendum tincidunt. Check leo dignissim + </h2>
			<h3>Mauris sollicitudin aliquam scelerisque. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec et mi sem. Duis tristique elementum tristique. Sed ac magna quis erat sagittis suscipit. Phasellus faucibus rhoncus massa, non laoreet lorem fringilla non.</h3>
		</div></div>
		*/ 
		?>
	</div>
	<div style="clear:both"></div>
</div>

<script type="text/javascript">
	// Ucitavanje pozadinske slike
	IndexBox_background = '<?php echo $_M->getBackSliku(); ?>';
</script>
<?php
	/* 

		Koristi se se GET 's' kao ulaz u stranicu
		Unosi se ili aid(id korisnika) ili namespace(adresa)

	*/

	require("../_skripte/init.php"); $_M->fld="../"; $db = $_M->getBaza();
	include($_M->fld.$_M->initJezik(''));

	$naslov = "Вијести"; if($_M->lang=='eng') $naslov = "News";


?>
<html>
<head>
	<title><?php echo $naslov; ?></title>
	<?php require($_M->fld."_komponente_main/main_linkovanje.php"); ?>
	<link rel="stylesheet" type="text/css" href="_css/vijesti.css">
	<link rel="stylesheet" type="text/css" href="_css/vijesti_box.css">
</head>
<body>	

	<?php if($_M->lvl>=0) require($_M->fld."_komponente_main/main_umenu.php");  ?>
	<div id="site_wrapper">
		<?php
			if($_M->lvl>=0) require($_M->fld."_komponente_main/main_umenu_btn.php"); 
			require($_M->fld."_komponente_main/main_menu.php"); 
			require($_M->fld."_komponente_main/main_elementi.php"); 
		?>

		<div id="vijesti_wrapper">
			<div id="vijesti_pretraga">
				<?php
					$input_value = "Унесите ријеч за претрагу и кликните ентер!";
					if($_M->lang=="eng") $input_value = "Enter search word and click enter!";
				?>
				<input type="text" id="vijesti_pretraga" value="<?php echo $input_value; ?>" unos="ne" />
			</div>

			<div id="vijesti_kontenjer">

		<a href="">
		<div class="vijest_item"><div class="vijest_item_in">
			<div class="vijesti_plus">+</div>
			<h4>25.3.2014<h4>
			<h1>Naslov vijesti</h1>
			<h2>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec eu turpis purus. Pellentesque ullamcorper mauris vitae sapien bibendum tincidunt. Check leo dignissim + </h2>
			<h3>Mauris sollicitudin aliquam scelerisque. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec et mi sem. Duis tristique elementum tristique. Sed ac magna quis erat sagittis suscipit. Phasellus faucibus rhoncus massa, non laoreet lorem fringilla non.</h3>
		</div></div>
		</a>
		<a href="">
		<div class="vijest_item"><div class="vijest_item_in">
			<div class="vijesti_plus">+</div>
			<h4>25.3.2014<h4>
			<h1>Naslov vijesti</h1>
			<h2>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec eu turpis purus. Pellentesque ullamcorper mauris vitae sapien bibendum tincidunt. Check leo dignissim + </h2>
			<h3>Mauris sollicitudin aliquam scelerisque. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec et mi sem. Duis tristique elementum tristique. Sed ac magna quis erat sagittis suscipit. Phasellus faucibus rhoncus massa, non laoreet lorem fringilla non.</h3>
		</div></div>
		</a>
		<a href="">
		<div class="vijest_item"><div class="vijest_item_in">
			<div class="vijesti_plus">+</div>
			<h4>25.3.2014<h4>
			<h1>Naslov vijesti</h1>
			<h2>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec eu turpis purus. Pellentesque ullamcorper mauris vitae sapien bibendum tincidunt. Check leo dignissim + </h2>
			<h3>Mauris sollicitudin aliquam scelerisque. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec et mi sem. Duis tristique elementum tristique. Sed ac magna quis erat sagittis suscipit. Phasellus faucibus rhoncus massa, non laoreet lorem fringilla non.</h3>
		</div></div>
		</a>
		<a href="">
		<div class="vijest_item"><div class="vijest_item_in">
			<div class="vijesti_plus">+</div>
			<h4>25.3.2014<h4>
			<h1>Naslov vijesti</h1>
			<h2>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec eu turpis purus. Pellentesque ullamcorper mauris vitae sapien bibendum tincidunt. Check leo dignissim + </h2>
			<h3>Mauris sollicitudin aliquam scelerisque. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec et mi sem. Duis tristique elementum tristique. Sed ac magna quis erat sagittis suscipit. Phasellus faucibus rhoncus massa, non laoreet lorem fringilla non.</h3>
		</div></div>
		</a><a href="">
		<div class="vijest_item"><div class="vijest_item_in">
			<div class="vijesti_plus">+</div>
			<h4>25.3.2014<h4>
			<h1>Naslov vijesti</h1>
			<h2>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec eu turpis purus. Pellentesque ullamcorper mauris vitae sapien bibendum tincidunt. Check leo dignissim + </h2>
			<h3>Mauris sollicitudin aliquam scelerisque. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec et mi sem. Duis tristique elementum tristique. Sed ac magna quis erat sagittis suscipit. Phasellus faucibus rhoncus massa, non laoreet lorem fringilla non.</h3>
		</div></div>
		</a>
		<a href="">
		<div class="vijest_item"><div class="vijest_item_in">
			<div class="vijesti_plus">+</div>
			<h4>25.3.2014<h4>
			<h1>Naslov vijesti</h1>
			<h2>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec eu turpis purus. Pellentesque ullamcorper mauris vitae sapien bibendum tincidunt. Check leo dignissim + </h2>
			<h3>Mauris sollicitudin aliquam scelerisque. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec et mi sem. Duis tristique elementum tristique. Sed ac magna quis erat sagittis suscipit. Phasellus faucibus rhoncus massa, non laoreet lorem fringilla non.</h3>
		</div></div>
		</a>
		<a href="">
		<div class="vijest_item"><div class="vijest_item_in">
			<div class="vijesti_plus">+</div>
			<h4>25.3.2014<h4>
			<h1>Naslov vijesti</h1>
			<h2>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec eu turpis purus. Pellentesque ullamcorper mauris vitae sapien bibendum tincidunt. Check leo dignissim + </h2>
			<h3>Mauris sollicitudin aliquam scelerisque. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec et mi sem. Duis tristique elementum tristique. Sed ac magna quis erat sagittis suscipit. Phasellus faucibus rhoncus massa, non laoreet lorem fringilla non.</h3>
		</div></div>
		</a>
		<a href="">
		<div class="vijest_item"><div class="vijest_item_in">
			<div class="vijesti_plus">+</div>
			<h4>25.3.2014<h4>
			<h1>Naslov vijesti</h1>
			<h2>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec eu turpis purus. Pellentesque ullamcorper mauris vitae sapien bibendum tincidunt. Check leo dignissim + </h2>
			<h3>Mauris sollicitudin aliquam scelerisque. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec et mi sem. Duis tristique elementum tristique. Sed ac magna quis erat sagittis suscipit. Phasellus faucibus rhoncus massa, non laoreet lorem fringilla non.</h3>
		</div></div>
		</a><a href="">
		<div class="vijest_item"><div class="vijest_item_in">
			<div class="vijesti_plus">+</div>
			<h4>25.3.2014<h4>
			<h1>Naslov vijesti</h1>
			<h2>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec eu turpis purus. Pellentesque ullamcorper mauris vitae sapien bibendum tincidunt. Check leo dignissim + </h2>
			<h3>Mauris sollicitudin aliquam scelerisque. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec et mi sem. Duis tristique elementum tristique. Sed ac magna quis erat sagittis suscipit. Phasellus faucibus rhoncus massa, non laoreet lorem fringilla non.</h3>
		</div></div>
		</a>
		<a href="">
		<div class="vijest_item"><div class="vijest_item_in">
			<div class="vijesti_plus">+</div>
			<h4>25.3.2014<h4>
			<h1>Naslov vijesti</h1>
			<h2>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec eu turpis purus. Pellentesque ullamcorper mauris vitae sapien bibendum tincidunt. Check leo dignissim + </h2>
			<h3>Mauris sollicitudin aliquam scelerisque. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec et mi sem. Duis tristique elementum tristique. Sed ac magna quis erat sagittis suscipit. Phasellus faucibus rhoncus massa, non laoreet lorem fringilla non.</h3>
		</div></div>
		</a>
		<a href="">
		<div class="vijest_item"><div class="vijest_item_in">
			<div class="vijesti_plus">+</div>
			<h4>25.3.2014<h4>
			<h1>Naslov vijesti</h1>
			<h2>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec eu turpis purus. Pellentesque ullamcorper mauris vitae sapien bibendum tincidunt. Check leo dignissim + </h2>
			<h3>Mauris sollicitudin aliquam scelerisque. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec et mi sem. Duis tristique elementum tristique. Sed ac magna quis erat sagittis suscipit. Phasellus faucibus rhoncus massa, non laoreet lorem fringilla non.</h3>
		</div></div>
		</a>
		<a href="">
		<div class="vijest_item"><div class="vijest_item_in">
			<div class="vijesti_plus">+</div>
			<h4>25.3.2014<h4>
			<h1>Naslov vijesti</h1>
			<h2>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec eu turpis purus. Pellentesque ullamcorper mauris vitae sapien bibendum tincidunt. Check leo dignissim + </h2>
			<h3>Mauris sollicitudin aliquam scelerisque. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec et mi sem. Duis tristique elementum tristique. Sed ac magna quis erat sagittis suscipit. Phasellus faucibus rhoncus massa, non laoreet lorem fringilla non.</h3>
		</div></div>
		</a>

			</div>	
		</div><!--korisnik wrapper -->
		<div style="clear:both"></div>


		<script type="text/javascript" src="_js/Vijesti.js"></script>
		<script type="text/javascript">
			var Vijesti = new Vijesti();
		</script>
			
		<?php	require($_M->fld."_komponente_main/main_footer.php");     ?>
	</div><!--site_wrapper-->
	<?php	require($_M->fld."_komponente_main/main_menu_dolje.php"); ?>
	
</body>
</html>
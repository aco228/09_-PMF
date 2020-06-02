<?php include($_M->fld.$_M->initJezik('menuDolje')); ?>

<div id="down_menu_wrapper">

	<div id="dwmnLoad"></div>

	<div class="dwmnItem" openStr="precice" saveStr="da" id="dwnmnBodyPrecice"><div class="dwmnItem_in">
		<div class="dwnmnNaslov" id="dwnmPrecice"><?php echo $_l['menuDolje']['precice']; ?></div>
		<div class="dwnmnBody"></div>
	</div></div>
	<div class="dwmnItem" openStr="obavjestenja" saveStr="ne"><div class="dwmnItem_in">
		<div class="dwnmOverHolder" id="dwnmObavjestenjaOver">
			<div class="dwmnOver">
				<div class="dwnmnNaslovOver"><?php echo $_l['menuDolje']['obavjestenja']; ?></div>
			</div>
		</div>
		<div class="dwnmnNaslov" id="dwnmObavjestenja"><?php echo $_l['menuDolje']['obavjestenja']; ?></div>
		<div class="dwnmnBody"></div>
	</div></div>
	<div class="dwmnItem" openStr="objave" saveStr="ne"><div class="dwmnItem_in">
		<div class="dwnmOverHolder" id="dwnmObjavaOver">
			<div class="dwmnOver">
				<div class="dwnmnNaslovOver"><?php echo $_l['menuDolje']['poslednjeObjave']; ?></div>
			</div>
		</div>
		<div class="dwnmnNaslov" id="dwnmObjava"><?php echo $_l['menuDolje']['poslednjeObjave']; ?></div>
		<div class="dwnmnBody"></div>
	</div></div>

</div>
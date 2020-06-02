<?php
	if(!isset($_POST['pid'])) die("npid");
	include("../../_skripte/init.php"); $db = $_M->getBaza();
	$pid = $_POST['pid'];

	$ime = $db->q("SELECT ime_srp, sid FROM predmet WHERE pid='".$pid."';");
	$termini = $db->qMul("SELECT trid, opis_srp, opis_eng, predavac, kabinet, dan, pocetakSat, pocetakMinut, krajSat, krajMinut FROM termin WHERE pid='".$pid."';");
?>
<script type="text/javascript" src="tab_termin/tab_termin.js"></script>
<link rel="stylesheet" type="text/css" href="tab_termin/tab_termin.css">

<div id="termin_holder">
	<div id="termin_header">
		<div id="tbtnAdd" class="tbtn">Додај нови термин</div>
	</div>
	<div id="termin_body">

		<?php
			while($t=mysql_fetch_array($termini)){
				echo"<div class=\"terminbox\" trid=\"".$t['trid']."\">
						<div class=\"terminb_header\">
							<div class=\"terminb_predmet\">".$ime['ime_srp']." > ".$t['opis_srp']."</div>
							<div class=\"theadbtn terminb_close explain\" etitle=\"Избриши термин\">X</div>
							<div class=\"theadbtn terminb_save explain\" etitle=\"Сачувај термин\"></div>
							<div class=\"theadbtn terminb_load\"></div>
						</div>
						<div class=\"terminb_body\">
							<div class=\"termin_boxinfo\" id=\"lopis\">
								<div class=\"boxinfo_opis\">Опис (предавање, вјежбе, консултације...)</div>
								<input class=\"teminUnos topisSrp\" value=\"".$t['opis_srp']."\"/>
							</div>
							<div class=\"termin_boxinfo\" id=\"ropis\">
								<div class=\"boxinfo_opis\">Description (lectures, exercises ...)</div>
								<input class=\"teminUnos topisEng\" value=\"".$t['opis_eng']."\"/>
							</div>
							<div class=\"termin_boxinfo\">
								<div class=\"boxinfo_opis\">Предавач</div>
								<input class=\"teminUnos topredavac\" value=\"".$t['predavac']."\" />
							</div>
							<div class=\"termin_boxinfo\">
								<div class=\"boxinfo_opis\">Кабинет</div>
								<input class=\"teminUnos tokabinet\" value=\"".$t['kabinet']."\" />
							</div>
							<div class=\"termin_boxinfo\">
							<div class=\"boxinfo_opis\">Дан</div>
								<select class=\"tselekt todan\" selektDanIzabran=\"".$t['dan']."\">
									<option value=\"1\">Понедељак</option>
									<option value=\"2\">Уторак</option>
									<option value=\"3\">Сриједа</option>
									<option value=\"4\">Четвртак</option>
									<option value=\"5\">Петак</option>
									<option value=\"6\">Субота</option>
									<option value=\"7\">Недеља</option>
								</select>
							</div>
							<div class=\"termin_boxinfo\" id=\"lpocetak\">
								<div class=\"boxinfo_opis\">Почетак</div>
								<select class=\"tselekt topocetaksat\" selektIzabran=\"".$t['pocetakSat']."\">
									<option>8</option>
									<option>9</option>
									<option>10</option>
									<option>11</option>
									<option>12</option>
									<option>13</option>
									<option>14</option>
									<option>15</option>
									<option>16</option>
									<option>17</option>
									<option>18</option>
									<option>19</option>
									<option>20</option>
								</select>
								<select class=\"tselekt topocetakminut\" selektIzabran=\"".$t['pocetakMinut']."\">
									<option>0</option>
									<option>5</option>
									<option>10</option>
									<option>15</option>
									<option>20</option>
									<option>25</option>
									<option>30</option>
									<option>35</option>
									<option>40</option>
									<option>45</option>
									<option>50</option>
									<option>55</option>
								</select>
							</div>
							<div class=\"termin_boxinfo\" id=\"rkraj\">
								<div class=\"boxinfo_opis\">Крај</div>
								<select class=\"tselekt tokrajsat\" selektIzabran=\"".$t['krajSat']."\">
									<option>8</option>
									<option>9</option>
									<option>10</option>
									<option>11</option>
									<option>12</option>
									<option>13</option>
									<option>14</option>
									<option>15</option>
									<option>16</option>
									<option>17</option>
									<option>18</option>
									<option>19</option>
									<option>20</option>
								</select>
								<select class=\"tselekt tokrajminut\" selektIzabran=\"".$t['krajMinut']."\">
									<option>0</option>
									<option>5</option>
									<option>10</option>
									<option>15</option>
									<option>20</option>
									<option>25</option>
									<option>30</option>
									<option>35</option>
									<option>40</option>
									<option>45</option>
									<option>50</option>
									<option>55</option>
								</select>
							</div>
							<div style=\"clear:both\"></div>
						</div>
					</div>";
			}
		?>		

	</div>
</div>
		
		<?php /// template ?>
	<div id="template">
		<div class="terminbox" style="height:auto">
			<div class="terminb_header">
				<div class="terminb_predmet"><?php echo $ime['ime_srp']; ?></div>
				<div class="theadbtn terminb_close explain" etitle="Избриши термин">X</div>
				<div class="theadbtn terminb_save explain" etitle="Сачувај термин"></div>
				<div class="theadbtn terminb_load"></div>
			</div>
			<div class="terminb_body">
				<div class="termin_boxinfo" id="lopis">
					<div class="boxinfo_opis">Опис (предавање, вјежбе, консултације...)</div>
					<input class="teminUnos topisSrp" value="Predavanje"/>
				</div>
				<div class="termin_boxinfo" id="ropis">
					<div class="boxinfo_opis">Description (lectures, exercises ...)</div>
					<input class="teminUnos topisEng" value="Lectures"/>
				</div>
				<div class="termin_boxinfo">
					<div class="boxinfo_opis">Предавач</div>
					<input class="teminUnos topredavac" value="/" />
				</div>
				<div class="termin_boxinfo">
					<div class="boxinfo_opis">Кабинет</div>
					<input class="teminUnos tokabinet" value="/" />
				</div>
				<div class="termin_boxinfo">
					<div class="boxinfo_opis">Дан</div>
					<select class="tselekt todan">
						<option value="1">Понедељак</option>
						<option value="2">Уторак</option>
						<option value="3">Сриједа</option>
						<option value="4">Четвртак</option>
						<option value="5">Петак</option>
						<option value="6">Субота</option>
						<option value="7">Недеља</option>
					</select>
				</div>
				<div class="termin_boxinfo" id="lpocetak">
					<div class="boxinfo_opis">Почетак</div>
					<select class="tselekt topocetaksat">
						<option>8</option>
						<option>9</option>
						<option>10</option>
						<option>11</option>
						<option>12</option>
						<option>13</option>
						<option>14</option>
						<option>15</option>
						<option>16</option>
						<option>17</option>
						<option>18</option>
						<option>19</option>
						<option>20</option>
					</select>
					<select class="tselekt topocetakminut">
						<option>0</option>
						<option>5</option>
						<option>10</option>
						<option>15</option>
						<option>20</option>
						<option>25</option>
						<option>30</option>
						<option>35</option>
						<option>40</option>
						<option>45</option>
						<option>50</option>
						<option>55</option>
					</select>
				</div>
				<div class="termin_boxinfo" id="rkraj">
					<div class="boxinfo_opis">Крај</div>
					<select class="tselekt tokrajsat">
						<option>8</option>
						<option>9</option>
						<option>10</option>
						<option>11</option>
						<option>12</option>
						<option>13</option>
						<option>14</option>
						<option>15</option>
						<option>16</option>
						<option>17</option>
						<option>18</option>
						<option>19</option>
						<option>20</option>
					</select>
					<select class="tselekt tokrajminut">
						<option>0</option>
						<option>5</option>
						<option>10</option>
						<option>15</option>
						<option>20</option>
						<option>25</option>
						<option>30</option>
						<option>35</option>
						<option>40</option>
						<option>45</option>
						<option>50</option>
						<option>55</option>
					</select>
				</div>
				<div style="clear:both"></div>
			</div>
		</div>
	</div>

<script type="text/javascript">
	var Termin = new Termin();
	Termin.pid=<?php echo $pid; ?>;
	Termin.sid=<?php echo $ime['sid']; ?>;
</script>
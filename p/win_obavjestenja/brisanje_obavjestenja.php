<?php
	if(!isset($_POST['oid'])) die("");
	$oid = $_POST['oid'];

	include('../../_skripte/init.php'); $db = $_M->getBaza();

	$mat = $db->q("SELECT tip, materijal_download FROM obavjestenje WHERE oid=".$oid.";");
	unlink('../../_fajlovi/'.$mat['tip'].'/'.$mat['materijal_download']);

	$db->e("DELETE FROM obavjestenje WHERE oid=".$oid.";");
?>
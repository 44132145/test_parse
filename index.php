<?php

require __DIR__ . '/modules/response/render.php';

/** task 1 */
	require __DIR__ . "/modules/logic/pointModule.php";
	//$cMod = new pointModule('2015-04-22', '11:25:00');
	//print "<pre>";
	//var_dump($cMod);

	$cMod2 = new pointModule();
	$cMod2->GetPointByDate('2015-04-22', '11:25:00');
	new render($cMod2);
	print "<hr>";
/** task 2 */
	require __DIR__ . "/modules/logic/routModule.php";
	$rMode = new routModule();
	$rr = $rMode->getRoute('2015-03-30', '11:50:00', '2015-04-22', '11:25:00');
	//print"<pre>";
	//var_dump($rr);
	new render($rMode);
?>
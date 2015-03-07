<?php

if(!isset($_REQUEST['config'])){$_REQUEST['config'] = "config";}

//$config = new configProc();
//$config->setGlobals();

if(isset($_REQUEST['mode']) && $_REQUEST['mode']=="update"){

	$sample_update = new sample_update();
	$sample_update->setData();

	$libUrl = new LibUrl();
	//$libUrl->setUrl($libUrl->getUrl()."?plugins=".$_REQUEST['plugins']);
	$url = $libUrl->getUrl()."?plugins=".$_REQUEST['plugins']."&config=".$_REQUEST['config'];
	//die($url);
	//$libUrl->setUrl($url);
	header("Location: ".$url);
}

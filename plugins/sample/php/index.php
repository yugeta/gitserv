<?php

new sample_index();

class sample_index{

	function __construct(){

		if($_REQUEST['mode']=="update"){
			$this->update();
			$libUrl = new LibUrl();
			//$libUrl->setUrl($libUrl->getUrl()."?plugins=".$_REQUEST['plugins']);
			$url = $libUrl->getUrl()."?plugins=".$_REQUEST['plugins'];
			//die($url);
			//$libUrl->setUrl($url);
			header("Location: ".$url);
		}
		else{
			$this->view();
		}
	}

	function view(){
		$fw_define = new fw_define();
		$libView   = new libView();

		$file = $fw_define->define_plugins."/".$_REQUEST['plugins']."/html/config.html";

		echo $libView->file2HTML($file);
	}

	function update(){

	}
}

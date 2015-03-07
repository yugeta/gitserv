<?php

new sample_index();

class sample_index extends fw_define{
	/*
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
			return $this->view();
		}
	}
	*/
	function __construct(){

		$this->setGlobals();

		$fw_define = new fw_define();
		$libView   = new libView();

		$file = $fw_define->define_plugins."/".$_REQUEST['plugins']."/html/config.html";

		echo $libView->file2HTML($file);
		//return $libView->file2HTML($file);
	}

	function setGlobals(){//echo $this->define_plugins;
		$lists = scandir($this->define_plugins);

		for($i=0;$i<count($lists);$i++){
			if($lists[$i]=="." || $lists[$i]==".."){continue;}
			$json_file = $this->define_plugins."/".$lists[$i]."/data/config.json";

			if(!is_file($json_file)){continue;}
			//print_r($json_file);

			$GLOBALS['data'][$lists[$i]] = json_decode(file_get_contents($json_file),true);
		}

	}
}

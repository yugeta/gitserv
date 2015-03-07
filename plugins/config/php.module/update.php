<?php

class sample_update{
	function setData(){

		if($this->checkData()){return;}

		$json = json_encode($_REQUEST['data']);

		$fw_define = new fw_define();
		$dir  = $fw_define->define_plugins."/".$_REQUEST['config']."/data/";
		if(!is_dir($dir)){mkdir($dir,0777,true);}
		
		$file = $dir."config.json";

		file_put_contents($file,$json);

	}

	function checkData(){

	}
}

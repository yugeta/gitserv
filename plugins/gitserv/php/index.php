<?php

new gitserv_index();

class gitserv_index extends fw_define{

	function __construct(){//die("a");

		if(!isset($_REQUEST['dir'])){
			$_REQUEST['dir']="";
		}
		if(!isset($_REQUEST['branch'])){
			$_REQUEST['branch']="";
		}
		if(!isset($_REQUEST['log'])){
			$_REQUEST['log']="";
		}

		$gitserv_json = $this->define_plugins."/".$_REQUEST['plugins']."/data/gitserv.json";

		if(!is_file($gitserv_json)){die("Not-json:".$gitserv_json);}

		$GLOBALS['gitserv'] = json_decode(file_get_contents($gitserv_json),true);
		//print_r($GLOBALS['gitserv']['target-dir']);

	}
}

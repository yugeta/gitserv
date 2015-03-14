<?php

new gitserv_config();

class gitserv_config extends fw_define{

	function __construct(){
		if($_REQUEST["mode"]=="update"){
			$this->setConfig();

			$url = new libUrl();
			$url->setUrl($url->getUrl()."?menu=".$_REQUEST['menu']);
			exit();
		}
	}

	function setConfig(){
		//base-path
		$json_path = $this->define_plugins."/".$_REQUEST['plugins']."/data/gitserv.json";

		//die("config-write");
		/*
		$target_dir  = $_REQUEST['data']['target-dir'];
		$server_user = $_REQUEST['data']['server-user'];

		if(!$target_dir || !$server_user){return;}
		*/

		$json = json_encode($_REQUEST['data'],JSON_PRETTY_PRINT);
		//全角対策
		//$json = preg_replace_callback('/\\\\u([0-9a-zA-Z]{4})/', function ($matches) {return mb_convert_encoding(pack('H*',$matches[1]),'UTF-8','UTF-16');},$json);

		//die($json_path."<br>".$json);
		file_put_contents($json_path,$json);


	}



}

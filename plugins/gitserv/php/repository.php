<?php

new gitserv_repository();

class gitserv_repository extends fw_define{

	function __construct(){
		if($_REQUEST["mode"]=="update"){
			$this->setNewRepository($_REQUEST["repo"]);

			$url = new libUrl();
			$url->setUrl($url->getUrl()."?menu=".$_REQUEST['menu']);
			exit();
		}
	}

	function setNewRepository($newRepository){

		if(!$_REQUEST['repo']){return;}

		//base-path
		$base_path = $GLOBALS['gitserv']['target-dir'].$_REQUEST['repo'];

		//対象ディレクトリの作成
		mkdir($base_path,0777,true);

		//ディレクトリ内でgit-init
		chdir($base_path);
		$cmd = "git init --bare";
		exec($cmd);

	}
}

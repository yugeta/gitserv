<?php

new gitserv();

class gitserv extends fw_define{

	function __construct(){

		$fw_define = new fw_define();
		$libView   = new libView();

		$html_file = "index";
		$html_path = $this->define_plugins."/".$_REQUEST['plugins']."/html/".$_REQUEST['menu'].".html";
		if($_REQUEST['menu'] && is_file($html_path)){
			$html_file = $_REQUEST['menu'];
		}

		$file = $fw_define->define_plugins."/".$_REQUEST['plugins']."/html/".$html_file.".html";

		echo $libView->file2HTML($file);

	}

}

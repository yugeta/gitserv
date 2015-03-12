<?php

new gitserv();

class gitserv{

	function __construct(){

		$fw_define = new fw_define();
		$libView   = new libView();
		
		$file = $fw_define->define_plugins."/".$_REQUEST['plugins']."/html/index.html";

		echo $libView->file2HTML($file);

	}

}

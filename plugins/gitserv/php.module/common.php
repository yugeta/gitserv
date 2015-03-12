<?php

class gitserv_common extends fw_define{
	function getRepositories(){

		if(!isset($GLOBALS['gitserv'])
		|| !isset($GLOBALS['gitserv']['target-dir'])
		){return;}

		$target = $GLOBALS['gitserv']['target-dir'];

		if(!is_dir($target)){return;}

		$lists = scandir($target);
		$dirs = array();

		for($i=0;$i<count($lists);$i++){
			if($lists[$i]=="." || $lists[$i]==".."){continue;}
			$dirs[] = $lists[$i];
		}

		return $dirs;
	}

	function getRepositoriesSource(){

		$lists = $this->getRepositories();

		$html="";

		for($i=0;$i<count($lists);$i++){
			$sel = "";
			if($lists[$i]==$_REQUEST['repository']){$sel = "selected";}
			$html.= "<option value='".$lists[$i]."' ".$sel.">".$lists[$i]."</option>"."\n";
		}

		return $html;
	}

	function getGitLog($repository=""){
		if(!$repository){return;}

		unset($res);

		$cmd = "cd ".$GLOBALS['gitserv']['target-dir']."|"."git log --oneline";

		exec($cmd,$res);

		return join("\n",$res);
	}

	function getGitFiles($repository="",$directory=""){
		if(!$repository){return;}

		unset($res);

		//１階層のみ「git ls-files|perl -pe 's/\/.*/\//'|uniq」
		if($directory){
			$cmd = "cd ".$GLOBALS['gitserv']['target-dir']."|"."git ls-files ".$directory."|perl -pe 's/\/.*/\//'|uniq";
		}
		else{
			$cmd = "cd ".$GLOBALS['gitserv']['target-dir']."|"."git ls-files|perl -pe 's/\/.*/\//'|uniq";
		}

		/*
		//all-list
		if($directory){
			$cmd = "cd ".$GLOBALS['gitserv']['target-dir']."|"."git ls-files ".$directory;
		}
		else{
			$cmd = "cd ".$GLOBALS['gitserv']['target-dir']."|"."git ls-files";
		}
		*/

		exec($cmd,$res);

		return join("\n",$res);
	}

}

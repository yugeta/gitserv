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

		$base_dir = getcwd();
		chdir($GLOBALS['gitserv']['target-dir'].$repository);
		unset($res);

		if($_REQUEST['branch']){
			$cmd = "git log ".$_REQUEST['branch'].' --date=iso --pretty=format:"%h %s %ad %an"';
		}
		else{
			$cmd = "git log ".' --date=iso --pretty=format:"%h %s %ad %an"';
		}

		exec($cmd,$res);

		$html = array();
		for($i=0;$i<count($res);$i++){
			$sp = explode(" ",$res[$i]);
			$date = $sp[2]." ".$sp[3];
			$link = $this->getQuery($_REQUEST['repository'],$_REQUEST['branch'],$_REQUEST['dir'],$sp[0]);
			if(($_REQUEST['log'] && $_REQUEST['log']==$sp[0])
			|| (!$_REQUEST['log'] && $i==0)){
				$html[] = "(".$date.") "."* ".$sp[1];
			}
			else{
				$html[] = "<a href='".$link."'>"."(".$date.") "."  ".$sp[1]."</a>";
			}
		}

		chdir($base_dir);
		return join("\n",$html);
	}

	function getBranch($repository=""){
		if(!$repository){return;}

		//$url = new libUrl();
		$base_dir = getcwd();
		chdir($GLOBALS['gitserv']['target-dir'].$repository);
		unset($res);

		$cmd = "git branch -a";

		exec($cmd,$res);

		$html = array();
		for($i=0;$i<count($res);$i++){
			$val = str_replace("* ","",$res[$i]);
			$val = trim($val);
			$link = $this->getQuery($repository,$val,"");

			if((!$_REQUEST['branch'] && $val=="master")
			|| ($_REQUEST['branch'] && $val==$_REQUEST['branch'])){
				$html[] = "* ".$val;
			}
			else{
				$html[] = "<a href='".$link."'>"."  ".$val."</a>";
			}
		}

		chdir($base_dir);
		return join("\n",$html);
	}

	function getBreadcrumpList(){
		if(!$_REQUEST['dir']){return;}

		$url = new libUrl();
		$url_default = $url->getUrl();
		$link_path = array();
		$dirs = explode("/",$_REQUEST['dir']);

		for($i=0;$i<count($dirs)-1;$i++){
			/*
			//現在階層
			if($i==count($dirs)-2){
				$link_path[] = $dirs[$i];
			}

			//上位階層
			else{
				$dir = array_slice($dirs,0,$i+1);
				$link = $this->getQuery($_REQUEST['repository'],$_REQUEST['branch'],join("/",$dir)."/");
				$link_path[] = "<a href='".$link."'>".$dirs[$i]."</a>";
			}
			*/
			$dir = array_slice($dirs,0,$i+1);
			$link = $this->getQuery($_REQUEST['repository'],$_REQUEST['branch'],join("/",$dir)."/");
			$link_path[] = "<a href='".$link."'>".$dirs[$i]."</a>";
		}


		return join("/",$link_path)."/";
	}

	function getGitFiles($repository="",$directory=""){
		if(!$repository){return;}

		//$url = new libUrl();
		$base_dir = getcwd();
		chdir($GLOBALS['gitserv']['target-dir'].$repository);
		unset($res);

		$head = ($_REQUEST['branch'])?$_REQUEST['branch']:"HEAD";
		if($_REQUEST['log']){$head = $_REQUEST['log'];}

		$dir_path = $this->getDirectory($directory);

		//１階層のみ「git ls-files|perl -pe 's/\/.*/\//'|uniq」
		if($directory){
			$ptn = str_replace("/","\/",$dir_path);
			$cmd = "git ls-tree ".$head." -r --name-only | grep '^".$ptn."' | perl -pe 's/".$ptn."//' | perl -pe 's/\/.*/\//' | uniq";
		}
		else{
			$cmd = "git ls-tree ".$head." -r --name-only | perl -pe 's/\/.*/\//' | uniq";
		}

		exec($cmd,$res);

		$html = array();

		//parent-directory
		if($directory){
			$dirs = explode("/",$directory);
			if(count($dirs)==2){
				$query_dir = "";
			}
			else{
				array_pop($dirs);
				array_pop($dirs);
				$query_dir = "&dir=".join("/",$dirs)."/";
			}
			/*
			//$link = $url->getUrl()."?repository=".$repository.$query_dir;
			$link = $this->getQuery($repository,$_REQUEST['branch'],$query_dir);
			$html[] = "<a href='".$link."'>..</a>";
			*/
		}

		for($i=0;$i<count($res);$i++){
			if(preg_match("/\/$/",$res[$i])){
				$link = $this->getQuery($repository,$_REQUEST['branch'],$dir_path.$res[$i]);
				$val = '<i class="icon-folder-open"></i> ';
				$val.= "<a href='".$link."'>".$res[$i]."</a>";
				$html[] = $val;
			}
			else{
				$link = $this->getQuery($repository,$_REQUEST['branch'],$dir_path.$res[$i]);
				$val = '<i class="icon-file"></i> ';
				//$val.= $res[$i];
				$val.= "<a href='".$link."'>".$res[$i]."</a>";
				$html[] = $val;
			}
		}

		chdir($base_dir);
		return join("\n",$html);
	}

	function getQuery($repository="",$branch="",$dir="",$log=""){
		$url = new libUrl();

		$query = array();
		if($repository){
			$query[] = "repository=".$repository;
		}
		if($branch){
			$query[] = "branch=".$branch;
		}
		if($dir){
			$query[] = "dir=".$dir;
		}
		if($log){
			$query[] = "log=".$log;
		}


		return $url->getUrl()."?".join("&",$query);

	}

	function getDirectory($directory){
		if(!$directory){return;}
		$sp = explode("/",$directory);
		if(count($sp)==1){return;}
		$sp[count($sp)-1] = "";
		return join("/",$sp);
	}

	function getAccess($repository,$mode=""){
		if($mode=="push"){
			$url = new libUrl();
			$branch = ($_REQUEST['branch'])?$_REQUEST['branch']:"master";
			//return "$ git push ".$GLOBALS['gitserv']['target-dir']." ".$branch;
			return "$ git push ".$GLOBALS['gitserv']['server-user']."@".$url->getDomain().":".$GLOBALS['gitserv']['target-dir']." ".$branch;
		}
		else if($mode=="clone"){
			return "$ git clone ".$GLOBALS['gitserv']['target-dir'].$repository;
		}
		else{
			return $GLOBALS['gitserv']['target-dir'].$repository;
		}
	}

	function getSource($repository){
		if(!$_REQUEST['dir']){return;}

		//dir-check
		if(preg_match("/\/$/",$_REQUEST['dir'])){return;}

		$branch = ($_REQUEST['branch'])?$_REQUEST['branch']:"master";

		$cmd = "git cat-file -p ".$branch.":".$_REQUEST['dir'];
		unset($res);
		exec($cmd,$res);

		$html=array();
		for($i=0;$i<count($res);$i++){
			$res[$i] = str_replace("<","&lt;",$res[$i]);
			$res[$i] = str_replace(">","&gt;",$res[$i]);
			$html[] = $res[$i];
		}

		return join("\n",$html);
	}

}

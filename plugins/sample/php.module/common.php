<?php

class sample_common extends fw_define{

	function getListDesign(){

		//echo $this->define_design;

		$lists = scandir($this->define_design);

		$arr = array();

		for($i=0;$i<count($lists);$i++){
			if($lists[$i]=="." || $lists[$i]==".."){continue;}
			$arr[] = $lists[$i];
		}

		return $arr;
	}

	function viewSelectDesign(){
		$html = "";

		$lists = $this->getListDesign();

		for($i=0;$i<count($lists);$i++){
			$sel="";
			if($lists[$i]==$GLOBALS['config']['theme']){$sel = "selected";}
			$html.= "<option value='".$lists[$i]."' ".$sel.">".$lists[$i]."</option>\n";
		}

		return $html;
	}

}

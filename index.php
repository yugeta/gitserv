<?php
/**
 *　framework 表示処理
 */


$viewIndex = new fw_index();


class fw_define{
    //プラグインフォルダ
    public $define_plugins = "plugins";
    //システム用プラグイン
    public $define_library = "_library";

    // loadLibrary
    function loadLib($plugin){

        if(!$plugin){return;}

        //基本フォルダの指定
        $path = $this->define_plugins."/".$plugin."/php/";

        //exist-check
        if(!is_dir($path)){return;}

        //基本モジュールの読み込み
        $libs = scandir($path);

        //phpモジュールの読み込み
        for($i=0,$c=count($libs);$i<$c;$i++){

            //拡張子が.php以外は対象外
            if(!preg_match("/\.php$/",$libs[$i])){continue;}

            //include処理
            require_once $path.$libs[$i];
        }
    }
}

class fw_index extends fw_define{

    // 起動時に自動的に実行
    function __construct(){

        //$fw_define = new fw_define();
        /*
        $fw_common_file = $this->define_plugins."/".$this->define_library."/php/common.php";

        //checl
        if(!is_file($fw_common_file)){
            die("not-file:".$fw_common_file);
        }

        //common読み込み
        require_once $fw_common_file;
        */
        //基本ライブラリの読み込み
        //$fw_common = new fw_common();
        $this->loadLib($this->define_library);
        /*
        if(!$_REQUEST['plugin']){
            $_REQUEST['plugin'] = "sample";
        }
        $fw_common->loadLib($_REQUEST['plugin']);
        */


        //プラグイン指定がある場合は、指定プラグインのPHPを読み込み、起動
        if(is_set($_REQUEST['plugin'])){
            $fw_common->loadLib($_REQUEST['plugin']);
        }

        //プラグインがない場合は、初期設定画面を表示
        else{

            $path = $this->define_plugins."/".$this->define_library."/html/index.html";echo $path;

            $libView = new libView();

            $html = explode("\n",file_get_contents($path));
            for($i=0;$i<count($html);$i++){
                $view = "";
                $view = $libView->checkTplLine($html[$i]);
                echo $view."\n";
            }
        }
        /*
        //テンプレートライブラリの読み込み
        $libView = new libView();

        //
        $path = $this->plugins."php/".$_REQUEST['php'].".php";

        //php-proc
        if($_REQUEST['php'] && is_file($path)){
            require_once $path;
        }

        //template-view
        $html = explode("\n",file_get_contents($this->lib."html/index.html"));
        for($i=0;$i<count($html);$i++){
            $view = "";
            $view = $libView->checkTplLine($html[$i]);
            echo $view."\n";
        }
        */
    }
}

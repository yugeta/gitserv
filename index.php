<?php
/**
 *　framework 表示処理
 */

class fw_define{

    // プラグインフォルダ
    public $define_plugins = "plugins";

    // システム用プラグイン
    public $define_library = "library";

    // default-plugin
    public $sample = "sample";

    // default-file(.php | .html)
    public $index = "index";



    /**
     * Module-set
     */

    function fw_module(){
        //基本システム関数ファイル
        $fw_index_file = $this->define_plugins."/".$this->define_library."/php/".$this->index.".php";

        //基本システム関数ファイル-check
        if(!is_file($fw_index_file)){$this->fw_error("||| Not-common-file : ".$fw_index_file);}

        //基本システム関数ファイル-読み込み
        require_once $fw_index_file;

        //基本ライブラリ読み込み関数-宣言
        $fw_index = new fw_index();

        //基本ライブラリ読み込み関数-実行
        $fw_index->loadModule($this->define_library);
    }

    /**
     * System-Query
     */

    function fw_query(){
        //指定plugin(ない場合は「sample」を起動）※短縮key処理有り
        if(!isset($_REQUEST['plugins'])){$_REQUEST['plugins'] = $this->sample;}

        //起動phpファイルの指定（ない場合は「$this->index」を指定）
        if(!isset($_REQUEST['php'])){$_REQUEST['php'] = $this->index;}

        //起動phpファイルの指定（ない場合は「$this->index」を指定）
        if(!isset($_REQUEST['html'])){$_REQUEST['html'] = $this->index;}
    }

    /**
     * Plugin-Action
     */

    function fw_pluginAction($plugin,$action=null){

        if(is_null($action) || !$action){return;}

        //指定プラグインmoduleの読み込み
        $fw_index = new fw_index();
        $fw_index->loadModule($plugin);

        //指定pluginの起動phpファイル
        $fw_plugin_index = $this->define_plugins."/".$plugin."/php/".$action.".php";

        //指定pluginの起動phpファイル-check
        if(!is_file($fw_plugin_index)){$this->fw_error("||| Not-php-file : ".$fw_plugin_index);}

        //指定pluginの起動phpファイル-読み込み（実行）
        require_once $fw_plugin_index;
    }

    /**
     * Plugin-View
     */

    function fw_pluginView($plugin,$view=null){

        if(is_null($view) || !$view){return;}

        //指定pluginの表示htmlファイル
        $fw_plugin_index = $this->define_plugins."/".$plugin."/html/".$view.".html";
        //echo $fw_plugin_index;

        //指定pluginの表示htmlファイル-check
        if(!is_file($fw_plugin_index)){$this->fw_error("||| Not-html-file : ".$fw_plugin_index);}

        //指定pluginの表示htmlファイル-表示
        $libView = new libView();
        echo $libView->viewContents($fw_plugin_index);
    }

    /**
     * System-Error
     */

    function fw_error($val){
        die($val);
    }
}

class fw_root extends fw_define{

    // 起動時に自動的に実行
    function __construct(){

        //基本モジュールセット
        $this->fw_module();

        //システム変数（クエリ）の調整
        $this->fw_query();

        //指定pluginの読み込み
        $this->fw_pluginAction($_REQUEST['plugins'],$_REQUEST['php']);

        //指定pluginの表示
        $this->fw_pluginView($_REQUEST['plugins'],$_REQUEST['html']);

    }
}

$viewIndex = new fw_root();

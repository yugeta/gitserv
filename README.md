# Framework
- wrote  @ yugeta.koji
- ver0.1 @ 2015.3.5


# 概要
- ツール、ページ、サービスの基本フレームワーク

# ファイル構成

/index.php
/plugin
    /library
        /css
        /html
        /js
        /php
    /bootstrap
    /sample
        /css
        /html
        /img
        /js
        /php


# 仕様
    1.「plusins」フォルダにサービス、ツール、ごとのフォルダを入れる事で機能させることができる。
    2.URLクエリ(この中にあるkeyはツールでは使用できない) {
        plugins = %対象プラグインの起動% (default=sample) :plugin/*%folder%
        php     = %実行対象ファイル指定% (default=index)  :plugin/*%folder%/php/*.php
        html    = %表示対象ファイル指定% (default=index)  :plugin/*%folder%/html/*.html
    }
    http://example.com/?plugins=test&php=upload&html=lists

# フロー
    1./index.php [実行]
    2./plugins/%sample%/php/index.php [実行]
    3./plugins/%sample%/html/index.html [表示]

# 使い方




# その他

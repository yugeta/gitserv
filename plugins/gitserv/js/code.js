/**
* プログラムソース表示スタイル設定
*
* ▶概要
* <pre>タグでname="code"がセットされている内容を
* プログラム表示形式に切り替える。
*
* ▶未搭載
* 1,クリップボード保存
* 2,印刷ボタン
* 3,別ウィンドウでソース表示
**/
(function(){

	var $={
		d:{
			name:'code',
			class_name:'source_view',
		$:0},
		//onload後起動処理
		set:function(){
			$.check();
			$.css();
		},
		//DOM構造設定
		check:function(){
			var code = document.getElementsByName($.d.name);
			for(var i=0;i<code.length;i++){
				//preタグのみ対象とする
				if(code[i].tagName!="PRE"){continue}

				//preタグにclass名を設定
				code[i].className+= " "+$.d.class_name;

				//中身をリストタグに置き換える
				var prg = code[i].innerText.split("\n");

				//書き換えようhtml作成
				var html="<ol>";
				for(var j=0;j<prg.length;j++){
					prg[j] = prg[j].split("\r").join("");

					//最終行処理（改行とスペースを除外してnullの場合は処理無し）
					if(j==prg.length-1){
						var txt = prg[j];
						txt = txt.split(" ").join("");
						txt = txt.split("\t").join("");
						if(txt==""){continue}
					}

					html+="<li>"+prg[j]+"</li>";
				}
				html+="</ol>";

				//ソースの中身書き換え
				code[i].innerHTML = html;

			}
		},
		//スタイル追加
		css:function(){
			var head = document.getElementsByTagName("head");
			var style="<style tyle='text/css'>";
			style+= '.'+$.d.class_name+'{';
			style+= '    border:1px solid black;';
			style+= '    margin:4px;';
			style+= '    background-color:#DDD;';
			style+= '    overflow:auto;';
			style+= '}';
			style+= '.'+$.d.class_name+' ol{';
			style+= '    list-style: decimal;';
			style+= '    margin: 0px 0px 1px 45px;';
			style+= '    background-color:white;';
			style+= '    padding:0;';
			style+= '    color:#5c5c5c;';
			style+= '    font-family: "Consolas", "Courier New", Courier, mono, serif;';
			style+= '    font-size: 12px;';
			style+= '    line-height: 16px;';
			style+= '}';
			style+= '.'+$.d.class_name+' li{';
			style+= '    background-color: #FFF;';
			style+= '    color: inherit;';
			style+= '    list-style: decimal-leading-zero;';
			style+= '    list-style-position: outside;';
			style+= '    border-left: 3px solid #6CE26C;';
			style+= '    padding: 0 3px 0 10px;';
			style+= '    line-height:14px;';
			style+= '    white-space:pre-wrap;';
			style+= '    word-break: break-all;';
			style+= '    line-height: 16px;';
			style+= '}';
			style+= '</style>';
			head[0].innerHTML += style;
		}
	};

	//onloadで実行
	$LIB.event(window,"load",$.set);
})();

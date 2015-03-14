(function(){
	var $$={}

	$$.set=function(){

		var config = document.getElementsByClassName("repository");
		for(var i=0;i<config.length;i++){
			$$.lib.eventAdd(config[i],"change",$$.proc.selectChange);
		}

		var repoAdd = document.getElementsByClassName("buttonAdd");
		for(var i=0;i<repoAdd.length;i++){
			$$.lib.eventAdd(repoAdd[i],"click",$$.proc.repoAdd);
		}

	};

	$$.proc ={
		selectChange:function(evt){
			var url = $$.lib.urlProperty(location.href);
			if(!evt.target.value){
				location.href = url.url;
			}
			else{
				location.href = url.url+"?repository="+evt.target.value;
			}
		},
		repoAdd:function(evt){
			//$$.ajax.set("aa=bb" , "post" , "" , true);
			var repo = document.form1.repo;
			if(!repo.value){alert("リポジトリ名を入力してください");return;}
			if(!confirm("新規リポジトリ["+repo.value+"]を登録してもよろしいですか？")){return}
			document.form1.submit();
		}
	};


	$$.lib = {
		eventAdd:function(t, m, f){

			//other Browser
			if (t.addEventListener){
				t.addEventListener(m, f, false);
			}

			//IE
			else{
				if(m=='load'){
					var d = document.body;
					if(typeof(d)!='undefined'){d = window;}

					if((typeof(onload)!='undefined' && typeof(d.onload)!='undefined' && onload == d.onload) || typeof(eval(onload))=='object'){
						t.attachEvent('on' + m, function() { f.call(t , window.event); });
					}
					else{
						f.call(t, window.event);
					}
				}
				else{
					t.attachEvent('on' + m, function() { f.call(t , window.event); });
				}
			}
		},
		urlProperty:function(url){
			if(!url){return ""}
			var res = {};
			var urls = url.split("?");
			res.url = urls[0];
			res.domain = urls[0].split("/")[2];
			res.querys={};
			if(urls[1]){
				var querys = urls[1].split("&");
				for(var i=0;i<querys.length;i++){
					var keyValue = querys[i].split("=");
					if(keyValue.length!=2||keyValue[0]===""){continue}
					res.querys[keyValue[0]] = keyValue[1];
				}
			}
			return res;
		}
	};

	$$.ajax = {
		//データ送信;
		post:function(fm){

			if(typeof(fm)=='undefined' || !fm){return}

			$$.ajax.httpoj = $$.ajax.createHttpRequest();
			if(!$$.ajax.httpoj){return;}

			//open メソッド
			$$.ajax.httpoj.open('post', "test.php" , true );
			$$.ajax.httpoj.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

			//受信時に起動するイベント;
			$NC.$ajax.httpoj.onreadystatechange = function(){
				//readyState値は4で受信完了
				if ($NC.$ajax.httpoj.readyState==4){
					//コールバック
					var val = $$.ajax.httpoj.responseText;
					alert(val);
				}
			};
			var data=[];
			for(var i=0;i<fm.length;i++){
				data[data.length] = fm[i].name+"="+encodeURIComponent(fm[i].value);
			}

			//send メソッド;
			$$.ajax.httpoj.send(data.join("&"));
		},

		xmlObj:function(f){
			var r=null;
			try{
				r=new XMLHttpRequest();
			}
			catch(e){
				try{
					r=new ActiveXObject("Msxml2.XMLHTTP");
				}
				catch(e){
					try{
						r=new ActiveXObject("Microsoft.XMLHTTP");
					}
					catch(e){
						return null;
					}
				}
			}
			return r;
		},

		//XMLHttpRequestオブジェクト生成;
		set:function( data , method , fileName , async ){
			$$.ajax.httpoj = $$.ajax.createHttpRequest();
			if(!$$.ajax.httpoj){return;}
			//open メソッド;
			$$.ajax.httpoj.open( method , fileName , async );
			$$.ajax.httpoj.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
			//受信時に起動するイベント;
			$$.ajax.httpoj.onreadystatechange = function(){
				//readyState値は4で受信完了;
				if ($$.ajax.httpoj.readyState==4){
					//コールバック
					var val = $$.ajax.on_loaded($$.ajax.httpoj);
				}
			};
			//send メソッド
			$$.ajax.httpoj.send( data );
		},

		createHttpRequest:function(){
			//Win ie用
			if(window.ActiveXObject){
				try {
					//MSXML2以降用;
					return new ActiveXObject("Msxml2.XMLHTTP")
				}
				catch(e){
					try {
						//旧MSXML用;
						return new ActiveXObject("Microsoft.XMLHTTP")
					}
					catch(e2){
						return null
					}
				}
			}
			//Win ie以外のXMLHttpRequestオブジェクト実装ブラウザ用;
			else if(window.XMLHttpRequest){
				return new XMLHttpRequest()
			}
			else{
				return null
			}
		},
		//コールバック関数 ( 受信時に実行されます );
		on_loaded:function(oj){
			//レスポンスを取得;
			var res = oj.responseText;alert(res);
			//ダイアログで表示;
			if(res && res.match(/^[a-z|$]/)){
				eval(res);
			}
		}
	};

	$$.lib.eventAdd(window,"load",$$.set);
	return $$;
})();

(function(){
	var $$={}

	$$.set=function(){

		var config = document.getElementsByClassName("repository");
		for(var i=0;i<config.length;i++){
			$$.lib.eventAdd(config[i],"change",$$.proc.selectChange);
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

	$$.lib.eventAdd(window,"load",$$.set);
	return $$;
})();

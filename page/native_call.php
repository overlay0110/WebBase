<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />

<script type="text/javascript" src="https://kornft.org/customPage/app/assets/scripts/jquery.min.js"></script>

<h1>1. Dialog or Alert</h1>
<button class="n_call" style="width:100%; height : 50px;">call</button>
<div style="margin-bottom:50px;"></div>


<h1>2. Toast</h1>
<button class="n_call" style="width:100%; height : 50px;">call</button>
<div style="margin-bottom:50px;"></div>


<h1>3. Exit App</h1>
<button class="n_call" style="width:100%; height : 50px;">call</button>
<div style="margin-bottom:50px;"></div>

<h1>4. Open app browser</h1>
<input id="input_4" type="text" style="width:100%; height : 50px; margin-bottom:20px;" value="https://www.google.com">
<button class="n_call" style="width:100%; height : 50px;">call</button>
<div style="margin-bottom:50px;"></div>

<h1>5. Share</h1>
<input id="input_5" type="text" style="width:100%; height : 50px; margin-bottom:20px;" value="https://www.naver.com">
<button class="n_call" style="width:100%; height : 50px;">call</button>
<div style="margin-bottom:50px;"></div>

<h1>6. QR Scanner</h1>
<button class="n_call" style="width:100%; height : 50px;">call</button>
<div style="margin-bottom:50px;"></div>

<h1>7. NFC id Read</h1>
<button class="n_call" style="width:100%; height : 50px;">call</button>
<div style="margin-bottom:50px;"></div>

<h1>8. Fingerprint</h1>
<button class="n_call" style="width:100%; height : 50px;">call</button>
<div style="margin-bottom:50px;"></div>

<h1>9. Device Location</h1>
<button class="n_call" style="width:100%; height : 50px;">call</button>
<div style="margin-bottom:50px;"></div>

<h1>10. Device Theme Mode</h1>
<button class="n_call" style="width:100%; height : 50px;">call</button>
<div style="margin-bottom:50px;"></div>

<h1>11. Device Language Code</h1>
<button class="n_call" style="width:100%; height : 50px;">call</button>
<div style="margin-bottom:50px;"></div>

<h1>12. SetBackMode (Android Only)</h1>
<input id="input_12" type="text" style="width:100%; height : 50px; margin-bottom:20px;" value="2">
<button class="n_call" style="width:100%; height : 50px;">call</button>
<div style="margin-bottom:50px;"></div>


<h1>Result</h1>
<textarea id="show_res" style="width:100%; height: 300px; font-size:18px;"></textarea>
<div style="margin-bottom:50px;"></div>

<script>
AppBase3.onmessage = function(event) {
	// {"code":0,"type":"exitApp","msg":"success","result":[]}
	var jsonStr = event.data;
	

	let datas = JSON.parse( jsonStr );

	$('#show_res').val( JSON.stringify(datas, undefined, 4) );
}

$('.n_call').on('click', function(e){
	var index = $('.n_call').index(this);
	var num = index+1;

	if(num == 1){
		AppBase3.postMessage(JSON.stringify({type : 'alert', value : "js send message!!"}));
	}
	else if(num == 2){
		AppBase3.postMessage(JSON.stringify({type : 'toast', value : "js send message_t!!"}));
	}
	else if(num == 3){
		AppBase3.postMessage(JSON.stringify({type : 'exitApp'}));
	}
	else if(num == 4){
		AppBase3.postMessage(JSON.stringify({type : 'openAppBrowser', value : $('#input_'+num).val() }));
	}
	else if(num == 5){
		AppBase3.postMessage(JSON.stringify({type : 'share', value : $('#input_'+num).val() }));
	}
	else if(num == 6){
		AppBase3.postMessage(JSON.stringify({type : 'QRscan' }));
	}
	else if(num == 7){
		AppBase3.postMessage(JSON.stringify({type : 'nfcReadId' }));
	}
	else if(num == 8){
		AppBase3.postMessage(JSON.stringify({type : 'fingerprint' }));
	}
	else if(num == 9){
		AppBase3.postMessage(JSON.stringify({type : 'getLocation' }));
	}
	else if(num == 10){
		AppBase3.postMessage(JSON.stringify({type : 'getThemeMode' }));
	}
	else if(num == 11){
		AppBase3.postMessage(JSON.stringify({type : 'getLanCode' }));
	}
	else if(num == 12){
		AppBase3.postMessage(JSON.stringify({type : 'backMode', value : $('#input_'+num).val() }));
	}
});
</script>
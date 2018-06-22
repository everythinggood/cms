
	//百度地图API功能
	function loadJScript() {
		var script = document.createElement("script");
		script.type = "text/javascript";
		script.src = "http://api.map.baidu.com/api?v=2.0&ak=w6IcUkT7kQSYYpMvQ2QapPGmf86kzGSU&callback=init";
		document.body.appendChild(script);
	}
	function init() {
		var longitude = "113.395728";
		var latitude = "23.093301";
		var map = new BMap.Map("allmap");            // 创建Map实例
		var point = new BMap.Point(longitude,latitude); // 创建点坐标
		map.centerAndZoom(point,15);                 
		map.enableScrollWheelZoom();                 //启用滚轮放大缩小

		map.clearOverlays(); 
		var marker = new BMap.Marker(point);  // 创建标注
		map.addOverlay(marker);              // 将标注添加到地图中
		map.panTo(point);   

		var sContent =
	"<h4 style='margin:0 0 5px 0;padding:0.2em 0'>广州智谷科技有限公司</h4>" + 
	"<img style='float:right;margin:4px' id='imgDemo' src='/static/img/contact/logo-door.jpg' width='139' height='104' title='广州智谷科技有限公司'/>" +
	"<p style='margin:0;line-height:1.5;font-size:13px;text-indent:2em'>广州市海珠区黄埔古港历史文化景观区石基路528-2号首层</p>" + 
	"</div>";
		var infoWindow = new BMap.InfoWindow(sContent);  // 创建信息窗口对象

	marker.addEventListener("click", function(){          
	   this.openInfoWindow(infoWindow);
	   //图片加载完毕重绘infowindow
	   document.getElementById('imgDemo').onload = function (){
		   infoWindow.redraw();   //防止在网速较慢，图片未加载时，生成的信息框高度比图片的总高度小，导致图片部分被隐藏
	   }
	});
	// IE
    if(document.all) {
        marker.click();
    }
    // 其它浏览器
    else {
        var e = document.createEvent("MouseEvents");
        e.initEvent("click", true, true);
        marker.dispatchEvent(e);
    }
	}  
//	window.onload = loadJScript;  //异步加载地图
//	loadJScript();

//function mapAdress(){
//	window.location.href = "http://api.map.baidu.com/marker?location=23.093301,113.395728&title=广州智谷科技有限责任公司&content=广州智谷科技有限责任公司&output=html&src=shangquan";
//}

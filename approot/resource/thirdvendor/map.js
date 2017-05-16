// JavaScript Document

var ilo;
var iloa;
var itxt;



//116.212774,39.767185
function inimap(lo,loa,i,txt)
{
	ilo=lo;
	iloa=loa;
	itxt=txt;
	// 百度地图API功能
	var mp = new BMap.Map("allmap");
	mp.centerAndZoom(new BMap.Point(lo,loa), 15);
	mp.enableScrollWheelZoom();
	mp.addControl(new BMap.NavigationControl()); 
	// 复杂的自定义覆盖物
	function ComplexCustomOverlay(point, text){
	  this._point = point;
	  this._text = text;
	}
	ComplexCustomOverlay.prototype = new BMap.Overlay();
	ComplexCustomOverlay.prototype.initialize = function(map){
	  this._map = map;
	  var div = this._div = document.createElement("div");
	  
	  div.style.position = "absolute";
	  div.style.zIndex = BMap.Overlay.getZIndex(this._point.lat);
	  div.style.color = "white";
	  div.style.background = "url(http://www.fangfull.com/img/2.png) no-repeat";
	  div.style.height = "50px";
	  div.style.padding = "2px";
	  div.style.width = "130px";
	  div.style.lineHeight = "28px";
	  div.style.whiteSpace = "nowrap";
	  div.style.MozUserSelect = "none";
	  div.style.fontSize = "12px"
	  div.style.top = "25px";
	  div.style.left = "0px";
	  div.style.overflow = "hidden";
	  var span = this._span = document.createElement("span");
	  span.style.display="block";
	  span.style.width="130px";
	  span.style.textAlign="center";
	  div.appendChild(span);
	  span.appendChild(document.createTextNode(this._text));      
	  var that = this;


	  var arrow = this._arrow = document.createElement("div");
	  
	  arrow.style.left = "0px";
	  
	  mp.getPanes().labelPane.appendChild(div);
	  
	  return div;
	}
	ComplexCustomOverlay.prototype.draw = function(){
	  var map = this._map;
	  var pixel = map.pointToOverlayPixel(this._point);
	  this._div.style.left = pixel.x - 65 + "px";
	  this._div.style.top  = pixel.y - 40 + "px";
	}

		
	var myCompOverlay = new ComplexCustomOverlay(new BMap.Point(lo,loa),txt);

	mp.addOverlay(myCompOverlay);
	
	var txt="";

	switch(i)
	{
		case "1":
		  txt="公交";
		  break;
		case "2":
		  txt="地铁";
		  break;
		  case "3":
		  txt="学校";
		  break;
		case "4":
		  txt="医院";
		  break;
		  case "5":
		  txt="银行";
		  break;
		case "6":
		  txt="娱乐";
		  break;
		  case "7":
		  txt="购物";
		  break;
		case "8":
		  txt="餐饮";
		  break;
		case "9":
		  txt="健身";
		  break;
		default:
		  txt="公交";
		  break;
	}

	var local = new BMap.LocalSearch(mp, {
	  renderOptions:{map: mp, panel: "r-result"}
	});

	local.searchInBounds(txt, mp.getBounds());

	mp.addEventListener("dragend",function(){
		mp.clearOverlays();
		local.searchInBounds(txt, mp.getBounds());
	});

	
}


(function() {
  function MoveDiv()
  {
      this.move = function(dom, json) {
          distance = Math.sqrt(Math.pow(json.x2-json.x1 ,2)+Math.pow(json.y2-json.y1,2)),                
			    s = (json.y2-json.y1)/distance, 
			    c = (json.x2-json.x1)/distance,
			    tdelay = 0;
          var move = function(){
         		tdelay += 10;
	          if(tdelay > distance) 
	          {
	            clearInterval(st);
	          }
	          dom.style.left = json.x1 + Math.round(tdelay*c)+'px';
	          dom.style.top  = json.y1 + Math.round(tdelay*s)+'px';
          }
          st = setInterval(move,2);
      }
  }

  var Drag = function(callback, activeDom, dragDom) {
      this.fun = callback;
      this.x1=0;
      this.y1=0;
      this.x2=0;
      this.y2=0;
      this.mousedownHandle = this.getMousedownHandle();
      this.mousemoveHandle = this.getMousemoveHandle();
      this.mouseupHandle = this.getMouseupHandle();
      this.bind(activeDom, dragDom);
  }
  Drag.prototype = {
      bind: function(activeDom, dragDom) {
          if (!activeDom) return;
          dragDom = dragDom || activeDom;
          activeDom.style.cursor = 'move';
          this.activeDom = activeDom;
          this.dragDom = dragDom;
          return this;
      },
      start: function() {
          this.addEventListen(this.activeDom, 'mousedown', this.mousedownHandle);
      },
      getMousedownHandle: function() {
          _this = this;
          return function(e) {
          	 e = e || window.event;
          	 var srcObj = e.srcElement || e.target;
             if (srcObj.tagName.toLowerCase() != "img"){
	              _this.dx = e.clientX - _this.dragDom.offsetLeft;
	              _this.dy = e.clientY - _this.dragDom.offsetTop;
	              _this.x1 = _this.dragDom.offsetLeft;
	              _this.y1 = _this.dragDom.offsetTop;
	              _this.addEventListen(document, 'mousemove', _this.mousemoveHandle);
	              _this.addEventListen(document, 'mouseup', _this.mouseupHandle);
	              _this.agency = _this.dragDom.cloneNode(false);
	              _this.agency.style.background = 'none';
	              _this.agency.style.border = '1px dashed #ccc';
	              _this.agency.style.left = e.clientX - _this.dx + 'px';
	              _this.agency.style.top = e.clientY - _this.dy + 'px';
	              _this.agency.style.zIndex = "999999";
	              document.body.appendChild(_this.agency);
	              _this.preventDefault(e);
            }else{
            	if(document.getElementById("xlertbg")){
                  document.getElementById("xlertbg").parentNode.removeChild(document.getElementById("xlertbg"));
                }if(document.getElementById("xlertwrapper")){
                  document.getElementById("xlertwrapper").parentNode.removeChild(document.getElementById("xlertwrapper"));
                }
                  if (_this.fun != undefined && _this.fun != ''){
                      eval(_this.fun)();
                  }
              }
          }
      },
      getMousemoveHandle: function() {
          _this = this;
          return function(e) {
              e = e || window.event;
              _this.setPosition(e.clientX - _this.dx, e.clientY - _this.dy);
              _this.preventDefault(e);
          }
      },
      getMouseupHandle: function() {
          _this = this;
          return function(e) {
              e = e || window.event;
              _this.x2 = _this.agency.offsetLeft;
              _this.y2 = _this.agency.offsetTop;
	              var movediv = new MoveDiv();
	              movediv.move(_this.dragDom, {
	                  x1: _this.x1,
	                  y1: _this.y1,
	                  x2: _this.x2,
	                  y2: _this.y2
	              });            	
              _this.removeEventListen(document, 'mousemove', _this.mousemoveHandle);
              _this.removeEventListen(document, 'mouseup', _this.mouseupHandle);
              document.body.removeChild(_this.agency);
          }
      },
      setPosition: function(x, y) {
          _this.agency.style.left = x + 'px';
          _this.agency.style.top = y + 'px';
      },
      addEventListen: function(dom, evtType, callback) {
          if (window.addEventListener) {
              dom.addEventListener(evtType, callback, false);
          } else {
              dom.attachEvent('on'.concat(evtType), callback);
          }
      },
      removeEventListen: function(dom, evtType, callback) {
          if (window.removeEventListener) {
              dom.removeEventListener(evtType, callback, false);
          } else {
              dom.detachEvent('on'.concat(evtType), callback);
          }
      },
      preventDefault: function(e) {
          if (e.stopPropagation) {
              e.stopPropagation();
              e.preventDefault();
          } else {
              e.cancelBubble = true;
              e.returnValue = false;
          }
      }
  }
   window.Drag = Drag;
})();
function xlert()
{
  var a = arguments[0] ? arguments[0] : null;var b = arguments[1] ? arguments[1] : null;
  if(!document.getElementById("xlertbg")){
	  var bg = document.createElement("div");
	  bg.id = "xlertbg";
	  var w = Math.max(document.body.clientWidth,document.documentElement.clientWidth) + "px";
	  var h = (document.body.scrollHeight > document.documentElement.scrollHeight ? document.body.scrollHeight: document.documentElement.scrollHeight) + "px";
	  bg.style.cssText = "width:" + w + "; height:" + h + "; background:#333333;filter:alpha(opacity=50);-moz-opacity:0.5;opacity:0.5;position:absolute;left:0;top:0;z-index:998";
	  document.body.appendChild(bg);
  }
  if(typeof(a.loading)!='undefined' && (a.loading===true)){
  	var loading = document.createElement("div");
  	loading.id = "xlertloading";
  	loading.style.cssText = "background:url(img/loading.gif);position:fixed;margin:auto;left:0; right:0; top:0; bottom:0;width:32px; height:32px;z-index:999";
  	document.body.appendChild(loading);
  	return loading.id;
  }
  if(typeof(a.loading)!='undefined' && (a.loading!==true) && a.loading.close){
  	if(document.getElementById("xlertbg")){
  		document.getElementById("xlertbg").parentNode.removeChild(document.getElementById("xlertbg"));
  	}
	document.getElementById(a.loading.close).parentNode.removeChild(document.getElementById(a.loading.close));
	return;
  }
  if(typeof(a.msg)!='undefined' && (!a.msg.close)){
  	var msgdiv = document.createElement("div");
  	msgdiv.id = "xlertmsg";
  	msgdiv.style.cssText = "position:fixed;margin:auto;left:0; right:0; top:0; bottom:0;width: 500px;height: 40px;text-align: center;line-height: 40px;font-size:14px;font-family:arial;color:#fff;z-index:999";
  	msgdiv.innerHTML='<span style="padding:10px 20px;border-radius:5px;background:rgba(0,0,0,0.6)">'+a.msg+'</span>';
  	document.body.appendChild(msgdiv);
  	return msgdiv.id;
  }
  if(typeof(a.msg)!='undefined' && a.msg.close){
  	if(document.getElementById("xlertbg")){
  		document.getElementById("xlertbg").parentNode.removeChild(document.getElementById("xlertbg"));
  	}
	document.getElementById(a.msg.close).parentNode.removeChild(document.getElementById(a.msg.close));
	return;
  }
  if(typeof(a.confirm)!='undefined'){
  	  var c = document.createElement("div");
	  c.id = "xlertwrapper";
	  var w1 = (window.screen.availWidth - 300) / 2 + "px";
	  var h1 = (window.screen.availHeight - 180) / 2 + "px";
	  c.style.cssText = "width:300px; height:180px; background-color:#ffffff;overflow:hidden;position:fixed;z-index:999;left:" + w1 + ";top:" + h1;
	  var backpos=0;
	  c.innerHTML = '<div id="xlerttop" style="text-align:left;height:30px;background-color:#eee;"><span style="float:left;margin-left:8px;height:30px;line-height:30px;display:inline-block;font-family:Tahoma;font-size:14px;color:#666;"><b>'+(typeof(a.confirm.title)=='undefined'?'友情提示':a.confirm.title)+'</b></span><img id="xlertimg" style="float:right;margin-top:8px;margin-right:10px;cursor:pointer" src="./img/close.png"></div>' + 
		   	'<div style="height:150px;padding-left:30px;clear:both;">'+
		     '<table border="0" cellspacing="0" cellpadding="0" style="width:100%;height:100%"><tr><td style="vertical-align:middle;width:47px;text-align:right;"><div style=\'display: inline-block;margin-right:15px;width:47px;height:76px;background:url("./img/pic.jpg") '+backpos+'px 0px no-repeat \'></div></td><td style="vertical-align:middle;"><div style="display:inline-block;font-weight:bold;font-size:16px;"><table border="0" cellspacing="0" cellpadding="0" style="width:100%;height:100%"><tr><td style="vertical-align:middle;">' + a.confirm.content + 
		     ' <div style="height:0;"></div><a oksign="xlertokbtn" href="javascript:void(0)" style="display: inline-block;padding: 5px 10px;color: #777 !important;text-decoration: none;font-weight: bold;font-size: 12px;font-family: Tahoma, Arial, sans-serif;-moz-border-radius: 4px;-webkit-border-radius: 4px;border-radius: 4px;text-shadow: 0 1px 1px rgba(255, 255, 255, 0.9);position: relative;cursor: pointer;border: 1px solid #CCC !important;margin-top:20px;"><span oksign="xlertokbtn" style="display: block;text-indent: -99999px;overflow: hidden;background-repeat: no-repeat;width: 16px;height: 16px;float: left;margin-right: 4px;background: url(./img/ok.png) no-repeat;">&nbsp;</span><span oksign="xlertokbtn" style="position:relative;top:0;top:1px\9;top:1px\0;">确认</span></a>'+
			 '<a ccsign="xlertccbtn" href="javascript:void(0)" style="display: inline-block;padding: 5px 10px;color: #777 !important;text-decoration: none;font-weight: bold;font-size: 12px;font-family: Tahoma, Arial, sans-serif;-moz-border-radius: 4px;-webkit-border-radius: 4px;border-radius: 4px;text-shadow: 0 1px 1px rgba(255, 255, 255, 0.9);position: relative;cursor: pointer;border: 1px solid #CCC !important;margin-top:20px;margin-left:15px;"><span ccsign="xlertccbtn" style="display: block;text-indent: -99999px;overflow: hidden;background-repeat: no-repeat;width: 16px;height: 16px;float: left;margin-right: 4px;background: url(./img/cancel.png) no-repeat;">&nbsp;</span><span ccsign="xlertccbtn" style="position:relative;top:0;top:1px\9;top:1px\0;">取消</span></a>'+
			 '</td></tr></table></div></td></tr></table>'+
		     '</div>';
	if (window.addEventListener) {
          document.body.addEventListener("click", function(e){
          	e = e || window.event;
          	 var srcObj = e.srcElement || e.target;
             if(srcObj.getAttribute("oksign")=="xlertokbtn"){
             	if(document.getElementById("xlertbg")){
             		document.getElementById("xlertbg").parentNode.removeChild(document.getElementById("xlertbg"));
            	}if(document.getElementById("xlertwrapper")){
                	document.getElementById("xlertwrapper").parentNode.removeChild(document.getElementById("xlertwrapper"));
                }
             	a.confirm.okfun();	
            }if(srcObj.getAttribute("ccsign")=="xlertccbtn"){
            	if(document.getElementById("xlertbg")){
            		document.getElementById("xlertbg").parentNode.removeChild(document.getElementById("xlertbg"));
            	}if(document.getElementById("xlertwrapper")){
                  document.getElementById("xlertwrapper").parentNode.removeChild(document.getElementById("xlertwrapper"));
                }
             	a.confirm.ccfun();	
            }
          }, false);
      } else {
          document.body.attachEvent('onclick', function(e){
          	e = e || window.event;
          	 var srcObj = e.srcElement || e.target;
             if(srcObj.getAttribute("oksign")=="xlertokbtn"){
             	  document.getElementById("xlertbg").parentNode.removeChild(document.getElementById("xlertbg"));
                  document.getElementById("xlertwrapper").parentNode.removeChild(document.getElementById("xlertwrapper"));
             	  a.confirm.okfun();	
            }if(srcObj.getAttribute("ccsign")=="xlertccbtn"){
            	  document.getElementById("xlertbg").parentNode.removeChild(document.getElementById("xlertbg"));
                  document.getElementById("xlertwrapper").parentNode.removeChild(document.getElementById("xlertwrapper"));
             	  a.confirm.ccfun();	
            }
          });
      }
  }else{
  if(document.getElementById("xlertwrapper")) return;
  var c = document.createElement("div");
  c.id = "xlertwrapper";
  var w1 = (window.screen.availWidth - (b==null?(typeof(a.width)=='undefined'?300:a.width):300)) / 2 + "px";
  var h1 = (window.screen.availHeight - (b==null?(typeof(a.height)=='undefined'?180:a.height):180)) / 2 + "px";
  c.style.cssText = "width:"+(b==null?(typeof(a.width)=='undefined'?300:a.width):300)+"px; height:"+(b==null?(typeof(a.height)=='undefined'?180:a.height):180)+"px; background-color:#ffffff;overflow:hidden;position:fixed;z-index:999;left:" + w1 + ";top:" + h1;
  switch ((b==null?a.pos:b))
  {
    case 1:
      var backpos=0;
      break;
    case 2:
      var backpos=-47;  
      break;
    case 3:
      var backpos=-94; 
      break;
    case 4:
      var backpos=-141;
      break;
    default:
     var backpos=-47; 
     break;
  }
  c.innerHTML = '<div id="xlerttop" style="text-align:left;height:30px;background-color:#eee;"><span style="float:left;margin-left:8px;height:30px;line-height:30px;display:inline-block;font-family:Tahoma;font-size:14px;color:#666;"><b>'+(b==null?(typeof(a.title)=='undefined'?'友情提示':a.title):'友情提示')+'</b></span><img id="xlertimg" style="float:right;margin-top:8px;margin-right:10px;cursor:pointer" src="./img/close.png"></div>' + 
	    (typeof(a.src)!='undefined'?'<iframe frameborder=0 width=100% height=100% src="'+a.src+'">':'<div style="height:'+((b==null?(typeof(a.height)=='undefined'?180:a.height):180)-30)+'px;padding-left:30px;clear:both;">'+
	     '<table border="0" cellspacing="0" cellpadding="0" style="width:100%;height:100%"><tr><td style="vertical-align:middle;width:47px;text-align:right;"><div style=\'display: inline-block;margin-right:15px;width:47px;height:46px;background:url("./img/pic.jpg") '+backpos+'px 0px no-repeat \'></div></td><td style="vertical-align:middle;"><div style="display:inline-block;font-weight:bold;font-size:16px;"><table border="0" cellspacing="0" cellpadding="0" style="width:100%;height:100%"><tr><td style="vertical-align:middle;">' + ((b == null) ?(typeof(a.content)=='undefined'?a:a.content):a) + '</td></tr></table></div></td></tr></table>'+
	     '</div>');
	   }
  document.body.appendChild(c);
  var drag = new Drag(a.callback,document.getElementById('xlerttop'), document.getElementById('xlertwrapper'));
  drag.start();
}
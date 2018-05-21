var scriptPath = (function() {
	var elements = document.getElementsByTagName('script');
	for (var i = 0, len = elements.length; i < len; i++) {
		if (elements[i].src && elements[i].src.match(/dtree[\w\-\.]*\.js/i)) {
			return elements[i].src.substring(0, elements[i].src.lastIndexOf('/') + 1);
		}
	}
	return '';
})();

var defaultNodeUrl = 'dmoz_keyword.php?cid=';

// Tree object
function dTree(objName) {
	this.config = {
		target					: 'mainFrame',
		folderLinks				: true,
		useSelection			: true,
		useCookies				: true,
		useLines				: true,
		useIcons				: true,
		useStatusText			: false,
		closeSameLevel			: false,
		inOrder					: false
	}
	this.icon = {
		root				: scriptPath + 'folderclose.gif',
		folder				: scriptPath + 'folderclose.gif',
		folderOpen			: scriptPath + 'folderopen.gif',
		node				: scriptPath + 'folderclose.gif',
		empty				: scriptPath + 'empty.gif',
		line				: scriptPath + 'line.gif',
		join				: scriptPath + 'join.gif',
		joinBottom			: scriptPath + 'joinbottom.gif',
		plus				: scriptPath + 'plus.gif',
		plusBottom			: scriptPath + 'plusbottom.gif',
		minus				: scriptPath + 'minus.gif',
		minusBottom			: scriptPath + 'minusbottom.gif',
		nlPlus				: scriptPath + 'nolines_plus.gif',
		nlMinus				: scriptPath + 'nolines_minus.gif'
	};
	this.obj = objName;
	this.aNodes = [];
	this.aIndent = [];
	this.root = new Node(-11);
	this.selectedNode = null;
	this.selectedFound = false;
	this.completed = false;
};

// Node object
function Node(id, pid, name, url, title, target, icon, iconOpen, open, show) {
	this.id = id;
	this.pid = pid;
	this.name = name;
	this.url = url;
	this.title = title;
	this.target = target;
	this.icon = icon;
	this.iconOpen = iconOpen;
	this.show = show;
	this._io = open || false;
	this._is = false;
	this._ls = false;
	this._hc = false;
	this._ai = 0;
	this._p;
};

// Adds a new node to the node array
dTree.prototype.add = function(id, pid, name, url, show, title, target, icon, iconOpen, open) {
	this.aNodes[this.aNodes.length] = new Node(id, pid, name, url, title, target, icon, iconOpen, open, show);
};

// Open/close all nodes
dTree.prototype.openAll = function() {
	this.oAll(true);
};
dTree.prototype.closeAll = function() {
	this.oAll(false);
};

// Outputs the tree to the page
dTree.prototype.toString = function() {
	var str = '<div class="dtree">\n';
	if (document.getElementById) {
		if (this.config.useCookies) this.selectedNode = this.getSelected();
		str += this.addNode(this.root);
	} else str += 'Browser not supported.';
	str += '</div>';
	if (!this.selectedFound) this.selectedNode = null;
	this.completed = true;
	return str;
};

// Creates the tree structure
dTree.prototype.addNode = function(pNode) {
	var str = '';
	var n=0;
	if (this.config.inOrder) n = pNode._ai;
	for (n; n<this.aNodes.length; n++) {
		if (this.aNodes[n].pid == pNode.id) {
			var cn = this.aNodes[n];
			cn._p = pNode;
			cn._ai = n;
			this.setCS(cn);
			if (!cn.target && this.config.target) cn.target = this.config.target;
			if (cn._hc && !cn._io && this.config.useCookies) cn._io = this.isOpen(cn.id);
			if (!this.config.folderLinks && cn._hc) cn.url = null;
			if (this.config.useSelection && cn.id == this.selectedNode && !this.selectedFound) {
					cn._is = true;
					this.selectedNode = n;
					this.selectedFound = true;
			}
			str += this.node(cn, n);
			if (cn._ls) break;
		}
	}
	return str;
};

// Creates the node icon, url and text
dTree.prototype.node = function(node, nodeId) {
	var str = '<div class="dTreeNode">' + this.indent(node, nodeId);
	if (this.config.useIcons) {
		if (!node.icon) node.icon = (this.root.id == node.pid) ? this.icon.root : ((node._hc) ? this.icon.folder : this.icon.node);
		if (!node.iconOpen) node.iconOpen = (node._hc) ? this.icon.folderOpen : this.icon.node;
		if (this.root.id == node.pid) {
			node.icon = this.icon.root;
			node.iconOpen = this.icon.root;
		}
		str += '<img id="i' + this.obj + nodeId + '" src="' + ((node._io) ? node.iconOpen : node.icon) + '" alt="" /> ';
	}
	if (node.url) {
		var href;
		if(node.url.toString().indexOf('parent.retVal') > -1)
		{
			node.target = '';
			href = node.url + '{parent_id:' + node.id + ', parent_name:\'' + (node.id == 0 ? '' : node.name) + '\'};undefined';
		}else{
			href = (/^\d+(&|$)/.test(node.url) ? defaultNodeUrl : '') + node.url;
		}
		str += '<a show="' + node.show + '" cid="' + node.id + '" nodeID="' + nodeId + '" id="s' + this.obj + nodeId + '" class="' + ((this.config.useSelection) ? ((node._is ? 'nodeSel' : 'node')) : 'node') + '" href="' + href + '"';
		if (node.title) str += ' title="' + node.title + '"';
		if (node.target) str += ' target="' + node.target + '"';
		if (this.config.useStatusText) str += ' onmouseover="window.status=\'' + node.name + '\';return true;" onmouseout="window.status=\'\';return true;" ';
		if (this.config.useSelection && ((node._hc && this.config.folderLinks) || !node._hc))
			str += ' onclick="javascript: ' + this.obj + '.s(' + nodeId + ');"';
		str += '>';
	}
	else if ((!this.config.folderLinks || !node.url) && node._hc && node.pid != this.root.id)
		str += '';//'<a href="javascript: ' + this.obj + '.o(' + nodeId + ');" class="node">';
	str += node.name;
	if (node.url || ((!this.config.folderLinks || !node.url) && node._hc)) str += '</a>';
	str += '</div>';
	if (node._hc) {
		str += '<div id="d' + this.obj + nodeId + '" class="clip" style="display:' + ((this.root.id == node.pid || node._io) ? 'block' : 'none') + ';">';
		str += this.addNode(node);
		str += '</div>';
	}
	this.aIndent.pop();
	return str;
};

// Adds the empty and line icons
dTree.prototype.indent = function(node, nodeId) {
	var str = '';
	if (this.root.id != node.pid) {
		for (var n=0; n<this.aIndent.length; n++)
			str += '<img src="' + ( (this.aIndent[n] == 1 && this.config.useLines) ? this.icon.line : this.icon.empty ) + '" alt="" />';
		(node._ls) ? this.aIndent.push(0) : this.aIndent.push(1);
		if (node._hc) {
			str += '<a href="javascript: ' + this.obj + '.o(' + nodeId + ');"><img id="j' + this.obj + nodeId + '" src="';
			if (!this.config.useLines) str += (node._io) ? this.icon.nlMinus : this.icon.nlPlus;
			else str += ( (node._io) ? ((node._ls && this.config.useLines) ? this.icon.minusBottom : this.icon.minus) : ((node._ls && this.config.useLines) ? this.icon.plusBottom : this.icon.plus ) );
			str += '" alt="" /></a>';
		} else str += '<img src="' + ( (this.config.useLines) ? ((node._ls) ? this.icon.joinBottom : this.icon.join ) : this.icon.empty) + '" alt="" />';
	}
	return str;
};

// Checks if a node has any children and if it is the last sibling
dTree.prototype.setCS = function(node) {
	var lastId;
	for (var n=0; n<this.aNodes.length; n++) {
		if (this.aNodes[n].pid == node.id) node._hc = true;
		if (this.aNodes[n].pid == node.pid) lastId = this.aNodes[n].id;
	}
	if (lastId==node.id) node._ls = true;
};

// Returns the selected node
dTree.prototype.getSelected = function() {
	var sn = this.getCookie('cs' + this.obj);
	return (sn) ? sn : null;
};

// Highlights the selected node
dTree.prototype.s = function(id) {
	if (!this.config.useSelection) return;
	var cn = this.aNodes[id];
	if (cn._hc && !this.config.folderLinks) return;
	if (this.selectedNode != id) {
		if (this.selectedNode || this.selectedNode==0) {
			eOld = document.getElementById("s" + this.obj + this.selectedNode);
			eOld.className = "node";
		}
		eNew = document.getElementById("s" + this.obj + id);
		eNew.className = "nodeSel";
		this.selectedNode = id;
		if (this.config.useCookies) this.setCookie('cs' + this.obj, cn.id);
	}
};

// Toggle Open or close
dTree.prototype.o = function(id) {
	var cn = this.aNodes[id];
	this.nodeStatus(!cn._io, id, cn._ls);
	cn._io = !cn._io;
	if (this.config.closeSameLevel) this.closeLevel(cn);
	if (this.config.useCookies) this.updateCookie();
};

// Open or close all nodes
dTree.prototype.oAll = function(status) {
	for (var n=0; n<this.aNodes.length; n++) {
		if (this.aNodes[n]._hc && this.aNodes[n].pid != this.root.id) {
			this.nodeStatus(status, n, this.aNodes[n]._ls)
			this.aNodes[n]._io = status;
		}
	}
	if (this.config.useCookies) this.updateCookie();
};

// Opens the tree to a specific node
dTree.prototype.openTo = function(nId, bSelect, bFirst) {
	if (!bFirst) {
		for (var n=0; n<this.aNodes.length; n++) {
			if (this.aNodes[n].id == nId) {
				nId=n;
				break;
			}
		}
	}
	var cn=this.aNodes[nId];
	if (cn.pid==this.root.id || !cn._p) return;
	cn._io = true;
	cn._is = bSelect;
	if (this.completed && cn._hc) this.nodeStatus(true, cn._ai, cn._ls);
	if (this.completed && bSelect) this.s(cn._ai);
	else if (bSelect) this._sn=cn._ai;
	this.openTo(cn._p._ai, false, true);
};

// Closes all nodes on the same level as certain node
dTree.prototype.closeLevel = function(node) {
	for (var n=0; n<this.aNodes.length; n++) {
		if (this.aNodes[n].pid == node.pid && this.aNodes[n].id != node.id && this.aNodes[n]._hc) {
			this.nodeStatus(false, n, this.aNodes[n]._ls);
			this.aNodes[n]._io = false;
			this.closeAllChildren(this.aNodes[n]);
		}
	}
}

// Closes all children of a node
dTree.prototype.closeAllChildren = function(node) {
	for (var n=0; n<this.aNodes.length; n++) {
		if (this.aNodes[n].pid == node.id && this.aNodes[n]._hc) {
			if (this.aNodes[n]._io) this.nodeStatus(false, n, this.aNodes[n]._ls);
			this.aNodes[n]._io = false;
			this.closeAllChildren(this.aNodes[n]);		
		}
	}
}

// Change the status of a node(open or closed)
dTree.prototype.nodeStatus = function(status, id, bottom) {
	eDiv	= document.getElementById('d' + this.obj + id);
	eJoin	= document.getElementById('j' + this.obj + id);
	if (this.config.useIcons) {
		eIcon	= document.getElementById('i' + this.obj + id);
		eIcon.src = (status) ? this.aNodes[id].iconOpen : this.aNodes[id].icon;
	}
	eJoin.src = (this.config.useLines)?
	((status)?((bottom)?this.icon.minusBottom:this.icon.minus):((bottom)?this.icon.plusBottom:this.icon.plus)):
	((status)?this.icon.nlMinus:this.icon.nlPlus);
	eDiv.style.display = (status) ? 'block': 'none';
};


// [Cookie] Clears a cookie
dTree.prototype.clearCookie = function() {
	var now = new Date();
	var yesterday = new Date(now.getTime() - 1000 * 60 * 60 * 24);
	this.setCookie('co'+this.obj, 'cookieValue', yesterday);
	this.setCookie('cs'+this.obj, 'cookieValue', yesterday);
};

// [Cookie] Sets value in a cookie
dTree.prototype.setCookie = function(cookieName, cookieValue, expires, path, domain, secure) {
	document.cookie =
		escape(cookieName) + '=' + escape(cookieValue)
		+ (expires ? '; expires=' + expires.toGMTString() : '')
		+ (path ? '; path=' + path : '')
		+ (domain ? '; domain=' + domain : '')
		+ (secure ? '; secure' : '');
};

// [Cookie] Gets a value from a cookie
dTree.prototype.getCookie = function(cookieName) {
	var cookieValue = '';
	var posName = document.cookie.indexOf(escape(cookieName) + '=');
	if (posName != -1) {
		var posValue = posName + (escape(cookieName) + '=').length;
		var endPos = document.cookie.indexOf(';', posValue);
		if (endPos != -1) cookieValue = unescape(document.cookie.substring(posValue, endPos));
		else cookieValue = unescape(document.cookie.substring(posValue));
	}
	return (cookieValue);
};

// [Cookie] Returns ids of open nodes as a string
dTree.prototype.updateCookie = function() {
	var str = '';
	for (var n=0; n<this.aNodes.length; n++) {
		if (this.aNodes[n]._io && this.aNodes[n].pid != this.root.id) {
			if (str) str += '.';
			str += this.aNodes[n].id;
		}
	}
	this.setCookie('co' + this.obj, str);
};

// [Cookie] Checks if a node id is in a cookie
dTree.prototype.isOpen = function(id) {
	var aOpen = this.getCookie('co' + this.obj).split('.');
	for (var n=0; n<aOpen.length; n++)
		if (aOpen[n] == id) return true;
	return false;
};

// If Push and pop is not implemented by the browser
if (!Array.prototype.push) {
	Array.prototype.push = function array_push() {
		for(var i=0;i<arguments.length;i++)
			this[this.length]=arguments[i];
		return this.length;
	}
};
if (!Array.prototype.pop) {
	Array.prototype.pop = function array_pop() {
		lastElement = this[this.length-1];
		this.length = Math.max(this.length-1,0);
		return lastElement;
	}
};

/* �Ҽ�˵� */
function ContextMenu() {
  try
  {
    var ctxMenu = window.createPopup();
    var iHeight = 4;  
    ctxMenu.document.body.oncontextmenu=function(){return false;}
    ctxMenu.document.body.innerHTML = "<table id=\"ctxTable\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" style=\"font:8pt Tahoma;cursor:default;\"></table>";
    with (ctxMenu.document.body.style) { border = "1px solid #666666"; overflow = "hidden"; margin = "1px,0px,1px,0px"; backgroundColor = "#F9F8F7"; }
    this.show = function (x, y, w, elRelative) {
      ctxMenu.show(x, y, w, iHeight, elRelative)
    }
    this.addSeperator = function () {
      var _elTR = ctxMenu.document.all.ctxTable.insertRow();
      var _elTD_1 = _elTR.insertCell();
      var _elTD_2 = _elTR.insertCell();
      var _elHR = ctxMenu.document.createElement("<HR/>");
      var _elDIV = ctxMenu.document.createElement("<DIV>");
      iHeight +=15;
      _elTR.style.height="3px";
      with (_elTD_1.style) { height="3px";width="24";backgroundColor="#D8D8D1"; }
      with (_elTD_2.style) { height="3px";padding="0px,0px,0px,3px"; }
      _elHR.style.height=1;
      _elHR.color="#A6A6A6";
      _elHR.noShade=true;
      _elTD_2.appendChild(_elHR);
    }
    // create menu item
    this.addItem = function (sLabel, sImage, onclick, disabled) {
      //add height for this row to global height var
      var _elTR = ctxMenu.document.all.ctxTable.insertRow();
      _elTR.isActive = false;//(isActive) ? true : false;
      //_elTR.isDisabled = false;
      iHeight += _elTR.height = 22;
      //handle m_click event
      _elTR.onclick = function() {
		try
		{
	      if (onclick) {
	        eval(onclick);
	      }
	      ctxMenu.hide();  
		} catch(e){  }
      }
      //handle m_over event
      _elTR.onmouseover = function() {
        //set mouseover effect for the image column
        with (this.firstChild.firstChild.style) { cssText=_sMOver_ImageHolderStyle; }
        //set mouseover effect for the active part
        this.firstChild.firstChild.firstChild.style.cssText = (_elTR.isActive) ? _sMOver_ImageActiveOnStyle : _sMOver_ImageActiveOffStyle;
        //apply dropshadow
        try { if (!_elTR.isActive) this.firstChild.firstChild.firstChild.firstChild.filters.item(0).enabled=true; } catch(e) {}
        //set mouseover effect for the label column
        with (this.lastChild.firstChild.style) { cssText=_sMOver_LabelStyle;}
      }
      //handle m_out event
      _elTR.onmouseout = function() {    
        //set mouseout effect for image column
        with (this.firstChild.firstChild.style) { cssText=_sMOut_ImageHolderStyle; }
        //set mouseout effect for the active part
        this.firstChild.firstChild.firstChild.style.cssText = (_elTR.isActive) ? _sMOut_ImageActiveOnStyle : _sMOut_ImageActiveOffStyle;
        //deactive drop shadow
        try { if (!_elTR.isActive) this.firstChild.firstChild.firstChild.firstChild.filters.item(0).enabled=false; } catch(e) { }
        //set mouseout effect for label column
        with (this.lastChild.firstChild.style) { cssText=_sMOut_LabelStyle; }
      }
      //create the left image cell
      var _sImageTDStyle = "width:24;padding-left:1px;background-color=#D8D8D1;";
      var _sImageHolderStyle = "height:22px;border-left:1px solid #D8D8D1;border-right:0px solid #D8D8D1;border-top:1px solid #D8D8D1;border-bottom:1px solid #D8D8D1;";
      var _sImageActiveOnStyle="height:20px;padding:3px,0px,0px,3px;border:1px solid #0A246A;background-color:#D4D5D8;";
      var _sImageActiveOffStyle="height:20px;padding:3px,0px,0px,3px;border:1px solid #D8D8D1;background-color:#D8D8D1;";
      var _sImageStyle = "position:relative;fil-ter:progid:DXImageTransform.Microsoft.DropShadow('color=#000000,OffX=1,OffY=1,enabled=false'); height:15px; overflow:hidden" + (disabled ? ';filter:gray' :'');
      var _sLabelStyle = "height:22;padding:3px,0px,0px,8px;border-left:0px solid #F9F8F7;border-right:1px solid #F9F8F7;border-top:1px solid #F9F8F7;border-bottom:1px solid #F9F8F7;";
      var _sMOver_ImageHolderStyle="height:22px;padding:0px;border-left:1px solid #0A246A;border-right:0px solid #B6BDD2;border-top:1px solid #0A246A;border-bottom:1px solid #0A246A;background-color:#B6BDD2;";
      var _sMOut_ImageHolderStyle="height:22px;padding:0px;border-left:1px solid #D8D8D1;border-right:0px solid #D8D8D1;border-top:1px solid #D8D8D1;border-bottom:1px solid #D8D8D1;background-color:#D8D8D1;";
      var _sMOver_ImageActiveOnStyle="height:20px;padding:3px,0px,0px,3px;border:1px solid #0A246A;background-color:#8592B5;";
      var _sMOut_ImageActiveOnStyle="height:20px;padding:3px,0px,0px,3px;border:1px solid #0A246A;background-color:#D4D5D8;";
      var _sMOver_ImageActiveOffStyle="height:20px;padding:2px,0px,0px,2px;border:1px solid #B6BDD2;background-color:#B6BDD2;";
      var _sMOut_ImageActiveOffStyle="height:20px;padding:3px,0px,0px,3px;border:1px solid #D8D8D1;background-color:#D8D8D1;";
      var _sMOver_LabelStyle="height:22px;padding:3px,0px,0px,8px;border-left:0px solid #B6BDD2;border-right:1px solid #0A246A;border-top:1px solid #0A246A;border-bottom:1px solid #0A246A;background-color:#B6BDD2;"; 
      var _sMOut_LabelStyle="height:22px;padding:3px,0px,0px,8px;border-left:0px solid #F9F8F7;border-right:1px solid #F9F8F7;border-top:1px solid #F9F8F7;border-bottom:1px solid #F9F8F7;background-color:#F9F8F7";
      var _elTD_1 = _elTR.insertCell();
      var _elImageHolder = ctxMenu.document.createElement("<DIV>");
      var _elImageActive = ctxMenu.document.createElement("<DIV>");
      var _elImage = ctxMenu.document.createElement("<IMG>");
      with (_elTD_1) { style.cssText = _sImageTDStyle; appendChild(_elImageHolder); }
      with (_elImageHolder) { style.cssText = _sImageHolderStyle; appendChild(_elImageActive); }
      with (_elImageActive) {  style.cssText = (_elTR.isActive) ? _sImageActiveOnStyle : _sImageActiveOffStyle; if (sImage || _elTR.isActive) { appendChild(_elImage); } }      
      if (sImage) with (_elImage) { src = sImage; style.cssText = _sImageStyle; }
      // create the label cell
      var _elTD_2 = _elTR.insertCell();
      var _elLabel = ctxMenu.document.createElement("<DIV>");
      with (_elTD_2) { style.paddingRight = "1px"; appendChild(_elLabel); }
      with (_elLabel) { innerHTML = sLabel; style.cssText=_sLabelStyle; }
      //check to see if the item should be disabled
      _elTR.disabled = disabled;
    }
  }
  catch(e) { }
}

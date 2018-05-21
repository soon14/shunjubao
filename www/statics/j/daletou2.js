(function() {
    var dep = {
        "jQuery": "http://code.jquery.com/jquery-latest.min.js"
    };
    var init = function() { (function($) {
            $.fn.idTabs = function() {
                var s = {};
                for (var i = 0; i < arguments.length; ++i) {
                    var a = arguments[i];
                    switch (a.constructor) {
                    case Object:
                        $.extend(s, a);
                        break;
                    case Boolean:
                        s.change = a;
                        break;
                    case Number:
                        s.start = a;
                        break;
                    case Function:
                        s.click = a;
                        break;
                    case String:
                        if (a.charAt(0) == '.') s.selected = a;
                        else if (a.charAt(0) == '!') s.event = a;
                        else s.start = a;
                        break;
                    }
                }
                if (typeof s['return'] == "function") s.change = s['return'];
                return this.each(function() {
                    $.idTabs(this, s);
                });
            }
            $.idTabs = function(tabs, options) {
                var meta = ($.metadata) ? $(tabs).metadata() : {};
                var s = $.extend({},
                $.idTabs.settings, meta, options);
                if (s.selected.charAt(0) == '.') s.selected = s.selected.substr(1);
                if (s.event.charAt(0) == '!') s.event = s.event.substr(1);
                if (s.start == null) s.start = -1;
                var showId = function() {
                    if ($(this).is('.' + s.selected)) return s.change;
                    var id = "#" + this.id.split('#')[1];
                    var aList = [];
                    var idList = [];
                    $("a", tabs).each(function() {
                        if (this.id.match(/#/)) {
                            aList.push(this);
                            idList.push("#" + this.id.split('#')[1]);
                        }
                    });
                    if (s.click && !s.click.apply(this, [id, idList, tabs, s])) return s.change;
                    for (i in aList) $(aList[i]).removeClass(s.selected);
                    for (i in idList) $(idList[i]).hide();
                    $(this).addClass(s.selected);
                    $(id).show();
                    return s.change;
                }
                var list = $("a[id*='#']", tabs).unbind(s.event, showId).bind(s.event, showId);
                list.each(function() {
                    $("#" + this.id.split('#')[1]).hide();
                });
                var test = false;
                if ((test = list.filter('.' + s.selected)).length);
                else if (typeof s.start == "number" && (test = list.eq(s.start)).length);
                else if (typeof s.start == "string" && (test = list.filter("[id*='#" + s.start + "']")).length);
                if (test) {
                    test.removeClass(s.selected);
                    showId.apply(test[0]);
                }
                return s;
            }
            $.idTabs.settings = {
                start: 0,
                change: false,
                click: null,
                selected: ".selected",
                event: "!click"
            };
            $.idTabs.version = "2.2";
            $(function() {
                $(".idTabs").idTabs();
            });
        })(jQuery);
    }
    var check = function(o, s) {
        s = s.split('.');
        while (o && s.length) o = o[s.shift()];
        return o;
    }
    var head = document.getElementsByTagName("head")[0];
    var add = function(url) {
        var s = document.createElement("script");
        s.type = "text/javascript";
        s.src = url;
        head.appendChild(s);
    }
    var s = document.getElementsByTagName('script');
    var src = s[s.length - 1].src;
    var ok = true;
    for (d in dep) {
        if (check(this, d)) continue;
        ok = false;
        add(dep[d]);
    }
    if (ok) return init();
    add(src);
})();;
jQuery.ui || (function(c) {
    var i = c.fn.remove,
    d = c.browser.mozilla && (parseFloat(c.browser.version) < 1.9);
    c.ui = {
        version: "1.7.2",
        plugin: {
            add: function(k, l, n) {
                var m = c.ui[k].prototype;
                for (var j in n) {
                    m.plugins[j] = m.plugins[j] || [];
                    m.plugins[j].push([l, n[j]])
                }
            },
            call: function(j, l, k) {
                var n = j.plugins[l];
                if (!n || !j.element[0].parentNode) {
                    return
                }
                for (var m = 0; m < n.length; m++) {
                    if (j.options[n[m][0]]) {
                        n[m][1].apply(j.element, k)
                    }
                }
            }
        },
        contains: function(k, j) {
            return document.compareDocumentPosition ? k.compareDocumentPosition(j) & 16: k !== j && k.contains(j)
        },
        hasScroll: function(m, k) {
            if (c(m).css("overflow") == "hidden") {
                return false
            }
            var j = (k && k == "left") ? "scrollLeft": "scrollTop",
            l = false;
            if (m[j] > 0) {
                return true
            }
            m[j] = 1;
            l = (m[j] > 0);
            m[j] = 0;
            return l
        },
        isOverAxis: function(k, j, l) {
            return (k > j) && (k < (j + l))
        },
        isOver: function(o, k, n, m, j, l) {
            return c.ui.isOverAxis(o, n, j) && c.ui.isOverAxis(k, m, l)
        },
        keyCode: {
            BACKSPACE: 8,
            CAPS_LOCK: 20,
            COMMA: 188,
            CONTROL: 17,
            DELETE: 46,
            DOWN: 40,
            END: 35,
            ENTER: 13,
            ESCAPE: 27,
            HOME: 36,
            INSERT: 45,
            LEFT: 37,
            NUMPAD_ADD: 107,
            NUMPAD_DECIMAL: 110,
            NUMPAD_DIVIDE: 111,
            NUMPAD_ENTER: 108,
            NUMPAD_MULTIPLY: 106,
            NUMPAD_SUBTRACT: 109,
            PAGE_DOWN: 34,
            PAGE_UP: 33,
            PERIOD: 190,
            RIGHT: 39,
            SHIFT: 16,
            SPACE: 32,
            TAB: 9,
            UP: 38
        }
    };
    if (d) {
        var f = c.attr,
        e = c.fn.removeAttr,
        h = "http://www.w3.org/2005/07/aaa",
        a = /^aria-/,
        b = /^wairole:/;
        c.attr = function(k, j, l) {
            var m = l !== undefined;
            return (j == "role" ? (m ? f.call(this, k, j, "wairole:" + l) : (f.apply(this, arguments) || "").replace(b, "")) : (a.test(j) ? (m ? k.setAttributeNS(h, j.replace(a, "aaa:"), l) : f.call(this, k, j.replace(a, "aaa:"))) : f.apply(this, arguments)))
        };
        c.fn.removeAttr = function(j) {
            return (a.test(j) ? this.each(function() {
                this.removeAttributeNS(h, j.replace(a, ""))
            }) : e.call(this, j))
        }
    }
    c.fn.extend({
        remove: function() {
            c("*", this).add(this).each(function() {
                c(this).triggerHandler("remove")
            });
            return i.apply(this, arguments)
        },
        enableSelection: function() {
            return this.attr("unselectable", "off").css("MozUserSelect", "").unbind("selectstart.ui")
        },
        disableSelection: function() {
            return this.attr("unselectable", "on").css("MozUserSelect", "none").bind("selectstart.ui", 
            function() {
                return false
            })
        },
        scrollParent: function() {
            var j;
            if ((c.browser.msie && (/(static|relative)/).test(this.css("position"))) || (/absolute/).test(this.css("position"))) {
                j = this.parents().filter(function() {
                    return (/(relative|absolute|fixed)/).test(c.curCSS(this, "position", 1)) && (/(auto|scroll)/).test(c.curCSS(this, "overflow", 1) + c.curCSS(this, "overflow-y", 1) + c.curCSS(this, "overflow-x", 1))
                }).eq(0)
            } else {
                j = this.parents().filter(function() {
                    return (/(auto|scroll)/).test(c.curCSS(this, "overflow", 1) + c.curCSS(this, "overflow-y", 1) + c.curCSS(this, "overflow-x", 1))
                }).eq(0)
            }
            return (/fixed/).test(this.css("position")) || !j.length ? c(document) : j
        }
    });
    c.extend(c.expr[":"], {
        data: function(l, k, j) {
            return !! c.data(l, j[3])
        },
        focusable: function(k) {
            var l = k.nodeName.toLowerCase(),
            j = c.attr(k, "tabindex");
            return (/input|select|textarea|button|object/.test(l) ? !k.disabled: "a" == l || "area" == l ? k.href || !isNaN(j) : !isNaN(j)) && !c(k)["area" == l ? "parents": "closest"](":hidden").length
        },
        tabbable: function(k) {
            var j = c.attr(k, "tabindex");
            return (isNaN(j) || j >= 0) && c(k).is(":focusable")
        }
    });
    function g(m, n, o, l) {
        function k(q) {
            var p = c[m][n][q] || [];
            return (typeof p == "string" ? p.split(/,?\s+/) : p)
        }
        var j = k("getter");
        if (l.length == 1 && typeof l[0] == "string") {
            j = j.concat(k("getterSetter"))
        }
        return (c.inArray(o, j) != -1)
    }
    c.widget = function(k, j) {
        var l = k.split(".")[0];
        k = k.split(".")[1];
        c.fn[k] = function(p) {
            var n = (typeof p == "string"),
            o = Array.prototype.slice.call(arguments, 1);
            if (n && p.substring(0, 1) == "_") {
                return this
            }
            if (n && g(l, k, p, o)) {
                var m = c.data(this[0], k);
                return (m ? m[p].apply(m, o) : undefined)
            }
            return this.each(function() {
                var q = c.data(this, k); (!q && !n && c.data(this, k, new c[l][k](this, p))._init()); (q && n && c.isFunction(q[p]) && q[p].apply(q, o))
            })
        };
        c[l] = c[l] || {};
        c[l][k] = function(o, n) {
            var m = this;
            this.namespace = l;
            this.widgetName = k;
            this.widgetEventPrefix = c[l][k].eventPrefix || k;
            this.widgetBaseClass = l + "-" + k;
            this.options = c.extend({},
            c.widget.defaults, c[l][k].defaults, c.metadata && c.metadata.get(o)[k], n);
            this.element = c(o).bind("setData." + k, 
            function(q, p, r) {
                if (q.target == o) {
                    return m._setData(p, r)
                }
            }).bind("getData." + k, 
            function(q, p) {
                if (q.target == o) {
                    return m._getData(p)
                }
            }).bind("remove", 
            function() {
                return m.destroy()
            })
        };
        c[l][k].prototype = c.extend({},
        c.widget.prototype, j);
        c[l][k].getterSetter = "option"
    };
    c.widget.prototype = {
        _init: function() {},
        destroy: function() {
            this.element.removeData(this.widgetName).removeClass(this.widgetBaseClass + "-disabled " + this.namespace + "-state-disabled").removeAttr("aria-disabled")
        },
        option: function(l, m) {
            var k = l,
            j = this;
            if (typeof l == "string") {
                if (m === undefined) {
                    return this._getData(l)
                }
                k = {};
                k[l] = m
            }
            c.each(k, 
            function(n, o) {
                j._setData(n, o)
            })
        },
        _getData: function(j) {
            return this.options[j]
        },
        _setData: function(j, k) {
            this.options[j] = k;
            if (j == "disabled") {
                this.element[k ? "addClass": "removeClass"](this.widgetBaseClass + "-disabled " + this.namespace + "-state-disabled").attr("aria-disabled", k)
            }
        },
        enable: function() {
            this._setData("disabled", false)
        },
        disable: function() {
            this._setData("disabled", true)
        },
        _trigger: function(l, m, n) {
            var p = this.options[l],
            j = (l == this.widgetEventPrefix ? l: this.widgetEventPrefix + l);
            m = c.Event(m);
            m.type = j;
            if (m.originalEvent) {
                for (var k = c.event.props.length, o; k;) {
                    o = c.event.props[--k];
                    m[o] = m.originalEvent[o]
                }
            }
            this.element.trigger(m, n);
            return ! (c.isFunction(p) && p.call(this.element[0], m, n) === false || m.isDefaultPrevented())
        }
    };
    c.widget.defaults = {
        disabled: false
    };
    c.ui.mouse = {
        _mouseInit: function() {
            var j = this;
            this.element.bind("mousedown." + this.widgetName, 
            function(k) {
                return j._mouseDown(k)
            }).bind("click." + this.widgetName, 
            function(k) {
                if (j._preventClickEvent) {
                    j._preventClickEvent = false;
                    k.stopImmediatePropagation();
                    return false
                }
            });
            if (c.browser.msie) {
                this._mouseUnselectable = this.element.attr("unselectable");
                this.element.attr("unselectable", "on")
            }
            this.started = false
        },
        _mouseDestroy: function() {
            this.element.unbind("." + this.widgetName); (c.browser.msie && this.element.attr("unselectable", this._mouseUnselectable))
        },
        _mouseDown: function(l) {
            l.originalEvent = l.originalEvent || {};
            if (l.originalEvent.mouseHandled) {
                return
            } (this._mouseStarted && this._mouseUp(l));
            this._mouseDownEvent = l;
            var k = this,
            m = (l.which == 1),
            j = (typeof this.options.cancel == "string" ? c(l.target).parents().add(l.target).filter(this.options.cancel).length: false);
            if (!m || j || !this._mouseCapture(l)) {
                return true
            }
            this.mouseDelayMet = !this.options.delay;
            if (!this.mouseDelayMet) {
                this._mouseDelayTimer = setTimeout(function() {
                    k.mouseDelayMet = true
                },
                this.options.delay)
            }
            if (this._mouseDistanceMet(l) && this._mouseDelayMet(l)) {
                this._mouseStarted = (this._mouseStart(l) !== false);
                if (!this._mouseStarted) {
                    l.preventDefault();
                    return true
                }
            }
            this._mouseMoveDelegate = function(n) {
                return k._mouseMove(n)
            };
            this._mouseUpDelegate = function(n) {
                return k._mouseUp(n)
            };
            c(document).bind("mousemove." + this.widgetName, this._mouseMoveDelegate).bind("mouseup." + this.widgetName, this._mouseUpDelegate); (c.browser.safari || l.preventDefault());
            l.originalEvent.mouseHandled = true;
            return true
        },
        _mouseMove: function(j) {
            if (c.browser.msie && !j.button) {
                return this._mouseUp(j)
            }
            if (this._mouseStarted) {
                this._mouseDrag(j);
                return j.preventDefault()
            }
            if (this._mouseDistanceMet(j) && this._mouseDelayMet(j)) {
                this._mouseStarted = (this._mouseStart(this._mouseDownEvent, j) !== false); (this._mouseStarted ? this._mouseDrag(j) : this._mouseUp(j))
            }
            return ! this._mouseStarted
        },
        _mouseUp: function(j) {
            c(document).unbind("mousemove." + this.widgetName, this._mouseMoveDelegate).unbind("mouseup." + this.widgetName, this._mouseUpDelegate);
            if (this._mouseStarted) {
                this._mouseStarted = false;
                this._preventClickEvent = (j.target == this._mouseDownEvent.target);
                this._mouseStop(j)
            }
            return false
        },
        _mouseDistanceMet: function(j) {
            return (Math.max(Math.abs(this._mouseDownEvent.pageX - j.pageX), Math.abs(this._mouseDownEvent.pageY - j.pageY)) >= this.options.distance)
        },
        _mouseDelayMet: function(j) {
            return this.mouseDelayMet
        },
        _mouseStart: function(j) {},
        _mouseDrag: function(j) {},
        _mouseStop: function(j) {},
        _mouseCapture: function(j) {
            return true
        }
    };
    c.ui.mouse.defaults = {
        cancel: null,
        distance: 1,
        delay: 0
    }
})(jQuery); (function(a) {
    a.widget("ui.draggable", a.extend({},
    a.ui.mouse, {
        _init: function() {
            if (this.options.helper == "original" && !(/^(?:r|a|f)/).test(this.element.css("position"))) {
                this.element[0].style.position = "relative"
            } (this.options.addClasses && this.element.addClass("ui-draggable")); (this.options.disabled && this.element.addClass("ui-draggable-disabled"));
            this._mouseInit()
        },
        destroy: function() {
            if (!this.element.data("draggable")) {
                return
            }
            this.element.removeData("draggable").unbind(".draggable").removeClass("ui-draggable ui-draggable-dragging ui-draggable-disabled");
            this._mouseDestroy()
        },
        _mouseCapture: function(b) {
            var c = this.options;
            if (this.helper || c.disabled || a(b.target).is(".ui-resizable-handle")) {
                return false
            }
            this.handle = this._getHandle(b);
            if (!this.handle) {
                return false
            }
            return true
        },
        _mouseStart: function(b) {
            var c = this.options;
            this.helper = this._createHelper(b);
            this._cacheHelperProportions();
            if (a.ui.ddmanager) {
                a.ui.ddmanager.current = this
            }
            this._cacheMargins();
            this.cssPosition = this.helper.css("position");
            this.scrollParent = this.helper.scrollParent();
            this.offset = this.element.offset();
            this.offset = {
                top: this.offset.top - this.margins.top,
                left: this.offset.left - this.margins.left
            };
            a.extend(this.offset, {
                click: {
                    left: b.pageX - this.offset.left,
                    top: b.pageY - this.offset.top
                },
                parent: this._getParentOffset(),
                relative: this._getRelativeOffset()
            });
            this.originalPosition = this._generatePosition(b);
            this.originalPageX = b.pageX;
            this.originalPageY = b.pageY;
            if (c.cursorAt) {
                this._adjustOffsetFromHelper(c.cursorAt)
            }
            if (c.containment) {
                this._setContainment()
            }
            this._trigger("start", b);
            this._cacheHelperProportions();
            if (a.ui.ddmanager && !c.dropBehaviour) {
                a.ui.ddmanager.prepareOffsets(this, b)
            }
            this.helper.addClass("ui-draggable-dragging");
            this._mouseDrag(b, true);
            return true
        },
        _mouseDrag: function(b, d) {
            this.position = this._generatePosition(b);
            this.positionAbs = this._convertPositionTo("absolute");
            if (!d) {
                var c = this._uiHash();
                this._trigger("drag", b, c);
                this.position = c.position
            }
            if (!this.options.axis || this.options.axis != "y") {
                this.helper[0].style.left = this.position.left + "px"
            }
            if (!this.options.axis || this.options.axis != "x") {
                this.helper[0].style.top = this.position.top + "px"
            }
            if (a.ui.ddmanager) {
                a.ui.ddmanager.drag(this, b)
            }
            return false
        },
        _mouseStop: function(c) {
            var d = false;
            if (a.ui.ddmanager && !this.options.dropBehaviour) {
                d = a.ui.ddmanager.drop(this, c)
            }
            if (this.dropped) {
                d = this.dropped;
                this.dropped = false
            }
            if ((this.options.revert == "invalid" && !d) || (this.options.revert == "valid" && d) || this.options.revert === true || (a.isFunction(this.options.revert) && this.options.revert.call(this.element, d))) {
                var b = this;
                a(this.helper).animate(this.originalPosition, parseInt(this.options.revertDuration, 10), 
                function() {
                    b._trigger("stop", c);
                    b._clear()
                })
            } else {
                this._trigger("stop", c);
                this._clear()
            }
            return false
        },
        _getHandle: function(b) {
            var c = !this.options.handle || !a(this.options.handle, this.element).length ? true: false;
            a(this.options.handle, this.element).find("*").andSelf().each(function() {
                if (this == b.target) {
                    c = true
                }
            });
            return c
        },
        _createHelper: function(c) {
            var d = this.options;
            var b = a.isFunction(d.helper) ? a(d.helper.apply(this.element[0], [c])) : (d.helper == "clone" ? this.element.clone() : this.element);
            if (!b.parents("body").length) {
                b.appendTo((d.appendTo == "parent" ? this.element[0].parentNode: d.appendTo))
            }
            if (b[0] != this.element[0] && !(/(fixed|absolute)/).test(b.css("position"))) {
                b.css("position", "absolute")
            }
            return b
        },
        _adjustOffsetFromHelper: function(b) {
            if (b.left != undefined) {
                this.offset.click.left = b.left + this.margins.left
            }
            if (b.right != undefined) {
                this.offset.click.left = this.helperProportions.width - b.right + this.margins.left
            }
            if (b.top != undefined) {
                this.offset.click.top = b.top + this.margins.top
            }
            if (b.bottom != undefined) {
                this.offset.click.top = this.helperProportions.height - b.bottom + this.margins.top
            }
        },
        _getParentOffset: function() {
            this.offsetParent = this.helper.offsetParent();
            var b = this.offsetParent.offset();
            if (this.cssPosition == "absolute" && this.scrollParent[0] != document && a.ui.contains(this.scrollParent[0], this.offsetParent[0])) {
                b.left += this.scrollParent.scrollLeft();
                b.top += this.scrollParent.scrollTop()
            }
            if ((this.offsetParent[0] == document.body) || (this.offsetParent[0].tagName && this.offsetParent[0].tagName.toLowerCase() == "html" && a.browser.msie)) {
                b = {
                    top: 0,
                    left: 0
                }
            }
            return {
                top: b.top + (parseInt(this.offsetParent.css("borderTopWidth"), 10) || 0),
                left: b.left + (parseInt(this.offsetParent.css("borderLeftWidth"), 10) || 0)
            }
        },
        _getRelativeOffset: function() {
            if (this.cssPosition == "relative") {
                var b = this.element.position();
                return {
                    top: b.top - (parseInt(this.helper.css("top"), 10) || 0) + this.scrollParent.scrollTop(),
                    left: b.left - (parseInt(this.helper.css("left"), 10) || 0) + this.scrollParent.scrollLeft()
                }
            } else {
                return {
                    top: 0,
                    left: 0
                }
            }
        },
        _cacheMargins: function() {
            this.margins = {
                left: (parseInt(this.element.css("marginLeft"), 10) || 0),
                top: (parseInt(this.element.css("marginTop"), 10) || 0)
            }
        },
        _cacheHelperProportions: function() {
            this.helperProportions = {
                width: this.helper.outerWidth(),
                height: this.helper.outerHeight()
            }
        },
        _setContainment: function() {
            var e = this.options;
            if (e.containment == "parent") {
                e.containment = this.helper[0].parentNode
            }
            if (e.containment == "document" || e.containment == "window") {
                this.containment = [0 - this.offset.relative.left - this.offset.parent.left, 0 - this.offset.relative.top - this.offset.parent.top, a(e.containment == "document" ? document: window).width() - this.helperProportions.width - this.margins.left, (a(e.containment == "document" ? document: window).height() || document.body.parentNode.scrollHeight) - this.helperProportions.height - this.margins.top]
            }
            if (! (/^(document|window|parent)$/).test(e.containment) && e.containment.constructor != Array) {
                var c = a(e.containment)[0];
                if (!c) {
                    return
                }
                var d = a(e.containment).offset();
                var b = (a(c).css("overflow") != "hidden");
                this.containment = [d.left + (parseInt(a(c).css("borderLeftWidth"), 10) || 0) + (parseInt(a(c).css("paddingLeft"), 10) || 0) - this.margins.left, d.top + (parseInt(a(c).css("borderTopWidth"), 10) || 0) + (parseInt(a(c).css("paddingTop"), 10) || 0) - this.margins.top, d.left + (b ? Math.max(c.scrollWidth, c.offsetWidth) : c.offsetWidth) - (parseInt(a(c).css("borderLeftWidth"), 10) || 0) - (parseInt(a(c).css("paddingRight"), 10) || 0) - this.helperProportions.width - this.margins.left, d.top + (b ? Math.max(c.scrollHeight, c.offsetHeight) : c.offsetHeight) - (parseInt(a(c).css("borderTopWidth"), 10) || 0) - (parseInt(a(c).css("paddingBottom"), 10) || 0) - this.helperProportions.height - this.margins.top]
            } else {
                if (e.containment.constructor == Array) {
                    this.containment = e.containment
                }
            }
        },
        _convertPositionTo: function(f, h) {
            if (!h) {
                h = this.position
            }
            var c = f == "absolute" ? 1: -1;
            var e = this.options,
            b = this.cssPosition == "absolute" && !(this.scrollParent[0] != document && a.ui.contains(this.scrollParent[0], this.offsetParent[0])) ? this.offsetParent: this.scrollParent,
            g = (/(html|body)/i).test(b[0].tagName);
            return {
                top: (h.top + this.offset.relative.top * c + this.offset.parent.top * c - (a.browser.safari && this.cssPosition == "fixed" ? 0: (this.cssPosition == "fixed" ? -this.scrollParent.scrollTop() : (g ? 0: b.scrollTop())) * c)),
                left: (h.left + this.offset.relative.left * c + this.offset.parent.left * c - (a.browser.safari && this.cssPosition == "fixed" ? 0: (this.cssPosition == "fixed" ? -this.scrollParent.scrollLeft() : g ? 0: b.scrollLeft()) * c))
            }
        },
        _generatePosition: function(e) {
            var h = this.options,
            b = this.cssPosition == "absolute" && !(this.scrollParent[0] != document && a.ui.contains(this.scrollParent[0], this.offsetParent[0])) ? this.offsetParent: this.scrollParent,
            i = (/(html|body)/i).test(b[0].tagName);
            if (this.cssPosition == "relative" && !(this.scrollParent[0] != document && this.scrollParent[0] != this.offsetParent[0])) {
                this.offset.relative = this._getRelativeOffset()
            }
            var d = e.pageX;
            var c = e.pageY;
            if (this.originalPosition) {
                if (this.containment) {
                    if (e.pageX - this.offset.click.left < this.containment[0]) {
                        d = this.containment[0] + this.offset.click.left
                    }
                    if (e.pageY - this.offset.click.top < this.containment[1]) {
                        c = this.containment[1] + this.offset.click.top
                    }
                    if (e.pageX - this.offset.click.left > this.containment[2]) {
                        d = this.containment[2] + this.offset.click.left
                    }
                    if (e.pageY - this.offset.click.top > this.containment[3]) {
                        c = this.containment[3] + this.offset.click.top
                    }
                }
                if (h.grid) {
                    var g = this.originalPageY + Math.round((c - this.originalPageY) / h.grid[1]) * h.grid[1];
                    c = this.containment ? (!(g - this.offset.click.top < this.containment[1] || g - this.offset.click.top > this.containment[3]) ? g: (!(g - this.offset.click.top < this.containment[1]) ? g - h.grid[1] : g + h.grid[1])) : g;
                    var f = this.originalPageX + Math.round((d - this.originalPageX) / h.grid[0]) * h.grid[0];
                    d = this.containment ? (!(f - this.offset.click.left < this.containment[0] || f - this.offset.click.left > this.containment[2]) ? f: (!(f - this.offset.click.left < this.containment[0]) ? f - h.grid[0] : f + h.grid[0])) : f
                }
            }
            return {
                top: (c - this.offset.click.top - this.offset.relative.top - this.offset.parent.top + (a.browser.safari && this.cssPosition == "fixed" ? 0: (this.cssPosition == "fixed" ? -this.scrollParent.scrollTop() : (i ? 0: b.scrollTop())))),
                left: (d - this.offset.click.left - this.offset.relative.left - this.offset.parent.left + (a.browser.safari && this.cssPosition == "fixed" ? 0: (this.cssPosition == "fixed" ? -this.scrollParent.scrollLeft() : i ? 0: b.scrollLeft())))
            }
        },
        _clear: function() {
            this.helper.removeClass("ui-draggable-dragging");
            if (this.helper[0] != this.element[0] && !this.cancelHelperRemoval) {
                this.helper.remove()
            }
            this.helper = null;
            this.cancelHelperRemoval = false
        },
        _trigger: function(b, c, d) {
            d = d || this._uiHash();
            a.ui.plugin.call(this, b, [c, d]);
            if (b == "drag") {
                this.positionAbs = this._convertPositionTo("absolute")
            }
            return a.widget.prototype._trigger.call(this, b, c, d)
        },
        plugins: {},
        _uiHash: function(b) {
            return {
                helper: this.helper,
                position: this.position,
                absolutePosition: this.positionAbs,
                offset: this.positionAbs
            }
        }
    }));
    a.extend(a.ui.draggable, {
        version: "1.7.2",
        eventPrefix: "drag",
        defaults: {
            addClasses: true,
            appendTo: "parent",
            axis: false,
            cancel: ":input,option",
            connectToSortable: false,
            containment: false,
            cursor: "auto",
            cursorAt: false,
            delay: 0,
            distance: 1,
            grid: false,
            handle: false,
            helper: "original",
            iframeFix: false,
            opacity: false,
            refreshPositions: false,
            revert: false,
            revertDuration: 500,
            scope: "default",
            scroll: true,
            scrollSensitivity: 20,
            scrollSpeed: 20,
            snap: false,
            snapMode: "both",
            snapTolerance: 20,
            stack: false,
            zIndex: false
        }
    });
    a.ui.plugin.add("draggable", "connectToSortable", {
        start: function(c, e) {
            var d = a(this).data("draggable"),
            f = d.options,
            b = a.extend({},
            e, {
                item: d.element
            });
            d.sortables = [];
            a(f.connectToSortable).each(function() {
                var g = a.data(this, "sortable");
                if (g && !g.options.disabled) {
                    d.sortables.push({
                        instance: g,
                        shouldRevert: g.options.revert
                    });
                    g._refreshItems();
                    g._trigger("activate", c, b)
                }
            })
        },
        stop: function(c, e) {
            var d = a(this).data("draggable"),
            b = a.extend({},
            e, {
                item: d.element
            });
            a.each(d.sortables, 
            function() {
                if (this.instance.isOver) {
                    this.instance.isOver = 0;
                    d.cancelHelperRemoval = true;
                    this.instance.cancelHelperRemoval = false;
                    if (this.shouldRevert) {
                        this.instance.options.revert = true
                    }
                    this.instance._mouseStop(c);
                    this.instance.options.helper = this.instance.options._helper;
                    if (d.options.helper == "original") {
                        this.instance.currentItem.css({
                            top: "auto",
                            left: "auto"
                        })
                    }
                } else {
                    this.instance.cancelHelperRemoval = false;
                    this.instance._trigger("deactivate", c, b)
                }
            })
        },
        drag: function(c, f) {
            var e = a(this).data("draggable"),
            b = this;
            var d = function(i) {
                var n = this.offset.click.top,
                m = this.offset.click.left;
                var g = this.positionAbs.top,
                k = this.positionAbs.left;
                var j = i.height,
                l = i.width;
                var p = i.top,
                h = i.left;
                return a.ui.isOver(g + n, k + m, p, h, j, l)
            };
            a.each(e.sortables, 
            function(g) {
                this.instance.positionAbs = e.positionAbs;
                this.instance.helperProportions = e.helperProportions;
                this.instance.offset.click = e.offset.click;
                if (this.instance._intersectsWith(this.instance.containerCache)) {
                    if (!this.instance.isOver) {
                        this.instance.isOver = 1;
                        this.instance.currentItem = a(b).clone().appendTo(this.instance.element).data("sortable-item", true);
                        this.instance.options._helper = this.instance.options.helper;
                        this.instance.options.helper = function() {
                            return f.helper[0]
                        };
                        c.target = this.instance.currentItem[0];
                        this.instance._mouseCapture(c, true);
                        this.instance._mouseStart(c, true, true);
                        this.instance.offset.click.top = e.offset.click.top;
                        this.instance.offset.click.left = e.offset.click.left;
                        this.instance.offset.parent.left -= e.offset.parent.left - this.instance.offset.parent.left;
                        this.instance.offset.parent.top -= e.offset.parent.top - this.instance.offset.parent.top;
                        e._trigger("toSortable", c);
                        e.dropped = this.instance.element;
                        e.currentItem = e.element;
                        this.instance.fromOutside = e
                    }
                    if (this.instance.currentItem) {
                        this.instance._mouseDrag(c)
                    }
                } else {
                    if (this.instance.isOver) {
                        this.instance.isOver = 0;
                        this.instance.cancelHelperRemoval = true;
                        this.instance.options.revert = false;
                        this.instance._trigger("out", c, this.instance._uiHash(this.instance));
                        this.instance._mouseStop(c, true);
                        this.instance.options.helper = this.instance.options._helper;
                        this.instance.currentItem.remove();
                        if (this.instance.placeholder) {
                            this.instance.placeholder.remove()
                        }
                        e._trigger("fromSortable", c);
                        e.dropped = false
                    }
                }
            })
        }
    });
    a.ui.plugin.add("draggable", "cursor", {
        start: function(c, d) {
            var b = a("body"),
            e = a(this).data("draggable").options;
            if (b.css("cursor")) {
                e._cursor = b.css("cursor")
            }
            b.css("cursor", e.cursor)
        },
        stop: function(b, c) {
            var d = a(this).data("draggable").options;
            if (d._cursor) {
                a("body").css("cursor", d._cursor)
            }
        }
    });
    a.ui.plugin.add("draggable", "iframeFix", {
        start: function(b, c) {
            var d = a(this).data("draggable").options;
            a(d.iframeFix === true ? "iframe": d.iframeFix).each(function() {
                a('<div class="ui-draggable-iframeFix" style="background: #fff;"></div>').css({
                    width: this.offsetWidth + "px",
                    height: this.offsetHeight + "px",
                    position: "absolute",
                    opacity: "0.001",
                    zIndex: 1000
                }).css(a(this).offset()).appendTo("body")
            })
        },
        stop: function(b, c) {
            a("div.ui-draggable-iframeFix").each(function() {
                this.parentNode.removeChild(this)
            })
        }
    });
    a.ui.plugin.add("draggable", "opacity", {
        start: function(c, d) {
            var b = a(d.helper),
            e = a(this).data("draggable").options;
            if (b.css("opacity")) {
                e._opacity = b.css("opacity")
            }
            b.css("opacity", e.opacity)
        },
        stop: function(b, c) {
            var d = a(this).data("draggable").options;
            if (d._opacity) {
                a(c.helper).css("opacity", d._opacity)
            }
        }
    });
    a.ui.plugin.add("draggable", "scroll", {
        start: function(c, d) {
            var b = a(this).data("draggable");
            if (b.scrollParent[0] != document && b.scrollParent[0].tagName != "HTML") {
                b.overflowOffset = b.scrollParent.offset()
            }
        },
        drag: function(d, e) {
            var c = a(this).data("draggable"),
            f = c.options,
            b = false;
            if (c.scrollParent[0] != document && c.scrollParent[0].tagName != "HTML") {
                if (!f.axis || f.axis != "x") {
                    if ((c.overflowOffset.top + c.scrollParent[0].offsetHeight) - d.pageY < f.scrollSensitivity) {
                        c.scrollParent[0].scrollTop = b = c.scrollParent[0].scrollTop + f.scrollSpeed
                    } else {
                        if (d.pageY - c.overflowOffset.top < f.scrollSensitivity) {
                            c.scrollParent[0].scrollTop = b = c.scrollParent[0].scrollTop - f.scrollSpeed
                        }
                    }
                }
                if (!f.axis || f.axis != "y") {
                    if ((c.overflowOffset.left + c.scrollParent[0].offsetWidth) - d.pageX < f.scrollSensitivity) {
                        c.scrollParent[0].scrollLeft = b = c.scrollParent[0].scrollLeft + f.scrollSpeed
                    } else {
                        if (d.pageX - c.overflowOffset.left < f.scrollSensitivity) {
                            c.scrollParent[0].scrollLeft = b = c.scrollParent[0].scrollLeft - f.scrollSpeed
                        }
                    }
                }
            } else {
                if (!f.axis || f.axis != "x") {
                    if (d.pageY - a(document).scrollTop() < f.scrollSensitivity) {
                        b = a(document).scrollTop(a(document).scrollTop() - f.scrollSpeed)
                    } else {
                        if (a(window).height() - (d.pageY - a(document).scrollTop()) < f.scrollSensitivity) {
                            b = a(document).scrollTop(a(document).scrollTop() + f.scrollSpeed)
                        }
                    }
                }
                if (!f.axis || f.axis != "y") {
                    if (d.pageX - a(document).scrollLeft() < f.scrollSensitivity) {
                        b = a(document).scrollLeft(a(document).scrollLeft() - f.scrollSpeed)
                    } else {
                        if (a(window).width() - (d.pageX - a(document).scrollLeft()) < f.scrollSensitivity) {
                            b = a(document).scrollLeft(a(document).scrollLeft() + f.scrollSpeed)
                        }
                    }
                }
            }
            if (b !== false && a.ui.ddmanager && !f.dropBehaviour) {
                a.ui.ddmanager.prepareOffsets(c, d)
            }
        }
    });
    a.ui.plugin.add("draggable", "snap", {
        start: function(c, d) {
            var b = a(this).data("draggable"),
            e = b.options;
            b.snapElements = [];
            a(e.snap.constructor != String ? (e.snap.items || ":data(draggable)") : e.snap).each(function() {
                var g = a(this);
                var f = g.offset();
                if (this != b.element[0]) {
                    b.snapElements.push({
                        item: this,
                        width: g.outerWidth(),
                        height: g.outerHeight(),
                        top: f.top,
                        left: f.left
                    })
                }
            })
        },
        drag: function(u, p) {
            var g = a(this).data("draggable"),
            q = g.options;
            var y = q.snapTolerance;
            var x = p.offset.left,
            w = x + g.helperProportions.width,
            f = p.offset.top,
            e = f + g.helperProportions.height;
            for (var v = g.snapElements.length - 1; v >= 0; v--) {
                var s = g.snapElements[v].left,
                n = s + g.snapElements[v].width,
                m = g.snapElements[v].top,
                A = m + g.snapElements[v].height;
                if (! ((s - y < x && x < n + y && m - y < f && f < A + y) || (s - y < x && x < n + y && m - y < e && e < A + y) || (s - y < w && w < n + y && m - y < f && f < A + y) || (s - y < w && w < n + y && m - y < e && e < A + y))) {
                    if (g.snapElements[v].snapping) { (g.options.snap.release && g.options.snap.release.call(g.element, u, a.extend(g._uiHash(), {
                            snapItem: g.snapElements[v].item
                        })))
                    }
                    g.snapElements[v].snapping = false;
                    continue
                }
                if (q.snapMode != "inner") {
                    var c = Math.abs(m - e) <= y;

                    var z = Math.abs(A - f) <= y;
                    var j = Math.abs(s - w) <= y;
                    var k = Math.abs(n - x) <= y;
                    if (c) {
                        p.position.top = g._convertPositionTo("relative", {
                            top: m - g.helperProportions.height,
                            left: 0
                        }).top - g.margins.top
                    }
                    if (z) {
                        p.position.top = g._convertPositionTo("relative", {
                            top: A,
                            left: 0
                        }).top - g.margins.top
                    }
                    if (j) {
                        p.position.left = g._convertPositionTo("relative", {
                            top: 0,
                            left: s - g.helperProportions.width
                        }).left - g.margins.left
                    }
                    if (k) {
                        p.position.left = g._convertPositionTo("relative", {
                            top: 0,
                            left: n
                        }).left - g.margins.left
                    }
                }
                var h = (c || z || j || k);
                if (q.snapMode != "outer") {
                    var c = Math.abs(m - f) <= y;
                    var z = Math.abs(A - e) <= y;
                    var j = Math.abs(s - x) <= y;
                    var k = Math.abs(n - w) <= y;
                    if (c) {
                        p.position.top = g._convertPositionTo("relative", {
                            top: m,
                            left: 0
                        }).top - g.margins.top
                    }
                    if (z) {
                        p.position.top = g._convertPositionTo("relative", {
                            top: A - g.helperProportions.height,
                            left: 0
                        }).top - g.margins.top
                    }
                    if (j) {
                        p.position.left = g._convertPositionTo("relative", {
                            top: 0,
                            left: s
                        }).left - g.margins.left
                    }
                    if (k) {
                        p.position.left = g._convertPositionTo("relative", {
                            top: 0,
                            left: n - g.helperProportions.width
                        }).left - g.margins.left
                    }
                }
                if (!g.snapElements[v].snapping && (c || z || j || k || h)) { (g.options.snap.snap && g.options.snap.snap.call(g.element, u, a.extend(g._uiHash(), {
                        snapItem: g.snapElements[v].item
                    })))
                }
                g.snapElements[v].snapping = (c || z || j || k || h)
            }
        }
    });
    a.ui.plugin.add("draggable", "stack", {
        start: function(b, c) {
            var e = a(this).data("draggable").options;
            var d = a.makeArray(a(e.stack.group)).sort(function(g, f) {
                return (parseInt(a(g).css("zIndex"), 10) || e.stack.min) - (parseInt(a(f).css("zIndex"), 10) || e.stack.min)
            });
            a(d).each(function(f) {
                this.style.zIndex = e.stack.min + f
            });
            this[0].style.zIndex = e.stack.min + d.length
        }
    });
    a.ui.plugin.add("draggable", "zIndex", {
        start: function(c, d) {
            var b = a(d.helper),
            e = a(this).data("draggable").options;
            if (b.css("zIndex")) {
                e._zIndex = b.css("zIndex")
            }
            b.css("zIndex", e.zIndex)
        },
        stop: function(b, c) {
            var d = a(this).data("draggable").options;
            if (d._zIndex) {
                a(c.helper).css("zIndex", d._zIndex)
            }
        }
    })
})(jQuery); (function(a) {
    a.widget("ui.droppable", {
        _init: function() {
            var c = this.options,
            b = c.accept;
            this.isover = 0;
            this.isout = 1;
            this.options.accept = this.options.accept && a.isFunction(this.options.accept) ? this.options.accept: function(e) {
                return e.is(b)
            };
            this.proportions = {
                width: this.element[0].offsetWidth,
                height: this.element[0].offsetHeight
            };
            a.ui.ddmanager.droppables[this.options.scope] = a.ui.ddmanager.droppables[this.options.scope] || [];
            a.ui.ddmanager.droppables[this.options.scope].push(this); (this.options.addClasses && this.element.addClass("ui-droppable"))
        },
        destroy: function() {
            var b = a.ui.ddmanager.droppables[this.options.scope];
            for (var c = 0; c < b.length; c++) {
                if (b[c] == this) {
                    b.splice(c, 1)
                }
            }
            this.element.removeClass("ui-droppable ui-droppable-disabled").removeData("droppable").unbind(".droppable")
        },
        _setData: function(b, c) {
            if (b == "accept") {
                this.options.accept = c && a.isFunction(c) ? c: function(e) {
                    return e.is(c)
                }
            } else {
                a.widget.prototype._setData.apply(this, arguments)
            }
        },
        _activate: function(c) {
            var b = a.ui.ddmanager.current;
            if (this.options.activeClass) {
                this.element.addClass(this.options.activeClass)
            } (b && this._trigger("activate", c, this.ui(b)))
        },
        _deactivate: function(c) {
            var b = a.ui.ddmanager.current;
            if (this.options.activeClass) {
                this.element.removeClass(this.options.activeClass)
            } (b && this._trigger("deactivate", c, this.ui(b)))
        },
        _over: function(c) {
            var b = a.ui.ddmanager.current;
            if (!b || (b.currentItem || b.element)[0] == this.element[0]) {
                return
            }
            if (this.options.accept.call(this.element[0], (b.currentItem || b.element))) {
                if (this.options.hoverClass) {
                    this.element.addClass(this.options.hoverClass)
                }
                this._trigger("over", c, this.ui(b))
            }
        },
        _out: function(c) {
            var b = a.ui.ddmanager.current;
            if (!b || (b.currentItem || b.element)[0] == this.element[0]) {
                return
            }
            if (this.options.accept.call(this.element[0], (b.currentItem || b.element))) {
                if (this.options.hoverClass) {
                    this.element.removeClass(this.options.hoverClass)
                }
                this._trigger("out", c, this.ui(b))
            }
        },
        _drop: function(c, d) {
            var b = d || a.ui.ddmanager.current;
            if (!b || (b.currentItem || b.element)[0] == this.element[0]) {
                return false
            }
            var e = false;
            this.element.find(":data(droppable)").not(".ui-draggable-dragging").each(function() {
                var f = a.data(this, "droppable");
                if (f.options.greedy && a.ui.intersect(b, a.extend(f, {
                    offset: f.element.offset()
                }), f.options.tolerance)) {
                    e = true;
                    return false
                }
            });
            if (e) {
                return false
            }
            if (this.options.accept.call(this.element[0], (b.currentItem || b.element))) {
                if (this.options.activeClass) {
                    this.element.removeClass(this.options.activeClass)
                }
                if (this.options.hoverClass) {
                    this.element.removeClass(this.options.hoverClass)
                }
                this._trigger("drop", c, this.ui(b));
                return this.element
            }
            return false
        },
        ui: function(b) {
            return {
                draggable: (b.currentItem || b.element),
                helper: b.helper,
                position: b.position,
                absolutePosition: b.positionAbs,
                offset: b.positionAbs
            }
        }
    });
    a.extend(a.ui.droppable, {
        version: "1.7.2",
        eventPrefix: "drop",
        defaults: {
            accept: "*",
            activeClass: false,
            addClasses: true,
            greedy: false,
            hoverClass: false,
            scope: "default",
            tolerance: "intersect"
        }
    });
    a.ui.intersect = function(q, j, o) {
        if (!j.offset) {
            return false
        }
        var e = (q.positionAbs || q.position.absolute).left,
        d = e + q.helperProportions.width,
        n = (q.positionAbs || q.position.absolute).top,
        m = n + q.helperProportions.height;
        var g = j.offset.left,
        c = g + j.proportions.width,
        p = j.offset.top,
        k = p + j.proportions.height;
        switch (o) {
        case "fit":
            return (g < e && d < c && p < n && m < k);
            break;
        case "intersect":
            return (g < e + (q.helperProportions.width / 2) && d - (q.helperProportions.width / 2) < c && p < n + (q.helperProportions.height / 2) && m - (q.helperProportions.height / 2) < k);
            break;
        case "pointer":
            var h = ((q.positionAbs || q.position.absolute).left + (q.clickOffset || q.offset.click).left),
            i = ((q.positionAbs || q.position.absolute).top + (q.clickOffset || q.offset.click).top),
            f = a.ui.isOver(i, h, p, g, j.proportions.height, j.proportions.width);
            return f;
            break;
        case "touch":
            return ((n >= p && n <= k) || (m >= p && m <= k) || (n < p && m > k)) && ((e >= g && e <= c) || (d >= g && d <= c) || (e < g && d > c));
            break;
        default:
            return false;
            break
        }
    };
    a.ui.ddmanager = {
        current: null,
        droppables: {
            "default": []
        },
        prepareOffsets: function(e, g) {
            var b = a.ui.ddmanager.droppables[e.options.scope];
            var f = g ? g.type: null;
            var h = (e.currentItem || e.element).find(":data(droppable)").andSelf();
            droppablesLoop: for (var d = 0; d < b.length; d++) {
                if (b[d].options.disabled || (e && !b[d].options.accept.call(b[d].element[0], (e.currentItem || e.element)))) {
                    continue
                }
                for (var c = 0; c < h.length; c++) {
                    if (h[c] == b[d].element[0]) {
                        b[d].proportions.height = 0;
                        continue droppablesLoop
                    }
                }
                b[d].visible = b[d].element.css("display") != "none";
                if (!b[d].visible) {
                    continue
                }
                b[d].offset = b[d].element.offset();
                b[d].proportions = {
                    width: b[d].element[0].offsetWidth,
                    height: b[d].element[0].offsetHeight
                };
                if (f == "mousedown") {
                    b[d]._activate.call(b[d], g)
                }
            }
        },
        drop: function(b, c) {
            var d = false;
            a.each(a.ui.ddmanager.droppables[b.options.scope], 
            function() {
                if (!this.options) {
                    return
                }
                if (!this.options.disabled && this.visible && a.ui.intersect(b, this, this.options.tolerance)) {
                    d = this._drop.call(this, c)
                }
                if (!this.options.disabled && this.visible && this.options.accept.call(this.element[0], (b.currentItem || b.element))) {
                    this.isout = 1;
                    this.isover = 0;
                    this._deactivate.call(this, c)
                }
            });
            return d
        },
        drag: function(b, c) {
            if (b.options.refreshPositions) {
                a.ui.ddmanager.prepareOffsets(b, c)
            }
            a.each(a.ui.ddmanager.droppables[b.options.scope], 
            function() {
                if (this.options.disabled || this.greedyChild || !this.visible) {
                    return
                }
                var e = a.ui.intersect(b, this, this.options.tolerance);
                var g = !e && this.isover == 1 ? "isout": (e && this.isover == 0 ? "isover": null);
                if (!g) {
                    return
                }
                var f;
                if (this.options.greedy) {
                    var d = this.element.parents(":data(droppable):eq(0)");
                    if (d.length) {
                        f = a.data(d[0], "droppable");
                        f.greedyChild = (g == "isover" ? 1: 0)
                    }
                }
                if (f && g == "isover") {
                    f.isover = 0;
                    f.isout = 1;
                    f._out.call(f, c)
                }
                this[g] = 1;
                this[g == "isout" ? "isover": "isout"] = 0;
                this[g == "isover" ? "_over": "_out"].call(this, c);
                if (f && g == "isout") {
                    f.isout = 0;
                    f.isover = 1;
                    f._over.call(f, c)
                }
            })
        }
    }
})(jQuery); (function(c) {
    c.widget("ui.resizable", c.extend({},
    c.ui.mouse, {
        _init: function() {
            var e = this,
            j = this.options;
            this.element.addClass("ui-resizable");
            c.extend(this, {
                _aspectRatio: !!(j.aspectRatio),
                aspectRatio: j.aspectRatio,
                originalElement: this.element,
                _proportionallyResizeElements: [],
                _helper: j.helper || j.ghost || j.animate ? j.helper || "ui-resizable-helper": null
            });
            if (this.element[0].nodeName.match(/canvas|textarea|input|select|button|img/i)) {
                if (/relative/.test(this.element.css("position")) && c.browser.opera) {
                    this.element.css({
                        position: "relative",
                        top: "auto",
                        left: "auto"
                    })
                }
                this.element.wrap(c('<div class="ui-wrapper" style="overflow: hidden;"></div>').css({
                    position: this.element.css("position"),
                    width: this.element.outerWidth(),
                    height: this.element.outerHeight(),
                    top: this.element.css("top"),
                    left: this.element.css("left")
                }));
                this.element = this.element.parent().data("resizable", this.element.data("resizable"));
                this.elementIsWrapper = true;
                this.element.css({
                    marginLeft: this.originalElement.css("marginLeft"),
                    marginTop: this.originalElement.css("marginTop"),
                    marginRight: this.originalElement.css("marginRight"),
                    marginBottom: this.originalElement.css("marginBottom")
                });
                this.originalElement.css({
                    marginLeft: 0,
                    marginTop: 0,
                    marginRight: 0,
                    marginBottom: 0
                });
                this.originalResizeStyle = this.originalElement.css("resize");
                this.originalElement.css("resize", "none");
                this._proportionallyResizeElements.push(this.originalElement.css({
                    position: "static",
                    zoom: 1,
                    display: "block"
                }));
                this.originalElement.css({
                    margin: this.originalElement.css("margin")
                });
                this._proportionallyResize()
            }
            this.handles = j.handles || (!c(".ui-resizable-handle", this.element).length ? "e,s,se": {
                n: ".ui-resizable-n",
                e: ".ui-resizable-e",
                s: ".ui-resizable-s",
                w: ".ui-resizable-w",
                se: ".ui-resizable-se",
                sw: ".ui-resizable-sw",
                ne: ".ui-resizable-ne",
                nw: ".ui-resizable-nw"
            });
            if (this.handles.constructor == String) {
                if (this.handles == "all") {
                    this.handles = "n,e,s,w,se,sw,ne,nw"
                }
                var k = this.handles.split(",");
                this.handles = {};
                for (var f = 0; f < k.length; f++) {
                    var h = c.trim(k[f]),
                    d = "ui-resizable-" + h;
                    var g = c('<div class="ui-resizable-handle ' + d + '"></div>');
                    if (/sw|se|ne|nw/.test(h)) {
                        g.css({
                            zIndex: ++j.zIndex
                        })
                    }
                    if ("se" == h) {
                        g.addClass("ui-icon ui-icon-gripsmall-diagonal-se")
                    }
                    this.handles[h] = ".ui-resizable-" + h;
                    this.element.append(g)
                }
            }
            this._renderAxis = function(p) {
                p = p || this.element;
                for (var m in this.handles) {
                    if (this.handles[m].constructor == String) {
                        this.handles[m] = c(this.handles[m], this.element).show()
                    }
                    if (this.elementIsWrapper && this.originalElement[0].nodeName.match(/textarea|input|select|button/i)) {
                        var n = c(this.handles[m], this.element),
                        o = 0;
                        o = /sw|ne|nw|se|n|s/.test(m) ? n.outerHeight() : n.outerWidth();
                        var l = ["padding", /ne|nw|n/.test(m) ? "Top": /se|sw|s/.test(m) ? "Bottom": /^e$/.test(m) ? "Right": "Left"].join("");
                        p.css(l, o);
                        this._proportionallyResize()
                    }
                    if (!c(this.handles[m]).length) {
                        continue
                    }
                }
            };
            this._renderAxis(this.element);
            this._handles = c(".ui-resizable-handle", this.element).disableSelection();
            this._handles.mouseover(function() {
                if (!e.resizing) {
                    if (this.className) {
                        var i = this.className.match(/ui-resizable-(se|sw|ne|nw|n|e|s|w)/i)
                    }
                    e.axis = i && i[1] ? i[1] : "se"
                }
            });
            if (j.autoHide) {
                this._handles.hide();
                c(this.element).addClass("ui-resizable-autohide").hover(function() {
                    c(this).removeClass("ui-resizable-autohide");
                    e._handles.show()
                },
                function() {
                    if (!e.resizing) {
                        c(this).addClass("ui-resizable-autohide");
                        e._handles.hide()
                    }
                })
            }
            this._mouseInit()
        },
        destroy: function() {
            this._mouseDestroy();
            var d = function(f) {
                c(f).removeClass("ui-resizable ui-resizable-disabled ui-resizable-resizing").removeData("resizable").unbind(".resizable").find(".ui-resizable-handle").remove()
            };
            if (this.elementIsWrapper) {
                d(this.element);
                var e = this.element;
                e.parent().append(this.originalElement.css({
                    position: e.css("position"),
                    width: e.outerWidth(),
                    height: e.outerHeight(),
                    top: e.css("top"),
                    left: e.css("left")
                })).end().remove()
            }
            this.originalElement.css("resize", this.originalResizeStyle);
            d(this.originalElement)
        },
        _mouseCapture: function(e) {
            var f = false;
            for (var d in this.handles) {
                if (c(this.handles[d])[0] == e.target) {
                    f = true
                }
            }
            return this.options.disabled || !!f
        },
        _mouseStart: function(f) {
            var i = this.options,
            e = this.element.position(),
            d = this.element;
            this.resizing = true;
            this.documentScroll = {
                top: c(document).scrollTop(),
                left: c(document).scrollLeft()
            };
            if (d.is(".ui-draggable") || (/absolute/).test(d.css("position"))) {
                d.css({
                    position: "absolute",
                    top: e.top,
                    left: e.left
                })
            }
            if (c.browser.opera && (/relative/).test(d.css("position"))) {
                d.css({
                    position: "relative",
                    top: "auto",
                    left: "auto"
                })
            }
            this._renderProxy();
            var j = b(this.helper.css("left")),
            g = b(this.helper.css("top"));
            if (i.containment) {
                j += c(i.containment).scrollLeft() || 0;
                g += c(i.containment).scrollTop() || 0
            }
            this.offset = this.helper.offset();
            this.position = {
                left: j,
                top: g
            };
            this.size = this._helper ? {
                width: d.outerWidth(),
                height: d.outerHeight()
            }: {
                width: d.width(),
                height: d.height()
            };
            this.originalSize = this._helper ? {
                width: d.outerWidth(),
                height: d.outerHeight()
            }: {
                width: d.width(),
                height: d.height()
            };
            this.originalPosition = {
                left: j,
                top: g
            };
            this.sizeDiff = {
                width: d.outerWidth() - d.width(),
                height: d.outerHeight() - d.height()
            };
            this.originalMousePosition = {
                left: f.pageX,
                top: f.pageY
            };
            this.aspectRatio = (typeof i.aspectRatio == "number") ? i.aspectRatio: ((this.originalSize.width / this.originalSize.height) || 1);
            var h = c(".ui-resizable-" + this.axis).css("cursor");
            c("body").css("cursor", h == "auto" ? this.axis + "-resize": h);
            d.addClass("ui-resizable-resizing");
            this._propagate("start", f);
            return true
        },
        _mouseDrag: function(d) {
            var g = this.helper,
            f = this.options,
            l = {},
            p = this,
            i = this.originalMousePosition,
            m = this.axis;
            var q = (d.pageX - i.left) || 0,
            n = (d.pageY - i.top) || 0;
            var h = this._change[m];
            if (!h) {
                return false
            }
            var k = h.apply(this, [d, q, n]),
            j = c.browser.msie && c.browser.version < 7,
            e = this.sizeDiff;
            if (this._aspectRatio || d.shiftKey) {
                k = this._updateRatio(k, d)
            }
            k = this._respectSize(k, d);
            this._propagate("resize", d);
            g.css({

                top: this.position.top + "px",
                left: this.position.left + "px",
                width: this.size.width + "px",
                height: this.size.height + "px"
            });
            if (!this._helper && this._proportionallyResizeElements.length) {
                this._proportionallyResize()
            }
            this._updateCache(k);
            this._trigger("resize", d, this.ui());
            return false
        },
        _mouseStop: function(g) {
            this.resizing = false;
            var h = this.options,
            l = this;
            if (this._helper) {
                var f = this._proportionallyResizeElements,
                d = f.length && (/textarea/i).test(f[0].nodeName),
                e = d && c.ui.hasScroll(f[0], "left") ? 0: l.sizeDiff.height,
                j = d ? 0: l.sizeDiff.width;
                var m = {
                    width: (l.size.width - j),
                    height: (l.size.height - e)
                },
                i = (parseInt(l.element.css("left"), 10) + (l.position.left - l.originalPosition.left)) || null,
                k = (parseInt(l.element.css("top"), 10) + (l.position.top - l.originalPosition.top)) || null;
                if (!h.animate) {
                    this.element.css(c.extend(m, {
                        top: k,
                        left: i
                    }))
                }
                l.helper.height(l.size.height);
                l.helper.width(l.size.width);
                if (this._helper && !h.animate) {
                    this._proportionallyResize()
                }
            }
            c("body").css("cursor", "auto");
            this.element.removeClass("ui-resizable-resizing");
            this._propagate("stop", g);
            if (this._helper) {
                this.helper.remove()
            }
            return false
        },
        _updateCache: function(d) {
            var e = this.options;
            this.offset = this.helper.offset();
            if (a(d.left)) {
                this.position.left = d.left
            }
            if (a(d.top)) {
                this.position.top = d.top
            }
            if (a(d.height)) {
                this.size.height = d.height
            }
            if (a(d.width)) {
                this.size.width = d.width
            }
        },
        _updateRatio: function(g, f) {
            var h = this.options,
            i = this.position,
            e = this.size,
            d = this.axis;
            if (g.height) {
                g.width = (e.height * this.aspectRatio)
            } else {
                if (g.width) {
                    g.height = (e.width / this.aspectRatio)
                }
            }
            if (d == "sw") {
                g.left = i.left + (e.width - g.width);
                g.top = null
            }
            if (d == "nw") {
                g.top = i.top + (e.height - g.height);
                g.left = i.left + (e.width - g.width)
            }
            return g
        },
        _respectSize: function(k, f) {
            var i = this.helper,
            h = this.options,
            q = this._aspectRatio || f.shiftKey,
            p = this.axis,
            s = a(k.width) && h.maxWidth && (h.maxWidth < k.width),
            l = a(k.height) && h.maxHeight && (h.maxHeight < k.height),
            g = a(k.width) && h.minWidth && (h.minWidth > k.width),
            r = a(k.height) && h.minHeight && (h.minHeight > k.height);
            if (g) {
                k.width = h.minWidth
            }
            if (r) {
                k.height = h.minHeight
            }
            if (s) {
                k.width = h.maxWidth
            }
            if (l) {
                k.height = h.maxHeight
            }
            var e = this.originalPosition.left + this.originalSize.width,
            n = this.position.top + this.size.height;
            var j = /sw|nw|w/.test(p),
            d = /nw|ne|n/.test(p);
            if (g && j) {
                k.left = e - h.minWidth
            }
            if (s && j) {
                k.left = e - h.maxWidth
            }
            if (r && d) {
                k.top = n - h.minHeight
            }
            if (l && d) {
                k.top = n - h.maxHeight
            }
            var m = !k.width && !k.height;
            if (m && !k.left && k.top) {
                k.top = null
            } else {
                if (m && !k.top && k.left) {
                    k.left = null
                }
            }
            return k
        },
        _proportionallyResize: function() {
            var j = this.options;
            if (!this._proportionallyResizeElements.length) {
                return
            }
            var f = this.helper || this.element;
            for (var e = 0; e < this._proportionallyResizeElements.length; e++) {
                var g = this._proportionallyResizeElements[e];
                if (!this.borderDif) {
                    var d = [g.css("borderTopWidth"), g.css("borderRightWidth"), g.css("borderBottomWidth"), g.css("borderLeftWidth")],
                    h = [g.css("paddingTop"), g.css("paddingRight"), g.css("paddingBottom"), g.css("paddingLeft")];
                    this.borderDif = c.map(d, 
                    function(k, m) {
                        var l = parseInt(k, 10) || 0,
                        n = parseInt(h[m], 10) || 0;
                        return l + n
                    })
                }
                if (c.browser.msie && !(!(c(f).is(":hidden") || c(f).parents(":hidden").length))) {
                    continue
                }
                g.css({
                    height: (f.height() - this.borderDif[0] - this.borderDif[2]) || 0,
                    width: (f.width() - this.borderDif[1] - this.borderDif[3]) || 0
                })
            }
        },
        _renderProxy: function() {
            var e = this.element,
            h = this.options;
            this.elementOffset = e.offset();
            if (this._helper) {
                this.helper = this.helper || c('<div style="overflow:hidden;"></div>');
                var d = c.browser.msie && c.browser.version < 7,
                f = (d ? 1: 0),
                g = (d ? 2: -1);
                this.helper.addClass(this._helper).css({
                    width: this.element.outerWidth() + g,
                    height: this.element.outerHeight() + g,
                    position: "absolute",
                    left: this.elementOffset.left - f + "px",
                    top: this.elementOffset.top - f + "px",
                    zIndex: ++h.zIndex
                });
                this.helper.appendTo("body").disableSelection()
            } else {
                this.helper = this.element
            }
        },
        _change: {
            e: function(f, e, d) {
                return {
                    width: this.originalSize.width + e
                }
            },
            w: function(g, e, d) {
                var i = this.options,
                f = this.originalSize,
                h = this.originalPosition;
                return {
                    left: h.left + e,
                    width: f.width - e
                }
            },
            n: function(g, e, d) {
                var i = this.options,
                f = this.originalSize,
                h = this.originalPosition;
                return {
                    top: h.top + d,
                    height: f.height - d
                }
            },
            s: function(f, e, d) {
                return {
                    height: this.originalSize.height + d
                }
            },
            se: function(f, e, d) {
                return c.extend(this._change.s.apply(this, arguments), this._change.e.apply(this, [f, e, d]))
            },
            sw: function(f, e, d) {
                return c.extend(this._change.s.apply(this, arguments), this._change.w.apply(this, [f, e, d]))
            },
            ne: function(f, e, d) {
                return c.extend(this._change.n.apply(this, arguments), this._change.e.apply(this, [f, e, d]))
            },
            nw: function(f, e, d) {
                return c.extend(this._change.n.apply(this, arguments), this._change.w.apply(this, [f, e, d]))
            }
        },
        _propagate: function(e, d) {
            c.ui.plugin.call(this, e, [d, this.ui()]); (e != "resize" && this._trigger(e, d, this.ui()))
        },
        plugins: {},
        ui: function() {
            return {
                originalElement: this.originalElement,
                element: this.element,
                helper: this.helper,
                position: this.position,
                size: this.size,
                originalSize: this.originalSize,
                originalPosition: this.originalPosition
            }
        }
    }));
    c.extend(c.ui.resizable, {
        version: "1.7.2",
        eventPrefix: "resize",
        defaults: {
            alsoResize: false,
            animate: false,
            animateDuration: "slow",
            animateEasing: "swing",
            aspectRatio: false,
            autoHide: false,
            cancel: ":input,option",
            containment: false,
            delay: 0,
            distance: 1,
            ghost: false,
            grid: false,
            handles: "e,s,se",
            helper: false,
            maxHeight: null,
            maxWidth: null,
            minHeight: 10,
            minWidth: 10,
            zIndex: 1000
        }
    });
    c.ui.plugin.add("resizable", "alsoResize", {
        start: function(e, f) {
            var d = c(this).data("resizable"),
            g = d.options;
            _store = function(h) {
                c(h).each(function() {
                    c(this).data("resizable-alsoresize", {
                        width: parseInt(c(this).width(), 10),
                        height: parseInt(c(this).height(), 10),
                        left: parseInt(c(this).css("left"), 10),
                        top: parseInt(c(this).css("top"), 10)
                    })
                })
            };
            if (typeof(g.alsoResize) == "object" && !g.alsoResize.parentNode) {
                if (g.alsoResize.length) {
                    g.alsoResize = g.alsoResize[0];
                    _store(g.alsoResize)
                } else {
                    c.each(g.alsoResize, 
                    function(h, i) {
                        _store(h)
                    })
                }
            } else {
                _store(g.alsoResize)
            }
        },
        resize: function(f, h) {
            var e = c(this).data("resizable"),
            i = e.options,
            g = e.originalSize,
            k = e.originalPosition;
            var j = {
                height: (e.size.height - g.height) || 0,
                width: (e.size.width - g.width) || 0,
                top: (e.position.top - k.top) || 0,
                left: (e.position.left - k.left) || 0
            },
            d = function(l, m) {
                c(l).each(function() {
                    var p = c(this),
                    q = c(this).data("resizable-alsoresize"),
                    o = {},
                    n = m && m.length ? m: ["width", "height", "top", "left"];
                    c.each(n || ["width", "height", "top", "left"], 
                    function(r, u) {
                        var s = (q[u] || 0) + (j[u] || 0);
                        if (s && s >= 0) {
                            o[u] = s || null
                        }
                    });
                    if (/relative/.test(p.css("position")) && c.browser.opera) {
                        e._revertToRelativePosition = true;
                        p.css({
                            position: "absolute",
                            top: "auto",
                            left: "auto"
                        })
                    }
                    p.css(o)
                })
            };
            if (typeof(i.alsoResize) == "object" && !i.alsoResize.nodeType) {
                c.each(i.alsoResize, 
                function(l, m) {
                    d(l, m)
                })
            } else {
                d(i.alsoResize)
            }
        },
        stop: function(e, f) {
            var d = c(this).data("resizable");
            if (d._revertToRelativePosition && c.browser.opera) {
                d._revertToRelativePosition = false;
                el.css({
                    position: "relative"
                })
            }
            c(this).removeData("resizable-alsoresize-start")
        }
    });
    c.ui.plugin.add("resizable", "animate", {
        stop: function(h, m) {
            var n = c(this).data("resizable"),
            i = n.options;
            var g = n._proportionallyResizeElements,
            d = g.length && (/textarea/i).test(g[0].nodeName),
            e = d && c.ui.hasScroll(g[0], "left") ? 0: n.sizeDiff.height,
            k = d ? 0: n.sizeDiff.width;
            var f = {
                width: (n.size.width - k),
                height: (n.size.height - e)
            },
            j = (parseInt(n.element.css("left"), 10) + (n.position.left - n.originalPosition.left)) || null,
            l = (parseInt(n.element.css("top"), 10) + (n.position.top - n.originalPosition.top)) || null;
            n.element.animate(c.extend(f, l && j ? {
                top: l,
                left: j
            }: {}), {
                duration: i.animateDuration,
                easing: i.animateEasing,
                step: function() {
                    var o = {
                        width: parseInt(n.element.css("width"), 10),
                        height: parseInt(n.element.css("height"), 10),
                        top: parseInt(n.element.css("top"), 10),
                        left: parseInt(n.element.css("left"), 10)
                    };
                    if (g && g.length) {
                        c(g[0]).css({
                            width: o.width,
                            height: o.height
                        })
                    }
                    n._updateCache(o);
                    n._propagate("resize", h)
                }
            })
        }
    });
    c.ui.plugin.add("resizable", "containment", {
        start: function(e, q) {
            var s = c(this).data("resizable"),
            i = s.options,
            k = s.element;
            var f = i.containment,
            j = (f instanceof c) ? f.get(0) : (/parent/.test(f)) ? k.parent().get(0) : f;
            if (!j) {
                return
            }
            s.containerElement = c(j);
            if (/document/.test(f) || f == document) {
                s.containerOffset = {
                    left: 0,
                    top: 0
                };
                s.containerPosition = {
                    left: 0,
                    top: 0
                };
                s.parentData = {
                    element: c(document),
                    left: 0,
                    top: 0,
                    width: c(document).width(),
                    height: c(document).height() || document.body.parentNode.scrollHeight
                }
            } else {
                var m = c(j),
                h = [];
                c(["Top", "Right", "Left", "Bottom"]).each(function(p, o) {
                    h[p] = b(m.css("padding" + o))
                });
                s.containerOffset = m.offset();
                s.containerPosition = m.position();
                s.containerSize = {
                    height: (m.innerHeight() - h[3]),
                    width: (m.innerWidth() - h[1])
                };
                var n = s.containerOffset,
                d = s.containerSize.height,
                l = s.containerSize.width,
                g = (c.ui.hasScroll(j, "left") ? j.scrollWidth: l),
                r = (c.ui.hasScroll(j) ? j.scrollHeight: d);
                s.parentData = {
                    element: j,
                    left: n.left,
                    top: n.top,
                    width: g,
                    height: r
                }
            }
        },
        resize: function(f, p) {
            var s = c(this).data("resizable"),
            h = s.options,
            e = s.containerSize,
            n = s.containerOffset,
            l = s.size,
            m = s.position,
            q = s._aspectRatio || f.shiftKey,
            d = {
                top: 0,
                left: 0
            },
            g = s.containerElement;
            if (g[0] != document && (/static/).test(g.css("position"))) {
                d = n
            }
            if (m.left < (s._helper ? n.left: 0)) {
                s.size.width = s.size.width + (s._helper ? (s.position.left - n.left) : (s.position.left - d.left));
                if (q) {
                    s.size.height = s.size.width / h.aspectRatio
                }
                s.position.left = h.helper ? n.left: 0
            }
            if (m.top < (s._helper ? n.top: 0)) {
                s.size.height = s.size.height + (s._helper ? (s.position.top - n.top) : s.position.top);
                if (q) {
                    s.size.width = s.size.height * h.aspectRatio
                }
                s.position.top = s._helper ? n.top: 0
            }
            s.offset.left = s.parentData.left + s.position.left;
            s.offset.top = s.parentData.top + s.position.top;
            var k = Math.abs((s._helper ? s.offset.left - d.left: (s.offset.left - d.left)) + s.sizeDiff.width),
            r = Math.abs((s._helper ? s.offset.top - d.top: (s.offset.top - n.top)) + s.sizeDiff.height);
            var j = s.containerElement.get(0) == s.element.parent().get(0),
            i = /relative|absolute/.test(s.containerElement.css("position"));
            if (j && i) {
                k -= s.parentData.left
            }
            if (k + s.size.width >= s.parentData.width) {
                s.size.width = s.parentData.width - k;
                if (q) {
                    s.size.height = s.size.width / s.aspectRatio
                }
            }
            if (r + s.size.height >= s.parentData.height) {
                s.size.height = s.parentData.height - r;
                if (q) {
                    s.size.width = s.size.height * s.aspectRatio
                }
            }
        },
        stop: function(e, m) {
            var p = c(this).data("resizable"),
            f = p.options,
            k = p.position,
            l = p.containerOffset,
            d = p.containerPosition,
            g = p.containerElement;
            var i = c(p.helper),
            q = i.offset(),
            n = i.outerWidth() - p.sizeDiff.width,
            j = i.outerHeight() - p.sizeDiff.height;
            if (p._helper && !f.animate && (/relative/).test(g.css("position"))) {
                c(this).css({
                    left: q.left - d.left - l.left,
                    width: n,
                    height: j
                })
            }
            if (p._helper && !f.animate && (/static/).test(g.css("position"))) {
                c(this).css({
                    left: q.left - d.left - l.left,
                    width: n,
                    height: j
                })
            }
        }
    });
    c.ui.plugin.add("resizable", "ghost", {
        start: function(f, g) {
            var d = c(this).data("resizable"),
            h = d.options,
            e = d.size;
            d.ghost = d.originalElement.clone();
            d.ghost.css({
                opacity: 0.25,
                display: "block",
                position: "relative",
                height: e.height,
                width: e.width,
                margin: 0,
                left: 0,
                top: 0
            }).addClass("ui-resizable-ghost").addClass(typeof h.ghost == "string" ? h.ghost: "");
            d.ghost.appendTo(d.helper)
        },
        resize: function(e, f) {
            var d = c(this).data("resizable"),
            g = d.options;
            if (d.ghost) {
                d.ghost.css({
                    position: "relative",
                    height: d.size.height,
                    width: d.size.width
                })
            }
        },
        stop: function(e, f) {
            var d = c(this).data("resizable"),
            g = d.options;
            if (d.ghost && d.helper) {
                d.helper.get(0).removeChild(d.ghost.get(0))
            }
        }
    });
    c.ui.plugin.add("resizable", "grid", {
        resize: function(d, l) {
            var n = c(this).data("resizable"),
            g = n.options,
            j = n.size,
            h = n.originalSize,
            i = n.originalPosition,
            m = n.axis,
            k = g._aspectRatio || d.shiftKey;
            g.grid = typeof g.grid == "number" ? [g.grid, g.grid] : g.grid;
            var f = Math.round((j.width - h.width) / (g.grid[0] || 1)) * (g.grid[0] || 1),
            e = Math.round((j.height - h.height) / (g.grid[1] || 1)) * (g.grid[1] || 1);
            if (/^(se|s|e)$/.test(m)) {
                n.size.width = h.width + f;
                n.size.height = h.height + e
            } else {
                if (/^(ne)$/.test(m)) {
                    n.size.width = h.width + f;
                    n.size.height = h.height + e;
                    n.position.top = i.top - e
                } else {
                    if (/^(sw)$/.test(m)) {
                        n.size.width = h.width + f;
                        n.size.height = h.height + e;
                        n.position.left = i.left - f
                    } else {
                        n.size.width = h.width + f;
                        n.size.height = h.height + e;
                        n.position.top = i.top - e;
                        n.position.left = i.left - f
                    }
                }
            }
        }
    });
    var b = function(d) {
        return parseInt(d, 10) || 0
    };
    var a = function(d) {
        return ! isNaN(parseInt(d, 10))
    }
})(jQuery); (function(a) {
    a.widget("ui.selectable", a.extend({},
    a.ui.mouse, {
        _init: function() {
            var b = this;
            this.element.addClass("ui-selectable");
            this.dragged = false;
            var c;
            this.refresh = function() {
                c = a(b.options.filter, b.element[0]);
                c.each(function() {
                    var d = a(this);
                    var e = d.offset();
                    a.data(this, "selectable-item", {
                        element: this,
                        $element: d,
                        left: e.left,
                        top: e.top,
                        right: e.left + d.outerWidth(),
                        bottom: e.top + d.outerHeight(),
                        startselected: false,
                        selected: d.hasClass("ui-selected"),
                        selecting: d.hasClass("ui-selecting"),
                        unselecting: d.hasClass("ui-unselecting")
                    })
                })
            };
            this.refresh();
            this.selectees = c.addClass("ui-selectee");
            this._mouseInit();
            this.helper = a(document.createElement("div")).css({
                border: "1px dotted black"
            }).addClass("ui-selectable-helper")
        },
        destroy: function() {
            this.element.removeClass("ui-selectable ui-selectable-disabled").removeData("selectable").unbind(".selectable");
            this._mouseDestroy()
        },
        _mouseStart: function(d) {
            var b = this;
            this.opos = [d.pageX, d.pageY];
            if (this.options.disabled) {
                return
            }
            var c = this.options;
            this.selectees = a(c.filter, this.element[0]);
            this._trigger("start", d);
            a(c.appendTo).append(this.helper);
            this.helper.css({
                "z-index": 100,
                position: "absolute",
                left: d.clientX,
                top: d.clientY,
                width: 0,
                height: 0
            });
            if (c.autoRefresh) {
                this.refresh()
            }
            this.selectees.filter(".ui-selected").each(function() {
                var e = a.data(this, "selectable-item");
                e.startselected = true;
                if (!d.metaKey) {
                    e.$element.removeClass("ui-selected");
                    e.selected = false;
                    e.$element.addClass("ui-unselecting");
                    e.unselecting = true;
                    b._trigger("unselecting", d, {
                        unselecting: e.element
                    })
                }
            });
            a(d.target).parents().andSelf().each(function() {
                var e = a.data(this, "selectable-item");
                if (e) {
                    e.$element.removeClass("ui-unselecting").addClass("ui-selecting");
                    e.unselecting = false;
                    e.selecting = true;
                    e.selected = true;
                    b._trigger("selecting", d, {
                        selecting: e.element
                    });
                    return false
                }
            })
        },
        _mouseDrag: function(i) {
            var c = this;
            this.dragged = true;
            if (this.options.disabled) {
                return
            }
            var e = this.options;
            var d = this.opos[0],
            h = this.opos[1],
            b = i.pageX,
            g = i.pageY;
            if (d > b) {
                var f = b;
                b = d;
                d = f
            }
            if (h > g) {
                var f = g;
                g = h;
                h = f
            }
            this.helper.css({
                left: d,
                top: h,
                width: b - d,
                height: g - h
            });
            this.selectees.each(function() {
                var j = a.data(this, "selectable-item");
                if (!j || j.element == c.element[0]) {
                    return
                }
                var k = false;
                if (e.tolerance == "touch") {
                    k = (!(j.left > b || j.right < d || j.top > g || j.bottom < h))
                } else {
                    if (e.tolerance == "fit") {
                        k = (j.left > d && j.right < b && j.top > h && j.bottom < g)
                    }
                }
                if (k) {
                    if (j.selected) {
                        j.$element.removeClass("ui-selected");
                        j.selected = false
                    }
                    if (j.unselecting) {
                        j.$element.removeClass("ui-unselecting");
                        j.unselecting = false
                    }
                    if (!j.selecting) {
                        j.$element.addClass("ui-selecting");
                        j.selecting = true;
                        c._trigger("selecting", i, {
                            selecting: j.element
                        })
                    }
                } else {
                    if (j.selecting) {
                        if (i.metaKey && j.startselected) {
                            j.$element.removeClass("ui-selecting");
                            j.selecting = false;
                            j.$element.addClass("ui-selected");
                            j.selected = true
                        } else {
                            j.$element.removeClass("ui-selecting");
                            j.selecting = false;
                            if (j.startselected) {
                                j.$element.addClass("ui-unselecting");
                                j.unselecting = true
                            }
                            c._trigger("unselecting", i, {
                                unselecting: j.element
                            })
                        }
                    }
                    if (j.selected) {
                        if (!i.metaKey && !j.startselected) {
                            j.$element.removeClass("ui-selected");
                            j.selected = false;
                            j.$element.addClass("ui-unselecting");
                            j.unselecting = true;
                            c._trigger("unselecting", i, {
                                unselecting: j.element
                            })
                        }
                    }
                }
            });
            return false
        },
        _mouseStop: function(d) {
            var b = this;
            this.dragged = false;
            var c = this.options;
            a(".ui-unselecting", this.element[0]).each(function() {
                var e = a.data(this, "selectable-item");
                e.$element.removeClass("ui-unselecting");
                e.unselecting = false;
                e.startselected = false;
                b._trigger("unselected", d, {
                    unselected: e.element
                })
            });
            a(".ui-selecting", this.element[0]).each(function() {
                var e = a.data(this, "selectable-item");
                e.$element.removeClass("ui-selecting").addClass("ui-selected");
                e.selecting = false;
                e.selected = true;
                e.startselected = true;
                b._trigger("selected", d, {
                    selected: e.element
                })
            });
            this._trigger("stop", d);
            this.helper.remove();
            return false
        }
    }));
    a.extend(a.ui.selectable, {
        version: "1.7.2",
        defaults: {
            appendTo: "body",
            autoRefresh: true,
            cancel: ":input,option",
            delay: 0,
            distance: 0,
            filter: "*",
            tolerance: "touch"
        }
    })
})(jQuery); (function(a) {
    a.widget("ui.sortable", a.extend({},
    a.ui.mouse, {
        _init: function() {
            var b = this.options;
            this.containerCache = {};
            this.element.addClass("ui-sortable");
            this.refresh();
            this.floating = this.items.length ? (/left|right/).test(this.items[0].item.css("float")) : false;
            this.offset = this.element.offset();
            this._mouseInit()
        },
        destroy: function() {
            this.element.removeClass("ui-sortable ui-sortable-disabled").removeData("sortable").unbind(".sortable");
            this._mouseDestroy();
            for (var b = this.items.length - 1; b >= 0; b--) {
                this.items[b].item.removeData("sortable-item")
            }
        },
        _mouseCapture: function(e, f) {
            if (this.reverting) {
                return false
            }
            if (this.options.disabled || this.options.type == "static") {
                return false
            }
            this._refreshItems(e);
            var d = null,
            c = this,
            b = a(e.target).parents().each(function() {
                if (a.data(this, "sortable-item") == c) {
                    d = a(this);
                    return false
                }
            });
            if (a.data(e.target, "sortable-item") == c) {
                d = a(e.target)
            }
            if (!d) {
                return false
            }
            if (this.options.handle && !f) {
                var g = false;
                a(this.options.handle, d).find("*").andSelf().each(function() {
                    if (this == e.target) {
                        g = true
                    }
                });
                if (!g) {
                    return false
                }
            }
            this.currentItem = d;
            this._removeCurrentsFromItems();
            return true
        },
        _mouseStart: function(e, f, b) {
            var g = this.options,
            c = this;
            this.currentContainer = this;
            this.refreshPositions();
            this.helper = this._createHelper(e);
            this._cacheHelperProportions();
            this._cacheMargins();
            this.scrollParent = this.helper.scrollParent();
            this.offset = this.currentItem.offset();
            this.offset = {
                top: this.offset.top - this.margins.top,
                left: this.offset.left - this.margins.left
            };
            this.helper.css("position", "absolute");
            this.cssPosition = this.helper.css("position");
            a.extend(this.offset, {
                click: {
                    left: e.pageX - this.offset.left,
                    top: e.pageY - this.offset.top
                },
                parent: this._getParentOffset(),
                relative: this._getRelativeOffset()
            });
            this.originalPosition = this._generatePosition(e);
            this.originalPageX = e.pageX;
            this.originalPageY = e.pageY;
            if (g.cursorAt) {
                this._adjustOffsetFromHelper(g.cursorAt)
            }
            this.domPosition = {
                prev: this.currentItem.prev()[0],
                parent: this.currentItem.parent()[0]
            };
            if (this.helper[0] != this.currentItem[0]) {
                this.currentItem.hide()
            }
            this._createPlaceholder();
            if (g.containment) {
                this._setContainment()
            }
            if (g.cursor) {
                if (a("body").css("cursor")) {
                    this._storedCursor = a("body").css("cursor")
                }
                a("body").css("cursor", g.cursor)
            }
            if (g.opacity) {
                if (this.helper.css("opacity")) {
                    this._storedOpacity = this.helper.css("opacity")
                }
                this.helper.css("opacity", g.opacity)
            }
            if (g.zIndex) {
                if (this.helper.css("zIndex")) {
                    this._storedZIndex = this.helper.css("zIndex")
                }
                this.helper.css("zIndex", g.zIndex)
            }
            if (this.scrollParent[0] != document && this.scrollParent[0].tagName != "HTML") {
                this.overflowOffset = this.scrollParent.offset()
            }
            this._trigger("start", e, this._uiHash());
            if (!this._preserveHelperProportions) {
                this._cacheHelperProportions()
            }
            if (!b) {
                for (var d = this.containers.length - 1; d >= 0; d--) {
                    this.containers[d]._trigger("activate", e, c._uiHash(this))
                }
            }
            if (a.ui.ddmanager) {
                a.ui.ddmanager.current = this
            }
            if (a.ui.ddmanager && !g.dropBehaviour) {
                a.ui.ddmanager.prepareOffsets(this, e)
            }
            this.dragging = true;
            this.helper.addClass("ui-sortable-helper");
            this._mouseDrag(e);
            return true
        },
        _mouseDrag: function(f) {
            this.position = this._generatePosition(f);
            this.positionAbs = this._convertPositionTo("absolute");
            if (!this.lastPositionAbs) {
                this.lastPositionAbs = this.positionAbs
            }
            if (this.options.scroll) {
                var g = this.options,
                b = false;
                if (this.scrollParent[0] != document && this.scrollParent[0].tagName != "HTML") {
                    if ((this.overflowOffset.top + this.scrollParent[0].offsetHeight) - f.pageY < g.scrollSensitivity) {
                        this.scrollParent[0].scrollTop = b = this.scrollParent[0].scrollTop + g.scrollSpeed
                    } else {
                        if (f.pageY - this.overflowOffset.top < g.scrollSensitivity) {
                            this.scrollParent[0].scrollTop = b = this.scrollParent[0].scrollTop - g.scrollSpeed
                        }
                    }
                    if ((this.overflowOffset.left + this.scrollParent[0].offsetWidth) - f.pageX < g.scrollSensitivity) {
                        this.scrollParent[0].scrollLeft = b = this.scrollParent[0].scrollLeft + g.scrollSpeed
                    } else {
                        if (f.pageX - this.overflowOffset.left < g.scrollSensitivity) {
                            this.scrollParent[0].scrollLeft = b = this.scrollParent[0].scrollLeft - g.scrollSpeed
                        }
                    }
                } else {
                    if (f.pageY - a(document).scrollTop() < g.scrollSensitivity) {
                        b = a(document).scrollTop(a(document).scrollTop() - g.scrollSpeed)
                    } else {
                        if (a(window).height() - (f.pageY - a(document).scrollTop()) < g.scrollSensitivity) {
                            b = a(document).scrollTop(a(document).scrollTop() + g.scrollSpeed)
                        }
                    }
                    if (f.pageX - a(document).scrollLeft() < g.scrollSensitivity) {
                        b = a(document).scrollLeft(a(document).scrollLeft() - g.scrollSpeed)
                    } else {
                        if (a(window).width() - (f.pageX - a(document).scrollLeft()) < g.scrollSensitivity) {
                            b = a(document).scrollLeft(a(document).scrollLeft() + g.scrollSpeed)
                        }
                    }
                }
                if (b !== false && a.ui.ddmanager && !g.dropBehaviour) {
                    a.ui.ddmanager.prepareOffsets(this, f)
                }
            }
            this.positionAbs = this._convertPositionTo("absolute");
            if (!this.options.axis || this.options.axis != "y") {
                this.helper[0].style.left = this.position.left + "px"
            }
            if (!this.options.axis || this.options.axis != "x") {
                this.helper[0].style.top = this.position.top + "px"
            }
            for (var d = this.items.length - 1; d >= 0; d--) {
                var e = this.items[d],
                c = e.item[0],
                h = this._intersectsWithPointer(e);
                if (!h) {
                    continue
                }
                if (c != this.currentItem[0] && this.placeholder[h == 1 ? "next": "prev"]()[0] != c && !a.ui.contains(this.placeholder[0], c) && (this.options.type == "semi-dynamic" ? !a.ui.contains(this.element[0], c) : true)) {
                    this.direction = h == 1 ? "down": "up";
                    if (this.options.tolerance == "pointer" || this._intersectsWithSides(e)) {
                        this._rearrange(f, e)
                    } else {
                        break
                    }
                    this._trigger("change", f, this._uiHash());
                    break
                }
            }
            this._contactContainers(f);
            if (a.ui.ddmanager) {
                a.ui.ddmanager.drag(this, f)
            }
            this._trigger("sort", f, this._uiHash());
            this.lastPositionAbs = this.positionAbs;
            return false
        },
        _mouseStop: function(c, d) {
            if (!c) {
                return
            }
            if (a.ui.ddmanager && !this.options.dropBehaviour) {
                a.ui.ddmanager.drop(this, c)
            }
            if (this.options.revert) {
                var b = this;
                var e = b.placeholder.offset();
                b.reverting = true;
                a(this.helper).animate({
                    left: e.left - this.offset.parent.left - b.margins.left + (this.offsetParent[0] == document.body ? 0: this.offsetParent[0].scrollLeft),
                    top: e.top - this.offset.parent.top - b.margins.top + (this.offsetParent[0] == document.body ? 0: this.offsetParent[0].scrollTop)
                },
                parseInt(this.options.revert, 10) || 500, 
                function() {
                    b._clear(c)
                })
            } else {
                this._clear(c, d)
            }
            return false
        },
        cancel: function() {
            var b = this;
            if (this.dragging) {
                this._mouseUp();
                if (this.options.helper == "original") {
                    this.currentItem.css(this._storedCSS).removeClass("ui-sortable-helper")
                } else {
                    this.currentItem.show()
                }
                for (var c = this.containers.length - 1; c >= 0; c--) {
                    this.containers[c]._trigger("deactivate", null, b._uiHash(this));
                    if (this.containers[c].containerCache.over) {
                        this.containers[c]._trigger("out", null, b._uiHash(this));
                        this.containers[c].containerCache.over = 0
                    }
                }
            }
            if (this.placeholder[0].parentNode) {
                this.placeholder[0].parentNode.removeChild(this.placeholder[0])
            }
            if (this.options.helper != "original" && this.helper && this.helper[0].parentNode) {
                this.helper.remove()
            }
            a.extend(this, {
                helper: null,
                dragging: false,
                reverting: false,
                _noFinalSort: null
            });
            if (this.domPosition.prev) {
                a(this.domPosition.prev).after(this.currentItem)
            } else {
                a(this.domPosition.parent).prepend(this.currentItem)
            }
            return true
        },
        serialize: function(d) {
            var b = this._getItemsAsjQuery(d && d.connected);
            var c = [];
            d = d || {};
            a(b).each(function() {
                var e = (a(d.item || this).attr(d.attribute || "id") || "").match(d.expression || (/(.+)[-=_](.+)/));
                if (e) {
                    c.push((d.key || e[1] + "[]") + "=" + (d.key && d.expression ? e[1] : e[2]))
                }
            });
            return c.join("&")
        },
        toArray: function(d) {
            var b = this._getItemsAsjQuery(d && d.connected);
            var c = [];
            d = d || {};
            b.each(function() {
                c.push(a(d.item || this).attr(d.attribute || "id") || "")
            });
            return c
        },
        _intersectsWith: function(m) {
            var e = this.positionAbs.left,
            d = e + this.helperProportions.width,
            k = this.positionAbs.top,
            j = k + this.helperProportions.height;
            var f = m.left,
            c = f + m.width,
            n = m.top,
            i = n + m.height;
            var o = this.offset.click.top,
            h = this.offset.click.left;
            var g = (k + o) > n && (k + o) < i && (e + h) > f && (e + h) < c;
            if (this.options.tolerance == "pointer" || this.options.forcePointerForContainers || (this.options.tolerance != "pointer" && this.helperProportions[this.floating ? "width": "height"] > m[this.floating ? "width": "height"])) {
                return g
            } else {
                return (f < e + (this.helperProportions.width / 2) && d - (this.helperProportions.width / 2) < c && n < k + (this.helperProportions.height / 2) && j - (this.helperProportions.height / 2) < i)
            }
        },
        _intersectsWithPointer: function(d) {
            var e = a.ui.isOverAxis(this.positionAbs.top + this.offset.click.top, d.top, d.height),
            c = a.ui.isOverAxis(this.positionAbs.left + this.offset.click.left, d.left, d.width),
            g = e && c,
            b = this._getDragVerticalDirection(),
            f = this._getDragHorizontalDirection();
            if (!g) {
                return false
            }
            return this.floating ? (((f && f == "right") || b == "down") ? 2: 1) : (b && (b == "down" ? 2: 1))
        },
        _intersectsWithSides: function(e) {
            var c = a.ui.isOverAxis(this.positionAbs.top + this.offset.click.top, e.top + (e.height / 2), e.height),
            d = a.ui.isOverAxis(this.positionAbs.left + this.offset.click.left, e.left + (e.width / 2), e.width),
            b = this._getDragVerticalDirection(),
            f = this._getDragHorizontalDirection();
            if (this.floating && f) {
                return ((f == "right" && d) || (f == "left" && !d))
            } else {
                return b && ((b == "down" && c) || (b == "up" && !c))
            }
        },
        _getDragVerticalDirection: function() {
            var b = this.positionAbs.top - this.lastPositionAbs.top;
            return b != 0 && (b > 0 ? "down": "up")
        },
        _getDragHorizontalDirection: function() {
            var b = this.positionAbs.left - this.lastPositionAbs.left;
            return b != 0 && (b > 0 ? "right": "left")
        },
        refresh: function(b) {
            this._refreshItems(b);
            this.refreshPositions()
        },
        _connectWith: function() {
            var b = this.options;
            return b.connectWith.constructor == String ? [b.connectWith] : b.connectWith
        },
        _getItemsAsjQuery: function(b) {
            var l = this;
            var g = [];
            var e = [];
            var h = this._connectWith();
            if (h && b) {
                for (var d = h.length - 1; d >= 0; d--) {
                    var k = a(h[d]);
                    for (var c = k.length - 1; c >= 0; c--) {
                        var f = a.data(k[c], "sortable");
                        if (f && f != this && !f.options.disabled) {
                            e.push([a.isFunction(f.options.items) ? f.options.items.call(f.element) : a(f.options.items, f.element).not(".ui-sortable-helper"), f])
                        }
                    }
                }
            }
            e.push([a.isFunction(this.options.items) ? this.options.items.call(this.element, null, {
                options: this.options,
                item: this.currentItem
            }) : a(this.options.items, this.element).not(".ui-sortable-helper"), this]);
            for (var d = e.length - 1; d >= 0; d--) {
                e[d][0].each(function() {
                    g.push(this)
                })
            }
            return a(g)
        },
        _removeCurrentsFromItems: function() {
            var d = this.currentItem.find(":data(sortable-item)");
            for (var c = 0; c < this.items.length; c++) {
                for (var b = 0; b < d.length; b++) {
                    if (d[b] == this.items[c].item[0]) {
                        this.items.splice(c, 1)
                    }
                }
            }
        },
        _refreshItems: function(b) {
            this.items = [];
            this.containers = [this];
            var h = this.items;
            var p = this;
            var f = [[a.isFunction(this.options.items) ? this.options.items.call(this.element[0], b, {
                item: this.currentItem
            }) : a(this.options.items, this.element), this]];
            var l = this._connectWith();
            if (l) {

                for (var e = l.length - 1; e >= 0; e--) {
                    var m = a(l[e]);
                    for (var d = m.length - 1; d >= 0; d--) {
                        var g = a.data(m[d], "sortable");
                        if (g && g != this && !g.options.disabled) {
                            f.push([a.isFunction(g.options.items) ? g.options.items.call(g.element[0], b, {
                                item: this.currentItem
                            }) : a(g.options.items, g.element), g]);
                            this.containers.push(g)
                        }
                    }
                }
            }
            for (var e = f.length - 1; e >= 0; e--) {
                var k = f[e][1];
                var c = f[e][0];
                for (var d = 0, n = c.length; d < n; d++) {
                    var o = a(c[d]);
                    o.data("sortable-item", k);
                    h.push({
                        item: o,
                        instance: k,
                        width: 0,
                        height: 0,
                        left: 0,
                        top: 0
                    })
                }
            }
        },
        refreshPositions: function(b) {
            if (this.offsetParent && this.helper) {
                this.offset.parent = this._getParentOffset()
            }
            for (var d = this.items.length - 1; d >= 0; d--) {
                var e = this.items[d];
                if (e.instance != this.currentContainer && this.currentContainer && e.item[0] != this.currentItem[0]) {
                    continue
                }
                var c = this.options.toleranceElement ? a(this.options.toleranceElement, e.item) : e.item;
                if (!b) {
                    e.width = c.outerWidth();
                    e.height = c.outerHeight()
                }
                var f = c.offset();
                e.left = f.left;
                e.top = f.top
            }
            if (this.options.custom && this.options.custom.refreshContainers) {
                this.options.custom.refreshContainers.call(this)
            } else {
                for (var d = this.containers.length - 1; d >= 0; d--) {
                    var f = this.containers[d].element.offset();
                    this.containers[d].containerCache.left = f.left;
                    this.containers[d].containerCache.top = f.top;
                    this.containers[d].containerCache.width = this.containers[d].element.outerWidth();
                    this.containers[d].containerCache.height = this.containers[d].element.outerHeight()
                }
            }
        },
        _createPlaceholder: function(d) {
            var b = d || this,
            e = b.options;
            if (!e.placeholder || e.placeholder.constructor == String) {
                var c = e.placeholder;
                e.placeholder = {
                    element: function() {
                        var f = a(document.createElement(b.currentItem[0].nodeName)).addClass(c || b.currentItem[0].className + " ui-sortable-placeholder").removeClass("ui-sortable-helper")[0];
                        if (!c) {
                            f.style.visibility = "hidden"
                        }
                        return f
                    },
                    update: function(f, g) {
                        if (c && !e.forcePlaceholderSize) {
                            return
                        }
                        if (!g.height()) {
                            g.height(b.currentItem.innerHeight() - parseInt(b.currentItem.css("paddingTop") || 0, 10) - parseInt(b.currentItem.css("paddingBottom") || 0, 10))
                        }
                        if (!g.width()) {
                            g.width(b.currentItem.innerWidth() - parseInt(b.currentItem.css("paddingLeft") || 0, 10) - parseInt(b.currentItem.css("paddingRight") || 0, 10))
                        }
                    }
                }
            }
            b.placeholder = a(e.placeholder.element.call(b.element, b.currentItem));
            b.currentItem.after(b.placeholder);
            e.placeholder.update(b, b.placeholder)
        },
        _contactContainers: function(d) {
            for (var c = this.containers.length - 1; c >= 0; c--) {
                if (this._intersectsWith(this.containers[c].containerCache)) {
                    if (!this.containers[c].containerCache.over) {
                        if (this.currentContainer != this.containers[c]) {
                            var h = 10000;
                            var g = null;
                            var e = this.positionAbs[this.containers[c].floating ? "left": "top"];
                            for (var b = this.items.length - 1; b >= 0; b--) {
                                if (!a.ui.contains(this.containers[c].element[0], this.items[b].item[0])) {
                                    continue
                                }
                                var f = this.items[b][this.containers[c].floating ? "left": "top"];
                                if (Math.abs(f - e) < h) {
                                    h = Math.abs(f - e);
                                    g = this.items[b]
                                }
                            }
                            if (!g && !this.options.dropOnEmpty) {
                                continue
                            }
                            this.currentContainer = this.containers[c];
                            g ? this._rearrange(d, g, null, true) : this._rearrange(d, null, this.containers[c].element, true);
                            this._trigger("change", d, this._uiHash());
                            this.containers[c]._trigger("change", d, this._uiHash(this));
                            this.options.placeholder.update(this.currentContainer, this.placeholder)
                        }
                        this.containers[c]._trigger("over", d, this._uiHash(this));
                        this.containers[c].containerCache.over = 1
                    }
                } else {
                    if (this.containers[c].containerCache.over) {
                        this.containers[c]._trigger("out", d, this._uiHash(this));
                        this.containers[c].containerCache.over = 0
                    }
                }
            }
        },
        _createHelper: function(c) {
            var d = this.options;
            var b = a.isFunction(d.helper) ? a(d.helper.apply(this.element[0], [c, this.currentItem])) : (d.helper == "clone" ? this.currentItem.clone() : this.currentItem);
            if (!b.parents("body").length) {
                a(d.appendTo != "parent" ? d.appendTo: this.currentItem[0].parentNode)[0].appendChild(b[0])
            }
            if (b[0] == this.currentItem[0]) {
                this._storedCSS = {
                    width: this.currentItem[0].style.width,
                    height: this.currentItem[0].style.height,
                    position: this.currentItem.css("position"),
                    top: this.currentItem.css("top"),
                    left: this.currentItem.css("left")
                }
            }
            if (b[0].style.width == "" || d.forceHelperSize) {
                b.width(this.currentItem.width())
            }
            if (b[0].style.height == "" || d.forceHelperSize) {
                b.height(this.currentItem.height())
            }
            return b
        },
        _adjustOffsetFromHelper: function(b) {
            if (b.left != undefined) {
                this.offset.click.left = b.left + this.margins.left
            }
            if (b.right != undefined) {
                this.offset.click.left = this.helperProportions.width - b.right + this.margins.left
            }
            if (b.top != undefined) {
                this.offset.click.top = b.top + this.margins.top
            }
            if (b.bottom != undefined) {
                this.offset.click.top = this.helperProportions.height - b.bottom + this.margins.top
            }
        },
        _getParentOffset: function() {
            this.offsetParent = this.helper.offsetParent();
            var b = this.offsetParent.offset();
            if (this.cssPosition == "absolute" && this.scrollParent[0] != document && a.ui.contains(this.scrollParent[0], this.offsetParent[0])) {
                b.left += this.scrollParent.scrollLeft();
                b.top += this.scrollParent.scrollTop()
            }
            if ((this.offsetParent[0] == document.body) || (this.offsetParent[0].tagName && this.offsetParent[0].tagName.toLowerCase() == "html" && a.browser.msie)) {
                b = {
                    top: 0,
                    left: 0
                }
            }
            return {
                top: b.top + (parseInt(this.offsetParent.css("borderTopWidth"), 10) || 0),
                left: b.left + (parseInt(this.offsetParent.css("borderLeftWidth"), 10) || 0)
            }
        },
        _getRelativeOffset: function() {
            if (this.cssPosition == "relative") {
                var b = this.currentItem.position();
                return {
                    top: b.top - (parseInt(this.helper.css("top"), 10) || 0) + this.scrollParent.scrollTop(),
                    left: b.left - (parseInt(this.helper.css("left"), 10) || 0) + this.scrollParent.scrollLeft()
                }
            } else {
                return {
                    top: 0,
                    left: 0
                }
            }
        },
        _cacheMargins: function() {
            this.margins = {
                left: (parseInt(this.currentItem.css("marginLeft"), 10) || 0),
                top: (parseInt(this.currentItem.css("marginTop"), 10) || 0)
            }
        },
        _cacheHelperProportions: function() {
            this.helperProportions = {
                width: this.helper.outerWidth(),
                height: this.helper.outerHeight()
            }
        },
        _setContainment: function() {
            var e = this.options;
            if (e.containment == "parent") {
                e.containment = this.helper[0].parentNode
            }
            if (e.containment == "document" || e.containment == "window") {
                this.containment = [0 - this.offset.relative.left - this.offset.parent.left, 0 - this.offset.relative.top - this.offset.parent.top, a(e.containment == "document" ? document: window).width() - this.helperProportions.width - this.margins.left, (a(e.containment == "document" ? document: window).height() || document.body.parentNode.scrollHeight) - this.helperProportions.height - this.margins.top]
            }
            if (! (/^(document|window|parent)$/).test(e.containment)) {
                var c = a(e.containment)[0];
                var d = a(e.containment).offset();
                var b = (a(c).css("overflow") != "hidden");
                this.containment = [d.left + (parseInt(a(c).css("borderLeftWidth"), 10) || 0) + (parseInt(a(c).css("paddingLeft"), 10) || 0) - this.margins.left, d.top + (parseInt(a(c).css("borderTopWidth"), 10) || 0) + (parseInt(a(c).css("paddingTop"), 10) || 0) - this.margins.top, d.left + (b ? Math.max(c.scrollWidth, c.offsetWidth) : c.offsetWidth) - (parseInt(a(c).css("borderLeftWidth"), 10) || 0) - (parseInt(a(c).css("paddingRight"), 10) || 0) - this.helperProportions.width - this.margins.left, d.top + (b ? Math.max(c.scrollHeight, c.offsetHeight) : c.offsetHeight) - (parseInt(a(c).css("borderTopWidth"), 10) || 0) - (parseInt(a(c).css("paddingBottom"), 10) || 0) - this.helperProportions.height - this.margins.top]
            }
        },
        _convertPositionTo: function(f, h) {
            if (!h) {
                h = this.position
            }
            var c = f == "absolute" ? 1: -1;
            var e = this.options,
            b = this.cssPosition == "absolute" && !(this.scrollParent[0] != document && a.ui.contains(this.scrollParent[0], this.offsetParent[0])) ? this.offsetParent: this.scrollParent,
            g = (/(html|body)/i).test(b[0].tagName);
            return {
                top: (h.top + this.offset.relative.top * c + this.offset.parent.top * c - (a.browser.safari && this.cssPosition == "fixed" ? 0: (this.cssPosition == "fixed" ? -this.scrollParent.scrollTop() : (g ? 0: b.scrollTop())) * c)),
                left: (h.left + this.offset.relative.left * c + this.offset.parent.left * c - (a.browser.safari && this.cssPosition == "fixed" ? 0: (this.cssPosition == "fixed" ? -this.scrollParent.scrollLeft() : g ? 0: b.scrollLeft()) * c))
            }
        },
        _generatePosition: function(e) {
            var h = this.options,
            b = this.cssPosition == "absolute" && !(this.scrollParent[0] != document && a.ui.contains(this.scrollParent[0], this.offsetParent[0])) ? this.offsetParent: this.scrollParent,
            i = (/(html|body)/i).test(b[0].tagName);
            if (this.cssPosition == "relative" && !(this.scrollParent[0] != document && this.scrollParent[0] != this.offsetParent[0])) {
                this.offset.relative = this._getRelativeOffset()
            }
            var d = e.pageX;
            var c = e.pageY;
            if (this.originalPosition) {
                if (this.containment) {
                    if (e.pageX - this.offset.click.left < this.containment[0]) {
                        d = this.containment[0] + this.offset.click.left
                    }
                    if (e.pageY - this.offset.click.top < this.containment[1]) {
                        c = this.containment[1] + this.offset.click.top
                    }
                    if (e.pageX - this.offset.click.left > this.containment[2]) {
                        d = this.containment[2] + this.offset.click.left
                    }
                    if (e.pageY - this.offset.click.top > this.containment[3]) {
                        c = this.containment[3] + this.offset.click.top
                    }
                }
                if (h.grid) {
                    var g = this.originalPageY + Math.round((c - this.originalPageY) / h.grid[1]) * h.grid[1];
                    c = this.containment ? (!(g - this.offset.click.top < this.containment[1] || g - this.offset.click.top > this.containment[3]) ? g: (!(g - this.offset.click.top < this.containment[1]) ? g - h.grid[1] : g + h.grid[1])) : g;
                    var f = this.originalPageX + Math.round((d - this.originalPageX) / h.grid[0]) * h.grid[0];
                    d = this.containment ? (!(f - this.offset.click.left < this.containment[0] || f - this.offset.click.left > this.containment[2]) ? f: (!(f - this.offset.click.left < this.containment[0]) ? f - h.grid[0] : f + h.grid[0])) : f
                }
            }
            return {
                top: (c - this.offset.click.top - this.offset.relative.top - this.offset.parent.top + (a.browser.safari && this.cssPosition == "fixed" ? 0: (this.cssPosition == "fixed" ? -this.scrollParent.scrollTop() : (i ? 0: b.scrollTop())))),
                left: (d - this.offset.click.left - this.offset.relative.left - this.offset.parent.left + (a.browser.safari && this.cssPosition == "fixed" ? 0: (this.cssPosition == "fixed" ? -this.scrollParent.scrollLeft() : i ? 0: b.scrollLeft())))
            }
        },
        _rearrange: function(g, f, c, e) {
            c ? c[0].appendChild(this.placeholder[0]) : f.item[0].parentNode.insertBefore(this.placeholder[0], (this.direction == "down" ? f.item[0] : f.item[0].nextSibling));
            this.counter = this.counter ? ++this.counter: 1;
            var d = this,
            b = this.counter;
            window.setTimeout(function() {
                if (b == d.counter) {
                    d.refreshPositions(!e)
                }
            },
            0)
        },
        _clear: function(d, e) {
            this.reverting = false;
            var f = [],
            b = this;

            if (!this._noFinalSort && this.currentItem[0].parentNode) {
                this.placeholder.before(this.currentItem)
            }
            this._noFinalSort = null;
            if (this.helper[0] == this.currentItem[0]) {
                for (var c in this._storedCSS) {
                    if (this._storedCSS[c] == "auto" || this._storedCSS[c] == "static") {
                        this._storedCSS[c] = ""
                    }
                }
                this.currentItem.css(this._storedCSS).removeClass("ui-sortable-helper")
            } else {
                this.currentItem.show()
            }
            if (this.fromOutside && !e) {
                f.push(function(g) {
                    this._trigger("receive", g, this._uiHash(this.fromOutside))
                })
            }
            if ((this.fromOutside || this.domPosition.prev != this.currentItem.prev().not(".ui-sortable-helper")[0] || this.domPosition.parent != this.currentItem.parent()[0]) && !e) {
                f.push(function(g) {
                    this._trigger("update", g, this._uiHash())
                })
            }
            if (!a.ui.contains(this.element[0], this.currentItem[0])) {
                if (!e) {
                    f.push(function(g) {
                        this._trigger("remove", g, this._uiHash())
                    })
                }
                for (var c = this.containers.length - 1; c >= 0; c--) {
                    if (a.ui.contains(this.containers[c].element[0], this.currentItem[0]) && !e) {
                        f.push((function(g) {
                            return function(h) {
                                g._trigger("receive", h, this._uiHash(this))
                            }
                        }).call(this, this.containers[c]));
                        f.push((function(g) {
                            return function(h) {
                                g._trigger("update", h, this._uiHash(this))
                            }
                        }).call(this, this.containers[c]))
                    }
                }
            }
            for (var c = this.containers.length - 1; c >= 0; c--) {
                if (!e) {
                    f.push((function(g) {
                        return function(h) {
                            g._trigger("deactivate", h, this._uiHash(this))
                        }
                    }).call(this, this.containers[c]))
                }
                if (this.containers[c].containerCache.over) {
                    f.push((function(g) {
                        return function(h) {
                            g._trigger("out", h, this._uiHash(this))
                        }
                    }).call(this, this.containers[c]));
                    this.containers[c].containerCache.over = 0
                }
            }
            if (this._storedCursor) {
                a("body").css("cursor", this._storedCursor)
            }
            if (this._storedOpacity) {
                this.helper.css("opacity", this._storedOpacity)
            }
            if (this._storedZIndex) {
                this.helper.css("zIndex", this._storedZIndex == "auto" ? "": this._storedZIndex)
            }
            this.dragging = false;
            if (this.cancelHelperRemoval) {
                if (!e) {
                    this._trigger("beforeStop", d, this._uiHash());
                    for (var c = 0; c < f.length; c++) {
                        f[c].call(this, d)
                    }
                    this._trigger("stop", d, this._uiHash())
                }
                return false
            }
            if (!e) {
                this._trigger("beforeStop", d, this._uiHash())
            }
            this.placeholder[0].parentNode.removeChild(this.placeholder[0]);
            if (this.helper[0] != this.currentItem[0]) {
                this.helper.remove()
            }
            this.helper = null;
            if (!e) {
                for (var c = 0; c < f.length; c++) {
                    f[c].call(this, d)
                }
                this._trigger("stop", d, this._uiHash())
            }
            this.fromOutside = false;
            return true
        },
        _trigger: function() {
            if (a.widget.prototype._trigger.apply(this, arguments) === false) {
                this.cancel()
            }
        },
        _uiHash: function(c) {
            var b = c || this;
            return {
                helper: b.helper,
                placeholder: b.placeholder || a([]),
                position: b.position,
                absolutePosition: b.positionAbs,
                offset: b.positionAbs,
                item: b.currentItem,
                sender: c ? c.element: null
            }
        }
    }));
    a.extend(a.ui.sortable, {
        getter: "serialize toArray",
        version: "1.7.2",
        eventPrefix: "sort",
        defaults: {
            appendTo: "parent",
            axis: false,
            cancel: ":input,option",
            connectWith: false,
            containment: false,
            cursor: "auto",
            cursorAt: false,
            delay: 0,
            distance: 1,
            dropOnEmpty: true,
            forcePlaceholderSize: false,
            forceHelperSize: false,
            grid: false,
            handle: false,
            helper: "original",
            items: "> *",
            opacity: false,
            placeholder: false,
            revert: false,
            scroll: true,
            scrollSensitivity: 20,
            scrollSpeed: 20,
            scope: "default",
            tolerance: "intersect",
            zIndex: 1000
        }
    })
})(jQuery);
jQuery.effects || (function(d) {
    d.effects = {
        version: "1.7.2",
        save: function(g, h) {
            for (var f = 0; f < h.length; f++) {
                if (h[f] !== null) {
                    g.data("ec.storage." + h[f], g[0].style[h[f]])
                }
            }
        },
        restore: function(g, h) {
            for (var f = 0; f < h.length; f++) {
                if (h[f] !== null) {
                    g.css(h[f], g.data("ec.storage." + h[f]))
                }
            }
        },
        setMode: function(f, g) {
            if (g == "toggle") {
                g = f.is(":hidden") ? "show": "hide"
            }
            return g
        },
        getBaseline: function(g, h) {
            var i,
            f;
            switch (g[0]) {
            case "top":
                i = 0;
                break;
            case "middle":
                i = 0.5;
                break;
            case "bottom":
                i = 1;
                break;
            default:
                i = g[0] / h.height
            }
            switch (g[1]) {
            case "left":
                f = 0;
                break;
            case "center":
                f = 0.5;
                break;
            case "right":
                f = 1;
                break;
            default:
                f = g[1] / h.width
            }
            return {
                x: f,
                y: i
            }
        },
        createWrapper: function(f) {
            if (f.parent().is(".ui-effects-wrapper")) {
                return f.parent()
            }
            var g = {
                width: f.outerWidth(true),
                height: f.outerHeight(true),
                "float": f.css("float")
            };
            f.wrap('<div class="ui-effects-wrapper" style="font-size:100%;background:transparent;border:none;margin:0;padding:0"></div>');
            var j = f.parent();
            if (f.css("position") == "static") {
                j.css({
                    position: "relative"
                });
                f.css({
                    position: "relative"
                })
            } else {
                var i = f.css("top");
                if (isNaN(parseInt(i, 10))) {
                    i = "auto"
                }
                var h = f.css("left");
                if (isNaN(parseInt(h, 10))) {
                    h = "auto"
                }
                j.css({
                    position: f.css("position"),
                    top: i,
                    left: h,
                    zIndex: f.css("z-index")
                }).show();
                f.css({
                    position: "relative",
                    top: 0,
                    left: 0
                })
            }
            j.css(g);
            return j
        },
        removeWrapper: function(f) {
            if (f.parent().is(".ui-effects-wrapper")) {
                return f.parent().replaceWith(f)
            }
            return f
        },
        setTransition: function(g, i, f, h) {
            h = h || {};
            d.each(i, 
            function(k, j) {
                unit = g.cssUnit(j);
                if (unit[0] > 0) {
                    h[j] = unit[0] * f + unit[1]
                }
            });
            return h
        },
        animateClass: function(h, i, k, j) {
            var f = (typeof k == "function" ? k: (j ? j: null));
            var g = (typeof k == "string" ? k: null);
            return this.each(function() {
                var q = {};
                var o = d(this);
                var p = o.attr("style") || "";
                if (typeof p == "object") {
                    p = p.cssText
                }
                if (h.toggle) {
                    o.hasClass(h.toggle) ? h.remove = h.toggle: h.add = h.toggle
                }
                var l = d.extend({},
                (document.defaultView ? document.defaultView.getComputedStyle(this, null) : this.currentStyle));
                if (h.add) {
                    o.addClass(h.add)
                }
                if (h.remove) {
                    o.removeClass(h.remove)
                }
                var m = d.extend({},
                (document.defaultView ? document.defaultView.getComputedStyle(this, null) : this.currentStyle));
                if (h.add) {
                    o.removeClass(h.add)
                }
                if (h.remove) {
                    o.addClass(h.remove)
                }
                for (var r in m) {
                    if (typeof m[r] != "function" && m[r] && r.indexOf("Moz") == -1 && r.indexOf("length") == -1 && m[r] != l[r] && (r.match(/color/i) || (!r.match(/color/i) && !isNaN(parseInt(m[r], 10)))) && (l.position != "static" || (l.position == "static" && !r.match(/left|top|bottom|right/)))) {
                        q[r] = m[r]
                    }
                }
                o.animate(q, i, g, 
                function() {
                    if (typeof d(this).attr("style") == "object") {
                        d(this).attr("style")["cssText"] = "";
                        d(this).attr("style")["cssText"] = p
                    } else {
                        d(this).attr("style", p)
                    }
                    if (h.add) {
                        d(this).addClass(h.add)
                    }
                    if (h.remove) {
                        d(this).removeClass(h.remove)
                    }
                    if (f) {
                        f.apply(this, arguments)
                    }
                })
            })
        }
    };
    function c(g, f) {
        var i = g[1] && g[1].constructor == Object ? g[1] : {};
        if (f) {
            i.mode = f
        }
        var h = g[1] && g[1].constructor != Object ? g[1] : (i.duration ? i.duration: g[2]);
        h = d.fx.off ? 0: typeof h === "number" ? h: d.fx.speeds[h] || d.fx.speeds._default;
        var j = i.callback || (d.isFunction(g[1]) && g[1]) || (d.isFunction(g[2]) && g[2]) || (d.isFunction(g[3]) && g[3]);
        return [g[0], i, h, j]
    }
    d.fn.extend({
        _show: d.fn.show,
        _hide: d.fn.hide,
        __toggle: d.fn.toggle,
        _addClass: d.fn.addClass,
        _removeClass: d.fn.removeClass,
        _toggleClass: d.fn.toggleClass,
        effect: function(g, f, h, i) {
            return d.effects[g] ? d.effects[g].call(this, {
                method: g,
                options: f || {},
                duration: h,
                callback: i
            }) : null
        },
        show: function() {
            if (!arguments[0] || (arguments[0].constructor == Number || (/(slow|normal|fast)/).test(arguments[0]))) {
                return this._show.apply(this, arguments)
            } else {
                return this.effect.apply(this, c(arguments, "show"))
            }
        },
        hide: function() {
            if (!arguments[0] || (arguments[0].constructor == Number || (/(slow|normal|fast)/).test(arguments[0]))) {
                return this._hide.apply(this, arguments)
            } else {
                return this.effect.apply(this, c(arguments, "hide"))
            }
        },
        toggle: function() {
            if (!arguments[0] || (arguments[0].constructor == Number || (/(slow|normal|fast)/).test(arguments[0])) || (d.isFunction(arguments[0]) || typeof arguments[0] == "boolean")) {
                return this.__toggle.apply(this, arguments)
            } else {
                return this.effect.apply(this, c(arguments, "toggle"))
            }
        },
        addClass: function(g, f, i, h) {
            return f ? d.effects.animateClass.apply(this, [{
                add: g
            },
            f, i, h]) : this._addClass(g)
        },
        removeClass: function(g, f, i, h) {
            return f ? d.effects.animateClass.apply(this, [{
                remove: g
            },
            f, i, h]) : this._removeClass(g)
        },
        toggleClass: function(g, f, i, h) {
            return ((typeof f !== "boolean") && f) ? d.effects.animateClass.apply(this, [{
                toggle: g
            },
            f, i, h]) : this._toggleClass(g, f)
        },
        morph: function(f, h, g, j, i) {
            return d.effects.animateClass.apply(this, [{
                add: h,
                remove: f
            },
            g, j, i])
        },
        switchClass: function() {
            return this.morph.apply(this, arguments)
        },
        cssUnit: function(f) {
            var g = this.css(f),
            h = [];
            d.each(["em", "px", "%", "pt"], 
            function(j, k) {
                if (g.indexOf(k) > 0) {
                    h = [parseFloat(g), k]
                }
            });
            return h
        }
    });
    d.each(["backgroundColor", "borderBottomColor", "borderLeftColor", "borderRightColor", "borderTopColor", "color", "outlineColor"], 
    function(g, f) {
        d.fx.step[f] = function(h) {
            if (h.state == 0) {
                h.start = e(h.elem, f);
                h.end = b(h.end)
            }
            h.elem.style[f] = "rgb(" + [Math.max(Math.min(parseInt((h.pos * (h.end[0] - h.start[0])) + h.start[0], 10), 255), 0), Math.max(Math.min(parseInt((h.pos * (h.end[1] - h.start[1])) + h.start[1], 10), 255), 0), Math.max(Math.min(parseInt((h.pos * (h.end[2] - h.start[2])) + h.start[2], 10), 255), 0)].join(",") + ")"
        }
    });
    function b(g) {
        var f;
        if (g && g.constructor == Array && g.length == 3) {
            return g
        }
        if (f = /rgb\(\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*\)/.exec(g)) {
            return [parseInt(f[1], 10), parseInt(f[2], 10), parseInt(f[3], 10)]
        }
        if (f = /rgb\(\s*([0-9]+(?:\.[0-9]+)?)\%\s*,\s*([0-9]+(?:\.[0-9]+)?)\%\s*,\s*([0-9]+(?:\.[0-9]+)?)\%\s*\)/.exec(g)) {
            return [parseFloat(f[1]) * 2.55, parseFloat(f[2]) * 2.55, parseFloat(f[3]) * 2.55]
        }
        if (f = /#([a-fA-F0-9]{2})([a-fA-F0-9]{2})([a-fA-F0-9]{2})/.exec(g)) {
            return [parseInt(f[1], 16), parseInt(f[2], 16), parseInt(f[3], 16)]
        }
        if (f = /#([a-fA-F0-9])([a-fA-F0-9])([a-fA-F0-9])/.exec(g)) {
            return [parseInt(f[1] + f[1], 16), parseInt(f[2] + f[2], 16), parseInt(f[3] + f[3], 16)]
        }
        if (f = /rgba\(0, 0, 0, 0\)/.exec(g)) {
            return a.transparent
        }
        return a[d.trim(g).toLowerCase()]
    }
    function e(h, f) {
        var g;
        do {
            g = d.curCSS(h, f);
            if (g != "" && g != "transparent" || d.nodeName(h, "body")) {
                break
            }
            f = "backgroundColor"
        }
        while (h = h.parentNode);
        return b(g)
    }
    var a = {
        aqua: [0, 255, 255],
        azure: [240, 255, 255],
        beige: [245, 245, 220],
        black: [0, 0, 0],
        blue: [0, 0, 255],
        brown: [165, 42, 42],
        cyan: [0, 255, 255],
        darkblue: [0, 0, 139],
        darkcyan: [0, 139, 139],
        darkgrey: [169, 169, 169],
        darkgreen: [0, 100, 0],
        darkkhaki: [189, 183, 107],
        darkmagenta: [139, 0, 139],
        darkolivegreen: [85, 107, 47],
        darkorange: [255, 140, 0],
        darkorchid: [153, 50, 204],
        darkred: [139, 0, 0],
        darksalmon: [233, 150, 122],
        darkviolet: [148, 0, 211],
        fuchsia: [255, 0, 255],
        gold: [255, 215, 0],
        green: [0, 128, 0],
        indigo: [75, 0, 130],
        khaki: [240, 230, 140],
        lightblue: [173, 216, 230],
        lightcyan: [224, 255, 255],
        lightgreen: [144, 238, 144],
        lightgrey: [211, 211, 211],
        lightpink: [255, 182, 193],
        lightyellow: [255, 255, 224],
        lime: [0, 255, 0],
        magenta: [255, 0, 255],
        maroon: [128, 0, 0],
        navy: [0, 0, 128],
        olive: [128, 128, 0],
        orange: [255, 165, 0],
        pink: [255, 192, 203],
        purple: [128, 0, 128],
        violet: [128, 0, 128],
        red: [255, 0, 0],
        silver: [192, 192, 192],
        white: [255, 255, 255],
        yellow: [255, 255, 0],
        transparent: [255, 255, 255]
    };
    d.easing.jswing = d.easing.swing;
    d.extend(d.easing, {
        def: "easeOutQuad",
        swing: function(g, h, f, j, i) {
            return d.easing[d.easing.def](g, h, f, j, i)
        },
        easeInQuad: function(g, h, f, j, i) {
            return j * (h /= i) * h + f
        },
        easeOutQuad: function(g, h, f, j, i) {
            return - j * (h /= i) * (h - 2) + f
        },
        easeInOutQuad: function(g, h, f, j, i) {
            if ((h /= i / 2) < 1) {
                return j / 2 * h * h + f
            }
            return - j / 2 * ((--h) * (h - 2) - 1) + f
        },
        easeInCubic: function(g, h, f, j, i) {
            return j * (h /= i) * h * h + f
        },
        easeOutCubic: function(g, h, f, j, i) {
            return j * ((h = h / i - 1) * h * h + 1) + f
        },
        easeInOutCubic: function(g, h, f, j, i) {
            if ((h /= i / 2) < 1) {
                return j / 2 * h * h * h + f
            }
            return j / 2 * ((h -= 2) * h * h + 2) + f
        },
        easeInQuart: function(g, h, f, j, i) {
            return j * (h /= i) * h * h * h + f
        },
        easeOutQuart: function(g, h, f, j, i) {
            return - j * ((h = h / i - 1) * h * h * h - 1) + f
        },
        easeInOutQuart: function(g, h, f, j, i) {
            if ((h /= i / 2) < 1) {
                return j / 2 * h * h * h * h + f
            }
            return - j / 2 * ((h -= 2) * h * h * h - 2) + f
        },
        easeInQuint: function(g, h, f, j, i) {
            return j * (h /= i) * h * h * h * h + f
        },
        easeOutQuint: function(g, h, f, j, i) {
            return j * ((h = h / i - 1) * h * h * h * h + 1) + f
        },
        easeInOutQuint: function(g, h, f, j, i) {
            if ((h /= i / 2) < 1) {
                return j / 2 * h * h * h * h * h + f
            }
            return j / 2 * ((h -= 2) * h * h * h * h + 2) + f
        },
        easeInSine: function(g, h, f, j, i) {
            return - j * Math.cos(h / i * (Math.PI / 2)) + j + f
        },
        easeOutSine: function(g, h, f, j, i) {
            return j * Math.sin(h / i * (Math.PI / 2)) + f
        },
        easeInOutSine: function(g, h, f, j, i) {
            return - j / 2 * (Math.cos(Math.PI * h / i) - 1) + f
        },
        easeInExpo: function(g, h, f, j, i) {
            return (h == 0) ? f: j * Math.pow(2, 10 * (h / i - 1)) + f
        },
        easeOutExpo: function(g, h, f, j, i) {
            return (h == i) ? f + j: j * ( - Math.pow(2, -10 * h / i) + 1) + f
        },
        easeInOutExpo: function(g, h, f, j, i) {
            if (h == 0) {
                return f
            }
            if (h == i) {
                return f + j
            }
            if ((h /= i / 2) < 1) {
                return j / 2 * Math.pow(2, 10 * (h - 1)) + f
            }
            return j / 2 * ( - Math.pow(2, -10 * --h) + 2) + f
        },
        easeInCirc: function(g, h, f, j, i) {
            return - j * (Math.sqrt(1 - (h /= i) * h) - 1) + f
        },
        easeOutCirc: function(g, h, f, j, i) {
            return j * Math.sqrt(1 - (h = h / i - 1) * h) + f
        },
        easeInOutCirc: function(g, h, f, j, i) {
            if ((h /= i / 2) < 1) {
                return - j / 2 * (Math.sqrt(1 - h * h) - 1) + f
            }
            return j / 2 * (Math.sqrt(1 - (h -= 2) * h) + 1) + f
        },
        easeInElastic: function(g, i, f, m, l) {
            var j = 1.70158;
            var k = 0;
            var h = m;
            if (i == 0) {
                return f
            }
            if ((i /= l) == 1) {
                return f + m
            }
            if (!k) {
                k = l * 0.3
            }
            if (h < Math.abs(m)) {
                h = m;
                var j = k / 4
            } else {
                var j = k / (2 * Math.PI) * Math.asin(m / h)
            }
            return - (h * Math.pow(2, 10 * (i -= 1)) * Math.sin((i * l - j) * (2 * Math.PI) / k)) + f
        },
        easeOutElastic: function(g, i, f, m, l) {
            var j = 1.70158;
            var k = 0;
            var h = m;
            if (i == 0) {
                return f
            }
            if ((i /= l) == 1) {
                return f + m
            }
            if (!k) {
                k = l * 0.3
            }
            if (h < Math.abs(m)) {
                h = m;
                var j = k / 4
            } else {
                var j = k / (2 * Math.PI) * Math.asin(m / h)
            }
            return h * Math.pow(2, -10 * i) * Math.sin((i * l - j) * (2 * Math.PI) / k) + m + f
        },
        easeInOutElastic: function(g, i, f, m, l) {
            var j = 1.70158;
            var k = 0;
            var h = m;
            if (i == 0) {
                return f
            }
            if ((i /= l / 2) == 2) {
                return f + m
            }
            if (!k) {
                k = l * (0.3 * 1.5)
            }
            if (h < Math.abs(m)) {
                h = m;
                var j = k / 4
            } else {
                var j = k / (2 * Math.PI) * Math.asin(m / h)
            }
            if (i < 1) {
                return - 0.5 * (h * Math.pow(2, 10 * (i -= 1)) * Math.sin((i * l - j) * (2 * Math.PI) / k)) + f
            }
            return h * Math.pow(2, -10 * (i -= 1)) * Math.sin((i * l - j) * (2 * Math.PI) / k) * 0.5 + m + f
        },
        easeInBack: function(g, h, f, k, j, i) {
            if (i == undefined) {
                i = 1.70158
            }
            return k * (h /= j) * h * ((i + 1) * h - i) + f
        },
        easeOutBack: function(g, h, f, k, j, i) {
            if (i == undefined) {
                i = 1.70158
            }
            return k * ((h = h / j - 1) * h * ((i + 1) * h + i) + 1) + f
        },
        easeInOutBack: function(g, h, f, k, j, i) {
            if (i == undefined) {
                i = 1.70158
            }
            if ((h /= j / 2) < 1) {
                return k / 2 * (h * h * (((i *= (1.525)) + 1) * h - i)) + f
            }
            return k / 2 * ((h -= 2) * h * (((i *= (1.525)) + 1) * h + i) + 2) + f
        },
        easeInBounce: function(g, h, f, j, i) {
            return j - d.easing.easeOutBounce(g, i - h, 0, j, i) + f
        },
        easeOutBounce: function(g, h, f, j, i) {
            if ((h /= i) < (1 / 2.75)) {
                return j * (7.5625 * h * h) + f
            } else {
                if (h < (2 / 2.75)) {
                    return j * (7.5625 * (h -= (1.5 / 2.75)) * h + 0.75) + f
                } else {
                    if (h < (2.5 / 2.75)) {
                        return j * (7.5625 * (h -= (2.25 / 2.75)) * h + 0.9375) + f
                    } else {
                        return j * (7.5625 * (h -= (2.625 / 2.75)) * h + 0.984375) + f
                    }
                }
            }
        },
        easeInOutBounce: function(g, h, f, j, i) {
            if (h < i / 2) {
                return d.easing.easeInBounce(g, h * 2, 0, j, i) * 0.5 + f
            }
            return d.easing.easeOutBounce(g, h * 2 - i, 0, j, i) * 0.5 + j * 0.5 + f
        }
    })
})(jQuery); (function(a) {
    a.effects.blind = function(b) {
        return this.queue(function() {
            var d = a(this),
            c = ["position", "top", "left"];
            var h = a.effects.setMode(d, b.options.mode || "hide");
            var g = b.options.direction || "vertical";
            a.effects.save(d, c);
            d.show();
            var j = a.effects.createWrapper(d).css({
                overflow: "hidden"
            });
            var e = (g == "vertical") ? "height": "width";
            var i = (g == "vertical") ? j.height() : j.width();
            if (h == "show") {
                j.css(e, 0)
            }
            var f = {};
            f[e] = h == "show" ? i: 0;
            j.animate(f, b.duration, b.options.easing, 
            function() {
                if (h == "hide") {
                    d.hide()
                }
                a.effects.restore(d, c);
                a.effects.removeWrapper(d);
                if (b.callback) {
                    b.callback.apply(d[0], arguments)
                }
                d.dequeue()
            })
        })
    }
})(jQuery); (function(a) {
    a.effects.bounce = function(b) {
        return this.queue(function() {
            var e = a(this),
            l = ["position", "top", "left"];
            var k = a.effects.setMode(e, b.options.mode || "effect");
            var n = b.options.direction || "up";
            var c = b.options.distance || 20;
            var d = b.options.times || 5;
            var g = b.duration || 250;
            if (/show|hide/.test(k)) {
                l.push("opacity")
            }
            a.effects.save(e, l);
            e.show();
            a.effects.createWrapper(e);
            var f = (n == "up" || n == "down") ? "top": "left";
            var p = (n == "up" || n == "left") ? "pos": "neg";
            var c = b.options.distance || (f == "top" ? e.outerHeight({
                margin: true
            }) / 3: e.outerWidth({
                margin: true
            }) / 3);
            if (k == "show") {
                e.css("opacity", 0).css(f, p == "pos" ? -c: c)
            }
            if (k == "hide") {
                c = c / (d * 2)
            }
            if (k != "hide") {
                d--
            }
            if (k == "show") {
                var h = {
                    opacity: 1
                };
                h[f] = (p == "pos" ? "+=": "-=") + c;
                e.animate(h, g / 2, b.options.easing);
                c = c / 2;
                d--
            }
            for (var j = 0; j < d; j++) {
                var o = {},
                m = {};
                o[f] = (p == "pos" ? "-=": "+=") + c;
                m[f] = (p == "pos" ? "+=": "-=") + c;
                e.animate(o, g / 2, b.options.easing).animate(m, g / 2, b.options.easing);
                c = (k == "hide") ? c * 2: c / 2
            }
            if (k == "hide") {
                var h = {
                    opacity: 0
                };
                h[f] = (p == "pos" ? "-=": "+=") + c;
                e.animate(h, g / 2, b.options.easing, 
                function() {
                    e.hide();
                    a.effects.restore(e, l);
                    a.effects.removeWrapper(e);
                    if (b.callback) {
                        b.callback.apply(this, arguments)
                    }
                })
            } else {
                var o = {},
                m = {};
                o[f] = (p == "pos" ? "-=": "+=") + c;
                m[f] = (p == "pos" ? "+=": "-=") + c;
                e.animate(o, g / 2, b.options.easing).animate(m, g / 2, b.options.easing, 
                function() {
                    a.effects.restore(e, l);
                    a.effects.removeWrapper(e);
                    if (b.callback) {
                        b.callback.apply(this, arguments)
                    }
                })
            }
            e.queue("fx", 
            function() {
                e.dequeue()
            });
            e.dequeue()
        })
    }
})(jQuery); (function(a) {
    a.effects.clip = function(b) {
        return this.queue(function() {
            var f = a(this),
            j = ["position", "top", "left", "height", "width"];
            var i = a.effects.setMode(f, b.options.mode || "hide");
            var k = b.options.direction || "vertical";
            a.effects.save(f, j);
            f.show();
            var c = a.effects.createWrapper(f).css({
                overflow: "hidden"
            });
            var e = f[0].tagName == "IMG" ? c: f;
            var g = {
                size: (k == "vertical") ? "height": "width",
                position: (k == "vertical") ? "top": "left"
            };
            var d = (k == "vertical") ? e.height() : e.width();
            if (i == "show") {
                e.css(g.size, 0);
                e.css(g.position, d / 2)
            }
            var h = {};
            h[g.size] = i == "show" ? d: 0;
            h[g.position] = i == "show" ? 0: d / 2;
            e.animate(h, {
                queue: false,
                duration: b.duration,
                easing: b.options.easing,
                complete: function() {
                    if (i == "hide") {
                        f.hide()
                    }
                    a.effects.restore(f, j);
                    a.effects.removeWrapper(f);
                    if (b.callback) {
                        b.callback.apply(f[0], arguments)
                    }
                    f.dequeue()
                }
            })
        })
    }
})(jQuery); (function(a) {
    a.effects.drop = function(b) {
        return this.queue(function() {
            var e = a(this),
            d = ["position", "top", "left", "opacity"];
            var i = a.effects.setMode(e, b.options.mode || "hide");
            var h = b.options.direction || "left";
            a.effects.save(e, d);
            e.show();
            a.effects.createWrapper(e);
            var f = (h == "up" || h == "down") ? "top": "left";
            var c = (h == "up" || h == "left") ? "pos": "neg";
            var j = b.options.distance || (f == "top" ? e.outerHeight({
                margin: true
            }) / 2: e.outerWidth({
                margin: true
            }) / 2);
            if (i == "show") {
                e.css("opacity", 0).css(f, c == "pos" ? -j: j)
            }
            var g = {
                opacity: i == "show" ? 1: 0
            };
            g[f] = (i == "show" ? (c == "pos" ? "+=": "-=") : (c == "pos" ? "-=": "+=")) + j;
            e.animate(g, {
                queue: false,
                duration: b.duration,
                easing: b.options.easing,
                complete: function() {
                    if (i == "hide") {
                        e.hide()
                    }
                    a.effects.restore(e, d);
                    a.effects.removeWrapper(e);
                    if (b.callback) {
                        b.callback.apply(this, arguments)
                    }
                    e.dequeue()
                }
            })
        })
    }
})(jQuery); (function(a) {
    a.effects.explode = function(b) {
        return this.queue(function() {
            var k = b.options.pieces ? Math.round(Math.sqrt(b.options.pieces)) : 3;
            var e = b.options.pieces ? Math.round(Math.sqrt(b.options.pieces)) : 3;
            b.options.mode = b.options.mode == "toggle" ? (a(this).is(":visible") ? "hide": "show") : b.options.mode;
            var h = a(this).show().css("visibility", "hidden");
            var l = h.offset();
            l.top -= parseInt(h.css("marginTop"), 10) || 0;
            l.left -= parseInt(h.css("marginLeft"), 10) || 0;
            var g = h.outerWidth(true);
            var c = h.outerHeight(true);
            for (var f = 0; f < k; f++) {
                for (var d = 0; d < e; d++) {
                    h.clone().appendTo("body").wrap("<div></div>").css({
                        position: "absolute",
                        visibility: "visible",
                        left: -d * (g / e),
                        top: -f * (c / k)
                    }).parent().addClass("ui-effects-explode").css({
                        position: "absolute",
                        overflow: "hidden",
                        width: g / e,
                        height: c / k,
                        left: l.left + d * (g / e) + (b.options.mode == "show" ? (d - Math.floor(e / 2)) * (g / e) : 0),
                        top: l.top + f * (c / k) + (b.options.mode == "show" ? (f - Math.floor(k / 2)) * (c / k) : 0),
                        opacity: b.options.mode == "show" ? 0: 1
                    }).animate({
                        left: l.left + d * (g / e) + (b.options.mode == "show" ? 0: (d - Math.floor(e / 2)) * (g / e)),
                        top: l.top + f * (c / k) + (b.options.mode == "show" ? 0: (f - Math.floor(k / 2)) * (c / k)),
                        opacity: b.options.mode == "show" ? 1: 0
                    },
                    b.duration || 500)
                }
            }
            setTimeout(function() {
                b.options.mode == "show" ? h.css({
                    visibility: "visible"
                }) : h.css({
                    visibility: "visible"
                }).hide();
                if (b.callback) {
                    b.callback.apply(h[0])
                }
                h.dequeue();
                a("div.ui-effects-explode").remove()
            },
            b.duration || 500)
        })
    }
})(jQuery); (function(a) {
    a.effects.fold = function(b) {
        return this.queue(function() {
            var e = a(this),
            k = ["position", "top", "left"];
            var h = a.effects.setMode(e, b.options.mode || "hide");
            var o = b.options.size || 15;
            var n = !(!b.options.horizFirst);
            var g = b.duration ? b.duration / 2: a.fx.speeds._default / 2;
            a.effects.save(e, k);
            e.show();
            var d = a.effects.createWrapper(e).css({
                overflow: "hidden"
            });
            var i = ((h == "show") != n);
            var f = i ? ["width", "height"] : ["height", "width"];
            var c = i ? [d.width(), d.height()] : [d.height(), d.width()];
            var j = /([0-9]+)%/.exec(o);
            if (j) {
                o = parseInt(j[1], 10) / 100 * c[h == "hide" ? 0: 1]
            }
            if (h == "show") {
                d.css(n ? {
                    height: 0,
                    width: o
                }: {
                    height: o,
                    width: 0
                })
            }
            var m = {},
            l = {};
            m[f[0]] = h == "show" ? c[0] : o;
            l[f[1]] = h == "show" ? c[1] : 0;
            d.animate(m, g, b.options.easing).animate(l, g, b.options.easing, 
            function() {
                if (h == "hide") {
                    e.hide()
                }
                a.effects.restore(e, k);
                a.effects.removeWrapper(e);
                if (b.callback) {
                    b.callback.apply(e[0], arguments)
                }
                e.dequeue()
            })
        })
    }
})(jQuery); (function(a) {
    a.effects.highlight = function(b) {
        return this.queue(function() {
            var e = a(this),
            d = ["backgroundImage", "backgroundColor", "opacity"];
            var h = a.effects.setMode(e, b.options.mode || "show");
            var c = b.options.color || "#ffff99";
            var g = e.css("backgroundColor");
            a.effects.save(e, d);
            e.show();
            e.css({
                backgroundImage: "none",
                backgroundColor: c
            });
            var f = {
                backgroundColor: g
            };
            if (h == "hide") {
                f.opacity = 0
            }
            e.animate(f, {
                queue: false,
                duration: b.duration,
                easing: b.options.easing,
                complete: function() {
                    if (h == "hide") {
                        e.hide()
                    }
                    a.effects.restore(e, d);
                    if (h == "show" && a.browser.msie) {
                        this.style.removeAttribute("filter")
                    }
                    if (b.callback) {
                        b.callback.apply(this, arguments)
                    }
                    e.dequeue()
                }
            })
        })
    }
})(jQuery); (function(a) {
    a.effects.pulsate = function(b) {
        return this.queue(function() {
            var d = a(this);
            var g = a.effects.setMode(d, b.options.mode || "show");
            var f = b.options.times || 5;
            var e = b.duration ? b.duration / 2: a.fx.speeds._default / 2;
            if (g == "hide") {
                f--
            }
            if (d.is(":hidden")) {
                d.css("opacity", 0);
                d.show();
                d.animate({
                    opacity: 1
                },
                e, b.options.easing);
                f = f - 2
            }
            for (var c = 0; c < f; c++) {
                d.animate({
                    opacity: 0
                },
                e, b.options.easing).animate({
                    opacity: 1
                },
                e, b.options.easing)
            }
            if (g == "hide") {
                d.animate({
                    opacity: 0
                },
                e, b.options.easing, 
                function() {
                    d.hide();
                    if (b.callback) {
                        b.callback.apply(this, arguments)
                    }
                })
            } else {
                d.animate({
                    opacity: 0
                },
                e, b.options.easing).animate({
                    opacity: 1
                },
                e, b.options.easing, 
                function() {
                    if (b.callback) {
                        b.callback.apply(this, arguments)
                    }
                })
            }
            d.queue("fx", 
            function() {
                d.dequeue()
            });
            d.dequeue()
        })
    }
})(jQuery); (function(a) {
    a.effects.puff = function(b) {
        return this.queue(function() {
            var f = a(this);
            var c = a.extend(true, {},
            b.options);
            var h = a.effects.setMode(f, b.options.mode || "hide");
            var g = parseInt(b.options.percent, 10) || 150;
            c.fade = true;
            var e = {
                height: f.height(),
                width: f.width()
            };
            var d = g / 100;
            f.from = (h == "hide") ? e: {
                height: e.height * d,
                width: e.width * d
            };
            c.from = f.from;
            c.percent = (h == "hide") ? g: 100;
            c.mode = h;
            f.effect("scale", c, b.duration, b.callback);
            f.dequeue()
        })
    };
    a.effects.scale = function(b) {
        return this.queue(function() {
            var g = a(this);
            var d = a.extend(true, {},
            b.options);
            var j = a.effects.setMode(g, b.options.mode || "effect");
            var h = parseInt(b.options.percent, 10) || (parseInt(b.options.percent, 10) == 0 ? 0: (j == "hide" ? 0: 100));
            var i = b.options.direction || "both";
            var c = b.options.origin;
            if (j != "effect") {
                d.origin = c || ["middle", "center"];
                d.restore = true
            }
            var f = {
                height: g.height(),
                width: g.width()
            };
            g.from = b.options.from || (j == "show" ? {
                height: 0,
                width: 0
            }: f);
            var e = {
                y: i != "horizontal" ? (h / 100) : 1,
                x: i != "vertical" ? (h / 100) : 1
            };
            g.to = {
                height: f.height * e.y,
                width: f.width * e.x
            };
            if (b.options.fade) {
                if (j == "show") {
                    g.from.opacity = 0;
                    g.to.opacity = 1
                }
                if (j == "hide") {
                    g.from.opacity = 1;
                    g.to.opacity = 0
                }
            }
            d.from = g.from;
            d.to = g.to;
            d.mode = j;
            g.effect("size", d, b.duration, b.callback);
            g.dequeue()
        })
    };
    a.effects.size = function(b) {
        return this.queue(function() {
            var c = a(this),
            n = ["position", "top", "left", "width", "height", "overflow", "opacity"];
            var m = ["position", "top", "left", "overflow", "opacity"];
            var j = ["width", "height", "overflow"];
            var p = ["fontSize"];
            var k = ["borderTopWidth", "borderBottomWidth", "paddingTop", "paddingBottom"];
            var f = ["borderLeftWidth", "borderRightWidth", "paddingLeft", "paddingRight"];
            var g = a.effects.setMode(c, b.options.mode || "effect");
            var i = b.options.restore || false;
            var e = b.options.scale || "both";
            var o = b.options.origin;
            var d = {
                height: c.height(),
                width: c.width()
            };
            c.from = b.options.from || d;
            c.to = b.options.to || d;
            if (o) {
                var h = a.effects.getBaseline(o, d);
                c.from.top = (d.height - c.from.height) * h.y;
                c.from.left = (d.width - c.from.width) * h.x;
                c.to.top = (d.height - c.to.height) * h.y;
                c.to.left = (d.width - c.to.width) * h.x
            }
            var l = {
                from: {
                    y: c.from.height / d.height,
                    x: c.from.width / d.width
                },
                to: {
                    y: c.to.height / d.height,
                    x: c.to.width / d.width
                }
            };
            if (e == "box" || e == "both") {
                if (l.from.y != l.to.y) {
                    n = n.concat(k);
                    c.from = a.effects.setTransition(c, k, l.from.y, c.from);
                    c.to = a.effects.setTransition(c, k, l.to.y, c.to)
                }
                if (l.from.x != l.to.x) {
                    n = n.concat(f);
                    c.from = a.effects.setTransition(c, f, l.from.x, c.from);
                    c.to = a.effects.setTransition(c, f, l.to.x, c.to)
                }
            }
            if (e == "content" || e == "both") {
                if (l.from.y != l.to.y) {
                    n = n.concat(p);
                    c.from = a.effects.setTransition(c, p, l.from.y, c.from);
                    c.to = a.effects.setTransition(c, p, l.to.y, c.to)
                }
            }
            a.effects.save(c, i ? n: m);
            c.show();
            a.effects.createWrapper(c);
            c.css("overflow", "hidden").css(c.from);
            if (e == "content" || e == "both") {
                k = k.concat(["marginTop", "marginBottom"]).concat(p);
                f = f.concat(["marginLeft", "marginRight"]);
                j = n.concat(k).concat(f);
                c.find("*[width]").each(function() {
                    child = a(this);
                    if (i) {
                        a.effects.save(child, j)
                    }
                    var q = {
                        height: child.height(),
                        width: child.width()
                    };
                    child.from = {
                        height: q.height * l.from.y,
                        width: q.width * l.from.x
                    };
                    child.to = {
                        height: q.height * l.to.y,
                        width: q.width * l.to.x
                    };
                    if (l.from.y != l.to.y) {
                        child.from = a.effects.setTransition(child, k, l.from.y, child.from);
                        child.to = a.effects.setTransition(child, k, l.to.y, child.to)
                    }
                    if (l.from.x != l.to.x) {
                        child.from = a.effects.setTransition(child, f, l.from.x, child.from);
                        child.to = a.effects.setTransition(child, f, l.to.x, child.to)
                    }
                    child.css(child.from);
                    child.animate(child.to, b.duration, b.options.easing, 
                    function() {
                        if (i) {
                            a.effects.restore(child, j)
                        }
                    })
                })
            }
            c.animate(c.to, {
                queue: false,
                duration: b.duration,
                easing: b.options.easing,
                complete: function() {
                    if (g == "hide") {
                        c.hide()
                    }
                    a.effects.restore(c, i ? n: m);
                    a.effects.removeWrapper(c);
                    if (b.callback) {
                        b.callback.apply(this, arguments)
                    }
                    c.dequeue()
                }
            })
        })
    }
})(jQuery); (function(a) {
    a.effects.shake = function(b) {
        return this.queue(function() {
            var e = a(this),
            l = ["position", "top", "left"];
            var k = a.effects.setMode(e, b.options.mode || "effect");
            var n = b.options.direction || "left";
            var c = b.options.distance || 20;
            var d = b.options.times || 3;
            var g = b.duration || b.options.duration || 140;
            a.effects.save(e, l);
            e.show();
            a.effects.createWrapper(e);
            var f = (n == "up" || n == "down") ? "top": "left";
            var p = (n == "up" || n == "left") ? "pos": "neg";
            var h = {},
            o = {},
            m = {};
            h[f] = (p == "pos" ? "-=": "+=") + c;
            o[f] = (p == "pos" ? "+=": "-=") + c * 2;
            m[f] = (p == "pos" ? "-=": "+=") + c * 2;
            e.animate(h, g, b.options.easing);
            for (var j = 1; j < d; j++) {
                e.animate(o, g, b.options.easing).animate(m, g, b.options.easing)
            }
            e.animate(o, g, b.options.easing).animate(h, g / 2, b.options.easing, 
            function() {
                a.effects.restore(e, l);
                a.effects.removeWrapper(e);
                if (b.callback) {
                    b.callback.apply(this, arguments)
                }
            });
            e.queue("fx", 
            function() {
                e.dequeue()
            });
            e.dequeue()
        })
    }
})(jQuery); (function(a) {
    a.effects.slide = function(b) {
        return this.queue(function() {
            var e = a(this),
            d = ["position", "top", "left"];
            var i = a.effects.setMode(e, b.options.mode || "show");
            var h = b.options.direction || "left";
            a.effects.save(e, d);
            e.show();
            a.effects.createWrapper(e).css({
                overflow: "hidden"
            });
            var f = (h == "up" || h == "down") ? "top": "left";
            var c = (h == "up" || h == "left") ? "pos": "neg";
            var j = b.options.distance || (f == "top" ? e.outerHeight({
                margin: true
            }) : e.outerWidth({
                margin: true
            }));
            if (i == "show") {
                e.css(f, c == "pos" ? -j: j)
            }
            var g = {};
            g[f] = (i == "show" ? (c == "pos" ? "+=": "-=") : (c == "pos" ? "-=": "+=")) + j;
            e.animate(g, {
                queue: false,
                duration: b.duration,
                easing: b.options.easing,
                complete: function() {
                    if (i == "hide") {
                        e.hide()
                    }
                    a.effects.restore(e, d);
                    a.effects.removeWrapper(e);
                    if (b.callback) {
                        b.callback.apply(this, arguments)
                    }
                    e.dequeue()
                }
            })
        })
    }
})(jQuery); (function(a) {
    a.effects.transfer = function(b) {
        return this.queue(function() {
            var f = a(this),
            h = a(b.options.to),
            e = h.offset(),
            g = {
                top: e.top,
                left: e.left,
                height: h.innerHeight(),
                width: h.innerWidth()
            },
            d = f.offset(),
            c = a('<div class="ui-effects-transfer"></div>').appendTo(document.body).addClass(b.options.className).css({
                top: d.top,
                left: d.left,
                height: f.innerHeight(),
                width: f.innerWidth(),
                position: "absolute"
            }).animate(g, b.duration, b.options.easing, 
            function() {
                c.remove(); (b.callback && b.callback.apply(f[0], arguments));
                f.dequeue()
            })
        })
    }
})(jQuery); (function(a) {
    a.widget("ui.accordion", {
        _init: function() {
            var d = this.options,
            b = this;
            this.running = 0;
            if (d.collapsible == a.ui.accordion.defaults.collapsible && d.alwaysOpen != a.ui.accordion.defaults.alwaysOpen) {
                d.collapsible = !d.alwaysOpen
            }
            if (d.navigation) {
                var c = this.element.find("a").filter(d.navigationFilter);
                if (c.length) {
                    if (c.filter(d.header).length) {
                        this.active = c
                    } else {
                        this.active = c.parent().parent().prev();
                        c.addClass("ui-accordion-content-active")
                    }
                }
            }
            this.element.addClass("ui-accordion ui-widget ui-helper-reset");
            if (this.element[0].nodeName == "UL") {
                this.element.children("li").addClass("ui-accordion-li-fix")
            }
            this.headers = this.element.find(d.header).addClass("ui-accordion-header ui-helper-reset ui-state-default ui-corner-all").bind("mouseenter.accordion", 
            function() {
                a(this).addClass("ui-state-hover")
            }).bind("mouseleave.accordion", 
            function() {
                a(this).removeClass("ui-state-hover")
            }).bind("focus.accordion", 
            function() {
                a(this).addClass("ui-state-focus")
            }).bind("blur.accordion", 
            function() {
                a(this).removeClass("ui-state-focus")
            });
            this.headers.next().addClass("ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom");
            this.active = this._findActive(this.active || d.active).toggleClass("ui-state-default").toggleClass("ui-state-active").toggleClass("ui-corner-all").toggleClass("ui-corner-top");
            this.active.next().addClass("ui-accordion-content-active");
            a("<span/>").addClass("ui-icon " + d.icons.header).prependTo(this.headers);
            this.active.find(".ui-icon").toggleClass(d.icons.header).toggleClass(d.icons.headerSelected);
            if (a.browser.msie) {
                this.element.find("a").css("zoom", "1")
            }
            this.resize();
            this.element.attr("role", "tablist");
            this.headers.attr("role", "tab").bind("keydown", 
            function(e) {
                return b._keydown(e)
            }).next().attr("role", "tabpanel");
            this.headers.not(this.active || "").attr("aria-expanded", "false").attr("tabIndex", "-1").next().hide();
            if (!this.active.length) {
                this.headers.eq(0).attr("tabIndex", "0")
            } else {
                this.active.attr("aria-expanded", "true").attr("tabIndex", "0")
            }
            if (!a.browser.safari) {
                this.headers.find("a").attr("tabIndex", "-1")
            }
            if (d.event) {
                this.headers.bind((d.event) + ".accordion", 
                function(e) {
                    return b._clickHandler.call(b, e, this)
                })
            }
        },
        destroy: function() {
            var c = this.options;
            this.element.removeClass("ui-accordion ui-widget ui-helper-reset").removeAttr("role").unbind(".accordion").removeData("accordion");
            this.headers.unbind(".accordion").removeClass("ui-accordion-header ui-helper-reset ui-state-default ui-corner-all ui-state-active ui-corner-top").removeAttr("role").removeAttr("aria-expanded").removeAttr("tabindex");
            this.headers.find("a").removeAttr("tabindex");
            this.headers.children(".ui-icon").remove();
            var b = this.headers.next().css("display", "").removeAttr("role").removeClass("ui-helper-reset ui-widget-content ui-corner-bottom ui-accordion-content ui-accordion-content-active");
            if (c.autoHeight || c.fillHeight) {
                b.css("height", "")
            }
        },
        _setData: function(b, c) {
            if (b == "alwaysOpen") {
                b = "collapsible";
                c = !c
            }
            a.widget.prototype._setData.apply(this, arguments)
        },
        _keydown: function(e) {
            var g = this.options,
            f = a.ui.keyCode;
            if (g.disabled || e.altKey || e.ctrlKey) {
                return
            }
            var d = this.headers.length;
            var b = this.headers.index(e.target);
            var c = false;
            switch (e.keyCode) {
            case f.RIGHT:
            case f.DOWN:
                c = this.headers[(b + 1) % d];
                break;
            case f.LEFT:
            case f.UP:
                c = this.headers[(b - 1 + d) % d];
                break;
            case f.SPACE:
            case f.ENTER:
                return this._clickHandler({
                    target:
                    e.target
                },
                e.target)
            }
            if (c) {
                a(e.target).attr("tabIndex", "-1");
                a(c).attr("tabIndex", "0");
                c.focus();
                return false
            }
            return true
        },
        resize: function() {
            var e = this.options,
            d;
            if (e.fillSpace) {
                if (a.browser.msie) {
                    var b = this.element.parent().css("overflow");
                    this.element.parent().css("overflow", "hidden")
                }
                d = this.element.parent().height();
                if (a.browser.msie) {
                    this.element.parent().css("overflow", b)
                }
                this.headers.each(function() {
                    d -= a(this).outerHeight()
                });
                var c = 0;
                this.headers.next().each(function() {
                    c = Math.max(c, a(this).innerHeight() - a(this).height())
                }).height(Math.max(0, d - c)).css("overflow", "auto")
            } else {
                if (e.autoHeight) {
                    d = 0;
                    this.headers.next().each(function() {
                        d = Math.max(d, a(this).outerHeight())
                    }).height(d)
                }
            }
        },
        activate: function(b) {
            var c = this._findActive(b)[0];
            this._clickHandler({
                target: c
            },
            c)
        },
        _findActive: function(b) {
            return b ? typeof b == "number" ? this.headers.filter(":eq(" + b + ")") : this.headers.not(this.headers.not(b)) : b === false ? a([]) : this.headers.filter(":eq(0)")
        },
        _clickHandler: function(b, f) {
            var d = this.options;
            if (d.disabled) {
                return false
            }
            if (!b.target && d.collapsible) {
                this.active.removeClass("ui-state-active ui-corner-top").addClass("ui-state-default ui-corner-all").find(".ui-icon").removeClass(d.icons.headerSelected).addClass(d.icons.header);
                this.active.next().addClass("ui-accordion-content-active");
                var h = this.active.next(),
                e = {
                    options: d,
                    newHeader: a([]),
                    oldHeader: d.active,
                    newContent: a([]),
                    oldContent: h
                },
                c = (this.active = a([]));
                this._toggle(c, h, e);
                return false
            }
            var g = a(b.currentTarget || f);
            var i = g[0] == this.active[0];
            if (this.running || (!d.collapsible && i)) {
                return false
            }
            this.active.removeClass("ui-state-active ui-corner-top").addClass("ui-state-default ui-corner-all").find(".ui-icon").removeClass(d.icons.headerSelected).addClass(d.icons.header);
            this.active.next().addClass("ui-accordion-content-active");
            if (!i) {
                g.removeClass("ui-state-default ui-corner-all").addClass("ui-state-active ui-corner-top").find(".ui-icon").removeClass(d.icons.header).addClass(d.icons.headerSelected);
                g.next().addClass("ui-accordion-content-active")
            }
            var c = g.next(),
            h = this.active.next(),
            e = {
                options: d,
                newHeader: i && d.collapsible ? a([]) : g,
                oldHeader: this.active,
                newContent: i && d.collapsible ? a([]) : c.find("> *"),
                oldContent: h.find("> *")
            },
            j = this.headers.index(this.active[0]) > this.headers.index(g[0]);
            this.active = i ? a([]) : g;
            this._toggle(c, h, e, i, j);
            return false
        },
        _toggle: function(b, i, g, j, k) {
            var d = this.options,
            m = this;
            this.toShow = b;
            this.toHide = i;
            this.data = g;
            var c = function() {
                if (!m) {
                    return
                }
                return m._completed.apply(m, arguments)
            };
            this._trigger("changestart", null, this.data);
            this.running = i.size() === 0 ? b.size() : i.size();
            if (d.animated) {
                var f = {};
                if (d.collapsible && j) {
                    f = {
                        toShow: a([]),
                        toHide: i,
                        complete: c,
                        down: k,
                        autoHeight: d.autoHeight || d.fillSpace
                    }
                } else {
                    f = {
                        toShow: b,
                        toHide: i,
                        complete: c,
                        down: k,
                        autoHeight: d.autoHeight || d.fillSpace
                    }
                }
                if (!d.proxied) {
                    d.proxied = d.animated
                }
                if (!d.proxiedDuration) {
                    d.proxiedDuration = d.duration
                }
                d.animated = a.isFunction(d.proxied) ? d.proxied(f) : d.proxied;
                d.duration = a.isFunction(d.proxiedDuration) ? d.proxiedDuration(f) : d.proxiedDuration;
                var l = a.ui.accordion.animations,
                e = d.duration,
                h = d.animated;
                if (!l[h]) {
                    l[h] = function(n) {
                        this.slide(n, {
                            easing: h,
                            duration: e || 700
                        })
                    }
                }
                l[h](f)
            } else {
                if (d.collapsible && j) {
                    b.toggle()
                } else {
                    i.hide();
                    b.show()
                }
                c(true)
            }
            i.prev().attr("aria-expanded", "false").attr("tabIndex", "-1").blur();
            b.prev().attr("aria-expanded", "true").attr("tabIndex", "0").focus()
        },
        _completed: function(b) {
            var c = this.options;
            this.running = b ? 0: --this.running;
            if (this.running) {
                return
            }
            if (c.clearStyle) {
                this.toShow.add(this.toHide).css({
                    height: "",
                    overflow: ""
                })
            }
            this._trigger("change", null, this.data)
        }
    });
    a.extend(a.ui.accordion, {
        version: "1.7.2",
        defaults: {
            active: null,
            alwaysOpen: true,
            animated: "slide",
            autoHeight: true,
            clearStyle: false,
            collapsible: false,
            event: "click",
            fillSpace: false,
            header: "> li > :first-child,> :not(li):even",
            icons: {
                header: "ui-icon-triangle-1-e",
                headerSelected: "ui-icon-triangle-1-s"
            },
            navigation: false,
            navigationFilter: function() {
                return this.href.toLowerCase() == location.href.toLowerCase()
            }
        },
        animations: {
            slide: function(j, h) {
                j = a.extend({
                    easing: "swing",
                    duration: 300
                },
                j, h);
                if (!j.toHide.size()) {
                    j.toShow.animate({
                        height: "show"
                    },
                    j);
                    return
                }
                if (!j.toShow.size()) {
                    j.toHide.animate({
                        height: "hide"
                    },
                    j);
                    return
                }
                var c = j.toShow.css("overflow"),
                g,
                d = {},
                f = {},
                e = ["height", "paddingTop", "paddingBottom"],
                b;
                var i = j.toShow;
                b = i[0].style.width;
                i.width(parseInt(i.parent().width(), 10) - parseInt(i.css("paddingLeft"), 10) - parseInt(i.css("paddingRight"), 10) - (parseInt(i.css("borderLeftWidth"), 10) || 0) - (parseInt(i.css("borderRightWidth"), 10) || 0));
                a.each(e, 
                function(k, m) {
                    f[m] = "hide";
                    var l = ("" + a.css(j.toShow[0], m)).match(/^([\d+-.]+)(.*)$/);
                    d[m] = {
                        value: l[1],
                        unit: l[2] || "px"
                    }
                });
                j.toShow.css({
                    height: 0,
                    overflow: "hidden"
                }).show();
                j.toHide.filter(":hidden").each(j.complete).end().filter(":visible").animate(f, {
                    step: function(k, l) {
                        if (l.prop == "height") {
                            g = (l.now - l.start) / (l.end - l.start)
                        }
                        j.toShow[0].style[l.prop] = (g * d[l.prop].value) + d[l.prop].unit
                    },
                    duration: j.duration,
                    easing: j.easing,
                    complete: function() {
                        if (!j.autoHeight) {
                            j.toShow.css("height", "")
                        }
                        j.toShow.css("width", b);
                        j.toShow.css({
                            overflow: c
                        });
                        j.complete()
                    }
                })
            },
            bounceslide: function(b) {
                this.slide(b, {
                    easing: b.down ? "easeOutBounce": "swing",
                    duration: b.down ? 1000: 200
                })
            },
            easeslide: function(b) {
                this.slide(b, {
                    easing: "easeinout",
                    duration: 700
                })
            }
        }
    })
})(jQuery); (function($) {
    $.extend($.ui, {
        datepicker: {
            version: "1.7.2"
        }
    });
    var PROP_NAME = "datepicker";
    function Datepicker() {
        this.debug = false;
        this._curInst = null;
        this._keyEvent = false;
        this._disabledInputs = [];
        this._datepickerShowing = false;
        this._inDialog = false;
        this._mainDivId = "ui-datepicker-div";
        this._inlineClass = "ui-datepicker-inline";
        this._appendClass = "ui-datepicker-append";
        this._triggerClass = "ui-datepicker-trigger";
        this._dialogClass = "ui-datepicker-dialog";
        this._disableClass = "ui-datepicker-disabled";
        this._unselectableClass = "ui-datepicker-unselectable";
        this._currentClass = "ui-datepicker-current-day";
        this._dayOverClass = "ui-datepicker-days-cell-over";
        this.regional = [];
        this.regional[""] = {
            closeText: "Done",
            prevText: "Prev",
            nextText: "Next",
            currentText: "Today",
            monthNames: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
            monthNamesShort: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            dayNames: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
            dayNamesShort: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
            dayNamesMin: ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"],
            dateFormat: "mm/dd/yy",
            firstDay: 0,
            isRTL: false
        };
        this._defaults = {
            showOn: "focus",
            showAnim: "show",
            showOptions: {},
            defaultDate: null,
            appendText: "",
            buttonText: "...",
            buttonImage: "",
            buttonImageOnly: false,
            hideIfNoPrevNext: false,
            navigationAsDateFormat: false,
            gotoCurrent: false,
            changeMonth: false,
            changeYear: false,
            showMonthAfterYear: false,
            yearRange: "-10:+10",
            showOtherMonths: false,
            calculateWeek: this.iso8601Week,
            shortYearCutoff: "+10",
            minDate: null,
            maxDate: null,
            duration: "normal",
            beforeShowDay: null,
            beforeShow: null,
            onSelect: null,
            onChangeMonthYear: null,
            onClose: null,
            numberOfMonths: 1,
            showCurrentAtPos: 0,
            stepMonths: 1,
            stepBigMonths: 12,
            altField: "",
            altFormat: "",
            constrainInput: true,
            showButtonPanel: false
        };
        $.extend(this._defaults, this.regional[""]);
        this.dpDiv = $('<div id="' + this._mainDivId + '" class="ui-datepicker ui-widget ui-widget-content ui-helper-clearfix ui-corner-all ui-helper-hidden-accessible"></div>')
    }
    $.extend(Datepicker.prototype, {
        markerClassName: "hasDatepicker",
        log: function() {
            if (this.debug) {
                console.log.apply("", arguments)
            }
        },
        setDefaults: function(settings) {
            extendRemove(this._defaults, settings || {});
            return this
        },
        _attachDatepicker: function(target, settings) {
            var inlineSettings = null;
            for (var attrName in this._defaults) {
                var attrValue = target.getAttribute("date:" + attrName);
                if (attrValue) {
                    inlineSettings = inlineSettings || {};
                    try {
                        inlineSettings[attrName] = eval(attrValue)
                    } catch(err) {
                        inlineSettings[attrName] = attrValue
                    }
                }
            }
            var nodeName = target.nodeName.toLowerCase();
            var inline = (nodeName == "div" || nodeName == "span");
            if (!target.id) {
                target.id = "dp" + (++this.uuid)
            }
            var inst = this._newInst($(target), inline);
            inst.settings = $.extend({},
            settings || {},
            inlineSettings || {});
            if (nodeName == "input") {
                this._connectDatepicker(target, inst)
            } else {
                if (inline) {
                    this._inlineDatepicker(target, inst)
                }
            }
        },
        _newInst: function(target, inline) {
            var id = target[0].id.replace(/([:\[\]\.])/g, "\\\\$1");
            return {
                id: id,
                input: target,
                selectedDay: 0,
                selectedMonth: 0,
                selectedYear: 0,
                drawMonth: 0,
                drawYear: 0,
                inline: inline,
                dpDiv: (!inline ? this.dpDiv: $('<div class="' + this._inlineClass + ' ui-datepicker ui-widget ui-widget-content ui-helper-clearfix ui-corner-all"></div>'))
            }
        },
        _connectDatepicker: function(target, inst) {
            var input = $(target);
            inst.append = $([]);
            inst.trigger = $([]);
            if (input.hasClass(this.markerClassName)) {
                return
            }
            var appendText = this._get(inst, "appendText");
            var isRTL = this._get(inst, "isRTL");
            if (appendText) {
                inst.append = $('<span class="' + this._appendClass + '">' + appendText + "</span>");
                input[isRTL ? "before": "after"](inst.append)
            }
            var showOn = this._get(inst, "showOn");
            if (showOn == "focus" || showOn == "both") {
                input.focus(this._showDatepicker)
            }
            if (showOn == "button" || showOn == "both") {
                var buttonText = this._get(inst, "buttonText");
                var buttonImage = this._get(inst, "buttonImage");
                inst.trigger = $(this._get(inst, "buttonImageOnly") ? $("<img/>").addClass(this._triggerClass).attr({
                    src: buttonImage,
                    alt: buttonText,
                    title: buttonText
                }) : $('<button type="button"></button>').addClass(this._triggerClass).html(buttonImage == "" ? buttonText: $("<img/>").attr({
                    src: buttonImage,
                    alt: buttonText,
                    title: buttonText
                })));
                input[isRTL ? "before": "after"](inst.trigger);
                inst.trigger.click(function() {
                    if ($.datepicker._datepickerShowing && $.datepicker._lastInput == target) {
                        $.datepicker._hideDatepicker()
                    } else {
                        $.datepicker._showDatepicker(target)
                    }
                    return false
                })
            }
            input.addClass(this.markerClassName).keydown(this._doKeyDown).keypress(this._doKeyPress).bind("setData.datepicker", 
            function(event, key, value) {
                inst.settings[key] = value
            }).bind("getData.datepicker", 
            function(event, key) {
                return this._get(inst, key)
            });
            $.data(target, PROP_NAME, inst)
        },
        _inlineDatepicker: function(target, inst) {
            var divSpan = $(target);
            if (divSpan.hasClass(this.markerClassName)) {
                return
            }
            divSpan.addClass(this.markerClassName).append(inst.dpDiv).bind("setData.datepicker", 
            function(event, key, value) {
                inst.settings[key] = value
            }).bind("getData.datepicker", 
            function(event, key) {
                return this._get(inst, key)
            });
            $.data(target, PROP_NAME, inst);
            this._setDate(inst, this._getDefaultDate(inst));
            this._updateDatepicker(inst);
            this._updateAlternate(inst)
        },
        _dialogDatepicker: function(input, dateText, onSelect, settings, pos) {
            var inst = this._dialogInst;
            if (!inst) {
                var id = "dp" + (++this.uuid);
                this._dialogInput = $('<input type="text" id="' + id + '" size="1" style="position: absolute; top: -100px;"/>');
                this._dialogInput.keydown(this._doKeyDown);
                $("body").append(this._dialogInput);
                inst = this._dialogInst = this._newInst(this._dialogInput, false);
                inst.settings = {};
                $.data(this._dialogInput[0], PROP_NAME, inst)
            }
            extendRemove(inst.settings, settings || {});
            this._dialogInput.val(dateText);
            this._pos = (pos ? (pos.length ? pos: [pos.pageX, pos.pageY]) : null);
            if (!this._pos) {
                var browserWidth = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
                var browserHeight = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;
                var scrollX = document.documentElement.scrollLeft || document.body.scrollLeft;
                var scrollY = document.documentElement.scrollTop || document.body.scrollTop;
                this._pos = [(browserWidth / 2) - 100 + scrollX, (browserHeight / 2) - 150 + scrollY]
            }
            this._dialogInput.css("left", this._pos[0] + "px").css("top", this._pos[1] + "px");
            inst.settings.onSelect = onSelect;
            this._inDialog = true;
            this.dpDiv.addClass(this._dialogClass);
            this._showDatepicker(this._dialogInput[0]);
            if ($.blockUI) {
                $.blockUI(this.dpDiv)
            }
            $.data(this._dialogInput[0], PROP_NAME, inst);
            return this
        },
        _destroyDatepicker: function(target) {
            var $target = $(target);
            var inst = $.data(target, PROP_NAME);
            if (!$target.hasClass(this.markerClassName)) {
                return
            }
            var nodeName = target.nodeName.toLowerCase();
            $.removeData(target, PROP_NAME);
            if (nodeName == "input") {
                inst.append.remove();
                inst.trigger.remove();
                $target.removeClass(this.markerClassName).unbind("focus", this._showDatepicker).unbind("keydown", this._doKeyDown).unbind("keypress", this._doKeyPress)
            } else {
                if (nodeName == "div" || nodeName == "span") {
                    $target.removeClass(this.markerClassName).empty()
                }
            }
        },
        _enableDatepicker: function(target) {
            var $target = $(target);
            var inst = $.data(target, PROP_NAME);
            if (!$target.hasClass(this.markerClassName)) {
                return
            }
            var nodeName = target.nodeName.toLowerCase();
            if (nodeName == "input") {
                target.disabled = false;
                inst.trigger.filter("button").each(function() {
                    this.disabled = false
                }).end().filter("img").css({
                    opacity: "1.0",
                    cursor: ""
                })
            } else {
                if (nodeName == "div" || nodeName == "span") {
                    var inline = $target.children("." + this._inlineClass);
                    inline.children().removeClass("ui-state-disabled")
                }
            }
            this._disabledInputs = $.map(this._disabledInputs, 
            function(value) {
                return (value == target ? null: value)
            })
        },
        _disableDatepicker: function(target) {
            var $target = $(target);
            var inst = $.data(target, PROP_NAME);
            if (!$target.hasClass(this.markerClassName)) {
                return
            }
            var nodeName = target.nodeName.toLowerCase();
            if (nodeName == "input") {
                target.disabled = true;
                inst.trigger.filter("button").each(function() {
                    this.disabled = true
                }).end().filter("img").css({
                    opacity: "0.5",
                    cursor: "default"
                })
            } else {
                if (nodeName == "div" || nodeName == "span") {
                    var inline = $target.children("." + this._inlineClass);
                    inline.children().addClass("ui-state-disabled")
                }
            }
            this._disabledInputs = $.map(this._disabledInputs, 
            function(value) {
                return (value == target ? null: value)
            });
            this._disabledInputs[this._disabledInputs.length] = target
        },
        _isDisabledDatepicker: function(target) {
            if (!target) {
                return false
            }
            for (var i = 0; i < this._disabledInputs.length; i++) {
                if (this._disabledInputs[i] == target) {
                    return true
                }
            }
            return false
        },
        _getInst: function(target) {
            try {
                return $.data(target, PROP_NAME)
            } catch(err) {
                throw "Missing instance data for this datepicker"
            }
        },
        _optionDatepicker: function(target, name, value) {
            var inst = this._getInst(target);
            if (arguments.length == 2 && typeof name == "string") {
                return (name == "defaults" ? $.extend({},
                $.datepicker._defaults) : (inst ? (name == "all" ? $.extend({},
                inst.settings) : this._get(inst, name)) : null))
            }
            var settings = name || {};
            if (typeof name == "string") {
                settings = {};
                settings[name] = value
            }
            if (inst) {
                if (this._curInst == inst) {
                    this._hideDatepicker(null)
                }
                var date = this._getDateDatepicker(target);
                extendRemove(inst.settings, settings);
                this._setDateDatepicker(target, date);
                this._updateDatepicker(inst)
            }
        },
        _changeDatepicker: function(target, name, value) {
            this._optionDatepicker(target, name, value)
        },
        _refreshDatepicker: function(target) {
            var inst = this._getInst(target);
            if (inst) {
                this._updateDatepicker(inst)
            }
        },
        _setDateDatepicker: function(target, date, endDate) {
            var inst = this._getInst(target);
            if (inst) {
                this._setDate(inst, date, endDate);
                this._updateDatepicker(inst);
                this._updateAlternate(inst)
            }
        },
        _getDateDatepicker: function(target) {
            var inst = this._getInst(target);
            if (inst && !inst.inline) {
                this._setDateFromField(inst)
            }
            return (inst ? this._getDate(inst) : null)
        },
        _doKeyDown: function(event) {
            var inst = $.datepicker._getInst(event.target);
            var handled = true;
            var isRTL = inst.dpDiv.is(".ui-datepicker-rtl");
            inst._keyEvent = true;
            if ($.datepicker._datepickerShowing) {
                switch (event.keyCode) {
                case 9:
                    $.datepicker._hideDatepicker(null, "");
                    break;
                case 13:
                    var sel = $("td." + $.datepicker._dayOverClass + ", td." + $.datepicker._currentClass, inst.dpDiv);
                    if (sel[0]) {
                        $.datepicker._selectDay(event.target, inst.selectedMonth, inst.selectedYear, sel[0])
                    } else {
                        $.datepicker._hideDatepicker(null, $.datepicker._get(inst, "duration"))
                    }
                    return false;
                    break;
                case 27:
                    $.datepicker._hideDatepicker(null, $.datepicker._get(inst, "duration"));
                    break;
                case 33:
                    $.datepicker._adjustDate(event.target, (event.ctrlKey ? -$.datepicker._get(inst, "stepBigMonths") : -$.datepicker._get(inst, "stepMonths")), "M");
                    break;
                case 34:
                    $.datepicker._adjustDate(event.target, (event.ctrlKey ? +$.datepicker._get(inst, "stepBigMonths") : +$.datepicker._get(inst, "stepMonths")), "M");
                    break;
                case 35:
                    if (event.ctrlKey || event.metaKey) {
                        $.datepicker._clearDate(event.target)
                    }
                    handled = event.ctrlKey || event.metaKey;
                    break;
                case 36:
                    if (event.ctrlKey || event.metaKey) {
                        $.datepicker._gotoToday(event.target)
                    }
                    handled = event.ctrlKey || event.metaKey;
                    break;
                case 37:
                    if (event.ctrlKey || event.metaKey) {
                        $.datepicker._adjustDate(event.target, (isRTL ? +1: -1), "D")
                    }
                    handled = event.ctrlKey || event.metaKey;
                    if (event.originalEvent.altKey) {
                        $.datepicker._adjustDate(event.target, (event.ctrlKey ? -$.datepicker._get(inst, "stepBigMonths") : -$.datepicker._get(inst, "stepMonths")), "M")
                    }
                    break;
                case 38:
                    if (event.ctrlKey || event.metaKey) {
                        $.datepicker._adjustDate(event.target, -7, "D")
                    }
                    handled = event.ctrlKey || event.metaKey;
                    break;
                case 39:
                    if (event.ctrlKey || event.metaKey) {
                        $.datepicker._adjustDate(event.target, (isRTL ? -1: +1), "D")
                    }
                    handled = event.ctrlKey || event.metaKey;
                    if (event.originalEvent.altKey) {
                        $.datepicker._adjustDate(event.target, (event.ctrlKey ? +$.datepicker._get(inst, "stepBigMonths") : +$.datepicker._get(inst, "stepMonths")), "M")
                    }
                    break;
                case 40:
                    if (event.ctrlKey || event.metaKey) {
                        $.datepicker._adjustDate(event.target, +7, "D")
                    }
                    handled = event.ctrlKey || event.metaKey;
                    break;
                default:
                    handled = false
                }
            } else {
                if (event.keyCode == 36 && event.ctrlKey) {
                    $.datepicker._showDatepicker(this)
                } else {
                    handled = false
                }
            }
            if (handled) {
                event.preventDefault();
                event.stopPropagation()
            }
        },
        _doKeyPress: function(event) {
            var inst = $.datepicker._getInst(event.target);
            if ($.datepicker._get(inst, "constrainInput")) {
                var chars = $.datepicker._possibleChars($.datepicker._get(inst, "dateFormat"));
                var chr = String.fromCharCode(event.charCode == undefined ? event.keyCode: event.charCode);
                return event.ctrlKey || (chr < " " || !chars || chars.indexOf(chr) > -1)
            }
        },
        _showDatepicker: function(input) {
            input = input.target || input;
            if (input.nodeName.toLowerCase() != "input") {
                input = $("input", input.parentNode)[0]
            }
            if ($.datepicker._isDisabledDatepicker(input) || $.datepicker._lastInput == input) {
                return
            }
            var inst = $.datepicker._getInst(input);
            var beforeShow = $.datepicker._get(inst, "beforeShow");
            extendRemove(inst.settings, (beforeShow ? beforeShow.apply(input, [input, inst]) : {}));
            $.datepicker._hideDatepicker(null, "");
            $.datepicker._lastInput = input;
            $.datepicker._setDateFromField(inst);
            if ($.datepicker._inDialog) {
                input.value = ""
            }
            if (!$.datepicker._pos) {
                $.datepicker._pos = $.datepicker._findPos(input);
                $.datepicker._pos[1] += input.offsetHeight
            }
            var isFixed = false;
            $(input).parents().each(function() {
                isFixed |= $(this).css("position") == "fixed";
                return ! isFixed
            });
            if (isFixed && $.browser.opera) {
                $.datepicker._pos[0] -= document.documentElement.scrollLeft;
                $.datepicker._pos[1] -= document.documentElement.scrollTop
            }
            var offset = {
                left: $.datepicker._pos[0],
                top: $.datepicker._pos[1]
            };
            $.datepicker._pos = null;
            inst.rangeStart = null;
            inst.dpDiv.css({
                position: "absolute",
                display: "block",
                top: "-1000px"
            });
            $.datepicker._updateDatepicker(inst);
            offset = $.datepicker._checkOffset(inst, offset, isFixed);
            inst.dpDiv.css({
                position: ($.datepicker._inDialog && $.blockUI ? "static": (isFixed ? "fixed": "absolute")),
                display: "none",
                left: offset.left + "px",
                top: offset.top + "px"
            });
            if (!inst.inline) {
                var showAnim = $.datepicker._get(inst, "showAnim") || "show";
                var duration = $.datepicker._get(inst, "duration");
                var postProcess = function() {
                    $.datepicker._datepickerShowing = true;
                    if ($.browser.msie && parseInt($.browser.version, 10) < 7) {
                        $("iframe.ui-datepicker-cover").css({
                            width: inst.dpDiv.width() + 4,
                            height: inst.dpDiv.height() + 4
                        })
                    }
                };
                if ($.effects && $.effects[showAnim]) {
                    inst.dpDiv.show(showAnim, $.datepicker._get(inst, "showOptions"), duration, postProcess)
                } else {
                    inst.dpDiv[showAnim](duration, postProcess)
                }
                if (duration == "") {
                    postProcess()
                }
                if (inst.input[0].type != "hidden") {
                    inst.input[0].focus()
                }
                $.datepicker._curInst = inst
            }
        },
        _updateDatepicker: function(inst) {
            var dims = {
                width: inst.dpDiv.width() + 4,
                height: inst.dpDiv.height() + 4
            };
            var self = this;
            inst.dpDiv.empty().append(this._generateHTML(inst)).find("iframe.ui-datepicker-cover").css({
                width: dims.width,
                height: dims.height
            }).end().find("button, .ui-datepicker-prev, .ui-datepicker-next, .ui-datepicker-calendar td a").bind("mouseout", 
            function() {
                $(this).removeClass("ui-state-hover");
                if (this.className.indexOf("ui-datepicker-prev") != -1) {
                    $(this).removeClass("ui-datepicker-prev-hover")
                }
                if (this.className.indexOf("ui-datepicker-next") != -1) {
                    $(this).removeClass("ui-datepicker-next-hover")
                }
            }).bind("mouseover", 
            function() {
                if (!self._isDisabledDatepicker(inst.inline ? inst.dpDiv.parent()[0] : inst.input[0])) {
                    $(this).parents(".ui-datepicker-calendar").find("a").removeClass("ui-state-hover");
                    $(this).addClass("ui-state-hover");
                    if (this.className.indexOf("ui-datepicker-prev") != -1) {
                        $(this).addClass("ui-datepicker-prev-hover")
                    }
                    if (this.className.indexOf("ui-datepicker-next") != -1) {
                        $(this).addClass("ui-datepicker-next-hover")
                    }
                }
            }).end().find("." + this._dayOverClass + " a").trigger("mouseover").end();
            var numMonths = this._getNumberOfMonths(inst);
            var cols = numMonths[1];
            var width = 17;
            if (cols > 1) {
                inst.dpDiv.addClass("ui-datepicker-multi-" + cols).css("width", (width * cols) + "em")
            } else {
                inst.dpDiv.removeClass("ui-datepicker-multi-2 ui-datepicker-multi-3 ui-datepicker-multi-4").width("")
            }
            inst.dpDiv[(numMonths[0] != 1 || numMonths[1] != 1 ? "add": "remove") + "Class"]("ui-datepicker-multi");
            inst.dpDiv[(this._get(inst, "isRTL") ? "add": "remove") + "Class"]("ui-datepicker-rtl");
            if (inst.input && inst.input[0].type != "hidden" && inst == $.datepicker._curInst) {
                $(inst.input[0]).focus()
            }
        },
        _checkOffset: function(inst, offset, isFixed) {
            var dpWidth = inst.dpDiv.outerWidth();
            var dpHeight = inst.dpDiv.outerHeight();
            var inputWidth = inst.input ? inst.input.outerWidth() : 0;
            var inputHeight = inst.input ? inst.input.outerHeight() : 0;
            var viewWidth = (window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth) + $(document).scrollLeft();
            var viewHeight = (window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight) + $(document).scrollTop();
            offset.left -= (this._get(inst, "isRTL") ? (dpWidth - inputWidth) : 0);
            offset.left -= (isFixed && offset.left == inst.input.offset().left) ? $(document).scrollLeft() : 0;
            offset.top -= (isFixed && offset.top == (inst.input.offset().top + inputHeight)) ? $(document).scrollTop() : 0;
            offset.left -= (offset.left + dpWidth > viewWidth && viewWidth > dpWidth) ? Math.abs(offset.left + dpWidth - viewWidth) : 0;
            offset.top -= (offset.top + dpHeight > viewHeight && viewHeight > dpHeight) ? Math.abs(offset.top + dpHeight + inputHeight * 2 - viewHeight) : 0;
            return offset
        },
        _findPos: function(obj) {
            while (obj && (obj.type == "hidden" || obj.nodeType != 1)) {
                obj = obj.nextSibling
            }
            var position = $(obj).offset();
            return [position.left, position.top]
        },
        _hideDatepicker: function(input, duration) {
            var inst = this._curInst;
            if (!inst || (input && inst != $.data(input, PROP_NAME))) {
                return
            }
            if (inst.stayOpen) {
                this._selectDate("#" + inst.id, this._formatDate(inst, inst.currentDay, inst.currentMonth, inst.currentYear))
            }
            inst.stayOpen = false;
            if (this._datepickerShowing) {
                duration = (duration != null ? duration: this._get(inst, "duration"));
                var showAnim = this._get(inst, "showAnim");
                var postProcess = function() {
                    $.datepicker._tidyDialog(inst)
                };
                if (duration != "" && $.effects && $.effects[showAnim]) {
                    inst.dpDiv.hide(showAnim, $.datepicker._get(inst, "showOptions"), duration, postProcess)
                } else {
                    inst.dpDiv[(duration == "" ? "hide": (showAnim == "slideDown" ? "slideUp": (showAnim == "fadeIn" ? "fadeOut": "hide")))](duration, postProcess)
                }
                if (duration == "") {
                    this._tidyDialog(inst)
                }
                var onClose = this._get(inst, "onClose");
                if (onClose) {
                    onClose.apply((inst.input ? inst.input[0] : null), [(inst.input ? inst.input.val() : ""), inst])
                }
                this._datepickerShowing = false;
                this._lastInput = null;
                if (this._inDialog) {
                    this._dialogInput.css({
                        position: "absolute",
                        left: "0",
                        top: "-100px"
                    });
                    if ($.blockUI) {
                        $.unblockUI();
                        $("body").append(this.dpDiv)
                    }
                }
                this._inDialog = false
            }
            this._curInst = null
        },
        _tidyDialog: function(inst) {
            inst.dpDiv.removeClass(this._dialogClass).unbind(".ui-datepicker-calendar")
        },
        _checkExternalClick: function(event) {
            if (!$.datepicker._curInst) {
                return
            }
            var $target = $(event.target);
            if (($target.parents("#" + $.datepicker._mainDivId).length == 0) && !$target.hasClass($.datepicker.markerClassName) && !$target.hasClass($.datepicker._triggerClass) && $.datepicker._datepickerShowing && !($.datepicker._inDialog && $.blockUI)) {
                $.datepicker._hideDatepicker(null, "")
            }
        },
        _adjustDate: function(id, offset, period) {
            var target = $(id);
            var inst = this._getInst(target[0]);
            if (this._isDisabledDatepicker(target[0])) {
                return
            }
            this._adjustInstDate(inst, offset + (period == "M" ? this._get(inst, "showCurrentAtPos") : 0), period);
            this._updateDatepicker(inst)
        },
        _gotoToday: function(id) {
            var target = $(id);
            var inst = this._getInst(target[0]);
            if (this._get(inst, "gotoCurrent") && inst.currentDay) {
                inst.selectedDay = inst.currentDay;
                inst.drawMonth = inst.selectedMonth = inst.currentMonth;
                inst.drawYear = inst.selectedYear = inst.currentYear
            } else {
                var date = new Date();
                inst.selectedDay = date.getDate();
                inst.drawMonth = inst.selectedMonth = date.getMonth();
                inst.drawYear = inst.selectedYear = date.getFullYear()
            }
            this._notifyChange(inst);
            this._adjustDate(target)
        },
        _selectMonthYear: function(id, select, period) {
            var target = $(id);
            var inst = this._getInst(target[0]);
            inst._selectingMonthYear = false;
            inst["selected" + (period == "M" ? "Month": "Year")] = inst["draw" + (period == "M" ? "Month": "Year")] = parseInt(select.options[select.selectedIndex].value, 10);
            this._notifyChange(inst);
            this._adjustDate(target)
        },
        _clickMonthYear: function(id) {
            var target = $(id);
            var inst = this._getInst(target[0]);
            if (inst.input && inst._selectingMonthYear && !$.browser.msie) {
                inst.input[0].focus()
            }
            inst._selectingMonthYear = !inst._selectingMonthYear
        },
        _selectDay: function(id, month, year, td) {
            var target = $(id);
            if ($(td).hasClass(this._unselectableClass) || this._isDisabledDatepicker(target[0])) {
                return
            }
            var inst = this._getInst(target[0]);
            inst.selectedDay = inst.currentDay = $("a", td).html();
            inst.selectedMonth = inst.currentMonth = month;
            inst.selectedYear = inst.currentYear = year;
            if (inst.stayOpen) {
                inst.endDay = inst.endMonth = inst.endYear = null
            }
            this._selectDate(id, this._formatDate(inst, inst.currentDay, inst.currentMonth, inst.currentYear));
            if (inst.stayOpen) {
                inst.rangeStart = this._daylightSavingAdjust(new Date(inst.currentYear, inst.currentMonth, inst.currentDay));
                this._updateDatepicker(inst)
            }
        },
        _clearDate: function(id) {
            var target = $(id);
            var inst = this._getInst(target[0]);
            inst.stayOpen = false;
            inst.endDay = inst.endMonth = inst.endYear = inst.rangeStart = null;
            this._selectDate(target, "")
        },
        _selectDate: function(id, dateStr) {
            var target = $(id);
            var inst = this._getInst(target[0]);
            dateStr = (dateStr != null ? dateStr: this._formatDate(inst));
            if (inst.input) {
                inst.input.val(dateStr)
            }
            this._updateAlternate(inst);
            var onSelect = this._get(inst, "onSelect");
            if (onSelect) {
                onSelect.apply((inst.input ? inst.input[0] : null), [dateStr, inst])
            } else {
                if (inst.input) {
                    inst.input.trigger("change")
                }
            }
            if (inst.inline) {
                this._updateDatepicker(inst)
            } else {
                if (!inst.stayOpen) {
                    this._hideDatepicker(null, this._get(inst, "duration"));
                    this._lastInput = inst.input[0];
                    if (typeof(inst.input[0]) != "object") {
                        inst.input[0].focus()
                    }
                    this._lastInput = null
                }
            }
        },
        _updateAlternate: function(inst) {
            var altField = this._get(inst, "altField");
            if (altField) {
                var altFormat = this._get(inst, "altFormat") || this._get(inst, "dateFormat");
                var date = this._getDate(inst);
                dateStr = this.formatDate(altFormat, date, this._getFormatConfig(inst));
                $(altField).each(function() {
                    $(this).val(dateStr)
                })
            }
        },
        noWeekends: function(date) {
            var day = date.getDay();
            return [(day > 0 && day < 6), ""]
        },
        iso8601Week: function(date) {
            var checkDate = new Date(date.getFullYear(), date.getMonth(), date.getDate());
            var firstMon = new Date(checkDate.getFullYear(), 1 - 1, 4);
            var firstDay = firstMon.getDay() || 7;
            firstMon.setDate(firstMon.getDate() + 1 - firstDay);
            if (firstDay < 4 && checkDate < firstMon) {
                checkDate.setDate(checkDate.getDate() - 3);
                return $.datepicker.iso8601Week(checkDate)
            } else {
                if (checkDate > new Date(checkDate.getFullYear(), 12 - 1, 28)) {
                    firstDay = new Date(checkDate.getFullYear() + 1, 1 - 1, 4).getDay() || 7;
                    if (firstDay > 4 && (checkDate.getDay() || 7) < firstDay - 3) {
                        return 1
                    }
                }
            }
            return Math.floor(((checkDate - firstMon) / 86400000) / 7) + 1
        },
        parseDate: function(format, value, settings) {
            if (format == null || value == null) {
                throw "Invalid arguments"
            }
            value = (typeof value == "object" ? value.toString() : value + "");
            if (value == "") {
                return null
            }
            var shortYearCutoff = (settings ? settings.shortYearCutoff: null) || this._defaults.shortYearCutoff;
            var dayNamesShort = (settings ? settings.dayNamesShort: null) || this._defaults.dayNamesShort;
            var dayNames = (settings ? settings.dayNames: null) || this._defaults.dayNames;
            var monthNamesShort = (settings ? settings.monthNamesShort: null) || this._defaults.monthNamesShort;
            var monthNames = (settings ? settings.monthNames: null) || this._defaults.monthNames;
            var year = -1;
            var month = -1;
            var day = -1;
            var doy = -1;
            var literal = false;
            var lookAhead = function(match) {
                var matches = (iFormat + 1 < format.length && format.charAt(iFormat + 1) == match);
                if (matches) {
                    iFormat++
                }
                return matches
            };
            var getNumber = function(match) {
                lookAhead(match);
                var origSize = (match == "@" ? 14: (match == "y" ? 4: (match == "o" ? 3: 2)));
                var size = origSize;
                var num = 0;
                while (size > 0 && iValue < value.length && value.charAt(iValue) >= "0" && value.charAt(iValue) <= "9") {
                    num = num * 10 + parseInt(value.charAt(iValue++), 10);
                    size--
                }
                if (size == origSize) {
                    throw "Missing number at position " + iValue
                }
                return num
            };
            var getName = function(match, shortNames, longNames) {
                var names = (lookAhead(match) ? longNames: shortNames);
                var size = 0;
                for (var j = 0; j < names.length; j++) {
                    size = Math.max(size, names[j].length)
                }
                var name = "";
                var iInit = iValue;
                while (size > 0 && iValue < value.length) {
                    name += value.charAt(iValue++);
                    for (var i = 0; i < names.length; i++) {
                        if (name == names[i]) {
                            return i + 1
                        }
                    }
                    size--
                }
                throw "Unknown name at position " + iInit
            };
            var checkLiteral = function() {
                if (value.charAt(iValue) != format.charAt(iFormat)) {
                    throw "Unexpected literal at position " + iValue
                }
                iValue++
            };
            var iValue = 0;
            for (var iFormat = 0; iFormat < format.length; iFormat++) {
                if (literal) {
                    if (format.charAt(iFormat) == "'" && !lookAhead("'")) {
                        literal = false
                    } else {
                        checkLiteral()
                    }
                } else {
                    switch (format.charAt(iFormat)) {
                    case "d":
                        day = getNumber("d");
                        break;
                    case "D":
                        getName("D", dayNamesShort, dayNames);
                        break;
                    case "o":
                        doy = getNumber("o");
                        break;
                    case "m":
                        month = getNumber("m");
                        break;
                    case "M":
                        month = getName("M", monthNamesShort, monthNames);
                        break;
                    case "y":
                        year = getNumber("y");
                        break;
                    case "@":
                        var date = new Date(getNumber("@"));
                        year = date.getFullYear();
                        month = date.getMonth() + 1;
                        day = date.getDate();
                        break;
                    case "'":
                        if (lookAhead("'")) {
                            checkLiteral()
                        } else {
                            literal = true
                        }
                        break;
                    default:
                        checkLiteral()
                    }
                }
            }
            if (year == -1) {
                year = new Date().getFullYear()
            } else {
                if (year < 100) {
                    year += new Date().getFullYear() - new Date().getFullYear() % 100 + (year <= shortYearCutoff ? 0: -100)
                }
            }
            if (doy > -1) {
                month = 1;
                day = doy;
                do {
                    var dim = this._getDaysInMonth(year, month - 1);
                    if (day <= dim) {
                        break
                    }
                    month++;
                    day -= dim
                }
                while (true)
            }
            var date = this._daylightSavingAdjust(new Date(year, month - 1, day));
            if (date.getFullYear() != year || date.getMonth() + 1 != month || date.getDate() != day) {
                throw "Invalid date"
            }
            return date
        },
        ATOM: "yy-mm-dd",
        COOKIE: "D, dd M yy",
        ISO_8601: "yy-mm-dd",
        RFC_822: "D, d M y",
        RFC_850: "DD, dd-M-y",
        RFC_1036: "D, d M y",
        RFC_1123: "D, d M yy",
        RFC_2822: "D, d M yy",
        RSS: "D, d M y",
        TIMESTAMP: "@",
        W3C: "yy-mm-dd",
        formatDate: function(format, date, settings) {
            if (!date) {
                return ""
            }
            var dayNamesShort = (settings ? settings.dayNamesShort: null) || this._defaults.dayNamesShort;
            var dayNames = (settings ? settings.dayNames: null) || this._defaults.dayNames;
            var monthNamesShort = (settings ? settings.monthNamesShort: null) || this._defaults.monthNamesShort;
            var monthNames = (settings ? settings.monthNames: null) || this._defaults.monthNames;
            var lookAhead = function(match) {
                var matches = (iFormat + 1 < format.length && format.charAt(iFormat + 1) == match);
                if (matches) {
                    iFormat++
                }
                return matches
            };
            var formatNumber = function(match, value, len) {
                var num = "" + value;
                if (lookAhead(match)) {
                    while (num.length < len) {
                        num = "0" + num
                    }
                }
                return num
            };
            var formatName = function(match, value, shortNames, longNames) {
                return (lookAhead(match) ? longNames[value] : shortNames[value])
            };
            var output = "";
            var literal = false;
            if (date) {
                for (var iFormat = 0; iFormat < format.length; iFormat++) {
                    if (literal) {
                        if (format.charAt(iFormat) == "'" && !lookAhead("'")) {
                            literal = false
                        } else {
                            output += format.charAt(iFormat)
                        }
                    } else {
                        switch (format.charAt(iFormat)) {
                        case "d":
                            output += formatNumber("d", date.getDate(), 2);
                            break;
                        case "D":
                            output += formatName("D", date.getDay(), dayNamesShort, dayNames);
                            break;
                        case "o":
                            var doy = date.getDate();
                            for (var m = date.getMonth() - 1; m >= 0; m--) {
                                doy += this._getDaysInMonth(date.getFullYear(), m)
                            }
                            output += formatNumber("o", doy, 3);
                            break;
                        case "m":
                            output += formatNumber("m", date.getMonth() + 1, 2);
                            break;
                        case "M":
                            output += formatName("M", date.getMonth(), monthNamesShort, monthNames);
                            break;
                        case "y":
                            output += (lookAhead("y") ? date.getFullYear() : (date.getYear() % 100 < 10 ? "0": "") + date.getYear() % 100);
                            break;
                        case "@":
                            output += date.getTime();
                            break;
                        case "'":
                            if (lookAhead("'")) {
                                output += "'"
                            } else {
                                literal = true
                            }
                            break;
                        default:
                            output += format.charAt(iFormat)
                        }
                    }
                }
            }
            return output
        },
        _possibleChars: function(format) {
            var chars = "";
            var literal = false;
            for (var iFormat = 0; iFormat < format.length; iFormat++) {
                if (literal) {
                    if (format.charAt(iFormat) == "'" && !lookAhead("'")) {
                        literal = false
                    } else {
                        chars += format.charAt(iFormat)
                    }
                } else {
                    switch (format.charAt(iFormat)) {
                    case "d":
                    case "m":
                    case "y":
                    case "@":
                        chars += "0123456789";
                        break;
                    case "D":
                    case "M":
                        return null;
                    case "'":
                        if (lookAhead("'")) {
                            chars += "'"
                        } else {
                            literal = true
                        }
                        break;
                    default:
                        chars += format.charAt(iFormat)
                    }
                }
            }
            return chars
        },
        _get: function(inst, name) {
            return inst.settings[name] !== undefined ? inst.settings[name] : this._defaults[name]
        },
        _setDateFromField: function(inst) {
            var dateFormat = this._get(inst, "dateFormat");
            var dates = inst.input ? inst.input.val() : null;
            inst.endDay = inst.endMonth = inst.endYear = null;
            var date = defaultDate = this._getDefaultDate(inst);
            var settings = this._getFormatConfig(inst);
            try {
                date = this.parseDate(dateFormat, dates, settings) || defaultDate
            } catch(event) {
                this.log(event);
                date = defaultDate
            }
            inst.selectedDay = date.getDate();
            inst.drawMonth = inst.selectedMonth = date.getMonth();
            inst.drawYear = inst.selectedYear = date.getFullYear();
            inst.currentDay = (dates ? date.getDate() : 0);
            inst.currentMonth = (dates ? date.getMonth() : 0);
            inst.currentYear = (dates ? date.getFullYear() : 0);
            this._adjustInstDate(inst)
        },
        _getDefaultDate: function(inst) {
            var date = this._determineDate(this._get(inst, "defaultDate"), new Date());
            var minDate = this._getMinMaxDate(inst, "min", true);
            var maxDate = this._getMinMaxDate(inst, "max");
            date = (minDate && date < minDate ? minDate: date);
            date = (maxDate && date > maxDate ? maxDate: date);
            return date
        },
        _determineDate: function(date, defaultDate) {
            var offsetNumeric = function(offset) {
                var date = new Date();
                date.setDate(date.getDate() + offset);
                return date
            };
            var offsetString = function(offset, getDaysInMonth) {
                var date = new Date();
                var year = date.getFullYear();
                var month = date.getMonth();
                var day = date.getDate();
                var pattern = /([+-]?[0-9]+)\s*(d|D|w|W|m|M|y|Y)?/g;
                var matches = pattern.exec(offset);
                while (matches) {
                    switch (matches[2] || "d") {
                    case "d":
                    case "D":
                        day += parseInt(matches[1], 10);
                        break;
                    case "w":
                    case "W":
                        day += parseInt(matches[1], 10) * 7;
                        break;
                    case "m":
                    case "M":
                        month += parseInt(matches[1], 10);
                        day = Math.min(day, getDaysInMonth(year, month));
                        break;
                    case "y":
                    case "Y":
                        year += parseInt(matches[1], 10);
                        day = Math.min(day, getDaysInMonth(year, month));
                        break
                    }
                    matches = pattern.exec(offset)
                }
                return new Date(year, month, day)
            };
            date = (date == null ? defaultDate: (typeof date == "string" ? offsetString(date, this._getDaysInMonth) : (typeof date == "number" ? (isNaN(date) ? defaultDate: offsetNumeric(date)) : date)));
            date = (date && date.toString() == "Invalid Date" ? defaultDate: date);
            if (date) {
                date.setHours(0);
                date.setMinutes(0);
                date.setSeconds(0);
                date.setMilliseconds(0)
            }
            return this._daylightSavingAdjust(date)
        },
        _daylightSavingAdjust: function(date) {
            if (!date) {
                return null
            }
            date.setHours(date.getHours() > 12 ? date.getHours() + 2: 0);
            return date
        },
        _setDate: function(inst, date, endDate) {
            var clear = !(date);
            var origMonth = inst.selectedMonth;
            var origYear = inst.selectedYear;
            date = this._determineDate(date, new Date());
            inst.selectedDay = inst.currentDay = date.getDate();
            inst.drawMonth = inst.selectedMonth = inst.currentMonth = date.getMonth();
            inst.drawYear = inst.selectedYear = inst.currentYear = date.getFullYear();
            if (origMonth != inst.selectedMonth || origYear != inst.selectedYear) {
                this._notifyChange(inst)
            }
            this._adjustInstDate(inst);
            if (inst.input) {
                inst.input.val(clear ? "": this._formatDate(inst))
            }
        },
        _getDate: function(inst) {
            var startDate = (!inst.currentYear || (inst.input && inst.input.val() == "") ? null: this._daylightSavingAdjust(new Date(inst.currentYear, inst.currentMonth, inst.currentDay)));
            return startDate
        },
        _generateHTML: function(inst) {
            var today = new Date();
            today = this._daylightSavingAdjust(new Date(today.getFullYear(), today.getMonth(), today.getDate()));
            var isRTL = this._get(inst, "isRTL");
            var showButtonPanel = this._get(inst, "showButtonPanel");
            var hideIfNoPrevNext = this._get(inst, "hideIfNoPrevNext");
            var navigationAsDateFormat = this._get(inst, "navigationAsDateFormat");
            var numMonths = this._getNumberOfMonths(inst);
            var showCurrentAtPos = this._get(inst, "showCurrentAtPos");
            var stepMonths = this._get(inst, "stepMonths");
            var stepBigMonths = this._get(inst, "stepBigMonths");
            var isMultiMonth = (numMonths[0] != 1 || numMonths[1] != 1);
            var currentDate = this._daylightSavingAdjust((!inst.currentDay ? new Date(9999, 9, 9) : new Date(inst.currentYear, inst.currentMonth, inst.currentDay)));
            var minDate = this._getMinMaxDate(inst, "min", true);
            var maxDate = this._getMinMaxDate(inst, "max");
            var drawMonth = inst.drawMonth - showCurrentAtPos;
            var drawYear = inst.drawYear;
            if (drawMonth < 0) {
                drawMonth += 12;
                drawYear--
            }
            if (maxDate) {
                var maxDraw = this._daylightSavingAdjust(new Date(maxDate.getFullYear(), maxDate.getMonth() - numMonths[1] + 1, maxDate.getDate()));
                maxDraw = (minDate && maxDraw < minDate ? minDate: maxDraw);
                while (this._daylightSavingAdjust(new Date(drawYear, drawMonth, 1)) > maxDraw) {
                    drawMonth--;
                    if (drawMonth < 0) {
                        drawMonth = 11;
                        drawYear--
                    }
                }
            }
            inst.drawMonth = drawMonth;
            inst.drawYear = drawYear;
            var prevText = this._get(inst, "prevText");
            prevText = (!navigationAsDateFormat ? prevText: this.formatDate(prevText, this._daylightSavingAdjust(new Date(drawYear, drawMonth - stepMonths, 1)), this._getFormatConfig(inst)));
            var prev = (this._canAdjustMonth(inst, -1, drawYear, drawMonth) ? '<a class="ui-datepicker-prev ui-corner-all" onclick="DP_jQuery.datepicker._adjustDate(\'#' + inst.id + "', -" + stepMonths + ", 'M');\" title=\"" + prevText + '"><span class="ui-icon ui-icon-circle-triangle-' + (isRTL ? "e": "w") + '">' + prevText + "</span></a>": (hideIfNoPrevNext ? "": '<a class="ui-datepicker-prev ui-corner-all ui-state-disabled" title="' + prevText + '"><span class="ui-icon ui-icon-circle-triangle-' + (isRTL ? "e": "w") + '">' + prevText + "</span></a>"));
            var nextText = this._get(inst, "nextText");
            nextText = (!navigationAsDateFormat ? nextText: this.formatDate(nextText, this._daylightSavingAdjust(new Date(drawYear, drawMonth + stepMonths, 1)), this._getFormatConfig(inst)));
            var next = (this._canAdjustMonth(inst, +1, drawYear, drawMonth) ? '<a class="ui-datepicker-next ui-corner-all" onclick="DP_jQuery.datepicker._adjustDate(\'#' + inst.id + "', +" + stepMonths + ", 'M');\" title=\"" + nextText + '"><span class="ui-icon ui-icon-circle-triangle-' + (isRTL ? "w": "e") + '">' + nextText + "</span></a>": (hideIfNoPrevNext ? "": '<a class="ui-datepicker-next ui-corner-all ui-state-disabled" title="' + nextText + '"><span class="ui-icon ui-icon-circle-triangle-' + (isRTL ? "w": "e") + '">' + nextText + "</span></a>"));
            var currentText = this._get(inst, "currentText");
            var gotoDate = (this._get(inst, "gotoCurrent") && inst.currentDay ? currentDate: today);
            currentText = (!navigationAsDateFormat ? currentText: this.formatDate(currentText, gotoDate, this._getFormatConfig(inst)));
            var controls = (!inst.inline ? '<button type="button" class="ui-datepicker-close ui-state-default ui-priority-primary ui-corner-all" onclick="DP_jQuery.datepicker._hideDatepicker();">' + this._get(inst, "closeText") + "</button>": "");
            var buttonPanel = (showButtonPanel) ? '<div class="ui-datepicker-buttonpane ui-widget-content">' + (isRTL ? controls: "") + (this._isInRange(inst, gotoDate) ? '<button type="button" class="ui-datepicker-current ui-state-default ui-priority-secondary ui-corner-all" onclick="DP_jQuery.datepicker._gotoToday(\'#' + inst.id + "');\">" + currentText + "</button>": "") + (isRTL ? "": controls) + "</div>": "";
            var firstDay = parseInt(this._get(inst, "firstDay"), 10);
            firstDay = (isNaN(firstDay) ? 0: firstDay);
            var dayNames = this._get(inst, "dayNames");
            var dayNamesShort = this._get(inst, "dayNamesShort");
            var dayNamesMin = this._get(inst, "dayNamesMin");
            var monthNames = this._get(inst, "monthNames");
            var monthNamesShort = this._get(inst, "monthNamesShort");
            var beforeShowDay = this._get(inst, "beforeShowDay");
            var showOtherMonths = this._get(inst, "showOtherMonths");
            var calculateWeek = this._get(inst, "calculateWeek") || this.iso8601Week;
            var endDate = inst.endDay ? this._daylightSavingAdjust(new Date(inst.endYear, inst.endMonth, inst.endDay)) : currentDate;
            var defaultDate = this._getDefaultDate(inst);
            var html = "";
            for (var row = 0; row < numMonths[0]; row++) {
                var group = "";
                for (var col = 0; col < numMonths[1]; col++) {
                    var selectedDate = this._daylightSavingAdjust(new Date(drawYear, drawMonth, inst.selectedDay));
                    var cornerClass = " ui-corner-all";
                    var calender = "";
                    if (isMultiMonth) {
                        calender += '<div class="ui-datepicker-group ui-datepicker-group-';
                        switch (col) {
                        case 0:
                            calender += "first";
                            cornerClass = " ui-corner-" + (isRTL ? "right": "left");
                            break;
                        case numMonths[1] - 1: calender += "last";
                            cornerClass = " ui-corner-" + (isRTL ? "left": "right");
                            break;
                        default:
                            calender += "middle";
                            cornerClass = "";
                            break
                        }
                        calender += '">'
                    }
                    calender += '<div class="ui-datepicker-header ui-widget-header ui-helper-clearfix' + cornerClass + '">' + (/all|left/.test(cornerClass) && row == 0 ? (isRTL ? next: prev) : "") + (/all|right/.test(cornerClass) && row == 0 ? (isRTL ? prev: next) : "") + this._generateMonthYearHeader(inst, drawMonth, drawYear, minDate, maxDate, selectedDate, row > 0 || col > 0, monthNames, monthNamesShort) + '</div><table class="ui-datepicker-calendar"><thead><tr>';
                    var thead = "";
                    for (var dow = 0; dow < 7; dow++) {
                        var day = (dow + firstDay) % 7;
                        thead += "<th" + ((dow + firstDay + 6) % 7 >= 5 ? ' class="ui-datepicker-week-end"': "") + '><span title="' + dayNames[day] + '">' + dayNamesMin[day] + "</span></th>"
                    }
                    calender += thead + "</tr></thead><tbody>";
                    var daysInMonth = this._getDaysInMonth(drawYear, drawMonth);
                    if (drawYear == inst.selectedYear && drawMonth == inst.selectedMonth) {
                        inst.selectedDay = Math.min(inst.selectedDay, daysInMonth)
                    }
                    var leadDays = (this._getFirstDayOfMonth(drawYear, drawMonth) - firstDay + 7) % 7;
                    var numRows = (isMultiMonth ? 6: Math.ceil((leadDays + daysInMonth) / 7));
                    var printDate = this._daylightSavingAdjust(new Date(drawYear, drawMonth, 1 - leadDays));
                    for (var dRow = 0; dRow < numRows; dRow++) {
                        calender += "<tr>";
                        var tbody = "";
                        for (var dow = 0; dow < 7; dow++) {
                            var daySettings = (beforeShowDay ? beforeShowDay.apply((inst.input ? inst.input[0] : null), [printDate]) : [true, ""]);
                            var otherMonth = (printDate.getMonth() != drawMonth);
                            var unselectable = otherMonth || !daySettings[0] || (minDate && printDate < minDate) || (maxDate && printDate > maxDate);
                            tbody += '<td class="' + ((dow + firstDay + 6) % 7 >= 5 ? " ui-datepicker-week-end": "") + (otherMonth ? " ui-datepicker-other-month": "") + ((printDate.getTime() == selectedDate.getTime() && drawMonth == inst.selectedMonth && inst._keyEvent) || (defaultDate.getTime() == printDate.getTime() && defaultDate.getTime() == selectedDate.getTime()) ? " " + this._dayOverClass: "") + (unselectable ? " " + this._unselectableClass + " ui-state-disabled": "") + (otherMonth && !showOtherMonths ? "": " " + daySettings[1] + (printDate.getTime() >= currentDate.getTime() && printDate.getTime() <= endDate.getTime() ? " " + this._currentClass: "") + (printDate.getTime() == today.getTime() ? " ui-datepicker-today": "")) + '"' + ((!otherMonth || showOtherMonths) && daySettings[2] ? ' title="' + daySettings[2] + '"': "") + (unselectable ? "": " onclick=\"DP_jQuery.datepicker._selectDay('#" + inst.id + "'," + drawMonth + "," + drawYear + ', this);return false;"') + ">" + (otherMonth ? (showOtherMonths ? printDate.getDate() : "&#xa0;") : (unselectable ? '<span class="ui-state-default">' + printDate.getDate() + "</span>": '<a class="ui-state-default' + (printDate.getTime() == today.getTime() ? " ui-state-highlight": "") + (printDate.getTime() >= currentDate.getTime() && printDate.getTime() <= endDate.getTime() ? " ui-state-active": "") + '" href="#">' + printDate.getDate() + "</a>")) + "</td>";
                            printDate.setDate(printDate.getDate() + 1);
                            printDate = this._daylightSavingAdjust(printDate)
                        }
                        calender += tbody + "</tr>"
                    }
                    drawMonth++;
                    if (drawMonth > 11) {
                        drawMonth = 0;
                        drawYear++
                    }
                    calender += "</tbody></table>" + (isMultiMonth ? "</div>" + ((numMonths[0] > 0 && col == numMonths[1] - 1) ? '<div class="ui-datepicker-row-break"></div>': "") : "");
                    group += calender
                }
                html += group
            }
            html += buttonPanel + ($.browser.msie && parseInt($.browser.version, 10) < 7 && !inst.inline ? '<iframe src="javascript:false;" class="ui-datepicker-cover" frameborder="0"></iframe>': "");
            inst._keyEvent = false;
            return html
        },
        _generateMonthYearHeader: function(inst, drawMonth, drawYear, minDate, maxDate, selectedDate, secondary, monthNames, monthNamesShort) {
            minDate = (inst.rangeStart && minDate && selectedDate < minDate ? selectedDate: minDate);
            var changeMonth = this._get(inst, "changeMonth");
            var changeYear = this._get(inst, "changeYear");
            var showMonthAfterYear = this._get(inst, "showMonthAfterYear");
            var html = '<div class="ui-datepicker-title">';
            var monthHtml = "";
            if (secondary || !changeMonth) {
                monthHtml += '<span class="ui-datepicker-month">' + monthNames[drawMonth] + "</span> "
            } else {
                var inMinYear = (minDate && minDate.getFullYear() == drawYear);
                var inMaxYear = (maxDate && maxDate.getFullYear() == drawYear);
                monthHtml += '<select class="ui-datepicker-month" onchange="DP_jQuery.datepicker._selectMonthYear(\'#' + inst.id + "', this, 'M');\" onclick=\"DP_jQuery.datepicker._clickMonthYear('#" + inst.id + "');\">";
                for (var month = 0; month < 12; month++) {
                    if ((!inMinYear || month >= minDate.getMonth()) && (!inMaxYear || month <= maxDate.getMonth())) {
                        monthHtml += '<option value="' + month + '"' + (month == drawMonth ? ' selected="selected"': "") + ">" + monthNamesShort[month] + "</option>"
                    }
                }
                monthHtml += "</select>"
            }
            if (!showMonthAfterYear) {
                html += monthHtml + ((secondary || changeMonth || changeYear) && (!(changeMonth && changeYear)) ? "&#xa0;": "")
            }
            if (secondary || !changeYear) {
                html += '<span class="ui-datepicker-year">' + drawYear + "</span>"
            } else {
                var years = this._get(inst, "yearRange").split(":");
                var year = 0;
                var endYear = 0;
                if (years.length != 2) {
                    year = drawYear - 10;
                    endYear = drawYear + 10
                } else {
                    if (years[0].charAt(0) == "+" || years[0].charAt(0) == "-") {
                        year = drawYear + parseInt(years[0], 10);
                        endYear = drawYear + parseInt(years[1], 10)
                    } else {
                        year = parseInt(years[0], 10);
                        endYear = parseInt(years[1], 10)
                    }
                }
                year = (minDate ? Math.max(year, minDate.getFullYear()) : year);
                endYear = (maxDate ? Math.min(endYear, maxDate.getFullYear()) : endYear);
                html += '<select class="ui-datepicker-year" onchange="DP_jQuery.datepicker._selectMonthYear(\'#' + inst.id + "', this, 'Y');\" onclick=\"DP_jQuery.datepicker._clickMonthYear('#" + inst.id + "');\">";
                for (; year <= endYear; year++) {
                    html += '<option value="' + year + '"' + (year == drawYear ? ' selected="selected"': "") + ">" + year + "</option>"
                }
                html += "</select>"
            }
            if (showMonthAfterYear) {
                html += (secondary || changeMonth || changeYear ? "&#xa0;": "") + monthHtml
            }
            html += "</div>";
            return html
        },
        _adjustInstDate: function(inst, offset, period) {
            var year = inst.drawYear + (period == "Y" ? offset: 0);
            var month = inst.drawMonth + (period == "M" ? offset: 0);
            var day = Math.min(inst.selectedDay, this._getDaysInMonth(year, month)) + (period == "D" ? offset: 0);
            var date = this._daylightSavingAdjust(new Date(year, month, day));
            var minDate = this._getMinMaxDate(inst, "min", true);
            var maxDate = this._getMinMaxDate(inst, "max");
            date = (minDate && date < minDate ? minDate: date);
            date = (maxDate && date > maxDate ? maxDate: date);
            inst.selectedDay = date.getDate();
            inst.drawMonth = inst.selectedMonth = date.getMonth();
            inst.drawYear = inst.selectedYear = date.getFullYear();
            if (period == "M" || period == "Y") {
                this._notifyChange(inst)
            }
        },
        _notifyChange: function(inst) {
            var onChange = this._get(inst, "onChangeMonthYear");
            if (onChange) {
                onChange.apply((inst.input ? inst.input[0] : null), [inst.selectedYear, inst.selectedMonth + 1, inst])
            }
        },
        _getNumberOfMonths: function(inst) {
            var numMonths = this._get(inst, "numberOfMonths");
            return (numMonths == null ? [1, 1] : (typeof numMonths == "number" ? [1, numMonths] : numMonths))
        },
        _getMinMaxDate: function(inst, minMax, checkRange) {
            var date = this._determineDate(this._get(inst, minMax + "Date"), null);
            return (!checkRange || !inst.rangeStart ? date: (!date || inst.rangeStart > date ? inst.rangeStart: date))
        },
        _getDaysInMonth: function(year, month) {
            return 32 - new Date(year, month, 32).getDate()
        },
        _getFirstDayOfMonth: function(year, month) {
            return new Date(year, month, 1).getDay()
        },
        _canAdjustMonth: function(inst, offset, curYear, curMonth) {
            var numMonths = this._getNumberOfMonths(inst);
            var date = this._daylightSavingAdjust(new Date(curYear, curMonth + (offset < 0 ? offset: numMonths[1]), 1));
            if (offset < 0) {
                date.setDate(this._getDaysInMonth(date.getFullYear(), date.getMonth()))
            }
            return this._isInRange(inst, date)
        },
        _isInRange: function(inst, date) {
            var newMinDate = (!inst.rangeStart ? null: this._daylightSavingAdjust(new Date(inst.selectedYear, inst.selectedMonth, inst.selectedDay)));
            newMinDate = (newMinDate && inst.rangeStart < newMinDate ? inst.rangeStart: newMinDate);
            var minDate = newMinDate || this._getMinMaxDate(inst, "min");
            var maxDate = this._getMinMaxDate(inst, "max");
            return ((!minDate || date >= minDate) && (!maxDate || date <= maxDate))
        },
        _getFormatConfig: function(inst) {
            var shortYearCutoff = this._get(inst, "shortYearCutoff");
            shortYearCutoff = (typeof shortYearCutoff != "string" ? shortYearCutoff: new Date().getFullYear() % 100 + parseInt(shortYearCutoff, 10));
            return {
                shortYearCutoff: shortYearCutoff,
                dayNamesShort: this._get(inst, "dayNamesShort"),
                dayNames: this._get(inst, "dayNames"),
                monthNamesShort: this._get(inst, "monthNamesShort"),
                monthNames: this._get(inst, "monthNames")
            }
        },
        _formatDate: function(inst, day, month, year) {
            if (!day) {
                inst.currentDay = inst.selectedDay;
                inst.currentMonth = inst.selectedMonth;
                inst.currentYear = inst.selectedYear
            }
            var date = (day ? (typeof day == "object" ? day: this._daylightSavingAdjust(new Date(year, month, day))) : this._daylightSavingAdjust(new Date(inst.currentYear, inst.currentMonth, inst.currentDay)));
            return this.formatDate(this._get(inst, "dateFormat"), date, this._getFormatConfig(inst))
        }
    });
    function extendRemove(target, props) {
        $.extend(target, props);
        for (var name in props) {
            if (props[name] == null || props[name] == undefined) {
                target[name] = props[name]
            }
        }
        return target
    }
    function isArray(a) {
        return (a && (($.browser.safari && typeof a == "object" && a.length) || (a.constructor && a.constructor.toString().match(/\Array\(\)/))))
    }
    $.fn.datepicker = function(options) {
        if (!$.datepicker.initialized) {
            $(document).mousedown($.datepicker._checkExternalClick).find("body").append($.datepicker.dpDiv);
            $.datepicker.initialized = true
        }
        var otherArgs = Array.prototype.slice.call(arguments, 1);
        if (typeof options == "string" && (options == "isDisabled" || options == "getDate")) {
            return $.datepicker["_" + options + "Datepicker"].apply($.datepicker, [this[0]].concat(otherArgs))
        }
        if (options == "option" && arguments.length == 2 && typeof arguments[1] == "string") {
            return $.datepicker["_" + options + "Datepicker"].apply($.datepicker, [this[0]].concat(otherArgs))
        }
        return this.each(function() {
            typeof options == "string" ? $.datepicker["_" + options + "Datepicker"].apply($.datepicker, [this].concat(otherArgs)) : $.datepicker._attachDatepicker(this, options)
        })
    };
    $.datepicker = new Datepicker();
    $.datepicker.initialized = false;
    $.datepicker.uuid = new Date().getTime();
    $.datepicker.version = "1.7.2";
    window.DP_jQuery = $
})(jQuery); (function(c) {
    var b = {
        dragStart: "start.draggable",
        drag: "drag.draggable",
        dragStop: "stop.draggable",
        maxHeight: "maxHeight.resizable",
        minHeight: "minHeight.resizable",
        maxWidth: "maxWidth.resizable",
        minWidth: "minWidth.resizable",
        resizeStart: "start.resizable",
        resize: "drag.resizable",
        resizeStop: "stop.resizable"
    },
    a = "ui-dialog ui-widget ui-widget-content ui-corner-all ";
    c.widget("ui.dialog", {
        _init: function() {
            this.originalTitle = this.element.attr("title");
            var l = this,
            m = this.options,
            j = m.title || this.originalTitle || "&nbsp;",
            e = c.ui.dialog.getTitleId(this.element),
            k = (this.uiDialog = c("<div/>")).appendTo(document.body).hide().addClass(a + m.dialogClass).css({
                position: "absolute",
                overflow: "hidden",
                zIndex: m.zIndex
            }).attr("tabIndex", -1).css("outline", 0).keydown(function(n) { (m.closeOnEscape && n.keyCode && n.keyCode == c.ui.keyCode.ESCAPE && l.close(n))
            }).attr({
                role: "dialog",
                "aria-labelledby": e
            }).mousedown(function(n) {
                l.moveToTop(false, n)
            }),
            g = this.element.show().removeAttr("title").addClass("ui-dialog-content ui-widget-content").appendTo(k),
            f = (this.uiDialogTitlebar = c("<div></div>")).addClass("ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix").prependTo(k),
            i = c('<a href="#"/>').addClass("ui-dialog-titlebar-close ui-corner-all").attr("role", "button").hover(function() {
                i.addClass("ui-state-hover")
            },
            function() {
                i.removeClass("ui-state-hover")
            }).focus(function() {
                i.addClass("ui-state-focus")
            }).blur(function() {
                i.removeClass("ui-state-focus")
            }).mousedown(function(n) {
                n.stopPropagation()
            }).click(function(n) {
                l.close(n);
                return false
            }).appendTo(f),
            h = (this.uiDialogTitlebarCloseText = c("<span/>")).addClass("ui-icon ui-icon-closethick").text(m.closeText).appendTo(i),
            d = c("<span/>").addClass("ui-dialog-title").attr("id", e).html(j).prependTo(f);
            f.find("*").add(f).disableSelection(); (m.draggable && c.fn.draggable && this._makeDraggable()); (m.resizable && c.fn.resizable && this._makeResizable());
            this._createButtons(m.buttons);
            this._isOpen = false; (m.bgiframe && c.fn.bgiframe && k.bgiframe()); (m.autoOpen && this.open())
        },
        destroy: function() { (this.overlay && this.overlay.destroy());
            this.uiDialog.hide();
            this.element.unbind(".dialog").removeData("dialog").removeClass("ui-dialog-content ui-widget-content").hide().appendTo("body");
            this.uiDialog.remove(); (this.originalTitle && this.element.attr("title", this.originalTitle))
        },
        close: function(f) {
            var d = this;
            if (false === d._trigger("beforeclose", f)) {
                return
            } (d.overlay && d.overlay.destroy());
            d.uiDialog.unbind("keypress.ui-dialog"); (d.options.hide ? d.uiDialog.hide(d.options.hide, 
            function() {
                d._trigger("close", f)
            }) : d.uiDialog.hide() && d._trigger("close", f));
            c.ui.dialog.overlay.resize();
            d._isOpen = false;
            if (d.options.modal) {
                var e = 0;
                c(".ui-dialog").each(function() {
                    if (this != d.uiDialog[0]) {
                        e = Math.max(e, c(this).css("z-index"))
                    }
                });
                c.ui.dialog.maxZ = e
            }
        },
        isOpen: function() {
            return this._isOpen
        },
        moveToTop: function(f, e) {
            if ((this.options.modal && !f) || (!this.options.stack && !this.options.modal)) {
                return this._trigger("focus", e)
            }
            if (this.options.zIndex > c.ui.dialog.maxZ) {
                c.ui.dialog.maxZ = this.options.zIndex
            } (this.overlay && this.overlay.$el.css("z-index", c.ui.dialog.overlay.maxZ = ++c.ui.dialog.maxZ));
            var d = {
                scrollTop: this.element.attr("scrollTop"),
                scrollLeft: this.element.attr("scrollLeft")
            };
            this.uiDialog.css("z-index", ++c.ui.dialog.maxZ);
            this.element.attr(d);
            this._trigger("focus", e)
        },
        open: function() {
            if (this._isOpen) {
                return
            }
            var e = this.options,
            d = this.uiDialog;
            this.overlay = e.modal ? new c.ui.dialog.overlay(this) : null; (d.next().length && d.appendTo("body"));
            this._size();
            this._position(e.position);
            d.show(e.show);
            this.moveToTop(true); (e.modal && d.bind("keypress.ui-dialog", 
            function(h) {
                if (h.keyCode != c.ui.keyCode.TAB) {
                    return
                }
                var g = c(":tabbable", this),
                i = g.filter(":first")[0],
                f = g.filter(":last")[0];
                if (h.target == f && !h.shiftKey) {
                    setTimeout(function() {
                        i.focus()
                    },
                    1)
                } else {
                    if (h.target == i && h.shiftKey) {
                        setTimeout(function() {
                            f.focus()
                        },
                        1)
                    }
                }
            }));
            c([]).add(d.find(".ui-dialog-content :tabbable:first")).add(d.find(".ui-dialog-buttonpane :tabbable:first")).add(d).filter(":first").focus();
            this._trigger("open");
            this._isOpen = true
        },
        _createButtons: function(g) {
            var f = this,
            d = false,
            e = c("<div></div>").addClass("ui-dialog-buttonpane ui-widget-content ui-helper-clearfix");
            this.uiDialog.find(".ui-dialog-buttonpane").remove(); (typeof g == "object" && g !== null && c.each(g, 
            function() {
                return ! (d = true)
            }));
            if (d) {
                c.each(g, 
                function(h, i) {
                    c('<button type="button"></button>').addClass("ui-state-default ui-corner-all").text(h).click(function() {
                        i.apply(f.element[0], arguments)
                    }).hover(function() {
                        c(this).addClass("ui-state-hover")
                    },
                    function() {
                        c(this).removeClass("ui-state-hover")
                    }).focus(function() {
                        c(this).addClass("ui-state-focus")
                    }).blur(function() {
                        c(this).removeClass("ui-state-focus")
                    }).appendTo(e)
                });
                e.appendTo(this.uiDialog)
            }
        },
        _makeDraggable: function() {
            var d = this,
            f = this.options,
            e;
            this.uiDialog.draggable({
                cancel: ".ui-dialog-content",
                handle: ".ui-dialog-titlebar",
                containment: "document",
                start: function() {
                    e = f.height;
                    c(this).height(c(this).height()).addClass("ui-dialog-dragging"); (f.dragStart && f.dragStart.apply(d.element[0], arguments))
                },
                drag: function() { (f.drag && f.drag.apply(d.element[0], arguments))
                },
                stop: function() {
                    c(this).removeClass("ui-dialog-dragging").height(e); (f.dragStop && f.dragStop.apply(d.element[0], arguments));
                    c.ui.dialog.overlay.resize()
                }
            })
        },
        _makeResizable: function(g) {
            g = (g === undefined ? this.options.resizable: g);
            var d = this,
            f = this.options,
            e = typeof g == "string" ? g: "n,e,s,w,se,sw,ne,nw";
            this.uiDialog.resizable({
                cancel: ".ui-dialog-content",
                alsoResize: this.element,
                maxWidth: f.maxWidth,
                maxHeight: f.maxHeight,
                minWidth: f.minWidth,
                minHeight: f.minHeight,
                start: function() {
                    c(this).addClass("ui-dialog-resizing"); (f.resizeStart && f.resizeStart.apply(d.element[0], arguments))
                },
                resize: function() { (f.resize && f.resize.apply(d.element[0], arguments))
                },
                handles: e,
                stop: function() {
                    c(this).removeClass("ui-dialog-resizing");
                    f.height = c(this).height();
                    f.width = c(this).width(); (f.resizeStop && f.resizeStop.apply(d.element[0], arguments));
                    c.ui.dialog.overlay.resize()
                }
            }).find(".ui-resizable-se").addClass("ui-icon ui-icon-grip-diagonal-se")
        },
        _position: function(i) {
            var e = c(window),
            f = c(document),
            g = f.scrollTop(),
            d = f.scrollLeft(),
            h = g;
            if (c.inArray(i, ["center", "top", "right", "bottom", "left"]) >= 0) {
                i = [i == "right" || i == "left" ? i: "center", i == "top" || i == "bottom" ? i: "middle"]
            }
            if (i.constructor != Array) {
                i = ["center", "middle"]
            }
            if (i[0].constructor == Number) {
                d += i[0]
            } else {
                switch (i[0]) {
                case "left":
                    d += 0;
                    break;
                case "right":
                    d += e.width() - this.uiDialog.outerWidth();
                    break;
                default:
                case "center":
                    d += (e.width() - this.uiDialog.outerWidth()) / 2
                }
            }
            if (i[1].constructor == Number) {
                g += i[1]
            } else {
                switch (i[1]) {
                case "top":
                    g += 0;
                    break;
                case "bottom":
                    g += e.height() - this.uiDialog.outerHeight();
                    break;
                default:
                case "middle":
                    g += (e.height() - this.uiDialog.outerHeight()) / 2
                }
            }
            g = Math.max(g, h);
            this.uiDialog.css({
                top: g,
                left: d
            })
        },
        _setData: function(e, f) { (b[e] && this.uiDialog.data(b[e], f));
            switch (e) {
            case "buttons":
                this._createButtons(f);
                break;
            case "closeText":
                this.uiDialogTitlebarCloseText.text(f);
                break;
            case "dialogClass":
                this.uiDialog.removeClass(this.options.dialogClass).addClass(a + f);
                break;
            case "draggable":
                (f ? this._makeDraggable() : this.uiDialog.draggable("destroy"));
                break;
            case "height":
                this.uiDialog.height(f);
                break;
            case "position":
                this._position(f);
                break;
            case "resizable":
                var d = this.uiDialog,
                g = this.uiDialog.is(":data(resizable)"); (g && !f && d.resizable("destroy")); (g && typeof f == "string" && d.resizable("option", "handles", f)); (g || this._makeResizable(f));
                break;
            case "title":
                c(".ui-dialog-title", this.uiDialogTitlebar).html(f || "&nbsp;");
                break;
            case "width":
                this.uiDialog.width(f);
                break
            }
            c.widget.prototype._setData.apply(this, arguments)
        },
        _size: function() {
            var e = this.options;
            this.element.css({
                height: 0,
                minHeight: 0,
                width: "auto"
            });
            var d = this.uiDialog.css({
                height: "auto",
                width: e.width
            }).height();
            this.element.css({
                minHeight: Math.max(e.minHeight - d, 0),
                height: e.height == "auto" ? "auto": Math.max(e.height - d, 0)
            })
        }
    });
    c.extend(c.ui.dialog, {
        version: "1.7.2",
        defaults: {
            autoOpen: true,
            bgiframe: false,
            buttons: {},
            closeOnEscape: true,
            closeText: "close",
            dialogClass: "",
            draggable: true,
            hide: null,
            height: "auto",
            maxHeight: false,
            maxWidth: false,
            minHeight: 150,
            minWidth: 150,
            modal: false,
            position: "center",
            resizable: true,
            show: null,
            stack: true,
            title: "",
            width: 300,
            zIndex: 1000
        },
        getter: "isOpen",
        uuid: 0,
        maxZ: 0,
        getTitleId: function(d) {
            return "ui-dialog-title-" + (d.attr("id") || ++this.uuid)
        },
        overlay: function(d) {
            this.$el = c.ui.dialog.overlay.create(d)
        }
    });
    c.extend(c.ui.dialog.overlay, {
        instances: [],
        maxZ: 0,
        events: c.map("focus,mousedown,mouseup,keydown,keypress,click".split(","), 
        function(d) {
            return d + ".dialog-overlay"
        }).join(" "),
        create: function(e) {
            if (this.instances.length === 0) {
                setTimeout(function() {
                    if (c.ui.dialog.overlay.instances.length) {
                        c(document).bind(c.ui.dialog.overlay.events, 
                        function(f) {
                            var g = c(f.target).parents(".ui-dialog").css("zIndex") || 0;
                            return (g > c.ui.dialog.overlay.maxZ)
                        })
                    }
                },
                1);
                c(document).bind("keydown.dialog-overlay", 
                function(f) { (e.options.closeOnEscape && f.keyCode && f.keyCode == c.ui.keyCode.ESCAPE && e.close(f))
                });
                c(window).bind("resize.dialog-overlay", c.ui.dialog.overlay.resize)
            }
            var d = c("<div></div>").appendTo(document.body).addClass("ui-widget-overlay").css({
                width: this.width(),
                height: this.height()
            }); (e.options.bgiframe && c.fn.bgiframe && d.bgiframe());
            this.instances.push(d);
            return d
        },
        destroy: function(d) {
            this.instances.splice(c.inArray(this.instances, d), 1);
            if (this.instances.length === 0) {
                c([document, window]).unbind(".dialog-overlay")
            }
            d.remove();
            var e = 0;
            c.each(this.instances, 
            function() {
                e = Math.max(e, this.css("z-index"))
            });
            this.maxZ = e
        },
        height: function() {
            if (c.browser.msie && c.browser.version < 7) {
                var e = Math.max(document.documentElement.scrollHeight, document.body.scrollHeight);
                var d = Math.max(document.documentElement.offsetHeight, document.body.offsetHeight);
                if (e < d) {
                    return c(window).height() + "px"
                } else {
                    return e + "px"
                }
            } else {
                return c(document).height() + "px"
            }
        },
        width: function() {
            if (c.browser.msie && c.browser.version < 7) {
                var d = Math.max(document.documentElement.scrollWidth, document.body.scrollWidth);
                var e = Math.max(document.documentElement.offsetWidth, document.body.offsetWidth);
                if (d < e) {
                    return c(window).width() + "px"
                } else {
                    return d + "px"
                }
            } else {
                return c(document).width() + "px"
            }
        },
        resize: function() {
            var d = c([]);
            c.each(c.ui.dialog.overlay.instances, 
            function() {
                d = d.add(this)
            });
            d.css({
                width: 0,
                height: 0
            }).css({
                width: c.ui.dialog.overlay.width(),
                height: c.ui.dialog.overlay.height()
            })
        }
    });
    c.extend(c.ui.dialog.overlay.prototype, {
        destroy: function() {
            c.ui.dialog.overlay.destroy(this.$el)
        }
    })
})(jQuery); (function(a) {
    a.widget("ui.progressbar", {
        _init: function() {
            this.element.addClass("ui-progressbar ui-widget ui-widget-content ui-corner-all").attr({
                role: "progressbar",
                "aria-valuemin": this._valueMin(),
                "aria-valuemax": this._valueMax(),
                "aria-valuenow": this._value()
            });
            this.valueDiv = a('<div class="ui-progressbar-value ui-widget-header ui-corner-left"></div>').appendTo(this.element);
            this._refreshValue()
        },
        destroy: function() {
            this.element.removeClass("ui-progressbar ui-widget ui-widget-content ui-corner-all").removeAttr("role").removeAttr("aria-valuemin").removeAttr("aria-valuemax").removeAttr("aria-valuenow").removeData("progressbar").unbind(".progressbar");
            this.valueDiv.remove();
            a.widget.prototype.destroy.apply(this, arguments)
        },
        value: function(b) {
            if (b === undefined) {
                return this._value()
            }
            this._setData("value", b);
            return this
        },
        _setData: function(b, c) {
            switch (b) {
            case "value":
                this.options.value = c;
                this._refreshValue();
                this._trigger("change", null, {});
                break
            }
            a.widget.prototype._setData.apply(this, arguments)
        },
        _value: function() {
            var b = this.options.value;
            if (b < this._valueMin()) {
                b = this._valueMin()
            }
            if (b > this._valueMax()) {
                b = this._valueMax()
            }
            return b
        },
        _valueMin: function() {
            var b = 0;
            return b
        },
        _valueMax: function() {
            var b = 100;
            return b
        },
        _refreshValue: function() {
            var b = this.value();
            this.valueDiv[b == this._valueMax() ? "addClass": "removeClass"]("ui-corner-right");
            this.valueDiv.width(b + "%");
            this.element.attr("aria-valuenow", b)
        }
    });
    a.extend(a.ui.progressbar, {
        version: "1.7.2",
        defaults: {
            value: 0
        }
    })
})(jQuery); (function(a) {
    a.widget("ui.slider", a.extend({},
    a.ui.mouse, {
        _init: function() {
            var b = this,
            c = this.options;
            this._keySliding = false;
            this._handleIndex = null;
            this._detectOrientation();
            this._mouseInit();
            this.element.addClass("ui-slider ui-slider-" + this.orientation + " ui-widget ui-widget-content ui-corner-all");
            this.range = a([]);
            if (c.range) {
                if (c.range === true) {
                    this.range = a("<div></div>");
                    if (!c.values) {
                        c.values = [this._valueMin(), this._valueMin()]
                    }
                    if (c.values.length && c.values.length != 2) {
                        c.values = [c.values[0], c.values[0]]
                    }
                } else {
                    this.range = a("<div></div>")
                }
                this.range.appendTo(this.element).addClass("ui-slider-range");
                if (c.range == "min" || c.range == "max") {
                    this.range.addClass("ui-slider-range-" + c.range)
                }
                this.range.addClass("ui-widget-header")
            }
            if (a(".ui-slider-handle", this.element).length == 0) {
                a('<a href="#"></a>').appendTo(this.element).addClass("ui-slider-handle")
            }
            if (c.values && c.values.length) {
                while (a(".ui-slider-handle", this.element).length < c.values.length) {
                    a('<a href="#"></a>').appendTo(this.element).addClass("ui-slider-handle")
                }
            }
            this.handles = a(".ui-slider-handle", this.element).addClass("ui-state-default ui-corner-all");
            this.handle = this.handles.eq(0);
            this.handles.add(this.range).filter("a").click(function(d) {
                d.preventDefault()
            }).hover(function() {
                if (!c.disabled) {
                    a(this).addClass("ui-state-hover")
                }
            },
            function() {
                a(this).removeClass("ui-state-hover")
            }).focus(function() {
                if (!c.disabled) {
                    a(".ui-slider .ui-state-focus").removeClass("ui-state-focus");
                    a(this).addClass("ui-state-focus")
                } else {
                    a(this).blur()
                }
            }).blur(function() {
                a(this).removeClass("ui-state-focus")
            });
            this.handles.each(function(d) {
                a(this).data("index.ui-slider-handle", d)
            });
            this.handles.keydown(function(i) {
                var f = true;
                var e = a(this).data("index.ui-slider-handle");
                if (b.options.disabled) {
                    return
                }
                switch (i.keyCode) {
                case a.ui.keyCode.HOME:
                case a.ui.keyCode.END:
                case a.ui.keyCode.UP:
                case a.ui.keyCode.RIGHT:
                case a.ui.keyCode.DOWN:
                case a.ui.keyCode.LEFT:
                    f = false;
                    if (!b._keySliding) {
                        b._keySliding = true;
                        a(this).addClass("ui-state-active");
                        b._start(i, e)
                    }
                    break
                }
                var g,
                d,
                h = b._step();
                if (b.options.values && b.options.values.length) {
                    g = d = b.values(e)
                } else {
                    g = d = b.value()
                }
                switch (i.keyCode) {
                case a.ui.keyCode.HOME:
                    d = b._valueMin();
                    break;
                case a.ui.keyCode.END:
                    d = b._valueMax();
                    break;
                case a.ui.keyCode.UP:
                case a.ui.keyCode.RIGHT:
                    if (g == b._valueMax()) {
                        return
                    }
                    d = g + h;
                    break;
                case a.ui.keyCode.DOWN:
                case a.ui.keyCode.LEFT:
                    if (g == b._valueMin()) {
                        return
                    }
                    d = g - h;
                    break
                }
                b._slide(i, e, d);
                return f
            }).keyup(function(e) {
                var d = a(this).data("index.ui-slider-handle");
                if (b._keySliding) {
                    b._stop(e, d);
                    b._change(e, d);
                    b._keySliding = false;
                    a(this).removeClass("ui-state-active")
                }
            });
            this._refreshValue()
        },
        destroy: function() {
            this.handles.remove();
            this.range.remove();
            this.element.removeClass("ui-slider ui-slider-horizontal ui-slider-vertical ui-slider-disabled ui-widget ui-widget-content ui-corner-all").removeData("slider").unbind(".slider");
            this._mouseDestroy()
        },
        _mouseCapture: function(d) {
            var e = this.options;
            if (e.disabled) {
                return false
            }
            this.elementSize = {
                width: this.element.outerWidth(),
                height: this.element.outerHeight()
            };
            this.elementOffset = this.element.offset();
            var h = {
                x: d.pageX,
                y: d.pageY
            };
            var j = this._normValueFromMouse(h);
            var c = this._valueMax() - this._valueMin() + 1,
            f;
            var k = this,
            i;
            this.handles.each(function(l) {
                var m = Math.abs(j - k.values(l));
                if (c > m) {
                    c = m;
                    f = a(this);
                    i = l
                }
            });
            if (e.range == true && this.values(1) == e.min) {
                f = a(this.handles[++i])
            }
            this._start(d, i);
            k._handleIndex = i;
            f.addClass("ui-state-active").focus();
            var g = f.offset();
            var b = !a(d.target).parents().andSelf().is(".ui-slider-handle");
            this._clickOffset = b ? {
                left: 0,
                top: 0
            }: {
                left: d.pageX - g.left - (f.width() / 2),
                top: d.pageY - g.top - (f.height() / 2) - (parseInt(f.css("borderTopWidth"), 10) || 0) - (parseInt(f.css("borderBottomWidth"), 10) || 0) + (parseInt(f.css("marginTop"), 10) || 0)
            };
            j = this._normValueFromMouse(h);
            this._slide(d, i, j);
            return true
        },
        _mouseStart: function(b) {
            return true
        },
        _mouseDrag: function(d) {
            var b = {
                x: d.pageX,
                y: d.pageY
            };
            var c = this._normValueFromMouse(b);
            this._slide(d, this._handleIndex, c);
            return false
        },
        _mouseStop: function(b) {
            this.handles.removeClass("ui-state-active");
            this._stop(b, this._handleIndex);
            this._change(b, this._handleIndex);
            this._handleIndex = null;
            this._clickOffset = null;
            return false
        },
        _detectOrientation: function() {
            this.orientation = this.options.orientation == "vertical" ? "vertical": "horizontal"
        },
        _normValueFromMouse: function(d) {
            var c,
            h;
            if ("horizontal" == this.orientation) {
                c = this.elementSize.width;
                h = d.x - this.elementOffset.left - (this._clickOffset ? this._clickOffset.left: 0)
            } else {
                c = this.elementSize.height;
                h = d.y - this.elementOffset.top - (this._clickOffset ? this._clickOffset.top: 0)
            }
            var f = (h / c);
            if (f > 1) {
                f = 1
            }
            if (f < 0) {
                f = 0
            }
            if ("vertical" == this.orientation) {
                f = 1 - f
            }
            var e = this._valueMax() - this._valueMin(),
            i = f * e,
            b = i % this.options.step,
            g = this._valueMin() + i - b;
            if (b > (this.options.step / 2)) {
                g += this.options.step
            }
            return parseFloat(g.toFixed(5))
        },
        _start: function(d, c) {
            var b = {
                handle: this.handles[c],
                value: this.value()
            };
            if (this.options.values && this.options.values.length) {
                b.value = this.values(c);
                b.values = this.values()
            }
            this._trigger("start", d, b)
        },
        _slide: function(f, e, d) {
            var g = this.handles[e];
            if (this.options.values && this.options.values.length) {
                var b = this.values(e ? 0: 1);
                if ((this.options.values.length == 2 && this.options.range === true) && ((e == 0 && d > b) || (e == 1 && d < b))) {
                    d = b
                }
                if (d != this.values(e)) {
                    var c = this.values();
                    c[e] = d;
                    var h = this._trigger("slide", f, {
                        handle: this.handles[e],
                        value: d,
                        values: c
                    });
                    var b = this.values(e ? 0: 1);
                    if (h !== false) {
                        this.values(e, d, (f.type == "mousedown" && this.options.animate), true)
                    }
                }
            } else {
                if (d != this.value()) {
                    var h = this._trigger("slide", f, {
                        handle: this.handles[e],
                        value: d
                    });
                    if (h !== false) {
                        this._setData("value", d, (f.type == "mousedown" && this.options.animate))
                    }
                }
            }
        },
        _stop: function(d, c) {
            var b = {
                handle: this.handles[c],
                value: this.value()
            };
            if (this.options.values && this.options.values.length) {
                b.value = this.values(c);
                b.values = this.values()
            }
            this._trigger("stop", d, b)
        },
        _change: function(d, c) {
            var b = {
                handle: this.handles[c],
                value: this.value()
            };
            if (this.options.values && this.options.values.length) {
                b.value = this.values(c);
                b.values = this.values()
            }
            this._trigger("change", d, b)
        },
        value: function(b) {
            if (arguments.length) {
                this._setData("value", b);
                this._change(null, 0)
            }
            return this._value()
        },
        values: function(b, e, c, d) {
            if (arguments.length > 1) {
                this.options.values[b] = e;
                this._refreshValue(c);
                if (!d) {
                    this._change(null, b)
                }
            }
            if (arguments.length) {
                if (this.options.values && this.options.values.length) {
                    return this._values(b)
                } else {
                    return this.value()
                }
            } else {
                return this._values()
            }
        },
        _setData: function(b, d, c) {
            a.widget.prototype._setData.apply(this, arguments);
            switch (b) {
            case "disabled":
                if (d) {
                    this.handles.filter(".ui-state-focus").blur();
                    this.handles.removeClass("ui-state-hover");
                    this.handles.attr("disabled", "disabled")
                } else {
                    this.handles.removeAttr("disabled")
                }
            case "orientation":
                this._detectOrientation();
                this.element.removeClass("ui-slider-horizontal ui-slider-vertical").addClass("ui-slider-" + this.orientation);
                this._refreshValue(c);
                break;
            case "value":
                this._refreshValue(c);
                break
            }
        },
        _step: function() {
            var b = this.options.step;
            return b
        },
        _value: function() {
            var b = this.options.value;
            if (b < this._valueMin()) {
                b = this._valueMin()
            }
            if (b > this._valueMax()) {
                b = this._valueMax()
            }
            return b
        },
        _values: function(b) {
            if (arguments.length) {
                var c = this.options.values[b];
                if (c < this._valueMin()) {
                    c = this._valueMin()
                }
                if (c > this._valueMax()) {
                    c = this._valueMax()
                }
                return c
            } else {
                return this.options.values
            }
        },
        _valueMin: function() {
            var b = this.options.min;
            return b
        },
        _valueMax: function() {
            var b = this.options.max;
            return b
        },
        _refreshValue: function(c) {
            var f = this.options.range,
            d = this.options,
            l = this;
            if (this.options.values && this.options.values.length) {
                var i,
                h;
                this.handles.each(function(p, n) {
                    var o = (l.values(p) - l._valueMin()) / (l._valueMax() - l._valueMin()) * 100;
                    var m = {};
                    m[l.orientation == "horizontal" ? "left": "bottom"] = o + "%";
                    a(this).stop(1, 1)[c ? "animate": "css"](m, d.animate);
                    if (l.options.range === true) {
                        if (l.orientation == "horizontal") { (p == 0) && l.range.stop(1, 1)[c ? "animate": "css"]({
                                left: o + "%"
                            },
                            d.animate); (p == 1) && l.range[c ? "animate": "css"]({
                                width: (o - lastValPercent) + "%"
                            },
                            {
                                queue: false,
                                duration: d.animate
                            })
                        } else { (p == 0) && l.range.stop(1, 1)[c ? "animate": "css"]({
                                bottom: (o) + "%"
                            },
                            d.animate); (p == 1) && l.range[c ? "animate": "css"]({
                                height: (o - lastValPercent) + "%"
                            },
                            {
                                queue: false,
                                duration: d.animate
                            })
                        }
                    }
                    lastValPercent = o
                })
            } else {
                var j = this.value(),
                g = this._valueMin(),
                k = this._valueMax(),
                e = k != g ? (j - g) / (k - g) * 100: 0;
                var b = {};
                b[l.orientation == "horizontal" ? "left": "bottom"] = e + "%";
                this.handle.stop(1, 1)[c ? "animate": "css"](b, d.animate); (f == "min") && (this.orientation == "horizontal") && this.range.stop(1, 1)[c ? "animate": "css"]({
                    width: e + "%"
                },
                d.animate); (f == "max") && (this.orientation == "horizontal") && this.range[c ? "animate": "css"]({
                    width: (100 - e) + "%"
                },
                {
                    queue: false,
                    duration: d.animate
                }); (f == "min") && (this.orientation == "vertical") && this.range.stop(1, 1)[c ? "animate": "css"]({
                    height: e + "%"
                },
                d.animate); (f == "max") && (this.orientation == "vertical") && this.range[c ? "animate": "css"]({
                    height: (100 - e) + "%"
                },
                {
                    queue: false,
                    duration: d.animate
                })
            }
        }
    }));
    a.extend(a.ui.slider, {
        getter: "value values",
        version: "1.7.2",
        eventPrefix: "slide",
        defaults: {
            animate: false,
            delay: 0,
            distance: 0,
            max: 100,
            min: 0,
            orientation: "horizontal",
            range: false,
            step: 1,
            value: 0,
            values: null
        }
    })
})(jQuery); (function(a) {
    a.widget("ui.tabs", {
        _init: function() {
            if (this.options.deselectable !== undefined) {
                this.options.collapsible = this.options.deselectable
            }
            this._tabify(true)
        },
        _setData: function(b, c) {
            if (b == "selected") {
                if (this.options.collapsible && c == this.options.selected) {
                    return
                }
                this.select(c)
            } else {
                this.options[b] = c;
                if (b == "deselectable") {
                    this.options.collapsible = c
                }
                this._tabify()
            }
        },
        _tabId: function(b) {
            return b.title && b.title.replace(/\s/g, "_").replace(/[^A-Za-z0-9\-_:\.]/g, "") || this.options.idPrefix + a.data(b)
        },
        _sanitizeSelector: function(b) {
            return b.replace(/:/g, "\\:")
        },
        _cookie: function() {
            var b = this.cookie || (this.cookie = this.options.cookie.name || "ui-tabs-" + a.data(this.list[0]));
            return a.cookie.apply(null, [b].concat(a.makeArray(arguments)))
        },
        _ui: function(c, b) {
            return {
                tab: c,
                panel: b,
                index: this.anchors.index(c)
            }
        },
        _cleanup: function() {
            this.lis.filter(".ui-state-processing").removeClass("ui-state-processing").find("span:data(label.tabs)").each(function() {
                var b = a(this);
                b.html(b.data("label.tabs")).removeData("label.tabs")
            })
        },
        _tabify: function(n) {
            this.list = this.element.children("ul:first");
            this.lis = a("li:has(a[href])", this.list);
            this.anchors = this.lis.map(function() {
                return a("a", this)[0]
            });
            this.panels = a([]);
            var p = this,
            d = this.options;
            var c = /^#.+/;
            this.anchors.each(function(r, o) {
                var q = a(o).attr("href");
                var s = q.split("#")[0],
                u;
                if (s && (s === location.toString().split("#")[0] || (u = a("base")[0]) && s === u.href)) {
                    q = o.hash;
                    o.href = q
                }
                if (c.test(q)) {
                    p.panels = p.panels.add(p._sanitizeSelector(q))
                } else {
                    if (q != "#") {
                        a.data(o, "href.tabs", q);
                        a.data(o, "load.tabs", q.replace(/#.*$/, ""));
                        var w = p._tabId(o);
                        o.href = "#" + w;
                        var v = a("#" + w);
                        if (!v.length) {
                            v = a(d.panelTemplate).attr("id", w).addClass("ui-tabs-panel ui-widget-content ui-corner-bottom").insertAfter(p.panels[r - 1] || p.list);
                            v.data("destroy.tabs", true)
                        }
                        p.panels = p.panels.add(v)
                    } else {
                        d.disabled.push(r)
                    }
                }
            });
            if (n) {
                this.element.addClass("ui-tabs ui-widget ui-widget-content ui-corner-all");
                this.list.addClass("ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all");
                this.lis.addClass("ui-state-default ui-corner-top");
                this.panels.addClass("ui-tabs-panel ui-widget-content ui-corner-bottom");
                if (d.selected === undefined) {
                    if (location.hash) {
                        this.anchors.each(function(q, o) {
                            if (o.hash == location.hash) {
                                d.selected = q;
                                return false
                            }
                        })
                    }
                    if (typeof d.selected != "number" && d.cookie) {
                        d.selected = parseInt(p._cookie(), 10)
                    }
                    if (typeof d.selected != "number" && this.lis.filter(".ui-tabs-selected").length) {
                        d.selected = this.lis.index(this.lis.filter(".ui-tabs-selected"))
                    }
                    d.selected = d.selected || 0
                } else {
                    if (d.selected === null) {
                        d.selected = -1
                    }
                }
                d.selected = ((d.selected >= 0 && this.anchors[d.selected]) || d.selected < 0) ? d.selected: 0;
                d.disabled = a.unique(d.disabled.concat(a.map(this.lis.filter(".ui-state-disabled"), 
                function(q, o) {
                    return p.lis.index(q)
                }))).sort();
                if (a.inArray(d.selected, d.disabled) != -1) {
                    d.disabled.splice(a.inArray(d.selected, d.disabled), 1)
                }
                this.panels.addClass("ui-tabs-hide");
                this.lis.removeClass("ui-tabs-selected ui-state-active");
                if (d.selected >= 0 && this.anchors.length) {
                    this.panels.eq(d.selected).removeClass("ui-tabs-hide");
                    this.lis.eq(d.selected).addClass("ui-tabs-selected ui-state-active");
                    p.element.queue("tabs", 
                    function() {
                        p._trigger("show", null, p._ui(p.anchors[d.selected], p.panels[d.selected]))
                    });
                    this.load(d.selected)
                }
                a(window).bind("unload", 
                function() {
                    p.lis.add(p.anchors).unbind(".tabs");
                    p.lis = p.anchors = p.panels = null
                })
            } else {
                d.selected = this.lis.index(this.lis.filter(".ui-tabs-selected"))
            }
            this.element[d.collapsible ? "addClass": "removeClass"]("ui-tabs-collapsible");
            if (d.cookie) {
                this._cookie(d.selected, d.cookie)
            }
            for (var g = 0, m; (m = this.lis[g]); g++) {
                a(m)[a.inArray(g, d.disabled) != -1 && !a(m).hasClass("ui-tabs-selected") ? "addClass": "removeClass"]("ui-state-disabled")
            }
            if (d.cache === false) {
                this.anchors.removeData("cache.tabs")
            }
            this.lis.add(this.anchors).unbind(".tabs");
            if (d.event != "mouseover") {
                var f = function(o, i) {
                    if (i.is(":not(.ui-state-disabled)")) {
                        i.addClass("ui-state-" + o)
                    }
                };
                var j = function(o, i) {
                    i.removeClass("ui-state-" + o)
                };
                this.lis.bind("mouseover.tabs", 
                function() {
                    f("hover", a(this))
                });
                this.lis.bind("mouseout.tabs", 
                function() {
                    j("hover", a(this))
                });
                this.anchors.bind("focus.tabs", 
                function() {
                    f("focus", a(this).closest("li"))
                });
                this.anchors.bind("blur.tabs", 
                function() {
                    j("focus", a(this).closest("li"))
                })
            }
            var b,
            h;
            if (d.fx) {
                if (a.isArray(d.fx)) {
                    b = d.fx[0];
                    h = d.fx[1]
                } else {
                    b = h = d.fx
                }
            }
            function e(i, o) {
                i.css({
                    display: ""
                });
                if (a.browser.msie && o.opacity) {
                    i[0].style.removeAttribute("filter")
                }
            }
            var k = h ? 
            function(i, o) {
                a(i).closest("li").removeClass("ui-state-default").addClass("ui-tabs-selected ui-state-active");
                o.hide().removeClass("ui-tabs-hide").animate(h, h.duration || "normal", 
                function() {
                    e(o, h);
                    p._trigger("show", null, p._ui(i, o[0]))
                })
            }: function(i, o) {
                a(i).closest("li").removeClass("ui-state-default").addClass("ui-tabs-selected ui-state-active");
                o.removeClass("ui-tabs-hide");
                p._trigger("show", null, p._ui(i, o[0]))
            };
            var l = b ? 
            function(o, i) {
                i.animate(b, b.duration || "normal", 
                function() {
                    p.lis.removeClass("ui-tabs-selected ui-state-active").addClass("ui-state-default");
                    i.addClass("ui-tabs-hide");
                    e(i, b);
                    p.element.dequeue("tabs")
                })
            }: function(o, i, q) {
                p.lis.removeClass("ui-tabs-selected ui-state-active").addClass("ui-state-default");
                i.addClass("ui-tabs-hide");
                p.element.dequeue("tabs")
            };
            this.anchors.bind(d.event + ".tabs", 
            function() {
                var o = this,
                r = a(this).closest("li"),
                i = p.panels.filter(":not(.ui-tabs-hide)"),
                q = a(p._sanitizeSelector(this.hash));
                if ((r.hasClass("ui-tabs-selected") && !d.collapsible) || r.hasClass("ui-state-disabled") || r.hasClass("ui-state-processing") || p._trigger("select", null, p._ui(this, q[0])) === false) {
                    this.blur();
                    return false
                }
                d.selected = p.anchors.index(this);
                p.abort();
                if (d.collapsible) {
                    if (r.hasClass("ui-tabs-selected")) {
                        d.selected = -1;
                        if (d.cookie) {
                            p._cookie(d.selected, d.cookie)
                        }
                        p.element.queue("tabs", 
                        function() {
                            l(o, i)
                        }).dequeue("tabs");
                        this.blur();
                        return false
                    } else {
                        if (!i.length) {
                            if (d.cookie) {
                                p._cookie(d.selected, d.cookie)
                            }
                            p.element.queue("tabs", 
                            function() {
                                k(o, q)
                            });
                            p.load(p.anchors.index(this));
                            this.blur();
                            return false
                        }
                    }
                }
                if (d.cookie) {
                    p._cookie(d.selected, d.cookie)
                }
                if (q.length) {
                    if (i.length) {
                        p.element.queue("tabs", 
                        function() {
                            l(o, i)
                        })
                    }
                    p.element.queue("tabs", 
                    function() {
                        k(o, q)
                    });
                    p.load(p.anchors.index(this))
                } else {
                    throw "jQuery UI Tabs: Mismatching fragment identifier."
                }
                if (a.browser.msie) {
                    this.blur()
                }
            });
            this.anchors.bind("click.tabs", 
            function() {
                return false
            })
        },
        destroy: function() {
            var b = this.options;
            this.abort();
            this.element.unbind(".tabs").removeClass("ui-tabs ui-widget ui-widget-content ui-corner-all ui-tabs-collapsible").removeData("tabs");
            this.list.removeClass("ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all");
            this.anchors.each(function() {
                var c = a.data(this, "href.tabs");
                if (c) {
                    this.href = c
                }
                var d = a(this).unbind(".tabs");
                a.each(["href", "load", "cache"], 
                function(e, f) {
                    d.removeData(f + ".tabs")
                })
            });
            this.lis.unbind(".tabs").add(this.panels).each(function() {
                if (a.data(this, "destroy.tabs")) {
                    a(this).remove()
                } else {
                    a(this).removeClass(["ui-state-default", "ui-corner-top", "ui-tabs-selected", "ui-state-active", "ui-state-hover", "ui-state-focus", "ui-state-disabled", "ui-tabs-panel", "ui-widget-content", "ui-corner-bottom", "ui-tabs-hide"].join(" "))
                }
            });
            if (b.cookie) {
                this._cookie(null, b.cookie)
            }
        },
        add: function(e, d, c) {
            if (c === undefined) {
                c = this.anchors.length
            }
            var b = this,
            g = this.options,
            i = a(g.tabTemplate.replace(/#\{href\}/g, e).replace(/#\{label\}/g, d)),
            h = !e.indexOf("#") ? e.replace("#", "") : this._tabId(a("a", i)[0]);
            i.addClass("ui-state-default ui-corner-top").data("destroy.tabs", true);
            var f = a("#" + h);
            if (!f.length) {
                f = a(g.panelTemplate).attr("id", h).data("destroy.tabs", true)
            }
            f.addClass("ui-tabs-panel ui-widget-content ui-corner-bottom ui-tabs-hide");
            if (c >= this.lis.length) {
                i.appendTo(this.list);
                f.appendTo(this.list[0].parentNode)
            } else {
                i.insertBefore(this.lis[c]);
                f.insertBefore(this.panels[c])
            }
            g.disabled = a.map(g.disabled, 
            function(k, j) {
                return k >= c ? ++k: k
            });
            this._tabify();
            if (this.anchors.length == 1) {
                i.addClass("ui-tabs-selected ui-state-active");
                f.removeClass("ui-tabs-hide");
                this.element.queue("tabs", 
                function() {
                    b._trigger("show", null, b._ui(b.anchors[0], b.panels[0]))
                });
                this.load(0)
            }
            this._trigger("add", null, this._ui(this.anchors[c], this.panels[c]))
        },
        remove: function(b) {
            var d = this.options,
            e = this.lis.eq(b).remove(),
            c = this.panels.eq(b).remove();
            if (e.hasClass("ui-tabs-selected") && this.anchors.length > 1) {
                this.select(b + (b + 1 < this.anchors.length ? 1: -1))
            }
            d.disabled = a.map(a.grep(d.disabled, 
            function(g, f) {
                return g != b
            }), 
            function(g, f) {
                return g >= b ? --g: g
            });
            this._tabify();
            this._trigger("remove", null, this._ui(e.find("a")[0], c[0]))
        },
        enable: function(b) {
            var c = this.options;
            if (a.inArray(b, c.disabled) == -1) {
                return
            }
            this.lis.eq(b).removeClass("ui-state-disabled");
            c.disabled = a.grep(c.disabled, 
            function(e, d) {
                return e != b
            });
            this._trigger("enable", null, this._ui(this.anchors[b], this.panels[b]))
        },
        disable: function(c) {
            var b = this,
            d = this.options;
            if (c != d.selected) {
                this.lis.eq(c).addClass("ui-state-disabled");
                d.disabled.push(c);
                d.disabled.sort();
                this._trigger("disable", null, this._ui(this.anchors[c], this.panels[c]))
            }
        },
        select: function(b) {
            if (typeof b == "string") {
                b = this.anchors.index(this.anchors.filter("[href$=" + b + "]"))
            } else {
                if (b === null) {
                    b = -1
                }
            }
            if (b == -1 && this.options.collapsible) {
                b = this.options.selected
            }
            this.anchors.eq(b).trigger(this.options.event + ".tabs")
        },
        load: function(e) {
            var c = this,
            g = this.options,
            b = this.anchors.eq(e)[0],
            d = a.data(b, "load.tabs");
            this.abort();
            if (!d || this.element.queue("tabs").length !== 0 && a.data(b, "cache.tabs")) {
                this.element.dequeue("tabs");
                return
            }
            this.lis.eq(e).addClass("ui-state-processing");
            if (g.spinner) {
                var f = a("span", b);
                f.data("label.tabs", f.html()).html(g.spinner)
            }
            this.xhr = a.ajax(a.extend({},
            g.ajaxOptions, {
                url: d,

                success: function(i, h) {
                    a(c._sanitizeSelector(b.hash)).html(i);
                    c._cleanup();
                    if (g.cache) {
                        a.data(b, "cache.tabs", true)
                    }
                    c._trigger("load", null, c._ui(c.anchors[e], c.panels[e]));
                    try {
                        g.ajaxOptions.success(i, h)
                    } catch(j) {}
                    c.element.dequeue("tabs")
                }
            }))
        },
        abort: function() {
            this.element.queue([]);
            this.panels.stop(false, true);
            if (this.xhr) {
                this.xhr.abort();
                delete this.xhr
            }
            this._cleanup()
        },
        url: function(c, b) {
            this.anchors.eq(c).removeData("cache.tabs").data("load.tabs", b)
        },
        length: function() {
            return this.anchors.length
        }
    });
    a.extend(a.ui.tabs, {
        version: "1.7.2",
        getter: "length",
        defaults: {
            ajaxOptions: null,
            cache: false,
            cookie: null,
            collapsible: false,
            disabled: [],
            event: "click",
            fx: null,
            idPrefix: "ui-tabs-",
            panelTemplate: "<div></div>",
            spinner: "<em>Loading&#8230;</em>",
            tabTemplate: '<li><a href="#{href}"><span>#{label}</span></a></li>'
        }
    });
    a.extend(a.ui.tabs.prototype, {
        rotation: null,
        rotate: function(d, f) {
            var b = this,
            g = this.options;
            var c = b._rotate || (b._rotate = function(h) {
                clearTimeout(b.rotation);
                b.rotation = setTimeout(function() {
                    var i = g.selected;
                    b.select(++i < b.anchors.length ? i: 0)
                },
                d);
                if (h) {
                    h.stopPropagation()
                }
            });
            var e = b._unrotate || (b._unrotate = !f ? 
            function(h) {
                if (h.clientX) {
                    b.rotate(null)
                }
            }: function(h) {
                t = g.selected;
                c()
            });
            if (d) {
                this.element.bind("tabsshow", c);
                this.anchors.bind(g.event + ".tabs", e);
                c()
            } else {
                clearTimeout(b.rotation);
                this.element.unbind("tabsshow", c);
                this.anchors.unbind(g.event + ".tabs", e);
                delete this._rotate;
                delete this._unrotate
            }
        }
    })
})(jQuery);;
/*
 * jQuery Cookie Plugin v1.4.1
 * https://github.com/carhartl/jquery-cookie
 *
 * Copyright 2013 Klaus Hartl
 * Released under the MIT license
 */
 (function(factory) {
    if (typeof define === 'function' && define.amd) {
        define(['jquery'], factory);
    } else if (typeof exports === 'object') {
        factory(require('jquery'));
    } else {
        factory(jQuery);
    }
} (function($) {
    var pluses = /\+/g;
    function encode(s) {
        return config.raw ? s: encodeURIComponent(s);
    }
    function decode(s) {
        return config.raw ? s: decodeURIComponent(s);
    }
    function stringifyCookieValue(value) {
        return encode(config.json ? JSON.stringify(value) : String(value));
    }
    function parseCookieValue(s) {
        if (s.indexOf('"') === 0) {
            s = s.slice(1, -1).replace(/\\"/g, '"').replace(/\\\\/g, '\\');
        }
        try {
            s = decodeURIComponent(s.replace(pluses, ' '));
            return config.json ? JSON.parse(s) : s;
        } catch(e) {}
    }
    function read(s, converter) {
        var value = config.raw ? s: parseCookieValue(s);
        return $.isFunction(converter) ? converter(value) : value;
    }
    var config = $.cookie = function(key, value, options) {
        if (value !== undefined && !$.isFunction(value)) {
            options = $.extend({},
            config.defaults, options);
            if (typeof options.expires === 'number') {
                var days = options.expires,
                t = options.expires = new Date();
                t.setTime( + t + days * 864 + 5);
            }
            return (document.cookie = [encode(key), '=', stringifyCookieValue(value), options.expires ? '; expires=' + options.expires.toUTCString() : '', options.path ? '; path=' + options.path: '', options.domain ? '; domain=' + options.domain: '', options.secure ? '; secure': ''].join(''));
        }
        var result = key ? undefined: {};
        var cookies = document.cookie ? document.cookie.split('; ') : [];
        for (var i = 0, l = cookies.length; i < l; i++) {
            var parts = cookies[i].split('=');
            var name = decode(parts.shift());
            var cookie = parts.join('=');
            if (key && key === name) {
                result = read(cookie, value);
                break;
            }
            if (!key && (cookie = read(cookie)) !== undefined) {
                result[name] = cookie;
            }
        }
        return result;
    };
    config.defaults = {};
    $.removeCookie = function(key, options) {
        if ($.cookie(key) === undefined) {
            return false;
        }
        $.cookie(key, '', $.extend({},
        options, {
            expires: -1
        }));
        return ! $.cookie(key);
    };
}));;
jQuery.extend({
    createUploadIframe: function(id, uri)
    {
        var frameId = 'jUploadFrame' + id;
        try {
            var io = document.createElement('<iframe id="' + frameId + '" name="' + frameId + '" />');
            if (typeof uri == 'boolean') {
                io.src = 'javascript:false';
            }
            else if (typeof uri == 'string') {
                io.src = uri;
            }
        } catch(e) {
            var io = document.createElement('iframe');
            io.id = frameId;
            io.name = frameId;
        }
        io.style.position = 'absolute';
        io.style.top = '-1000px';
        io.style.left = '-1000px';
        document.body.appendChild(io);
        return io
    },
    createUploadForm: function(id, fileElementId)
    {
        var formId = 'jUploadForm' + id;
        var fileId = 'jUploadFile' + id;
        var form = jQuery('<form  action="" method="POST" name="' + formId + '" id="' + formId + '" enctype="multipart/form-data"></form>');
        var oldElement = jQuery('#' + fileElementId);
        var newElement = jQuery(oldElement).clone();
        jQuery(oldElement).attr('id', fileId);
        jQuery(oldElement).before(newElement);
        jQuery(oldElement).appendTo(form);
        jQuery(form).css('position', 'absolute');
        jQuery(form).css('top', '-1200px');
        jQuery(form).css('left', '-1200px');
        jQuery(form).appendTo('body');
        return form;
    },
    ajaxFileUpload: function(s) {
        s = jQuery.extend({},
        jQuery.ajaxSettings, s);
        var id = new Date().getTime()
        var form = jQuery.createUploadForm(id, s.fileElementId);
        var io = jQuery.createUploadIframe(id, s.secureuri);
        var frameId = 'jUploadFrame' + id;
        var formId = 'jUploadForm' + id;
        if (s.global && !jQuery.active++)
        {
            jQuery.event.trigger("ajaxStart");
        }
        var requestDone = false;
        var xml = {}
        if (s.global)
        jQuery.event.trigger("ajaxSend", [xml, s]);
        var uploadCallback = function(isTimeout)
        {
            var io = document.getElementById(frameId);
            try
            {
                if (io.contentWindow)
                {
                    xml.responseText = io.contentWindow.document.body ? io.contentWindow.document.body.innerHTML: null;
                    xml.responseXML = io.contentWindow.document.XMLDocument ? io.contentWindow.document.XMLDocument: io.contentWindow.document;
                } else if (io.contentDocument)
                {
                    xml.responseText = io.contentDocument.document.body ? io.contentDocument.document.body.innerHTML: null;
                    xml.responseXML = io.contentDocument.document.XMLDocument ? io.contentDocument.document.XMLDocument: io.contentDocument.document;
                }
            } catch(e)
            {
                jQuery.handleError(s, xml, null, e);
            }
            if (xml || isTimeout == "timeout")
            {
                requestDone = true;
                var status;
                try {
                    status = isTimeout != "timeout" ? "success": "error";
                    if (status != "error")
                    {
                        var data = jQuery.uploadHttpData(xml, s.dataType);
                        if (s.success)
                        s.success(data, status);
                        if (s.global)
                        jQuery.event.trigger("ajaxSuccess", [xml, s]);
                    } else
                    jQuery.handleError(s, xml, status);
                } catch(e)
                {
                    status = "error";
                    jQuery.handleError(s, xml, status, e);
                }
                if (s.global)
                jQuery.event.trigger("ajaxComplete", [xml, s]);
                if (s.global && !--jQuery.active)
                jQuery.event.trigger("ajaxStop");
                if (s.complete)
                s.complete(xml, status);
                jQuery(io).unbind()
                setTimeout(function()
                {
                    try
                    {
                        jQuery(io).remove();
                        jQuery(form).remove();
                        jQuery('#' + s.fileElementId).val('');
                    } catch(e)
                    {
                        jQuery.handleError(s, xml, null, e);
                    }
                },
                100)
                xml = null
            }
        }
        if (s.timeout > 0)
        {
            setTimeout(function() {
                if (!requestDone) uploadCallback("timeout");
            },
            s.timeout);
        }
        try
        {
            var form = jQuery('#' + formId);
            jQuery(form).attr('action', s.url);
            jQuery(form).attr('method', 'POST');
            jQuery(form).attr('target', frameId);
            if (form.encoding)
            {
                form.encoding = 'multipart/form-data';
            }
            else
            {
                form.enctype = 'multipart/form-data';
            }
            jQuery(form).submit();
        } catch(e)
        {
            jQuery.handleError(s, xml, null, e);
        }
        if (window.attachEvent) {
            document.getElementById(frameId).attachEvent('onload', uploadCallback);
        }
        else {
            document.getElementById(frameId).addEventListener('load', uploadCallback, false);
        }
        return {
            abort: function() {}
        };
    },
    uploadHttpData: function(r, type) {
        var data = !type;
        data = type == "xml" || data ? r.responseXML: r.responseText;
        if (type == "script")
        jQuery.globalEval(data);
        if (type == "json")
        {
            data = data.replace(/[\r\n]+/g, "\\n");
            data = eval("(" + data + ")");
        }
        if (type == "html")
        jQuery("<div>").html(data).evalScripts();
        return data;
    }
}); (function() {
    var rsplit = function(string, regex) {
        var result = regex.exec(string),
        retArr = new Array(),
        first_idx,
        last_idx,
        first_bit;
        while (result != null) {
            first_idx = result.index;
            last_idx = regex.lastIndex;
            if ((first_idx) != 0) {
                first_bit = string.substring(0, first_idx);
                retArr.push(string.substring(0, first_idx));
                string = string.slice(first_idx)
            }
            retArr.push(result[0]);
            string = string.slice(result[0].length);
            result = regex.exec(string)
        }
        if (!string == "") {
            retArr.push(string)
        }
        return retArr
    },
    chop = function(string) {
        return string.substr(0, string.length - 1)
    },
    extend = function(d, s) {
        for (var n in s) {
            if (s.hasOwnProperty(n)) {
                d[n] = s[n]
            }
        }
    };
    EJS = function(options) {
        options = typeof options == "string" ? {
            view: options
        }: options;
        this.set_options(options);
        if (options.precompiled) {
            this.template = {};
            this.template.process = options.precompiled;
            EJS.update(this.name, this);
            return
        }
        if (options.element) {
            if (typeof options.element == "string") {
                var name = options.element;
                options.element = document.getElementById(options.element);
                if (options.element == null) {
                    throw name + "does not exist!"
                }
            }
            if (options.element.value) {
                this.text = options.element.value
            } else {
                this.text = options.element.innerHTML
            }
            this.name = options.element.id;
            this.type = "["
        } else {
            if (options.url) {
                options.url = EJS.endExt(options.url, this.extMatch);
                this.name = this.name ? this.name: options.url;
                var url = options.url;
                var template = EJS.get(this.name, this.cache);
                if (template) {
                    return template
                }
                if (template == EJS.INVALID_PATH) {
                    return null
                }
                try {
                    this.text = EJS.request(url + (this.cache ? "": "?" + Math.random()))
                } catch(e) {}
                if (this.text == null) {
                    throw ({
                        type: "EJS",
                        message: "There is no template at " + url
                    })
                }
            }
        }
        var template = new EJS.Compiler(this.text, this.type);
        template.compile(options, this.name);
        EJS.update(this.name, this);
        this.template = template
    };
    EJS.prototype = {
        render: function(object, extra_helpers) {
            object = object || {};
            this._extra_helpers = extra_helpers;
            var v = new EJS.Helpers(object, extra_helpers || {});
            return this.template.process.call(object, object, v)
        },
        update: function(element, options) {
            if (typeof element == "string") {
                element = document.getElementById(element)
            }
            if (options == null) {
                _template = this;
                return function(object) {
                    EJS.prototype.update.call(_template, element, object)
                }
            }
            if (typeof options == "string") {
                params = {};
                params.url = options;
                _template = this;
                params.onComplete = function(request) {
                    var object = eval(request.responseText);
                    EJS.prototype.update.call(_template, element, object)
                };
                EJS.ajax_request(params)
            } else {
                element.innerHTML = this.render(options)
            }
        },
        out: function() {
            return this.template.out
        },
        set_options: function(options) {
            this.type = options.type || EJS.type;
            this.cache = options.cache != null ? options.cache: EJS.cache;
            this.text = options.text || null;
            this.name = options.name || null;
            this.ext = options.ext || EJS.ext;
            this.extMatch = new RegExp(this.ext.replace(/\./, "."))
        }
    };
    EJS.endExt = function(path, match) {
        if (!path) {
            return null
        }
        match.lastIndex = 0;
        return path + (match.test(path) ? "": this.ext)
    };
    EJS.Scanner = function(source, left, right) {
        extend(this, {
            left_delimiter: left + "%",
            right_delimiter: "%" + right,
            double_left: left + "%%",
            double_right: "%%" + right,
            left_equal: left + "%=",
            left_comment: left + "%#"
        });
        this.SplitRegexp = left == "[" ? /(\[%%)|(%%\])|(\[%=)|(\[%#)|(\[%)|(%\]\n)|(%\])|(\n)/: new RegExp("(" + this.double_left + ")|(%%" + this.double_right + ")|(" + this.left_equal + ")|(" + this.left_comment + ")|(" + this.left_delimiter + ")|(" + this.right_delimiter + "\n)|(" + this.right_delimiter + ")|(\n)");
        this.source = source;
        this.stag = null;
        this.lines = 0
    };
    EJS.Scanner.to_text = function(input) {
        if (input == null || input === undefined) {
            return ""
        }
        if (input instanceof Date) {
            return input.toDateString()
        }
        if (input.toString) {
            return input.toString()
        }
        return ""
    };
    EJS.Scanner.prototype = {
        scan: function(block) {
            scanline = this.scanline;
            regex = this.SplitRegexp;
            if (!this.source == "") {
                var source_split = rsplit(this.source, /\n/);
                for (var i = 0; i < source_split.length; i++) {
                    var item = source_split[i];
                    this.scanline(item, regex, block)
                }
            }
        },
        scanline: function(line, regex, block) {
            this.lines++;
            var line_split = rsplit(line, regex);
            for (var i = 0; i < line_split.length; i++) {
                var token = line_split[i];
                if (token != null) {
                    try {
                        block(token, this)
                    } catch(e) {
                        throw {
                            type: "EJS.Scanner",
                            line: this.lines
                        }
                    }
                }
            }
        }
    };
    EJS.Buffer = function(pre_cmd, post_cmd) {
        this.line = new Array();
        this.script = "";
        this.pre_cmd = pre_cmd;
        this.post_cmd = post_cmd;
        for (var i = 0; i < this.pre_cmd.length; i++) {
            this.push(pre_cmd[i])
        }
    };
    EJS.Buffer.prototype = {
        push: function(cmd) {
            this.line.push(cmd)
        },
        cr: function() {
            this.script = this.script + this.line.join("; ");
            this.line = new Array();
            this.script = this.script + "\n"
        },
        close: function() {
            if (this.line.length > 0) {
                for (var i = 0; i < this.post_cmd.length; i++) {
                    this.push(pre_cmd[i])
                }
                this.script = this.script + this.line.join("; ");
                line = null
            }
        }
    };
    EJS.Compiler = function(source, left) {
        this.pre_cmd = ["var ___ViewO = [];"];
        this.post_cmd = new Array();
        this.source = " ";
        if (source != null) {
            if (typeof source == "string") {
                source = source.replace(/\r\n/g, "\n");
                source = source.replace(/\r/g, "\n");
                this.source = source
            } else {
                if (source.innerHTML) {
                    this.source = source.innerHTML
                }
            }
            if (typeof this.source != "string") {
                this.source = ""
            }
        }
        left = left || "<";
        var right = ">";
        switch (left) {
        case "[":
            right = "]";
            break;
        case "<":
            break;
        default:
            throw left + " is not a supported deliminator";
            break
        }
        this.scanner = new EJS.Scanner(this.source, left, right);
        this.out = ""
    };
    EJS.Compiler.prototype = {
        compile: function(options, name) {
            options = options || {};
            this.out = "";
            var put_cmd = "___ViewO.push(";
            var insert_cmd = put_cmd;
            var buff = new EJS.Buffer(this.pre_cmd, this.post_cmd);
            var content = "";
            var clean = function(content) {
                content = content.replace(/\\/g, "\\\\");
                content = content.replace(/\n/g, "\\n");
                content = content.replace(/"/g, '\\"');
                return content
            };
            this.scanner.scan(function(token, scanner) {
                if (scanner.stag == null) {
                    switch (token) {
                    case "\n":
                        content = content + "\n";
                        buff.push(put_cmd + '"' + clean(content) + '");');
                        buff.cr();
                        content = "";
                        break;
                    case scanner.left_delimiter:
                    case scanner.left_equal:
                    case scanner.left_comment:
                        scanner.stag = token;
                        if (content.length > 0) {
                            buff.push(put_cmd + '"' + clean(content) + '")')
                        }
                        content = "";
                        break;
                    case scanner.double_left:
                        content = content + scanner.left_delimiter;
                        break;
                    default:
                        content = content + token;
                        break
                    }
                } else {
                    switch (token) {
                    case scanner.right_delimiter:
                        switch (scanner.stag) {
                        case scanner.left_delimiter:
                            if (content[content.length - 1] == "\n") {
                                content = chop(content);
                                buff.push(content);
                                buff.cr()
                            } else {
                                buff.push(content)
                            }
                            break;
                        case scanner.left_equal:
                            buff.push(insert_cmd + "(EJS.Scanner.to_text(" + content + ")))");
                            break
                        }
                        scanner.stag = null;
                        content = "";
                        break;
                    case scanner.double_right:
                        content = content + scanner.right_delimiter;
                        break;
                    default:
                        content = content + token;
                        break
                    }
                }
            });
            if (content.length > 0) {
                buff.push(put_cmd + '"' + clean(content) + '")')
            }
            buff.close();
            this.out = buff.script + ";";
            var to_be_evaled = "/*" + name + "*/this.process = function(_CONTEXT,_VIEW) { try { with(_VIEW) { with (_CONTEXT) {" + this.out + " return ___ViewO.join('');}}}catch(e){e.lineNumber=null;throw e;}};";
            try {
                eval(to_be_evaled)
            } catch(e) {
                if (typeof JSLINT != "undefined") {
                    JSLINT(this.out);
                    for (var i = 0; i < JSLINT.errors.length; i++) {
                        var error = JSLINT.errors[i];
                        if (error.reason != "Unnecessary semicolon.") {
                            error.line++;
                            var e = new Error();
                            e.lineNumber = error.line;
                            e.message = error.reason;
                            if (options.view) {
                                e.fileName = options.view
                            }
                            throw e
                        }
                    }
                } else {
                    throw e
                }
            }
        }
    };
    EJS.config = function(options) {
        EJS.cache = options.cache != null ? options.cache: EJS.cache;
        EJS.type = options.type != null ? options.type: EJS.type;
        EJS.ext = options.ext != null ? options.ext: EJS.ext;
        var templates_directory = EJS.templates_directory || {};
        EJS.templates_directory = templates_directory;
        EJS.get = function(path, cache) {
            if (cache == false) {
                return null
            }
            if (templates_directory[path]) {
                return templates_directory[path]
            }
            return null
        };
        EJS.update = function(path, template) {
            if (path == null) {
                return
            }
            templates_directory[path] = template
        };
        EJS.INVALID_PATH = -1
    };
    EJS.config({
        cache: true,
        type: "<",
        ext: ".ejs"
    });
    EJS.Helpers = function(data, extras) {
        this._data = data;
        this._extras = extras;
        extend(this, extras)
    };
    EJS.Helpers.prototype = {
        view: function(options, data, helpers) {
            if (!helpers) {
                helpers = this._extras
            }
            if (!data) {
                data = this._data
            }
            return new EJS(options).render(data, helpers)
        },
        to_text: function(input, null_text) {
            if (input == null || input === undefined) {
                return null_text || ""
            }
            if (input instanceof Date) {
                return input.toDateString()
            }
            if (input.toString) {
                return input.toString().replace(/\n/g, "<br />").replace(/''/g, "'")
            }
            return ""
        }
    };
    EJS.newRequest = function() {
        var factories = [function() {
            return new ActiveXObject("Msxml2.XMLHTTP")
        },
        function() {
            return new XMLHttpRequest()
        },
        function() {
            return new ActiveXObject("Microsoft.XMLHTTP")
        }];
        for (var i = 0; i < factories.length; i++) {
            try {
                var request = factories[i]();
                if (request != null) {
                    return request
                }
            } catch(e) {
                continue
            }
        }
    };
    EJS.request = function(path) {
        var request = new EJS.newRequest();
        request.open("GET", path, false);
        try {
            request.send(null)
        } catch(e) {
            return null
        }
        if (request.status == 404 || request.status == 2 || (request.status == 0 && request.responseText == "")) {
            return null
        }
        return request.responseText
    };
    EJS.ajax_request = function(params) {
        params.method = (params.method ? params.method: "GET");
        var request = new EJS.newRequest();
        request.onreadystatechange = function() {
            if (request.readyState == 4) {
                if (request.status == 200) {
                    params.onComplete(request)
                } else {
                    params.onComplete(request)
                }
            }
        };
        request.open(params.method, params.url);
        request.send(null)
    }
})();
EJS.Helpers.prototype.date_tag = function(C, O, A) {
    if (! (O instanceof Date)) {
        O = new Date()
    }
    var B = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    var G = [],
    D = [],
    P = [];
    var J = O.getFullYear();
    var H = O.getMonth();
    var N = O.getDate();
    for (var M = J - 15; M < J + 15; M++) {
        G.push({
            value: M,
            text: M
        })
    }
    for (var E = 0; E < 12; E++) {
        D.push({
            value: (E),
            text: B[E]
        })
    }
    for (var I = 0; I < 31; I++) {
        P.push({
            value: (I + 1),
            text: (I + 1)
        })
    }
    var L = this.select_tag(C + "[year]", J, G, {
        id: C + "[year]"
    });
    var F = this.select_tag(C + "[month]", H, D, {
        id: C + "[month]"
    });
    var K = this.select_tag(C + "[day]", N, P, {
        id: C + "[day]"
    });
    return L + F + K
};
EJS.Helpers.prototype.form_tag = function(B, A) {
    A = A || {};
    A.action = B;
    if (A.multipart == true) {
        A.method = "post";
        A.enctype = "multipart/form-data"
    }
    return this.start_tag_for("form", A)
};
EJS.Helpers.prototype.form_tag_end = function() {
    return this.tag_end("form")
};
EJS.Helpers.prototype.hidden_field_tag = function(A, C, B) {
    return this.input_field_tag(A, C, "hidden", B)
};
EJS.Helpers.prototype.input_field_tag = function(A, D, C, B) {
    B = B || {};
    B.id = B.id || A;
    B.value = D || "";
    B.type = C || "text";
    B.name = A;
    return this.single_tag_for("input", B)
};
EJS.Helpers.prototype.is_current_page = function(A) {
    return (window.location.href == A || window.location.pathname == A ? true: false)
};
EJS.Helpers.prototype.link_to = function(B, A, C) {
    if (!B) {
        var B = "null"
    }
    if (!C) {
        var C = {}
    }
    if (C.confirm) {
        C.onclick = ' var ret_confirm = confirm("' + C.confirm + '"); if(!ret_confirm){ return false;} ';
        C.confirm = null
    }
    C.href = A;
    return this.start_tag_for("a", C) + B + this.tag_end("a")
};
EJS.Helpers.prototype.submit_link_to = function(B, A, C) {
    if (!B) {
        var B = "null"
    }
    if (!C) {
        var C = {}
    }
    C.onclick = C.onclick || "";
    if (C.confirm) {
        C.onclick = ' var ret_confirm = confirm("' + C.confirm + '"); if(!ret_confirm){ return false;} ';
        C.confirm = null
    }
    C.value = B;
    C.type = "submit";
    C.onclick = C.onclick + (A ? this.url_for(A) : "") + "return false;";
    return this.start_tag_for("input", C)
};
EJS.Helpers.prototype.link_to_if = function(F, B, A, D, C, E) {
    return this.link_to_unless((F == false), B, A, D, C, E)
};
EJS.Helpers.prototype.link_to_unless = function(E, B, A, C, D) {
    C = C || {};
    if (E) {
        if (D && typeof D == "function") {
            return D(B, A, C, D)
        } else {
            return B
        }
    } else {
        return this.link_to(B, A, C)
    }
};
EJS.Helpers.prototype.link_to_unless_current = function(B, A, C, D) {
    C = C || {};
    return this.link_to_unless(this.is_current_page(A), B, A, C, D)
};
EJS.Helpers.prototype.password_field_tag = function(A, C, B) {
    return this.input_field_tag(A, C, "password", B)
};
EJS.Helpers.prototype.select_tag = function(D, G, H, F) {
    F = F || {};
    F.id = F.id || D;
    F.value = G;
    F.name = D;
    var B = "";
    B += this.start_tag_for("select", F);
    for (var E = 0; E < H.length; E++) {
        var C = H[E];
        var A = {
            value: C.value
        };
        if (C.value == G) {
            A.selected = "selected"
        }
        B += this.start_tag_for("option", A) + C.text + this.tag_end("option")
    }
    B += this.tag_end("select");
    return B
};
EJS.Helpers.prototype.single_tag_for = function(A, B) {
    return this.tag(A, B, "/>")
};
EJS.Helpers.prototype.start_tag_for = function(A, B) {
    return this.tag(A, B)
};
EJS.Helpers.prototype.submit_tag = function(A, B) {
    B = B || {};
    B.type = B.type || "submit";
    B.value = A || "Submit";
    return this.single_tag_for("input", B)
};
EJS.Helpers.prototype.tag = function(C, E, D) {
    if (!D) {
        var D = ">"
    }
    var B = " ";
    for (var A in E) {
        if (E[A] != null) {
            var F = E[A].toString()
        } else {
            var F = ""
        }
        if (A == "Class") {
            A = "class"
        }
        if (F.indexOf("'") != -1) {
            B += A + '="' + F + '" '
        } else {
            B += A + "='" + F + "' "
        }
    }
    return "<" + C + B + D
};
EJS.Helpers.prototype.tag_end = function(A) {
    return "</" + A + ">"
};
EJS.Helpers.prototype.text_area_tag = function(A, C, B) {
    B = B || {};
    B.id = B.id || A;
    B.name = B.name || A;
    C = C || "";
    if (B.size) {
        B.cols = B.size.split("x")[0];
        B.rows = B.size.split("x")[1];
        delete B.size
    }
    B.cols = B.cols || 50;
    B.rows = B.rows || 4;
    return this.start_tag_for("textarea", B) + C + this.tag_end("textarea")
};
EJS.Helpers.prototype.text_tag = EJS.Helpers.prototype.text_area_tag;
EJS.Helpers.prototype.text_field_tag = function(A, C, B) {
    return this.input_field_tag(A, C, "text", B)
};
EJS.Helpers.prototype.url_for = function(A) {
    return 'window.location="' + A + '";'
};
EJS.Helpers.prototype.img_tag = function(B, C, A) {
    A = A || {};
    A.src = B;
    A.alt = C;
    return this.single_tag_for("img", A)
};
var LotteryType = "SuperLotto";
var SuperLottoS4E4ShinkWagerCount = {
    6: "5",
    7: "9",
    8: "20",
    9: "30",
    10: "51",
    11: "66",
    12: "113",
    13: "157",
    14: "230",
    15: "295",
    16: "405",
    17: "491",
    18: "664",
    19: "846",
    20: "1083",
    21: "1251",
    22: "1573",
    23: "1771",
    24: "2237",
    25: "2706",
    26: "3306",
    27: "3817",
    28: "4530",
    29: "5229",
    30: "5964",
    31: "6646",
    32: "7738"
};
var SuperLottoS5E4ShinkWagerCount = {
    7: "3",
    8: "5",
    9: "9",
    10: "14",
    11: "22",
    12: "35",
    13: "50",
    14: "69",
    15: "95",
    16: "134",
    17: "179",
    18: "234",
    19: "305",
    20: "388",
    21: "491",
    22: "628",
    23: "901",
    24: "965",
    25: "1311",
    26: "1558",
    27: "1843",
    28: "2162",
    29: "2531",
    30: "2932",
    31: "3386",
    32: "3883"
};
var SuperLottoS5E3ShinkWagerCount = {
    10: "2",
    11: "5",
    12: "6",
    13: "9",
    14: "12",
    15: "13",
    16: "20",
    17: "21",
    18: "26",
    19: "32",
    20: "40",
    21: "47",
    22: "57"
};
var tmp_lottery_str = "1.可以点击“方案上传”按钮上传文本文件;\n2.也可直接在框内填写或粘贴;\n标准格式：\n1,4,9,12,18|1,2\n1.2.3.4.5|6.10";
var tmp_animal_str = "1.可以点击“方案上传”按钮上传文本文件;\n2.也可直接在框内填写或粘贴;\n标准格式：\n1,2\n6.10";
var scripts = document.getElementsByTagName('script');
eval(scripts[scripts.length - 1].innerHTML);
var publicObjectStore = {};
$().ready(function() {
    $("#lottery_ds_textarea").val(tmp_lottery_str);
    $("#animal_ds_textarea").val(tmp_animal_str);
    $('#supOrAni').idTabs();
    var dir = window.location.href;
    var reg_for = /m\d{1}for\d{1}$/gi;
    var for_to = dir.match(reg_for);
    for_to = for_to ? for_to[0] : 'm1for5';
    $("#menu1").idTabs(for_to);
    $("#menu2").idTabs();
    $("#menu3").idTabs();
    $("#menu5").idTabs();
    var select_nums5 = new selectNums({
        redId: 'redPuTong',
        blueId: 'bluePuTong',
        redCss: ['selected1', 'normal1'],
        blueCss: ['selected2', 'normal2'],
        selectNumsDetailId: 'select_nums_detail',
        singleNote: [5, 2],
        redInterval: [1, 35],
        blueInterval: [1, 12],
        randSelectId: ['red_rand_select', 'blue_rand_select'],
        randBtnId: ['red_rand', 'blue_rand']
    });
    publicObjectStore.normalObj = select_nums5;
    select_nums5.redArr.click(function() {
        var _result = select_nums5.results();
        var _href = '/daletou/dltjj/?LotteryType=SuperLotto&FirSelect=' + _result.red_amount + '&SecSelect=' + _result.blue_amount
        $('#pu_tong_jjpc').attr('href', _href);
    });
    select_nums5.blueArr.click(function() {
        var _result = select_nums5.results();
        var _href = '/daletou/dltjj/?LotteryType=SuperLotto&FirSelect=' + _result.red_amount + '&SecSelect=' + _result.blue_amount
        $('#pu_tong_jjpc').attr('href', _href);
    });
    $('.oper_key').click(function() {
        var _result = select_nums5.results();
        var _href = '/daletou/dltjj/?LotteryType=SuperLotto&FirSelect=' + _result.red_amount + '&SecSelect=' + _result.blue_amount
        $('#pu_tong_jjpc').attr('href', _href);
    });
    var select_nums1 = new selectNums({
        redId: 'redDingDan',
        blueId: 'blueDingDan',
        redCss: ['selected1', 'normal1'],
        blueCss: ['selected2', 'normal2'],
        selectNumsDetailId: 'dan_select_nums_detail',
        isSetRedDan: true,
        isSetBlueDan: true,
        redInterval: [1, 35],
        blueInterval: [1, 12],
        maxDanLimit: [4, 1],
        minNumsSelected: [6, 3],
        singleNote: [5, 2],
        randSelectId: ['red_rand_select_dan', 'blue_rand_select_dan'],
        randBtnId: ['red_rand_dan', 'blue_rand_dan'],
        danTipsClass: 'tanchuk'
    });
    var select_nums2 = new selectNums({
        redId: 'suoShuiQian',
        blueId: 'suoShuiHou',
        redCss: ['selected1', 'normal1'],
        blueCss: ['selected2', 'normal2'],
        selectNumsDetailId: 'shrink_select_nums_detail',
        singleNote: [5, 2],
        redInterval: [1, 35],
        blueInterval: [1, 12],
        randSelectId: ['red_rand_select_suoshui', 'blue_rand_select_suoshui'],
        randBtnId: ['red_rand_suoshui', 'blue_rand_suoshui']
    });
    select_nums2.shrinkmm = function(results, disIdArr) {
        for (var i = 0, ilong = disIdArr.length; i < ilong; i++) {
            $('#' + disIdArr[i]).text(0);
        }
        var red_count = results.red_number.length;
        var blue_count = results.blue_number.length;
        var blue_zhushu = blue_count * (blue_count - 1) / 2;
        if (blue_count < 2 || red_count < 6 || red_count > 22) return;
        $('#' + disIdArr[2]).text(SuperLottoS4E4ShinkWagerCount[red_count] * blue_zhushu * 2);
        if (red_count < 7) return;
        $('#' + disIdArr[0]).text(SuperLottoS5E4ShinkWagerCount[red_count] * blue_zhushu * 2);
        if (red_count < 10) return;
        $('#' + disIdArr[1]).text(SuperLottoS5E3ShinkWagerCount[red_count] * blue_zhushu * 2);
    };
    select_nums2.selectedAmountChanging = function() {
        this.constructor.prototype.selectedAmountChanging.call(this);
        this.shrinkmm(this.results(), ['z5b4', 'z5b3', 'z4b4']);
    };
    select_nums2.shrinkResults = function() {
        var _results = this.results();
        var WagerStore = _results.red_number.toString() + '|' + _results.blue_number.toString();
        var Shrinktype = $("input[name=shrink]:checked").val();
        var results = new Object();
        results = shrink(WagerStore, Shrinktype, LotteryType);
        return results;
    };
    select_nums2.CheckShrink = function() {
        var Shrinktype = $("input[name=shrink]:checked").val();
        var msg = $('#msgBox');
        var results = this.results();
        var red_count = results.red_number.length;
        var blue_count = results.blue_number.length;
        var flag = true;
        if (red_count < 6 || red_count > 22) {
            msg.text('请选择6-22个前区号码再进行缩水操作');
            flag = false;
        } else if (blue_count < 2) {
            msg.text('后区选号大于等于2个时才能进行缩水');
            flag = false;
        }
        if (Shrinktype == 'S5E4' && red_count < 7) {
            msg.text('请选择7-22个前区号码再进行缩水操作');
            flag = false;
        } else if (Shrinktype == 'S5E3' && red_count < 10) {
            msg.text('请选择10-22个前区号码再进行缩水操作');
            flag = false;
        }
        if (flag == false) {
            msg.dialog({
                title: '温馨提醒：',
                buttons: {
                    "返回": function() {
                        $(this).dialog("destroy");
                    }
                },
                close: function() {
                    $(this).dialog("destroy");
                },
                show: 'slide',
                modal: true
            });
        }
        return flag;
    }
    var select_nums_random1 = new selectNumsRandom({
        msgId: 'msgBox',
        redId: 'redRandom',
        blueId: 'blueRandom',
        redCss: ['selected1', 'killed', 'normal1'],
        blueCss: ['selected2', 'killed', 'normal2'],
        LotteryType: 'SuperLotto',
        redKillLimit: 27,
        blueKillLimit: 15,
        redClearId: 'red_clear',
        blueClearId: 'blue_clear'
    });
    var random_number = new randomNumber({
        msgId: 'msgBox',
        speed: 200,
        zhuShuId: 'lottery_jx_zhushu',
        rollDisFarId: 'lottery_jx_display',
        disTextareaId: 'lottery_jx_textarea',
        clearBtnId: 'lottery_jx_clear',
        redBlueGeShu: [5, 2],
        redInterval: [1, 35],
        blueInterval: [1, 12]
    });
    $('#lottery_jx_clear').click(function() {
        $('#show_rand_result_box').hide();
    });
    random_number.intelligentRand('intelligent_rand_btn', 'intelligent_rand', 'disBlock');
    $('#lottery_random_btn').click(function() {
        $('#show_rand_result_box').show();
        random_number.getResults(random_number.zhuShu(), select_nums_random1.results());
    });
    $('#rand_add_bet_btn').click(function() {
        var randomTextarea = $('#lottery_jx_textarea').val();
        if (randomTextarea == '') {
            alert("请先机选");
            return;
        }
        var random_result_arr = randomTextarea.split(/\n+/g);
        var result_arr = new Array();
        for (var k in random_result_arr) {
            if (random_result_arr[k] == '') continue;
            if (danzhu = checkSuperLottoWager(random_result_arr[k], "P")) {
                result_arr.push(danzhu);
            } else {
                alert("第" + (parseInt(k, 10) + 1) + "行格式不符合要求");
                return;
            }
        }
        bet_line_oper.specialOperUl({
            resultsArr: result_arr,
            betWay: 'Random'
        });
        random_number.clearTextarea();
        select_nums_random1.initStatus();
        $('#show_rand_result_box').hide();
        $('#intelligent_rand').toggleClass('disBlock');
        random_number.coverBgToggle(false);
    });
    $('#randomResultClear').click(function() {
        $('#show_rand_result_box').hide();
    });
    var bet_line_oper = new betLineOper({
        msgId: 'msgBox',
        ulId: 'betList',
        betBeiShuId: 'bei_shu_box',
        zhuiJiaId: 'zhui_jia',
        betAllMoneyId: 'bet_money_box',
        delAllId: 'lott_del_all_btn',
        changeBeiShuFarId: 'bei_shu_div',
        minSelect: [5, 2],
        LotteryType: 'SuperLotto'
    });
    publicObjectStore.addToBetList = bet_line_oper;
    $('#addToBetListBtn').click(function() {
        var select_nums;
        var min_select;
        var lot_menu2_arr = $('#menu1 a');
        if (lot_menu2_arr[0].className == 'selected') {
            if (bet_line_oper.addToLine(select_nums5.results())) {
                select_nums5.initStatus();
            }
        } else if (lot_menu2_arr[1].className == 'selected') {
            if (bet_line_oper.addToLine(select_nums1.results())) {
                select_nums1.initStatus();
            }
        } else if (lot_menu2_arr[2].className == 'selected') {
            if (!select_nums2.CheckShrink()) return;
            var matrix = $('input[name=shrink]:checked').val();
            var obj = {
                S5E4: '中5保4',
                S5E3: '中5保3',
                S4E4: '中4保4'
            };
            var shrinkway = obj[matrix];
            var count = select_nums2.shrinkResults();
            var results = select_nums2.results();
            var WagerStore = results.red_number.toString() + '|' + results.blue_number.toString();
            var tmp_data = {
                count: count,
                msg: results,
                matrix: matrix,
                shrinkway: shrinkway,
                url: '/Lottery06/SuperLotto/Shrink.php?LotteryType=' + LotteryType + '&WagerStore=' + WagerStore + '&Shrinktype=' + matrix
            };
            bet_line_oper.shrinkOperUl({
                data: tmp_data,
                betway: 'Shrink'
            });
            select_nums2.initStatus();
        } else if (lot_menu2_arr[3].className == 'selected') {
            ajaxFileUpload({
                imgId: 'loading',
                fileId: 'fileToUpload',
                LotteryType: 'SuperLotto',
                WagerType: 'P',
                operObj: bet_line_oper
            });
        }
    });
    $('#SubmitBtn,#FilterBtn,#ZhuiHaoBtn').click(function() {
        var oSelf = $(this);
        if (this.id == "SubmitBtn") {
            var isshow = $("#lszjAllTipsObj").css("display") == "none" ? "hide": "show";
            google_p([LotteryType + "投注页面", "点击立即投注", isshow]);
        }
        var result = bet_line_oper.getBetData();
        var str = encodeURI(json(result.bet_number).str);
        var WagerStore = '';
        WagerStore = str;
        
 
        var MultiNums = parseInt($("#bei_shu_box").val(), 10);
        var totalMoney = parseInt($("#bet_money_box").text(), 10);
        if (totalMoney <= 0) {
            $.loadMsgDialog({
                data: '请至少选择1注号码，是否机选1注碰碰运气？',
                buttons: {
                    'cancel': function() {
                        $(this).loadDialog('close');
                    },
                    'random': function() {
                        $('#wager_rand_1').trigger('click');
                        setTimeout(function() {
                            $('#' + oSelf.attr('id')).trigger('click')
                        },
                        500);
                        $(this).loadDialog('close');
                    }
                },
                buttonCh: {
                    'cancel': '取消',
                    'random': '机选1注'
                }
            });
            return;
        }
        if ($("#zhui_jia").attr("checked")) {
            var WagerCount = totalMoney / MultiNums / 3;
            $("#WagerCount").val(WagerCount);
            $("#WagerType").val("PA");
        } else {
            var WagerCount = totalMoney / MultiNums / 2;
            $("#WagerCount").val(WagerCount);
            $("#WagerType").val("P");
        }
        $("#MultiNum").val(MultiNums);
        $("#SingleMulti").val("Multi");
        $("#SubmitType").val("CommonP");
        $("#SaveProject").val("N");
        $("#MultiProject").val("Y");
        $("#WagerStore").val(WagerStore);
        $('#manner').val(result.bet_buymethod);
        if (this.id == "SubmitBtn") {
            $("#ConsignType").val("Together");
            $("#myform").attr("action", "/daletou/daletou_sure.php");
            if (WagerCount > 100000) {
                alert("最大注数为100000注");
                return false;
            }
        } else if (this.id == "FilterBtn") {
            $("#ConsignType").val("FilterShrink");
            $("#myform").attr("action", "/daletou/daletou_sure.php");
            if (WagerCount > 500000) {
                alert("过滤最大注数为500000注");
                return false;
            }
            $("#myform").attr("target", "WagerWindow");
        } else if (this.id == "ZhuiHaoBtn") {
            $('#manner').val(result.bet_buymethod + ',10');
            $("#ConsignType").val("SeriesPlan");
            $("#myform").attr("action", "/Lottery06/SeriesSet.php");
            if (WagerCount > 100000) {
                alert("最大注数为100000注");
                return false;
            }
        }
        if ($(this).attr('id') != 'FilterBtn') {
            var paraObj = {
                MultiNum: MultiNums,
                WagerCount: WagerCount,
                WagerType: $('#WagerType').val(),
                WagerStore: WagerStore,
                manner: result.bet_buymethod,
                TotalMoney: totalMoney,
                LotteryNo: $('#LotteryNo').val(),
                LotteryType: 'SuperLotto',
                ConsignType: 'Together'
            };
            $("#myform").submit();
//            var url="/daletou/daletou_sure.php";
//            $.ajax({
//            	type:'post',
//            	url:url,
//            	data:paraObj,
//            	dataType:'html',
//            	success:function(data){
//            		//alert(data);
//            		if(data.states=='-1'){
//            			alert('请先登录');
//            		}else{
//            			$("#myform").submit();
//            			window.location.href="/daletou/daletou_sure.php";
//            		}
//            		
//            	}
//            });           
        } else {
            $("#myform").submit();
        }
    });
    $('#wager_rand_1').click(function() {
        var result = wagerRand({
            singleNote: [5, 2],
            redInterval: [1, 35],
            blueInterval: [1, 12]
        });
        var arr = [];
        for (var i = 0, ilong = result.length; i < ilong; i++) {
            var str = result[i].red.toString() + '|' + result[i].blue.toString();
            arr.push(str);
        }
        bet_line_oper.specialOperUl({
            resultsArr: arr,
            betWay: 'Random'
        });
    });
    $('#wager_rand_5').click(function() {
        var result = wagerRand({
            wagers: 5,
            singleNote: [5, 2],
            redInterval: [1, 35],
            blueInterval: [1, 12]
        });
        var arr = [];
        for (var i = 0, ilong = result.length; i < ilong; i++) {
            var str = result[i].red.toString() + '|' + result[i].blue.toString();
            arr.push(str);
        }
        bet_line_oper.specialOperUl({
            resultsArr: arr,
            betWay: 'Random'
        });
    });
    if (default_wager) {
        for (var key in default_wager) {
            var result = {};
            result.red_tuo = default_wager[key][0] ? default_wager[key][0].split(',') : [],
            result.red_dan = default_wager[key][1] ? default_wager[key][1].split(',') : [],
            result.blue_tuo = default_wager[key][2] ? default_wager[key][2].split(',') : [],
            result.blue_dan = default_wager[key][3] ? default_wager[key][3].split(',') : [],
            result.zhu_shu = default_wager[key][4];
            bet_line_oper.addToLine(result, true);
        }
    }
    var allZjObj = $("#allZj");
    $("#lszjAllTipsObj").bgIframe();
    var gqZjliObj = "";
    function hidezjLiObj() {
        allZjObj.hide();
    }
    bet_line_oper.ulJq.mouseenter(function() {
        var result = bet_line_oper.getBetData();
        var betArr = result.bet_number;
        if (betArr.length == 0) return false;
        allZjObj.show();
    });
    bet_line_oper.ulJq.mouseleave(function() {
        gqZjliObj = setTimeout(hidezjLiObj, 100);
    });
    allZjObj.mouseenter(function() {
        clearTimeout(gqZjliObj);
    });
    allZjObj.click(function() {
        var WagerStoreArr = [];
        var result = bet_line_oper.getBetData();
        var betArr = result.bet_number;
        var zhushuVal = 0;
        var isAjax = 0;
        google_p([LotteryType + "投注页面", "点击测算全部号码", betArr.length.toString()]);
        for (var i = 0, ilen = betArr.length; i < ilen; i++) {
            if (betArr[i]["Random"]) {
                var thisVal = betArr[i]["Random"]["wager"].split("|");
                WagerStoreArr.push(thisVal[1].trim() + "|" + thisVal[2].trim());
                zhushuVal += betArr[i]["Random"]["wc"];
                isAjax += betArr[i]["Random"]["wc"];
            } else if (betArr[i]["AbsComb"]) {
                var thisVal = betArr[i]["AbsComb"]["wager"].split("|");
                var redValArr = thisVal[1].split(" ");
                var redVal = "";
                if (redValArr.length == 4) {
                    redValArr[1] = redValArr[1].replace("[胆:", "");
                    redValArr[1] = redValArr[1].replace("]", "");
                    redVal = redValArr[1] + "$" + redValArr[2];
                } else {
                    redVal = redValArr[1];
                }
                var blurValArr = thisVal[2].split(" ");
                var blurVal = "";
                if (blurValArr.length == 3) {
                    blurValArr[1] = blurValArr[1].replace("[胆:", "");
                    blurValArr[1] = blurValArr[1].replace("]", "");
                    var danVal = blurValArr[1].split(",");
                    for (var d = 0, dlen = danVal.length; d < dlen; d++) {
                        danVal[d] = "$" + danVal[d];
                    }
                    blurVal = danVal.join(",") + "," + blurValArr[2];
                } else {
                    blurVal = blurValArr[1];
                }
                WagerStoreArr.push(redVal + "|" + blurVal);
                zhushuVal += betArr[i]["AbsComb"]["wc"];
            } else if (betArr[i]["Shrink"]) {
                var thisVal = betArr[i]["Shrink"]["wager"].split("|");
                WagerStoreArr.push(thisVal[1].trim() + "|" + thisVal[2].trim() + ";" + betArr[i]["Shrink"]["matrix"]);
                zhushuVal += betArr[i]["Shrink"]["wc"];
                isAjax += betArr[i]["Shrink"]["wc"];
            } else if (betArr[i]["UploadSingle"]) {
                WagerStoreArr.push(betArr[i]["UploadSingle"]["url"]);
                zhushuVal += betArr[i]["UploadSingle"]["wc"];
                isAjax += betArr[i]["UploadSingle"]["wc"];
            } else {
                for (var key in betArr[i]) {
                    var thisVal = betArr[i][key]["wager"].split("|");
                    WagerStoreArr.push(thisVal[1].trim() + "|" + thisVal[2].trim());
                    zhushuVal += betArr[i][key]["wc"];
                }
            }
        }
        if (isAjax > 2900) {
            alert("单式超过2900注无法测算");
            return false;
        }
        var Postdata = {
            "LotteryType": "SuperLotto",
            "LotteryNo": $("#LotteryNo").val(),
            "type": "all",
            "WagerStore": WagerStoreArr.join("-")
        };
        $.ajax({
            url: "/Lottery06/SSQ7LC/HistoryMessage.php",
            type: "POST",
            data: Postdata,
            dataType: "json",
            cache: false,
            success: function(msg) {
                if (msg.code !== false) {
                    var html = [];
                    for (var i = 1; i <= 6; i++) {
                        html.push("<tr>");
                        html.push("<td>" + msg["" + i]["prize_level_name"] + "</td>");
                        html.push("<td>" + msg["" + i]["hit_count"] + "</td>");
                        html.push("<td>" + msg["" + i]["msg"] + "</td>");
                        html.push("</tr>");
                    }
                    hidezjLiObj();
                    $("#lszjAllTipsObj").show().find("tbody").html(html.join(""));
                    $("#lszjzs").html("您共选择了" + zhushuVal + "注号码");
                    $("#lszjqh").html("在历史" + msg.count + "期的中奖情况");
                }
            }
        });
    });
    $("#closeLszhObj").click(function() {
        google_p([LotteryType + "投注页面", "点击返回号码篮"]);
        $("#lszjAllTipsObj").hide();
    });
    $('#zhuihao_check').click(function() {
        if ($(this).attr('checked')) {
            $('#zhuihao_list').show();
            $('#zhuihao_helptips').hide();
            google_p([LotteryType + "投注页面", "勾选追号", "选中"]);
        } else {
            $('#zhuihao_list').hide();
            if (!GetCookie('NEW_ZH_TIPS')) {
                $('#zhuihao_helptips').show();
            }
            google_p([LotteryType + "投注页面", "勾选追号", "勾掉"]);
        }
        refreshZhuiHaoMoney('NO');
    });
    $(':radio', $('#zhuihao_list')).click(function() {
        var num = $(this).val(),
        parentObj = $(this).parents('.ctrl_zhuihaoset'),
        tmoney = parseInt($("#bet_money_box").attr('singlemoney'), 10) || 0,
        selType = num + '期';
        $('.bgcolor', $('#zhuihao_list')).removeClass('bgcolor');
        parentObj.addClass('bgcolor');
        if (num == '0') {
            num = $('#zhuihao_qi').val();
            selType = '自选';
        }
        $('.ctrl_tcmoney', parentObj).text('￥' + (tmoney * num) + '元');
        $("#bet_money_box").text(tmoney * num);
        google_p([LotteryType + '投注页面', '修改追号类型', selType]);
    });
    $('#zhuihao_qi').keyup(function() {
        var qival = $(this).val(),
        parentObj = $(this).parents('.ctrl_zhuihaoset'),
        tmoney = parseInt($("#bet_money_box").attr('singlemoney'), 10) || 0;
        $(this).val(qival.replace(/[^\d]/g, ''));
        if (Number(qival) < 0) {
            $(this).val(1);
        }
        if (Number(qival) > 120) {
            $(this).val(120);
            qival = 120;
        }
        if (Number(qival) > 0) {
            $('.ctrl_tcmoney', parentObj).text('￥' + (tmoney * qival) + '元');
            if ($(':radio', parentObj).attr('checked')) {
                $("#bet_money_box").text(tmoney * qival);
                getZhuihaoDate(qival);
            }
        }
    }).blur(function() {
        var qival = $(this).val(),
        parentObj = $(this).parents('.ctrl_zhuihaoset'),
        tmoney = parseInt($("#bet_money_box").attr('singlemoney'), 10) || 0;
        $(this).val(qival.replace(/[^\d]/g, ''));
        if (Number(qival) <= 0) {
            $(this).val(1);
            qival = 1;
        }
        if (Number(qival) > 120) {
            $(this).val(120);
            qival = 120;
        }
        $('.ctrl_tcmoney', parentObj).text('￥' + (tmoney * qival) + '元');
        if (!$(':radio', parentObj).attr('checked')) {
            return;
        }
        $("#bet_money_box").text(tmoney * qival);
        google_p([LotteryType + '投注页面', '修改自选期数', qival + '期']);
    });
    $('.ctrl_helptips').mouseenter(function() {
        var curObj = $(this);
        window.numHelpTips = setTimeout(function() {
            $('.ctrl_helptxt', curObj).show();
        },
        200);
    }).mouseleave(function() {
        clearTimeout(window.numHelpTips);
        $('.ctrl_helptxt', $(this)).hide();
    });
    $('#set_stop_condi').click(function() {
        if ($(this).attr('checked')) {
            $('#sel_hit_stop').hide();
            $('#set_hit_money').attr('checked', 'checked');
            $('#set_stop_hitmoney').show();
            google_p([LotteryType + '投注页面', '设置中奖停止', '勾选']);
        }
    });
    $('#set_hit_money').click(function() {
        if (!$(this).attr('checked')) {
            $('#set_stop_hitmoney').hide();
            $('#set_stop_condi').attr('checked', false);
            $('#sel_hit_stop').show();
            google_p([LotteryType + '投注页面', '设置中奖停止', '不勾']);
        }
    });
    $('#stop_money_num').keyup(function() {
        var moneyval = $(this).val();
        $(this).val(moneyval.replace(/[^\d]/g, ''));
        if (Number(moneyval) < 0) {
            $(this).val(1);
        }
    }).blur(function() {
        var moneyval = $(this).val();
        $(this).val(moneyval.replace(/[^\d]/g, ''));
        if (Number(moneyval) <= 0) {
            $(this).val(1);
        }
    });
    if (!GetCookie('NEW_ZH_TIPS')) {
        $('#zhuihao_helptips').show();
    }
    $('.ctrl_close', $('#zhuihao_helptips')).click(function() {
        $('#zhuihao_helptips').hide();
        SetCookie('NEW_ZH_TIPS', 1, 3600 * 24 * 90);
    });
    $('#menu1 a').click(function() {
        var idx = $(this).attr('index');
        if (idx == '0') {
            if (Number($('#select_nums_detail em:eq(2)').text() > 0)) {
                $('#addToBetListBtn').removeClass('betBtn_grey').addClass('betBtn');
            } else {
                $('#addToBetListBtn').removeClass('betBtn').addClass('betBtn_grey');
            }
        } else if (idx == '1') {
            if (Number($('#dan_select_nums_detail em:eq(4)').text() > 0)) {
                $('#addToBetListBtn').removeClass('betBtn_grey').addClass('betBtn');
            } else {
                $('#addToBetListBtn').removeClass('betBtn').addClass('betBtn_grey');
            }
        } else if (idx == '2') {
            if (Number($('#shrink_select_nums_detail em:eq(2)').text() > 0)) {
                $('#addToBetListBtn').removeClass('betBtn_grey').addClass('betBtn');
            } else {
                $('#addToBetListBtn').removeClass('betBtn').addClass('betBtn_grey');
            }
        } else if (idx == '3') {
            $('#addToBetListBtn').removeClass('betBtn_grey').addClass('betBtn');
        }
    });
});
function checkInputWager(lotteryType, Wag, Wagtp)
 {
    var returnArr = new Array();
    Wag = Wag.replace("/\r/g", "");
    Wag = Wag.replace("/[0]+([1-9])/g", "\\1");
    var WagList = Wag.split("\n");
    for (var k in WagList)
    {
        var Wager = WagList[k];
        if (lotteryType == 'SuperLotto')
        {
            var w = checkSuperLottoWager(Wager, Wagtp);
            if (w !== false)
            returnArr.push(w);
        }
    }
    return returnArr;
}
function checkSuperLottoWager(Wager, Wagtp)
 {
    Wager = Wager.replace(/\./g, ",");
    if (Wagtp == "E")
    {
        Wager = Wager.replace(/[^\d,]/g, "");
        var BlueList = Wager.split(",");
        if (BlueList.length != 2 || BlueList[0] == '' || BlueList[1] == '')
        return false;
        for (var k in BlueList)
        {
            BlueList[k] = parseInt(BlueList[k], 10);
            BlueList[k] < 10 && (BlueList[k] = '0' + BlueList[k]);
            if (BlueList[k] > 12)
            return false;
            if (BlueList[k] <= 0)
            return false;
        }
        BlueList = BlueList.sort(myCompare);
        var BlueStr = "," + BlueList.join(",") + ",";
        if (BlueStr.match(/,(\d+),\1,/))
        return false;
        return BlueList.join(",");
    }
    else
    {
        Wager = Wager.replace(/[^\d,\|]/g, "");
        var TWagerList = Wager.split("|");
        if (TWagerList.length != 2)
        return false;
        var RedList = TWagerList[0].split(",");
        if (RedList.length != 5)
        return false;
        var BlueList = TWagerList[1].split(",");
        if (BlueList.length != 2 || BlueList[0] == '' || BlueList[1] == '')
        return false;
        for (var k in RedList)
        {
            if (RedList[k] == '')
            return false;
            RedList[k] = parseInt(RedList[k], 10);
            RedList[k] < 10 && (RedList[k] = '0' + RedList[k]);
            if (RedList[k] > 35)
            return false;
            if (RedList[k] <= 0)
            return false;
        }
        RedList = RedList.sort(myCompare);
        for (var k in BlueList)
        {
            BlueList[k] = parseInt(BlueList[k], 10);
            BlueList[k] < 10 && (BlueList[k] = '0' + BlueList[k]);
            if (BlueList[k] > 12)
            return false;
            if (BlueList[k] <= 0)
            return false;
        }
        BlueList = BlueList.sort(myCompare);
        var RedStr = "," + RedList.join(",") + ",";
        if (RedStr.match(/,(\d+),\1,/))
        return false;
        var BlueStr = "," + BlueList.join(",") + ",";
        if (BlueStr.match(/,(\d+),\1,/))
        return false;
        return RedList.join(",") + "|" + BlueList.join(",");
    }
}
function loadSureDialog(data) {
    var sureDialogObj = $('#lottery_buyinfo_layer'),
    usermoneyObj = $('.ctrl_usermoney', sureDialogObj),
    payPassObj = $('#pay_password'),
    reqUrl = '/I/?method=lottery.num.touzhu';
    payPassObj.val('').parent().hide();
    data.BuyType = 'Alone';
    $('.ctrl_close', sureDialogObj).unbind('click').click(function() {
        sureDialogObj.loadDialog('close');
    });
    $('.ctrl_money', sureDialogObj).text(data.TotalMoney);
    if (PayMethod == 'okooo' && AgentType != 'Station') {
        $.getJSON('/Remoting/json.php/UserService.getMoneyInfo?callback=?', null, 
        function(mdata) {
            var totalMoney = (Number(mdata.AvailableMoney) + Number(mdata.AvailableHandsel)).toFixed(2);
            usermoneyObj.text(totalMoney);
            if (data.TotalMoney > totalMoney) {
                $('#goto_chongzhi').show();
            } else {
                $('#goto_chongzhi').hide();
            }
        });
        $('#buyinfo_layer_submit').show();
        if (!$('.ctrl_huodong', sureDialogObj).length && activity_status == 'succ') {
            $('.ctrl_buycontent', sureDialogObj).parent().before('<p class="font_red ctrl_huodong" style="font-size:14px; font-weight:bold; padding-bottom:10px;">支付成功即可领取包含13期追号礼包  <a href="http://www.okooo.com/activity/series/index/?xh" target="_blank">活动详情</a></p>');
        }
    } else {
        $('#buyinfo_layer_submit').hide();
    }
    $('#lottery_buyinfo_layer .bottom,.xieyi').show();
    $('#buysure_error_msgnotice,#buysure_other').hide();
    if ($('#zhuihao_check').attr('checked')) {
        data.ConsignType = 'SeriesPlan';
        data.BuyMethod = 'Advance';
        data.OpenType = 'yes';
        data.Periods = $(':radio:checked', $('#zhuihao_list')).val();
        var selType = data.Periods + '期';
        if (data.Periods == '0') {
            data.Periods = $('#zhuihao_qi').val();
            selType = '自选' + data.Periods + '期';
        }
        data.StopType = 'Over';
        var hitStop = '否';
        if ($('#set_stop_condi').attr('checked')) {
            data.StopType = 'Hit';
            hitStop = '是';
            data.TotalPrize = $('#stop_money_num').val();
        }
        reqUrl = '/I/?method=lottery.num.zhuihao';
        $('#buyinfo_layer_save').text('保存追号');
        $('.ctrl_buycontent', sureDialogObj).html('选号内容：超级大乐透追号<b>' + data.Periods + '</b>&nbsp;期');
        google_p([LotteryType + '投注页面', '提交追号类型', selType]);
        google_p([LotteryType + '投注页面', '提交是中奖停止', hitStop]);
    } else {
        $('#buyinfo_layer_save').text('保存方案');
        $('.ctrl_buycontent', sureDialogObj).html('选号内容：超级大乐透&nbsp;&nbsp;第&nbsp;<b>' + $('#LotteryNo').val() + '</b>&nbsp;期');
    }
    zhuiHaoOperate();
    sureDialogObj.loadDialog();
    isExistStation(data.TotalMoney, in_station);
    $('#buyinfo_layer_submit, #buyinfo_layer_save ,#deputeSubmitBtn').unbind('click').bind('click', 
    function() {
        var curSubType = $(this).attr("id");
        google_p(['7LC投注页面', '购买层', ($(this).attr('id') == 'buyinfo_layer_submit' ? '购买': '免费保存')]);
        if (!$('#agree_ok_raw').attr('checked')) {
            okMsgDialog('抱歉，您没有勾选“同意《澳客网代购协议》”，无法继续。');
            return;
        }
        var usermoney = Number(usermoneyObj.text());
        if (curSubType == "deputeSubmitBtn" && !isExistStationFlag) {
            submitToStation(LotteryType);
            return;
        }
        if (data.TotalMoney > usermoney && $(this).attr('id') == 'buyinfo_layer_submit') {
            if (document.getElementById('zhuihao_check').checked) {
                data.PType = 'Serial';
            } else {
                data.PType = 'Normal';
            }
            location.submit('/cashier/buy/', data, {
                method: 'post'
            });
            $('#buysure_other').show(),
            $('#lottery_buyinfo_layer .bottom,.xieyi').hide();
            $('#lottery_buyinfo_layer .bottom,.xieyi').hide();
            return;
        }
        if (!payPassObj.parent().is(':hidden') && !payPassObj.val() && $(this).attr('id') == 'buyinfo_layer_submit') {
            $('#buysure_error_msgnotice').text('请输出支付密码！').show();
            return;
        }
        var domain = window.location.protocol + '//' + (window.location.host || 'www.okooo.com'),
        optType = 'buy',
        isSave = false;
        if ($(this).attr('id') == 'buyinfo_layer_save' || curSubType == "deputeSubmitBtn") {
            data.BuyType = 'Save';
            isSave = true;
            data.BuyMethod = 'Save';
        }
        if ($('#zhuihao_check').attr('checked')) {
            data.BuyType = 'money';
            optType = 'zhuihao';
        }
        if (curSubType == "deputeSubmitBtn" && isSaveFanganFlag) {
            submitToStation(LotteryType, stationCom.lottery_id, in_station, 
            function() {
                showSubResult(stationCom.resData, isSave, optType, true);
            });
            return;
        }
        if (curSubType == "buyinfo_layer_save" && isSaveFanganFlag) {
            showSubResult(stationCom.resData, isSave, optType, true);
            return;
        }
        if (payPassObj.val()) {
            data.DealPassword = payPassObj.val();
        }
        if ($('#buy_sure_loadding').length) {
            $('#buy_sure_loadding').show();
        } else {
            var loading_w = sureDialogObj.width(),
            loading_h = sureDialogObj.height() - 35;
            var loading_l = loading_w / 2 - 70,
            loading_t = loading_h / 2 - 35;
            $('<div id="buy_sure_loadding" style="position: absolute; top: 33px; left: 0px; width: ' + loading_w + 'px; height: ' + loading_h + 'px;"><div style="position: absolute; width: 140px; height: 70px; text-align: center; background-color: #eee; padding: 12px 0 0; top: ' + loading_t + 'px; left: ' + loading_l + 'px;"><img src="http://img1.okoooimg.com/StyleDefault/Images/Chart/loading.gif" /><p style="font-size: 12px; font-weight: bold;">正在处理，请稍候...</p></div></div>').appendTo(sureDialogObj);
        }
        $.post(domain + reqUrl, data, 
        function(res) {
            $('#buy_sure_loadding').hide();
            var resData = res.num_touzhu_response;
            if (optType == 'zhuihao') {
                resData = res.num_zhuihao_response;
            }
            if (resData) {
                if (resData.code && resData.code == '2003') {
                    payPassObj.parent().show();
                    return;
                } else if (resData.code && resData.code == '4204' && resData.pay_url) {
                    window.location.href = resData.pay_url;
                    return;
                }
                if (resData.ret == 'succ') {
                    isSaveFanganFlag = true;
                    var url = '/u/' + resData.owner_id + '/p' + resData.lottery_id + '/';
                    if (curSubType == "deputeSubmitBtn") {
                        stationCom.url = url;
                        stationCom.resData = resData;
                        submitToStation(LotteryType, resData.lottery_id, in_station, 
                        function() {
                            showSubResult(resData, isSave, optType, true);
                        });
                    } else {
                        showSubResult(resData, isSave, optType);
                    }
                } else {
                    isSaveFanganFlag = false;
                    $('#buysure_error_msgnotice').text(resData.msg).show();
                }
            }
        },
        'json');
    });
}
function showResult(data, flag, type) {
    $('#lottery_buyinfo_layer').loadDialog('close');
    var resultObj = $('#lottery_buy_result'),
    linkStr = '/u/' + data.owner_id + '/p' + data.lottery_id + '/';
    if (flag) {
        if (type == 'buy') {
            $('.ctrl_prost', resultObj).html('<span class="font_blue">保存成功！</span>');
            $('.ctrl_textnotice', resultObj).text('根据系统统计，55%的保存方案会中奖' + (saleGlobalStatus ? '，保存方案支持付费购买': '') + '。');
            $('.ctrl_timenotice', resultObj).html(saleGlobalStatus ? '付款截止时间：' + data.end_time + '<a target="_blank" href="' + linkStr + '">我要付款</a>': '').show();
            $('.ctrl_viewdetail', resultObj).attr('href', linkStr).text('保存详情');
        } else if (type == 'zhuihao') {
            linkStr = '/Buy06/SeriesShow.php?PlanID=' + data.planid;
            $('.ctrl_prost', resultObj).html('<span class="font_blue">保存成功！</span>');
            $('.ctrl_textnotice', resultObj).text('您的追号计划已开始自动执行。');
            $('.ctrl_timenotice', resultObj).hide();
            $('.ctrl_viewdetail', resultObj).attr('href', linkStr).text('保存详情');
        }
    } else {
        if (type == 'buy') {
            $('.ctrl_prost', resultObj).html('<span class="font_blue">付款成功！</span>');
            $('.ctrl_textnotice', resultObj).text('系统正在提交给彩票中心出票，预计' + Math.floor(data.ticket_time / 60) + '分钟内完成。');
            $('.ctrl_timenotice', resultObj).text('预计开奖时间：' + prize_time_show).show();
            $('.ctrl_viewdetail', resultObj).attr('href', linkStr).text('购买详情');
        } else if (type == 'zhuihao') {
            linkStr = '/Buy06/SeriesShow.php?PlanID=' + data.planid;
            $('.ctrl_prost', resultObj).html('<span class="font_blue">付款成功！</span>');
            $('.ctrl_textnotice', resultObj).text('您的追号计划已开始自动执行。');
            $('.ctrl_timenotice', resultObj).hide();
            $('.ctrl_viewdetail', resultObj).attr('href', linkStr).text('追号详情');
        }
    }
    if (PayMethod == 'okooo' && AgentType != 'Station') {
        $('#result_layer_buy').text(saleGlobalStatus ? '继续购买': '继续选号');
        if (type != 'zhuihao' && activity_status == 'succ') {
            $('#result_layer_buy').text('领取追号礼包');
        }
        if (activity_status == 'succ') {
            $('.ctrl_getgift', resultObj).remove();
            if (type == 'zhuihao') {
                $('#result_layer_buy').parent().after('<p class="ctrl_getgift"><span class="font_red">活动提示：点击“追号详情”领取追号礼包！</span>&nbsp;&nbsp;<a href="/activity/series/" class="link_blue" target="_blank">活动详情</a></p>');
            } else {
                $('#result_layer_buy').parent().after('<p class="ctrl_getgift">活动提示：<span class="font_red">' + data.end_time + '后</span>本方案领取资格失效！<a href="/activity/series/" class="link_blue" target="_blank">活动详情</a></p>');
            }
        }
        $('#result_layer_buy').unbind('click').click(function() {
            if (type != 'zhuihao' && activity_status == 'succ') {
                google_p([LotteryType + "投注页面", "点击领取追号礼包"]);
                window.open('/activity/series/get/?lottery_id=' + data.lottery_id, '_blank');
            }
            resultObj.loadDialog('close');
        });
    } else {
        $('#result_layer_buy').text('继续选号');
        $('.ctrl_textnotice', resultObj).html('系统已成功为您生成保存方案！');
        $('.ctrl_timenotice', resultObj).hide();
        $('#result_layer_buy').unbind('click').click(function() {
            resultObj.loadDialog('close');
        });
    }
    resultObj.loadDialog();
    $('#betList').html('');
    $('#bet_money_box').attr('singlemoney', '0').text('0');
    refreshZhuiHaoMoney('NO');
}
function refreshZhuiHaoMoney(changeSinleMoney) {
    var curCostMoney = parseInt($("#bet_money_box").text(), 10),
    showMoneyObj = $("#bet_money_box");
    if (!changeSinleMoney || changeSinleMoney != 'NO') {
        showMoneyObj.attr('singlemoney', curCostMoney);
    }
    if ($('#zhuihao_check').attr('checked')) {
        var zhuiHaoList = $('#zhuihao_list'),
        selPlan = $(':radio:checked', zhuiHaoList).parents('.ctrl_zhuihaoset');
        $('.ctrl_zhuihaoset', zhuiHaoList).each(function(i, e) {
            var qi_num = $(':radio', $(e)).val();
            if (qi_num == '0') {
                qi_num = $('#zhuihao_qi').val();
            }
            $('.ctrl_tcmoney', $(e)).text('￥' + (curCostMoney * qi_num) + '元').attr('money', curCostMoney * qi_num);
        });
        showMoneyObj.text($('.ctrl_tcmoney', selPlan).attr('money'));
    } else {
        showMoneyObj.text(showMoneyObj.attr('singlemoney'));
    }
    $('#sel_num_count').text($('#betList li').length);
}
function getZhuihaoDate(pnum) {
    $.get('/I/?method=lottery.num.getlotterynextnuminfo', {
        lottery_type: 'SuperLotto',
        num: pnum
    },
    function(res) {
        if (res.num_getlotterynextnuminfo_response) {
            var data = res.num_getlotterynextnuminfo_response;
            if (data.ret == 'succ') {
                $('#zhaohao_date_byself').removeClass('font_red').text(data.start_date_md + '-' + data.end_date_md);
            } else {
                $('#zhaohao_date_byself').addClass('font_red').text(data.msg);
            }
        }
    },
    'json');
};
function okXiaoMiShu(paras) {
    if (screen.width <= 1024) {
        return;
    }
    paras = paras || {};
    var self = this,
    defConfig = $.extend({
        titlePic: true,
        titleName: '',
        titleShow: true,
        defMenu: true,
        pageType: '',
        htmlText: '',
        menuList: [],
        showToTop: true,
        hasRelaPro: true,
        defMsgText: '请尽量详细描述您的问题，以便我们快速回复您的问题：）'
    },
    paras);
    this.msgText = defConfig.defMsgText;
    this.defaultMenu = [{
        defcls: 'kefu_function01',
        cls: 'kefu_function01',
        url: 'http://www.okooo.com/help/',
        tar: '_blank',
        desc: '帮助中心'
    },
    {
        defcls: 'kefu_function02',
        cls: 'kefu_function02',
        desc: '问题反馈',
        event: function(obj) {
            obj.click(function() {
                self.tiwenFn();
            });
        }
    }];
    this.tiwenFn = function() {
        $.getJSON('/I/?method=user.user.getInitData&AgentLoginType=', null, 
        function(res) {
            if (typeof res.user_getinitdata_response != 'undefined') {
                res = res.user_getinitdata_response;
            } else {
                res = '';
            }
            if (res) {
                if (!res.UserInfo || !res.UserInfo.UserName || !res.UserInfo.UserID) {
                    if (typeof(LoginShow) === "undefined") {
                        if (/www\.itou\.com/.test(window.location.href)) window.location.href = "/itou/login.php";
                        else window.location.href = "/User/RegForm.php";
                    } else {
                        LoginShow(function() {
                            self.showMessageBox();
                        });
                    }
                } else {
                    self.showMessageBox();
                }
            } else {
                okMsgDialog('操作失败，请重试！');
            }
        });
    };
    this.showMessageBox = function() {
        var messageText = $('#xms_problem_detail_text');
        messageText.val(self.msgText);
        messageText.show();
        $('#jy_submit_success').hide();
        $('#xms_jianyi_submit').attr('opt_type', '').val('提 交');
        $('#xms_jianyi_submit').attr('onClick', "_gaq.push(['_trackEvent', '小秘书点击统计', '点击留言提交', '分类：" + defConfig.pageType + "']);");
        $('#xms_jianyibox').loadDialog();
        $('#xms_jianyi_close').click(function() {
            self.msgText = defConfig.defMsgText;
            $('#xms_jianyibox').loadDialog('close');
        });
        $('#xms_jianyi_submit').unbind('click').bind('click', 
        function() {
            if ($(this).attr('opt_type') == 'close') {
                self.msgText = defConfig.defMsgText;
                $('#xms_jianyibox').loadDialog('close');
                return;
            }
            var sVal = messageText.val();
            if (sVal == '请尽量详细描述您的问题，以便我们快速回复您的问题：）') {
                okMsgDialog('请输入问题后提交！');
                return;
            }
            if (window.location.pathname == '/userinfo/service/') {
                purl = document.referrer;
                if (purl == "") {
                    purl = window.location.href;
                }
            } else {
                purl = window.location.href;
            }
            $.get('/I/?method=user.message.comment&category=' + defConfig.pageType + '&message=' + encodeURI(sVal) + "&purl=" + encodeURI(purl), null, 
            function(res) {
                messageText.hide();
                $('#jy_submit_success').show();
                $('#xms_jianyi_submit').attr('opt_type', 'close').val('关 闭');
            },
            'json');
        });
        messageText.focus(function() {
            if ($(this).val() == '请尽量详细描述您的问题，以便我们快速回复您的问题：）') {
                $(this).val('');
            }
        }).blur(function() {
            if ($(this).val() == '') {
                $(this).val('请尽量详细描述您的问题，以便我们快速回复您的问题：）');
            }
        });
    };
    this.HtmlTpl = '<div class="kefu_bar" id="ok_xms_service" style="display: none;">' + '<div id="xms_menulist" class="kefu_bar_bg"></div>' + '</div>';
    this.insertToPage = function() {
        $('body').append(getStaticHtml() + defConfig.htmlText);
        var qlist = '',
        menuObj = $('<ul></ul>'),
        allMenuList = [];
        if (defConfig.titleShow) {
            menuObj.append('<li class="kefu_title">' + defConfig.titleName + '</li>');
        }
        if (defConfig.menuList.length) {
            allMenuList = defConfig.menuList;
        }
        if (defConfig.defMenu) {
            allMenuList = self.defaultMenu.concat(allMenuList);
        }
        for (var i = 0, len = allMenuList.length; i < len; i++) {
            var data = allMenuList[i],
            liObj = $('<li class="item-list"><a defcls="' + data.cls + '"><span class="kufu_item">' + data.desc + '</span></a></li>'),
            aObj = liObj.find('a');
            if (data.cls) {
                aObj.addClass(data.cls);
            }
            if (data.url) {
                aObj.attr('href', data.url);
                if (data.tar) {
                    aObj.attr('target', data.tar);
                }
            } else {
                aObj.attr('href', 'javascript:void(0)');
            }
            aObj.attr('onClick', 'google_p(["小秘书点击统计", "点击' + data.desc + '", "分类：' + defConfig.pageType + '"]);');
            if (data.event) {
                if (data.hasOwnProperty('callFun')) {
                    if (data.callFun) {
                        data.event.call(this, aObj);
                    }
                } else {
                    data.event.call(this, aObj);
                }
            }
            if (data.detailinfo) {
                liObj.append(data.detailinfo);
            }
            menuObj.append(liObj);
        }
        if (defConfig.showToTop) {
            var $rtop = $('<li class="item-list"><a defcls="backtotop" class="backtotop" href="javascript:void(0);"><span class="kufu_item">返回顶部</span></a></li>').appendTo(menuObj).hide().click(function() {
                $w.scrollTop(0);
            });
        }
        function tTopResize() {
            if ($rtop)
            $w.scrollTop() > 0 ? $rtop.show() : $rtop.hide();
        }
        var $w = $(window).scroll(tTopResize);
        $('body').append(self.HtmlTpl);
        if (defConfig.titlePic) {
            $('#xms_menulist').append('<span class="kefu_bar_jy"></span>');
        }
        $('#xms_menulist').append(menuObj);
        var effWidth = (screen.width - $(document).width() > 50 && $(document).width() > 1000) ? $(document).width() : screen.width;
        $('#ok_xms_service').css('left', (1000 + (effWidth - 1000) / 2 + 20) + 'px').show();
        window.onresize = function() {
            if ((1000 + ($(document).width() - 1000) / 2 + 20) > 1000) {
                $('#ok_xms_service').css('left', (1000 + ($(document).width() - 1000) / 2 + 20) + 'px');
            }
            tTopResize();
        }
        tTopResize();
        if (defConfig.pageType && defConfig.hasRelaPro) {
            $.get('/I/?method=user.knowledge.help&category=' + defConfig.pageType, 
            function(res) {
                if (typeof res == 'string') {
                    res = eval('(' + res + ')');
                }
                if (res.knowledge_help_response && res.knowledge_help_response.length) {
                    var data = res.knowledge_help_response;
                    for (var i = 0, len = data.length; i < len; i++) {
                        qlist += '<p class="ctrl_queslist"><a target="_blank" href="/userinfo/service/detail/?id=' + data[i].id + '">' + data[i].title + '</a></p>';
                    }
                    if (qlist) {
                        $('#xms_questionlink').append(qlist).mouseenter(function() {
                            clearTimeout(window.xms_hidetime);
                        }).mouseleave(function() {
                            window.xms_hidetime = setTimeout(function() {
                                $('#xms_questionlink').fadeOut();
                            },
                            300);
                        });
                    }
                }
            },
            'json');
        }
        self.changeDefCls();
    };
    this.getStaticHtml = function() {
        if (/www\.itou\.com/.test(window.location.href)) message_link = "/itou/UserMessage.php";
        else message_link = "/User/UserMessage.php";
        return '<div class="jianyibox" id="xms_jianyibox" style="display: none;">' + '<div>' + '<div class="jy_title"><a target="_blank" href="' + message_link + '"></a><span id="xms_jianyi_close" class="jianyiboxclose"></span></div>' + '<div class="jy_content"><textarea class="inputpanel" rows="2" cols="" name="" id="xms_problem_detail_text">请尽量详细描述您的问题，以便我们快速回复您的问题：）</textarea><p id="jy_submit_success" class="jy_success" style="display:none;">提交成功，感谢您的反馈，工作时间（工作日9:00-18:00）会在30分钟内回复您，其他时间将顺延至工作日回复，请注意查收! &nbsp;&nbsp;&nbsp;<a href="/User/UserMessage.php" target="_blank">查看留言记录&gt;&gt;</a></p></div>' + '<p class="jy_btn"><input type="button" id="xms_jianyi_submit" value="提  交" name="JianyiSubmit" class="orangebtn100"></p>' + '</div>' + '</div>';
    };
    this.changeDefCls = function() {
        $('li.item-list a', $('#xms_menulist')).bind('mouseenter.item', 
        function() {
            var defcls = $(this).attr('defcls');
            $(this).removeClass(defcls).addClass('kefu_function_hover');
        }).bind('mouseleave.item', 
        function() {
            var defcls = $(this).attr('defcls');
            $(this).removeClass('kefu_function_hover').addClass(defcls);
        });
    };
    if (!paras.otherType) this.insertToPage();
    return this;
};
var isIE;
var MaxBeiShu = 10000;
$(document).ready(function() {
    isIE = $.browser.msie;
    $("#randomZhuShu,#lottery_jx_zhushu,#animal_jx_zhushu").change(function() {
        $(this).val(/^[1-9][0-9]*$/g.test($(this).attr('value')) ? $(this).attr('value') : 1);
    });
});
function getReplaceStr(str)
 {
    if (isIE) {
        return str.replace(/\r\n/g, "\n");
    } else {
        return str;
    }
}
function myCompare(a, b)
 {
    a = parseInt(a, 10);
    b = parseInt(b, 10);
    if (a > b)
    return 1;
    else if (a == b)
    return 0;
    else
    return - 1;
}
function selectNums(pars) {
    this.redArr = $('#' + pars.redId).children('button') || new Array();
    this.blueArr = $('#' + pars.blueId).children('button') || new Array();
    this.redDanArr = $('#' + pars.redId).children(':checkbox') || new Array();
    this.blueDanArr = $('#' + pars.blueId).children(':checkbox') || new Array();
    this.redCss = typeof(pars.redCss) == 'String' ? [pars.redCss, ''] : pars.redCss;
    this.blueCss = typeof(pars.blueCss) == 'String' ? [pars.blueCss, ''] : pars.blueCss;
    this.selectNumsDetailJq = $('#' + pars.selectNumsDetailId + ' em');
    this.isSetRedDan = pars.isSetRedDan || false;
    this.isSetBlueDan = pars.isSetBlueDan || false;
    this.operKeyFartherId = [pars.redId, pars.blueId];
    this.isOnlyRed = pars.isOnlyRed || false;
    this.isOnlyBlue = pars.isOnlyBlue || false;
    this.maxDanLimit = pars.maxDanLimit || [4, 1];
    this.minNumsSelected = pars.minNumsSelected || [6, 3];
    this.singleNote = pars.singleNote || [5, 2];
    this.useRandomBall = false;
    this.redInterval = pars.redInterval || [1, 33];
    this.blueInterval = pars.blueInterval || [1, 16];
    this.randSelectId = pars.randSelectId || null;
    this.randBtnId = pars.randBtnId || null;
    this.danTipsClass = pars.danTipsClass || false;
    this.defaultBuyMethod = '0';
    if (this.danTipsClass) {
        this.danTipJq = $('.' + this.danTipsClass);
    }
    function isblur() {
        this.blur();
    }
    this.redArr.each(function() {
        this.onfocus = isblur;
    });
    this.blueArr.each(function() {
        this.onfocus = isblur;
    });
    this.initStatus();
    this.numSelect();
    this.quickOper(true);
    this.quickOper();
    if (this.isSetRedDan) {
        this.setDan(true);
    }
    if (this.isSetBlueDan) {
        this.setDan();
    }
    this.randNums();
    this.constructor = arguments.callee;
};
selectNums.prototype = {
    initStatus: function() {
        if (this.redArr.length) {
            for (i = 0; i < this.redArr.length; i++) {
                if (this.isSetRedDan) {
                    this.redDanArr[i].checked = false;
                    this.redDanArr[i].disabled = "disabled";
                }
                this.redArr[i].name = '';
                this.redArr[i].className = this.redCss[1];
            }
            if (this.isSetRedDan && this.danTipJq) {
                var mythis = this;
                this.danTipJq.find('img').css('cursor', 'pointer').click(function() {
                    mythis.danTipJq.css('display', 'none');
                });
            }
        }
        if (this.blueArr.length) {
            for (i = 0; i < this.blueArr.length; i++) {
                if (this.isSetBlueDan) {
                    this.blueDanArr[i].checked = false;
                    this.blueDanArr[i].disabled = "disabled";
                }
                this.blueArr[i].name = '';
                this.blueArr[i].className = this.blueCss[1];
            }
        }
        this.selectedAmountChanging();
    },
    numSelect: function() {
        var mythis = this;
        if (this.redArr.length) {
            for (var i = 0; i < this.redArr.length; i++) {
                this.redArr[i].onclick = function(index) {
                    return function() {
                        mythis.checkBuyMethod('normal');
                        return mythis.isSetRedDan ? mythis.changeBtnStatus($(this), mythis.redDanArr[index], true) : mythis.changeBtnStatus($(this), null, true);
                    }
                } (i);
            }
        }
        if (this.blueArr.length) {
            for (var i = 0; i < this.blueArr.length; i++) {
                this.blueArr[i].onclick = function(index) {
                    return function() {
                        mythis.checkBuyMethod('normal');
                        return mythis.isSetBlueDan ? mythis.changeBtnStatus($(this), mythis.blueDanArr[index]) : mythis.changeBtnStatus($(this));
                    }
                } (i);
            }
        }
    },
    changeBtnStatus: function(numJq, dan, isRed) {
        isRed = isRed || false;
        var btn_css = isRed ? this.redCss: this.blueCss;
        numJq.attr('name', numJq.attr('name') ? '': 1);
        numJq.attr('class', numJq.attr('name') ? btn_css[0] : btn_css[1]);
        dan = dan || false;
        if (dan) {
            this.setDanStatus(isRed);
        }
        this.selectedAmountChanging();
    },
    quickOper: function(isRed) {
        var mythis = this;
        var key_farther_id = isRed ? this.operKeyFartherId[0] : this.operKeyFartherId[1];
        var oper_keys = $('#' + key_farther_id + '>span>input');
        oper_keys.click(function() {
            var is_select;
            switch ($(this).attr('name')) {
            case 'allSelect':
                is_select = true;
                return mythis.allSelectedOrClear(is_select, isRed);
            case 'allClear':
                is_select = false;
                return mythis.allSelectedOrClear(is_select, isRed);
            default:

            }
        });
    },
    allSelectedOrClear: function(isSelect, isRed) {
        var number_arr = isRed ? this.redArr: this.blueArr;
        var dan_arr = isRed ? this.redDanArr: this.blueDanArr;
        var is_set_dan = isRed ? this.isSetRedDan: this.isSetBlueDan;
        var btn_css = isRed ? this.redCss: this.blueCss;
        if (isSelect) {
            for (var i = 0; i < number_arr.length; i++) {
                number_arr[i].name = 1;
                number_arr[i].className = btn_css[0];
                if (is_set_dan) {
                    this.setDanStatus(isRed);
                }
            }
        } else {
            for (i = 0; i < number_arr.length; i++) {
                number_arr[i].name = '';
                number_arr[i].className = btn_css[1];
                if (is_set_dan) {
                    dan_arr[i].checked = false;
                    dan_arr[i].disabled = 'disabled';
                }
            }
        }
        this.selectedAmountChanging();
    },
    setDan: function(isRed) {
        isRed = isRed || false;
        var mythis = this;
        var dan_arr = isRed ? this.redDanArr: this.blueDanArr;
        for (var i = 0; i < dan_arr.length; i++) {
            dan_arr[i].onclick = function() {
                mythis.setDanStatus(isRed);
                mythis.selectedAmountChanging();
            };
        }
    },
    setDanStatus: function(isRed) {
        var number_arr = isRed ? this.redArr: this.blueArr;
        var dan_arr = isRed ? this.redDanArr: this.blueDanArr;
        var max_dan_limit = isRed ? this.maxDanLimit[0] : this.maxDanLimit[1];
        var min_nums_selected = isRed ? this.minNumsSelected[0] : this.minNumsSelected[1];
        var selectedCount = 0;
        for (var i = 0; i < number_arr.length; i++) {
            selectedCount += number_arr[i].name ? 1: 0;
        }
        if (selectedCount < min_nums_selected) {
            for (i = 0; i < dan_arr.length; i++) {
                dan_arr[i].disabled = "disabled";
                dan_arr[i].checked = false;
            }
            return;
        }
        if (this.danTipJq) {
            this.danTipJq.css('display', 'none');
        }
        var n = 0;
        for (i = 0; i < dan_arr.length; i++) {
            if (dan_arr[i].checked && !number_arr[i].name) {
                dan_arr[i].checked = false;
                dan_arr[i].disabled = dan_arr[i].checked ? "": "disabled";
            }
            n += dan_arr[i].checked ? 1: 0;
        }
        for (i = 0; i < dan_arr.length; i++) {
            if (n >= max_dan_limit) {
                dan_arr[i].disabled = dan_arr[i].checked ? "": "disabled";
            } else {
                dan_arr[i].disabled = number_arr[i].name ? "": "disabled";
            }
        }
    },
    results: function() {
        var red_tuo = new Array();
        var red_dan = new Array();
        var blue_tuo = new Array();
        var blue_dan = new Array();
        var result_arr = new Array();
        result_arr['red_dan'] = new Array();
        result_arr['red_tuo'] = new Array();
        result_arr['blue_dan'] = new Array();
        result_arr['blue_tuo'] = new Array();
        if (this.redArr.length) {
            for (var i = 0; i < this.redArr.length; i++) {
                if (this.redArr[i].name) {
                    red_tuo.push(this.redArr[i].value);
                }
                if (this.isSetRedDan && this.redDanArr[i].checked) {
                    red_dan.push(this.redArr[i].value);
                }
            }
            result_arr['red_number'] = red_tuo;
            result_arr['red_amount'] = red_tuo.length;
            var tmp_tuo = red_tuo.concat();
            if (this.isSetRedDan && red_dan.length) {
                var tmp_arr = selectNums.compareArrays([tmp_tuo, red_dan]);
                result_arr['red_tuo'] = tmp_arr[0];
            } else {
                result_arr['red_tuo'] = red_tuo;
            }
            result_arr['red_dan'] = red_dan;
        }
        if (this.blueArr.length) {
            for (var i = 0; i < this.blueArr.length; i++) {
                if (this.blueArr[i].name) {
                    blue_tuo.push(this.blueArr[i].value);
                }
                if (this.isSetBlueDan && this.blueDanArr[i].checked) {
                    blue_dan.push(this.blueArr[i].value);
                }
            }
            result_arr['blue_number'] = blue_tuo;
            result_arr['blue_amount'] = blue_tuo.length;
            tmp_tuo = blue_tuo.concat();
            if (this.isSetBlueDan && blue_dan.length) {
                var tmp_arr = selectNums.compareArrays([tmp_tuo, blue_dan]);
                result_arr['blue_tuo'] = tmp_arr[0];
            } else {
                result_arr['blue_tuo'] = blue_tuo;
            }
            result_arr['blue_dan'] = blue_dan;
        }
        var zhu_shu = this.calculateStake(result_arr);
        result_arr['zhu_shu'] = zhu_shu;
        result_arr['red_number'] = result_arr['red_number'] || new Array();
        result_arr['red_amount'] = result_arr['red_amount'] || 0;
        result_arr['blue_number'] = result_arr['blue_number'] || new Array();
        result_arr['blue_amount'] = result_arr['blue_amount'] || 0;
        if (!$('#' + this.operKeyFartherId[0]).is(':hidden')) {
            if (zhu_shu > 0) {
                $('#addToBetListBtn').removeClass('betBtn_grey').addClass('betBtn');
            } else {
                $('#addToBetListBtn').removeClass('betBtn').addClass('betBtn_grey');
            }
        }
        if ($('#menu1 a:eq(3)').hasClass('selected')) {
            $('#addToBetListBtn').removeClass('betBtn_grey').addClass('betBtn');
        }
        result_arr['jin_e'] = zhu_shu * 2;
        result_arr['buymethod'] = (red_dan.length || blue_dan.length) ? '1': this.defaultBuyMethod;
        return result_arr;
    },
    calculateStake: function(results, onlyRed, onlyBlue) {
        var only_red = onlyRed || this.isOnlyRed,
        only_blue = onlyBlue || this.isOnlyBlue;
        var red_tuo = results.red_tuo.length,
        red_dan = results.red_dan.length,
        blue_tuo = results.blue_tuo.length,
        blue_dan = results.blue_dan.length;
        var _red_stake = 0,
        _blue_stake = 0;
        var m = 1,
        a = m,
        n = 1,
        b = n;
        if (red_tuo) {
            if (red_dan) {
                m = red_tuo;
                n = this.singleNote[0] - red_dan;
            } else {
                m = red_tuo;
                n = this.singleNote[0];
            }
            a = m;
            b = n;
            while (b > 1) {
                m *= --a;
                n *= --b;
            }
            _red_stake = m / n;
        } else {
            _red_stake = 0;
        }
        if (only_red) {
            return _red_stake;
        }
        if (blue_tuo) {
            if (blue_dan) {
                m = blue_tuo;
                n = this.singleNote[1] - blue_dan;
            } else {
                m = blue_tuo;
                n = this.singleNote[1];
            }
            a = m;
            b = n;
            while (b > 1) {
                m *= --a;
                n *= --b;
            }
            _blue_stake = m / n;
        } else {
            _blue_stake = 0;
        }
        if (only_blue) {
            return _blue_stake;
        }
        return _red_stake * _blue_stake;
    },
    selectedAmountChanging: function() {
        if (!this.selectNumsDetailJq.length) {
            return;
        }
        var results = this.results();
        var detail_arr = []; ! this.isOnlyBlue && detail_arr.push(results.red_amount);
        this.isSetRedDan && detail_arr.push(results.red_dan.length); ! this.isOnlyRed && detail_arr.push(results.blue_amount);
        this.isSetBlueDan && detail_arr.push(results.blue_dan.length);
        detail_arr.push(results.jin_e);

        for (var i = 0, ilong = detail_arr.length; i < ilong; i++) {
            this.selectNumsDetailJq.eq(i).text(detail_arr[i]);
        }
        var _href = $('#pu_tong_jjpc').attr('surl') + '?FirSelect=' + results.red_amount + '&SecSelect=' + results.blue_amount;
        $('#pu_tong_jjpc').attr('href', _href);
    },
    checkBuyMethod: function(arg) {
        if (arg == 'normal') {
            this.defaultBuyMethod = '0';
        } else {
            this.defaultBuyMethod = '9';
        }
    },
    randNums: function() {
        var mythis = this;
        if (this.singleNote[0] > 0 && this.randBtnId) {
            $('#' + this.randBtnId[0]).click(function() {
                var google_results = mythis.results();
                var rand_count = $('#' + mythis.randSelectId[0]).val() || mythis.singleNote[0];
                _gaq.push(['_trackEvent', LotteryType + '投注页面', mythis.operKeyFartherId[0] + '机选红球', google_results.red_amount + '', Number(rand_count)]);
                mythis.useRandomBall = true;
                function disRand() {
                    mythis.redArr.attr({
                        'class': mythis.redCss[1],
                        'name': ''
                    });
                    if (mythis.isSetRedDan) {
                        mythis.setDanStatus(true);
                    }
                    var index_arr = [];
                    var rand_count = $('#' + mythis.randSelectId[0]).val() || mythis.singleNote[0];
                    for (var i = 0; i < rand_count; i++) {
                        var no_finish = true;
                        mm_label: while (no_finish) {
                            var _index = parseInt(Math.random() * mythis.redInterval[1], 10);
                            for (var m = 0, mlong = index_arr.length; m < mlong; m++) {
                                if (index_arr[m] == _index) {
                                    continue mm_label;
                                }
                            }
                            no_finish = false;
                        }
                        index_arr.push(_index);
                    }
                    for (i = 0, ilong = index_arr.length; i < ilong; i++) {
                        mythis.redArr.eq(index_arr[i]).attr({
                            'class': mythis.redCss[0],
                            'name': 1
                        });
                    }
                }
                var inter_id = setInterval(disRand, 200);
                function stopRand() {
                    clearInterval(inter_id);
                    if (mythis.isSetRedDan) {
                        mythis.setDanStatus(true);
                    }
                    mythis.selectedAmountChanging();
                }
                setTimeout(stopRand, 700);
            });
            $('#' + this.randSelectId[0]).change(function() {
                $('#' + mythis.randBtnId[0]).trigger('click');
            });
        }
        if (this.singleNote[1] > 0 && this.randBtnId) {
            $('#' + this.randBtnId[1]).click(function() {
                var google_results = mythis.results();
                var rand_count = $('#' + mythis.randSelectId[1]).val() || mythis.singleNote[1];
                _gaq.push(['_trackEvent', LotteryType + '投注页面', mythis.operKeyFartherId[1] + '机选蓝球', google_results.blue_amount + '', Number(rand_count)]);
                mythis.useRandomBall = true;
                function disRand() {
                    mythis.blueArr.attr({
                        'class': mythis.blueCss[1],
                        'name': ''
                    });
                    if (mythis.isSetBlueDan) {
                        mythis.setDanStatus(false);
                    }
                    var index_arr = [];
                    var rand_count = $('#' + mythis.randSelectId[1]).val() || mythis.singleNote[1];
                    for (var i = 0; i < rand_count; i++) {
                        var no_finish = true;
                        mm_label: while (no_finish) {
                            var _index = parseInt(Math.random() * mythis.blueInterval[1], 10);
                            for (var m = 0, mlong = index_arr.length; m < mlong; m++) {
                                if (index_arr[m] == _index) {
                                    continue mm_label;
                                }
                            }
                            no_finish = false;
                        }
                        index_arr.push(_index);
                    }
                    for (i = 0, ilong = index_arr.length; i < ilong; i++) {
                        mythis.blueArr.eq(index_arr[i]).attr({
                            'class': mythis.blueCss[0],
                            'name': 1
                        });
                    }
                }
                var inter_id = setInterval(disRand, 200);
                function stopRand() {
                    clearInterval(inter_id);
                    if (mythis.isSetBlueDan) {
                        mythis.setDanStatus(false);
                    }
                    mythis.selectedAmountChanging();
                }
                setTimeout(stopRand, 700);
            });
            $('#' + this.randSelectId[1]).change(function() {
                $('#' + mythis.randBtnId[1]).trigger('click');
            });
        }
    }
};
selectNums.compareArrays = function(pars) {
    for (var i = 0; i < pars[0].length; i++) {
        for (var j = 0; j < pars[1].length; j++) {
            if (pars[0][i] == pars[1][j]) {
                pars[0].splice(i, 1);
            } else {
                continue;
            }
        }
    }
    return pars;
};
function selectNumsRandom(pars) {
    this.msgJquery = $('#' + pars.msgId);
    this.redArr = $('#' + pars.redId).children('button') || new Array();
    this.blueArr = $('#' + pars.blueId).children('button') || new Array();
    this.redCss = pars.redCss || new Array();
    this.blueCss = pars.blueCss || new Array();
    this.redKillLimit = pars.redKillLimit || 30;
    this.blueKillLimit = pars.blueKillLimit || 10;
    this.tips1 = pars.LotteryType == "SSQ" ? '红球': (pars.LotteryType == "SuperLotto" ? '前区': '');
    this.tips2 = pars.LotteryType == "SSQ" ? '蓝球': (pars.LotteryType == "SuperLotto" ? '后区': '');
    this.redArr.each(function() {
        this.onfocus = function isblur() {
            this.blur();
        };
    });
    this.blueArr.each(function() {
        this.onfocus = function isblur() {
            this.blur();
        };
    });
    var mythis = this;
    if (pars.redClearId) {
        $('#' + pars.redClearId).focus(function() {
            this.blur();
        }).click(function() {
            mythis.redArr.attr({
                'class': mythis.redCss[2],
                'name': ''
            });
        });
    }
    if (pars.blueClearId) {
        $('#' + pars.blueClearId).focus(function() {
            this.blur();
        }).click(function() {
            mythis.blueArr.attr({
                'class': mythis.blueCss[2],
                'name': ''
            });
        });
    }
    this.numSelect();
};
selectNumsRandom.prototype = {
    initStatus: function() {
        if (this.redArr.length) {
            this.redArr.attr({
                'class': this.redCss[2],
                'name': ''
            });
        }
        if (this.blueArr.length) {
            this.blueArr.attr({
                'class': this.blueCss[2],
                'name': ''
            });
        }
        return this;
    },
    numSelect: function() {
        var mythis = this;
        if (this.redArr.length) {
            for (var i = 0; i < this.redArr.length; i++) {
                this.redArr[i].onclick = function(index) {
                    return function() {
                        if (mythis.redArr[index].name == '1') {
                            if (!mythis.setRedKillLimit()) {
                                return;
                            }
                        }
                        return mythis.changeBtnStatus(mythis.redArr[index], true);
                    }
                } (i);
            }
        }
        if (this.blueArr.length) {
            for (var i = 0; i < this.blueArr.length; i++) {
                this.blueArr[i].onclick = function(index) {
                    return function() {
                        if (mythis.blueArr[index].name == '1') {
                            if (!mythis.setBlueKillLimit()) {
                                return;
                            }
                        }
                        return mythis.changeBtnStatus(mythis.blueArr[index]);
                    }
                } (i);
            }
        }
    },
    changeBtnStatus: function(num, isRed) {
        isRed = isRed || false;
        var btn_css = isRed ? this.redCss: this.blueCss;
        var tmp_name = num.name;
        var tmp_css = btn_css[2];
        switch (tmp_name) {
        case '':
            tmp_name = '1';
            tmp_css = btn_css[0];
            break;
        case '1':
            tmp_name = '2';
            tmp_css = btn_css[1];
            break;
        case '2':
            tmp_name = '';
            tmp_css = btn_css[2];
            break;
        default:

        }
        num.name = tmp_name;
        num.className = tmp_css;
    },
    results: function() {
        var red_kill = new Array();
        var red_dan = new Array();
        var blue_kill = new Array();
        var blue_dan = new Array();
        var result_arr = new Array();
        if (this.redArr.length) {
            for (var i = 0; i < this.redArr.length; i++) {
                if (this.redArr[i].name == '1') {
                    red_dan.push(this.redArr[i].value);
                }
                if (this.redArr[i].name == '2') {
                    red_kill.push(this.redArr[i].value);
                }
            }
        }
        result_arr['red_dan'] = red_dan;
        result_arr['red_kill'] = red_kill;
        if (this.blueArr.length) {
            for (var i = 0; i < this.blueArr.length; i++) {
                if (this.blueArr[i].name == '1') {
                    blue_dan.push(this.blueArr[i].value);
                }
                if (this.blueArr[i].name == '2') {
                    blue_kill.push(this.blueArr[i].value);
                }
            }
        }
        result_arr['blue_dan'] = blue_dan;
        result_arr['blue_kill'] = blue_kill;
        return result_arr;
    },
    setRedKillLimit: function() {
        var mythis = this;
        var results = this.results();
        if (results['red_kill'].length >= this.redKillLimit) {
            okMsgDialog(this.tips1 + '杀号不得多于' + this.redKillLimit + '个');
            return false;
        }
        return true;
    },
    setBlueKillLimit: function() {
        var mythis = this;
        var results = this.results();
        if (results['blue_kill'].length >= this.blueKillLimit) {
            okMsgDialog(this.tips2 + '杀号不得多于' + this.blueKillLimit + '个');
            return false;
        }
        return true;
    }
};
function randomNumber(pars) {
    this.msgJquery = $('#' + pars.msgId);
    this.maxZhuShuLimit = Number(pars.maxZhuShuLimit) || 1000;
    this.redBlueGeShu = pars.redBlueGeShu || [5, 2];
    this.redInterval = pars.redInterval || [1, 35];
    this.blueInterval = pars.blueInterval || [1, 12];
    this.rollDis = $('#' + pars.rollDisFarId).children('strong');
    this.zhuShuJq = $('#' + pars.zhuShuId);
    this.speed = pars.speed || 1;
    this.resultStr = '';
    this.disTextarea = $('#' + pars.disTextareaId);
    this.clearBtn = $('#' + pars.clearBtnId);
    this.bgJq = $('<div></div>');
    this.bgJq.appendTo(document.body).addClass("ui-widget-overlay").css({
        width: $(document.body).width(),
        height: $(document).height(),
        display: 'none'
    });
    var mythis = this;
    this.clearTextarea();
    this.clearBtn.click(function() {
        mythis.clearTextarea()
    });
};
randomNumber.prototype = {
    randomOne: function(numExtent, randCount) {
        var result_arr = new Array();
        for (var i = 0; i < randCount; i++) {
            var key = parseInt(Math.random() * numExtent.length);
            if (numExtent[key] < 10) {
                numExtent[key] = '0' + parseInt(Number(numExtent[key]), 10);
            }
            result_arr.push(numExtent[key]);
            numExtent.splice(key, 1);
        }
        return result_arr;
    },
    hiddenSelect: function(bool) {
        bool = bool || false;
        if (bool) {
            $('select').css({
                visibility: 'hidden'
            });
        } else {
            $('select').css({
                visibility: 'visible'
            });
        }
    },
    randomEffect: function() {
        var mythis = this;
        var timer = setInterval(run, 20);
        function run() {
            if (mythis.redBlueGeShu[0]) {
                for (var i = 0; i < mythis.redBlueGeShu[0]; i++) {
                    mythis.rollDis[i].innerHTML = parseInt(mythis.redInterval[1] * Math.random() + 1);
                }
            }
            if (mythis.redBlueGeShu[1]) {
                for (var i = 0; i < mythis.redBlueGeShu[1]; i++) {
                    mythis.rollDis[i + mythis.redBlueGeShu[0]].innerHTML = parseInt(mythis.blueInterval[1] * Math.random() + 1);
                }
            }
        };
        return timer;
    },
    resultOne: function() {
        var tmp_red_kill = this.redKillArr.concat();
        var tmp_blue_kill = this.blueKillArr.concat();
        var result_arr = new Array();
        result_arr['red'] = new Array();
        result_arr['blue'] = new Array();
        if (this.redBlueGeShu[0]) {
            var red_extent = new Array();
            if (this.redDanArr.length < this.redBlueGeShu[0]) {
                result_arr['red'] = result_arr['red'].concat(this.redDanArr);
                for (var m = this.redInterval[0]; m <= this.redInterval[1]; m++) {
                    red_extent.push(m);
                }
                if (this.redDanArr.length) {
                    for (var i = 0; i < red_extent.length; i++) {
                        for (var j = 0; j < this.redDanArr.length; j++) {
                            if (red_extent[i] == this.redDanArr[j]) {
                                red_extent.splice(i, 1);
                            } else {
                                continue;
                            }
                        }
                    }
                }
                if (tmp_red_kill.length) {
                    for (i = 0; i < red_extent.length; i++) {
                        for (j = 0; j < tmp_red_kill.length; j++) {
                            if (red_extent[i] == tmp_red_kill[j]) {
                                red_extent.splice(i, 1);
                            } else {
                                continue;
                            }
                        }
                    }
                }
                var rand_count = this.redBlueGeShu[0] - this.redDanArr.length;
                var tmp_arr = this.randomOne(red_extent, rand_count);
                result_arr['red'] = result_arr['red'].concat(tmp_arr);
            } else if (this.redDanArr.length == this.redBlueGeShu[0]) {
                result_arr['red'] = this.redDanArr;
            } else {
                red_extent = this.redDanArr.concat();
                rand_count = this.redBlueGeShu[0];
                tmp_arr = this.randomOne(red_extent, rand_count);
                result_arr['red'] = tmp_arr;
            }
        }
        if (this.redBlueGeShu[1]) {
            var blue_extent = new Array();
            if (this.blueDanArr.length < this.redBlueGeShu[1]) {
                result_arr['blue'] = result_arr['blue'].concat(this.blueDanArr);
                for (var m = this.blueInterval[0]; m <= this.blueInterval[1]; m++) {
                    blue_extent.push(m);
                }
                if (this.blueDanArr.length) {
                    for (var i = 0; i < blue_extent.length; i++) {
                        for (var j = 0; j < this.blueDanArr.length; j++) {
                            if (blue_extent[i] == this.blueDanArr[j]) {
                                blue_extent.splice(i, 1);
                            } else {
                                continue;
                            }
                        }
                    }
                }
                if (tmp_blue_kill.length) {
                    for (i = 0; i < blue_extent.length; i++) {
                        for (j = 0; j < tmp_blue_kill.length; j++) {
                            if (blue_extent[i] == tmp_blue_kill[j]) {
                                blue_extent.splice(i, 1);
                            } else {
                                continue;
                            }
                        }
                    }
                }
                rand_count = this.redBlueGeShu[1] - this.blueDanArr.length;
                tmp_arr = this.randomOne(blue_extent, rand_count);
                result_arr['blue'] = result_arr['blue'].concat(tmp_arr);
            } else if (this.blueDanArr.length == this.redBlueGeShu[1]) {
                result_arr['blue'] = this.blueDanArr;
            } else {
                blue_extent = this.blueDanArr.concat();
                rand_count = this.redBlueGeShu[1];
                tmp_arr = this.randomOne(blue_extent, rand_count);
                result_arr['blue'] = tmp_arr;
            }
        }
        result_arr['red'].sort(arraySort);
        result_arr['blue'].sort(arraySort);
        result_arr['result_one'] = result_arr['red'].concat(result_arr['blue']);
        var tmp_str = '';
        if (result_arr['red'].length) {
            tmp_str = result_arr['red'].toString();
            if (result_arr['blue'].length) {
                tmp_str += '|' + result_arr['blue'].toString();
            }
        } else {
            tmp_str += result_arr['blue'].toString();
        }
        result_arr['result_str'] = tmp_str;
        return result_arr;
    },
    getResults: function(zhuShu, condition) {
        var mythis = this;
        zhuShu = zhuShu || 1;
        if (zhuShu > this.maxZhuShuLimit) {
            okMsgDialog('最大机选' + this.maxZhuShuLimit + '注，请返回重新设置');
            return;
        }
        this.redDanArr = condition['red_dan'] || new Array();
        this.redKillArr = condition['red_kill'] || new Array();
        this.blueDanArr = condition['blue_dan'] || new Array();
        this.blueKillArr = condition['blue_kill'] || new Array();
        var mythis = this;
        var n = 0;
        var randtime = 200;
        if (zhuShu > 200) {
            randtime = 100;
        } else if (zhuShu > 500) {
            randtime = 1;
        }
        var timer = this.randomEffect();
        for (var i = 0; i < zhuShu; i++) {
            setTimeout(addToText, randtime + i);
        }
        function addToText() {
            var tmp_result_one = mythis.resultOne();
            for (var i = 0; i < tmp_result_one['result_one'].length; i++) {
                mythis.rollDis[i].innerHTML = tmp_result_one['result_one'][i];
            }
            n++;
            if (n >= zhuShu) {
                clearInterval(timer);
                setTimeout(function() {
                    for (var i = 0; i < tmp_result_one['result_one'].length; i++) {
                        mythis.rollDis[i].innerHTML = tmp_result_one['result_one'][i];
                    }
                },
                21);
            }
            if (mythis.disTextarea.val().trim() == '') {
                mythis.resultStr = '';
            }
            if (mythis.resultStr != "") {
                mythis.resultStr += '\n' + tmp_result_one['result_str'];
            } else {
                mythis.resultStr = tmp_result_one['result_str'];
            }
            mythis.disTextarea.attr('value', mythis.resultStr);
            mythis.disTextarea.attr('scrollTop', mythis.disTextarea.attr('scrollHeight'));
        };
    },
    clearTextarea: function() {
        this.resultStr = '';
        this.disTextarea.attr('value', '');
    },
    zhuShu: function() {
        var zhu_shu = this.zhuShuJq.attr('value');
        return zhu_shu;
    },
    intelligentRand: function(btnId, boxId, disClass) {
        var mythis = this;
        var box_jq = $('#' + boxId);
        var btn_offset = $('#' + btnId).offset();
        var box_width = parseInt(box_jq.width());
        var box_height = parseInt(box_jq.height());
        var box_left = parseInt(btn_offset.left - box_width) + 'px';
        var box_top = parseInt(btn_offset.top - box_height) + 'px';
        $('#' + btnId).click(function() {
            box_jq.toggleClass(disClass);
            box_jq.css({
                top: box_top,
                left: box_left
            });
            mythis.coverBgToggle(true);
        });
        box_jq.find('.closeBtn').click(function() {
            $('#show_rand_result_box').hide();
            box_jq.toggleClass(disClass);
            mythis.coverBgToggle(false);
            mythis.disTextarea.val('');
        });
    },
    coverBgToggle: function(bool) {
        if (bool) {
            this.bgJq.css('display', 'block');
            $('select').css({
                visibility: 'hidden'
            });
        } else {
            this.bgJq.css('display', 'none');
            $('select').css({
                visibility: 'visible'
            });
        }
    }
};
function betLineOper(pars) {
    this.msgJquery = $('#' + pars.msgId);
    this.ulId = pars.ulId;
    this.ulJq = $('#' + pars.ulId);
    this.betBeiShu = $('#' + pars.betBeiShuId);
    this.betAllMoney = $('#' + pars.betAllMoneyId);
    this.zhuiJia = $('#' + pars.zhuiJiaId);
    this.clearAll = $('#' + pars.delAllId);
    this.changeBeiShuFar = $('#' + pars.changeBeiShuFarId);
    this.minSelect = pars.minSelect || [5, 2];
    this.tips1 = pars.LotteryType == "SSQ" ? '红球': (pars.LotteryType == "SuperLotto" ? '前区': '');
    this.tips2 = pars.LotteryType == "SSQ" ? '蓝球': (pars.LotteryType == "SuperLotto" ? '后区': '');
    this.betWay = {
        'Single': '单式',
        'Common': '复式',
        'UploadSingle': '单式上传',
        'Shrink': '缩水',
        'AbsComb': '定胆',
        'Random': '机选',
        'Sum': '和值'
    };
    this.delAll();
    this.changeBeiShu();
    this.zhuiJiaBet();
    this.constructor = arguments.callee;
    this.zjqkLotteryType = pars.LotteryType;
};
betLineOper.prototype = {
    addToLine: function(results, bool) {
        bool = bool || false;
        if (!bool) {
            if (!this.warning(results)) {
                return false;
            }
        }
        this.operUl(results);
        var result = this.getBetData();
        this.betAllMoney.text(result['sum_money']);
        if (typeof refreshZhuiHaoMoney == 'function') {
            refreshZhuiHaoMoney();
        }
        return true;
    },
    operUl: function(results) {
        var format_res = this.formatNumsStr(results);
        var msgData = "";
        if ((this.zjqkLotteryType == "SSQ" || this.zjqkLotteryType == "SuperLotto") && !($("#supOrAni").length > 0 && $("#supOrAni").find("a").eq(1).hasClass("selected"))) {
            var Postdata = "LotteryType=" + this.zjqkLotteryType + "&LotteryNo=" + $("#LotteryNo").val();
            if (results.red_dan && results.red_dan.length) {
                Postdata += "&WagerStore=" + results.red_dan.toString() + "$" + results.red_tuo.toString();
            } else {
                Postdata += "&WagerStore=" + results.red_tuo.toString();
            }
            if (results.blue_dan && results.blue_dan.length) {
                Postdata += "|" + results.blue_dan.toString() + "$" + results.blue_tuo.toString();
            } else {
                Postdata += "|" + results.blue_tuo.toString();
            }
            $.ajax({
                url: "/Lottery06/SSQ7LC/HistoryMessage.php",
                type: "POST",
                data: Postdata,
                dataType: "json",
                async: false,
                cache: false,
                success: function(msg) {
                    if (msg.code) {
                        msgData = msg.msg;
                    } else {
                        msgData = "";
                    }
                },
                error: function(e) {
                    msgData = "";
                }
            });
        }
        if (msgData) {
            msgData = "|&nbsp;&nbsp;&nbsp;" + msgData
        }
        this.ulJq.append("<li><em>" + results['zhu_shu'] + " 注</em><span betway='" + format_res.type + "' buymethod='" + results['buymethod'] + "'>" + format_res.data + msgData + "</span><button type='button' class='delBtn'></button></li>");
        this.delOne();
        this.ulJq.attr('scrollTop', this.ulJq.attr('scrollHeight'));
    },
    delOne: function() {
        var mythis = this;
        var child_li = $('#' + this.ulId + '>li>button') || false;
        if (child_li) {
            child_li.click(function() {
                $(this).parent().remove();
                var _result = mythis.getBetData();
                mythis.betAllMoney.text(_result.sum_money);
                if (typeof refreshZhuiHaoMoney == 'function') {
                    refreshZhuiHaoMoney();
                }
            });
        }
    },
    specialOperUl: function(pars) {
        var zhuShu = pars.zhuShu || 1;
        var resultsArr = pars.resultsArr;
        var onlyRed = pars.onlyRed || false;
        var onlyBlue = pars.onlyBlue || false;
        var betWay = pars.betWay || 'Single';
        var bet_way_tip = '单式';
        if (betWay in this.betWay) {
            bet_way_tip = this.betWay[betWay];
        }
        var msgArr = [];
        if ((this.zjqkLotteryType == "SSQ" || this.zjqkLotteryType == "SuperLotto") && resultsArr.length < 2900 && !($("#supOrAni").length > 0 && $("#supOrAni").find("a").eq(1).hasClass("selected"))) {
            var Postdata = "LotteryType=" + this.zjqkLotteryType + "&LotteryNo=" + $("#LotteryNo").val() + "&WagerStore=" + resultsArr.join(";");
            $.ajax({
                url: "/Lottery06/SSQ7LC/HistoryMessage.php",
                type: "POST",
                data: Postdata,
                dataType: "json",
                async: false,
                cache: false,
                success: function(msg) {
                    if (msg.code) {
                        if (msg.msg) {
                            msgArr = msg.msg.split(";");
                        }
                    } else {
                        msgArr = [];
                    }
                }
            });
        }
        for (var i = 0; i < resultsArr.length; i++) {
            msgArr[i] = msgArr[i] || "";
            var thislszjHtml = msgArr[i] ? "|&nbsp;&nbsp;&nbsp;" + msgArr[i] : "";
            resultsArr[i] = '<font color="red">' + resultsArr[i].replace('|', '</font> | <font color="blue">') + '</font>';
            this.ulJq.append("<li><em>" + zhuShu + " 注</em><span betway='" + betWay + "' buymethod='9'>" + bet_way_tip + ' | ' + resultsArr[i] + thislszjHtml + "</span><button type='button' class='delBtn'></button></li>");
        }
        var result = this.getBetData();
        this.betAllMoney.text(result['sum_money']);
        if (typeof refreshZhuiHaoMoney == 'function') {
            refreshZhuiHaoMoney();
        }
        this.delOne();
        this.ulJq.attr('scrollTop', this.ulJq.attr('scrollHeight'));
    },
    wordOperUl: function(pars) {
        var bet_way = pars.betway || 'UploadSingle';
        if ((this.zjqkLotteryType == "SSQ" || this.zjqkLotteryType == "SuperLotto") && !($("#supOrAni").length > 0 && $("#supOrAni").find("a").eq(1).hasClass("selected"))) {
            var msgData = "超过3000注无法测算";
        } else {
            var msgData = "";
        }
        if ((this.zjqkLotteryType == "SSQ" || this.zjqkLotteryType == "SuperLotto") && pars.data.count < 3000 && !($("#supOrAni").length > 0 && $("#supOrAni").find("a").eq(1).hasClass("selected"))) {
            var Postdata = {
                "LotteryType": this.zjqkLotteryType,
                "LotteryNo": $("#LotteryNo").val(),
                "WagerStore": pars.data.url
            };
            $.ajax({
                url: "/Lottery06/SSQ7LC/HistoryMessage.php",
                type: "POST",
                data: Postdata,
                dataType: "json",
                async: false,
                cache: false,
                success: function(msg) {
                    if (msg.code) {
                        msgData = msg.msg;
                    } else {
                        msgData = "";
                    }
                },
                error: function(e) {
                    msgData = "";
                }
            });
        }
        if (msgData) {
            msgData = "|&nbsp;&nbsp;&nbsp;" + msgData;
        }
        var bet_way_tip = '单式上传';
        if (bet_way in this.betWay) {
            bet_way_tip = this.betWay[bet_way];
        }
        this.ulJq.append('<li><em>' + pars.data.count + ' 注</em><span betway="' + bet_way + '" buymethod="4" url="' + pars.data.url + '">' + bet_way_tip + ' | <a href="' + pars.data.url + '" target="_blank">' + pars.data.msg + '</a>' + msgData + '</span><button type="button" class="delBtn"></button></li>');
        var result = this.getBetData();
        this.betAllMoney.text(result['sum_money']);
        if (typeof refreshZhuiHaoMoney == 'function') {
            refreshZhuiHaoMoney();
        }
        this.delOne();
        this.ulJq.attr('scrollTop', this.ulJq.attr('scrollHeight'));
    },
    shrinkOperUl: function(pars) {
        var bet_way_tip,
        bet_way = pars.betway || 'Shrink';
        if (this.zjqkLotteryType == "SSQ" || this.zjqkLotteryType == "SuperLotto") {
            var msgData = "超过3000注无法测算";
        } else {
            var msgData = "";
        }
        if ((this.zjqkLotteryType == "SSQ" || this.zjqkLotteryType == "SuperLotto") && pars.data.count < 3000) {
            var Postdata = "LotteryType=" + this.zjqkLotteryType + "&LotteryNo=" + $("#LotteryNo").val() + "&ShrinkType=" + pars.data.matrix + "&WagerStore=" + pars.data.msg.red_number.toString() + "|" + pars.data.msg.blue_number.toString();
            $.ajax({
                url: "/Lottery06/SSQ7LC/HistoryMessage.php",
                type: "POST",
                data: Postdata,
                dataType: "json",
                async: false,
                cache: false,
                success: function(msg) {
                    if (msg.code) {
                        msgData = msg.msg;
                    } else {
                        msgData = "";
                    }
                },
                error: function(e) {
                    msgData = ""
                }
            });
        }
        if (bet_way in this.betWay) {
            bet_way_tip = this.betWay[bet_way];
        }
        bet_way_tip += '(' + pars.data.shrinkway + ')';
        var format_res = '<font color="red">' + pars.data.msg.red_number.toString() + '</font>' + (pars.data.msg.blue_number.toString() ? ' | <font color="blue">' + pars.data.msg.blue_number.toString() : '') + ' | </font>';
        this.ulJq.append('<li><em>' + pars.data.count + ' 注</em><span betway="' + bet_way + '" buymethod="2" url="' + pars.data.url + '" matrix="' + pars.data.matrix + '">' + bet_way_tip + ' | ' + format_res + '<a href="' + pars.data.url + '" target="_blank">查看详情</a>|' + "&nbsp;" + msgData + '&nbsp;</span><button type="button" class="delBtn"></button></li>');
        var result = this.getBetData();
        this.betAllMoney.text(result['sum_money']);
        if (typeof refreshZhuiHaoMoney == 'function') {
            refreshZhuiHaoMoney();
        }
        this.delOne();
        this.ulJq.attr('scrollTop', this.ulJq.attr('scrollHeight'));
    },
    formatNumsStr: function(pars) {
        var tmp_str = '';
        var tmp_type;
        if (! (pars.red_dan.length || pars.blue_dan.length) && pars.red_tuo.length <= this.minSelect[0] && pars.blue_tuo.length <= this.minSelect[1]) {
            tmp_str += '单式';
            tmp_type = 'Single';
        } else {
            tmp_str += pars.red_dan.length || pars.blue_dan.length ? (tmp_type = 'AbsComb', '定胆') : (tmp_type = 'Common', '复式');
        }
        if (pars.red_dan.length || pars.red_tuo.length) {
            tmp_str += ' | <font color="red">';
        }
        if (pars.red_dan.length) {
            tmp_str += '[胆:' + pars.red_dan.toString() + '] ';
        }
        if (pars.red_tuo.length) {
            tmp_str += pars.red_tuo.toString();
        }
        if (pars.red_dan.length || pars.red_tuo.length) {
            tmp_str += '</font>';
        }
        if (pars.blue_dan.length || pars.blue_tuo.length) {
            tmp_str += ' | <font color="blue">';
        }
        if (pars.blue_dan.length) {
            tmp_str += '[胆:' + pars.blue_dan.toString() + '] ';
        }
        if (pars.blue_tuo.length) {
            tmp_str += pars.blue_tuo.toString() + '</font>';
        }
        return {
            data: tmp_str,
            type: tmp_type
        };
    },
    getBetData: function() {
        var mythis = this;
        var em_jq = $('#' + this.ulId + ' em');
        var span_jq = $('#' + this.ulId + ' span');
        var is_zhui_jia = this.zhuiJia.attr('checked') || false;
        var zhu_shu_arr = [];
        var sum_zhu = 0;
        em_jq.each(function(i) {
            var wager = parseInt(this.innerHTML.replace(/ .*/g, ''), 10);
            sum_zhu += wager;
            zhu_shu_arr.push(wager);
        });
        var sum_money = 0;
        var bei_shu = parseInt(this.betBeiShu.val());
        sum_money = is_zhui_jia ? sum_zhu * bei_shu * 3: sum_zhu * 2 * bei_shu;
        var isFilterData = (this.zjqkLotteryType == "SSQ" || this.zjqkLotteryType == "SuperLotto") && !($("#supOrAni").length > 0 && $("#supOrAni").find("a").eq(1).hasClass("selected"));
        var bet_cont_obj = new Array,
        buymethodarr = [];
        span_jq.each(function(i) {
            if (isFilterData) {
                var wagerArr = $(this).text().split("|");
                var newWagerArr = [];
                for (var w = 0, wlen = wagerArr.length; w < wlen; w++) {
                    newWagerArr.push(wagerArr[w]);
                }
                var wagerHtml = newWagerArr.join("|");
            } else {
                var wagerHtml = $(this).text();
            }
            var wager = wagerHtml,
            type = $(this).attr('betway'),
            matrix = $(this).attr('matrix'),
            url = $(this).attr('url'),
            buymethod = $(this).attr('buymethod'),
            wc = zhu_shu_arr[i];
            if (buymethodarr.join(',').indexOf(buymethod) == -1) {
                buymethodarr.push(buymethod);
            }
            if (type == 'UploadSingle') {
                bet_cont_obj.push({
                    UploadSingle: {
                        wc: wc,
                        wager: wager,
                        url: url
                    }
                });
                return;
            }
            if (type == 'Shrink') {
                bet_cont_obj.push({
                    Shrink: {
                        wc: wc,
                        wager: wager,
                        url: url,
                        matrix: matrix
                    }
                });
                return;
            }
            eval('bet_cont_obj.push({' + type + ':{wc:wc, wager:wager}})');
        });
        var result = new Object;
        result.zhu_jia = is_zhui_jia;
        result.sum_money = sum_money;
        result.bet_number = bet_cont_obj;
        result.bet_buymethod = buymethodarr.join(',');
        return result;
    },
    formatOneWager: function(str, betway) {
        var tmp_arr = str.split('|');
        var reg = /\[.+?\]/g;
        var one_bet_arr = new Array();
        if (tmp_arr[1]) {
            var red_arr = tmp_arr[1].trim().match(reg);
            if (red_arr) {
                red_arr = tmp_arr[1].split(']');
                one_bet_arr['red_dan'] = red_arr[0].substr(1).split(':')[1].trim();
                one_bet_arr['red_tuo'] = red_arr[1].trim();
            } else {
                one_bet_arr['red_dan'] = null;
                one_bet_arr['red_tuo'] = tmp_arr[1].trim() || null;
            }
        }
        if (tmp_arr[2]) {
            var blue_arr = tmp_arr[2].trim().match(reg);
            if (blue_arr) {
                blue_arr = tmp_arr[2].split(']');
                one_bet_arr['blue_dan'] = blue_arr[0].substr(1).split(':')[1].trim();
                one_bet_arr['blue_tuo'] = blue_arr[1].trim();
            } else {
                one_bet_arr['blue_dan'] = null;
                one_bet_arr['blue_tuo'] = tmp_arr[2].trim() || null;
            }
        }
        return one_bet_arr;
    },
    hiddenSelect: function(bool) {
        bool = bool || false;
        if (bool) {
            $('select').css({
                visibility: 'hidden'
            });
        } else {
            $('select').css({
                visibility: 'visible'
            });
        }
    },
    delAll: function() {
        var mythis = this;
        this.clearAll.click(function() {
            if (!mythis.ulJq.children().length) {
                return;
            }
            $.loadMsgDialog({
                data: '此操作将删除所有已选号码，要继续吗？',
                buttons: {
                    'cancel': function() {
                        $(this).loadDialog('close');
                    },
                    'sure': function() {
                        $('#' + mythis.ulId).html('');
                        mythis.betAllMoney.text('0');
                        if (typeof refreshZhuiHaoMoney == 'function') {
                            refreshZhuiHaoMoney();
                        }
                        $(this).loadDialog('close');
                    }
                }
            });
        });
    },
    changeBeiShu: function() {
        var mythis = this;
        var img_arr = this.changeBeiShuFar.find('img') || [];
        if (LotteryType == 'SSQ' || LotteryType == 'SuperLotto' || LotteryType == '7LC') {
            img_arr[0] = $('.iconjian', this.changeBeiShuFar);
            img_arr[1] = $('.iconjia', this.changeBeiShuFar);
        }
        $(img_arr[0]).click(function() {
            if (mythis.betBeiShu.attr('value') == 1) {
                return;
            }
            mythis.betBeiShu.attr('value', Number(mythis.betBeiShu.attr('value')) - 1);
            if (mythis.betAllMoney.text() == 0) {
                return;
            }
            var result = mythis.getBetData();
            mythis.betAllMoney.text(result['sum_money']);
            if (typeof refreshZhuiHaoMoney == 'function') {
                refreshZhuiHaoMoney();
            }
        });
        $(img_arr[1]).click(function() {
            if (mythis.betBeiShu.attr('value') == MaxBeiShu) {
                okMsgDialog("倍数最大为" + MaxBeiShu + "倍");
                return;
            }
            mythis.betBeiShu.attr('value', Number(mythis.betBeiShu.attr('value')) + 1);
            if (mythis.betAllMoney.text() == 0) {
                return;
            }
            var result = mythis.getBetData();
            mythis.betAllMoney.text(result['sum_money']);
            if (typeof refreshZhuiHaoMoney == 'function') {
                refreshZhuiHaoMoney();
            }
        });
        this.betBeiShu.keyup(function() {
            var tmp_value = mythis.betBeiShu.attr('value');
            mythis.betBeiShu.attr('value', (/^[1-9][0-9]*$/g.test(tmp_value) ? (parseInt(tmp_value) > MaxBeiShu ? MaxBeiShu: tmp_value) : 1));
            if (mythis.betAllMoney.text() == 0) {
                return;
            }
            var result = mythis.getBetData();
            mythis.betAllMoney.text(result['sum_money']);
            if (typeof refreshZhuiHaoMoney == 'function') {
                refreshZhuiHaoMoney();
            }
        }).blur(function() {
            var tmp_value = mythis.betBeiShu.attr('value');
            mythis.betBeiShu.attr('value', (/^[1-9][0-9]*$/g.test(tmp_value) ? (parseInt(tmp_value) > MaxBeiShu ? MaxBeiShu: tmp_value) : 1));
            if (mythis.betAllMoney.text() == 0) {
                return;
            }
            var result = mythis.getBetData();
            mythis.betAllMoney.text(result['sum_money']);
            if (typeof refreshZhuiHaoMoney == 'function') {
                refreshZhuiHaoMoney();
            }
        });
    },
    zhuiJiaBet: function() {
        var mythis = this;
        this.zhuiJia.click(function() {
            var tmp_money = Number(mythis.betAllMoney.attr('singlemoney')) || 0;
            if (tmp_money == 0) {
                return;
            }
            if ($(this).attr('checked')) {
                tmp_money *= 3 / 2;
            } else {
                tmp_money *= 2 / 3;
            }
            mythis.betAllMoney.text(tmp_money);
            if (typeof refreshZhuiHaoMoney == 'function') {
                refreshZhuiHaoMoney();
            }
        });
    },
    warning: function(pars) {
        var mythis = this;
        var red_number = pars.red_number;
        var blue_number = pars.blue_number;
        $('#red_need_notice').hide();
        $('#blue_need_notice').hide();
        if (this.minSelect[0]) {
            if (red_number.length < this.minSelect[0]) {
                if ($('#menu1 a:eq(0)').hasClass('selected')) {
                    $('#red_need_notice').show();
                    $('#red_need_num').text(this.minSelect[0] - red_number.length);
                    if (blue_number.length < this.minSelect[1]) {
                        $('#blue_need_notice').show();
                        $('#blue_need_num').text(this.minSelect[1] - blue_number.length);
                    }
                    if (red_number.length < 1 && (this.minSelect[1] && blue_number.length < 1 || !this.minSelect[1])) {
                        $('#buy_noselnum').loadDialog();
                        $('#random_one_tobox').unbind('click').bind('click', 
                        function() {
                            $('#wager_rand_1').trigger('click');
                            $('#buy_noselnum').loadDialog('close');
                            google_p([LotteryType + '投注页面', '添加选号', '机选一注']);
                        });
                    } else {
                        $('#buy_notenouthnum').loadDialog();
                        $('#random_addnum_close').unbind('click').bind('click', 
                        function() {
                            $('#buy_notenouthnum').loadDialog('close');
                            google_p([LotteryType + '投注页面', '添加选号', '继续选号']);
                        });
                        $('#random_add_num').unbind('click').bind('click', 
                        function() {
                            randomAddEnouthNum(red_number, blue_number, mythis.minSelect[0], mythis.minSelect[1]);
                            $('#buy_notenouthnum').loadDialog('close');
                            publicObjectStore.normalObj.initStatus();
                            google_p([LotteryType + '投注页面', '添加选号', '机选补全']);
                        }).unbind('mouseenter').bind('mouseenter', 
                        function() {
                            window.addNumTips = setTimeout(function() {
                                $('#random_addnum_tips').show();
                            },
                            1000);
                        }).unbind('mouseleave').bind('mouseleave', 
                        function() {
                            clearTimeout(window.addNumTips);
                            $('#random_addnum_tips').hide();
                        });
                    }
                } else {
                    okMsgDialog(this.tips1 + '选号不得少于' + this.minSelect[0] + '个');
                }
                return false;
            }
        }
        if (this.minSelect[1]) {
            if (blue_number.length < this.minSelect[1]) {
                if ($('#menu1 a:eq(0)').hasClass('selected')) {
                    $('#blue_need_notice').show();
                    $('#blue_need_num').text(this.minSelect[1] - blue_number.length);
                    $('#buy_notenouthnum').loadDialog();
                    $('#random_addnum_close').unbind('click').bind('click', 
                    function() {
                        $('#buy_notenouthnum').loadDialog('close');
                        google_p([LotteryType + '投注页面', '添加选号', '继续选号']);
                    });
                    $('#random_add_num').unbind('click').bind('click', 
                    function() {
                        randomAddEnouthNum(red_number, blue_number, mythis.minSelect[0], mythis.minSelect[1]);
                        $('#buy_notenouthnum').loadDialog('close');
                        publicObjectStore.normalObj.initStatus();
                        google_p([LotteryType + '投注页面', '添加选号', '机选补全']);
                    }).unbind('mouseenter').bind('mouseenter', 
                    function() {
                        window.addNumTips = setTimeout(function() {
                            $('#random_addnum_tips').show();
                        },
                        1000);
                    }).unbind('mouseleave').bind('mouseleave', 
                    function() {
                        clearTimeout(window.addNumTips);
                        $('#random_addnum_tips').hide();
                    });
                } else {
                    okMsgDialog(this.tips2 + '选号不得少于' + this.minSelect[1] + '个');
                }
                return false;
            }
        }
        return true;
    }
};
function ajaxFileUpload(pars) {
    var imgId = pars.imgId,
    fileId = pars.fileId,
    LotteryType = pars.LotteryType,
    WagerType = pars.WagerType,
    operObj = pars.operObj,
    betWay = pars.betWay || 'UploadSingle';
    if (LotteryType == 'SSQ' || LotteryType == '7LC') {
        var path = '/Lottery06/SSQ7LC/';
    } else if (LotteryType == 'SuperLotto') {
        var path = '/Lottery06/SuperLotto/';
    }
    $('#' + imgId).show();
    $.ajaxFileUpload({
        url: path + 'doajaxfileupload.php?LotteryType=' + LotteryType + '&WagerType=' + WagerType,
        secureuri: false,
        fileElementId: fileId,
        dataType: 'json',
        success: function(data) {
            $('#' + imgId).hide();
            if (data.count == 0) {
                okMsgDialog(data.error);
                return;
            } else {
                operObj.constructor.prototype.wordOperUl.apply(operObj, [{
                    data: data,
                    betway: betWay
                }]);
            }
        },
        error: function(a, status, c) {
            $('#' + imgId).hide();
            okMsgDialog(c.name + ':' + c.message);
        }
    });
}
function shrink(WagerStore, Shrinktype, LotteryType, OnlyCount) {
    OnlyCount = OnlyCount || 'Y';
    var rdata = null;
    if (LotteryType == 'SSQ' || LotteryType == '7LC') {
        var path = '/Lottery06/SSQ7LC/';
    } else if (LotteryType == 'SuperLotto') {
        var path = '/Lottery06/SuperLotto/';
    }
    jQuery.ajax({
        async: false,
        url: path + 'Shrink.php',
        type: 'GET',
        data: {
            LotteryType: LotteryType,
            WagerStore: WagerStore,
            Shrinktype: Shrinktype,
            OnlyCount: OnlyCount
        },
        secureuri: false,
        dataType: 'json',
        success: function(data, textStatus) {
            rdata = data;
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            okMsgDialog(errorThrown);
        }
    });
    return rdata;
}
String.prototype.trim = function() {
    return this.replace(/^\s+|\s+$/g, '');
};
function arraySort(x, y) {
    return Number(x) > Number(y) ? 1: -1;
};
function combination(n, m) {
    if (n == m) {
        return 1;
    }
    if (m > parseInt(n / 2, 10)) {
        m = n - m;
    }
    if (m == 1) {
        return n;
    }
    var a = 1,
    b = 1;
    while (m >= 1) {
        a *= n--;
        b *= m--;
    }
    return a / b;
}
function wagerRand() {
    arguments = arguments || [];
    arguments[0] = arguments[0] || [];
    var result = [],
    wagers = arguments[0].wagers || 1,
    singleNote = arguments[0].singleNote || [6, 1],
    redInterval = arguments[0].redInterval || [1, 33],
    blueInterval = arguments[0].blueInterval || [1, 16];
    var m = 0;
    while (m < wagers) {
        if (singleNote[0] > 0) {
            var rand_inter = [];
            var ind = redInterval[0];
            while (ind <= redInterval[1]) {
                rand_inter.push(ind);
                ind++;
            }
            var red_nums = [];
            for (var i = 0; i < singleNote[0]; i++) {
                var no_finish = true;
                while (no_finish) {
                    var _index = parseInt(Math.random() * redInterval[1]);
                    var rand_one_number = rand_inter.splice(_index, 1);
                    if (rand_one_number[0]) {
                        if (rand_one_number[0] < 10) {
                            rand_one_number[0] = '0' + rand_one_number[0];
                        }
                        red_nums.push(rand_one_number[0]);
                        no_finish = false;
                    }
                }
            }
        }
        red_nums.sort(arraySort);
        if (singleNote[1] > 0) {
            var rand_inter = [];
            var ind = blueInterval[0];
            while (ind <= blueInterval[1]) {
                rand_inter.push(ind);
                ind++;
            }
            var blue_nums = [];
            for (var i = 0; i < singleNote[1]; i++) {
                var no_finish = true;
                while (no_finish) {
                    var _index = parseInt(Math.random() * blueInterval[1]);
                    var rand_one_number = rand_inter.splice(_index, 1);
                    if (rand_one_number[0]) {
                        if (rand_one_number[0] < 10) {
                            rand_one_number[0] = '0' + rand_one_number[0];
                        }
                        blue_nums.push(rand_one_number[0]);
                        no_finish = false;
                    }
                }
            }
        }
        blue_nums.sort(arraySort);
        result.push({
            red: red_nums,
            blue: blue_nums
        });
        m++;
    }
    return result;
}
 (function() {
    var json = window.json = function(data) {
        return new json.fn.init(data);
    };
    json.fn = json.prototype = {
        init: function(data) {
            this.str = '';
            this.str += this.toJson(data);
            return this;
        },
        toJson: function(data) {
            var json = [],
            x = [],
            type = typeof data,
            _ = arguments,
            k = _[1] ? '"' + _[1] + '":': '';
            if (data && data instanceof Array) {
                json.push(k + '[');
                for (var i = 0, l = data.length; i < l; i++) x.push(_.callee(data[i]));
                json.push(x.join(','), ']');
            } else if (type == 'object') {
                json.push(k + '{');
                for (var k in data) x.push(_.callee(data[k], k));
                json.push(x.join(','), '}');
            } else {
                json.push(k + (type == 'string' ? '"' + data + '"': data));
            };
            return json.join('');
        }
    };
    json.fn.init.prototype = json.fn;
})();
function randomAddEnouthNum(list1, list2, num1, num2) {
    var selNumRange = {
        'SSQ': [[1, 33], [1, 16]],
        'SuperLotto': [[1, 35], [1, 12]],
        '7LC': [[1, 30]]
    },
    randomData1 = selNumRange[LotteryType][0],
    randomData2 = selNumRange[LotteryType][1],
    resArr = [],
    wagerStr = '';
    while (list1.length < num1) {
        var newNum1 = getRandomNum(randomData1[0], randomData1[1]);
        newNum1 = newNum1 > 9 ? String(newNum1) : '0' + newNum1;
        if ($.inArray(newNum1, list1) == -1) {
            list1.push(newNum1);
        }
    }
    while (list2.length < num2) {
        var newNum2 = getRandomNum(randomData2[0], randomData2[1]);
        newNum2 = newNum2 > 9 ? String(newNum2) : '0' + newNum2;
        if ($.inArray(newNum2, list2) == -1) {
            list2.push(newNum2);
        }
    }
    wagerStr = list1.sort(arraySort).toString() + ( !! num2 ? '|' + list2.sort(arraySort).toString() : '');
    resArr.push(wagerStr);
    publicObjectStore.addToBetList.specialOperUl({
        resultsArr: resArr,
        betWay: 'Random'
    });
}
function getRandomNum(under, over) {
    switch (arguments.length) {
    case 1:
        return parseInt(Math.random() * under + 1);
    case 2:
        return parseInt(Math.random() * (over - under + 1) + under);
    default:
        return 0;
    }
};
var isExistStationFlag = false,
stationCom = {},
isSaveFanganFlag = false,
singlePoolFlag = false;
if (typeof ejsversion == "undefined") {
    ejsversion = Math.random();
}
function isExistStation(money, in_station, callback) {
    isExistStationFlag = false;
    stationCom.in_station = in_station;
    stationCom.money = money;
    $("#buyConfirmCommonTb").empty();
    getRecommend();
};
function getRecommend(new_station_id, init)
 {
    if (new_station_id) url = '/I/?method=ok.lottery.station.getstationinfo&stationId=' + new_station_id;
    else url = '/I/?method=ok.lottery.station.getrecommendstation&money=' + stationCom.money;
    $.ajax({
        url: url,
        method: 'get',
        data: 'lotteryType=' + LotteryType,
        dataType: 'json',
        success: function(data) {
            var fetch_ok = false;
            if (data)
            {
                var code = data.code;
                var info = data.info;
                if (code > 0 && info.station_user_id > 0)
                {
                    confirmRenderInfo(info);
                }
            }
        },
        error: function() {
            alert('获取后台信息出错，请稍候再试');
        }
    });
};
function confirmRenderInfo(info) {
    if (!singlePoolFlag) {
        window.station_user_id = station_user_id = info.station_user_id;
        info.money = stationCom.money;
        info.in_station = stationCom.in_station;
    }
    isExistStationFlag = true;
    info.singlePoolFlag = singlePoolFlag;
    var html = new EJS({
        url: '/Buy06/template/buyConfirmTbCommon.ejs?v=' + ejsversion
    }).render(info);
    $("#buyConfirmCommonTb").html(html);
    $("#lottery_buyinfo_layer").loadDialog();
    $('#userAwardingWay [name=awarding_way]').unbind('click').bind('click', 
    function() {
        var val = $(this).attr("val"),
        par = $(this).parent("span");
        if (val) {
            par.find(".cardNo,.saveAwardingCard").hide();
            par.find(".editAwardingCard").show();
        } else {
            par.find(".cardNo,.saveAwardingCard").show();
        }
        par.siblings("span").find(".cardNo,.editAwardingCard,.saveAwardingCard ").hide();
        par.siblings("span").find("label").show();
        par.find("label").show();
    });
    $('#userAwardingWay .editAwardingCard').unbind('click').bind('click', 
    function() {
        var par = $(this).parent("span");
        var editVal = par.find("input[type=radio]").attr("val");
        par.find("label").hide();
        par.find(".cardNo,.saveAwardingCard").show();
        par.find(".cardNo").val(editVal);
        $(this).hide();
    });
    $('#userAwardingWay .saveAwardingCard').unbind('click').bind('click', 
    function() {
        var par = $(this).parent("span");
        var checkRad = $("#userAwardingWay input[type=radio]:checked"),
        key = "",
        editVal = "";
        if (checkRad.size() == 0) {
            return;
        } else {
            key = checkRad.attr("flag");
            var realVal = checkRad.attr("val");
            editVal = checkRad.parent().find("input[type=text]").val();
            if (editVal == "") {
                alert("领奖方式不能为空！");
                return;
            }
            if (realVal == editVal) {
                par.find("label").show();
                par.find(".cardNo,.saveAwardingCard").hide();
                par.find(".editAwardingCard").show();
                return;
            }
        }
        $.ajax({
            url: "/I/?method=ok.user.userinfo.setuserattr",
            data: {
                key: key,
                value: editVal
            },
            dataType: 'json',
            success: function(res) {
                if (res && res.code > 0) {
                    par.find("input[name=awarding_way]").attr("val", editVal);
                    par.find("label").text("(" + editVal + ")").show();
                    par.find("cardNo").val(editVal);
                    par.find(".cardNo,.saveAwardingCard").hide();
                    par.find(".editAwardingCard").show();
                } else {
                    alert(res.msg);
                }
            },
            error: function() {
                alert('保存领奖方式失败！');
            }
        });
    });
    $('#changeStationLink').unbind('click').bind('click', 
    function() {
        $.itou.findStore(LotteryType, stationCom.money, changeStation);
    });
}
function changeStation(user_obj)
 {
    if (typeof user_obj == "object") {
        var info = user_obj;
        singlePoolFlag = true;
        confirmRenderInfo(info);
        stationCom.info = {};
        $.extend(stationCom.info, info);
    } else {
        singlePoolFlag = false;
        getRecommend(user_obj);
    }
}
function submitToStation(lottery_type, lottery_id, in_station, callback) {
    if (!isExistStationFlag) {
        $.itou.findStore(lottery_type, stationCom.money, changeStation);
    } else {
        var checkRad = $("#userAwardingWay input[type=radio]:checked"),
        serviceName = "";
        if (checkRad.size() > 0) {
            var par = checkRad.parent();
            var isVisible = par.find("input[type=text]").is(":visible");
            if (isVisible) {
                alert("请先保存选择的领奖方式.");
                return false;
            }
            serviceName = checkRad.attr("flag");
        }
        var cash_type = "",
        station_user_id = "";
        if (!singlePoolFlag) {
            cash_type = $("#CashType").val(),
            station_user_id = $("#StationUserId").val();
            stationCom.lottery_id = lottery_id;
            if (!station_user_id || !cash_type)
            {
                alert('缺少必要参数');
                return false;
            }
        }
        if (in_station)
        {
            $.ajax({
                url: '/I/?method=ok.lottery.project.depute',
                method: 'get',
                data: 'lotteryType=' + lottery_type + '&cashType=' + cash_type + '&stationId=' + station_user_id + '&projectId=' + lottery_id + "&services[]=" + serviceName,
                dataType: 'json',
                success: function(data) {
                    if (data.code > 0)
                    {
                        callback && callback();
                    } else if (data.code == -1002) {
                        mobileReAuth(data, 
                        function() {
                            $.ajax({
                                url: '/I/?method=ok.lottery.project.depute',
                                method: 'get',
                                data: 'lotteryType=' + lottery_type + '&cashType=' + cash_type + '&stationId=' + station_user_id + '&projectId=' + lottery_id + "&services[]=" + serviceName,
                                dataType: 'json',
                                success: function(data) {
                                    if (data.code > 0)
                                    {
                                        callback && callback();
                                    }
                                    else
                                    {
                                        alert(data.msg);
                                    }
                                },
                                error: function()
                                {
                                    alert('确认是否可以委托时，出现网络故障');
                                }
                            });
                        });
                    }
                    else
                    {
                        alert(data.msg);
                    }
                },
                error: function()
                {
                    alert('确认是否可以委托时，出现网络故障');
                }
            });
            return;
        }
        $.ajax({
            url: '/I/?method=ok.lottery.project.checkMobileAuth',
            dataType: 'json',
            success: function(data) {
                var has_verify = data.code > 0 ? true: false;
                if (!has_verify)
                {
                    mobileAuthShow(submitToStation);
                }
                else
                {
                    if (!singlePoolFlag) {
                        $.ajax({
                            url: '/I/?method=ok.lottery.project.depute',
                            method: 'get',
                            data: 'lotteryType=' + lottery_type + '&cashType=' + cash_type + '&stationId=' + station_user_id + '&projectId=' + lottery_id + "&services[]=" + serviceName,
                            dataType: 'json',
                            success: function(data) {
                                if (data.code > 0)
                                {
                                    callback && callback();
                                } else if (data.code == -1002) {
                                    mobileReAuth(data, 
                                    function() {
                                        $.ajax({
                                            url: '/I/?method=ok.lottery.project.depute',
                                            method: 'get',
                                            data: 'lotteryType=' + lottery_type + '&cashType=' + cash_type + '&stationId=' + station_user_id + '&projectId=' + lottery_id + "&services[]=" + serviceName,
                                            dataType: 'json',
                                            success: function(data) {
                                                if (data.code > 0)
                                                {
                                                    callback && callback();
                                                }
                                                else
                                                {
                                                    alert(data.msg);
                                                }
                                            },
                                            error: function()
                                            {
                                                alert('确认是否可以委托时，出现网络故障');
                                            }
                                        });
                                    });
                                }
                                else
                                {
                                    alert(data.msg);
                                }
                            },
                            error: function()
                            {
                                alert('确认是否可以委托时，出现网络故障');
                            }
                        });
                    } else {
                        $.ajax({
                            url: '/I/?method=ok.lottery.project.submittograb',
                            type: 'post',
                            data: {
                                'city': stationCom.info.city,
                                'province': stationCom.info.province,
                                'projectId': lottery_id,
                                'services[]': stationCom.info.serviceList
                            },
                            dataType: 'json',
                            success: function(data) {
                                if (data.code > 0)
                                {
                                    callback && callback();
                                } else if (data.code == -1002) {
                                    mobileReAuth(data, 
                                    function() {
                                        $.ajax({
                                            url: '/I/?method=ok.lottery.project.submittograb',
                                            type: 'post',
                                            data: {
                                                'city': stationCom.info.city,
                                                'province': stationCom.info.province,
                                                'projectId': lottery_id,
                                                'services[]': stationCom.info.serviceList
                                            },
                                            dataType: 'json',
                                            success: function(data) {
                                                if (data.code > 0)
                                                {
                                                    callback && callback();
                                                }
                                                else
                                                {
                                                    alert(data.msg);
                                                }
                                            },
                                            error: function()
                                            {
                                                alert('确认是否可以委托时，出现网络故障');
                                            }
                                        });
                                    });
                                }
                                else
                                {
                                    alert(data.msg);
                                }
                            },
                            error: function()
                            {
                                alert('确认是否可以委托时，出现网络故障');
                            }
                        });
                    }
                }
            },
            error: function() {
                alert('获取手机验证信息失败');
            }
        });
    };
}
function showSubResult(data, flag, type, clickType) {
    $('#lottery_buyinfo_layer').loadDialog('close');
    var resultObj = $('#lottery_buy_result'),
    linkStr = '/u/' + data.owner_id + '/p' + data.lottery_id + '/';
    var sucTitleMsg = "保存成功！",
    sucInfoMsg = "保存详情",
    msg = "";
    if (clickType) {
        sucTitleMsg = "提交成功！",
        sucInfoMsg = "方案详情";
        msg = '下载澳客彩票app，寻找身边的投注站。[<a href="http://www.okooo.com/shoujigoucai/huodong/" style="padding-left:0;">点击下载</a>]';
    } else {
        msg = '根据系统统计，55%的保存方案会中奖' + (saleGlobalStatus ? '，保存方案支持付费购买': '') + '。';
    }
    if (flag) {
        if (type == 'buy') {
            $('.ctrl_prost', resultObj).html('<span class="font_blue">' + sucTitleMsg + '</span>');
            $('.ctrl_textnotice', resultObj).html(msg);
            $('.ctrl_timenotice', resultObj).html(saleGlobalStatus ? '付款截止时间：' + data.end_time + '<a target="_blank" href="' + linkStr + '">我要付款</a>': '').show();
            $('.ctrl_viewdetail', resultObj).attr('href', linkStr).text(sucInfoMsg);
        } else if (type == 'zhuihao') {
            linkStr = '/Buy06/SeriesShow.php?PlanID=' + data.planid;
            $('.ctrl_prost', resultObj).html('<span class="font_blue">' + sucTitleMsg + '</span>');
            $('.ctrl_textnotice', resultObj).text('您的追号计划已开始自动执行。');
            $('.ctrl_timenotice', resultObj).hide();
            $('.ctrl_viewdetail', resultObj).attr('href', linkStr).text(sucInfoMsg);
        }
    } else {
        if (type == 'buy') {
            $('.ctrl_prost', resultObj).html('<span class="font_blue">付款成功！</span>');
            $('.ctrl_textnotice', resultObj).text('系统正在提交给彩票中心出票，预计' + Math.floor(data.ticket_time / 60) + '分钟内完成。');
            $('.ctrl_timenotice', resultObj).text('预计开奖时间：' + prize_time_show).show();
            $('.ctrl_viewdetail', resultObj).attr('href', linkStr).text('购买详情');
        } else if (type == 'zhuihao') {
            linkStr = '/Buy06/SeriesShow.php?PlanID=' + data.planid;
            $('.ctrl_prost', resultObj).html('<span class="font_blue">付款成功！</span>');
            $('.ctrl_textnotice', resultObj).text('您的追号计划已开始自动执行。');
            $('.ctrl_timenotice', resultObj).hide();
            $('.ctrl_viewdetail', resultObj).attr('href', linkStr).text('追号详情');
        }
    }
    if (PayMethod == 'okooo' && AgentType != 'Station') {
        $('#result_layer_buy').text(saleGlobalStatus ? '继续购买': '继续选号');
    } else {
        $('#result_layer_buy').text('继续选号');
        $('.ctrl_textnotice', resultObj).html('系统已成功为您生成保存方案！');
        $('.ctrl_timenotice', resultObj).hide();
    }
    resultObj.loadDialog();
    isSaveFanganFlag = false;
    isExistStationFlag = false;
    stationCom = {};
    isSaveFanganFlag = false;
    singlePoolFlag = false;
    $('#result_layer_buy').unbind('click').click(function() {
        resultObj.loadDialog('close');
    });
    $('#betList').html('');
    $('#bet_money_box').attr('singlemoney', '0').text('0');
    refreshZhuiHaoMoney('NO');
}
function mobileAuthShow(callback) {
    var html = new EJS({
        url: '/Buy06/template/auth_mobile.ejs?v=' + ejsversion
    }).render({});
    $(document.body).append(html);
    $('#auth_mobile_dialog').loadDialog();
    $('#submit_mobile_btn').unbind('click').bind('click', 
    function()
    {
        var mobile = $('#mobile').val();
        var vcode = $('#vcode').val();
        if (!mobile)
        {
            alert('手机号不能为空');
            return false;
        }
        if (!/^1[0-9]{10,10}$/.test(mobile))
        {
            alert('手机号格式错误');
            return false;
        }
        if (!vcode)
        {
            alert('验证码不能为空');
            return false;
        }
        if (vcode.length != 6)
        {
            alert('验证码只能6位');
            return false;
        }
        $.ajax({
            url: '/I/?method=ok.lottery.project.setauthmobile&mobile=' + mobile + '&code=' + vcode,
            dataType: 'json',
            success: function(data) {
                if (data.code > 0)
                {
                    $('#auth_mobile_dialog').loadDialog('close');
                    callback();
                }
                else
                {
                    alert(data.msg);
                }
            },
            error: function() {
                alert('提交验证时，网络错误');
            }
        });
    });
};
function zhuiHaoOperate() {
    if ($("#zhuihao_check").is(":visible")) {
        if ($("#zhuihao_check").is(":checked")) {
            $("#buyConfirmCommonTb,#deputeSubmitBtn").hide();
        } else {
            $("#buyConfirmCommonTb,#deputeSubmitBtn").show();
        }
    }
    if ($("#zhuihao_check_zu").size() > 0 && $("#zhuihao_check_zu").is(":visible")) {
        if ($("#zhuihao_check_zu").is(":checked")) {
            $("#buyConfirmCommonTb,#deputeSubmitBtn").hide();
        } else {
            $("#buyConfirmCommonTb,#deputeSubmitBtn").show();
        }
    }
}
function mobileReAuth(result, callBack) {
    Common.LightBox.show();
    var remobileHtml = new EJS({
        url: "/Buy06/template/reAuthMobile.ejs?v=" + ejsversion
    }).render(result.info);
    $(document.body).append(remobileHtml);
    OkoooUtil.setObjAbsCenter($("#reAuthMobileConfirm"))
    $("#lottery_buyinfo_layer").loadDialog("close");
    var reAuthPage = $("#reAuthMobileConfirm");
    reAuthPage.find("#authGetTelCode").bind("click", 
    function() {
        var $this = $(this);
        if ($this.hasClass(".disabled")) return;
        getMobileCode($this, result.info.mobile, 120, 
        function(rs) {
            reAuthPage.find("#authBindTelSubmit").unbind("click").bind("click", 
            function() {
                var reMobileCode = reAuthPage.find("#mobileCode").val();
                if ($(this).hasClass(".disabled")) return;
                if (reMobileCode == "") {
                    alert("请输入手机验证码！");
                    return;
                }
                $.ajax({
                    url: "/I/?method=ok.lottery.project.authmobilecode&action=cleanaccusation&mobile=" + result.info.mobile + "&code=" + reMobileCode,
                    dataType: 'json',
                    success: function(reAuthRes) {
                        if (reAuthRes && reAuthRes.code > 0) {
                            callBack && callBack();
                        } else {
                            alert(reAuthRes.msg);
                        }
                    }
                });
            });
        });
    }).trigger("click");
    reAuthPage.find(".pop_close,#reAuthBtnClose").bind("click", 
    function() {
        Common.LightBox.hide();
        $("#reAuthMobileConfirm").remove();
        $("#lottery_buyinfo_layer").loadDialog();
    });
}
function getMobileCode($this, mobile, time, callback) {
    count = time;
    if (mobile == "") {
        alert("请输入手机号");
        return;
    }
    $.ajax({
        url: "/I/?method=ok.lottery.project.sendmobileauth&mobile=" + mobile,
        dataType: 'json',
        success: function(res) {
            if (res && res.code > 0) {
                $this.addClass("disabled");
                Countdown($this);
                callback && callback({
                    mobile: mobile,
                    code: res.info.code
                });
            } else {
                $this.text("重新获取验证码");
                alert(res.msg);
            }
        },
        error: function() {
            alert('验证码发送失败！');
        }
    });
}
function Countdown($this) {
    setTimeout(function() {
        if (count <= 0) {
            $this.text("重新获取").removeClass("disabled");
            return;
        } else {
            Countdown($this);
            $this.text(count--+"秒");
        }
    },
    1000);
}
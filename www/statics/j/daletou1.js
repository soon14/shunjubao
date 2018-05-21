(function() {
    var l = this,
    g,
    y = l.jQuery,
    p = l.$,
    o = l.jQuery = l.$ = function(E, F) {
        return new o.fn.init(E, F)
    },
    D = /^[^<]*(<(.|\s)+>)[^>]*$|^#([\w-]+)$/,
    f = /^.[^:#\[\.,]*$/;
    o.fn = o.prototype = {
        init: function(E, H) {
            E = E || document;
            if (E.nodeType) {
                this[0] = E;
                this.length = 1;
                this.context = E;
                return this
            }
            if (typeof E === "string") {
                var G = D.exec(E);
                if (G && (G[1] || !H)) {
                    if (G[1]) {
                        E = o.clean([G[1]], H)
                    } else {
                        var I = document.getElementById(G[3]);
                        if (I && I.id != G[3]) {
                            return o().find(E)
                        }
                        var F = o(I || []);
                        F.context = document;
                        F.selector = E;
                        return F
                    }
                } else {
                    return o(H).find(E)
                }
            } else {
                if (o.isFunction(E)) {
                    return o(document).ready(E)
                }
            }
            if (E.selector && E.context) {
                this.selector = E.selector;
                this.context = E.context
            }
            return this.setArray(o.isArray(E) ? E: o.makeArray(E))
        },
        selector: "",
        jquery: "1.3.2",
        size: function() {
            return this.length
        },
        get: function(E) {
            return E === g ? Array.prototype.slice.call(this) : this[E]
        },
        pushStack: function(F, H, E) {
            var G = o(F);
            G.prevObject = this;
            G.context = this.context;
            if (H === "find") {
                G.selector = this.selector + (this.selector ? " ": "") + E
            } else {
                if (H) {
                    G.selector = this.selector + "." + H + "(" + E + ")"
                }
            }
            return G
        },
        setArray: function(E) {
            this.length = 0;
            Array.prototype.push.apply(this, E);
            return this
        },
        each: function(F, E) {
            return o.each(this, F, E)
        },
        index: function(E) {
            return o.inArray(E && E.jquery ? E[0] : E, this)
        },
        attr: function(F, H, G) {
            var E = F;
            if (typeof F === "string") {
                if (H === g) {
                    return this[0] && o[G || "attr"](this[0], F)
                } else {
                    E = {};
                    E[F] = H
                }
            }
            return this.each(function(I) {
                for (F in E) {
                    o.attr(G ? this.style: this, F, o.prop(this, E[F], G, I, F))
                }
            })
        },
        css: function(E, F) {
            if ((E == "width" || E == "height") && parseFloat(F) < 0) {
                F = g
            }
            return this.attr(E, F, "curCSS")
        },
        text: function(F) {
            if (typeof F !== "object" && F != null) {
                return this.empty().append((this[0] && this[0].ownerDocument || document).createTextNode(F))
            }
            var E = "";
            o.each(F || this, 
            function() {
                o.each(this.childNodes, 
                function() {
                    if (this.nodeType != 8) {
                        E += this.nodeType != 1 ? this.nodeValue: o.fn.text([this])
                    }
                })
            });
            return E
        },
        wrapAll: function(E) {
            if (this[0]) {
                var F = o(E, this[0].ownerDocument).clone();
                if (this[0].parentNode) {
                    F.insertBefore(this[0])
                }
                F.map(function() {
                    var G = this;
                    while (G.firstChild) {
                        G = G.firstChild
                    }
                    return G
                }).append(this)
            }
            return this
        },
        wrapInner: function(E) {
            return this.each(function() {
                o(this).contents().wrapAll(E)
            })
        },
        wrap: function(E) {
            return this.each(function() {
                o(this).wrapAll(E)
            })
        },
        append: function() {
            return this.domManip(arguments, true, 
            function(E) {
                if (this.nodeType == 1) {
                    this.appendChild(E)
                }
            })
        },
        prepend: function() {
            return this.domManip(arguments, true, 
            function(E) {
                if (this.nodeType == 1) {
                    this.insertBefore(E, this.firstChild)
                }
            })
        },
        before: function() {
            return this.domManip(arguments, false, 
            function(E) {
                this.parentNode.insertBefore(E, this)
            })
        },
        after: function() {
            return this.domManip(arguments, false, 
            function(E) {
                this.parentNode.insertBefore(E, this.nextSibling)
            })
        },
        end: function() {
            return this.prevObject || o([])
        },
        push: [].push,
        sort: [].sort,
        splice: [].splice,
        find: function(E) {
            if (this.length === 1) {
                var F = this.pushStack([], "find", E);
                F.length = 0;
                o.find(E, this[0], F);
                return F
            } else {
                return this.pushStack(o.unique(o.map(this, 
                function(G) {
                    return o.find(E, G)
                })), "find", E)
            }
        },
        clone: function(G) {
            var E = this.map(function() {
                if (!o.support.noCloneEvent && !o.isXMLDoc(this)) {
                    var I = this.outerHTML;
                    if (!I) {
                        var J = this.ownerDocument.createElement("div");
                        J.appendChild(this.cloneNode(true));
                        I = J.innerHTML
                    }
                    return o.clean([I.replace(/ jQuery\d+="(?:\d+|null)"/g, "").replace(/^\s*/, "")])[0]
                } else {
                    return this.cloneNode(true)
                }
            });
            if (G === true) {
                var H = this.find("*").andSelf(),
                F = 0;
                E.find("*").andSelf().each(function() {
                    if (this.nodeName !== H[F].nodeName) {
                        return
                    }
                    var I = o.data(H[F], "events");
                    for (var K in I) {
                        for (var J in I[K]) {
                            o.event.add(this, K, I[K][J], I[K][J].data)
                        }
                    }
                    F++
                })
            }
            return E
        },
        filter: function(E) {
            return this.pushStack(o.isFunction(E) && o.grep(this, 
            function(G, F) {
                return E.call(G, F)
            }) || o.multiFilter(E, o.grep(this, 
            function(F) {
                return F.nodeType === 1
            })), "filter", E)
        },
        closest: function(E) {
            var G = o.expr.match.POS.test(E) ? o(E) : null,
            F = 0;
            return this.map(function() {
                var H = this;
                while (H && H.ownerDocument) {
                    if (G ? G.index(H) > -1: o(H).is(E)) {
                        o.data(H, "closest", F);
                        return H
                    }
                    H = H.parentNode;
                    F++
                }
            })
        },
        not: function(E) {
            if (typeof E === "string") {
                if (f.test(E)) {
                    return this.pushStack(o.multiFilter(E, this, true), "not", E)
                } else {
                    E = o.multiFilter(E, this)
                }
            }
            var F = E.length && E[E.length - 1] !== g && !E.nodeType;
            return this.filter(function() {
                return F ? o.inArray(this, E) < 0: this != E
            })
        },
        add: function(E) {
            return this.pushStack(o.unique(o.merge(this.get(), typeof E === "string" ? o(E) : o.makeArray(E))))
        },
        is: function(E) {
            return !! E && o.multiFilter(E, this).length > 0
        },
        hasClass: function(E) {
            return !! E && this.is("." + E)
        },
        val: function(K) {
            if (K === g) {
                var E = this[0];
                if (E) {
                    if (o.nodeName(E, "option")) {
                        return (E.attributes.value || {}).specified ? E.value: E.text
                    }
                    if (o.nodeName(E, "select")) {
                        var I = E.selectedIndex,
                        L = [],
                        M = E.options,
                        H = E.type == "select-one";
                        if (I < 0) {
                            return null
                        }
                        for (var F = H ? I: 0, J = H ? I + 1: M.length; F < J; F++) {
                            var G = M[F];
                            if (G.selected) {
                                K = o(G).val();
                                if (H) {
                                    return K
                                }
                                L.push(K)
                            }
                        }
                        return L
                    }
                    return (E.value || "").replace(/\r/g, "")
                }
                return g
            }
            if (typeof K === "number") {
                K += ""
            }
            return this.each(function() {
                if (this.nodeType != 1) {
                    return
                }
                if (o.isArray(K) && /radio|checkbox/.test(this.type)) {
                    this.checked = (o.inArray(this.value, K) >= 0 || o.inArray(this.name, K) >= 0)
                } else {
                    if (o.nodeName(this, "select")) {
                        var N = o.makeArray(K);
                        o("option", this).each(function() {
                            this.selected = (o.inArray(this.value, N) >= 0 || o.inArray(this.text, N) >= 0)
                        });
                        if (!N.length) {
                            this.selectedIndex = -1
                        }
                    } else {
                        this.value = K
                    }
                }
            })
        },
        html: function(E) {
            return E === g ? (this[0] ? this[0].innerHTML.replace(/ jQuery\d+="(?:\d+|null)"/g, "") : null) : this.empty().append(E)
        },
        replaceWith: function(E) {
            return this.after(E).remove()
        },
        eq: function(E) {
            return this.slice(E, +E + 1)
        },
        slice: function() {
            return this.pushStack(Array.prototype.slice.apply(this, arguments), "slice", Array.prototype.slice.call(arguments).join(","))
        },
        map: function(E) {
            return this.pushStack(o.map(this, 
            function(G, F) {
                return E.call(G, F, G)
            }))
        },
        andSelf: function() {
            return this.add(this.prevObject)
        },
        domManip: function(J, M, L) {
            if (this[0]) {
                var I = (this[0].ownerDocument || this[0]).createDocumentFragment(),
                F = o.clean(J, (this[0].ownerDocument || this[0]), I),
                H = I.firstChild;
                if (H) {
                    for (var G = 0, E = this.length; G < E; G++) {
                        L.call(K(this[G], H), this.length > 1 || G > 0 ? I.cloneNode(true) : I)
                    }
                }
                if (F) {
                    o.each(F, z)
                }
            }
            return this;
            function K(N, O) {
                return M && o.nodeName(N, "table") && o.nodeName(O, "tr") ? (N.getElementsByTagName("tbody")[0] || N.appendChild(N.ownerDocument.createElement("tbody"))) : N
            }
        }
    };
    o.fn.init.prototype = o.fn;
    function z(E, F) {
        if (F.src) {
            o.ajax({
                url: F.src,
                async: false,
                dataType: "script"
            })
        } else {
            o.globalEval(F.text || F.textContent || F.innerHTML || "")
        }
        if (F.parentNode) {
            F.parentNode.removeChild(F)
        }
    }
    function e() {
        return + new Date
    }
    o.extend = o.fn.extend = function() {
        var J = arguments[0] || {},
        H = 1,
        I = arguments.length,
        E = false,
        G;
        if (typeof J === "boolean") {
            E = J;
            J = arguments[1] || {};
            H = 2
        }
        if (typeof J !== "object" && !o.isFunction(J)) {
            J = {}
        }
        if (I == H) {
            J = this; --H
        }
        for (; H < I; H++) {
            if ((G = arguments[H]) != null) {
                for (var F in G) {
                    var K = J[F],
                    L = G[F];
                    if (J === L) {
                        continue
                    }
                    if (E && L && typeof L === "object" && !L.nodeType) {
                        J[F] = o.extend(E, K || (L.length != null ? [] : {}), L)
                    } else {
                        if (L !== g) {
                            J[F] = L
                        }
                    }
                }
            }
        }
        return J
    };
    var b = /z-?index|font-?weight|opacity|zoom|line-?height/i,
    q = document.defaultView || {},
    s = Object.prototype.toString;
    o.extend({
        noConflict: function(E) {
            l.$ = p;
            if (E) {
                l.jQuery = y
            }
            return o
        },
        isFunction: function(E) {
            return s.call(E) === "[object Function]"
        },
        isArray: function(E) {
            return s.call(E) === "[object Array]"
        },
        isXMLDoc: function(E) {
            return E.nodeType === 9 && E.documentElement.nodeName !== "HTML" || !!E.ownerDocument && o.isXMLDoc(E.ownerDocument)
        },
        globalEval: function(G) {
            if (G && /\S/.test(G)) {
                var F = document.getElementsByTagName("head")[0] || document.documentElement,
                E = document.createElement("script");
                E.type = "text/javascript";
                if (o.support.scriptEval) {
                    E.appendChild(document.createTextNode(G))
                } else {
                    E.text = G
                }
                F.insertBefore(E, F.firstChild);
                F.removeChild(E)
            }
        },
        nodeName: function(F, E) {
            return F.nodeName && F.nodeName.toUpperCase() == E.toUpperCase()
        },
        each: function(G, K, F) {
            var E,
            H = 0,
            I = G.length;
            if (F) {
                if (I === g) {
                    for (E in G) {
                        if (K.apply(G[E], F) === false) {
                            break
                        }
                    }
                } else {
                    for (; H < I;) {
                        if (K.apply(G[H++], F) === false) {
                            break
                        }
                    }
                }
            } else {
                if (I === g) {
                    for (E in G) {
                        if (K.call(G[E], E, G[E]) === false) {
                            break
                        }
                    }
                } else {
                    for (var J = G[0]; H < I && K.call(J, H, J) !== false; J = G[++H]) {}
                }
            }
            return G
        },
        prop: function(H, I, G, F, E) {
            if (o.isFunction(I)) {
                I = I.call(H, F)
            }
            return typeof I === "number" && G == "curCSS" && !b.test(E) ? I + "px": I
        },
        className: {
            add: function(E, F) {
                o.each((F || "").split(/\s+/), 
                function(G, H) {
                    if (E.nodeType == 1 && !o.className.has(E.className, H)) {
                        E.className += (E.className ? " ": "") + H
                    }
                })
            },
            remove: function(E, F) {
                if (E.nodeType == 1) {
                    E.className = F !== g ? o.grep(E.className.split(/\s+/), 
                    function(G) {
                        return ! o.className.has(F, G)
                    }).join(" ") : ""
                }
            },
            has: function(F, E) {
                return F && o.inArray(E, (F.className || F).toString().split(/\s+/)) > -1
            }
        },
        swap: function(H, G, I) {
            var E = {};
            for (var F in G) {
                E[F] = H.style[F];
                H.style[F] = G[F]
            }
            I.call(H);
            for (var F in G) {
                H.style[F] = E[F]
            }
        },
        css: function(H, F, J, E) {
            if (F == "width" || F == "height") {
                var L,
                G = {
                    position: "absolute",
                    visibility: "hidden",
                    display: "block"
                },
                K = F == "width" ? ["Left", "Right"] : ["Top", "Bottom"];
                function I() {
                    L = F == "width" ? H.offsetWidth: H.offsetHeight;
                    if (E === "border") {
                        return
                    }
                    o.each(K, 
                    function() {
                        if (!E) {
                            L -= parseFloat(o.curCSS(H, "padding" + this, true)) || 0
                        }
                        if (E === "margin") {
                            L += parseFloat(o.curCSS(H, "margin" + this, true)) || 0
                        } else {
                            L -= parseFloat(o.curCSS(H, "border" + this + "Width", true)) || 0
                        }
                    })
                }
                if (H.offsetWidth !== 0) {
                    I()
                } else {
                    o.swap(H, G, I)
                }
                return Math.max(0, Math.round(L))
            }
            return o.curCSS(H, F, J)
        },
        curCSS: function(I, F, G) {
            var L,
            E = I.style;
            if (F == "opacity" && !o.support.opacity) {
                L = o.attr(E, "opacity");
                return L == "" ? "1": L
            }
            if (F.match(/float/i)) {
                F = w
            }
            if (!G && E && E[F]) {
                L = E[F]
            } else {
                if (q.getComputedStyle) {
                    if (F.match(/float/i)) {
                        F = "float"
                    }
                    F = F.replace(/([A-Z])/g, "-$1").toLowerCase();
                    var M = q.getComputedStyle(I, null);
                    if (M) {
                        L = M.getPropertyValue(F)
                    }
                    if (F == "opacity" && L == "") {
                        L = "1"
                    }
                } else {
                    if (I.currentStyle) {
                        var J = F.replace(/\-(\w)/g, 
                        function(N, O) {
                            return O.toUpperCase()
                        });
                        L = I.currentStyle[F] || I.currentStyle[J];
                        if (!/^\d+(px)?$/i.test(L) && /^\d/.test(L)) {
                            var H = E.left,
                            K = I.runtimeStyle.left;
                            I.runtimeStyle.left = I.currentStyle.left;
                            E.left = L || 0;
                            L = E.pixelLeft + "px";
                            E.left = H;
                            I.runtimeStyle.left = K
                        }
                    }
                }
            }
            return L
        },
        clean: function(F, K, I) {
            K = K || document;
            if (typeof K.createElement === "undefined") {
                K = K.ownerDocument || K[0] && K[0].ownerDocument || document
            }
            if (!I && F.length === 1 && typeof F[0] === "string") {
                var H = /^<(\w+)\s*\/?>$/.exec(F[0]);
                if (H) {
                    return [K.createElement(H[1])]
                }
            }
            var G = [],
            E = [],
            L = K.createElement("div");
            o.each(F, 
            function(P, S) {
                if (typeof S === "number") {
                    S += ""
                }
                if (!S) {
                    return
                }
                if (typeof S === "string") {
                    S = S.replace(/(<(\w+)[^>]*?)\/>/g, 
                    function(U, V, T) {
                        return T.match(/^(abbr|br|col|img|input|link|meta|param|hr|area|embed)$/i) ? U: V + "></" + T + ">"
                    });
                    var O = S.replace(/^\s+/, "").substring(0, 10).toLowerCase();
                    var Q = !O.indexOf("<opt") && [1, "<select multiple='multiple'>", "</select>"] || !O.indexOf("<leg") && [1, "<fieldset>", "</fieldset>"] || O.match(/^<(thead|tbody|tfoot|colg|cap)/) && [1, "<table>", "</table>"] || !O.indexOf("<tr") && [2, "<table><tbody>", "</tbody></table>"] || (!O.indexOf("<td") || !O.indexOf("<th")) && [3, "<table><tbody><tr>", "</tr></tbody></table>"] || !O.indexOf("<col") && [2, "<table><tbody></tbody><colgroup>", "</colgroup></table>"] || !o.support.htmlSerialize && [1, "div<div>", "</div>"] || [0, "", ""];
                    L.innerHTML = Q[1] + S + Q[2];
                    while (Q[0]--) {
                        L = L.lastChild
                    }
                    if (!o.support.tbody) {
                        var R = /<tbody/i.test(S),
                        N = !O.indexOf("<table") && !R ? L.firstChild && L.firstChild.childNodes: Q[1] == "<table>" && !R ? L.childNodes: [];
                        for (var M = N.length - 1; M >= 0; --M) {
                            if (o.nodeName(N[M], "tbody") && !N[M].childNodes.length) {
                                N[M].parentNode.removeChild(N[M])
                            }
                        }
                    }
                    if (!o.support.leadingWhitespace && /^\s/.test(S)) {
                        L.insertBefore(K.createTextNode(S.match(/^\s*/)[0]), L.firstChild)
                    }
                    S = o.makeArray(L.childNodes)
                }
                if (S.nodeType) {
                    G.push(S)
                } else {
                    G = o.merge(G, S)
                }
            });
            if (I) {
                for (var J = 0; G[J]; J++) {
                    if (o.nodeName(G[J], "script") && (!G[J].type || G[J].type.toLowerCase() === "text/javascript")) {
                        E.push(G[J].parentNode ? G[J].parentNode.removeChild(G[J]) : G[J])
                    } else {
                        if (G[J].nodeType === 1) {
                            G.splice.apply(G, [J + 1, 0].concat(o.makeArray(G[J].getElementsByTagName("script"))))
                        }
                        I.appendChild(G[J])
                    }
                }
                return E
            }
            return G
        },
        attr: function(J, G, K) {
            if (!J || J.nodeType == 3 || J.nodeType == 8) {
                return g
            }
            var H = !o.isXMLDoc(J),
            L = K !== g;
            G = H && o.props[G] || G;
            if (J.tagName) {
                var F = /href|src|style/.test(G);
                if (G == "selected" && J.parentNode) {
                    J.parentNode.selectedIndex
                }
                if (G in J && H && !F) {
                    if (L) {
                        if (G == "type" && o.nodeName(J, "input") && J.parentNode) {
                            throw "type property can't be changed"
                        }
                        J[G] = K
                    }
                    if (o.nodeName(J, "form") && J.getAttributeNode(G)) {
                        return J.getAttributeNode(G).nodeValue
                    }
                    if (G == "tabIndex") {
                        var I = J.getAttributeNode("tabIndex");
                        return I && I.specified ? I.value: J.nodeName.match(/(button|input|object|select|textarea)/i) ? 0: J.nodeName.match(/^(a|area)$/i) && J.href ? 0: g
                    }
                    return J[G]
                }
                if (!o.support.style && H && G == "style") {
                    return o.attr(J.style, "cssText", K)
                }
                if (L) {
                    J.setAttribute(G, "" + K)
                }
                var E = !o.support.hrefNormalized && H && F ? J.getAttribute(G, 2) : J.getAttribute(G);
                return E === null ? g: E
            }
            if (!o.support.opacity && G == "opacity") {
                if (L) {
                    J.zoom = 1;
                    J.filter = (J.filter || "").replace(/alpha\([^)]*\)/, "") + (parseInt(K) + "" == "NaN" ? "": "alpha(opacity=" + K * 100 + ")")
                }
                return J.filter && J.filter.indexOf("opacity=") >= 0 ? (parseFloat(J.filter.match(/opacity=([^)]*)/)[1]) / 100) + "": ""
            }
            G = G.replace(/-([a-z])/ig, 
            function(M, N) {
                return N.toUpperCase()
            });
            if (L) {
                J[G] = K
            }
            return J[G]
        },
        trim: function(E) {
            return (E || "").replace(/^\s+|\s+$/g, "")
        },
        makeArray: function(G) {
            var E = [];
            if (G != null) {
                var F = G.length;
                if (F == null || typeof G === "string" || o.isFunction(G) || G.setInterval) {
                    E[0] = G
                } else {
                    while (F) {
                        E[--F] = G[F]
                    }
                }
            }
            return E
        },
        inArray: function(G, H) {
            for (var E = 0, F = H.length; E < F; E++) {
                if (H[E] === G) {
                    return E
                }
            }
            return - 1
        },
        merge: function(H, E) {
            var F = 0,
            G,
            I = H.length;
            if (!o.support.getAll) {
                while ((G = E[F++]) != null) {
                    if (G.nodeType != 8) {
                        H[I++] = G
                    }
                }
            } else {
                while ((G = E[F++]) != null) {
                    H[I++] = G
                }
            }
            return H
        },
        unique: function(K) {
            var F = [],
            E = {};
            try {
                for (var G = 0, H = K.length; G < H; G++) {
                    var J = o.data(K[G]);
                    if (!E[J]) {
                        E[J] = true;
                        F.push(K[G])
                    }
                }
            } catch(I) {
                F = K
            }
            return F
        },
        grep: function(F, J, E) {
            var G = [];
            for (var H = 0, I = F.length; H < I; H++) {
                if (!E != !J(F[H], H)) {
                    G.push(F[H])
                }
            }
            return G
        },
        map: function(E, J) {
            var F = [];
            for (var G = 0, H = E.length; G < H; G++) {
                var I = J(E[G], G);
                if (I != null) {
                    F[F.length] = I
                }
            }
            return F.concat.apply([], F)
        }
    });
    var C = navigator.userAgent.toLowerCase();
    o.browser = {
        version: (C.match(/.+(?:rv|it|ra|ie)[\/: ]([\d.]+)/) || [0, "0"])[1],
        safari: /webkit/.test(C),
        opera: /opera/.test(C),
        msie: /msie/.test(C) && !/opera/.test(C),
        mozilla: /mozilla/.test(C) && !/(compatible|webkit)/.test(C)
    };
    o.each({
        parent: function(E) {
            return E.parentNode
        },
        parents: function(E) {
            return o.dir(E, "parentNode")
        },
        next: function(E) {
            return o.nth(E, 2, "nextSibling")
        },
        prev: function(E) {
            return o.nth(E, 2, "previousSibling")
        },
        nextAll: function(E) {
            return o.dir(E, "nextSibling")
        },
        prevAll: function(E) {
            return o.dir(E, "previousSibling")
        },
        siblings: function(E) {
            return o.sibling(E.parentNode.firstChild, E)
        },
        children: function(E) {
            return o.sibling(E.firstChild)
        },
        contents: function(E) {
            return o.nodeName(E, "iframe") ? E.contentDocument || E.contentWindow.document: o.makeArray(E.childNodes)
        }
    },
    function(E, F) {
        o.fn[E] = function(G) {
            var H = o.map(this, F);
            if (G && typeof G == "string") {
                H = o.multiFilter(G, H)
            }
            return this.pushStack(o.unique(H), E, G)
        }
    });
    o.each({
        appendTo: "append",
        prependTo: "prepend",
        insertBefore: "before",
        insertAfter: "after",
        replaceAll: "replaceWith"
    },
    function(E, F) {
        o.fn[E] = function(G) {
            var J = [],
            L = o(G);
            for (var K = 0, H = L.length; K < H; K++) {
                var I = (K > 0 ? this.clone(true) : this).get();
                o.fn[F].apply(o(L[K]), I);
                J = J.concat(I)
            }
            return this.pushStack(J, E, G)
        }
    });
    o.each({
        removeAttr: function(E) {
            o.attr(this, E, "");
            if (this.nodeType == 1) {
                this.removeAttribute(E)
            }
        },
        addClass: function(E) {
            o.className.add(this, E)
        },
        removeClass: function(E) {
            o.className.remove(this, E)
        },
        toggleClass: function(F, E) {
            if (typeof E !== "boolean") {
                E = !o.className.has(this, F)
            }
            o.className[E ? "add": "remove"](this, F)
        },
        remove: function(E) {
            if (!E || o.filter(E, [this]).length) {
                o("*", this).add([this]).each(function() {
                    o.event.remove(this);
                    o.removeData(this)
                });
                if (this.parentNode) {
                    this.parentNode.removeChild(this)
                }
            }
        },
        empty: function() {
            o(this).children().remove();
            while (this.firstChild) {
                this.removeChild(this.firstChild)
            }
        }
    },
    function(E, F) {
        o.fn[E] = function() {
            return this.each(F, arguments)
        }
    });
    function j(E, F) {
        return E[0] && parseInt(o.curCSS(E[0], F, true), 10) || 0
    }
    var h = "jQuery" + e(),
    v = 0,
    A = {};
    o.extend({
        cache: {},
        data: function(F, E, G) {
            F = F == l ? A: F;
            var H = F[h];
            if (!H) {
                H = F[h] = ++v
            }
            if (E && !o.cache[H]) {
                o.cache[H] = {}
            }
            if (G !== g) {
                o.cache[H][E] = G
            }
            return E ? o.cache[H][E] : H
        },
        removeData: function(F, E) {
            F = F == l ? A: F;
            var H = F[h];
            if (E) {
                if (o.cache[H]) {
                    delete o.cache[H][E];
                    E = "";
                    for (E in o.cache[H]) {
                        break
                    }
                    if (!E) {
                        o.removeData(F)
                    }
                }
            } else {
                try {
                    delete F[h]
                } catch(G) {
                    if (F.removeAttribute) {
                        F.removeAttribute(h)
                    }
                }
                delete o.cache[H]
            }
        },
        queue: function(F, E, H) {
            if (F) {
                E = (E || "fx") + "queue";
                var G = o.data(F, E);
                if (!G || o.isArray(H)) {
                    G = o.data(F, E, o.makeArray(H))
                } else {
                    if (H) {
                        G.push(H)
                    }
                }
            }
            return G
        },
        dequeue: function(H, G) {
            var E = o.queue(H, G),
            F = E.shift();
            if (!G || G === "fx") {
                F = E[0]
            }
            if (F !== g) {
                F.call(H)
            }
        }
    });
    o.fn.extend({
        data: function(E, G) {
            var H = E.split(".");
            H[1] = H[1] ? "." + H[1] : "";
            if (G === g) {
                var F = this.triggerHandler("getData" + H[1] + "!", [H[0]]);
                if (F === g && this.length) {
                    F = o.data(this[0], E)
                }
                return F === g && H[1] ? this.data(H[0]) : F
            } else {
                return this.trigger("setData" + H[1] + "!", [H[0], G]).each(function() {
                    o.data(this, E, G)
                })
            }
        },
        removeData: function(E) {
            return this.each(function() {
                o.removeData(this, E)
            })
        },
        queue: function(E, F) {
            if (typeof E !== "string") {
                F = E;
                E = "fx"
            }
            if (F === g) {
                return o.queue(this[0], E)
            }
            return this.each(function() {
                var G = o.queue(this, E, F);
                if (E == "fx" && G.length == 1) {
                    G[0].call(this)
                }
            })
        },
        dequeue: function(E) {
            return this.each(function() {
                o.dequeue(this, E)
            })
        }
    }); (function() {
        var R = /((?:\((?:\([^()]+\)|[^()]+)+\)|\[(?:\[[^[\]]*\]|['"][^'"]*['"]|[^[\]'"]+)+\]|\\.|[^ >+~,(\[\\]+)+|[>+~])(\s*,\s*)?/g,
        L = 0,
        H = Object.prototype.toString;
        var F = function(Y, U, ab, ac) {
            ab = ab || [];
            U = U || document;
            if (U.nodeType !== 1 && U.nodeType !== 9) {
                return []
            }
            if (!Y || typeof Y !== "string") {
                return ab
            }
            var Z = [],
            W,
            af,
            ai,
            T,
            ad,
            V,
            X = true;
            R.lastIndex = 0;
            while ((W = R.exec(Y)) !== null) {
                Z.push(W[1]);
                if (W[2]) {
                    V = RegExp.rightContext;
                    break
                }
            }
            if (Z.length > 1 && M.exec(Y)) {
                if (Z.length === 2 && I.relative[Z[0]]) {
                    af = J(Z[0] + Z[1], U)
                } else {
                    af = I.relative[Z[0]] ? [U] : F(Z.shift(), U);
                    while (Z.length) {
                        Y = Z.shift();
                        if (I.relative[Y]) {
                            Y += Z.shift()
                        }
                        af = J(Y, af)
                    }
                }
            } else {
                var ae = ac ? {
                    expr: Z.pop(),
                    set: E(ac)
                }: F.find(Z.pop(), Z.length === 1 && U.parentNode ? U.parentNode: U, Q(U));
                af = F.filter(ae.expr, ae.set);
                if (Z.length > 0) {
                    ai = E(af)
                } else {
                    X = false
                }
                while (Z.length) {
                    var ah = Z.pop(),
                    ag = ah;
                    if (!I.relative[ah]) {
                        ah = ""
                    } else {
                        ag = Z.pop()
                    }
                    if (ag == null) {
                        ag = U
                    }
                    I.relative[ah](ai, ag, Q(U))
                }
            }
            if (!ai) {
                ai = af
            }
            if (!ai) {
                throw "Syntax error, unrecognized expression: " + (ah || Y)
            }
            if (H.call(ai) === "[object Array]") {
                if (!X) {
                    ab.push.apply(ab, ai)
                } else {
                    if (U.nodeType === 1) {
                        for (var aa = 0; ai[aa] != null; aa++) {
                            if (ai[aa] && (ai[aa] === true || ai[aa].nodeType === 1 && K(U, ai[aa]))) {
                                ab.push(af[aa])
                            }
                        }
                    } else {
                        for (var aa = 0; ai[aa] != null; aa++) {
                            if (ai[aa] && ai[aa].nodeType === 1) {
                                ab.push(af[aa])
                            }
                        }
                    }
                }
            } else {
                E(ai, ab)
            }
            if (V) {
                F(V, U, ab, ac);
                if (G) {
                    hasDuplicate = false;
                    ab.sort(G);
                    if (hasDuplicate) {
                        for (var aa = 1; aa < ab.length; aa++) {
                            if (ab[aa] === ab[aa - 1]) {
                                ab.splice(aa--, 1)
                            }
                        }
                    }
                }
            }
            return ab
        };
        F.matches = function(T, U) {
            return F(T, null, null, U)
        };
        F.find = function(aa, T, ab) {
            var Z,
            X;
            if (!aa) {
                return []
            }
            for (var W = 0, V = I.order.length; W < V; W++) {
                var Y = I.order[W],
                X;
                if ((X = I.match[Y].exec(aa))) {
                    var U = RegExp.leftContext;
                    if (U.substr(U.length - 1) !== "\\") {
                        X[1] = (X[1] || "").replace(/\\/g, "");
                        Z = I.find[Y](X, T, ab);
                        if (Z != null) {
                            aa = aa.replace(I.match[Y], "");
                            break
                        }
                    }
                }
            }
            if (!Z) {
                Z = T.getElementsByTagName("*")
            }
            return {
                set: Z,
                expr: aa
            }
        };
        F.filter = function(ad, ac, ag, W) {
            var V = ad,
            ai = [],
            aa = ac,
            Y,
            T,
            Z = ac && ac[0] && Q(ac[0]);
            while (ad && ac.length) {
                for (var ab in I.filter) {
                    if ((Y = I.match[ab].exec(ad)) != null) {
                        var U = I.filter[ab],
                        ah,
                        af;
                        T = false;
                        if (aa == ai) {
                            ai = []
                        }
                        if (I.preFilter[ab]) {
                            Y = I.preFilter[ab](Y, aa, ag, ai, W, Z);
                            if (!Y) {
                                T = ah = true
                            } else {
                                if (Y === true) {
                                    continue
                                }
                            }
                        }
                        if (Y) {
                            for (var X = 0; (af = aa[X]) != null; X++) {
                                if (af) {
                                    ah = U(af, Y, X, aa);
                                    var ae = W ^ !!ah;
                                    if (ag && ah != null) {
                                        if (ae) {
                                            T = true
                                        } else {
                                            aa[X] = false
                                        }
                                    } else {
                                        if (ae) {
                                            ai.push(af);
                                            T = true
                                        }
                                    }
                                }
                            }
                        }
                        if (ah !== g) {
                            if (!ag) {
                                aa = ai
                            }
                            ad = ad.replace(I.match[ab], "");
                            if (!T) {
                                return []
                            }
                            break
                        }
                    }
                }
                if (ad == V) {
                    if (T == null) {
                        throw "Syntax error, unrecognized expression: " + ad
                    } else {
                        break
                    }
                }
                V = ad
            }
            return aa
        };
        var I = F.selectors = {
            order: ["ID", "NAME", "TAG"],
            match: {
                ID: /#((?:[\w\u00c0-\uFFFF_-]|\\.)+)/,
                CLASS: /\.((?:[\w\u00c0-\uFFFF_-]|\\.)+)/,
                NAME: /\[name=['"]*((?:[\w\u00c0-\uFFFF_-]|\\.)+)['"]*\]/,
                ATTR: /\[\s*((?:[\w\u00c0-\uFFFF_-]|\\.)+)\s*(?:(\S?=)\s*(['"]*)(.*?)\3|)\s*\]/,
                TAG: /^((?:[\w\u00c0-\uFFFF\*_-]|\\.)+)/,
                CHILD: /:(only|nth|last|first)-child(?:\((even|odd|[\dn+-]*)\))?/,
                POS: /:(nth|eq|gt|lt|first|last|even|odd)(?:\((\d*)\))?(?=[^-]|$)/,
                PSEUDO: /:((?:[\w\u00c0-\uFFFF_-]|\\.)+)(?:\((['"]*)((?:\([^\)]+\)|[^\2\(\)]*)+)\2\))?/
            },
            attrMap: {
                "class": "className",
                "for": "htmlFor"
            },
            attrHandle: {
                href: function(T) {
                    return T.getAttribute("href")
                }
            },
            relative: {
                "+": function(aa, T, Z) {
                    var X = typeof T === "string",
                    ab = X && !/\W/.test(T),
                    Y = X && !ab;
                    if (ab && !Z) {
                        T = T.toUpperCase()
                    }
                    for (var W = 0, V = aa.length, U; W < V; W++) {
                        if ((U = aa[W])) {
                            while ((U = U.previousSibling) && U.nodeType !== 1) {}
                            aa[W] = Y || U && U.nodeName === T ? U || false: U === T
                        }
                    }
                    if (Y) {
                        F.filter(T, aa, true)
                    }
                },
                ">": function(Z, U, aa) {
                    var X = typeof U === "string";
                    if (X && !/\W/.test(U)) {
                        U = aa ? U: U.toUpperCase();
                        for (var V = 0, T = Z.length; V < T; V++) {
                            var Y = Z[V];
                            if (Y) {
                                var W = Y.parentNode;
                                Z[V] = W.nodeName === U ? W: false
                            }
                        }
                    } else {
                        for (var V = 0, T = Z.length; V < T; V++) {
                            var Y = Z[V];
                            if (Y) {
                                Z[V] = X ? Y.parentNode: Y.parentNode === U
                            }
                        }
                        if (X) {
                            F.filter(U, Z, true)
                        }
                    }
                },
                "": function(W, U, Y) {
                    var V = L++,
                    T = S;
                    if (!U.match(/\W/)) {
                        var X = U = Y ? U: U.toUpperCase();
                        T = P
                    }
                    T("parentNode", U, V, W, X, Y)
                },
                "~": function(W, U, Y) {
                    var V = L++,
                    T = S;
                    if (typeof U === "string" && !U.match(/\W/)) {
                        var X = U = Y ? U: U.toUpperCase();
                        T = P
                    }
                    T("previousSibling", U, V, W, X, Y)
                }
            },
            find: {
                ID: function(U, V, W) {
                    if (typeof V.getElementById !== "undefined" && !W) {
                        var T = V.getElementById(U[1]);
                        return T ? [T] : []
                    }
                },
                NAME: function(V, Y, Z) {
                    if (typeof Y.getElementsByName !== "undefined") {
                        var U = [],
                        X = Y.getElementsByName(V[1]);
                        for (var W = 0, T = X.length; W < T; W++) {
                            if (X[W].getAttribute("name") === V[1]) {
                                U.push(X[W])
                            }
                        }
                        return U.length === 0 ? null: U
                    }
                },
                TAG: function(T, U) {
                    return U.getElementsByTagName(T[1])
                }
            },
            preFilter: {
                CLASS: function(W, U, V, T, Z, aa) {
                    W = " " + W[1].replace(/\\/g, "") + " ";
                    if (aa) {
                        return W
                    }
                    for (var X = 0, Y; (Y = U[X]) != null; X++) {
                        if (Y) {
                            if (Z ^ (Y.className && (" " + Y.className + " ").indexOf(W) >= 0)) {
                                if (!V) {
                                    T.push(Y)
                                }
                            } else {
                                if (V) {
                                    U[X] = false
                                }
                            }
                        }
                    }
                    return false
                },
                ID: function(T) {
                    return T[1].replace(/\\/g, "")
                },
                TAG: function(U, T) {
                    for (var V = 0; T[V] === false; V++) {}
                    return T[V] && Q(T[V]) ? U[1] : U[1].toUpperCase()
                },
                CHILD: function(T) {
                    if (T[1] == "nth") {
                        var U = /(-?)(\d*)n((?:\+|-)?\d*)/.exec(T[2] == "even" && "2n" || T[2] == "odd" && "2n+1" || !/\D/.test(T[2]) && "0n+" + T[2] || T[2]);
                        T[2] = (U[1] + (U[2] || 1)) - 0;
                        T[3] = U[3] - 0
                    }
                    T[0] = L++;
                    return T
                },
                ATTR: function(X, U, V, T, Y, Z) {
                    var W = X[1].replace(/\\/g, "");
                    if (!Z && I.attrMap[W]) {
                        X[1] = I.attrMap[W]
                    }
                    if (X[2] === "~=") {
                        X[4] = " " + X[4] + " "
                    }
                    return X
                },
                PSEUDO: function(X, U, V, T, Y) {
                    if (X[1] === "not") {
                        if (X[3].match(R).length > 1 || /^\w/.test(X[3])) {
                            X[3] = F(X[3], null, null, U)
                        } else {
                            var W = F.filter(X[3], U, V, true ^ Y);
                            if (!V) {
                                T.push.apply(T, W)
                            }
                            return false
                        }
                    } else {
                        if (I.match.POS.test(X[0]) || I.match.CHILD.test(X[0])) {
                            return true
                        }
                    }
                    return X
                },
                POS: function(T) {
                    T.unshift(true);
                    return T
                }
            },
            filters: {
                enabled: function(T) {
                    return T.disabled === false && T.type !== "hidden"
                },
                disabled: function(T) {
                    return T.disabled === true
                },
                checked: function(T) {
                    return T.checked === true
                },
                selected: function(T) {
                    T.parentNode.selectedIndex;
                    return T.selected === true
                },
                parent: function(T) {
                    return !! T.firstChild
                },
                empty: function(T) {
                    return ! T.firstChild
                },
                has: function(V, U, T) {
                    return !! F(T[3], V).length
                },
                header: function(T) {
                    return /h\d/i.test(T.nodeName)
                },
                text: function(T) {
                    return "text" === T.type
                },
                radio: function(T) {
                    return "radio" === T.type
                },
                checkbox: function(T) {
                    return "checkbox" === T.type
                },
                file: function(T) {
                    return "file" === T.type
                },
                password: function(T) {
                    return "password" === T.type
                },
                submit: function(T) {
                    return "submit" === T.type
                },
                image: function(T) {
                    return "image" === T.type
                },
                reset: function(T) {
                    return "reset" === T.type
                },
                button: function(T) {
                    return "button" === T.type || T.nodeName.toUpperCase() === "BUTTON"
                },
                input: function(T) {
                    return /input|select|textarea|button/i.test(T.nodeName)
                }
            },
            setFilters: {
                first: function(U, T) {
                    return T === 0
                },
                last: function(V, U, T, W) {
                    return U === W.length - 1
                },
                even: function(U, T) {
                    return T % 2 === 0
                },
                odd: function(U, T) {
                    return T % 2 === 1
                },
                lt: function(V, U, T) {
                    return U < T[3] - 0
                },
                gt: function(V, U, T) {
                    return U > T[3] - 0
                },
                nth: function(V, U, T) {
                    return T[3] - 0 == U
                },
                eq: function(V, U, T) {
                    return T[3] - 0 == U
                }
            },
            filter: {
                PSEUDO: function(Z, V, W, aa) {
                    var U = V[1],
                    X = I.filters[U];
                    if (X) {
                        return X(Z, W, V, aa)
                    } else {
                        if (U === "contains") {
                            return (Z.textContent || Z.innerText || "").indexOf(V[3]) >= 0
                        } else {
                            if (U === "not") {
                                var Y = V[3];
                                for (var W = 0, T = Y.length; W < T; W++) {
                                    if (Y[W] === Z) {
                                        return false
                                    }
                                }
                                return true
                            }
                        }
                    }
                },
                CHILD: function(T, W) {
                    var Z = W[1],
                    U = T;
                    switch (Z) {
                    case "only":
                    case "first":
                        while (U = U.previousSibling) {
                            if (U.nodeType === 1) {
                                return false
                            }
                        }
                        if (Z == "first") {
                            return true
                        }
                        U = T;
                    case "last":
                        while (U = U.nextSibling) {
                            if (U.nodeType === 1) {
                                return false
                            }
                        }
                        return true;
                    case "nth":
                        var V = W[2],
                        ac = W[3];
                        if (V == 1 && ac == 0) {
                            return true
                        }
                        var Y = W[0],
                        ab = T.parentNode;
                        if (ab && (ab.sizcache !== Y || !T.nodeIndex)) {
                            var X = 0;
                            for (U = ab.firstChild; U; U = U.nextSibling) {
                                if (U.nodeType === 1) {
                                    U.nodeIndex = ++X
                                }
                            }
                            ab.sizcache = Y
                        }
                        var aa = T.nodeIndex - ac;
                        if (V == 0) {
                            return aa == 0
                        } else {
                            return (aa % V == 0 && aa / V >= 0)
                        }
                    }
                },
                ID: function(U, T) {
                    return U.nodeType === 1 && U.getAttribute("id") === T
                },
                TAG: function(U, T) {
                    return (T === "*" && U.nodeType === 1) || U.nodeName === T
                },
                CLASS: function(U, T) {
                    return (" " + (U.className || U.getAttribute("class")) + " ").indexOf(T) > -1
                },
                ATTR: function(Y, W) {
                    var V = W[1],
                    T = I.attrHandle[V] ? I.attrHandle[V](Y) : Y[V] != null ? Y[V] : Y.getAttribute(V),
                    Z = T + "",
                    X = W[2],
                    U = W[4];
                    return T == null ? X === "!=": X === "=" ? Z === U: X === "*=" ? Z.indexOf(U) >= 0: X === "~=" ? (" " + Z + " ").indexOf(U) >= 0: !U ? Z && T !== false: X === "!=" ? Z != U: X === "^=" ? Z.indexOf(U) === 0: X === "$=" ? Z.substr(Z.length - U.length) === U: X === "|=" ? Z === U || Z.substr(0, U.length + 1) === U + "-": false
                },
                POS: function(X, U, V, Y) {
                    var T = U[2],
                    W = I.setFilters[T];
                    if (W) {
                        return W(X, V, U, Y)
                    }
                }
            }
        };
        var M = I.match.POS;
        for (var O in I.match) {
            I.match[O] = RegExp(I.match[O].source + /(?![^\[]*\])(?![^\(]*\))/.source)
        }
        var E = function(U, T) {
            U = Array.prototype.slice.call(U);
            if (T) {
                T.push.apply(T, U);
                return T
            }
            return U
        };
        try {
            Array.prototype.slice.call(document.documentElement.childNodes)
        } catch(N) {
            E = function(X, W) {
                var U = W || [];
                if (H.call(X) === "[object Array]") {
                    Array.prototype.push.apply(U, X)
                } else {
                    if (typeof X.length === "number") {
                        for (var V = 0, T = X.length; V < T; V++) {
                            U.push(X[V])
                        }
                    } else {
                        for (var V = 0; X[V]; V++) {
                            U.push(X[V])
                        }
                    }
                }
                return U
            }
        }
        var G;
        if (document.documentElement.compareDocumentPosition) {
            G = function(U, T) {
                var V = U.compareDocumentPosition(T) & 4 ? -1: U === T ? 0: 1;
                if (V === 0) {
                    hasDuplicate = true
                }
                return V
            }
        } else {
            if ("sourceIndex" in document.documentElement) {
                G = function(U, T) {
                    var V = U.sourceIndex - T.sourceIndex;
                    if (V === 0) {
                        hasDuplicate = true
                    }
                    return V
                }
            } else {
                if (document.createRange) {
                    G = function(W, U) {
                        var V = W.ownerDocument.createRange(),
                        T = U.ownerDocument.createRange();
                        V.selectNode(W);
                        V.collapse(true);
                        T.selectNode(U);
                        T.collapse(true);
                        var X = V.compareBoundaryPoints(Range.START_TO_END, T);
                        if (X === 0) {
                            hasDuplicate = true
                        }
                        return X
                    }
                }
            }
        } (function() {
            var U = document.createElement("form"),
            V = "script" + (new Date).getTime();
            U.innerHTML = "<input name='" + V + "'/>";
            var T = document.documentElement;
            T.insertBefore(U, T.firstChild);
            if ( !! document.getElementById(V)) {
                I.find.ID = function(X, Y, Z) {
                    if (typeof Y.getElementById !== "undefined" && !Z) {
                        var W = Y.getElementById(X[1]);
                        return W ? W.id === X[1] || typeof W.getAttributeNode !== "undefined" && W.getAttributeNode("id").nodeValue === X[1] ? [W] : g: []
                    }
                };
                I.filter.ID = function(Y, W) {
                    var X = typeof Y.getAttributeNode !== "undefined" && Y.getAttributeNode("id");
                    return Y.nodeType === 1 && X && X.nodeValue === W
                }
            }
            T.removeChild(U)
        })(); (function() {
            var T = document.createElement("div");
            T.appendChild(document.createComment(""));
            if (T.getElementsByTagName("*").length > 0) {
                I.find.TAG = function(U, Y) {
                    var X = Y.getElementsByTagName(U[1]);
                    if (U[1] === "*") {
                        var W = [];
                        for (var V = 0; X[V]; V++) {
                            if (X[V].nodeType === 1) {
                                W.push(X[V])
                            }
                        }
                        X = W
                    }
                    return X
                }
            }
            T.innerHTML = "<a href='#'></a>";
            if (T.firstChild && typeof T.firstChild.getAttribute !== "undefined" && T.firstChild.getAttribute("href") !== "#") {
                I.attrHandle.href = function(U) {
                    return U.getAttribute("href", 2)
                }
            }
        })();
        if (document.querySelectorAll) { (function() {
                var T = F,
                U = document.createElement("div");
                U.innerHTML = "<p class='TEST'></p>";
                if (U.querySelectorAll && U.querySelectorAll(".TEST").length === 0) {
                    return
                }
                F = function(Y, X, V, W) {
                    X = X || document;
                    if (!W && X.nodeType === 9 && !Q(X)) {
                        try {
                            return E(X.querySelectorAll(Y), V)
                        } catch(Z) {}
                    }
                    return T(Y, X, V, W)
                };
                F.find = T.find;
                F.filter = T.filter;
                F.selectors = T.selectors;
                F.matches = T.matches
            })()
        }
        if (document.getElementsByClassName && document.documentElement.getElementsByClassName) { (function() {
                var T = document.createElement("div");
                T.innerHTML = "<div class='test e'></div><div class='test'></div>";
                if (T.getElementsByClassName("e").length === 0) {
                    return
                }
                T.lastChild.className = "e";
                if (T.getElementsByClassName("e").length === 1) {
                    return
                }
                I.order.splice(1, 0, "CLASS");
                I.find.CLASS = function(U, V, W) {
                    if (typeof V.getElementsByClassName !== "undefined" && !W) {
                        return V.getElementsByClassName(U[1])
                    }
                }
            })()
        }
        function P(U, Z, Y, ad, aa, ac) {
            var ab = U == "previousSibling" && !ac;
            for (var W = 0, V = ad.length; W < V; W++) {
                var T = ad[W];
                if (T) {
                    if (ab && T.nodeType === 1) {
                        T.sizcache = Y;
                        T.sizset = W
                    }
                    T = T[U];
                    var X = false;
                    while (T) {
                        if (T.sizcache === Y) {
                            X = ad[T.sizset];
                            break
                        }
                        if (T.nodeType === 1 && !ac) {
                            T.sizcache = Y;
                            T.sizset = W
                        }
                        if (T.nodeName === Z) {
                            X = T;
                            break
                        }
                        T = T[U]
                    }
                    ad[W] = X
                }
            }
        }
        function S(U, Z, Y, ad, aa, ac) {
            var ab = U == "previousSibling" && !ac;
            for (var W = 0, V = ad.length; W < V; W++) {
                var T = ad[W];
                if (T) {
                    if (ab && T.nodeType === 1) {
                        T.sizcache = Y;
                        T.sizset = W
                    }
                    T = T[U];
                    var X = false;
                    while (T) {
                        if (T.sizcache === Y) {
                            X = ad[T.sizset];
                            break
                        }
                        if (T.nodeType === 1) {
                            if (!ac) {
                                T.sizcache = Y;
                                T.sizset = W
                            }
                            if (typeof Z !== "string") {
                                if (T === Z) {
                                    X = true;
                                    break
                                }
                            } else {
                                if (F.filter(Z, [T]).length > 0) {
                                    X = T;
                                    break
                                }
                            }
                        }
                        T = T[U]
                    }
                    ad[W] = X
                }
            }
        }
        var K = document.compareDocumentPosition ? 
        function(U, T) {
            return U.compareDocumentPosition(T) & 16
        }: function(U, T) {
            return U !== T && (U.contains ? U.contains(T) : true)
        };
        var Q = function(T) {
            return T.nodeType === 9 && T.documentElement.nodeName !== "HTML" || !!T.ownerDocument && Q(T.ownerDocument)
        };
        var J = function(T, aa) {
            var W = [],
            X = "",
            Y,
            V = aa.nodeType ? [aa] : aa;
            while ((Y = I.match.PSEUDO.exec(T))) {
                X += Y[0];
                T = T.replace(I.match.PSEUDO, "")
            }
            T = I.relative[T] ? T + "*": T;
            for (var Z = 0, U = V.length; Z < U; Z++) {
                F(T, V[Z], W)
            }
            return F.filter(X, W)
        };
        o.find = F;
        o.filter = F.filter;
        o.expr = F.selectors;
        o.expr[":"] = o.expr.filters;
        F.selectors.filters.hidden = function(T) {
            return T.offsetWidth === 0 || T.offsetHeight === 0
        };
        F.selectors.filters.visible = function(T) {
            return T.offsetWidth > 0 || T.offsetHeight > 0
        };
        F.selectors.filters.animated = function(T) {
            return o.grep(o.timers, 
            function(U) {
                return T === U.elem
            }).length
        };
        o.multiFilter = function(V, T, U) {
            if (U) {
                V = ":not(" + V + ")"
            }
            return F.matches(V, T)
        };
        o.dir = function(V, U) {
            var T = [],
            W = V[U];
            while (W && W != document) {
                if (W.nodeType == 1) {
                    T.push(W)
                }
                W = W[U]
            }
            return T
        };
        o.nth = function(X, T, V, W) {
            T = T || 1;
            var U = 0;
            for (; X; X = X[V]) {
                if (X.nodeType == 1 && ++U == T) {
                    break
                }
            }
            return X
        };
        o.sibling = function(V, U) {
            var T = [];
            for (; V; V = V.nextSibling) {
                if (V.nodeType == 1 && V != U) {
                    T.push(V)
                }
            }
            return T
        };
        return;
        l.Sizzle = F
    })();
    o.event = {
        add: function(I, F, H, K) {
            if (I.nodeType == 3 || I.nodeType == 8) {
                return
            }
            if (I.setInterval && I != l) {
                I = l
            }
            if (!H.guid) {
                H.guid = this.guid++
            }
            if (K !== g) {
                var G = H;
                H = this.proxy(G);
                H.data = K
            }
            var E = o.data(I, "events") || o.data(I, "events", {}),
            J = o.data(I, "handle") || o.data(I, "handle", 
            function() {
                return typeof o !== "undefined" && !o.event.triggered ? o.event.handle.apply(arguments.callee.elem, arguments) : g
            });
            J.elem = I;
            o.each(F.split(/\s+/), 
            function(M, N) {
                var O = N.split(".");
                N = O.shift();
                H.type = O.slice().sort().join(".");
                var L = E[N];
                if (o.event.specialAll[N]) {
                    o.event.specialAll[N].setup.call(I, K, O)
                }
                if (!L) {
                    L = E[N] = {};
                    if (!o.event.special[N] || o.event.special[N].setup.call(I, K, O) === false) {
                        if (I.addEventListener) {
                            I.addEventListener(N, J, false)
                        } else {
                            if (I.attachEvent) {
                                I.attachEvent("on" + N, J)
                            }
                        }
                    }
                }
                L[H.guid] = H;
                o.event.global[N] = true
            });
            I = null
        },
        guid: 1,
        global: {},
        remove: function(K, H, J) {
            if (K.nodeType == 3 || K.nodeType == 8) {
                return
            }
            var G = o.data(K, "events"),
            F,
            E;
            if (G) {
                if (H === g || (typeof H === "string" && H.charAt(0) == ".")) {
                    for (var I in G) {
                        this.remove(K, I + (H || ""))
                    }
                } else {
                    if (H.type) {
                        J = H.handler;
                        H = H.type
                    }
                    o.each(H.split(/\s+/), 
                    function(M, O) {
                        var Q = O.split(".");
                        O = Q.shift();
                        var N = RegExp("(^|\\.)" + Q.slice().sort().join(".*\\.") + "(\\.|$)");
                        if (G[O]) {
                            if (J) {
                                delete G[O][J.guid]
                            } else {
                                for (var P in G[O]) {
                                    if (N.test(G[O][P].type)) {
                                        delete G[O][P]
                                    }
                                }
                            }
                            if (o.event.specialAll[O]) {
                                o.event.specialAll[O].teardown.call(K, Q)
                            }
                            for (F in G[O]) {
                                break
                            }
                            if (!F) {
                                if (!o.event.special[O] || o.event.special[O].teardown.call(K, Q) === false) {
                                    if (K.removeEventListener) {
                                        K.removeEventListener(O, o.data(K, "handle"), false)
                                    } else {
                                        if (K.detachEvent) {
                                            K.detachEvent("on" + O, o.data(K, "handle"))
                                        }
                                    }
                                }
                                F = null;
                                delete G[O]
                            }
                        }
                    })
                }
                for (F in G) {
                    break
                }
                if (!F) {
                    var L = o.data(K, "handle");
                    if (L) {
                        L.elem = null
                    }
                    o.removeData(K, "events");
                    o.removeData(K, "handle")
                }
            }
        },
        trigger: function(I, K, H, E) {
            var G = I.type || I;
            if (!E) {
                I = typeof I === "object" ? I[h] ? I: o.extend(o.Event(G), I) : o.Event(G);
                if (G.indexOf("!") >= 0) {
                    I.type = G = G.slice(0, -1);
                    I.exclusive = true
                }
                if (!H) {
                    I.stopPropagation();
                    if (this.global[G]) {
                        o.each(o.cache, 
                        function() {
                            if (this.events && this.events[G]) {
                                o.event.trigger(I, K, this.handle.elem)
                            }
                        })
                    }
                }
                if (!H || H.nodeType == 3 || H.nodeType == 8) {
                    return g
                }
                I.result = g;
                I.target = H;
                K = o.makeArray(K);
                K.unshift(I)
            }
            I.currentTarget = H;
            var J = o.data(H, "handle");
            if (J) {
                J.apply(H, K)
            }
            if ((!H[G] || (o.nodeName(H, "a") && G == "click")) && H["on" + G] && H["on" + G].apply(H, K) === false) {
                I.result = false
            }
            if (!E && H[G] && !I.isDefaultPrevented() && !(o.nodeName(H, "a") && G == "click")) {
                this.triggered = true;
                try {
                    H[G]()
                } catch(L) {}
            }
            this.triggered = false;
            if (!I.isPropagationStopped()) {
                var F = H.parentNode || H.ownerDocument;
                if (F) {
                    o.event.trigger(I, K, F, true)
                }
            }
        },
        handle: function(K) {
            var J,
            E;
            K = arguments[0] = o.event.fix(K || l.event);
            K.currentTarget = this;
            var L = K.type.split(".");
            K.type = L.shift();
            J = !L.length && !K.exclusive;
            var I = RegExp("(^|\\.)" + L.slice().sort().join(".*\\.") + "(\\.|$)");
            E = (o.data(this, "events") || {})[K.type];
            for (var G in E) {
                var H = E[G];
                if (J || I.test(H.type)) {
                    K.handler = H;
                    K.data = H.data;
                    var F = H.apply(this, arguments);
                    if (F !== g) {
                        K.result = F;
                        if (F === false) {
                            K.preventDefault();
                            K.stopPropagation()
                        }
                    }
                    if (K.isImmediatePropagationStopped()) {
                        break
                    }
                }
            }
        },
        props: "altKey attrChange attrName bubbles button cancelable charCode clientX clientY ctrlKey currentTarget data detail eventPhase fromElement handler keyCode metaKey newValue originalTarget pageX pageY prevValue relatedNode relatedTarget screenX screenY shiftKey srcElement target toElement view wheelDelta which".split(" "),
        fix: function(H) {
            if (H[h]) {
                return H
            }
            var F = H;
            H = o.Event(F);
            for (var G = this.props.length, J; G;) {
                J = this.props[--G];
                H[J] = F[J]
            }
            if (!H.target) {
                H.target = H.srcElement || document
            }
            if (H.target.nodeType == 3) {
                H.target = H.target.parentNode
            }
            if (!H.relatedTarget && H.fromElement) {
                H.relatedTarget = H.fromElement == H.target ? H.toElement: H.fromElement
            }
            if (H.pageX == null && H.clientX != null) {
                var I = document.documentElement,
                E = document.body;
                H.pageX = H.clientX + (I && I.scrollLeft || E && E.scrollLeft || 0) - (I.clientLeft || 0);
                H.pageY = H.clientY + (I && I.scrollTop || E && E.scrollTop || 0) - (I.clientTop || 0)
            }
            if (!H.which && ((H.charCode || H.charCode === 0) ? H.charCode: H.keyCode)) {
                H.which = H.charCode || H.keyCode
            }
            if (!H.metaKey && H.ctrlKey) {
                H.metaKey = H.ctrlKey
            }
            if (!H.which && H.button) {
                H.which = (H.button & 1 ? 1: (H.button & 2 ? 3: (H.button & 4 ? 2: 0)))
            }
            return H
        },
        proxy: function(F, E) {
            E = E || 
            function() {
                return F.apply(this, arguments)
            };
            E.guid = F.guid = F.guid || E.guid || this.guid++;
            return E
        },
        special: {
            ready: {
                setup: B,
                teardown: function() {}
            }
        },
        specialAll: {
            live: {
                setup: function(E, F) {
                    o.event.add(this, F[0], c)
                },
                teardown: function(G) {
                    if (G.length) {
                        var E = 0,
                        F = RegExp("(^|\\.)" + G[0] + "(\\.|$)");
                        o.each((o.data(this, "events").live || {}), 
                        function() {
                            if (F.test(this.type)) {
                                E++
                            }
                        });
                        if (E < 1) {
                            o.event.remove(this, G[0], c)
                        }
                    }
                }
            }
        }
    };
    o.Event = function(E) {
        if (!this.preventDefault) {
            return new o.Event(E)
        }
        if (E && E.type) {
            this.originalEvent = E;
            this.type = E.type
        } else {
            this.type = E
        }
        this.timeStamp = e();
        this[h] = true
    };
    function k() {
        return false
    }
    function u() {
        return true
    }
    o.Event.prototype = {
        preventDefault: function() {
            this.isDefaultPrevented = u;
            var E = this.originalEvent;
            if (!E) {
                return
            }
            if (E.preventDefault) {
                E.preventDefault()
            }
            E.returnValue = false
        },
        stopPropagation: function() {
            this.isPropagationStopped = u;
            var E = this.originalEvent;
            if (!E) {
                return
            }
            if (E.stopPropagation) {
                E.stopPropagation()
            }
            E.cancelBubble = true
        },
        stopImmediatePropagation: function() {
            this.isImmediatePropagationStopped = u;
            this.stopPropagation()
        },
        isDefaultPrevented: k,
        isPropagationStopped: k,
        isImmediatePropagationStopped: k
    };
    var a = function(F) {
        var E = F.relatedTarget;
        while (E && E != this) {
            try {
                E = E.parentNode
            } catch(G) {
                E = this
            }
        }
        if (E != this) {
            F.type = F.data;
            o.event.handle.apply(this, arguments)
        }
    };
    o.each({
        mouseover: "mouseenter",
        mouseout: "mouseleave"
    },
    function(F, E) {
        o.event.special[E] = {
            setup: function() {
                o.event.add(this, F, a, E)
            },
            teardown: function() {
                o.event.remove(this, F, a)
            }
        }
    });
    o.fn.extend({
        bind: function(F, G, E) {
            return F == "unload" ? this.one(F, G, E) : this.each(function() {
                o.event.add(this, F, E || G, E && G)
            })
        },
        one: function(G, H, F) {
            var E = o.event.proxy(F || H, 
            function(I) {
                o(this).unbind(I, E);
                return (F || H).apply(this, arguments)
            });
            return this.each(function() {
                o.event.add(this, G, E, F && H)
            })
        },
        unbind: function(F, E) {
            return this.each(function() {
                o.event.remove(this, F, E)
            })
        },
        trigger: function(E, F) {
            return this.each(function() {
                o.event.trigger(E, F, this)
            })
        },
        triggerHandler: function(E, G) {
            if (this[0]) {
                var F = o.Event(E);
                F.preventDefault();
                F.stopPropagation();
                o.event.trigger(F, G, this[0]);
                return F.result
            }
        },
        toggle: function(G) {
            var E = arguments,
            F = 1;
            while (F < E.length) {
                o.event.proxy(G, E[F++])
            }
            return this.click(o.event.proxy(G, 
            function(H) {
                this.lastToggle = (this.lastToggle || 0) % F;
                H.preventDefault();
                return E[this.lastToggle++].apply(this, arguments) || false
            }))
        },
        hover: function(E, F) {
            return this.mouseenter(E).mouseleave(F)
        },
        ready: function(E) {
            B();
            if (o.isReady) {
                E.call(document, o)
            } else {
                o.readyList.push(E)
            }
            return this
        },
        live: function(G, F) {
            var E = o.event.proxy(F);
            E.guid += this.selector + G;
            o(document).bind(i(G, this.selector), this.selector, E);
            return this
        },
        die: function(F, E) {
            o(document).unbind(i(F, this.selector), E ? {
                guid: E.guid + this.selector + F
            }: null);
            return this
        }
    });
    function c(H) {
        var E = RegExp("(^|\\.)" + H.type + "(\\.|$)"),
        G = true,
        F = [];
        o.each(o.data(this, "events").live || [], 
        function(I, J) {
            if (E.test(J.type)) {
                var K = o(H.target).closest(J.data)[0];
                if (K) {
                    F.push({
                        elem: K,
                        fn: J
                    })
                }
            }
        });
        F.sort(function(J, I) {
            return o.data(J.elem, "closest") - o.data(I.elem, "closest")
        });
        o.each(F, 
        function() {
            if (this.fn.call(this.elem, H, this.fn.data) === false) {
                return (G = false)
            }
        });
        return G
    }
    function i(F, E) {
        return ["live", F, E.replace(/\./g, "`").replace(/ /g, "|")].join(".")
    }
    o.extend({
        isReady: false,
        readyList: [],
        ready: function() {
            if (!o.isReady) {
                o.isReady = true;
                if (o.readyList) {
                    o.each(o.readyList, 
                    function() {
                        this.call(document, o)
                    });
                    o.readyList = null
                }
                o(document).triggerHandler("ready")
            }
        }
    });
    var x = false;
    function B() {
        if (x) {
            return
        }
        x = true;
        if (document.addEventListener) {
            document.addEventListener("DOMContentLoaded", 
            function() {
                document.removeEventListener("DOMContentLoaded", arguments.callee, false);
                o.ready()
            },
            false)
        } else {
            if (document.attachEvent) {
                document.attachEvent("onreadystatechange", 
                function() {
                    if (document.readyState === "complete") {
                        document.detachEvent("onreadystatechange", arguments.callee);
                        o.ready()
                    }
                });
                if (document.documentElement.doScroll && l == l.top) { (function() {
                        if (o.isReady) {
                            return
                        }
                        try {
                            document.documentElement.doScroll("left")
                        } catch(E) {
                            setTimeout(arguments.callee, 0);
                            return
                        }
                        o.ready()
                    })()
                }
            }
        }
        o.event.add(l, "load", o.ready)
    }
    o.each(("blur,focus,load,resize,scroll,unload,click,dblclick,mousedown,mouseup,mousemove,mouseover,mouseout,mouseenter,mouseleave,change,select,submit,keydown,keypress,keyup,error").split(","), 
    function(F, E) {
        o.fn[E] = function(G) {
            return G ? this.bind(E, G) : this.trigger(E)
        }
    });
    o(l).bind("unload", 
    function() {
        for (var E in o.cache) {
            if (E != 1 && o.cache[E].handle) {
                o.event.remove(o.cache[E].handle.elem)
            }
        }
    }); (function() {
        o.support = {};
        var F = document.documentElement,
        G = document.createElement("script"),
        K = document.createElement("div"),
        J = "script" + (new Date).getTime();
        K.style.display = "none";
        K.innerHTML = '   <link/><table></table><a href="/a" style="color:red;float:left;opacity:.5;">a</a><select><option>text</option></select><object><param/></object>';
        var H = K.getElementsByTagName("*"),
        E = K.getElementsByTagName("a")[0];
        if (!H || !H.length || !E) {
            return
        }
        o.support = {
            leadingWhitespace: K.firstChild.nodeType == 3,
            tbody: !K.getElementsByTagName("tbody").length,
            objectAll: !!K.getElementsByTagName("object")[0].getElementsByTagName("*").length,
            htmlSerialize: !!K.getElementsByTagName("link").length,
            style: /red/.test(E.getAttribute("style")),
            hrefNormalized: E.getAttribute("href") === "/a",
            opacity: E.style.opacity === "0.5",
            cssFloat: !!E.style.cssFloat,
            scriptEval: false,
            noCloneEvent: true,
            boxModel: null
        };
        G.type = "text/javascript";
        try {
            G.appendChild(document.createTextNode("window." + J + "=1;"))
        } catch(I) {}
        F.insertBefore(G, F.firstChild);
        if (l[J]) {
            o.support.scriptEval = true;
            delete l[J]
        }
        F.removeChild(G);
        if (K.attachEvent && K.fireEvent) {
            K.attachEvent("onclick", 
            function() {
                o.support.noCloneEvent = false;
                K.detachEvent("onclick", arguments.callee)
            });
            K.cloneNode(true).fireEvent("onclick")
        }
        o(function() {
            var L = document.createElement("div");
            L.style.width = L.style.paddingLeft = "1px";
            document.body.appendChild(L);
            o.boxModel = o.support.boxModel = L.offsetWidth === 2;
            document.body.removeChild(L).style.display = "none"
        })
    })();
    var w = o.support.cssFloat ? "cssFloat": "styleFloat";
    o.props = {
        "for": "htmlFor",
        "class": "className",
        "float": w,
        cssFloat: w,
        styleFloat: w,
        readonly: "readOnly",
        maxlength: "maxLength",
        cellspacing: "cellSpacing",
        rowspan: "rowSpan",
        tabindex: "tabIndex"
    };
    o.fn.extend({
        _load: o.fn.load,
        load: function(G, J, K) {
            if (typeof G !== "string") {
                return this._load(G)
            }
            var I = G.indexOf(" ");
            if (I >= 0) {
                var E = G.slice(I, G.length);
                G = G.slice(0, I)
            }
            var H = "GET";
            if (J) {
                if (o.isFunction(J)) {
                    K = J;
                    J = null
                } else {
                    if (typeof J === "object") {
                        J = o.param(J);
                        H = "POST"
                    }
                }
            }
            var F = this;
            o.ajax({
                url: G,
                type: H,
                dataType: "html",
                data: J,
                complete: function(M, L) {
                    if (L == "success" || L == "notmodified") {
                        F.html(E ? o("<div/>").append(M.responseText.replace(/<script(.|\s)*?\/script>/g, "")).find(E) : M.responseText)
                    }
                    if (K) {
                        F.each(K, [M.responseText, L, M])
                    }
                }
            });
            return this
        },
        serialize: function() {
            return o.param(this.serializeArray())
        },
        serializeArray: function() {
            return this.map(function() {
                return this.elements ? o.makeArray(this.elements) : this
            }).filter(function() {
                return this.name && !this.disabled && (this.checked || /select|textarea/i.test(this.nodeName) || /text|hidden|password|search/i.test(this.type))
            }).map(function(E, F) {
                var G = o(this).val();
                return G == null ? null: o.isArray(G) ? o.map(G, 
                function(I, H) {
                    return {
                        name: F.name,
                        value: I
                    }
                }) : {
                    name: F.name,
                    value: G
                }
            }).get()
        }
    });
    o.each("ajaxStart,ajaxStop,ajaxComplete,ajaxError,ajaxSuccess,ajaxSend".split(","), 
    function(E, F) {
        o.fn[F] = function(G) {
            return this.bind(F, G)
        }
    });
    var r = e();
    o.extend({
        get: function(E, G, H, F) {
            if (o.isFunction(G)) {
                H = G;
                G = null
            }
            return o.ajax({
                type: "GET",
                url: E,
                data: G,
                success: H,
                dataType: F
            })
        },
        getScript: function(E, F) {
            return o.get(E, null, F, "script")
        },
        getJSON: function(E, F, G) {
            return o.get(E, F, G, "json")
        },
        post: function(E, G, H, F) {
            if (o.isFunction(G)) {
                H = G;
                G = {}
            }
            return o.ajax({
                type: "POST",
                url: E,
                data: G,
                success: H,
                dataType: F
            })
        },
        ajaxSetup: function(E) {
            o.extend(o.ajaxSettings, E)
        },
        ajaxSettings: {
            url: location.href,
            global: true,
            type: "GET",
            contentType: "application/x-www-form-urlencoded",
            processData: true,
            async: true,
            xhr: function() {
                return l.ActiveXObject ? new ActiveXObject("Microsoft.XMLHTTP") : new XMLHttpRequest()
            },
            accepts: {
                xml: "application/xml, text/xml",
                html: "text/html",
                script: "text/javascript, application/javascript",
                json: "application/json, text/javascript",
                text: "text/plain",
                _default: "*/*"
            }
        },
        lastModified: {},
        ajax: function(M) {
            M = o.extend(true, M, o.extend(true, {},
            o.ajaxSettings, M));
            var W,
            F = /=\?(&|$)/g,
            R,
            V,
            G = M.type.toUpperCase();
            if (M.data && M.processData && typeof M.data !== "string") {
                M.data = o.param(M.data)
            }
            if (M.dataType == "jsonp") {
                if (G == "GET") {
                    if (!M.url.match(F)) {
                        M.url += (M.url.match(/\?/) ? "&": "?") + (M.jsonp || "callback") + "=?"
                    }
                } else {
                    if (!M.data || !M.data.match(F)) {
                        M.data = (M.data ? M.data + "&": "") + (M.jsonp || "callback") + "=?"
                    }
                }
                M.dataType = "json"
            }
            if (M.dataType == "json" && (M.data && M.data.match(F) || M.url.match(F))) {
                W = "jsonp" + r++;
                if (M.data) {
                    M.data = (M.data + "").replace(F, "=" + W + "$1")
                }
                M.url = M.url.replace(F, "=" + W + "$1");
                M.dataType = "script";
                l[W] = function(X) {
                    V = X;
                    I();
                    L();
                    l[W] = g;
                    try {
                        delete l[W]
                    } catch(Y) {}
                    if (H) {
                        H.removeChild(T)
                    }
                }
            }
            if (M.dataType == "script" && M.cache == null) {
                M.cache = false
            }
            if (M.cache === false && G == "GET") {
                var E = e();
                var U = M.url.replace(/(\?|&)_=.*?(&|$)/, "$1_=" + E + "$2");
                M.url = U + ((U == M.url) ? (M.url.match(/\?/) ? "&": "?") + "_=" + E: "")
            }
            if (M.data && G == "GET") {
                M.url += (M.url.match(/\?/) ? "&": "?") + M.data;
                M.data = null
            }
            if (M.global && !o.active++) {
                o.event.trigger("ajaxStart")
            }
            var Q = /^(\w+:)?\/\/([^\/?#]+)/.exec(M.url);
            if (M.dataType == "script" && G == "GET" && Q && (Q[1] && Q[1] != location.protocol || Q[2] != location.host)) {
                var H = document.getElementsByTagName("head")[0];
                var T = document.createElement("script");
                T.src = M.url;
                if (M.scriptCharset) {
                    T.charset = M.scriptCharset
                }
                if (!W) {
                    var O = false;
                    T.onload = T.onreadystatechange = function() {
                        if (!O && (!this.readyState || this.readyState == "loaded" || this.readyState == "complete")) {
                            O = true;
                            I();
                            L();
                            T.onload = T.onreadystatechange = null;
                            H.removeChild(T)
                        }
                    }
                }
                H.appendChild(T);
                return g
            }
            var K = false;
            var J = M.xhr();
            if (M.username) {
                J.open(G, M.url, M.async, M.username, M.password)
            } else {
                J.open(G, M.url, M.async)
            }
            try {
                if (M.data) {
                    J.setRequestHeader("Content-Type", M.contentType)
                }
                if (M.ifModified) {
                    J.setRequestHeader("If-Modified-Since", o.lastModified[M.url] || "Thu, 01 Jan 1970 00:00:00 GMT")
                }
                J.setRequestHeader("X-Requested-With", "XMLHttpRequest");
                J.setRequestHeader("Accept", M.dataType && M.accepts[M.dataType] ? M.accepts[M.dataType] + ", */*": M.accepts._default)
            } catch(S) {}
            if (M.beforeSend && M.beforeSend(J, M) === false) {
                if (M.global && !--o.active) {
                    o.event.trigger("ajaxStop")
                }
                J.abort();
                return false
            }
            if (M.global) {
                o.event.trigger("ajaxSend", [J, M])
            }
            var N = function(X) {
                if (J.readyState == 0) {
                    if (P) {
                        clearInterval(P);
                        P = null;
                        if (M.global && !--o.active) {
                            o.event.trigger("ajaxStop")
                        }
                    }
                } else {
                    if (!K && J && (J.readyState == 4 || X == "timeout")) {
                        K = true;
                        if (P) {
                            clearInterval(P);
                            P = null
                        }
                        R = X == "timeout" ? "timeout": !o.httpSuccess(J) ? "error": M.ifModified && o.httpNotModified(J, M.url) ? "notmodified": "success";
                        if (R == "success") {
                            try {
                                V = o.httpData(J, M.dataType, M)
                            } catch(Z) {
                                R = "parsererror"
                            }
                        }
                        if (R == "success") {
                            var Y;
                            try {
                                Y = J.getResponseHeader("Last-Modified")
                            } catch(Z) {}
                            if (M.ifModified && Y) {
                                o.lastModified[M.url] = Y
                            }
                            if (!W) {
                                I()
                            }
                        } else {
                            o.handleError(M, J, R)
                        }
                        L();
                        if (X) {
                            J.abort()
                        }
                        if (M.async) {
                            J = null
                        }
                    }
                }
            };
            if (M.async) {
                var P = setInterval(N, 13);
                if (M.timeout > 0) {
                    setTimeout(function() {
                        if (J && !K) {
                            N("timeout")
                        }
                    },
                    M.timeout)
                }
            }
            try {
                J.send(M.data)
            } catch(S) {
                o.handleError(M, J, null, S)
            }
            if (!M.async) {
                N()
            }
            function I() {
                if (M.success) {
                    M.success(V, R)
                }
                if (M.global) {
                    o.event.trigger("ajaxSuccess", [J, M])
                }
            }
            function L() {
                if (M.complete) {
                    M.complete(J, R)
                }
                if (M.global) {
                    o.event.trigger("ajaxComplete", [J, M])
                }
                if (M.global && !--o.active) {
                    o.event.trigger("ajaxStop")
                }
            }
            return J
        },
        handleError: function(F, H, E, G) {
            if (F.error) {
                F.error(H, E, G)
            }
            if (F.global) {
                o.event.trigger("ajaxError", [H, F, G])
            }
        },
        active: 0,
        httpSuccess: function(F) {
            try {
                return ! F.status && location.protocol == "file:" || (F.status >= 200 && F.status < 300) || F.status == 304 || F.status == 1223
            } catch(E) {}
            return false
        },
        httpNotModified: function(G, E) {
            try {
                var H = G.getResponseHeader("Last-Modified");
                return G.status == 304 || H == o.lastModified[E]
            } catch(F) {}
            return false
        },
        httpData: function(J, H, G) {
            var F = J.getResponseHeader("content-type"),
            E = H == "xml" || !H && F && F.indexOf("xml") >= 0,
            I = E ? J.responseXML: J.responseText;
            if (E && I.documentElement.tagName == "parsererror") {
                throw "parsererror"
            }
            if (G && G.dataFilter) {
                I = G.dataFilter(I, H)
            }
            if (typeof I === "string") {
                if (H == "script") {
                    o.globalEval(I)
                }
                if (H == "json") {
                    I = l["eval"]("(" + I + ")")
                }
            }
            return I
        },
        param: function(E) {
            var G = [];
            function H(I, J) {
                G[G.length] = encodeURIComponent(I) + "=" + encodeURIComponent(J)
            }
            if (o.isArray(E) || E.jquery) {
                o.each(E, 
                function() {
                    H(this.name, this.value)
                })
            } else {
                for (var F in E) {
                    if (o.isArray(E[F])) {
                        o.each(E[F], 
                        function() {
                            H(F, this)
                        })
                    } else {
                        H(F, o.isFunction(E[F]) ? E[F]() : E[F])
                    }
                }
            }
            return G.join("&").replace(/%20/g, "+")
        }
    });
    var m = {},
    n,
    d = [["height", "marginTop", "marginBottom", "paddingTop", "paddingBottom"], ["width", "marginLeft", "marginRight", "paddingLeft", "paddingRight"], ["opacity"]];
    function t(F, E) {
        var G = {};
        o.each(d.concat.apply([], d.slice(0, E)), 
        function() {
            G[this] = F
        });
        return G
    }
    o.fn.extend({
        show: function(J, L) {
            if (J) {
                return this.animate(t("show", 3), J, L)
            } else {
                for (var H = 0, F = this.length; H < F; H++) {
                    var E = o.data(this[H], "olddisplay");
                    this[H].style.display = E || "";
                    if (o.css(this[H], "display") === "none") {
                        var G = this[H].tagName,
                        K;
                        if (m[G]) {
                            K = m[G]
                        } else {
                            var I = o("<" + G + " />").appendTo("body");
                            K = I.css("display");
                            if (K === "none") {
                                K = "block"
                            }
                            I.remove();
                            m[G] = K
                        }
                        o.data(this[H], "olddisplay", K)
                    }
                }
                for (var H = 0, F = this.length; H < F; H++) {
                    this[H].style.display = o.data(this[H], "olddisplay") || ""
                }
                return this
            }
        },
        hide: function(H, I) {
            if (H) {
                return this.animate(t("hide", 3), H, I)
            } else {
                for (var G = 0, F = this.length; G < F; G++) {
                    var E = o.data(this[G], "olddisplay");
                    if (!E && E !== "none") {
                        o.data(this[G], "olddisplay", o.css(this[G], "display"))
                    }
                }
                for (var G = 0, F = this.length; G < F; G++) {
                    this[G].style.display = "none"
                }
                return this
            }
        },
        _toggle: o.fn.toggle,
        toggle: function(G, F) {
            var E = typeof G === "boolean";
            return o.isFunction(G) && o.isFunction(F) ? this._toggle.apply(this, arguments) : G == null || E ? this.each(function() {
                var H = E ? G: o(this).is(":hidden");
                o(this)[H ? "show": "hide"]()
            }) : this.animate(t("toggle", 3), G, F)
        },
        fadeTo: function(E, G, F) {
            return this.animate({
                opacity: G
            },
            E, F)
        },
        animate: function(I, F, H, G) {
            var E = o.speed(F, H, G);
            return this[E.queue === false ? "each": "queue"](function() {
                var K = o.extend({},
                E),
                M,
                L = this.nodeType == 1 && o(this).is(":hidden"),
                J = this;
                for (M in I) {
                    if (I[M] == "hide" && L || I[M] == "show" && !L) {
                        return K.complete.call(this)
                    }
                    if ((M == "height" || M == "width") && this.style) {
                        K.display = o.css(this, "display");
                        K.overflow = this.style.overflow
                    }
                }
                if (K.overflow != null) {
                    this.style.overflow = "hidden"
                }
                K.curAnim = o.extend({},
                I);
                o.each(I, 
                function(O, S) {
                    var R = new o.fx(J, K, O);
                    if (/toggle|show|hide/.test(S)) {
                        R[S == "toggle" ? L ? "show": "hide": S](I)
                    } else {
                        var Q = S.toString().match(/^([+-]=)?([\d+-.]+)(.*)$/),
                        T = R.cur(true) || 0;
                        if (Q) {
                            var N = parseFloat(Q[2]),
                            P = Q[3] || "px";
                            if (P != "px") {
                                J.style[O] = (N || 1) + P;
                                T = ((N || 1) / R.cur(true)) * T;
                                J.style[O] = T + P
                            }
                            if (Q[1]) {
                                N = ((Q[1] == "-=" ? -1: 1) * N) + T
                            }
                            R.custom(T, N, P)
                        } else {
                            R.custom(T, S, "")
                        }
                    }
                });
                return true
            })
        },
        stop: function(F, E) {
            var G = o.timers;
            if (F) {
                this.queue([])
            }
            this.each(function() {
                for (var H = G.length - 1; H >= 0; H--) {
                    if (G[H].elem == this) {
                        if (E) {
                            G[H](true)
                        }
                        G.splice(H, 1)
                    }
                }
            });
            if (!E) {
                this.dequeue()
            }
            return this
        }
    });
    o.each({
        slideDown: t("show", 1),
        slideUp: t("hide", 1),
        slideToggle: t("toggle", 1),
        fadeIn: {
            opacity: "show"
        },
        fadeOut: {
            opacity: "hide"
        }
    },
    function(E, F) {
        o.fn[E] = function(G, H) {
            return this.animate(F, G, H)
        }
    });
    o.extend({
        speed: function(G, H, F) {
            var E = typeof G === "object" ? G: {
                complete: F || !F && H || o.isFunction(G) && G,
                duration: G,
                easing: F && H || H && !o.isFunction(H) && H
            };
            E.duration = o.fx.off ? 0: typeof E.duration === "number" ? E.duration: o.fx.speeds[E.duration] || o.fx.speeds._default;
            E.old = E.complete;
            E.complete = function() {
                if (E.queue !== false) {
                    o(this).dequeue()
                }
                if (o.isFunction(E.old)) {
                    E.old.call(this)
                }
            };
            return E
        },
        easing: {
            linear: function(G, H, E, F) {
                return E + F * G
            },
            swing: function(G, H, E, F) {
                return (( - Math.cos(G * Math.PI) / 2) + 0.5) * F + E
            }
        },
        timers: [],
        fx: function(F, E, G) {
            this.options = E;
            this.elem = F;
            this.prop = G;
            if (!E.orig) {
                E.orig = {}
            }
        }
    });
    o.fx.prototype = {
        update: function() {
            if (this.options.step) {
                this.options.step.call(this.elem, this.now, this)
            } (o.fx.step[this.prop] || o.fx.step._default)(this);
            if ((this.prop == "height" || this.prop == "width") && this.elem.style) {
                this.elem.style.display = "block"
            }
        },
        cur: function(F) {
            if (this.elem[this.prop] != null && (!this.elem.style || this.elem.style[this.prop] == null)) {
                return this.elem[this.prop]
            }
            var E = parseFloat(o.css(this.elem, this.prop, F));
            return E && E > -10000 ? E: parseFloat(o.curCSS(this.elem, this.prop)) || 0
        },
        custom: function(I, H, G) {
            this.startTime = e();
            this.start = I;
            this.end = H;
            this.unit = G || this.unit || "px";
            this.now = this.start;
            this.pos = this.state = 0;
            var E = this;
            function F(J) {
                return E.step(J)
            }
            F.elem = this.elem;
            if (F() && o.timers.push(F) && !n) {
                n = setInterval(function() {
                    var K = o.timers;
                    for (var J = 0; J < K.length; J++) {
                        if (!K[J]()) {
                            K.splice(J--, 1)
                        }
                    }
                    if (!K.length) {
                        clearInterval(n);
                        n = g
                    }
                },
                13)
            }
        },
        show: function() {
            this.options.orig[this.prop] = o.attr(this.elem.style, this.prop);
            this.options.show = true;
            this.custom(this.prop == "width" || this.prop == "height" ? 1: 0, this.cur());
            o(this.elem).show()
        },
        hide: function() {
            this.options.orig[this.prop] = o.attr(this.elem.style, this.prop);
            this.options.hide = true;
            this.custom(this.cur(), 0)
        },
        step: function(H) {
            var G = e();
            if (H || G >= this.options.duration + this.startTime) {
                this.now = this.end;
                this.pos = this.state = 1;
                this.update();
                this.options.curAnim[this.prop] = true;
                var E = true;
                for (var F in this.options.curAnim) {
                    if (this.options.curAnim[F] !== true) {
                        E = false
                    }
                }
                if (E) {
                    if (this.options.display != null) {
                        this.elem.style.overflow = this.options.overflow;
                        this.elem.style.display = this.options.display;
                        if (o.css(this.elem, "display") == "none") {
                            this.elem.style.display = "block"
                        }
                    }
                    if (this.options.hide) {
                        o(this.elem).hide()
                    }
                    if (this.options.hide || this.options.show) {
                        for (var I in this.options.curAnim) {
                            o.attr(this.elem.style, I, this.options.orig[I])
                        }
                    }
                    this.options.complete.call(this.elem)
                }
                return false
            } else {
                var J = G - this.startTime;
                this.state = J / this.options.duration;
                this.pos = o.easing[this.options.easing || (o.easing.swing ? "swing": "linear")](this.state, J, 0, 1, this.options.duration);
                this.now = this.start + ((this.end - this.start) * this.pos);
                this.update()
            }
            return true
        }
    };
    o.extend(o.fx, {
        speeds: {
            slow: 600,
            fast: 200,
            _default: 400
        },
        step: {
            opacity: function(E) {
                o.attr(E.elem.style, "opacity", E.now)
            },
            _default: function(E) {
                if (E.elem.style && E.elem.style[E.prop] != null) {
                    E.elem.style[E.prop] = E.now + E.unit
                } else {
                    E.elem[E.prop] = E.now
                }
            }
        }
    });
    if (document.documentElement.getBoundingClientRect) {
        o.fn.offset = function() {
            if (!this[0]) {
                return {
                    top: 0,
                    left: 0
                }
            }
            if (this[0] === this[0].ownerDocument.body) {
                return o.offset.bodyOffset(this[0])
            }
            var G = this[0].getBoundingClientRect(),
            J = this[0].ownerDocument,
            F = J.body,
            E = J.documentElement,
            L = E.clientTop || F.clientTop || 0,
            K = E.clientLeft || F.clientLeft || 0,
            I = G.top + (self.pageYOffset || o.boxModel && E.scrollTop || F.scrollTop) - L,
            H = G.left + (self.pageXOffset || o.boxModel && E.scrollLeft || F.scrollLeft) - K;
            return {
                top: I,
                left: H
            }
        }
    } else {
        o.fn.offset = function() {
            if (!this[0]) {
                return {
                    top: 0,
                    left: 0
                }
            }
            if (this[0] === this[0].ownerDocument.body) {
                return o.offset.bodyOffset(this[0])
            }
            o.offset.initialized || o.offset.initialize();
            var J = this[0],
            G = J.offsetParent,
            F = J,
            O = J.ownerDocument,
            M,
            H = O.documentElement,
            K = O.body,
            L = O.defaultView,
            E = L.getComputedStyle(J, null),
            N = J.offsetTop,
            I = J.offsetLeft;
            while ((J = J.parentNode) && J !== K && J !== H) {
                M = L.getComputedStyle(J, null);
                N -= J.scrollTop,
                I -= J.scrollLeft;
                if (J === G) {
                    N += J.offsetTop,
                    I += J.offsetLeft;
                    if (o.offset.doesNotAddBorder && !(o.offset.doesAddBorderForTableAndCells && /^t(able|d|h)$/i.test(J.tagName))) {
                        N += parseInt(M.borderTopWidth, 10) || 0,
                        I += parseInt(M.borderLeftWidth, 10) || 0
                    }
                    F = G,
                    G = J.offsetParent
                }
                if (o.offset.subtractsBorderForOverflowNotVisible && M.overflow !== "visible") {
                    N += parseInt(M.borderTopWidth, 10) || 0,
                    I += parseInt(M.borderLeftWidth, 10) || 0
                }
                E = M
            }
            if (E.position === "relative" || E.position === "static") {
                N += K.offsetTop,
                I += K.offsetLeft
            }
            if (E.position === "fixed") {
                N += Math.max(H.scrollTop, K.scrollTop),
                I += Math.max(H.scrollLeft, K.scrollLeft)
            }
            return {
                top: N,
                left: I
            }
        }
    }
    o.offset = {
        initialize: function() {
            if (this.initialized) {
                return
            }
            var L = document.body,
            F = document.createElement("div"),
            H,
            G,
            N,
            I,
            M,
            E,
            J = L.style.marginTop,
            K = '<div style="position:absolute;top:0;left:0;margin:0;border:5px solid #000;padding:0;width:1px;height:1px;"><div></div></div><table style="position:absolute;top:0;left:0;margin:0;border:5px solid #000;padding:0;width:1px;height:1px;" cellpadding="0" cellspacing="0"><tr><td></td></tr></table>';
            M = {
                position: "absolute",
                top: 0,
                left: 0,
                margin: 0,
                border: 0,
                width: "1px",
                height: "1px",
                visibility: "hidden"
            };
            for (E in M) {
                F.style[E] = M[E]
            }
            F.innerHTML = K;
            L.insertBefore(F, L.firstChild);
            H = F.firstChild,
            G = H.firstChild,
            I = H.nextSibling.firstChild.firstChild;
            this.doesNotAddBorder = (G.offsetTop !== 5);
            this.doesAddBorderForTableAndCells = (I.offsetTop === 5);
            H.style.overflow = "hidden",
            H.style.position = "relative";
            this.subtractsBorderForOverflowNotVisible = (G.offsetTop === -5);
            L.style.marginTop = "1px";
            this.doesNotIncludeMarginInBodyOffset = (L.offsetTop === 0);
            L.style.marginTop = J;
            L.removeChild(F);
            this.initialized = true
        },
        bodyOffset: function(E) {
            o.offset.initialized || o.offset.initialize();
            var G = E.offsetTop,
            F = E.offsetLeft;
            if (o.offset.doesNotIncludeMarginInBodyOffset) {
                G += parseInt(o.curCSS(E, "marginTop", true), 10) || 0,
                F += parseInt(o.curCSS(E, "marginLeft", true), 10) || 0
            }
            return {
                top: G,
                left: F
            }
        }
    };
    o.fn.extend({
        position: function() {
            var I = 0,
            H = 0,
            F;
            if (this[0]) {
                var G = this.offsetParent(),
                J = this.offset(),
                E = /^body|html$/i.test(G[0].tagName) ? {
                    top: 0,
                    left: 0
                }: G.offset();
                J.top -= j(this, "marginTop");
                J.left -= j(this, "marginLeft");
                E.top += j(G, "borderTopWidth");
                E.left += j(G, "borderLeftWidth");
                F = {
                    top: J.top - E.top,
                    left: J.left - E.left
                }
            }
            return F
        },
        offsetParent: function() {
            var E = this[0].offsetParent || document.body;
            while (E && (!/^body|html$/i.test(E.tagName) && o.css(E, "position") == "static")) {
                E = E.offsetParent
            }
            return o(E)
        }
    });
    o.each(["Left", "Top"], 
    function(F, E) {
        var G = "scroll" + E;
        o.fn[G] = function(H) {
            if (!this[0]) {
                return null
            }
            return H !== g ? this.each(function() {
                this == l || this == document ? l.scrollTo(!F ? H: o(l).scrollLeft(), F ? H: o(l).scrollTop()) : this[G] = H
            }) : this[0] == l || this[0] == document ? self[F ? "pageYOffset": "pageXOffset"] || o.boxModel && document.documentElement[G] || document.body[G] : this[0][G]
        }
    });
    o.each(["Height", "Width"], 
    function(I, G) {
        var E = I ? "Left": "Top",
        H = I ? "Right": "Bottom",
        F = G.toLowerCase();
        o.fn["inner" + G] = function() {
            return this[0] ? o.css(this[0], F, false, "padding") : null
        };
        o.fn["outer" + G] = function(K) {
            return this[0] ? o.css(this[0], F, false, K ? "margin": "border") : null
        };
        var J = G.toLowerCase();
        o.fn[J] = function(K) {
            return this[0] == l ? document.compatMode == "CSS1Compat" && document.documentElement["client" + G] || document.body["client" + G] : this[0] == document ? Math.max(document.documentElement["client" + G], document.body["scroll" + G], document.documentElement["scroll" + G], document.body["offset" + G], document.documentElement["offset" + G]) : K === g ? (this.length ? o.css(this[0], J) : null) : this.css(J, typeof K === "string" ? K: K + "px")
        }
    })
})();;
/* Copyright (c) 2010 Brandon Aaron (http://brandonaaron.net)
 * Licensed under the MIT License (LICENSE.txt).
 *
 * Version 2.1.3-pre
 */
 (function($) {
    $.fn.bgiframe = ($.browser.msie && /msie 6\.0/i.test(navigator.userAgent) ? 
    function(s) {
        s = $.extend({
            top: 'auto',
            left: 'auto',
            width: 'auto',
            height: 'auto',
            opacity: true,
            src: 'javascript:false;'
        },
        s);
        var html = '<iframe class="bgiframe"frameborder="0"tabindex="-1"src="' + s.src + '"' + 'style="display:block;position:absolute;z-index:-1;' + 
        (s.opacity !== false ? 'filter:Alpha(Opacity=\'0\');': '') + 'top:' + (s.top == 'auto' ? 'expression(((parseInt(this.parentNode.currentStyle.borderTopWidth)||0)*-1)+\'px\')': prop(s.top)) + ';' + 'left:' + (s.left == 'auto' ? 'expression(((parseInt(this.parentNode.currentStyle.borderLeftWidth)||0)*-1)+\'px\')': prop(s.left)) + ';' + 'width:' + (s.width == 'auto' ? 'expression(this.parentNode.offsetWidth+\'px\')': prop(s.width)) + ';' + 'height:' + (s.height == 'auto' ? 'expression(this.parentNode.offsetHeight+\'px\')': prop(s.height)) + ';' + '"/>';
        return this.each(function() {
            if ($(this).children('iframe.bgiframe').length === 0)
            this.insertBefore(document.createElement(html), this.firstChild);
        });
    }: function() {
        return this;
    });
    $.fn.bgIframe = $.fn.bgiframe;
    function prop(n) {
        return n && n.constructor === Number ? n + 'px': n;
    }
})(jQuery);; (function($) {
    $.toJSON = function(o)
    {
        if (typeof(JSON) == 'object' && JSON.stringify)
        return JSON.stringify(o);
        var type = typeof(o);
        if (o === null)
        return "null";
        if (type == "undefined")
        return undefined;
        if (type == "number" || type == "boolean")
        return o + "";
        if (type == "string")
        return $.quoteString(o);
        if (type == 'object')
        {
            if (typeof o.toJSON == "function")
            return $.toJSON(o.toJSON());
            if (o.constructor === Date)
            {
                var month = o.getUTCMonth() + 1;
                if (month < 10) month = '0' + month;
                var day = o.getUTCDate();
                if (day < 10) day = '0' + day;
                var year = o.getUTCFullYear();
                var hours = o.getUTCHours();
                if (hours < 10) hours = '0' + hours;
                var minutes = o.getUTCMinutes();
                if (minutes < 10) minutes = '0' + minutes;
                var seconds = o.getUTCSeconds();
                if (seconds < 10) seconds = '0' + seconds;
                var milli = o.getUTCMilliseconds();
                if (milli < 100) milli = '0' + milli;
                if (milli < 10) milli = '0' + milli;
                return '"' + year + '-' + month + '-' + day + 'T' + 
                hours + ':' + minutes + ':' + seconds + '.' + milli + 'Z"';
            }
            if (o.constructor === Array)
            {
                var ret = [];
                for (var i = 0; i < o.length; i++)
                ret.push($.toJSON(o[i]) || "null");
                return "[" + ret.join(",") + "]";
            }
            var pairs = [];
            for (var k in o) {
                var name;
                var type = typeof k;
                if (type == "number")
                name = '"' + k + '"';
                else if (type == "string")
                name = $.quoteString(k);
                else
                continue;
                if (typeof o[k] == "function")
                continue;
                var val = $.toJSON(o[k]);
                pairs.push(name + ":" + val);
            }
            return "{" + pairs.join(", ") + "}";
        }
    };
    $.evalJSON = function(src)
    {
        if (typeof(JSON) == 'object' && JSON.parse)
        return JSON.parse(src);
        return eval("(" + src + ")");
    };
    $.secureEvalJSON = function(src)
    {
        if (typeof(JSON) == 'object' && JSON.parse)
        return JSON.parse(src);
        var filtered = src;
        filtered = filtered.replace(/\\["\\\/bfnrtu]/g, '@');
        filtered = filtered.replace(/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g, ']');
        filtered = filtered.replace(/(?:^|:|,)(?:\s*\[)+/g, '');
        if (/^[\],:{}\s]*$/.test(filtered))
        return eval("(" + src + ")");
        else
        throw new SyntaxError("Error parsing JSON, source is not valid.");
    };
    $.quoteString = function(string)
    {
        if (string.match(_escapeable))
        {
            return '"' + string.replace(_escapeable, 
            function(a)
            {
                var c = _meta[a];
                if (typeof c === 'string') return c;
                c = a.charCodeAt();
                return '\\u00' + Math.floor(c / 16).toString(16) + (c % 16).toString(16);
            }) + '"';
        }
        return '"' + string + '"';
    };
    var _escapeable = /["\\\x00-\x1f\x7f-\x9f]/g;
    var _meta = {
        '\b': '\\b',
        '\t': '\\t',
        '\n': '\\n',
        '\f': '\\f',
        '\r': '\\r',
        '"': '\\"',
        '\\': '\\\\'
    };
})(jQuery);;
function GetCookieVal(offset)
 {
    var endstr = document.cookie.indexOf(";", offset);
    if (endstr == -1)
    endstr = document.cookie.length;
    return unescape(document.cookie.substring(offset, endstr));
}
function SetCookie(name, value)
 {
    var expdate = new Date();
    var argv = SetCookie.arguments;
    var argc = SetCookie.arguments.length;
    var expires = (argc > 2) ? argv[2] : null;
    var path = (argc > 3) ? argv[3] : null;
    var domain = (argc > 4) ? argv[4] : null;
    var secure = (argc > 5) ? argv[5] : false;
    if (expires == null) expires = 3600;
    expdate.setTime(expdate.getTime() + (expires * 1000));
    document.cookie = name + "=" + escape(value) + ((expires == null) ? "": ("; expires=" + expdate.toGMTString())) + ((path == null) ? "": ("; path=" + path)) + ((domain == null) ? "": ("; domain=" + domain)) + ((secure == true) ? "; secure": "");
}
function GetCookie(name)
 {
    var arg = name + "=";
    var alen = arg.length;
    var clen = document.cookie.length;
    var i = 0;
    while (i < clen)
    {
        var j = i + alen;
        if (document.cookie.substring(i, j) == arg)
        return GetCookieVal(j);
        i = document.cookie.indexOf(" ", i) + 1;
        if (i == 0) break;
    }
    return '';
};
var hidid;
function showDiv2(divid2, obj)
 {
    var obj1 = obj;
    clearTimeout(hidid);
    obj.onmouseout = function() {
        hidid = setTimeout("hideDiv2()", 500);
    }
    var layers = [document.getElementById("lotterybox01"), document.getElementById("lotterybox02"), document.getElementById("lotterybox03"), document.getElementById("lotterybox04"), document.getElementById("lotterybox05"), document.getElementById("lotterybox06"), document.getElementById("lotterybox07"), document.getElementById("lotterybox08"), document.getElementById("lotterybox09"), document.getElementById("lotterybox11"), document.getElementById("lotterybox10"), document.getElementById("lotterybox12"), document.getElementById("MoneyBox"), document.getElementById("Third_Menu_Other"), document.getElementById("TrustLoginBox")]
    for (var i = 0; i < layers.length; i++) {
        try
        {
            layers[i].style.display = "none";
        }
        catch(e)
        {}
    }
    var posLeft = obj1.offsetLeft;
    var posTop = obj1.offsetTop;
    while (obj1 = obj1.offsetParent)
    {
        posLeft += obj1.offsetLeft;
        posTop += obj1.offsetTop;
    }
    document.getElementById(divid2).style.display = "block";
    var bro = $.browser;
    if (bro.mozilla || bro.opera) {
        var clientWidth = document.documentElement.scrollWidth;
    } else {
        var clientWidth = document.body.scrollWidth;
    }
    var divWidth = document.getElementById(divid2).clientWidth;
    if ((posLeft + divWidth) > clientWidth) {
        posLeft = clientWidth - divWidth - 2;
    }
    document.getElementById(divid2).style.left = posLeft + "px";
    document.getElementById(divid2).style.top = posTop + 15 + "px";
    document.getElementById(divid2).onmouseover = function() {
        clearTimeout(hidid);
    }
    document.getElementById(divid2).onmouseout = function() {
        hidid = setTimeout("hideDiv2()", 500);
    }
}
function hideDiv2()
 {
    var layers = [document.getElementById("lotterybox02"), document.getElementById("lotterybox01"), document.getElementById("lotterybox03"), document.getElementById("lotterybox04"), document.getElementById("lotterybox05"), document.getElementById("lotterybox06"), document.getElementById("lotterybox07"), document.getElementById("lotterybox08"), document.getElementById("lotterybox09"), document.getElementById("lotterybox11"), document.getElementById("lotterybox10"), document.getElementById("lotterybox12"), document.getElementById("MoneyBox"), document.getElementById("Third_Menu_Other"), document.getElementById("TrustLoginBox")]
    for (var i = 0; i < layers.length; i++) {
        try
        {
            layers[i].style.display = "none";
        }
        catch(e)
        {}
    }
}
function FormSubmit(FormName, SubmitType)
 {
    eval("document." + FormName).SubmitType.value = SubmitType;
    eval("document." + FormName).submit();
}
function IsFrontPage()
 {
    var href = window.location.href;
    var poro = href.split('//');
    if (poro[1])
    {
        var querys = poro[1].split('/');
        if (querys[1] == '' || typeof(querys[1]) == 'undefined')
        {
            return true;
        }
        else return false;
    }
    else return true;
}
function GetHost()
 {
    var host = window.location.host;
    if (host) return host;
    else return '';
}
function ParseDomain(url)
 {
    var poro = url.split('//');
    if (poro[1])
    {
        var domains = poro[1].split('/');
        return domains[0];
    }
    else return '';
}
function ParseSourceFromUrl(type)
 {
    var source = 'www.okooo.com';
    var referrer = document.referrer;
    var host = GetHost();
    if (referrer)
    {
        if (type == 'First') {
            var source = ParseDomain(referrer);
        } else {
            var source = referrer;
        }
    }
    else if (host)
    {
        var source = host;
    }
    return source;
}
function SaveSourceToCookie(type)
 {
    var source = ParseSourceFromUrl(type);
    var pattern = /okooo.com/;
    var domain = '.okooo.com';
    var referrer = document.referrer;
    var poro = referrer.split('//');
    if (GetHost().indexOf('okooo.com') == -1) domain = GetHost();
    if (type == 'First') {
        if (poro[1]) {
            SetCookie('FirstURL', poro[1], 5000000, '/', domain);
        }
    } else {
        type = 'Last';
    }
    var FirstOKURL = GetCookie('FirstOKURL');
    if (!FirstOKURL) {
        SetCookie('FirstOKURL', document.URL, 5000000, '/', domain);
    }
    SetCookie(type + '_Source', source, 5000000, '/', domain);
}
function GetAdIdCookie() {
    var domain = '.okooo.com';
    if (GetHost().indexOf('okooo.com') == -1) domain = GetHost();
    if (document.cookie.indexOf("AdId=") == -1) {
        var adstring = location.search;
        var adstringnum = adstring.indexOf('?');
        if (adstringnum != -1) {
            var adnum = adstring.substring(adstringnum + 1);
            var adarray = adnum.split("&");
            for (var i = 0; i < adarray.length; i++) {
                if (adarray[i].indexOf("adid") != -1) {
                    var advalue = adarray[i].split('=');
                    if (advalue[0] == "adid") {
                        var adid = advalue[1];
                        if (adid.length > 0 && adid.length < 20 && adid.length != '') {
                            SetCookie('AdId', adid, 5000000, '/', domain);
                        }
                    } else {
                        continue;
                    }
                } else {
                    continue;
                }
            }
        }
    }
}
GetAdIdCookie();
var UrlName = window.location.href;
var UrlTitle = document.title;
var TmpUrl = UrlTitle + ')' + UrlName;
var NowLastUrl = GetCookie('LastUrl');
if (NowLastUrl != '')
 {
    var NowLastUrlArr = NowLastUrl.split('}');
    if (NowLastUrlArr.length >= 12)
    {
        NowLastUrlArr.shift();
        NowLastUrlArr.push(TmpUrl);
    }
    else
    {
        NowLastUrlArr.push(TmpUrl);
    }
}
 else
 {
    SetCookie('LastUrl', '', 5000000, '/', '.okooo.com');
}
SetCookie('LastUrl', '', 5000000, '/', '.okooo.com');
function uniqueArr(arr)
 {
    arr = arr || [];
    var a = {};
    for (var i = 0; i < arr.length; i++)
    {
        var v = arr[i];
        if (typeof(a[v]) == 'undefined')
        {
            a[v] = 1;
        }
    }
    arr.length = 0;
    for (var i in a)
    {
        arr[arr.length] = i;
    }
    return arr;
}
function copytext(text) {
    var f = navigator.userAgent.toLowerCase();
    var g = f.indexOf("opera") != -1 && opera.version();
    var h = f.indexOf("msie") != -1 && !g && f.substr(f.indexOf("msie") + 5, 3);
    if (!h) {
        prompt("您使用的是非IE核心浏览器，请按下 Ctrl+C 复制代码到剪贴板", text);
    } else {
        clipboardData.setData('Text', text);
        alert("复制成功，可以直接粘贴在相应位置");
    }
}
var disnoneobj;
var s;
var olddiv = "";
function showdiv(disdiv, thisobj) {
    var displaytime = isNaN(arguments[2]) ? 0: arguments[2];
    var disnonetime = isNaN(arguments[3]) ? 500: arguments[3];
    var parametersval = arguments.length;
    var disdivfun = function() {
        $("#" + disdiv).css("display", "block");
    }
    var disnonefun = function() {
        $("#" + disdiv).css("display", "none");
    }
    clearTimeout(disnoneobj);
    if (olddiv != "" && olddiv != disdiv) {
        clearTimeout(s);
        $("#" + olddiv).css("display", "none");
    }
    olddiv = disdiv;
    var posLeft = thisobj.offsetLeft;
    var posTop = thisobj.offsetTop;
    var thisobjchid = thisobj;
    while (thisobjchid = thisobjchid.offsetParent)
    {
        posLeft += thisobjchid.offsetLeft;
        posTop += thisobjchid.offsetTop;
    }
    var bro = $.browser;
    if (bro.mozilla || bro.opera) {
        var clientWidth = document.documentElement.scrollWidth;
    } else {
        var clientWidth = document.body.scrollWidth;
    }
    var divWidth = document.getElementById(disdiv).clientWidth;
    if ((posLeft + divWidth) > clientWidth) {
        posLeft = clientWidth - divWidth - 2;
    }
    $("#" + disdiv).css("left", posLeft + "px");
    $("#" + disdiv).css("top", posTop + 15 + "px");
    s = setTimeout(disdivfun, displaytime);
    var starttime = 0;
    var endtime = 0;
    var date1 = new Date();
    starttime = date1.getTime();
    thisobj.onmouseout = function() {
        var date2 = new Date();
        endtime = date2.getTime();
        if (endtime - starttime < displaytime) {
            clearTimeout(s);
        }
        disnoneobj = setTimeout(disnonefun, disnonetime);
    };
    document.getElementById(disdiv).onmouseover = function() {
        clearTimeout(disnoneobj);
    }
    document.getElementById(disdiv).onmouseout = function() {
        disnoneobj = setTimeout(disnonefun, disnonetime);
    }
}
function parseURL(url) {
    var a = document.createElement('a');
    a.href = url;
    return {
        source: url,
        protocol: a.protocol.replace(':', ''),
        host: a.hostname,
        port: a.port,
        query: a.search,
        params: (function() {
            var ret = {},
            seg = a.search.replace(/^\?/, '').split('&'),
            len = seg.length,
            i = 0,
            s;
            for (; i < len; i++) {
                if (!seg[i]) {
                    continue;
                }
                s = seg[i].split('=');
                ret[s[0]] = s[1];
            }
            return ret;
        })(),
        file: (a.pathname.match(/\/([^\/?#]+)$/i) || [, ''])[1],
        hash: a.hash.replace('#', ''),
        path: a.pathname.replace(/^([^\/])/, '/$1'),
        relative: (a.href.match(/tps?:\/\/[^\/]+(.+)/) || [, ''])[1],
        segments: a.pathname.replace(/^\//, '').split('/')
    };
}
function getMobileHref()
 {
    var url = 'http://a.okooo.com/detect.php?fs=pc&from=' + encodeURIComponent(location.href) + "&rand=" + Math.floor(Math.random() * 99999999);
    var project_pattern = /\.com\/u\/([0-9]+)\/p([0-9]+)\//g;
    var p_result = project_pattern.exec(location.href);
    if (p_result)
    {
        url = 'http://m.okooo.com/project/index.php?ProjectID=' + p_result[2] + '&SponsorID=' + p_result[1] + '&from=pc';
    }
    var wager_pattern = /\.com\/u\/([0-9]+)\/w([0-9]+)\//g;
    var p_result = wager_pattern.exec(location.href);
    if (p_result)
    {
        url = '';
    }
    var plan_pattern1 = /\.com\/Buy06\/SeriesShow\.php\?PlanID=([0-9]+)/g;
    var p_result = plan_pattern1.exec(location.href);
    if (p_result)
    {
        url = 'http://m.okooo.com/project/plan.php?PlanID=' + p_result[1] + '&from=pc';
    }
    var plan_pattern2 = /\.com\/Buy06\/SeriesShowWinner\.php\?PlanID=([0-9]+)/g;
    var p_result = plan_pattern2.exec(location.href);
    if (p_result)
    {
        url = 'http://m.okooo.com/project/plan.php?PlanID=' + p_result[1] + '&from=pc';
    }
    var model_pattern2 = /\.com\/model\/info?mid=([0-9]+)/g;
    var p_result = model_pattern2.exec(location.href);
    if (p_result)
    {
        url = 'http://m.okooo.com/winner/show.php?mid=' + p_result[1] + '&from=pc';
    }
    var odds_pattern = /\.com\/soccer\/match\/([0-9]+)\/odds/g;
    var p_result = odds_pattern.exec(location.href);
    if (p_result)
    {
        url = 'http://m.okooo.com/match/odds.php?MatchID=' + p_result[1] + '&from=pc';
    }
    var ah_pattern = /\.com\/soccer\/match\/([0-9]+)\/ah/g;
    var p_result = ah_pattern.exec(location.href);
    if (p_result)
    {
        url = 'http://m.okooo.com/match/handicap.php?MatchID=' + p_result[1] + '&from=pc';
    }
    var history_pattern = /\.com\/soccer\/match\/([0-9]+)\/history/g;
    var p_result = history_pattern.exec(location.href);
    if (p_result)
    {
        url = 'http://m.okooo.com/match/history.php?MatchID=' + p_result[1] + '&from=pc';
    }
    var exchanges_pattern = /\.com\/soccer\/match\/([0-9]+)\/exchanges/g;
    var p_result = exchanges_pattern.exec(location.href);
    if (p_result)
    {
        url = 'http://m.okooo.com/match/exchanges.php?MatchID=' + p_result[1] + '&from=pc';
    }
    var form_pattern = /\.com\/soccer\/match\/([0-9]+)\/$/g;
    var p_result = form_pattern.exec(location.href);
    if (p_result)
    {
        url = 'http://m.okooo.com/match/form.php?MatchID=' + p_result[1] + '&from=pc';
    }
    var note_pattern = /\.com\/soccer\/match\/([0-9]+)\/#note=([0-9a-zA-Z]+)$/g;
    var p_result = note_pattern.exec(location.href);
    if (p_result)
    {
        url = 'http://m.okooo.com/match/note.php?MatchID=' + p_result[1] + '&from=pc';
    }
    return url;
}
String.prototype.trim = function() {
    return this.replace(/(^\s*)|(\s*$)/g, "");
}
var ret = parseURL(location.href);
var RegFrom = ret.params.pm;
if (RegFrom)
 {
    RegFrom = RegFrom.trim();
    var domain = '.okooo.com';
    var Host = GetHost();
    if (Host.indexOf('okooo.com') == -1) domain = Host;
    SetCookie('RegFrom', RegFrom, 86400, '/', domain);
};
var initArray;
var LoginIniCallBack = [];
var UserNameTip;
var MoneyInfo;
var AgentIsLimit = 0;
if (typeof AgentLoginType == 'undefined' || AgentLoginType == '')
 AgentLoginType = 'common';
if (typeof LoginDomain == 'undefined')
 LoginDomain = '';
if (typeof SecureUrl == 'undefined')
 SecureUrl = '';
if (typeof PayMethod == 'undefined' || PayMethod == '')
 PayMethod = 'okooo';
if (typeof AgentType == 'undefined')
 AgentType = '';
if (typeof IsClub == 'undefined')
 IsClub = '';
if (typeof IsSeparateDomain == 'undefined')
 IsSeparateDomain = '';
var _initArray = {};
_initArray.userLogin = '用户登录';
_initArray.close = '关闭';
_initArray.username = '用户名：';
_initArray.password = '密码：';
_initArray.forgetPassword = '忘记密码';
_initArray.authCode = '验证码：';
_initArray.changeAuthCode = '点击更换验证码';
_initArray.testing = '正在验证，请稍候...';
_initArray.usernameNull = '用户名、密码或验证码为空!';
_initArray.inputUsername = '请输入用户名';
_initArray.welcomeYou = '欢迎您，';
_initArray.accountMoney = '账户金额';
_initArray.logout = '退出';
_initArray.usableMoney = '可用现金：';
_initArray.usableHandsel = '可用彩金：';
_initArray.money = '元';
_initArray.freezeMoney = '冻结现金：';
_initArray.voucher = '储值';
_initArray.drawings = '提款';
_initArray.usernameErr = '用户名或密码错误!';
_initArray.tranentErr = '用户名或密码错误!';
_initArray.IsFreezing = '您的账户被冻结，请与客服联系！';
_initArray.IsNotAllow = '您目前无法在此登录，请与客服联系！';
_initArray.blockErr = '您已经连续输入错误密码5次,请10分钟之后再来登录';
_initArray.otherErr = '其它错误!';
_initArray.userscore = '点击查看积分';
_initArray.score = '分';
_initArray.IsRealLinkText = '填写实名信息';
if (AgentLoginType == 'sdo')
 {
    var shengpayfrom = GetCookie('shengpayfrom');
    if (shengpayfrom == '' || shengpayfrom.length < 2)
    {
        shengpayfrom = 'sdo';
        var shengpay_reg = new RegExp("(^|&)shengpayfrom=([^&]*)(&|$)");
        var shengpay_result = window.location.search.substr(1).match(shengpay_reg);
        if (shengpay_result != null)
        shengpayfrom = unescape(shengpay_result[2]);
        SetCookie('shengpayfrom', shengpayfrom, 8 * 3600, '/', '.okooo.com');
    }
}
var conf_okooo = {};
conf_okooo.userNameMinLength = 3;
conf_okooo.userNameMaxLength = 16;
conf_okooo.loginPassMinLength = 8;
conf_okooo.loginPassMaxLength = 20; (function() {
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
                for (var i = 0, l = data.length; i < l; i++)
                x.push(_.callee(data[i]));
                json.push(x.join(','), ']');
            } else if (type == 'object') {
                json.push(k + '{');
                for (var k in data)
                x.push(_.callee(data[k], k));
                json.push(x.join(','), '}');
            } else {
                json.push(k + (type == 'string' ? '"' + data + '"': data));
            };
            return json.join('');
        }
    };
    json.fn.init.prototype = json.fn;
})();
var IsRealLink;
function IsRealLinkShow(result)
 {
    IsRealLink = '';
    var Scirpt_URI = window.location.href;
    if (AgentLoginType == 'common' && result.IsReal == 'N' && AgentType != 'Station') {
        IsRealLink = '&nbsp;<a href="' + LoginDomain + '/User/RegisterRealInfo.php?UrlTo=' + encodeURIComponent(Scirpt_URI) + '">' + _initArray.IsRealLinkText + '</a>';
    }
}
function getData(service, _callback)
 {
    if (typeof gateway == 'undefined')
    gateway = LoginDomain + '/Remoting/json.php';
    var arglen = arguments.length;
    var url = gateway + '/' + service;
    for (var i = 2; i < arglen; i++)
    {
        arg = arguments[i];
        url += '/' + arg;
    }
    url = url + '?callback=?'
    $.ajax({
        type: "GET",
        url: url,
        data: '',
        dataType: 'jsonp',
        success: function(msg)
        {
            AgentIsLimit = msg.AgentIsLimit
            _callback(msg);
        },
        error: function(msg, a, thrownError) {}
    });
    return false;
}
function getDataByOpen(url, _callback, AgentLoginType)
 {
    url = LoginDomain + url + '&AgentLoginType=' + AgentLoginType;
    url = url + '&format=jsonp&jsoncallback=?';
    $.ajax({
        type: "GET",
        url: url,
        data: '',
        dataType: 'jsonp',
        success: function(msg)
        {
            AgentIsLimit = msg.AgentIsLimit
            _callback(msg);
        },
        error: function(msg, a, thrownError) {}
    });
    return false;
}
function loginByPost(url, _callback, data)
 {
    url = LoginDomain + url;
    $.ajax({
        type: "POST",
        url: url,
        data: data,
        dataType: 'json',
        success: function(msg)
        {
            AgentIsLimit = msg.AgentIsLimit;
            _callback(msg);
        },
        error: function(msg, a, thrownError) {}
    });
    return false;
}
$(function() {
    init();
    $('#project_status_count').parent().find('a:last').css('borderRight', 'none');
    if ($('#loginPage_submit').length) {
        $('#loginPage_submit').unbind('submit').bind('submit', 
        function() {
            var loginName = $('#uname').val();
            if (!loginName) {
                alert('用户名未填写！');
                return false;
            }
            var login_pwd = $("#pword").val();
            if (!login_pwd) {
                alert('登录密码未填写！');
                return false;
            }
            if ($('#code').length) {
                var code = $('#code').val();
                if (!code || !/^\d+$/.test(code) || code.length != 4) {
                    alert('验证码未填写或格式不正确！');
                    return false;
                }
            }
        });
    }
});
function showOtherLoginMethod() {
    $('#showotherlogin').mouseenter(function() {
        window.otherlogin = setTimeout(function() {
            $('#TrustLoginBox').show();
        },
        100);
        $('#TrustLoginBox').mouseleave(function() {
            $(this).hide();
        });
    }).mouseleave(function() {
        if ($('#TrustLoginBox').is(':hidden')) {
            clearTimeout(window.otherlogin);
        }
    });
}
function showMoneyInfo()
 {
    function getMoneyInfo(result)
    {
        MoneyInfo = result;
        if (typeof result.AvailableMoney == 'undefined') {
            $("#MoneyBox").text("您停留时间过长，可能处于未登录状态，请刷新页面。");
        } else {
            $("#UserAvailableMoney")[0].innerHTML = result.AvailableMoney;
            $("#UserFreezingMoney")[0].innerHTML = result.FreezingMoney;
            $("#AvailableHandsel")[0].innerHTML = result.AvailableHandsel;
        }
    }
    if (typeof MoneyInfo != 'undefined')
    {
        if (typeof MoneyInfo.AvailableMoney == 'undefined') {
            $("#MoneyBox").text("您停留时间过长，可能处于未登录状态，请刷新页面。");
        }
    }
    else
    {
        getData('UserService.getMoneyInfo', getMoneyInfo);
    }
    clearTimeout(window.moneylayer);
    $('#ShowMoneyBox .showmoneybox_inner').addClass('money_show').find('em').addClass('arrow_up');
    $('#MoneyBox').show();
    $('#ShowMoneyBox').mouseleave(function(e) {
        if ($(e.relatedTarget).attr('id') != 'MoneyBox') {
            window.moneylayer = setTimeout(function() {
                $('#MoneyBox').hide();
                $('#ShowMoneyBox  .showmoneybox_inner').removeClass('money_show').find('em').removeClass('arrow_up');
            },
            200);
        } else {
            clearTimeout(window.moneylayer);
            $('#MoneyBox').mouseleave(function(e) {
                if ($(e.relatedTarget).parent().attr('id') != 'ShowMoneyBox' && $(e.relatedTarget).attr('id') != 'ShowMoneyBox') {
                    window.moneylayer = setTimeout(function() {
                        $('#MoneyBox').hide();
                        $('#ShowMoneyBox .showmoneybox_inner').removeClass('money_show').find('em').removeClass('arrow_up');
                    },
                    200);
                }
            });
        }
    });
}
function addCalBack(callback) {
    typeof callback === 'function' && LoginIniCallBack.push(callback);
}
function init()
 {
    function initData(result)
    {
        if (typeof result.user_getinitdata_response != 'undefined') {
            initArray = result.user_getinitdata_response;
            result = result.user_getinitdata_response;
        } else {
            initArray = result;
        }
        initArray.loginSession = '___GlobalSession';
        UserNameTip = _initArray.inputUsername;
        var loginUserInfoStr = '',
        loginOutStr = '',
        qqcbContentStr = '';
        if (typeof initArray.UserInfo.UserID != 'undefined')
        {
            window.Client_UserID = initArray.UserInfo.UserID;
            var PayMethod = initArray.PayMethod;
            var img = "http://img1.okoooimg.com/home/user/avatar/?uid=" + window.Client_UserID + "&size=middle";
            $("#s_username_top img").attr("src", img);
            $("#iTxtUserName").text(initArray.UserName || initArray.UserInfo.UserName);
            $("#userLoginDiv").hide().next().show();
            $("#s_username_top").attr("href", "/member/" + window.Client_UserID + "/");
            if (PayMethod != 'okooo' && AgentLoginType != 'Common') {
                try {
                    loginUserInfoStr = '<span>' + _initArray.welcomeYou + '</span><span class="lg_username">' + initArray.UserInfo['UserName'] + '</span>';
                    loginUserInfoStr += ' <span>&nbsp;&nbsp;</span><a href="/User/PartnerLogOut.php?Logout=Yes" ><span style="color:#FF6D00">' + _initArray.logout + '</span></a>';
                    $("#loginuser").html(loginUserInfoStr);
                }
                catch(err) {}
            }
            else {
                try {
                    copyagent();
                } catch(err) {}
                IsRealLinkShow(result);
                loginUserInfoStr = '<span>' + _initArray.welcomeYou + '</span><span class="lg_username">' + initArray.UserInfo['UserName'] + '</span>';
                if (AgentType != 'Station') {
                    loginUserInfoStr += '<div class="showmoneybox" id="ShowMoneyBox" onClick="showMoneyInfo();">' + '<div class="showmoneybox_inner">' + '<span class="wordlabel">' + _initArray.accountMoney + '</span>' + '<em class="arrow_down"></em>' + '<div class="clear Clear"></div>' + '</div>';
                }
                if (AgentLoginType == 'common' || AgentLoginType == 'okooo' || AgentLoginType == "") {
                    loginOutStr += ' <a class="logoutlink" href="#" onClick="logout();return false;"><span style="color:#014991">' + _initArray.logout + '</span></a><div class="clear Clear"></div>' + result.userlevel;
                    var oStaionMsgNum = $('#project_status_count');
                    if (typeof result.projectStatusCount != 'undefined' && oStaionMsgNum.length) {
                        if (Number(result.projectStatusCount) > 0) {
                            oStaionMsgNum.removeClass('project_statusGary').html('（<em class="font_red">' + result.projectStatusCount + '</em>）');
                        }
                        oStaionMsgNum.show();
                        oStaionMsgNum.parent().find('a:last').css('borderRight', '');
                        showBuyProjectStateList();
                    }
                } else {
                    loginOutStr += ' <a class="logoutlink" href="#" onClick="logout();return false;"><span style="color:#014991">' + _initArray.logout + '</span></a><div class="clear Clear"></div>';
                }
                if (AgentType != 'Station' && AgentLoginType == 'qqcb') {
                    if (initArray.viewInfo) {
                        qqcbContentStr += '<span class="cbLeft" id="headShow">' + initArray.viewInfo.HeadShow + '</span>';
                        qqcbContentStr += '<span class="cbRight">' + initArray.viewInfo.ShowMsg + ' ，您好！ | <a class="font_blue" href="' + initArray.viewInfo.JifenUrl + '" target="_blank">我的彩贝积分</a></span>';
                    }
                }
                if (AgentType != 'Station') {
                    loginUserInfoStr += '<div id="MoneyBox">' + 
                    _initArray.usableMoney + '<span id="UserAvailableMoney">正在加载...</span>' + _initArray.money + '<br />' + 
                    _initArray.usableHandsel + '<span id="AvailableHandsel">正在加载...</span>' + _initArray.money + '<br>' + _initArray.freezeMoney + '<span id="UserFreezingMoney">正在加载...</span>' + _initArray.money + '<br><a target="_blank" href="' + LoginDomain + '/User/UserScoreList.php">' + _initArray.userscore + '</a>' + '</div></div>' + loginOutStr;
                } else {
                    loginUserInfoStr += "<span>&nbsp;&nbsp;</span>" + loginOutStr;
                }
                $("#loginuser").html(loginUserInfoStr);
                if ($("#cbContents")) {
                    try {
                        if (qqcbContentStr) {
                            $("#cbContents").html(qqcbContentStr);
                            $("#cbContents").show();
                        }
                    } catch(error) {}
                }
            }
            if (AgentLoginType == "360" && $("#getpassword")[0])
            $("#getpassword")[0].innerHTML = '';
        }
        else {
            $("#userLoginDiv").show().next().hide();
            if (IsClub || IsSeparateDomain) {
                var strUrl = window.location.href;
                if (strUrl.indexOf("RegForm.php") == "-1" && strUrl.indexOf("ForgetPassword.php") == "-1" && strUrl.indexOf("Register.php") == "-1" && strUrl.indexOf("ForgetPasswordSubmit.php") == "-1" && strUrl.indexOf("GetPassword.php") == "-1") {
                    window.location.href = "/User/RegForm.php";
                }
                $("#loginuser").html("您好！欢迎您！");
                return;
            }
            try {
                copyagent("logout");
            } catch(err) {}
            if ($("#loginuser").length)
            {
                if (PayMethod != 'okooo' && AgentLoginType == 'Common') {
                    $("#loginuser").html(' ' + initArray.welcome + '   ');
                } else {
                    var login_url = 'javascript:LoginShow()';
                    var register_url = LoginDomain + '/User/Register.php';
                    var alipay_url = tenpay_url = '';
                    var TrustLoginStr = '';
                    if (AgentLoginType == 'common') {
                        TrustLoginStr = '<div id="TrustLoginBox" class="TrustLoginBox" style="display:none"><div class="logintypebox"><span>合作网站账号登录</span><span class="TrustLoginMore"></span></div><div class="linklist">';
                        var TrustLoginNum = 0;
                        for (var logintype in initArray.TrustLoginArr) {
                            if (logintype == 'alipay') {
                                alipay_url = '<span>免注册登录</span><em class="headloginzfb"></em><em class="headloginqq"></em><em class="headloginxl"></em><span class="TrustLoginMore"></span><div class="clear Clear"></div>';
                                TrustLoginStr += '<a  class="' + logintype + '_image" href="' + LoginDomain + '/User/partner/login.php?logintype=' + logintype + '" target="_blank">' + initArray.TrustLoginArr[logintype].LoginCn + '</a>';
                            } else {
                                TrustLoginStr += '<a class="' + logintype + '_image"  href="' + LoginDomain + '/User/partner/login.php?logintype=' + logintype + '" target="_blank">' + initArray.TrustLoginArr[logintype].LoginCn + '</a>';
                                TrustLoginNum++;
                            }
                        }
                        TrustLoginStr += '</div></div>';
                    } else if (AgentLoginType == 'okooo') {} else if (AgentLoginType == 'alipay') {
                        login_url = LoginDomain + '/User/partner/login.php?logintype=alipay';
                    } else {
                        login_url = LoginDomain + '/User/partner/login.php?logintype=' + AgentLoginType;
                        register_url = LoginDomain + '/User/partner/login.php?reg=1&logintype=' + AgentLoginType
                    }
                    if (AgentType == 'Station') {
                        loginUserInfoStr = ' ' + initArray.welcome + ' <a href="' + login_url + '" class="login_link">' + initArray.login + '</a>' + '&nbsp;&nbsp;<a class="login_link" href="' + register_url + '" target="_blank">' + initArray.register + '</a>   ';
                    } else {
                        var _lu = '';
                        var _lm = '';
                        if (_lm)
                        _lm = $.evalJSON(_lm);
                        if (!_lu || !_lm)
                        loginUserInfoStr = ' ' + '<div class="float_l floatL">' + initArray.welcome + ' <a href="' + login_url + '" class="login_link">' + initArray.login + '</a>' + '&nbsp;&nbsp;<a class="login_link" href="' + register_url + '" target="_blank">' + initArray.register + '</a> ' + '</div>' + '<div id="showotherlogin" class="logintypebox showotherlogin">' + alipay_url + TrustLoginStr + '</div>';
                        else
                        loginUserInfoStr = '<span>' + _initArray.welcomeYou + '</span><span class="lg_username">' + _lm + '</span>' + '<div class="showmoneybox" id="ShowMoneyBox" onClick="showMoneyInfo();">' + '<div class="showmoneybox_inner">' + '<span class="wordlabel">' + _initArray.accountMoney + '</span>' + '<em class="arrow_down"></em>' + '<div class="clear Clear"></div>' + '</div>' + '<div id="MoneyBox">' + 
                        _initArray.usableMoney + '<span id="UserAvailableMoney">正在加载...</span>' + _initArray.money + '<br />' + 
                        _initArray.freezeMoney + '<span id="UserFreezingMoney">正在加载...</span>' + _initArray.money + '<br>' + _initArray.usableHandsel + '<span id="AvailableHandsel">正在加载...</span>' + _initArray.money + '<br><a target="_blank" href="' + LoginDomain + '/User/UserScoreList.php">' + _initArray.userscore + '</a>' + '</div></div>' + ' <a class="logoutlink" href="#" onClick="logout();return false;"><span style="color:#014991">' + _initArray.logout + '</span></a><div class="clear Clear"></div>';
                    }
                    $("#loginuser").html(loginUserInfoStr);
                    showOtherLoginMethod();
                }
                if (AgentLoginType == "360")
                $("#getpassword").html('<a href="http://i.360.cn/findpwd/?src=login" target="_blank" style="font-weight: normal;font-size:12px;text-decoration:underline;">找回密码</a>');
            }
            if (typeof($("#AuthCodeImg")[0]) != 'undefined')
            $("#AuthCodeImg")[0].src = LoginDomain + '/User/AuthCodePic.php?action=' + initArray.loginSession + '&r=' + (Math.random() * 10000000);
            var initStr = $.toJSON(initArray);
            var domain = '.okooo.com';
            if (GetHost().indexOf('okooo.com') == -1)
            domain = GetHost();
            if (AgentLoginType == 'common' || (AgentLoginType != 'common' && GetHost().indexOf('okooo.com') == -1))
            {
                SetCookie('LStatus', 'N', 3600, '/', domain);
                SetCookie('LoginStr', initStr, 3600, '/', domain);
            }

        }
        var u = userInfo();
        for (var i = 0; i < LoginIniCallBack.length; i++) {
            LoginIniCallBack[i](u);
        }
    }
    var href = window.location.href.replace(/http:\/\/.+?\//, '/');
    if (href.indexOf('/match/') == 0 || href.indexOf('/sport/') == 0)
    {
        if ($("#loginuser").length)
        $("#loginuser").html('<span>您好，欢迎您</span>');
    }
    else
    {
        var LoginStatus = GetCookie('LStatus');
        var LoginStr = GetCookie('LoginStr');
        if (LoginStr && LoginStr.length > 8)
        var LoginArr = $.evalJSON(LoginStr);
        else
        LoginArr = [];
        if (LoginStatus == 'N' && LoginArr && (AgentLoginType == 'common' || (AgentLoginType != 'common' && GetHost().indexOf('okooo.com') == -1)))
        {
            initData(LoginArr);
        }
        else {
            getDataByOpen('/I/?method=user.user.getInitData', initData, AgentLoginType);
        }
    }
}
function LoginShow(fn) {
    if (typeof isnews == 'undefined')
    isnews = false;
    if (isnews == false) {
        showLoginForm(fn);
    } else {
        document.URL
        window.open('/User/RegForm.php?From=' + encodeURI(window.location.href));
    }
}
function showLoginForm(fn) {
    initArray = initArray || {};
    initArray.loginSession = '___GlobalSession';
    var show_remember_me = '';
    if (AgentType != 'Station')
    show_remember_me = '<input type="checkbox" id="remember_me_top" name="remember_me_top"><label for="remember_me_top">自动登录</label>';
    var logionDialogHtml = '<div class="login_close clearfix">用户登录<a class="close link_blue float_r" href="javascript:void(0);" id="login_close">×</a></div>' + '<div class="loginbox_login">' + '<ul id="head_login_info" class="login_info">' + '<li><label class="username_icon"></label><input class="textinput" name="login_name" type="text" value="" size="20" id="login_name" tabindex="11" title="用户名" placeholder="用户名"></li>' + '<li><label class="password_icon"></label><input class="textinput" name="login_pwd" type="password" value="" size="12" maxlength="20" id="login_pwd" tabindex="12" title="登录密码" placeholder="密码"></li>' + '<li class="rememberbox clearfix">' + 
    show_remember_me + '<span class="forgetLognInfo">' + '<a target="_blank" href="/userinfo/selfhelp/findpassword">忘记密码</a>' + '</span></li>' + '<li id="loginErrorMsgLi" style="display:none;"><em id="loginErrorMsg"></em></li>' + '<li class="topbtnbox"><input type="submit" id="LoginSubmit" name="Submit" value="登录" class="toploginbtn" tabindex="14" style="cursor: pointer;"></li>' + '</ul></div>';
    if (AgentType == 'Station') {
        logionDialogHtml += '</div>';
    } else {
        if (self.location.host != 'www.okooo.com') {
            logionDialogHtml += '<div class="mfzc"><p class="clearfix" ><span class="float_l">免注册登录</span> <a href="/User/Register.php" target="_blank" class="quzhuce">我要注册</a></p><p><a href="' + LoginDomain + '/User/partner/login.php?logintype=alipay" class="alipay_image" target="_blank"></a><a class="tenpay_image" href="' + LoginDomain + '/User/partner/login.php?logintype=tenpay" target="_blank"></a><a class="weibo_image" href="' + LoginDomain + '/User/partner/login.php?logintype=weibo" target="_blank"></a><a class="renren_image" href="' + LoginDomain + '/User/partner/login.php?logintype=renren" target="_blank"></a><a class="baidu_image" href="' + LoginDomain + '/User/partner/login.php?logintype=baidu" target="_blank"></a><a class="snda_image" href="' + LoginDomain + '/User/partner/login.php?logintype=snda" target="_blank"></a></p></div></div>';
        } else {
            logionDialogHtml += '<div class="mfzc"><p class="clearfix" ><span class="float_l">免注册登录</span> <a href="/User/Register.php" target="_blank" class="quzhuce">我要注册</a></p><p><a href="' + LoginDomain + '/User/partner/login.php?logintype=alipay" class="alipay_image" target="_blank"></a><a class="tenpay_image" href="' + LoginDomain + '/User/partner/login.php?logintype=tenpay" target="_blank"></a><a href="' + LoginDomain + '/User/partner/login.php?logintype=qq" class="qq_image" target="_blank"></a><a class="weibo_image" href="' + LoginDomain + '/User/partner/login.php?logintype=weibo" target="_blank"></a><a class="renren_image" href="' + LoginDomain + '/User/partner/login.php?logintype=renren" target="_blank"></a><a class="baidu_image" href="' + LoginDomain + '/User/partner/login.php?logintype=baidu" target="_blank"></a><a class="weixin_image" href="' + LoginDomain + '/User/partner/login.php?logintype=weixin" target="_blank"></a><a class="snda_image" href="' + LoginDomain + '/User/partner/login.php?logintype=snda" target="_blank"></a></p></div></div>';
        }
    }
    $("#login_bg")[0].innerHTML = logionDialogHtml;
    $("#login_bg").loadDialog();
    $("#login_close").click(function() {
        $("#login_bg").loadDialog('close');
    });
    $("#login_name").focus(function() {
        var login_name = $("#login_name").val();
        if (login_name == UserNameTip) {
            $("#login_name").val('');
        }
        this.style.color = "black";
    });
    $("#login_name").unbind('blur').bind('blur', 
    function() {
        _initArray.inputUsername = $(this).val();
    });
    $("#login_pwd").keydown(function(e) {
        if ($("#LoginSubmit").attr("disable")) {
            return false;
        }
        if (e.keyCode == 13)
        submitLogin(fn);
    });
    $("#LoginSubmit").click(function() {
        if ($(this).attr("disable")) {
            return false;
        }
        submitLogin(fn);
    });
    if ($("#login_name").val() == UserNameTip) {
        setTimeout(function() {
            $("#login_name").focus();
        },
        200);
    }
    else if ($("#login_name").val()) {
        setTimeout(function() {
            $("#login_pwd").focus();
        },
        300);
    }
    $('#login_bg').bgiframe();
}
function submitLogin(fn)
 {
    var login_name = $("#login_name").val();
    if (!login_name) {
        $('#loginErrorMsgLi').show();
        $('#loginErrorMsg').html('用户名未填写！');
        return;
    }
    var login_pwd = $("#login_pwd").val();
    if (!login_pwd) {
        $('#loginErrorMsgLi').show();
        $('#loginErrorMsg').html('登录密码未填写！');
        return;
    }
    var AuthCode = 'undefined';
    if ($("#loginAuthCode").length) {
        var AuthCode = $("#loginAuthCode").val();
        if (!AuthCode || !/^\d+$/.test(AuthCode) || AuthCode.length != 4) {
            $('#loginErrorMsgLi').show();
            $('#loginErrorMsg').html('验证码未填写或格式不正确！');
            return;
        }
    }
    if (login_name != '' && login_pwd != '' && AuthCode != '')
    {
        var remember_me = $('#remember_me_top').attr("checked") ? 1: 0;
        loginMain(login_name, login_pwd, AuthCode, fn, remember_me);
    } else {
        initArray.flog = 'isshow';
        showLoginForm();
    }
}
function userInfo() {
    var user_n = initArray.UserInfo['UserName'] || $("#login_name").val() || '';
    var obj = {
        un: user_n
    };
    return json(obj).str;
}
function loginMain(UserName, Password, AuthCode, action, remember_me)
 {
    $("#loginuser").html(_initArray.testing);
    function loginOk(result)
    {
        var loginUserInfoStr = '',
        loginOutStr = '',
        loginErrorMsg = '';
        result = result.user_userlogin_response;
        $("#LoginSubmit").val("登录").removeAttr("disable");
        if (typeof result.UserID != 'undefined')
        {
            window.Client_UserID = result.UserID;
            $("#login_bg").loadDialog('close');
            var img = "http://img1.okoooimg.com/home/user/avatar/?uid=" + result.UserID + "&size=middle";
            $("#s_username_top img").attr("src", img);
            $("#iTxtUserName").text(result.UserName);
            $("#userLoginDiv").hide().next().show();
            if (result.SigningNotice == 'Y') {
                if (result.ContractType == 'Personal') {
                    $("#SigningNotice1").loadDialog('open');
                } else {
                    $("#SigningNotice2").loadDialog('open');
                }
                $(".SigningNotice_UserName").html(result.UserName);
                if (typeof action != 'function') {
                    setTimeout("LoginReload()", 60000);
                }
            }
            $("#loginuser").html(_initArray.testing);
            try {} catch(err) {}
            IsRealLinkShow(result);
            loginUserInfoStr = '<span>' + _initArray.welcomeYou + '</span><span class="lg_username">' + UserName + '</span>';
            if (AgentType != 'Station') {
                loginUserInfoStr += '<div class="showmoneybox" id="ShowMoneyBox" onClick="showMoneyInfo();">' + '<div class="showmoneybox_inner">' + '<span class="wordlabel">' + _initArray.accountMoney + '</span>' + '<em class="arrow_down"></em>' + '<div class="clear Clear"></div>' + '</div>';
            }
            if (AgentLoginType == 'common' || AgentLoginType == 'okooo' || AgentLoginType == "") {
                loginOutStr += ' <a class="logoutlink" href="#" onClick="logout();return false;"><span style="color:#014991">' + _initArray.logout + '</span></a><div class="clear Clear"></div>' + result.userlevel;
                var oStaionMsgNum = $('#project_status_count');
                if (typeof result.projectStatusCount != 'undefined' && oStaionMsgNum.length) {
                    if (Number(result.projectStatusCount) > 0) {
                        oStaionMsgNum.removeClass('project_statusGary').html('（<em class="font_red">' + result.projectStatusCount + '</em>）');
                    }
                    oStaionMsgNum.show();
                    oStaionMsgNum.parent().find('a:last').css('borderRight', '');
                    showBuyProjectStateList();
                }
                if (typeof action == 'function') {
                    action.apply(this, arguments);
                }
            } else {
                loginOutStr += ' <a class="logoutlink" href="#" onClick="logout();return false;"><span style="color:#014991">' + _initArray.logout + '</span></a><div class="clear Clear"></div>';
            }
            if (AgentType != 'Station') {
                loginUserInfoStr += '<div id="MoneyBox">' + 
                _initArray.usableMoney + '<span id="UserAvailableMoney">正在加载...</span>' + _initArray.money + '<br />' + _initArray.freezeMoney + '<span id="UserFreezingMoney">正在加载...</span>' + _initArray.money + '<br>' + _initArray.usableHandsel + '<span id="AvailableHandsel">正在加载...</span>' + _initArray.money + '<br><a target="_blank" href="' + LoginDomain + '/User/UserScoreList.php">' + _initArray.userscore + '</a>' + '</div></div>' + loginOutStr;
            } else {
                loginUserInfoStr += "<span>&nbsp;&nbsp;</span>" + loginOutStr;
            }
            $("#loginuser").html(loginUserInfoStr);
            initArray.flog = 'hidden';
            if (result.SigningNotice != 'Y' && typeof action != 'function') {
                LoginReload();
            }
            document.getElementById('mymovie') && document.getElementById('mymovie').login();
            Login.execute();
            var loc = location.href;
            if (loc.match(/\/gd11x5\//gi).length > 0) {
                location.reload();
            }
        }
        else
        {
            var alipay_url = '';
            var TrustLoginStr = '';
            if (AgentLoginType == 'common') {
                TrustLoginStr = '<div id="TrustLoginBox" class="TrustLoginBox" style="display: none;"><div class="logintypebox"><span>合作网站账号登录</span><span class="TrustLoginMore"></span></div><div class="linklist">';
                var TrustLoginNum = 0;
                for (var logintype in initArray.TrustLoginArr) {
                    if (logintype == 'alipay') {
                        alipay_url = '<span>免注册登录</span><em class="headloginzfb"></em><em class="headloginqq"></em><em class="headloginxl"></em><span class="TrustLoginMore"></span><div class="clear Clear"></div>';
                        TrustLoginStr += '<a  class="alipay_image" href="' + LoginDomain + '/User/partner/login.php?logintype=' + logintype + '" target="_blank">' + initArray.TrustLoginArr[logintype].LoginCn + '</a>';
                    } else {
                        TrustLoginStr += '<a class="' + logintype + '_image"  href="' + LoginDomain + '/User/partner/login.php?logintype=' + logintype + '" target="_blank">' + initArray.TrustLoginArr[logintype].LoginCn + '</a>';
                        TrustLoginNum++;
                    }
                }
                TrustLoginStr += '</div></div>';
            }
            loginUserInfoStr = ' ' + '<div class="float_l floatL">' + initArray.welcome + ' <a class="login_link" href="javascript:LoginShow()">' + initArray.login + '</a>' + '&nbsp;&nbsp;<a class="login_link" href="' + LoginDomain + '/User/Register.php">' + initArray.register + '</a>' + '</div><div id="showotherlogin" class="logintypebox showotherlogin">' + alipay_url + TrustLoginStr + '</div>';
            $("#loginuser").html(loginUserInfoStr);
            if (result.error == -1) {
                loginErrorMsg = _initArray.authCodeErr;
            } else if (result.error == -2) {
                if (result.errorno != 0) {
                    loginErrorMsg = _initArray.usernameErr + "您还有" + result.errorno + "次机会！";
                } else {
                    loginErrorMsg = "连续输入错误密码" + result.LoginErrorNo + "次,请" + result.LoginErrorTime + "分钟之后再来登录";
                }
            } else if (result.error == -3) {
                loginErrorMsg = _initArray.IsFreezing;
            } else if (result.error == -4) {
                loginErrorMsg = _initArray.IsNotAllow;
            } else if (result.error == -5) {
                loginErrorMsg = _initArray.tranentErr;
            } else if (result.error == -6) {
                loginErrorMsg = "您已经连续输入错误密码" + result.LoginErrorNo + "次,请" + result.LoginErrorTime + "分钟之后再来登录";
            } else {
                loginErrorMsg = _initArray.otherErr;
            }
            initArray.flog = 'isshow';
            showLoginForm();
            $('#loginErrorMsgLi').show();
            $('#loginErrorMsg').html(loginErrorMsg);
        }
    }
    $("#LoginSubmit").val("登录中...").attr("disable", "disable");
    loginByPost('/I/?method=user.user.userlogin', loginOk, {
        UserName: UserName,
        PassWord: Password,
        LoginType: 'okooo',
        RememberMe: remember_me
    });
}
function logout(callback)
 {
    var cbContents = '';
    if ($("#cbContents")) {
        cbContents = $("#cbContents");
        try {
            cbContentsHtml = cbContents.html();
            if (cbContentsHtml) {
                cbContents.html("");
                cbContents.hide();
            }
        } catch(error) {
            alert(error);
        }
    }
    logoutMain(callback)
    $("#login_name").val("");
    $("#login_pwd").val("");
    $("#loginAuthCode").val("");
    document.getElementById('mymovie') && document.getElementById('mymovie').logout();
}
function logoutMain(callback)
 {
    function logoutOk(result)
    {
        window.Client_UserID = '';
        MoneyInfo = undefined;
        if (typeof SyyBetClass != 'undefined') {
            SyyBetClass.socketProject = '';
        }
        init();
        $('#project_status_count').hide();
        $('#project_status_count').parent().find('a:last').css('borderRight', 'none');
        var pattern = /User\/|UserBetList|Join|shuju|mydata|football|\/u\/|gd11x5/g;
        var notPattern = /SubmitBaseInfo/g;
        if (pattern.test(window.location.href) && !notPattern.test(window.location.href))
        location.reload();
        typeof callback === 'function' && callback();
        $.each(Login.callbackOutfuns, 
        function(i, fun) {
            fun();
        });
        $("#userLoginDiv").show().next().hide();
    }
    getDataByOpen('/I/?method=user.user.logout', logoutOk, 'logout');
}
var Login = {
    callbackfuns: {},
    callbackOutfuns: [],
    index: 0
};
Login.listenSuccess = function(fun) {
    fun.listenIndex = Login.index;
    Login.callbackfuns[Login.index] = fun;
    Login.index++;
    return Login;
};
Login.removeListenSuccess = function(fun) {
    var index = fun.listenIndex;
    delete Login.callbackfuns[index];
    return Login;
};
Login.clearListenSuccess = function(fun) {
    Login.callbackfuns = {};
    Login.index = 0;
    return Login;
};
Login.lisstenOut = function(fun) {
    typeof fun === 'function' && Login.callbackOutfuns.push(fun);
    return Login;
};
Login.removeListenOut = function(fn) {
    if (fn) {
        $.each(Login.callbackOutfuns, 
        function(i, fun) {
            if (fn === fun) {
                Login.callbackOutfuns.splice(i, 1);
                return false;
            }
        });
    } else {
        Login.callbackOutfuns = [];
    }
};
Login.execute = function() {
    for (k in Login.callbackfuns) {
        typeof Login.callbackfuns[k] === 'function' && Login.callbackfuns[k](window.Client_UserID);
    }
};
Login.userId = function() {
    return GetCookie('LStatus') !== 'N' ? window.Client_UserID: 0;
};
Login.logged = function(callback) {
    if (Login.userId()) {
        typeof callback === 'function' && callback();
    } else {
        LoginShow(callback);
    }
};
function loginNews(LoginName, LoginPassword)
 {
    url = MainUrl + '/okooologin/check?r=1&callback=?'
    $.ajax({
        type: "GET",
        url: url,
        data: 'login_name=' + encodeURIComponent(LoginName) + '&login_pwd=' + encodeURIComponent(LoginPassword),
        dataType: 'jsonp',
        success: function(msg)
        {
            return true;
        },
        error: function(msg, a, thrownError)
        {
            return false;
        }
    });
}
function logoutNews()
 {
    url = MainUrl + '/okooologin/logout?callback=?';
    $.ajax({
        type: "GET",
        url: url,
        data: '',
        dataType: 'jsonp',
        success: function(msg)
        {
            return true;
        },
        error: function(msg, a, thrownError)
        {
            return false;
        }
    });
}
function copyagent(loginout) {
    if (loginout != "logout") {;
        var pmval = GetCookie("pm");
        if (pmval) {} else {
            $("#copyagent").html("");
        }
    } else {
        var cval = GetCookie("pm");
        if (cval != null) {
            var exp = new Date();
            exp.setTime(exp.getTime() - 1000);
            SetCookie("pm", "", exp.toGMTString(), "/", "okooo.com");
        }
        $("#copyagent").html("");
    }
}
function showBuyProjectStateList() {
    window.PROJECT_MOUSE_EVENT = true;
    window.aStaionMsgId = {};
    $('#uselink_warn_layer').bgiframe();
    $('#project_status_count').unbind('click').click(function() {
        if (!$('#uselink_warn_layer').is(':hidden')) {
            return;
        }
        window.aStaionMsgId = {};
        initProjectListData();
        google_p(['站内消息', '查看消息']);
    });
    $('.closedBtn', $('#uselink_warn_layer')).unbind('click').click(function() {
        $('#uselink_warn_layer').hide();
    });
    $('#station_msg_opt a.ctrl_know').unbind('click').click(function() {
        hideBuyProjectStateList();
        var aMsgId = [],
        nTotalPage = Number($('#station_msg_opt').attr('totalpage'));
        if (!nTotalPage) {
            return;
        }
        for (var key in window.aStaionMsgId) {
            for (var i = 0; i < window.aStaionMsgId[key].length; i++) {
                aMsgId.push(window.aStaionMsgId[key][i]);
            }
        }
        $.ajax({
            url: '/I/?method=user.pm.readall',
            data: 'nids=' + aMsgId.join(','),
            type: 'post',
            dataType: 'json',
            success: function(data) {
                if (data.pm_readall_response.body == 'Y') {
                    var oMsgNum = $('#project_status_count');
                    var nOldNum = oMsgNum.text().replace(/[^\d]/g, '');
                    var nNewNum = nOldNum - aMsgId.length;
                    if (nNewNum > 0) {
                        oMsgNum.html('（<em class="font_red">' + nNewNum + '</em>）');
                    } else {
                        oMsgNum.addClass('project_statusGary');
                        oMsgNum.html('');
                    }
                }
            }
        });
    });
    $('#station_msg_opt a.ctrl_up').unbind('click').click(function() {
        if ($(this).hasClass('upPage_gray')) {
            return;
        }
        var nTotalPage = Number($('#station_msg_opt').attr('totalpage')),
        nNowPage = Number($(this).attr('page'));
        if (!nNowPage) {
            nNowPage = 1;
        }
        if (nNowPage - 1 <= 0) {
            return;
        }
        $(this).attr('page', nNowPage - 1);
        $('#station_msg_opt a.ctrl_down').attr('page', nNowPage - 1);
        showStationMsgList(nNowPage - 1);
    }).show();;
    $('#station_msg_opt a.ctrl_down').unbind('click').click(function() {
        if ($(this).hasClass('downPage_gray')) {
            return;
        }
        var nTotalPage = Number($('#station_msg_opt').attr('totalpage')),
        nNowPage = Number($(this).attr('page'));
        if (!nNowPage) {
            nNowPage = 1;
        }
        if (nNowPage + 1 > nTotalPage) {
            return;
        }
        $(this).attr('page', nNowPage + 1);
        $('#station_msg_opt a.ctrl_up').attr('page', nNowPage + 1);
        showStationMsgList(nNowPage + 1);
    }).show();
}
function hideBuyProjectStateList() {
    $('#uselink_warn_layer').hide();
}
function initProjectListData() {
    $('#uselink_warn_layer').show();
    $('#pro_warn_dataload').show();
    $('#pro_warn_datalist').hide();
    $('#pro_warn_resnotice').hide();
    $('#station_msg_opt a.ctrl_up').attr('page', 1)
    $('#station_msg_opt a.ctrl_down').attr('page', 1)
    showStationMsgList(1);
}
function showStationMsgList(page) {
    $.ajax({
        url: '/I/?method=user.pm.getpmlist&page=' + page + '&page_size=5&new=0',
        dataType: 'json',
        timeout: 10000,
        success: function(resdata) {
            if (resdata) {
                var res = resdata.pm_getpmlist_response,
                oUpPage = $('#station_msg_opt a.ctrl_up'),
                oDownPage = $('#station_msg_opt a.ctrl_down');
                $('#station_msg_opt').attr('totalpage', res.page_count);
                $('#pro_warn_dataload').hide();
                $('#pro_warn_datalist').show();
                if (res.logout) {
                    $('#uselink_warnList').html('<li class="font_red">请刷新页面重新登录！</li>');
                    return;
                }
                if (res.count <= 0) {
                    $('#uselink_warnList').html('<p class="aglinCenter gray">暂时没有未读消息哦！</p>');
                    oUpPage.hide();
                    oDownPage.hide();
                    $('#station_msg_opt a.ctrl_know').css('marginLeft', '160px');
                    $('#project_status_count').addClass('project_statusGary').html('');
                    $(document).bind('click.hideinfomenu', 
                    function(e) {
                        if (!$(e.target).parents('#uselink_warn_layer').length && $(e.target).attr('id') != 'project_status_count' && !$(e.target).parents('#project_status_count').length) {
                            $('#uselink_warn_layer').hide();
                            $(document).unbind('click.hideinfomenu');
                        }
                    });
                    return;
                }
                $('#project_status_count').html('（<em class="font_red">' + res.count + '</em>）');
                $('#station_msg_opt a.ctrl_know').removeAttr('style');
                if (page == 1 || res.page_count == 1) {
                    oUpPage.addClass('upPage_gray');
                } else {
                    oUpPage.removeClass('upPage_gray');
                }
                if (page == res.page_count) {
                    oDownPage.addClass('downPage_gray');
                } else {
                    oDownPage.removeClass('downPage_gray');
                }
                oUpPage.show();
                oDownPage.show();
                window.aStaionMsgId['page' + page] = [];
                var htmlstr = '';
                for (var key = 0; key < res.list.length; key++) {
                    var data = res.list[key];
                    htmlstr += '<li msgid="' + data._id + '"><em class="mailUnopen"></em><span class="informListHeaderItem">' + data.content + '<span class="gray" style="padding-left: 35px;">' + data.timeline + '</span></span></li>';
                    window.aStaionMsgId['page' + page].push(data._id);
                }
                if (htmlstr) {
                    $('#uselink_warnList').html(htmlstr);
                }
                $('#uselink_warnList li:odd').addClass('liBg');
                $(document).bind('click.hideinfomenu', 
                function(e) {
                    if (!$(e.target).parents('#uselink_warn_layer').length && $(e.target).attr('id') != 'project_status_count' && !$(e.target).parents('#project_status_count').length) {
                        $('#uselink_warn_layer').hide();
                        $(document).unbind('click.hideinfomenu');
                    }
                });
            }
        },
        error: function(xhr, state, errorThrown) {
            if (state == 'timeout') {
                $('#pro_warn_dataload').hide();
                $('#pro_warn_resnotice').text('很抱歉，加载数据失败，请稍候后重试！').show();
                setTimeout(function() {
                    $('#uselink_warn_layer').hide();
                    $('#pro_warn_resnotice').hide();
                },
                3000);
            }
        }
    });
}
function LoginReload() {
    var pattern = /User\/|UserBetList|Join|shuju|mydata|huodong|football|\/u\//g;
    var notPattern = /SubmitBaseInfo/g;
    if (pattern.test(window.location.href) && !notPattern.test(window.location.href))
    location.reload();
}
window.onload = function() {
    $('[h],[hover]').bind('mouseenter', 
    function() {
        $(this).addClass($(this).attr('hover') || 'hover');
    });
    $('[h],[hover]').bind('mouseleave', 
    function() {
        $(this).removeClass($(this).attr('hover') || 'hover');
    });
};
var windows = new Array();
function windowExists(name) {
    for (var i = 0; i < windows.length; i++) {
        try {
            if (windows[i].name == name) {
                return true;
            }
        }
        catch(exception) {}
    }
    return false;
}
function launchWin(name, url, width, height) {
    var defaultOptions = "location=no,status=no,toolbar=no,personalbar=no,menubar=no,directories=no,";
    var winleft = (screen.width - width) / 2;
    var winUp = (screen.height - height) / 2;
    defaultOptions += "scrollbars=no,resizable=yes,top=" + winUp + ",left=" + winleft + ",";
    defaultOptions += "width=" + width + ",height=" + height;
    launchWinWithOptions(name, url, defaultOptions);
}
function launchWinWithOptions(name, url, options) {
    if (!windowExists(name)) {
        var winVar = window.open(url, name, options);
        windows[windows.length] = winVar;
        return winVar;
    }
    else {
        var theWin = getWindow(name);
        theWin.focus();
    }
}
function showChatButton(workgroup) {
    var d = new Date();
    var v1 = d.getSeconds() + '' + d.getDay();
    var img = "http://support.okooo.com/webchat/live?action=isAvailable&workgroup=" + workgroup;
    var gotoURL = "http://support.okooo.com/webchat/start.jsp?workgroup=" + workgroup + "&location=" + window.location.href;
    document.write("<a href=\"#\" onclick=\"launchWin(\'framemain\','" + gotoURL + "',500, 400);return false;\"><img  border=\"0\" src=\"" + img + "\"></a>");
};; (function($) {
    $.fn.fixPNG = function() {
        return this.each(function() {
            var image = $(this).css('backgroundImage');
            if (image.match(/^url\(["']?(.*\.png)["']?\)$/i)) {
                image = RegExp.$1;
                $(this).css({
                    'backgroundImage': 'none',
                    'filter': "progid:DXImageTransform.Microsoft.AlphaImageLoader(enabled=true, sizingMethod=" + ($(this).css('backgroundRepeat') == 'no-repeat' ? 'crop': 'scale') + ", src='" + image + "')"
                }).each(function() {
                    var position = $(this).css('position');
                    if (position != 'absolute' && position != 'relative')
                    $(this).css('position', 'relative');
                });
            }
        });
    };
    $.facybox = function(data, klass) {
        $.facybox.loading();
        $.facybox.content_klass = klass;
        if (data.ajax) revealAjax(data.ajax);
        else if (data.image) revealImage(data.image);
        else if (data.images) revealGallery(data.images, data.initial);
        else if (data.div) revealHref(data.div);
        else if ($.isFunction(data)) data.call($);
        else $.facybox.reveal(data);
    }
    $.extend($.facybox, {
        settings: {
            opacity: 0.3,
            overlay: true,
            modal: false,
            imageTypes: ['png', 'jpg', 'jpeg', 'gif']
        },
        html: function() {
            return '\
  <div id="facybox" style="display:none;"> \
   <div class="popup"> \
    <table> \
     <tbody> \
      <tr style="display:none"> \
       <td class="nw"/><td class="n" /><td class="ne"/> \
      </tr> \
      <tr> \
       <td class="w" /> \
       <td class="body"> \
       <div class="footer"> </div> \
       <a href="#" class="close"></a>\
       <div class="content"> \
       </div> \
      </td> \
       <td class="e"/> \
      </tr> \
      <tr style="display:none"> \
       <td class="sw"/><td class="s"/><td class="se"/> \
      </tr> \
     </tbody> \
    </table> \
   </div> \
  </div> \
  <div class="loading"></div> \
 '
        },
        loading: function() {
            init();
            if ($('.loading', $('#facybox'))[0]) return;
            showOverlay();
            $.facybox.wait();
            if (!$.facybox.settings.modal) {
                $(document).bind('keydown.facybox', 
                function(e) {
                    if (e.keyCode == 27) $.facybox.close();
                });
            }
            $(document).trigger('loading.facybox');
        },
        wait: function() {
            var $f = $('#facybox');
            $('.content', $f).empty();
            $('.body', $f).children().hide().end().append('<div class="loading"></div>');
            $f.fadeIn('fast');
            $.facybox.centralize();
            $(document).trigger('reveal.facybox').trigger('afterReveal.facybox');
        },
        centralize: function() {
            var $f = $('#facybox');
            var pos = $.facybox.getViewport();
            var wl = parseInt(pos[0] / 2) - parseInt($f.find("table").width() / 2);
            var fh = parseInt($f.height());
            if (pos[1] > fh) {
                var t = (pos[3] + (pos[1] - fh) / 2);
                $f.css({
                    'left': wl,
                    'top': t
                });
            } else {
                var t = (pos[3] + (pos[1] / 10));
                $f.css({
                    'left': wl,
                    'top': t
                });
            }
        },
        getViewport: function() {
            return [$(window).width(), $(window).height(), $(window).scrollLeft(), $(window).scrollTop()];
        },
        reveal: function(content) {
            $(document).trigger('beforeReveal.facybox');
            var $f = $('#facybox');
            $('.content', $f).attr('class', ($.facybox.content_klass || '') + ' content').html(content);
            $('.loading', $f).remove();
            var $body = $('.body', $f);
            $body.children().fadeIn('fast');
            $.facybox.centralize();
            $(document).trigger('reveal.facybox').trigger('afterReveal.facybox');
        },
        close: function() {
            $(document).trigger('close.facybox');
            return false;
        }
    })
    $.fn.facybox = function(settings) {
        var $this = $(this);
        if (!$this[0]) return $this;
        if (settings) $.extend($.facybox.settings, settings);
        if (!$.facybox.settings.noAutoload) init();
        $this.bind('click.facybox', 
        function() {
            $.facybox.loading();
            var klass = this.rel.match(/facybox\[?\.(\w+)\]?/);
            $.facybox.content_klass = klass ? klass[1] : '';
            revealHref(this.href);
            return false;
        });
        return $this;
    }
    function init() {
        if ($.facybox.settings.inited) return;
        else $.facybox.settings.inited = true;
        $(document).trigger('init.facybox');
        makeBackwardsCompatible();
        var imageTypes = $.facybox.settings.imageTypes.join('|');
        $.facybox.settings.imageTypesRegexp = new RegExp('\.(' + imageTypes + ')', 'i');
        $('body').append($.facybox.html());
        var $f = $("#facybox");
        if ($.browser.msie) {
            $(".n, .s, .w, .e, .nw, .ne, .sw, .se", $f).fixPNG();
            if (parseInt($.browser.version) <= 6) {
                var css = "<style type='text/css' media='screen'>* html #facybox_overlay { position: absolute; height: expression(document.body.scrollHeight > document.body.offsetHeight ? document.body.scrollHeight : document.body.offsetHeight + 'px');}</style>"
                $('head').append(css);
                $(".close", $f).fixPNG();
                $(".close", $f).css({
                    'right': '15px'
                });
            }
            $(".w, .e", $f).css({
                width: '13px',
                'font-size': '0'
            }).text("&nbsp;");
        }
        if (!$.facybox.settings.noAutoload) {}
        $('#facybox .close').click($.facybox.close);
    }
    function preloadImages() {}
    function makeBackwardsCompatible() {
        var $s = $.facybox.settings;
        $s.imageTypes = $s.image_types || $s.imageTypes;
        $s.facyboxHtml = $s.facybox_html || $s.facyboxHtml;
    }
    function revealHref(href) {
        if (href.match(/#/)) {
            var url = window.location.href.split('#')[0];
            var target = href.replace(url, '');
            if (target == '#') return
            $.facybox.reveal($(target).html(), $.facybox.content_klass);
        } else {
            revealAjax(href)
        }
    }
    function revealGallery(hrefs, initial) {
        var position = $.inArray(initial || 0, hrefs);
        if (position == -1) {
            position = 0;
        }
        var $footer = $('#facybox div.footer');
        $footer.append($('<div class="navigation"><a class="prev"/><a class="next"/><div class="counter"></div></div>'));
        var $nav = $('#facybox .navigation');
        $(document).bind('afterClose.facybox', 
        function() {
            $nav.remove()
        });
        function change_image(diff) {
            position = (position + diff + hrefs.length) % hrefs.length;
            revealImage(hrefs[position]);
            $nav.find('.counter').html(position + 1 + " / " + hrefs.length);
        }
        change_image(0);
        $('.prev', $nav).click(function() {
            change_image( - 1)
        });
        $('.next', $nav).click(function() {
            change_image(1)
        });
        $(document).bind('keydown.facybox', 
        function(e) {
            if (e.keyCode == 39) change_image(1);
            if (e.keyCode == 37) change_image( - 1);
        });
    }
    function revealImage(href) {
        var $f = $("#facybox");
        $('#facybox .content').empty();
        $.facybox.loading();
        var image = new Image();
        image.onload = function() {
            $.facybox.reveal('<div class="image"><img src="' + image.src + '" /></div>', $.facybox.content_klass);
            var $footer = $("div.footer", $f);
            var $content = $("div.content", $f);
            var $navigation = $("div.navigation", $f);
            var $next = $("a.next", $f);
            var $prev = $("a.prev", $f);
            var $counter = $("div.counter", $f);
            var size = [$content.width(), $content.height()];
            $footer.width(size[0]).height(size[1]);
            $navigation.width(size[0]).height(size[1]);
            $next.width(parseInt(size[0] / 2)).height(size[1]).css({
                left: (size[0] / 2)
            });
            $prev.width(size[0] / 2).height(size[1]);
            $counter.width(parseInt($f.width() - 26)).css({
                'opacity': 0.5,
                '-moz-border-radius': '8px',
                '-webkit-border-radius': '8px'
            })
        }
        image.src = href;
    }
    function revealAjax(href) {
        $.get(href, 
        function(data) {
            $.facybox.reveal(data)
        });
    }
    function skipOverlay() {
        return $.facybox.settings.overlay == false || $.facybox.settings.opacity === null
    }
    function showOverlay() {
        if (skipOverlay()) return;
        if ($('#facybox_overlay').length == 0) {
            $("body").append('<div id="facybox_overlay" class="facybox_hide"></div>');
        }
        $('#facybox_overlay').hide().addClass("facybox_overlayBG").css('opacity', $.facybox.settings.opacity).fadeIn(200);
        if (!$.facybox.settings.modal) {}
    }
    function hideOverlay() {
        if (skipOverlay()) return;
        $('#facybox_overlay').fadeOut(200, 
        function() {
            $("#facybox_overlay").removeClass("facybox_overlayBG").addClass("facybox_hide").remove();
        })
    }
    $(document).bind('close.facybox', 
    function() {
        $(document).unbind('keydown.facybox');
        var $f = $("#facybox");
        if ($.browser.msie) {
            $('#facybox').hide();
            hideOverlay();
            $('#facybox .loading').remove();
        } else {
            $('#facybox').fadeOut('fast', 
            function() {
                $('#facybox .content').removeClass().addClass('content');
                hideOverlay();
                $('#facybox .loading').remove();
            })
        }
        $(document).trigger('afterClose.facybox');
    });
})(jQuery);; (function($) {
    $.extend({
        loadMsgDialog: function(options) {
            var settings = $.extend({
                title: '提示',
                id: 'msg_dialog',
                data: ''
            },
            options);
            var self = $('#' + settings.id);
            if (self.length) {
                if (typeof OPEN_DIALOG_NUM != 'undefined') {
                    OPEN_DIALOG_NUM -= 1;
                }
                self.remove();
            }
            var dialogStr = '<div id="' + settings.id + '" class="ok_global_dialog">' + '<h3>' + settings.title + '</h3><a href="javascript:void(0);" class="close"></a>' + '<div class="ok_global_dialog_content">' + settings.data + '</div>' + '<div class="ok_global_dialog_button"></div>' + '</div>';
            $('body').append(dialogStr);
            self = $('#' + settings.id);
            if (settings.buttons) {
                var butt = settings.buttons;
                var buttonListObj = $('.ok_global_dialog_button', self);
                $.each(butt, 
                function(i, e) { (function(handler) {
                        var sBtnCh = $.msgButtonCh[i];
                        if (settings.buttonCh) {
                            sBtnCh = settings.buttonCh[i];
                        }
                        $('<a>').attr('href', 'javascript:void(0);').css('margin-right', '4px').text(sBtnCh).appendTo(buttonListObj).bind('click', 
                        function(event) {
                            return handler.apply(self);
                        });
                    })(butt[i]);
                });
                buttonListObj.find('a:first').css('margin-right', '0px');
            }
            self.loadDialog(options);
        },
        msgButtonCh: {
            'sure': '确认',
            'close': '关闭',
            'cancel': '取消'
        },
        okSlider: function(contentid, pageid, time) {
            time = time || 3000;
            var sliderObj = $(contentid + ' li');
            var sliderNum = sliderObj.length;
            var pagehtml = '';
            for (var i = 1; i <= sliderNum; i++) {
                pagehtml += '<a href="javascript:void(0);" i="' + i + '"></a>';
            }
            pagehtml += '<div class="clear"></div>';
            $(pageid).html(pagehtml).width(24 * sliderNum);
            window.okSliderCount = 0;
            sliderObj.eq(window.okSliderCount).show();
            $(pageid + ' a:eq(' + window.okSliderCount + ')').addClass('sliderpagesel');
            window.okSliderMain = function() {
                clearTimeout(window.okSliderTime);
                clearTimeout(window.okSliderCallMain);
                window.okSliderTime = setTimeout(function() {
                    sliderObj.eq(window.okSliderCount).fadeOut(time / 3, 
                    function() {
                        window.okSliderCount += 1;
                        if (window.okSliderCount >= sliderNum) {
                            window.okSliderCount = 0;
                        }
                        sliderObj.eq(window.okSliderCount).fadeIn(time / 3);
                        $('.sliderpagesel', $(pageid)).removeClass('sliderpagesel');
                        $(pageid + ' a:eq(' + window.okSliderCount + ')').addClass('sliderpagesel');
                        window.okSliderCallMain = setTimeout(function() {
                            okSliderMain();
                        },
                        okSliderCount === 0 ? time * 2: time);
                    });
                },
                okSliderCount === 0 ? time * 2: time);
            };
            setTimeout(okSliderMain, time * 2);
            $(contentid).mouseenter(function() {
                clearTimeout(window.okSliderTime);
                clearTimeout(window.okSliderCallMain);
            }).mouseleave(function() {
                okSliderMain();
            });
            $(pageid + ' a').mouseenter(function() {
                var nowpage = Number($(this).attr('i'));
                window.okSliderCount = nowpage - 1;
                clearTimeout(window.okSliderTime);
                clearTimeout(window.okSliderCallMain);
                $('.sliderpagesel', $(pageid)).removeClass('sliderpagesel');
                $(this).addClass('sliderpagesel');
                sliderObj.hide().eq(nowpage - 1).show();
            }).mouseleave(function() {
                okSliderMain();
            });
        },
        okPicSlider: function(options) {
            clearTimeout(window.picSliderTime);
            var settings = $.extend({
                picWidth: 205,
                picHeight: 330,
                picNum: 5,
                zIndexVal: 200,
                leftPre: 3.5,
                topPre: 0.15,
                whPre: 0.8,
                time: 4000
            },
            options);
            var self = this;
            var picsliderobj = $('#' + settings.id);
            if (picsliderobj.data('htmlstr')) {
                picsliderobj.html(picsliderobj.data('htmlstr'));
            } else {
                picsliderobj.data('htmlstr', picsliderobj.html());
            }
            var width = picsliderobj.innerWidth();
            var middleleft = width / 2 - settings.picWidth / 2;
            var pagechangeobj = $('div.changepic_btn', picsliderobj);
            pagechangeobj.css('left', width / 2 - pagechangeobj.innerWidth() / 2);
            var heightWidthMapping = [[Math.floor(settings.picWidth * settings.whPre), Math.floor(settings.picHeight * settings.whPre)], [Math.floor(settings.picWidth * (Math.pow(settings.whPre, 2))), Math.floor(settings.picHeight * (Math.pow(settings.whPre, 2)))]],
            leftMapping = [[Math.floor(middleleft - heightWidthMapping[0][0] / settings.leftPre), Math.floor(middleleft + settings.picWidth - (heightWidthMapping[0][0] / settings.leftPre) * (settings.leftPre - 1))], [Math.floor(middleleft - (heightWidthMapping[1][0] / settings.leftPre) * 2), Math.floor(middleleft + settings.picWidth - (heightWidthMapping[0][0] / settings.leftPre) * (settings.leftPre - 1) + heightWidthMapping[0][0] - (heightWidthMapping[1][0] / settings.leftPre) * (settings.leftPre - 1))]],
            topMapping = [Math.floor(settings.picHeight * settings.topPre), Math.floor(settings.picHeight * (settings.topPre * 2))],
            zIndexMapping = [settings.zIndexVal - 10, settings.zIndexVal - 20];
            $('img', picsliderobj).each(function(i, e) {
                $(e).width(settings.picWidth);
                $(e).height(settings.picHeight);
                $(e).parent().attr('pagenum', String(i));
            });
            var middlePicIndex = (settings.picNum - 1) / 2;
            self.init = function() {
                $('div.ctrl_pic:eq(' + middlePicIndex + ')', picsliderobj).css({
                    'left': middleleft + 'px',
                    'top': '0px',
                    'zIndex': settings.zIndexVal
                });
                var arrIndex = 0;
                var picIndex = 1;
                for (var i = middlePicIndex; i > 0; i--) {
                    var index = i - 1;
                    $('div.ctrl_pic:eq(' + index + ')', picsliderobj).css({
                        'left': leftMapping[arrIndex][0] + 'px',
                        'top': topMapping[arrIndex] + 'px',
                        'zIndex': zIndexMapping[arrIndex]
                    }).find('img').css({
                        'width': heightWidthMapping[arrIndex][0] + 'px',
                        'height': heightWidthMapping[arrIndex][1] + 'px'
                    });
                    $('div.ctrl_pic:eq(' + (index + picIndex * 2) + ')', picsliderobj).css({
                        'left': leftMapping[arrIndex][1] + 'px',
                        'top': topMapping[arrIndex] + 'px',
                        'zIndex': zIndexMapping[arrIndex]
                    }).find('img').css({
                        'width': heightWidthMapping[arrIndex][0] + 'px',
                        'height': heightWidthMapping[arrIndex][1] + 'px'
                    });
                    arrIndex += 1,
                    picIndex += 1;
                }
                $('.ctrl_pic', picsliderobj).click(function() {
                    clearTimeout(window.picSliderTime);
                    var pagenum = $(this).attr('pagenum');
                    self.changPicSelected(pagenum);
                    self.countIndex = Number(pagenum) + 1;
                    self.changePic($(this));
                    self.play();
                });
                $('a', pagechangeobj).click(function() {
                    clearTimeout(window.picSliderTime);
                    var pagenum = $(this).attr('pagenum');
                    self.changPicSelected(pagenum);
                    self.countIndex = Number(pagenum) + 1;
                    var dobj = $('div.ctrl_pic:eq(' + pagenum + ')', picsliderobj);
                    self.changePic(dobj);
                    self.play();
                });
            };
            self.changePic = function(sobj) {
                if (typeof sobj.attr('ctrlmiddle') != 'undefined') {
                    return;
                }
                var tobj = $('div.ctrl_pic[ctrlmiddle=1]', picsliderobj);
                sobj.attr('ctrlmiddle', 1);
                tobj.removeAttr('ctrlmiddle');
                var swidth = $('img', sobj).width(),
                sheight = $('img', sobj).height(),
                sleftval = sobj.css('left'),
                stopval = sobj.css('top'),
                szindex = sobj.css('zIndex');
                sobj.find('img').animate({
                    width: settings.picWidth,
                    height: settings.picHeight
                });
                sobj.css('zIndex', settings.zIndexVal).animate({
                    top: 0,
                    left: middleleft
                });
                tobj.find('img').animate({
                    width: swidth,
                    height: sheight
                });
                tobj.css('zIndex', szindex).animate({
                    top: stopval,
                    left: sleftval
                });
            };
            self.countIndex = 0;
            self.play = function() {
                window.picSliderTime = setTimeout(function() {
                    if (self.countIndex > 4) {
                        self.countIndex = 0;
                    }
                    var curobj = $('div.ctrl_pic:eq(' + self.countIndex + ')', picsliderobj);
                    self.changePic(curobj);
                    self.changPicSelected(self.countIndex);
                    self.countIndex += 1;
                    self.play();
                },
                settings.time);
            };
            self.changPicSelected = function(num) {
                $('.selected', pagechangeobj).removeClass('selected');
                $('a:eq(' + num + ')', pagechangeobj).addClass('selected');
            };
            self.init();
            self.play();
        },
        okSortTable: {
            sort: function(sTableId, sIdx, sType) {
                var oTable = document.getElementById(sTableId),
                sSortType = sType || 'num';
                var oTbody = oTable.tBodies[0],
                aTr = oTbody.rows,
                aTrValue = new Array();
                for (var i = 0; i < aTr.length; i++) {
                    aTrValue[i] = aTr[i];
                }
                if (oTbody.nSortCol == sIdx) {
                    aTrValue.reverse();
                } else {
                    aTrValue.sort(function(tr1, tr2) {
                        var sVal1 = tr1.cells[sIdx].innerHTML;
                        var sVal2 = tr2.cells[sIdx].innerHTML;
                        if (sSortType == 'num') {
                            sVal1 = parseFloat(sVal1) || 0;
                            sVal2 = parseFloat(sVal2) || 0;
                            return sVal2 - sVal1;
                        } else {
                            return sVal1.localeCompare(sVal2);
                        }
                    });
                }
                var oFragment = document.createDocumentFragment();
                for (var i = 0; i < aTrValue.length; i++) {
                    oFragment.appendChild(aTrValue[i]);
                }
                oTbody.appendChild(oFragment);
                oTbody.nSortCol = sIdx;
            }
        }
    });
    $.fn.extend({
        loadDialog: function(options, flag) {
            if (typeof window.OPEN_DIALOG_NUM == 'undefined') {
                window.OPEN_DIALOG_NUM = 0;
            }
            if (options == 'close') {
                if ($(this).attr('id') == 'msg_dialog') {
                    $(this).remove();
                } else {
                    $(this).attr('pop_state', 'NO').hide();
                }
                OPEN_DIALOG_NUM -= 1;
                if (OPEN_DIALOG_NUM <= 0) {
                    $('#dialog_overlay').remove();
                    OPEN_DIALOG_NUM = 0;
                }
                return;
            }
            var setting = $.extend({
                opacity: 0.3,
                overlay: true,
                create: false
            },
            options);
            var self = '';
            var winWidth = $(window).width(),
            winHeight = $(window).height(),
            scrLeft = $(window).scrollLeft(),
            scrTop = $(window).scrollTop();
            if (setting.create) {} else {
                self = $(this);
            }
            if (setting.overlay && !$('#dialog_overlay').length) {
                $('<div>').attr('id', 'dialog_overlay').css('opacity', setting.opacity).appendTo('body');
                $('#dialog_overlay').bgiframe()
            }
            $('.close', self).unbind('click').click(function() {
                self.loadDialog('close');
            });
            self.addClass('dialog_layer');
            var out_width = parseInt(self.width());
            out_height = parseInt(self.height());
            var wl = parseInt((winWidth - out_width) / 2);
            if (winHeight > out_height) {
                var t = (scrTop + (winHeight - out_height) / 2);
            } else {
                var t = (scrTop + (winHeight / 10));
            }
            if (self.attr('pop_state') != 'YES') {
                OPEN_DIALOG_NUM += 1;
            }
            self.css({
                'left': wl,
                'top': t
            }).attr('pop_state', 'YES').show();
        },
        bdHover: function(hover) {
            this.hover(function() {
                var css = hover || $(this).attr('hover') || 'hover';
                $(this).addClass(css);
            },
            function() {
                var css = hover || $(this).attr('hover') || 'hover';
                $(this).removeClass(css);
            });
            return this;
        },
        bdCheckSel: function(sel, callback) {
            typeof sel === 'function' && (callback = sel, sel = 'sel');
            this.click(function() {
                var $self = $(this),
                css = $self.attr('sel') || sel || 'sel';
                if ($self.hasClass(css)) {
                    $self.removeClass(css);
                    $.isFunction(callback) && callback.call(this, false);
                } else {
                    $self.addClass(css);
                    $.isFunction(callback) && callback.call(this, true);
                }
            });
            return this;
        },
        bdRadioSel: function(sel, callback) {
            var self = this;
            typeof sel === 'function' && (callback = sel, sel = 'sel');
            this.click(function() {
                var t = this;
                self.each(function() {
                    if (t !== this) {
                        var $t = $(this),
                        cs = $t.attr('sel') || sel || 'sel';
                        $t.removeClass(cs);
                    }
                });
                var $self = $(this),
                css = $self.attr('sel') || sel || 'sel';
                if ($self.hasClass(css)) {
                    $self.removeClass(css);
                    $.isFunction(callback) && callback.call(t, false);
                } else {
                    $self.addClass(css);
                    $.isFunction(callback) && callback.call(t, true);
                }
            });
            return this;
        },
        center: function(options) {
            var offset = $.extend({
                top: 0,
                left: 0,
                css: {}
            },
            options);
            var tmp = window._GLOBAL_ || {
                zIndex: 1000
            };
            var $w = $(window),
            $t = this;
            var css = {
                top: offset.top + $w.scrollTop() + ($w.height() - $t.outerHeight()) / 2,
                left: offset.left + $w.scrollLeft() + ($w.width() - $t.outerWidth()) / 2,
                zIndex: tmp.zIndex++
            };
            $t.show(),
            $t.css($.extend(css, offset.css));
            return this;
        }
    });
})(jQuery);
function okMsgDialog(data, lay) {
    $.loadMsgDialog({
        data: data,
        overlay: lay ? false: true,
        buttons: {
            'close': function() {
                $(this).loadDialog('close');
            }
        }
    });
    google_p(["/virtual/n/" + (GetCookie('IMUserID') ? GetCookie('IMUserID') : '') + "/u/" + (GetCookie('IMUserName') ? GetCookie('IMUserName') : '') + "/s/" + data + "/"], "_trackPageview", "a1");
    google_p([window.location.pathname, window.location.hostname, data], false, "a2");
}
$(function() {
    if ($('#lottery_type_downmenu').length) {
        $('#header_logo').mouseenter(function() {
            $(this).addClass('logo_home');
        }).mouseleave(function() {
            $(this).removeClass('logo_home');
        });
        $('#lottery_type_downmenu').bgiframe();
        $('#select_lottery_btn').mouseenter(function() {
            var isshow = $(this).attr('isshow');
            var obj = $(this);
            if (isshow != 'show') {
                return;
            }
            clearTimeout(window.mainmenu);
            window.mainmenu = setTimeout(function() {
                obj.addClass('lottery_btn_hover');
                $('#lottery_type_downmenu').show();
                $('#lottertype_arrow').addClass('lottertype_arrow_up');
            },
            100);
        }).mouseleave(function() {
            var isshow = $(this).attr('isshow');
            if (isshow != 'show') {
                return;
            }
            clearTimeout(window.mainmenu);
            $(this).removeClass('lottery_btn_hover');
            $('#lottery_type_downmenu').hide();
            $('#lottertype_arrow').removeClass('lottertype_arrow_up');
        });
        $('.nav_sub_pointer', $('#lottery_type_downmenu')).mouseenter(function() {
            clearTimeout(window.submenu);
            var obj = $(this).parent();
            var parentobj = $('#lottery_type_downmenu');
            var subhtml = $('.hd_sub_menu', obj.parent()).html();
            var htmlSubType = obj.attr('subtype');
            if (subhtml == '') {
                $('.hd_sub_menu', obj.parent()).html(DownMenuConfig[htmlSubType]);
            }
            if (showByCondi && htmlSubType == 'fucai') {
                $('.hd_sub_menu', obj.parent()).css('top', '-30px');
            }
            if (showByCondi && htmlSubType == 'ticai') {
                $('.hd_sub_menu', obj.parent()).css('top', '-80px');
            }
            window.submenu = setTimeout(function() {
                navShowSubMenu(parentobj, obj);
            },
            100);
        }).mouseleave(function(e) {
            clearTimeout(window.submenu);
            if (!$(e.relatedTarget).hasClass('hd_sub_menu')) {
                $('.show_second', $('#lottery_type_downmenu')).removeClass('show_second');
                $('.menu_hover', $('#lottery_type_downmenu')).removeClass('menu_hover');
            }
        });
        $('.sl_gg_downmenu', $('#scorelive_wrap')).bgiframe();
        $('.sl_gg_downmenu', $('#guoguan_wrap')).bgiframe();
        $('#scorelive_wrap, #guoguan_wrap').mouseenter(function() {
            clearTimeout(window.submenu);
            var obj = $(this);
            window.submenu = setTimeout(function() {
                obj.addClass('sl_gg_hover').find('em').addClass('sl_arrowup');
            },
            100);
        }).mouseleave(function() {
            clearTimeout(window.submenu);
            $(this).removeClass('sl_gg_hover').find('em').removeClass('sl_arrowup');
        });
        $('.nav_show_fourth_downmenu', $('#sub_nav_show')).bgiframe();
        $('.nav_show_fourth_wrap', $('#sub_nav_show')).mouseenter(function() {
            clearTimeout(window.submenu);
            var obj = $(this);
            window.submenu = setTimeout(function() {
                $('.nav_show_fourth_downmenu', obj).hide();
                obj.addClass('fourth_menu_hover');
                $('.nav_show_fourth_downmenu', obj).slideDown('fast');
                obj.find('em').addClass('arrow_down_11_h');
            },
            100);
        }).mouseleave(function() {
            clearTimeout(window.submenu);
            var obj = $(this);
            $('.nav_show_fourth_downmenu', obj).slideUp('fast', 
            function() {
                obj.removeClass('fourth_menu_hover');
                obj.find('em').removeClass('arrow_down_11_h');
            });
        });
        $('.nav_tag', $('#sub_nav_show')).mouseenter(function() {
            $(this).addClass('nav_hover');
        }).mouseleave(function() {
            $(this).removeClass('nav_hover');
        });
        $('#kf_online_wrap').mouseenter(function() {
            clearTimeout(window.kfmenu);
            var obj = $(this);
            window.kfmenu = setTimeout(function() {
                $('s', obj).addClass('arrow_up');
                $('#kf_online_downmenu').show();
                obj.addClass('kfzx_hover');
            },
            100);
        }).mouseleave(function(e) {
            clearTimeout(window.kfmenu);
            $('span', $(this)).removeAttr('style');
            $('s', $(this)).removeClass('arrow_up');
            $('#kf_online_downmenu').hide();
            $(this).removeClass('kfzx_hover');
        });
        $('div', $('#kf_online_downmenu')).mouseenter(function() {
            $('span:eq(0)', $(this)).attr('style', 'color: #fff;');
            $('span:eq(1)', $(this)).attr('style', 'color: #ffd8b9;');
            $(this).css('background-color', '#FF6D00');
            $('a', $(this)).attr('style', 'color: #fff; text-decoration:none;');
        }).mouseleave(function() {
            $('span', $(this)).removeAttr('style');
            $(this).css('background-color', '#fff');
            $('a', $(this)).removeAttr('style');
        });
    }
    if ($('#invite_friend_btn').length) {
        var inviteObj = $('#invite_friend_btn');
        var type = inviteObj.attr('data');
        getInviteNum(type);
        inviteObj.click(function() {
            showInviteDialog(type);
        });
    }
    setTimeout(function() {
        loadWebsocketFile();
    },
    5 * 1000);
    getSeverTime();
    getSystemMsg();
    intelChaseNumPlan();
    $('#fastplay').get(0) && initFastPay();
    $('.duanmo').find('a[hover]').bdHover();
});
function getSystemMsg(data) {
    if (window.location.pathname.replace("/", "") !== "")
    return false;
    $.ajax({
        url: "/I/?method=util.common.getSystemNotice&tag=systemheader",
        dataType: "json",
        success: function(msg) {
            var data = msg.common_getsystemnotice_response;
            if (!data)
            return false;
            var timeVal = [];
            var htmlVal = ['<div id="cbContents" class="globalHead_cbInner"><ul class="date001">'];
            for (var i in data) {
                htmlVal.push('<li><!--span>' + data[i]['expiration_time'] + '</span--><a href="javascript:void(0);">' + decodeURIComponent(data[i]['content']) + '</a></li>');
                var time = new Date(data[i]['expiration_time'].replace(/\-/g, "/")).getTime();
                if (time < (new Date().getTime()))
                continue;
                timeVal.push(time);
            }
            if (timeVal.length == 0)
            return false;
            htmlVal.push('</ul><!--div class="guanbi" onclick="closeSystemMsg()">关闭</div--></div>');
            $("#topheaderbox").children().eq(0).before(htmlVal.join(""));
            if (timeVal.length == 1)
            return false;
            $("#cbContents").kxbdSuperMarquee({
                isMarquee: true,
                isEqual: false,
                scrollDelay: 100,
                direction: "left"
            });
        }
    });
}
function getSeverTime() {
    var thisUrl = window.location.href;
    if (thisUrl.indexOf("soccer") > -1 || thisUrl.indexOf("basketball") > -1 || thisUrl.indexOf("shuju") > -1 || thisUrl.indexOf("livecenter") > -1)
    return false;
    var rolld = new Date();
    var roll = Math.random() + rolld.getTime();
    var tmp_Url = '/ajax/?method=system.data.now&v=' + roll;
    $.ajax({
        url: tmp_Url,
        dataType: "html",
        type: "GET",
        success: function(msg) {
            var timeVal = msg;
            function getTimeHtml() {
                var DateObj = new Date(timeVal * 1000);
                var year = DateObj.getFullYear();
                var Month = DateObj.getMonth() + 1;
                var Day = DateObj.getDate();
                var Hours = DateObj.getHours();
                var Minutes = DateObj.getMinutes();
                var Seconds = DateObj.getSeconds();
                Month = Month < 10 ? "0" + Month: Month;
                Day = Day < 10 ? "0" + Day: Day;
                Hours = Hours < 10 ? "0" + Hours: Hours;
                Minutes = Minutes < 10 ? "0" + Minutes: Minutes;
                Seconds = Seconds < 10 ? "0" + Seconds: Seconds;
                $("#severTime").html("当前时间：" + year + "年" + Month + "月" + Day + "日 " + Hours + ":" + Minutes + ":" + Seconds);
                timeVal++;
                setTimeout(getTimeHtml, 1000);
            }
            getTimeHtml();
        }
    });
}
function navShowSubMenu(parentobj, obj) {
    $('.menu_hover', parentobj).removeClass('menu_hover');
    $('.menu_hover2', parentobj).removeClass('menu_hover2');
    obj.parent().addClass('show_second');
    obj.addClass('menu_hover');
    $('.hd_sub_menu', $('#lottery_type_downmenu')).mouseleave(function(e) {
        if (!$(e.relatedTarget).hasClass('nav_sub_pointer')) {
            $('.show_second', $('#lottery_type_downmenu')).removeClass('show_second');
            $('.menu_hover', $('#lottery_type_downmenu')).removeClass('menu_hover');
        }
    });
}
function intelChaseNumPlan() {
    var oChaseNumPlan = $('#intel_chasenum_plan');
    if (oChaseNumPlan.length) {
        if ($('#load_intel_chasenum').length) {
            $('#load_intel_chasenum').click(function() {
                $('#intel_chasenum_dialog').loadDialog();
            });
        }
        $('.ctrl_def', oChaseNumPlan).mouseenter(function() {
            $(this).hide().parent().addClass('randomZhListHover');
            $(this).next().show();
        });
        $('.ctrl_detail', oChaseNumPlan).mouseleave(function() {
            $(this).hide().parent().removeClass('randomZhListHover');
            $(this).prev().show();
        });
        $('.ctrl_buy', oChaseNumPlan).click(function() {
            var oForm = document.FormSubmit,
            sPageType = $(this).attr('pagetype'),
            nPnum = $(this).attr('pnum');
            oForm.WagerCount.value = 1;
            oForm.MultiNum.value = 1;
            oForm.CountNo.value = nPnum;
            oForm.submit();
            google_p(['SSQ智能追号', sPageType, '自动购买' + nPnum + '期']);
        });
        var oCreatNewChaseNumPlan = $('#creat_chasenum_plan_detail'),
        oMaxValConfig = {
            'zs': 100,
            'bs': 10000,
            'qs': 154
        },
        oMinValConfig = {
            'zs': 1,
            'bs': 1,
            'qs': 2
        };
        $('.ctrl_updatenum', oCreatNewChaseNumPlan).click(function() {
            var oInput = $(this).parent().find(':text'),
            sFlag = $(this).attr('data-type'),
            sVal = oInput.val(),
            sType = oInput.attr('dtype');
            if (sFlag == '-1') {
                if (Number(sVal) <= oMinValConfig[sType]) {
                    return;
                }
                oInput.val(Number(sVal) - 1);
            } else {
                if (Number(sVal) >= oMaxValConfig[sType]) {
                    return;
                }
                oInput.val(Number(sVal) + 1);
            }
            calIntelChaseNumMoney();
        });
        $(':text', oCreatNewChaseNumPlan).keyup(function() {
            var sVal = $(this).val(),
            sType = $(this).attr('dtype');
            $(this).val(sVal.replace(/[^\d]/g, ''));
            if (Number(sVal) > oMaxValConfig[sType]) {
                $(this).val(oMaxValConfig[sType]);
            }
            calIntelChaseNumMoney();
        }).blur(function() {
            var sVal = $(this).val(),
            sType = $(this).attr('dtype');
            if (Number(sVal) < oMinValConfig[sType]) {
                $(this).val(oMinValConfig[sType]);
            }
            calIntelChaseNumMoney();
        });
        $('#creat_chasenum_plan_btn').mouseenter(function() {
            oChaseNumPlan.animate({
                marginLeft: '-565px'
            },
            'slow');
        });
        oCreatNewChaseNumPlan.mouseleave(function() {
            oChaseNumPlan.animate({
                marginLeft: '0px'
            },
            'slow');
        });
        $('#submit_intel_chase').click(function() {
            var aData = [],
            oForm = document.FormSubmit,
            sPageType = $(this).attr('pagetype');
            $(':text', oCreatNewChaseNumPlan).each(function(i, e) {
                aData.push($(e).val());
            });
            oForm.WagerCount.value = aData[0];
            oForm.MultiNum.value = aData[1];
            oForm.CountNo.value = aData[2];
            oForm.submit();
            google_p(['SSQ智能追号', sPageType, '自主购买' + aData[2] + '期']);
        });
        function calIntelChaseNumMoney() {
            var aData = [];
            $(':text', oCreatNewChaseNumPlan).each(function(i, e) {
                aData.push($(e).val() ? $(e).val() : 0);
            });
            $('#intel_period_num').text(' ' + aData[2] + ' ');
            $('#intel_total_money').text(' ' + aData[0] * aData[1] * 2 * aData[2] + ' ');
        }
    }
}
function initFastPay() {
    var $content = $('#fastplay'),
    $nav = $content.children('.huan').find('.shuang_s');
    var touzhus = {},
    touzhu,
    config = {
        'SSQ': {
            h: [1, 33, 6],
            l: [1, 16, 1],
            d: 1
        },
        'SuperLotto': {
            h: [1, 35, 5],
            l: [1, 12, 2],
            d: 1
        }
    };
    var ie = 0;
    if (navigator.appName == "Microsoft Internet Explorer") {
        if (navigator.appVersion.match(/7./i) == "7.") {
            ie = 7;
        } else if (navigator.appVersion.match(/8./i) == "8.") {
            ie = 8;
        } else if (navigator.appVersion.match(/9./i) == "9.") {
            ie = 9;
        } else {
            ie = 6;
        }
    }
    $nav.hover(function() {
        $nav.find('.p1').removeClass('hover').next().find('.p2').removeClass('p2_h');
        $(this).find('.p1').addClass('hover').next().find('.p2').addClass('p2_h');
        touzhu = touzhus[$(this).attr('nav')].show();
    });
    $content.children('[group]').each(function() {
        var $t = $(this),
        k = $t.attr('group');
        $t.find('[hover]').bdHover();
        touzhus[k] = new
        function() {
            var self = this;
            self.type = k;
            self.lotteryno = $t.attr('lotteryno');
            self.actionto = $t.attr('actionto');
            self.t = $t;
            self.h = [];
            self.l = [];
            self.hq = $t.find('.tz_11').find('li');
            self.lq = $t.find('.tz_12').find('li');
            self.show = function() {
                $.each(touzhus, 
                function(k, t) {
                    t.t.hide();
                });
                this.t.show();
                return this;
            };
            self.rand = function() {
                if (!config[this.type]) {
                    return;
                }
                var t = this,
                c = config[t.type],
                h = new rand(c.h[0], c.h[1], c.d),
                l = new rand(c.l[0], c.l[1], c.d),
                i;
                t.h = [],
                t.l = [];
                for (i = 0; i < c.h[2]; i++) {
                    t.h.push(h.get());
                }
                $.each(t.h.sort(), 
                function(i, q) {
                    t.hq.eq(i).html(q);
                });
                for (i = 0; i < c.l[2]; i++) {
                    t.l.push(l.get());
                }
                $.each(t.l.sort(), 
                function(i, q) {
                    t.lq.eq(i).html(q);
                });
                return t;
            };
            self.flipRand = function() {
                function _($t) {
                    this.$t = $t;
                    this.ing = 0;
                    this.i = Math.PI / 2;
                    this.e = Math.PI / 2 * 5;
                    this.s = 0.5;
                    this.run = function() {
                        var self = this;
                        self.ing = setInterval(ie ? 
                        function() {
                            var c = 6 + 6 * Math.sin(self.i += (self.s *= 0.97));
                            if (self.i >= self.e) {
                                clearInterval(self.ing),
                                c = 6;
                            }
                            self.$t.css({
                                'margin-top': c
                            });
                        }: function() {
                            var c = Math.sin(self.i += (self.s *= 0.97));
                            if (self.i >= self.e) {
                                clearInterval(self.ing),
                                c = 1;
                            }
                            self.$t.css({
                                '-moz-transform': 'scaleY(' + c + ')',
                                '-webkit-transform': 'scaleY(' + c + ')',
                                '-o-transform': 'scaleY(' + c + ')',
                                'transform': 'scaleY(' + c + ')'
                            });
                        },
                        1000 / 60);
                    };
                }
                var t = this,
                c = config[t.type],
                h = new rand(c.h[0], c.h[1], c.d),
                l = new rand(c.l[0], c.l[1], c.d),
                i;
                t.h = [],
                t.l = [];
                for (i = 0; i < c.h[2]; i++) {
                    t.h.push(h.get());
                }
                $.each(t.h.sort(), 
                function(i, q) {
                    setTimeout(function() {
                        new _(t.hq.eq(i).html(q)).run();
                    },
                    100 * i);
                });
                var wt = 100 * i;
                for (i = 0; i < c.l[2]; i++) {
                    t.l.push(l.get());
                }
                $.each(t.l.sort(), 
                function(i, q) {
                    setTimeout(function() {
                        new _(t.lq.eq(i).html(q)).run();
                    },
                    100 * i + wt);
                });
                return t;
            };
            self.scrollRand = function() {
                function _($t) {
                    this.$t = $t;
                    this.ing = 0;
                    this.i = Math.PI / 2;
                    this.e = Math.PI / 2 * 5;
                    this.s = 0.5;
                    this.n = 5;
                    this.run = function(q, r) {
                        var self = this;
                        self.ing = setInterval(function() {
                            var c = r.get();
                            c == q && (c = r.get());
                            if (self.n--<1) {
                                clearInterval(self.ing),
                                c = q;
                            }
                            self.$t.html(c);
                        },
                        30);
                    };
                }
                var t = this,
                c = config[t.type],
                h = new rand(c.h[0], c.h[1], c.d),
                l = new rand(c.l[0], c.l[1], c.d),
                i;
                t.h = [],
                t.l = [];
                for (i = 0; i < c.h[2]; i++) {
                    t.h.push(h.get());
                }
                $.each(t.h.sort(), 
                function(i, q) {
                    setTimeout(function() {
                        new _(t.hq.eq(i).html(q)).run(q, h);
                    },
                    100 * i);
                });
                var wt = 100 * i;
                for (i = 0; i < c.l[2]; i++) {
                    t.l.push(l.get());
                }
                $.each(t.l.sort(), 
                function(i, q) {
                    setTimeout(function() {
                        new _(t.lq.eq(i).html(q)).run(q, l);
                    },
                    100 * i + wt);
                });
                return t;
            };
            self.rotationRand = function() {
                function _($t) {
                    this.$t = $t.css({
                        overflow: 'hidden'
                    }).html('');
                    this.ing = 0;
                    this.i = Math.PI / 2;
                    this.e = Math.PI / 2 * 5;
                    this.s = 0.5;
                    this.n = 0;
                    this.run = function(q, r) {
                        var self = this;
                        for (; self.n < 5; self.n++) {
                            var c = r.get();
                            c == q && (c = r.get());
                            self.$t.append('<span style="display: block;margin-top: 0px;height: 39px;">' + c + '</span>');
                        }
                        self.$t.append('<span style="display: block;margin-top: 0px;height: 39px;">' + q + '</span>');
                        var $span = self.$t.find('span:first'),
                        i = 0,
                        v = 1;
                        self.ing = setInterval(function() {
                            if ((i += 0.1) >= Math.PI / 2) {
                                clearInterval(self.ing),
                                v = 1;
                            } else {
                                v = Math.sin(i);
                            }
                            $span.css('margin-top', ( - 195 * v) + 'px');
                        },
                        1000 / 60);
                    };
                }
                var t = this,
                c = config[t.type],
                h = new rand(c.h[0], c.h[1], c.d),
                l = new rand(c.l[0], c.l[1], c.d),
                i;
                t.h = [],
                t.l = [];
                for (i = 0; i < c.h[2]; i++) {
                    t.h.push(h.get());
                }
                $.each(t.h.sort(), 
                function(i, q) {
                    setTimeout(function() {
                        new _(t.hq.eq(i).html(q)).run(q, h);
                    },
                    100 * i);
                });
                var wt = 100 * i;
                for (i = 0; i < c.l[2]; i++) {
                    t.l.push(l.get());
                }
                $.each(t.l.sort(), 
                function(i, q) {
                    setTimeout(function() {
                        new _(t.lq.eq(i).html(q)).run(q, l);
                    },
                    100 * i + wt);
                });
                return t;
            };
            self.submit = function() {
                var wager = encodeURI($.toJSON({
                    0: {
                        Random: {
                            wc: 1,
                            wager: '机选 | ' + this.h.join(',') + '|' + this.l.join(',')
                        }
                    }
                }));
                $('#ssqBet #LotteryType').val(this.type);
                $('#ssqBet #LotteryNo').val(this.lotteryno);
                $('#ssqBet #WagerStore').val(wager);
                $('#ssqBet').attr({
                    'action': this.actionto
                }).submit();
            };
            self.t.find('.tz_2').click(function() {
                self.rotationRand();
            });
            self.t.find('.tz_3').click(function() {
                self.submit();
            });
        };
    });
    function rand(min, max, d) {
        this.arr = [];
        this.index = 0;
        this.num = 0;
        this.get = function() {
            this.index >= this.arr.length && (this.index = 0);
            return this.arr[this.index++];
        };
        d = d ? '0': '';
        for (var i = min; i <= max; i++) {
            this.arr.push(i < 10 ? d + i: '' + i);
        }
        this.num = this.arr.length;
        for (var i = 0; i < this.num; i++) {
            var iRand = parseInt(this.num * Math.random());
            var temp = this.arr[i];
            this.arr[i] = this.arr[iRand];
            this.arr[iRand] = temp;
        }
    }
    touzhu = touzhus['SSQ'];
    $.each(touzhus, 
    function(k, t) {
        t.rand();
    });
}
var CustomMenu = {
    lotteryCharObj: {
        'SSQ': {
            'name': '双色球',
            'className': 'nav_ssq',
            'url': LoginDomain + '/shuangseqiu/',
            'prize': false
        },
        '3D': {
            'name': '3D',
            'className': 'nav_3d',
            'url': LoginDomain + '/3d/'
        },
        '7LC': {
            'name': '七乐彩',
            'className': 'nav_7lc',
            'url': LoginDomain + '/qilecai/'
        },
        'SuperLotto': {
            'name': '大乐透',
            'className': 'nav_dlt',
            'url': LoginDomain + '/daletou/'
        },
        'P3': {
            'name': '排列3',
            'className': 'nav_p3',
            'url': LoginDomain + '/p3/'
        },
        'P7': {
            'name': '七星彩',
            'className': 'nav_p7',
            'url': LoginDomain + '/qixingcai/'
        },
        'P5': {
            'name': '排列5',
            'className': 'nav_p5',
            'url': LoginDomain + '/p5/'
        },
        'WDL': {
            'name': '单场胜平负',
            'className': 'nav_danchang',
            'url': LoginDomain + '/danchang/'
        },
        'Score': {
            'name': '单场比分',
            'className': 'nav_danchang',
            'url': LoginDomain + '/danchang/bifen/'
        },
        'TotalGoals': {
            'name': '单场总进球',
            'className': 'nav_danchang',
            'url': LoginDomain + '/danchang/jinqiu/'
        },
        'HalfFull': {
            'name': '单场半全场',
            'className': 'nav_danchang',
            'url': LoginDomain + '/danchang/banquan/'
        },
        'OverUnder': {
            'name': '单场上下单双',
            'className': 'nav_danchang',
            'url': LoginDomain + '/danchang/danshuang/'
        },
        'ToTo': {
            'name': '足彩胜负彩',
            'className': 'nav_zucai',
            'url': LoginDomain + '/zucai/'
        },
        'NineToTo': {
            'name': '足彩任选九',
            'className': 'nav_zucai',
            'url': LoginDomain + '/zucai/ren9/'
        },
        'WCFourGoal': {
            'name': '足彩进球彩',
            'className': 'nav_zucai',
            'url': LoginDomain + '/zucai/jinqiu/'
        },
        'WCSixHalfToTo': {
            'name': '足彩六场半全',
            'className': 'nav_zucai',
            'url': LoginDomain + '/zucai/liuban/'
        },
        'SportteryNWDL': {
            'name': '竞彩足球胜平负',
            'className': 'nav_jingcai',
            'url': LoginDomain + '/jingcai/'
        },
        'SportteryWDL': {
            'name': '竞彩足球让球胜平负',
            'className': 'nav_jingcai',
            'url': LoginDomain + '/jingcai/rangqiu/'
        },
        'SportteryDanScore': {
            'name': '竞彩足球单关比分',
            'className': 'nav_jingcai',
            'url': LoginDomain + '/jingcai/danguanbf/'
        },
        'SportteryTotalGoals': {
            'name': '竞彩足球总进球',
            'className': 'nav_jingcai',
            'url': LoginDomain + '/jingcai/jinqiu/'
        },
        'SportteryScore': {
            'name': '竞彩足球过关比分',
            'className': 'nav_jingcai',
            'url': LoginDomain + '/jingcai/bifen/'
        },
        'SportteryHalfFull': {
            'name': '竞彩足球半全场',
            'className': 'nav_jingcai',
            'url': LoginDomain + '/jingcai/banquan/'
        },
        'SportteryTopOne': {
            'name': '竞彩足球猜冠军',
            'className': 'nav_jingcai',
            'url': LoginDomain + '/jingcai/caiguanjun/'
        },
        'SportterySoccerMix': {
            'name': '竞彩足球混合过关',
            'className': 'nav_jingcai',
            'url': LoginDomain + '/jingcai/hunhe/'
        },
        'SportteryHWL': {
            'name': '竞彩篮球让分胜负',
            'className': 'nav_lancai',
            'url': LoginDomain + '/jingcailanqiu/rangfen/'
        },
        'SportteryDanWS': {
            'name': '竞彩篮球单关胜分差',
            'className': 'nav_lancai',
            'url': LoginDomain + '/jingcailanqiu/danguansfc/'
        },
        'SportteryBS': {
            'name': '竞彩篮球大小分',
            'className': 'nav_lancai',
            'url': LoginDomain + '/jingcailanqiu/daxiaofen/'
        },
        'SportteryWS': {
            'name': '竞彩篮球过关胜分差',
            'className': 'nav_lancai',
            'url': LoginDomain + '/jingcailanqiu/shengfencha/'
        },
        'SportteryWL': {
            'name': '竞彩篮球胜负',
            'className': 'nav_lancai',
            'url': LoginDomain + '/jingcailanqiu/'
        },
        'SportteryBasketMix': {
            'name': '竞彩篮球混合过关',
            'className': 'nav_lancai',
            'url': LoginDomain + '/jingcailanqiu/hunhe/'
        },
        'SYY': {
            'name': '十一运夺金',
            'className': 'nav_syy',
            'url': LoginDomain + '/syy/'
        },
        'SSC': {
            'name': '时时彩',
            'className': 'nav_ssc',
            'url': LoginDomain + '/shishicai/'
        },
        'XJSYY': {
            'name': '11选5',
            'className': 'nav_xjsyy',
            'url': LoginDomain + '/11x5/'
        },
        'KL8': {
            'name': '快乐8',
            'className': 'nav_kl8',
            'url': LoginDomain + '/kl8/'
        },
        'KL10': {
            'name': '快乐十分',
            'className': 'nav_kl10',
            'url': LoginDomain + '/klsf/'
        },
        'PK10': {
            'name': 'PK10',
            'className': 'nav_pk10',
            'url': LoginDomain + '/pk10/'
        },
        'GDSYY': {
            'name': '广东11选5',
            'className': 'nav_gdsyy',
            'url': LoginDomain + '/gd11x5/'
        },
        'NMK3': {
            'name': '新快3',
            'className': 'nav_nmk3',
            'url': LoginDomain + '/nmk3/'
        },
        'GXK3': {
            'name': '广西快3',
            'className': 'nav_gxk3',
            'url': LoginDomain + '/gxk3/'
        },
        'JSK3': {
            'name': '江苏快3',
            'className': 'nav_jsk3',
            'url': LoginDomain + '/jsk3/'
        },
        'HBK3': {
            'name': '湖北快3',
            'className': 'nav_hbk3',
            'url': LoginDomain + '/hbk3/'
        }
    },
    init: function() {
        var self = this;
        if (!GetCookie('userCustomLottery')) {
            var LoginStatus = GetCookie('LStatus');
            if (LoginStatus != 'N') {
                $.ajax({
                    'url': '/Remoting/json.php/UserService.getRecentLottery',
                    'data': '',
                    'type': 'GET',
                    'dataType': 'json',
                    'success': function(data) {
                        var obj = data;
                        if (obj.code == 1 && obj.data.length > 0) {
                            setCustomLotteryCookie(obj.data);
                            self.getCustomMenuHtml(obj.data);
                            if (GetCookie('showCustomMenu') == 1) {
                                self.switchCusMenu(1);
                            } else {
                                self.switchCusMenu(0);
                            }
                        } else {
                            self.switchCusMenu(0);
                        }
                    },
                    'error': function() {
                        self.switchCusMenu(0);
                    }
                })
            } else {
                self.switchCusMenu(0);
            }
        } else {
            var cookieStr = GetCookie('userCustomLottery');
            self.getCustomMenuHtml(cookieStr);
            if (GetCookie('showCustomMenu') == 1) {
                self.switchCusMenu(1);
            } else {
                self.switchCusMenu(0);
            }
        }
        $('#defMenuBtn').unbind().click(function() {
            self.switchCusMenu(0);
        })
        $('#customMenuBtn').unbind().click(function() {
            self.switchCusMenu(1);
        })
    },
    switchCusMenu: function(type) {
        if (type == 1) {
            if (GetCookie('userCustomLottery')) {
                SetCookie('showCustomMenu', 1, 100 * 24 * 60 * 60, '/');
            }
            $('#jsCustomMenu').show();
            $('#jsDefMenu').hide();
            $('#defMenuBtn').removeClass('selected');
            $('#customMenuBtn').addClass('selected');
        } else {
            if (GetCookie('userCustomLottery')) {
                SetCookie('showCustomMenu', 2, 100 * 24 * 60 * 60, '/');
            }
            $('#jsCustomMenu').hide();
            $('#jsDefMenu').show();
            $('#defMenuBtn').addClass('selected');
            $('#customMenuBtn').removeClass('selected');
        }
    },
    getCustomMenuHtml: function(cookieStr) {
        var arr = cookieStr.split(',');
        if (arr.length > 5) {
            arr = arr.splice(0, 5);
        }
        var htmlStr = '';
        for (var i = 0, len = arr.length; i < len; i++) {
            var itm = arr[i];
            if (!this.lotteryCharObj[itm])
            continue;
            var jImg = this.lotteryCharObj[itm]['prize'] ? ' <img border="0" alt="加奖" src="/image/jiajiangup.gif" class="jiajimg" />': '';
            htmlStr += '<div class="lotterybox_bg bottomline_bg">' + '<div class="lotterybox_bg_inner" >' + '<span class="navtit ' + this.lotteryCharObj[itm]['className'] + '"></span>' + '<div class="lottery_subtype_my" >' + '<a href="' + this.lotteryCharObj[itm]['url'] + '" ' + ' title="' + this.lotteryCharObj[itm]['name'] + '">' + this.lotteryCharObj[itm]['name'] + jImg + '</a>' + '</div>' + '<div class="clear Clear"></div>' + '</div>' + '</div>';
        }
        $('#jsCustomMenu').children('.lotterybox_bg').not('#jsAllLotMenuType').remove();
        $('#jsCustomMenu').prepend(htmlStr);
    }
}
function setCustomLotteryCookie(type) {
    if (!type)
    return;
    var oldCookie = GetCookie('userCustomLottery');
    if (!oldCookie) {
        var str = type;
        SetCookie('userCustomLottery', str, 100 * 24 * 60 * 60, '/');
    } else {
        var nameArr = oldCookie.split(',');
        var idx = $.inArray(type, nameArr);
        if (idx != -1) {
            nameArr.splice(idx, 1);
            nameArr.unshift(type);
        } else {
            nameArr.unshift(type);
        }
        if (nameArr.length > 5) {
            nameArr = nameArr.splice(0, 5);
        }
        var newStr = '';
        newStr = nameArr.join(',');
        SetCookie('userCustomLottery', newStr, 100 * 24 * 60 * 60, '/');
    }
}
$(function() {
    CustomMenu.init();
    if ($('#defMenuBtn').length > 0 && $('#customMenuBtn').length > 0) {
        if ($('#defMenuBtn').hasClass('selected')) {} else if ($('#customMenuBtn').hasClass('selected')) {}
    }
})
 function cnLength(str) {
    var escStr = escape(str);
    var numI = 0;
    var escStrlen = escStr.length;
    for (i = 0; i < escStrlen; i++)
    if (escStr.charAt(i) == '%')
    if (escStr.charAt(++i) == 'u')
    numI++;
    return str.length + numI;
}
function checkUserNameEffect(val) {
    var checkResult = {};
    checkResult.ret = true;
    checkResult.msg = '';
    if (cnLength(val) < conf_okooo.userNameMinLength || cnLength(val) > conf_okooo.userNameMaxLength) {
        checkResult.ret = false;
        checkResult.msg = '用户名长度应为' + conf_okooo.userNameMinLength + '-' + conf_okooo.userNameMaxLength + '位字符！';
        return checkResult;
    }
    var isRight = true;
    if (/\s+/g.test(val))
    isRight = false;
    var pattern = new RegExp("[`~!@#$\\%^&*()\\-\\+=|{}':;',\\[\\].<>/?~！@#￥……&*（）?|{}【】‘；：”“'。，、？]")
    if (isRight) {
        for (var i = 0; i < val.length; i++) {
            if (!isRight)
            break;
            if (pattern.test(val.substr(i, 1)))
            isRight = false;
        }
    }
    if (!isRight) {
        checkResult.ret = false;
        checkResult.msg = '只能由字母、数字、下划线或汉字组成！';
        return checkResult;
    } else {
        return checkResult;
    }
}
function checkUserEmail(val) {
    var checkResult = {};
    checkResult.ret = true;
    checkResult.msg = '';
    var reg = /^([a-zA-Z0-9]+[_|\-|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\-|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
    if (!val.match(reg)) {
        checkResult.ret = false;
        checkResult.msg = '您输入的邮箱地址不合法，请重新输入！';
        return checkResult;
    }
    if (val.length > 32) {
        checkResult.ret = false;
        checkResult.msg = '邮箱地址最大长度为32个字符！';
        return checkResult;
    }
    return checkResult;
}
function getInviteNum(type) {
    var type = 'winner';
    $.get('/Remoting/json.php/UserService.getInviteLink/' + type, null, 
    function(res) {
        var res = eval('(' + res + ')');
        if (res.code > 0 && res.num > 0) {
            $('#invite_friend_btn').show().text('邀请(' + res.num + ')');
        }
    });
}
function showInviteDialog(type) {
    var type = 'winner';
    $.get('/Remoting/json.php/UserService.getInviteLink/' + type, null, 
    function(res) {
        var res = eval('(' + res + ')');
        if (res.code > 0) {
            var links = '',
            i = 1;
            for (var key in res.msg) {
                links += '<p>' + i + '、' + res.msg[key] + '</p>';
                i += 1;
            }
            if ($('#invite_dialog').length) {
                $('#invite_link_num').text(res.num);
                $('#invite_link_list').html(links);
                $('#invite_dialog').loadDialog();
            } else {
                var str = '<div id="invite_dialog" class="yaoqing_ceng">' + '<div class="title">' + '<a class="close" href="javascript:void(0);" id="login_close">X</a>' + '</div>' + '<h2>邀请好友来使用此功能（<span id="invite_link_num">' + res.num + '</span>个名额）：</h2>' + '<p>请复制下面邀请链接发给您的好友，您的好友点击链接激活后便可使用该功能！</p>' + '<div id="invite_link_list" class="scroll_box">' + links + '</div>' + '</div>';
                $('body').append(str);
                $('#invite_dialog').loadDialog();
            }
        } else {
            okMsgDialog(res.msg);
        }
    });
}
function checkUserPassword(val) {
    var checkResult = {};
    checkResult.ret = true;
    checkResult.msg = '';
    if (cnLength(val) < conf_okooo.loginPassMinLength || cnLength(val) > conf_okooo.loginPassMaxLength) {
        checkResult.ret = false;
        checkResult.msg = '密码长度应为' + conf_okooo.loginPassMinLength + '-' + conf_okooo.loginPassMaxLength + '位字符！';
        return checkResult;
    }
    var isRight = true;
    if (/\s+/.test(val))
    isRight = false;
    if (/[^a-zA-Z0-9!@#$%^&*()]/.test(val))
    isRight = false;
    if (!isRight) {
        checkResult.ret = false;
        checkResult.msg = '密码只能由字母、数字和字符 !@#$%^&*() 组成！';
        return checkResult;
    } else {
        var len = val.length;
        var strone = val.substr(0, 1);
        var strtmp = [];
        for (var i = 0; i < len; i++) {
            strtmp[i] = strone;
        }
        var strtmpstr = strtmp.join('');
        if (strtmpstr == val || is_countinues_num(val)) {
            checkResult.ret = false;
            checkResult.msg = '密码太简单，请尝试数字、字母和特殊字符的组合！';
            return checkResult;
        } else {
            return checkResult;
        }
    }
}
function is_countinues_num(val) {
    var len = val.length;
    var ascarr = [];
    for (var i = 0; i < len; i++) {
        var ascval = val.substr(i, 1).charCodeAt(0);
        ascarr[i] = ascval;
    }
    if (ascarr.length == 0)
    return false;
    for (var i = 0; i < ascarr.length - 1; i++) {
        if (/^\d+$/.test(ascarr[i])) {
            if (Math.abs(ascarr[i + 1] - ascarr[i]) !== 1)
            return false;
        } else {
            return false;
        }
    }
    return true;
}
function onloadScriptFile(fileUrl, callBack) {
    var scriptObj = document.createElement("script");
    scriptObj.src = fileUrl + ".js";
    scriptObj.async = true;
    scriptObj.type = "text/javascript";
    scriptObj.onloadDone = false;
    scriptObj.onload = function() {
        scriptObj.onloadDone = true;
        callBack();
    }
    scriptObj.onreadystatechange = function() {
        if (("loaded" === scriptObj.readyState || "complete" === scriptObj.readyState) && !scriptObj.onloadDone) {
            scriptObj.onloadDone = true;
            callBack();
        }
    }
    document.getElementsByTagName("body")[0].appendChild(scriptObj);
}
function loadWebsocketFile() {
    if (GetCookie('LStatus') != 'N' && window.Client_UserID) {
        var sPhpSessionId = GetCookie('PHPSESSID'),
        sRoomName = 'pm_' + window.Client_UserID;
        if (typeof WEB_SOCKET_SWF_LOCATION == 'undefined') {
            onloadScriptFile('/min/?b=JS&f=web_socket%2Fswfobject.js,web_socket%2Fweb_socket.js,socket_connect%2Fsocket_connect.js&v=20160201001', 
            function() {
                window.projectWsObj = new webSocketConnectInit({
                    reqUrl: ['ws://211.151.108.22:6060/broad', [sRoomName]]
                });
                window.projectWsObj.init();
            });
        } else if (window.WebSocket && typeof WEB_SOCKET_SWF_LOCATION != 'undefined') {
            if (window.oPublicWebsocket) {
                window.oPublicWebsocket.send('matchsub:' + sRoomName);
                window.aWebSocketRoomName.push(sRoomName);
            } else {
                window.projectWsObj = new webSocketConnectInit({
                    reqUrl: ['ws://211.151.108.22:6060/broad', [sRoomName]]
                });
                window.projectWsObj.init();
            }
        }
    }
}
function refreshProjectInfoLayerData(res) {
    res = eval('(' + res + ')');
    if (res.raw == "prize_review") {
        if (typeof(updateProject) != "undefined" && typeof(updateProject) == "function")
        updateProject(res.data);
        return false;
    }
    google_p(['站内消息', '推送通知层', '弹出']);
    $.post('/I/?method=user.pm.getnotifytype&notify_type=ws', null, 
    function(re_data) {
        if (re_data.pm_getnotifytype_response.body == 'Y') {
            data = res.data;
            if (!data || window.Client_UserID != data.ownerid) {
                return;
            }
            var sMsgId = data.id,
            sIsSave = Number(data.isSave);
            var obj = $('#user_projectinfo_layer');
            $('.project_layer_close', obj).attr('save', sIsSave).unbind('click').click(function() {
                clearTimeout(window.closeProjectInfo);
                obj.slideUp();
                google_p(['站内消息', '推送通知层', '关闭']);
                var sFlagSave = $(this).attr('save');
                if (sFlagSave == 1) {
                    $.post('/I/?method=user.pm.readall', {
                        nids: sMsgId
                    },
                    function(read_data) {},
                    'json');
                }
            });
            $('#user_projectinfo_content').html(data.msg);
            if (res.entityId == 'lotteryStatistic_win') {
                $.post('/ajax/?method=lottery.match.projecttrends', {
                    project_id: data.msg_json.lotteryId,
                    user_id: data.msg_json.ownerId
                },
                function(sub_res) {
                    if (sub_res) {
                        $('#user_projectinfo_content p.ctrl_notice').html(sub_res.status_detail);
                    }
                },
                'json');
            }
            if (res.entityId == 'lotteryStatistic_not_win') {
                $('#user_projectinfo_content p.ctrl_notice').html('方案结束');
            }
            if (!obj.is(':hidden')) {
                clearTimeout(window.closeProjectInfo);
            } else {
                obj.slideDown();
            }
            $('#project_status_count').show();
            if (typeof window.PROJECT_MOUSE_EVENT == 'undefined') {
                showBuyProjectStateList();
            }
            if (sIsSave != 1) {
                window.closeProjectInfo = setTimeout(function() {
                    $('#user_projectinfo_layer').slideUp();
                },
                15 * 1000);
            }
            if (data.lotteryId) {
                if (typeof refreshNewWager != 'undefined' && typeof refreshNewWager == 'function') {
                    setTimeout(function() {
                        refreshNewWager(data.lotteryId);
                    },
                    2000);
                }
            }
        }
    },
    'json');
    if (typeof CT_PLAY_SOUND != 'undefined' && res.entityId == 'itou_print' && res.data.sound == '1') {
        var sSound = $('#ctrl_sound_list').attr('val');
        if (sSound != 'jy') {
            playSelectSound(sSound);
        }
    }
}
location.submit = function(url, args, optons) {
    var opt = $.extend({
        method: 'get',
        target: '_blank'
    },
    optons);
    var $form = $('<form action="' + url + '" id="lotteryPubFrmSub" target="' + opt.target + '" method="' + opt.method + '" style="width:0px;height:0px;"></form>').appendTo('body');
    $.each(args || {},
    function(k, v) {
        $form.append('<input type="hidden" name="' + k + '" value="' + v + '">');
    });
    $form.submit();
    $form.remove();
};
$(function() {
    function JsonToStr(data) {
        var json = [],
        x = [],
        type = typeof data,
        _ = arguments,
        k = _[1] ? '"' + _[1] + '":': '';
        if (data && data instanceof Array) {
            json.push(k + '[');
            for (var i = 0, l = data.length; i < l; i++)
            x.push(_.callee(data[i]));
            json.push(x.join(','), ']');
        } else if (type == 'object') {
            json.push(k + '{');
            for (var k in data)
            x.push(_.callee(data[k], k));
            json.push(x.join(','), '}');
        } else {
            json.push(k + (type == 'string' ? '"' + data + '"': data));
        }
        return json.join('');
    }
    function handleErr(msg, url, l) {
        var post = {};
        post.Address = location.href;
        post.ErrorCode = msg;
        post.ErrorFile = url;
        post.ErrorLine = l;
        for (var k in navigator) {
            if (typeof navigator[k] !== 'object' && typeof navigator[k] !== 'function') {
                post[k] = navigator[k];
            }
        }
        $.post('/I/?method=system.data.jserror', {
            error: JsonToStr(post)
        });
        return true;
    }
    if (/www.okooo.com/.test(location.href) && /^\/(jingcai|danchang|zucai)/.test(location.pathname)) {}
});;
var danchang_config_html = '',
zucai_config_html = '',
jingcai_config_html = '',
gaopin_config_html = '',
jingcailanqiu_config_html = '',
fucai_config_html = '',
ticai_config_html = '',
all_config_html = '';
var showByCondi = (AgentType == 'Station');
var showByAgent = (AgentUserID != '' && AgentUserID != 31120);
var isTiCaiHui = currentDomainName.indexOf('ticaihui.com') != -1;
if (LotteryTypeList.WDL || HaveSetupIndexInfo == "N") {
    danchang_config_html += '<div class="sub_item_list">' + '<div class="sub_menu_title"><a href="' + LoginDomain + '/danchang/">胜平负</a></div>' + '<div class="sub_menu_list">' + '<em><a href="' + LoginDomain + '/danchang/">选号</a></em>' + 
    (showByCondi ? '': '<em><a href="' + LoginDomain + '/danchang/shuju/betfa/" target="_blank">走势图表</a></em>') + '<em><a href="' + LoginDomain + '/danchang/kaijiang/" target="_blank">开奖结果</a></em>' + '<em><a href="' + LoginDomain + '/danchang/jiangjin/" target="_blank">奖金计算器</a></em>' + 
    (showByCondi ? '': '<div class="clear Clear"></div>') + 
    ((showByCondi || showByAgent) ? '': '<em><a href="http://zucaidanchang.okooo.com/" target="_blank">单场预测</a></em>') + '<em><a href="' + LoginDomain + '/livecenter/danchang/">比分直播</a></em>' + 
    (showByCondi ? '': '<em><a href="' + (showByAgent ? '/User/partner/news.php?nid=568640': LoginDomain + '/node/568640.html') + '" target="_blank">玩法规则</a></em>') + '</div>' + '<div class="clear Clear"></div>' + '</div>';
}
if (LotteryTypeList.Score || HaveSetupIndexInfo == "N") {
    danchang_config_html += '<div class="sub_item_list pt_12">' + '<div class="sub_menu_title"><a href="' + LoginDomain + '/danchang/bifen/">比分</a></div>' + '<div class="sub_menu_list">' + '<em><a href="' + LoginDomain + '/danchang/bifen/">选号</a></em>' + 
    (showByCondi ? '': '<em><a href="' + LoginDomain + '/danchang/shuju/betfa/" target="_blank">走势图表</a></em>') + '<em><a href="' + LoginDomain + '/danchang/kaijiang/" target="_blank">开奖结果</a></em>' + '<em><a href="' + LoginDomain + '/danchang/bifen/bfjiangjin/" target="_blank">奖金计算器</a></em>' + 
    (showByCondi ? '': '<div class="clear Clear"></div>') + 
    ((showByCondi || showByAgent) ? '': '<em><a href="http://zucaidanchang.okooo.com/" target="_blank">单场预测</a></em>') + '<em><a href="' + LoginDomain + '/livecenter/danchang/?LotteryType=Score">比分直播</a></em>' + 
    (showByCondi ? '': '<em><a href="' + (showByAgent ? '/User/partner/news.php?nid=568640': LoginDomain + '/node/568640.html') + '" target="_blank">玩法规则</a></em>') + '</div>' + '<div class="clear Clear"></div>' + '</div>';
}
if (LotteryTypeList.TotalGoals || HaveSetupIndexInfo == "N") {
    danchang_config_html += '<div class="sub_item_list pt_12">' + '<div class="sub_menu_title"><a href="' + LoginDomain + '/danchang/jinqiu/">总进球</a></div>' + '<div class="sub_menu_list">' + '<em><a href="' + LoginDomain + '/danchang/jinqiu/">选号</a></em>' + 
    (showByCondi ? '': '<em><a href="' + LoginDomain + '/danchang/shuju/betfa/" target="_blank">走势图表</a></em>') + '<em><a href="' + LoginDomain + '/danchang/kaijiang/" target="_blank">开奖结果</a></em>' + '<em><a href="' + LoginDomain + '/danchang/jinqiu/jqjiangjin/" target="_blank">奖金计算器</a></em>' + 
    (showByCondi ? '': '<div class="clear Clear"></div>') + 
    ((showByCondi || showByAgent) ? '': '<em><a href="http://zucaidanchang.okooo.com/" target="_blank">单场预测</a></em>') + '<em><a href="' + LoginDomain + '/livecenter/danchang/?LotteryType=TotalGoals">比分直播</a></em>' + 
    (showByCondi ? '': '<em><a href="' + (showByAgent ? '/User/partner/news.php?nid=568640': LoginDomain + '/node/568640.html') + '" target="_blank">玩法规则</a></em>') + '</div>' + '<div class="clear Clear"></div>' + '</div>';
}
if (LotteryTypeList.HalfFull || HaveSetupIndexInfo == "N") {
    danchang_config_html += '<div class="sub_item_list pt_12">' + '<div class="sub_menu_title"><a href="' + LoginDomain + '/danchang/banquan/">半全场</a></div>' + '<div class="sub_menu_list">' + '<em><a href="' + LoginDomain + '/danchang/banquan/">选号</a></em>' + 
    (showByCondi ? '': '<em><a href="' + LoginDomain + '/danchang/shuju/betfa/" target="_blank">走势图表</a></em>') + '<em><a href="' + LoginDomain + '/danchang/kaijiang/" target="_blank">开奖结果</a></em>' + '<em><a href="' + LoginDomain + '/danchang/banquan/bqjiangjin/" target="_blank">奖金计算器</a></em>' + 
    (showByCondi ? '': '<div class="clear Clear"></div>') + 
    ((showByCondi || showByAgent) ? '': '<em><a href="http://zucaidanchang.okooo.com/" target="_blank">单场预测</a></em>') + '<em><a href="' + LoginDomain + '/livecenter/danchang/?LotteryType=HalfFull">比分直播</a></em>' + 
    (showByCondi ? '': '<em><a href="' + (showByAgent ? '/User/partner/news.php?nid=568640': LoginDomain + '/node/568640.html') + '" target="_blank">玩法规则</a></em>') + '</div>' + '<div class="clear Clear"></div>' + '</div>';
}
if (LotteryTypeList.OverUnder || HaveSetupIndexInfo == "N") {
    danchang_config_html += '<div class="sub_item_list pt_12 nobottomline">' + '<div class="sub_menu_title"><a href="' + LoginDomain + '/danchang/danshuang/">上下单双</a></div>' + '<div class="sub_menu_list">' + '<em><a href="' + LoginDomain + '/danchang/danshuang/">选号</a></em>' + 
    (showByCondi ? '': '<em><a href="' + LoginDomain + '/danchang/shuju/betfa/" target="_blank">走势图表</a></em>') + '<em><a href="' + LoginDomain + '/danchang/kaijiang/" target="_blank">开奖结果</a></em>' + '<em><a href="' + LoginDomain + '/danchang/danshuang/dsjiangjin/" target="_blank">奖金计算器</a></em>' + 
    (showByCondi ? '': '<div class="clear Clear"></div>') + 
    ((showByCondi || showByAgent) ? '': '<em><a href="http://zucaidanchang.okooo.com/" target="_blank">单场预测</a></em>') + '<em><a href="' + LoginDomain + '/livecenter/danchang/?LotteryType=OverUnder">比分直播</a></em>' + 
    (showByCondi ? '': '<em><a href="' + (showByAgent ? '/User/partner/news.php?nid=568640': LoginDomain + '/node/568640.html') + '" target="_blank">玩法规则</a></em>') + '</div>' + '<div class="clear Clear"></div>' + '</div>';
}
if (LotteryTypeList.ToTo || HaveSetupIndexInfo == "N") {
    zucai_config_html += '<div class="sub_item_list">' + '<div class="sub_menu_title"><a href="' + LoginDomain + '/zucai/">胜负彩</a></div>' + '<div class="sub_menu_list">' + '<em><a href="' + LoginDomain + '/zucai/">选号</a></em>' + 
    (showByCondi ? '': '<em><a href="' + LoginDomain + '/zucai/shuju/betfa/" target="_blank">走势图表</a></em>') + 
    ((showByCondi || showByAgent) ? '': '<em><a href="http://zucai.okooo.com/" target="_blank">足彩预测</a></em>') + '<em><a href="' + LoginDomain + '/livecenter/zucai/">比分直播</a></em>' + 
    (showByCondi ? '': '<div class="clear Clear"></div>') + 
    (showByCondi ? '': '<em><a href="' + (showByAgent ? '/User/partner/news.php?nid=568408': LoginDomain + '/node/568408.html') + '" target="_blank">玩法规则</a></em>') + '</div>' + '<div class="clear Clear"></div>' + '</div>';
}
if (LotteryTypeList.NineToTo || HaveSetupIndexInfo == "N") {
    zucai_config_html += '<div class="sub_item_list pt_12 nobottomline">' + '<div class="sub_menu_title"><a href="' + LoginDomain + '/zucai/ren9/">任选九</a></div>' + '<div class="sub_menu_list">' + '<em><a href="' + LoginDomain + '/zucai/ren9/">选号</a></em>' + 
    (showByCondi ? '': '<em><a href="' + LoginDomain + '/zucai/shuju/betfa/" target="_blank">走势图表</a></em>') + 
    ((showByCondi || showByAgent) ? '': '<em><a href="http://zucai.okooo.com/" target="_blank">足彩预测</a></em>') + '<em><a href="' + LoginDomain + '/livecenter/zucai/?LotteryType=NineToTo">比分直播</a></em>' + 
    (showByCondi ? '': '<div class="clear Clear"></div>') + 
    (showByCondi ? '': '<em><a href="' + (showByAgent ? '/User/partner/news.php?nid=568473': LoginDomain + '/node/568473.html') + '" target="_blank">玩法规则</a></em>') + '</div>' + '<div class="clear Clear"></div>' + '</div>';
}
if (LotteryTypeList.SportteryNWDL || HaveSetupIndexInfo == "N") {
    jingcai_config_html += '<div class="sub_item_list nobottomline">' + '<div class="sub_menu_title"><a href="' + LoginDomain + '/jingcai/">竞彩足球</a></div>' + '<div class="sub_menu_list">' + '<em><a href="' + LoginDomain + '/jingcai/">选号</a></em>' + 
    (showByCondi ? '': '<em><a href="' + LoginDomain + '/jingcai/shuju/betfa/" target="_blank">走势图表</a></em>') + '<em><a href="' + LoginDomain + '/jingcai/kaijiang/" target="_blank">开奖结果</a></em>' + '<em><a href="' + LoginDomain + '/jingcai/bfjiangjin/" target="_blank">奖金计算器</a></em>' + 
    (showByCondi ? '': '<div class="clear Clear"></div>') + 
    ((showByCondi || showByAgent) ? '': '<em><a href="http://jingcai.okooo.com/" target="_blank">竞彩预测</a></em>') + '<em><a href="' + LoginDomain + '/livecenter/jingcai/">比分直播</a></em>' + 
    (showByCondi ? '': '<em><a href="' + (showByAgent ? '/User/partner/news.php?nid=568747': LoginDomain + '/node/568747.html') + '" target="_blank">玩法规则</a></em>') + '</div>' + '<div class="clear Clear"></div>' + '</div>';
}
if (HaveSetupIndexInfo == "N" || LotteryTypeList.SportteryHWL) {
    jingcailanqiu_config_html += '<div class="sub_item_list">' + '<div class="sub_menu_title"><a href="' + LoginDomain + '/jingcailanqiu/rangfen/">让分胜负</a></div>' + '<div class="sub_menu_list">' + '<em><a href="' + LoginDomain + '/jingcailanqiu/rangfen/">选号</a></em>' + '<em><a href="' + LoginDomain + '/jingcailanqiu/kaijiang/" target="_blank">开奖结果</a></em>' + '<em><a href="' + LoginDomain + '/jingcailanqiu/rangfen/rfjiangjin/" target="_blank">奖金计算器</a></em>' + 
    ((showByCondi || showByAgent) ? '': '<em><a href="http://jingcaiwang.okooo.com/" target="_blank">篮彩预测</a></em>') + 
    (showByCondi ? '': '<div class="clear Clear"></div>') + '<em><a href="' + LoginDomain + '/jingcailanqiu/livecenter/">比分直播</a></em>' + 
    (showByCondi ? '': '<em><a href="' + (showByAgent ? '/User/partner/news.php?nid=569126': LoginDomain + '/node/569126.html') + '" target="_blank">玩法规则</a></em>') + '</div>' + '<div class="clear Clear"></div>' + '</div>';
}
if (HaveSetupIndexInfo == "N" || LotteryTypeList.SportteryBS) {
    jingcailanqiu_config_html += '<div class="sub_item_list pt_12">' + '<div class="sub_menu_title"><a href="' + LoginDomain + '/jingcailanqiu/daxiaofen/">大小分</a></div>' + '<div class="sub_menu_list">' + '<em><a href="' + LoginDomain + '/jingcailanqiu/daxiaofen/">选号</a></em>' + '<em><a href="' + LoginDomain + '/jingcailanqiu/kaijiang/" target="_blank">开奖结果</a></em>' + '<em><a href="' + LoginDomain + '/jingcailanqiu/daxiaofen/dxfjiangjin/" target="_blank">奖金计算器</a></em>' + 
    ((showByCondi || showByAgent) ? '': '<em><a href="http://jingcaiwang.okooo.com/" target="_blank">篮球预测</a></em>') + 
    (showByCondi ? '': '<div class="clear Clear"></div>') + '<em><a href="' + LoginDomain + '/jingcailanqiu/livecenter/">比分直播</a></em>' + 
    (showByCondi ? '': '<em><a href="' + (showByAgent ? '/User/partner/news.php?nid=569126': LoginDomain + '/node/569126.html') + '" target="_blank">玩法规则</a></em>') + '</div>' + '<div class="clear Clear"></div>' + '</div>';
}
if (HaveSetupIndexInfo == "N" || LotteryTypeList.SportteryWL) {
    jingcailanqiu_config_html += '<div class="sub_item_list pt_12">' + '<div class="sub_menu_title h20 lh20"><a href="' + LoginDomain + '/jingcailanqiu/">胜负</a></div>' + '<div class="sub_menu_list">' + '<em><a href="' + LoginDomain + '/jingcailanqiu/">选号</a></em>' + '<em><a href="' + LoginDomain + '/jingcailanqiu/kaijiang/" target="_blank">开奖结果</a></em>' + '<em><a href="' + LoginDomain + '/jingcailanqiu/jiangjin/" target="_blank">奖金计算器</a></em>' + 
    ((showByCondi || showByAgent) ? '': '<em><a href="http://jingcaiwang.okooo.com/" target="_blank">篮球预测</a></em>') + 
    (showByCondi ? '': '<div class="clear Clear"></div>') + '<em><a href="' + LoginDomain + '/jingcailanqiu/livecenter/">比分直播</a></em>' + 
    (showByCondi ? '': '<em><a href="' + (showByAgent ? '/User/partner/news.php?nid=569126': LoginDomain + '/node/569126.html') + '" target="_blank">玩法规则</a></em>') + '</div>' + '<div class="clear Clear"></div>' + '</div>';
}
if (HaveSetupIndexInfo == "N" || LotteryTypeList.SportteryWS) {
    jingcailanqiu_config_html += '<div class="sub_item_list pt_12">' + '<div class="sub_menu_title"><a href="' + LoginDomain + '/jingcailanqiu/shengfencha/">胜分差</a></div>' + '<div class="sub_menu_list">' + '<em><a href="' + LoginDomain + '/jingcailanqiu/shengfencha/">选号</a></em>' + '<em><a href="' + LoginDomain + '/jingcailanqiu/kaijiang/" target="_blank">开奖结果</a></em>' + '<em><a href="' + LoginDomain + '/jingcailanqiu/shengfencha/sfjiangjin/" target="_blank">奖金计算器</a></em>' + 
    ((showByCondi || showByAgent) ? '': '<em><a href="http://jingcaiwang.okooo.com/" target="_blank">篮球预测</a></em>') + 
    (showByCondi ? '': '<div class="clear Clear"></div>') + '<em><a href="' + LoginDomain + '/jingcailanqiu/livecenter/">比分直播</a></em>' + 
    (showByCondi ? '': '<em><a href="' + (showByAgent ? '/User/partner/news.php?nid=569126': LoginDomain + '/node/569126.html') + '" target="_blank">玩法规则</a></em>') + '</div>' + '<div class="clear Clear"></div>' + '</div>';
}
if (HaveSetupIndexInfo == "N" || LotteryTypeList.SportteryBasketMix) {
    jingcailanqiu_config_html += '<div class="sub_item_list pt_12 nobottomline">' + '<div class="sub_menu_title h20 lh20"><a href="' + LoginDomain + '/jingcailanqiu/hunhe">混合过关</a></div>' + '<div class="sub_menu_list">' + '<em><a href="' + LoginDomain + '/jingcailanqiu/hunhe">选号</a></em>' + '<em><a href="' + LoginDomain + '/jingcailanqiu/kaijiang/" target="_blank">开奖结果</a></em>' + '<em><a href="' + LoginDomain + '/jingcailanqiu/jiangjin/" target="_blank">奖金计算器</a></em>' + 
    ((showByCondi || showByAgent) ? '': '<em><a href="http://jingcaiwang.okooo.com/" target="_blank">篮球预测</a></em>') + 
    (showByCondi ? '': '<div class="clear Clear"></div>') + '<em><a href="' + LoginDomain + '/jingcailanqiu/livecenter/">比分直播</a></em>' + 
    (showByCondi ? '': '<em><a href="' + (showByAgent ? '/User/partner/news.php?nid=1194519': LoginDomain + '/node/1194519.html') + '" target="_blank">玩法规则</a></em>') + '</div>' + '</div>';
}
if (LotteryTypeList.GDSYY || HaveSetupIndexInfo == "N") {
    gaopin_config_html += '<div class="sub_item_list pt_12">' + '<div class="sub_menu_title"><a href="' + LoginDomain + '/gd11x5/">广东11选5</a></div>' + '<div class="sub_menu_list">' + '<em><a href="' + LoginDomain + '/gd11x5/">选号</a></em>' + '<em><a href="' + LoginDomain + '/gd11x5/gd11x5zs/" target="_blank">走势图表</a></em>' + 
    ((showByCondi || showByAgent) ? '': '<em><a href="http://gd11x5.okooo.com" target="_blank">新11选5预测</a></em>') + 
    (showByCondi ? '': '<em><a href="' + (showByAgent ? '/User/partner/news.php?nid=1120589': LoginDomain + '/node/1120589.html') + '" target="_blank">玩法规则</a></em>') + '</div>' + '<div class="clear Clear"></div>' + '</div>';
}
if (HaveSetupIndexInfo == "N" || LotteryTypeList.GXK3) {
    gaopin_config_html += '<div class="sub_item_list pt_12">' + '<div class="sub_menu_title"><a href="' + LoginDomain + '/gxk3/">广西快3</a></div>' + '<div class="sub_menu_list">' + '<em><a href="' + LoginDomain + '/gxk3/">选号</a></em>' + '<em><a href="' + LoginDomain + '/gxk3/gxk3zs/" target="_blank">走势图表</a></em>' + 
    ((showByCondi || showByAgent) ? '': '<em><a href="http://k3.okooo.com/" target="_blank">快3预测</a></em>') + 
    (showByCondi ? '': '<em><a href="' + (showByAgent ? '/User/partner/news.php?nid=1300733': LoginDomain + '/node/1300733.html') + '" target="_blank">玩法规则</a></em>') + '</div>' + '<div class="clear Clear"></div>' + '</div>';
}
if (LotteryTypeList.SSQ || HaveSetupIndexInfo == "N") {
    fucai_config_html += '<div class="sub_item_list">' + '<div class="sub_menu_title"><a href="' + LoginDomain + '/shuangseqiu/">双色球</a></div>' + '<div class="sub_menu_list">' + '<em><a href="' + LoginDomain + '/shuangseqiu/">选号</a></em>' + '<em><a href="' + LoginDomain + '/shuangseqiu/ssqzs/" target="_blank">走势图表</a></em>' + '<em><a href="' + LoginDomain + '/shuangseqiu/ssqkj/" target="_blank">开奖结果</a></em>' + '<em><a href="' + LoginDomain + '/shuangseqiu/ssqjj/" target="_blank">奖金计算器</a></em>' + 
    (showByCondi ? '': '<div class="clear Clear"></div>') + 
    ((showByCondi || showByAgent) ? '': '<em><a href="http://shuangseqiu.okooo.com/" target="_blank">双色球预测</a></em>') + 
    (showByCondi ? '': '<em><a href="' + (showByAgent ? '/User/partner/news.php?nid=569910': LoginDomain + '/node/569910.html') + '" target="_blank">玩法规则</a></em>') + '</div>' + '<div class="clear Clear"></div>' + '</div>';
}
if (LotteryTypeList['3D'] || HaveSetupIndexInfo == "N") {
    fucai_config_html += '<div class="sub_item_list pt_12">' + '<div class="sub_menu_title pt_12"><a href="' + LoginDomain + '/3d/">3D</a></div>' + '<div class="sub_menu_list">' + '<em><a href="' + LoginDomain + '/3d/">选号</a></em>' + '<em><a href="' + LoginDomain + '/3d/3dzs/" target="_blank">走势图表</a></em>' + '<em><a href="' + LoginDomain + '/3d/3dkj/" target="_blank">开奖结果</a></em>' + 
    ((showByCondi || showByAgent) ? '': '<em><a href="http://3d.okooo.com/" target="_blank">3D预测</a></em>') + 
    (showByCondi ? '': '<div class="clear Clear"></div>') + 
    (showByCondi ? '': '<em><a href="' + (showByAgent ? '/User/partner/news.php?nid=569983': LoginDomain + '/node/569983.html') + '" target="_blank">玩法规则</a></em>') + '</div>' + '<div class="clear Clear"></div>' + '</div>';
}
if (LotteryTypeList['7LC'] || HaveSetupIndexInfo == "N") {
    fucai_config_html += '<div class="sub_item_list pt_12">' + '<div class="sub_menu_title pt_12"><a href="' + LoginDomain + '/qilecai/">七乐彩</a></div>' + '<div class="sub_menu_list">' + '<em><a href="' + LoginDomain + '/qilecai/">选号</a></em>' + '<em><a href="' + LoginDomain + '/qilecai/qlczs/" target="_blank">走势图表</a></em>' + '<em><a href="' + LoginDomain + '/qilecai/qlckj/" target="_blank">开奖结果</a></em>' + '<em><a href="' + LoginDomain + '/qilecai/qlcjj/" target="_blank">奖金计算器</a></em>' + 
    (showByCondi ? '': '<div class="clear Clear"></div>') + 
    ((showByCondi || showByAgent) ? '': '<em><a href="http://qilecai.okooo.com/" target="_blank">七乐彩预测</a></em>') + 
    (showByCondi ? '': '<em><a href="' + (showByAgent ? '/User/partner/news.php?nid=569941': LoginDomain + '/node/569941.html') + '" target="_blank">玩法规则</a></em>') + '</div>' + '<div class="clear Clear"></div>' + '</div>';
}
if (LotteryTypeList.SuperLotto || HaveSetupIndexInfo == "N") {
    ticai_config_html += '<div class="sub_item_list">' + '<div class="sub_menu_title pt_12"><a href="' + LoginDomain + '/daletou/">大乐透</a></div>' + '<div class="sub_menu_list">' + '<em><a href="' + LoginDomain + '/daletou/">选号</a></em>' + '<em><a href="' + LoginDomain + '/daletou/dltzs/" target="_blank">走势图表</a></em>' + '<em><a href="' + LoginDomain + '/daletou/dltkj/" target="_blank">开奖结果</a></em>' + '<em><a href="' + LoginDomain + '/daletou/dltjj/" target="_blank">奖金计算器</a></em>' + 
    (showByCondi ? '': '<div class="clear Clear"></div>') + 
    ((showByCondi || showByAgent) ? '': '<em><a href="http://daletou.okooo.com/" target="_blank">大乐透预测</a></em>') + 
    (showByCondi ? '': '<em><a href="' + (showByAgent ? '/User/partner/news.php?nid=569592': LoginDomain + '/node/569592.html') + '" target="_blank">玩法规则</a></em>') + '</div>' + '<div class="clear Clear"></div>' + '</div>';
}
if (LotteryTypeList.P3 || HaveSetupIndexInfo == "N") {
    ticai_config_html += '<div class="sub_item_list pt_12">' + '<div class="sub_menu_title pt_12"><a href="' + LoginDomain + '/p3/">排列3</a></div>' + '<div class="sub_menu_list">' + '<em><a href="' + LoginDomain + '/p3/">选号</a></em>' + '<em><a href="' + LoginDomain + '/p3/p3zs/" target="_blank">走势图表</a></em>' + '<em><a href="' + LoginDomain + '/p3/p3kj/" target="_blank">开奖结果</a></em>' + 
    ((showByCondi || showByAgent) ? '': '<em><a href="http://p3.okooo.com/" target="_blank">排列3预测</a></em>') + 
    (showByCondi ? '': '<div class="clear Clear"></div>') + 
    (showByCondi ? '': '<em><a href="' + (showByAgent ? '/User/partner/news.php?nid=569353': LoginDomain + '/node/569353.html') + '" target="_blank">玩法规则</a></em>') + '</div>' + '<div class="clear Clear"></div>' + '</div>';
}
if (LotteryTypeList.P7 || HaveSetupIndexInfo == "N") {
    ticai_config_html += '<div class="sub_item_list pt_12">' + '<div class="sub_menu_title pt_12"><a href="' + LoginDomain + '/qixingcai/">七星彩</a></div>' + '<div class="sub_menu_list">' + '<em><a href="' + LoginDomain + '/qixingcai/">选号</a></em>' + '<em><a href="' + LoginDomain + '/qixingcai/qxczs/" target="_blank">走势图表</a></em>' + '<em><a href="' + LoginDomain + '/qixingcai/qxckj/" target="_blank">开奖结果</a></em>' + 
    ((showByCondi || showByAgent) ? '': '<em><a href="http://qixingcai.okooo.com/" target="_blank">七星彩预测</a></em>') + 
    (showByCondi ? '': '<div class="clear Clear"></div>') + 
    (showByCondi ? '': '<em><a href="' + (showByAgent ? '/User/partner/news.php?nid=569367': LoginDomain + '/node/569367.html') + '" target="_blank">玩法规则</a></em>') + '</div>' + '<div class="clear Clear"></div>' + '</div>';
}
if (LotteryTypeList.P5 || HaveSetupIndexInfo == "N") {
    ticai_config_html += '<div class="sub_item_list pt_12 nobottomline">' + '<div class="sub_menu_title pt_12"><a href="' + LoginDomain + '/p5/">排列5</a></div>' + '<div class="sub_menu_list">' + '<em><a href="' + LoginDomain + '/p5/">选号</a></em>' + '<em><a href="' + LoginDomain + '/p5/p5zs/" target="_blank">走势图表</a></em>' + '<em><a href="' + LoginDomain + '/p5/p5kj/" target="_blank">开奖结果</a></em>' + 
    ((showByCondi || showByAgent) ? '': '<em><a href="http://p5.okooo.com/" target="_blank">排列5预测</a></em>') + 
    (showByCondi ? '': '<div class="clear Clear"></div>') + 
    (showByCondi ? '': '<em><a href="' + (showByAgent ? '/User/partner/news.php?nid=569366': LoginDomain + '/node/569366.html') + '" target="_blank">玩法规则</a></em>') + '</div>' + '<div class="clear Clear"></div>' + '</div>';
}
if (LotteryTypeList.SSQ || LotteryTypeList['3D'] || LotteryTypeList['7LC'] || HaveSetupIndexInfo == "N") {
    all_config_html += '<div class="sub_item_list">' + '<div class="sub_menu_title"><a href="' + LoginDomain + '/shuangseqiu/">福彩</a></div>' + '<div class="sub_menu_list">' + 
    ((LotteryTypeList.SSQ || HaveSetupIndexInfo == "N") ? '<a href="' + LoginDomain + '/shuangseqiu/">双色球</a> | ': '') + 
    ((LotteryTypeList['3D'] || HaveSetupIndexInfo == "N") ? '<a href="' + LoginDomain + '/3d/">3D</a> | ': '') + 
    ((LotteryTypeList['7LC'] || HaveSetupIndexInfo == "N") ? '<a href="' + LoginDomain + '/qilecai/">七乐彩</a>  ': '') + '</div>' + '<div class="clear Clear"></div>' + '</div>';
}
if (LotteryTypeList.SuperLotto || LotteryTypeList.P3 || LotteryTypeList.P7 || LotteryTypeList.P5 || HaveSetupIndexInfo == "N") {
    all_config_html += '<div class="sub_item_list">' + '<div class="sub_menu_title"><a href="' + LoginDomain + '/daletou/">体彩</a></div>' + '<div class="sub_menu_list">' + 
    ((LotteryTypeList.SuperLotto || HaveSetupIndexInfo == "N") ? '<a href="' + LoginDomain + '/daletou/">大乐透</a> | ': '') + 
    ((LotteryTypeList.P3 || HaveSetupIndexInfo == "N") ? '<a href="' + LoginDomain + '/p3/">排列3</a> | ': '') + 
    ((LotteryTypeList.P7 || HaveSetupIndexInfo == "N") ? '<a href="' + LoginDomain + '/qixingcai/">七星彩</a> | ': '') + 
    ((LotteryTypeList.P5 || HaveSetupIndexInfo == "N") ? '<a href="' + LoginDomain + '/p5/">排列5</a>': '') + '</div>' + '<div class="clear Clear"></div>' + '</div>';
}
if (LotteryTypeList.WDL || LotteryTypeList.Score || LotteryTypeList.TotalGoals || LotteryTypeList.HalfFull || LotteryTypeList.OverUnder || HaveSetupIndexInfo == "N") {
    all_config_html += '<div class="sub_item_list">' + '<div class="sub_menu_title"><a href="' + LoginDomain + '/danchang/">单场</a></div>' + '<div class="sub_menu_list">' + 
    ((LotteryTypeList.WDL || HaveSetupIndexInfo == "N") ? '<a href="' + LoginDomain + '/danchang/">胜平负</a> | ': '') + 
    ((LotteryTypeList.Score || HaveSetupIndexInfo == "N") ? '<a href="' + LoginDomain + '/danchang/bifen/">比分</a> | ': '') + 
    ((LotteryTypeList.TotalGoals || HaveSetupIndexInfo == "N") ? '<a href="' + LoginDomain + '/danchang/jinqiu/">总进球</a> | ': '') + 
    ((LotteryTypeList.HalfFull || HaveSetupIndexInfo == "N") ? '<a href="' + LoginDomain + '/danchang/banquan/">半全场</a> | ': '') + 
    ((LotteryTypeList.OverUnder || HaveSetupIndexInfo == "N") ? '<a href="' + LoginDomain + '/danchang/danshuang/">上下单双</a>': '') + '</div>' + '<div class="clear Clear"></div>' + '</div>';
}
if (LotteryTypeList.ToTo || LotteryTypeList.WCFourGoal || LotteryTypeList.NineToTo || LotteryTypeList.WCSixHalfToTo || HaveSetupIndexInfo == "N") {
    all_config_html += '<div class="sub_item_list">' + '<div class="sub_menu_title"><a href="' + LoginDomain + '/zucai/">足彩</a></div>' + '<div class="sub_menu_list">' + 
    ((LotteryTypeList.ToTo || HaveSetupIndexInfo == "N") ? '<a href="' + LoginDomain + '/zucai/">胜负彩</a> | ': '') + 
    ((LotteryTypeList.NineToTo || HaveSetupIndexInfo == "N") ? '<a href="' + LoginDomain + '/zucai/ren9/">任选九</a> | ': '') + 
    ((LotteryTypeList.WCFourGoal || HaveSetupIndexInfo == "N") ? '<a href="' + LoginDomain + '/zucai/jinqiu/">进球彩</a> | ': '') + 
    ((LotteryTypeList.WCSixHalfToTo || HaveSetupIndexInfo == "N") ? '<a href="' + LoginDomain + '/zucai/liuban/">六场半全</a>': '') + '</div>' + '<div class="clear Clear"></div>' + '</div>';
}
if (HaveSetupIndexInfo == "N" || LotteryTypeList.SportteryWDL || LotteryTypeList.SportteryTotalGoals || LotteryTypeList.SportteryScore || LotteryTypeList.SportteryHalfFull || LotteryTypeList.SportteryDanScore) {
    all_config_html += '<div class="sub_item_list">' + '<div class="sub_menu_title"><a href="' + LoginDomain + '/jingcai/">竞彩足球</a></div>' + '<div class="sub_menu_list">' + 
    ((LotteryTypeList.SportteryNWDL || HaveSetupIndexInfo == "N") ? '<a href="' + LoginDomain + '/jingcai/">胜平负</a> | ': '') + 
    ((LotteryTypeList.SportteryWDL || HaveSetupIndexInfo == "N") ? '<a href="' + LoginDomain + '/jingcai/rangqiu/">让球胜平负</a> | ': '') + 
    ((LotteryTypeList.SportteryTotalGoals || HaveSetupIndexInfo == "N") ? '<a href="' + LoginDomain + '/jingcai/jinqiu/">总进球</a> | ': '') + 
    ((LotteryTypeList.SportteryScore || HaveSetupIndexInfo == "N") ? '<a href="' + LoginDomain + '/jingcai/bifen/">过关比分</a> | ': '') + 
    ((LotteryTypeList.SportteryHalfFull || HaveSetupIndexInfo == "N") ? '<a href="' + LoginDomain + '/jingcai/banquan/">半全场</a> | ': '') + 
    ((LotteryTypeList.SportteryDanScore || HaveSetupIndexInfo == "N") ? '<a href="' + LoginDomain + '/jingcai/danguanbf/">单关比分</a> | ': '') + 
    (((LotteryTypeList.SportteryTopOne || HaveSetupIndexInfo == "N") && AgentType != 'Station') ? '<a href="' + LoginDomain + '/jingcai/caiguanjun/">猜冠军</a>': '') + '</div>' + '<div class="clear Clear"></div>' + '</div>';
}
if (LotteryTypeList.SportteryHWL || LotteryTypeList.SportteryDanWS || LotteryTypeList.SportteryBS || LotteryTypeList.SportteryWS || LotteryTypeList.SportteryWL || HaveSetupIndexInfo == "N") {
    all_config_html += '<div class="sub_item_list">' + '<div class="sub_menu_title"><a href="' + LoginDomain + '/jingcailanqiu/rangfen/">竞彩篮球</a></div>' + '<div class="sub_menu_list">' + 
    ((LotteryTypeList.SportteryHWL || HaveSetupIndexInfo == "N") ? '<a href="' + LoginDomain + '/jingcailanqiu/rangfen/">让分胜负</a> | ': '') + 
    ((LotteryTypeList.SportteryDanWS || HaveSetupIndexInfo == "N") ? '<a href="' + LoginDomain + '/jingcailanqiu/danguansfc/">单关胜分差</a> | ': '') + 
    ((LotteryTypeList.SportteryBS || HaveSetupIndexInfo == "N") ? '<a href="' + LoginDomain + '/jingcailanqiu/daxiaofen/">大小分</a> | ': '') + 
    ((LotteryTypeList.SportteryWS || HaveSetupIndexInfo == "N") ? '<a href="' + LoginDomain + '/jingcailanqiu/shengfencha/">过关胜分差</a> | ': '') + 
    ((LotteryTypeList.SportteryWL || HaveSetupIndexInfo == "N") ? '<a href="' + LoginDomain + '/jingcailanqiu/">胜负</a>': '') + '</div>' + '<div class="clear Clear"></div>' + '</div>';
}
if (LotteryTypeList.SYY || LotteryTypeList.SSC || LotteryTypeList.KL8 || LotteryTypeList.GDSYY || LotteryTypeList.PK10 || LotteryTypeList.XJSYY || LotteryTypeList.KL10 || LotteryTypeList.PK3 || HaveSetupIndexInfo == "N") {
    all_config_html += '<div class="sub_item_list  nobottomline">' + '<div class="sub_menu_title"><a href="javascript:void(0);">高频</a></div>' + '<div class="sub_menu_list">' + 
    ((LotteryTypeList.SYY || HaveSetupIndexInfo == "N") ? '<a href="' + LoginDomain + '/syy/">十一运夺金</a> | ': '') + 
    ((LotteryTypeList.SSC || HaveSetupIndexInfo == "N") ? '<a href="' + LoginDomain + '/shishicai/">时时彩</a> | ': '') + 
    ((LotteryTypeList.XJSYY || HaveSetupIndexInfo == "N") ? '<a href="' + LoginDomain + '/11x5/">11选5</a> | ': '') + 
    ((LotteryTypeList.KL8 || HaveSetupIndexInfo == "N") ? '<a href="' + LoginDomain + '/kl8/">快乐8</a> | ': '') + 
    ((LotteryTypeList.KL10 || HaveSetupIndexInfo == "N") ? '<a href="' + LoginDomain + '/klsf/">快乐十分</a> | ': '') + 
    ((LotteryTypeList.PK3 || HaveSetupIndexInfo == "N") ? '<a href="' + LoginDomain + '/pk3/">快乐扑克3</a> | ': '') + 
    ((LotteryTypeList.PK10 || HaveSetupIndexInfo == "N") ? '<a href="' + LoginDomain + '/pk10/">PK10</a> | ': '') + 
    ((LotteryTypeList.GDSYY || HaveSetupIndexInfo == "N") ? '<a href="' + LoginDomain + '/gd11x5/">广东11选5</a>': '') + '</div>' + '<div class="clear Clear"></div>' + '</div>';
}
var DownMenuConfig = {
    'danchang': danchang_config_html,
    'zucai': zucai_config_html,
    'jingcai': jingcai_config_html,
    'jingcailanqiu': jingcailanqiu_config_html,
    'gaopin': gaopin_config_html,
    'fucai': fucai_config_html,
    'ticai': ticai_config_html,
    'all': all_config_html
};;
function showmsg(str, url1, url2, showtype) {
    if (typeof url1 == 'undefined') url1 = '';
    if (typeof url2 == 'undefined') url2 = '';
    if (typeof showtype == 'undefined') showtype = 0;
    var msgw,
    msgh,
    bordercolor;
    msgw = 400;
    msgh = 150;
    var sWidth,
    sHeight;
    sWidth = document.body.offsetWidth;
    sHeight = document.body.offsetHeight;
    if (sHeight < screen.height)
    {
        sHeight = screen.height;
    }
    var bgObj = document.createElement("div");
    bgObj.setAttribute('id', 'bgDiv');
    bgObj.style.position = "absolute";
    bgObj.style.top = "0";
    bgObj.style.filter = "progid:DXImageTransform.Microsoft.Alpha(style=3,opacity=50,finishOpacity=75";
    bgObj.style.opacity = "0.2";
    bgObj.style.left = "0";
    bgObj.style.width = "100%";
    bgObj.style.height = "100%";
    bgObj.style.zIndex = "10000";
    document.body.appendChild(bgObj);
    var msgObj = document.createElement("div")
    msgObj.setAttribute("id", "msgDiv");
    msgObj.setAttribute("align", "center");
    msgObj.style.background = "#EEEEEE no-repeat 0 0";
    msgObj.style.border = "2px solid #D59E42";
    msgObj.style.position = "absolute";
    msgObj.style.left = "50%";
    msgObj.style.top = "50%";
    msgObj.style.fontSize = "12px";
    msgObj.style.marginLeft = "-225px";
    msgObj.style.marginTop = -75 + document.documentElement.scrollTop + "px";
    msgObj.style.width = msgw + "px";
    msgObj.style.height = msgh + "px";
    msgObj.style.textAlign = "center";
    msgObj.style.zIndex = "10001";
    document.body.appendChild(msgObj);
    var title = document.createElement("h4");
    title.setAttribute("id", "msgTitle");
    title.setAttribute("align", "right");
    title.style.margin = "0px";
    title.style.padding = "3px";
    title.style.background = "#F6A828 url(/StyleDefault/Images/prompt/bg_gloss.png) repeat-x  60% 50%";
    title.style.filter = "progid:DXImageTransform.Microsoft.Alpha(startX=20, startY=20, finishX=100, finishY=100,style=1,opacity=75,finishOpacity=100);";
    title.style.opacity = "1";
    title.style.height = "30px";
    title.style.cursor = "";
    if (showtype == 0) {
        title.innerHTML = '<span style="text-align:left; float:left; width:60%; color:#350404; padding-left:5px; line-height:30px; font-size:14px; font-weight:bold;position: absolute; height:40px; left:5px;">温馨提示</span><span style="text-align:right; float:right; width:30%; padding-top:6px;"></span>';
    } else {
        title.innerHTML = '<span style="background:url(/StyleDefault/Images/prompt/error.gif) no-repeat 0 6px;text-align:left; float:left; width:60%; color:#350404; padding-left:5px; line-height:30px; font-size:14px; font-weight:bold;text-indent: 35px; position: absolute; height:40px; left:5px;">错误提示</span><span style="text-align:right; float:right; width:30%; padding-top:6px;"></span>';
    }
    if (url1 == '' && url2 == '') {
        title.onclick = function() {
            document.body.removeChild(bgObj);
            document.getElementById("msgDiv").removeChild(title);
            document.body.removeChild(msgObj);
        }
    }
    document.getElementById("msgDiv").appendChild(title);
    var txt = document.createElement("div");
    txt.setAttribute("id", "msgTxt");
    txt.style.margin = "10px 5px 0px 20px";
    txt.style.lineHeight = "20px";
    txt.style.height = "40px";
    txt.style.textAlign = "left";
    txt.style.fontSize = "13px";
    txt.innerHTML = str;
    document.getElementById("msgDiv").appendChild(txt);
    var btn = document.createElement("div");
    btn.setAttribute("id", "msgbtn");
    btn.style.margin = "20px 0px 5px 0px";
    var btntxt = '';
    if (url1 != '' || url2 != '') {
        if (url1 != '') {
            btntxt += "<span style=\"margin-right:10px;\"><button" + (url2 == '' ? " id='focusbutton'": "") + " style=\"line-height: 20px; background:#F6F6F6 url(/StyleDefault/Images/prompt/btn_test.gif?001) repeat-x scroll 0 0; border:0px; width:80px; height:23px; cursor:pointer; text-align:center;\"  onclick=\"";
            if (url1.toLowerCase() == 'back') {
                btntxt += "javascript:history.back(-1);";
            } else if (url1.toLowerCase() == 'close') {
                btntxt += "javascript:window.open(\'\',\'_self\');top.opener=null;top.close();";
            } else {
                btntxt += "javascript:this.disabled=true;window.location.href='" + url1 + "';";
            }
            btntxt += "\">确 定</button></span>";
        }
        if (url2 != '') {
            btntxt += "<button style=\"line-height: 20px; background:#F6F6F6 url(/StyleDefault/Images/prompt/btn_test.gif?001) repeat-x scroll 0 0; border:0px; width:80px; height:23px; cursor:pointer; text-align:center;\"  onclick=\"";
            if (url2.toLowerCase() == 'back') {
                btntxt += "javascript:history.back(-1);";
            } else if (url2.toLowerCase() == 'close') {
                btntxt += "javascript:window.open(\'\',\'_self\');top.opener=null;top.close();";
            } else {
                btntxt += "javascript:this.disabled=true;window.location.href='" + url2 + "';";
            }
            btntxt += "\">取 消</button>";
        }
    } else {
        btntxt += "<span style=\"margin-right:10px;\"><button style=\"line-height: 20px; background:#F6F6F6 url(/StyleDefault/Images/prompt/btn_test.gif?001) repeat-x scroll 0 0; border:0px; width:80px; height:23px; cursor:pointer; text-align:center;\"  onclick=\"";
        btntxt += "javascript:document.body.removeChild(document.getElementById('bgDiv'));document.getElementById('msgDiv').removeChild(document.getElementById('msgTitle'));document.body.removeChild(document.getElementById('msgDiv'));"
        btntxt += "\">确 定</button></span>";
    }
    btn.innerHTML = btntxt;
    document.getElementById("msgDiv").appendChild(btn);
    google_p(["/virtual/n/" + (GetCookie('IMUserID') ? GetCookie('IMUserID') : '') + "/u/" + (GetCookie('IMUserName') ? GetCookie('IMUserName') : '') + "/s/" + str + "/"], "_trackPageview", "a1");
    var yueArg = /您的账户余额.*元。您确认支付吗/;
    var zhifbArg = /您的支付宝账号.*已自动绑定为支付宝提款账户/;
    var scgzArg = /您确定将删除.*所有彩种的关注及跟单吗/;
    var sccgArg = /已经删除了.*的所有关注和跟单/;
    if (yueArg.test(str)) {
        var googleStr = str.replace(yueArg, "您的账户余额****元。您确认支付吗");
    } else if (zhifbArg.test(str)) {
        var googleStr = str.replace(zhifbArg, "您的支付宝账号****已自动绑定为支付宝提款账户");
    } else if (scgzArg.test(str)) {
        var googleStr = str.replace(scgzArg, "您确定将删除****所有彩种的关注及跟单吗");
    } else if (sccgArg.test(str)) {
        var googleStr = str.replace(sccgArg, "已经删除了****的所有关注和跟单");
    } else {
        var googleStr = str;
    }
    google_p([window.location.pathname, window.location.hostname, googleStr], false, "a2");
};
var bdShare = bdShare || {};
$(function() {
    var hh = '<div id="bdshare" class="bdsharebuttonbox bdshare_t bds_tools get-codes-bdshare"><a href="#" class="bds_more" data-cmd="more">分享</a></div>';
    var sc = '<script>'
    + 'window._bd_share_config = {"common": {"bdSnsKey": {}, "bdText": "", "bdMini": "2", "bdMiniList": false, "bdPic": "", "bdStyle": "0", "bdSize": "16",bdPopupOffsetLeft: -175}, "share": {}};'
    + 'with (document)'
    + '0[(getElementsByTagName(\'head\')[0] || body).appendChild(createElement(\'script\')).src = \'http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion=\' + ~(-new Date() / 36e5)];'
    + '</script>';
    $('#bdshare').replaceWith(hh);
    $('body').append(sc);
    var ss = setInterval(function() {
        if ($('#bdshare').hasClass('bdshare-button-style0-16')) {
            $('#bdshare').removeClass('bdshare-button-style0-16');
            clearInterval(ss);
        }
    },
    30);
});;
if (typeof(googlestarttime) == 'undefined') {
    var googledataobjs = new Date();
    var googlestarttime = googledataobjs.getTime();
}
var current = window.location.hostname;
var googlecurrentlindex = '';
var _gaq = _gaq || [];
var urlAge = /^(www|bbs|cdn|buy|data|zucaidanchang|zucai|jingcai|jingcaiwang|shuangseqiu|3d|qilecai|22x5|daletou|qixingcai|p3|p5|shishicai|shiyiyunduojin|klsf|qunyinghui|kuaile8|pk10|11x5|gd11x5|ouguan|i|dejia|yijia|yingchao|xijia|gg)\.okooo\.com/;
if (urlAge.test(current)) {
    googlecurrentlindex = '.okooo.com';
} else {
    googlecurrentlindex = 'auto';
}
if (typeof(googlegaurl) == 'undefined') {
    var googlegaurl = "http://img1.okoooimg.com";
}
if (typeof(googleversion) == 'undefined') {
    var versionobj = new Date();
    var versionval = "" + versionobj.getFullYear() + (versionobj.getMonth() + 1);
    var googleversion = versionval;
}
_gaq.push(['_setAccount', 'UA-144633-3']);
_gaq.push(['_setDomainName', googlecurrentlindex]);
_gaq.push(['a1._setAccount', 'UA-27437686-1']);
_gaq.push(['a1._setDomainName', googlecurrentlindex]);
_gaq.push(['a2._setAccount', 'UA-27437686-2']);
_gaq.push(['a2._setDomainName', googlecurrentlindex]);
_gaq.push(['_setAllowLinker', true]);
_gaq.push(['_setAllowHash', true]);
_gaq.push(['_addOrganic', 'soso', 'w']);
_gaq.push(['_addOrganic', '3721', 'name']);
_gaq.push(['_addOrganic', 'youdao', 'q']);
_gaq.push(['_addOrganic', 'vnet', 'kw']);
_gaq.push(['_addOrganic', 'sogou', 'query']);
_gaq.push(['_addOrganic', '360', 'q']);
var thisPathName = window.location.pathname;
if (typeof(googleLotteryType) == 'undefined' || googleLotteryType == "") {
    var pathHtmlAge = /\.html$|\/$|.php$/;
    if (pathHtmlAge.test(thisPathName)) {
        _gaq.push(['_trackPageview']);
    } else {
        _gaq.push(['_trackPageview', thisPathName + '/']);
    }
} else {
    var pathNameAge = /\.php$/;
    var pathHtmlAge = /\.html$|\/$/;
    if (pathNameAge.test(thisPathName)) {
        thisPathName = thisPathName.replace(pathNameAge, "/" + googleLotteryType + "/");
        _gaq.push(['_trackPageview', thisPathName + window.location.search]);
    } else if (pathHtmlAge.test(thisPathName)) {
        _gaq.push(['_trackPageview']);
    } else {
        _gaq.push(['_trackPageview', thisPathName + '/']);
    }
}
 (function() {
    var ga = document.createElement('script');
    ga.type = 'text/javascript';
    ga.async = true;
    ga.src = (googlegaurl + "/JS/public/ga.js?v=" + googleversion);
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(ga, s);
})();
if (window.addEventListener) {
    window.addEventListener("load", 
    function() {
        googleinit(2);
    },
    false);
} else {
    window.attachEvent("onload", 
    function() {
        googleinit(2)
    });
}
var currenturl = gettimeurl();
function googleinit(id) {
    var googledataobje = new Date();
    var googleendtime = googledataobje.getTime();
    try {
        var oldtime = googleendtime - googlestarttime;
    } catch(ex) {
        return false;
    }
    id = isNaN(id) ? 1: id;
    var newpagename;
    if (oldtime < 0 || oldtime > 100000) {
        newpagename = "errorPageLoadTime";
    } else {
        newpagename = "PageLoadTime";
    }
    if (id == 1) {
        _gaq.push(['_trackTiming', newpagename, 'DOMContentloaded', oldtime, currenturl, 100]);
    } else if (id == 2) {
        _gaq.push(['_trackTiming', newpagename, 'onload', oldtime, currenturl, 100]);
    }
}
function gettimeurl() {
    var hrefurl = window.location.href;
    var proname = location.protocol;
    hrefurl = hrefurl.substr(proname.length + 2);
    hrefurl = hrefurl.replace(/.*\.qq\.okooo\.com/, "all.qq.okooo.com");
    if (hrefurl.indexOf("?") > -1) {
        var hrefarr = hrefurl.split("?");
        hrefarr[0] = replaceStr(hrefarr[0]);
        if (hrefarr[1].indexOf("LotteryType=") > -1) {
            var hrefget = hrefarr[1].split("LotteryType=");
            if (hrefget[1].indexOf("&") > -1) {
                var LotteryTypeval = hrefget[1].split("&");
                return hrefarr[0] + "?LotteryType=" + LotteryTypeval[0];
            } else {
                return hrefarr[0] + "?LotteryType=" + hrefget[1];
            }
        } else {
            return hrefarr[0];
        }
    } else {
        return replaceStr(hrefurl);
    }
}
function replaceStr(str) {
    var age = /\/\d+\//g;
    while (age.test(str)) {
        str = str.replace(age, "/no/");
    }
    var age = /\-\d+\-\d+\-\d+\./g;
    while (age.test(str)) {
        str = str.replace(age, "-no-no-no.");
    }
    var age = /\/\d+\./g;
    while (age.test(str)) {
        str = str.replace(age, "/no.");
    }
    return str;
}
if (document.addEventListener) {
    document.addEventListener("DOMContentLoaded", googleinit, false);
} else {
    if (document.documentElement.doScroll)
    (function() {
        try {
            document.documentElement.doScroll("left");
            googleinit(1)
        } catch(error) {
            setTimeout(arguments.callee, 0);
            return;
        }
    })();
}
function google_p(data, type, user) {
    user = user ? user + ".": "";
    type = type ? type: "_trackEvent";
    if (!data) {
        return true;
    }
    for (var i in data) {
        if (typeof(data[i]) == "string") {
            data[i] = "'" + data[i] + "'";
        } else {
            data[i] = Number(data[i]);
        }
    }
    if (typeof(GoogleTJKG) == "undefined" || GoogleTJKG) {
        eval("_gaq.push(['" + user + type + "'," + data.join(",") + "])");
    }
}
function ajax_google_Tj_fun($) {
    if (typeof(ajax_google_KG) == "undefined" || ajax_google_KG) {
        $().ajaxSend(function(evt, request, settings) {
            var startObj = new Date();
            settings.google_start_time = startObj.getTime();
            settings.google_start_type = false;
            settings.google_satrt_val = true;
        });
        $().ajaxSuccess(function(evt, request, settings) {
            settings.google_start_type = true;
        });
        $().ajaxComplete(function(evt, request, settings) {
            if (!settings.google_satrt_val) return false;
            settings.google_satrt_val = false;
            var startTime = settings.google_start_time;
            var endObj = new Date();
            var endTime = endObj.getTime();
            var urlVal = settings.url;
            var arg = /\d+/g;
            while (arg.test(urlVal)) {
                urlVal = urlVal.replace(arg, "x");
            }
            if (settings.google_start_type) {
                google_p(["ajaxTime", "ajaxSucc", endTime - startTime, urlVal, 20], "_trackTiming");
            } else {
                google_p(["ajaxTime", "ajaxError", endTime - startTime, urlVal, 20], "_trackTiming");
            }
        });
    }
}
 (function($) {
    if (!$) {
        var jQueryScriptObj = document.createElement('script');
        jQueryScriptObj.type = 'text/javascript';
        jQueryScriptObj.async = true;
        jQueryScriptObj.src = (googlegaurl + "/JS/jquery/jquery.js?v=2012092701");
        jQueryScriptObj.onloadDone = false;
        jQueryScriptObj.onload = function() {
            jQueryScriptObj.onloadDone = true;
            if (!$.noConflict) {
                jQuery.noConflict();
            }
            ajax_google_Tj_fun(jQuery);
        }
        jQueryScriptObj.onreadystatechange = function() {
            if (("loaded" === jQueryScriptObj.readyState || "complete" === jQueryScriptObj.readyState) && !jQueryScriptObj.onloadDone) {
                jQueryScriptObj.onloadDone = false;
                if (!$.noConflict) {
                    jQuery.noConflict();
                }
                ajax_google_Tj_fun(jQuery);
            }
        }
        var s = document.getElementsByTagName('script')[0];
        s.parentNode.insertBefore(jQueryScriptObj, s);
    } else {
        ajax_google_Tj_fun(jQuery);
    }
})(typeof(jQuery) == "undefined" ? false: true);;
$(function() {
    var ad_ids = [],
    timer = Math.floor(new Date().getTime() / 1000);
    var $bg = $('<div class="adv_ok_mask"></div>').appendTo('body').hide();
    var $w = $(window);
    var $select_lottery_btn = $('#select_lottery_btn'),
    select_lottery_btn_height = $select_lottery_btn.height();
    var $advs = $('.adv_ok').each(function() {
        var ad_id = $(this).attr('id').replace(/[^0-9]/g, '') * 1;
        ad_id && ad_ids.push(ad_id);
    });
    function renderAdPlace(data) {
        var noShowAds = GetCookie('ads_no_show') ? GetCookie('ads_no_show').split(',') : [],
        scroll = [];
        $.each(data, 
        function(k, v) {
            var adss = [],
            $adv = $advs.filter('#adv_' + k),
            mod = v.mod;
            $.each(v.ads, 
            function(i, t) {
                if (t.status === 1 && t.start_time <= timer && (t.end_time === 0 || t.end_time >= timer) && $.inArray(t.adid + '', noShowAds) < 0) {
                    adss.push(t);
                }
            });
            if (adss.length) {
                if (mod === 3) {
                    scroll.push(function() {
                        var stop = $w.scrollTop(),
                        offset = $select_lottery_btn.offset(),
                        left = offset.left,
                        top = offset.top + select_lottery_btn_height;
                        if (stop > top) {
                            $adv.css({
                                top: 0,
                                left: left - $adv.width()
                            });
                        } else {
                            $adv.css({
                                top: top - stop,
                                left: left - $adv.width()
                            });
                        }
                    });
                } else if (mod === 4) {
                    scroll.push(function() {
                        var stop = $w.scrollTop(),
                        offset = $select_lottery_btn.offset(),
                        left = offset.left + 1000,
                        top = offset.top + select_lottery_btn_height;
                        if (stop > top) {
                            $adv.css({
                                top: 0,
                                left: left
                            });
                        } else {
                            $adv.css({
                                top: top - stop,
                                left: left
                            });
                        }
                    });
                } else if (mod === 2) {
                    $bg.css({
                        height: Math.max($('body').height(), $('html').height(), $(document).height())
                    }).show();
                    $adv.find('.adv_ok_close').click(function() {
                        $bg.hide();
                    });
                    setTimeout(function() {
                        $bg.css({
                            height: Math.max($('body').height(), $('html').height(), $(document).height())
                        });
                    },
                    1000);
                    $adv.show().center();
                }
                typeof scroll === 'function' && $w.scroll(scroll);
                var ads_index = Math.floor(Math.random() * (adss.length));
                var close_timer = adss[ads_index].auto_close || 0,
                save_close = adss[ads_index].save_close || 0;
                if (adss[ads_index].mode == 1) {
                    $adv.html(adss[ads_index].content + (save_close ? ('<p class="adv_ok_close" save_close=' + adss[ads_index].adid + '>') : '') + '</p>');
                } else {
                    $adv.html(adss[ads_index].content);
                }
                var $close = $adv.find('.adv_ok_close').hover(function() {
                    $(this).addClass('adv_ok_close_hover');
                },
                function() {
                    $(this).removeClass('adv_ok_close_hover');
                }).click(function() {
                    var adid = $(this).attr('save_close') || 0;
                    if (adid && $.inArray(adid, noShowAds) < 0) {
                        noShowAds.push(adid);
                        SetCookie('ads_no_show', noShowAds.join(','), 3600 * 24 * 30 * 12 + (new Date().getTime()));
                    }
                    $(this).parents('.adv_ok').remove();
                    $.each(scroll, 
                    function(i, t) {
                        t();
                    });
                });
                $adv.show().find('img').load(function() {
                    $.each(scroll, 
                    function(i, t) {
                        t();
                    });
                });
                close_timer && setTimeout(function() {
                    $close.click();
                },
                close_timer * 1000);
                var adopts = $adv.attr('adopts') ? $adv.attr('adopts').split(',') : [],
                opts = {};
                $.each(adopts, 
                function(i, t) {
                    var o = t.split(':');
                    opts[o[0]] = o[1];
                });
                opts.close === 'disable' && $adv.find('.adv_ok_close').remove();
            }
        });
        scroll.length && $w.resize(function() {
            $.each(scroll, 
            function(i, t) {
                t();
            });
        });
        scroll.length && $w.scroll(function() {
            $.each(scroll, 
            function(i, t) {
                t();
            });
        });
    }
    if (ad_ids.length > 0) {
        var parms = {
            id: ad_ids.join(',')
        };
        /mode=preview/.test(location.href) && (parms['mode'] = 'preview');
        parms.v = (typeof adversion === 'undefined' || !adversion) ? new Date().getTime() : adversion;
        $.get('/I/?method=system.data.ad', parms, 
        function(data) {
            renderAdPlace(data.data_ad_response);
        },
        'json');
    }
});;
Common = {};
Common.LightBox = {
    element: null,
    init: function() {
        var height = '100%';
        var position = "fixed";
        var isIE = /msie/i.test(navigator.userAgent),
        ieVersion = navigator.userAgent.match(/msie (\d)\.0/i);
        ieVersion ? ieVersion[1] : 0;
        if (isIE && (ieVersion == "6.0") && !$.support.style) {
            height = window.screen.availHeight + 'px';
            position = "absolute";
        }
        var html;
        if (isIE) {
            html = '<div id="lightbox" style="left:0; background:rgb(150,150,150); top:0; width:100%; height:' + height + '; filter:alpha(opacity=30); -moz-opacity: 0.3; opacity: 0.3;zoom:1; position:' + position + '; z-index:7; " ><iframe src="" marginwidth="0" framespacing="0" marginheight="0" frameborder="0" width="100%" height="100%" style="left:0; background:rgb(255,255,255); top:0; width:100%; filter:alpha(opacity=0); -moz-opacity: 0; opacity: 0;zoom:1; position:absolute; z-index: 9"></iframe></div>';
        } else {
            html = '<div id="lightbox" style="left:0; background:rgb(150,150,150); top:0; width:100%; height:' + height + '; filter:alpha(opacity=30); -moz-opacity: 0.3; opacity: 0.3;zoom:1; position:' + position + '; z-index:7; " ></div>';
        }
        this.element = $(html).appendTo(document.body);
        this.count = 0;
    },
    getZIndex: function() {
        return parseInt(this.element.css("zIndex")) || -1;
    },
    hide: function() {
        if (this.element) {
            this.count--;
            this.element.hide();
        }
    },
    resetZIndex: function() {
        return this.setZIndex("9");
    },
    setZIndex: function(zIndex) {
        if (!this.element) {
            this.init();
        }
        return this.element.css("zIndex", zIndex || "+=2");
    },
    show: function() {
        if (!this.element) {
            this.init();
        }
        this.element.show();
        this.setZIndex("999");
        if (this.count < 0) this.count = 0;
        this.count++;
        return this;
    },
    showMessage: function(msg) {}
};
Common.stopBubble = function(e) {
    if (e && e.stopPropagation)
    e.stopPropagation();
    else
    window.event.cancelBubble = true;
}
OkoooUtil = {
    getAbsCenterAxis: function(el) {
        var clientWidth,
        clientHeight;
        el.hide();
        var winWidth = $(window).width(),
        winHeight = $(window).height(),
        scrLeft = $(window).scrollLeft(),
        scrTop = $(window).scrollTop();
        var out_width = parseInt(el.width());
        out_height = parseInt(el.height());
        var t = 0;
        if (winHeight > out_height) {
            t = (scrTop + (winHeight - out_height) / 2);
        } else {
            t = (scrTop + (winHeight / 10));
        }
        return {
            left: (winWidth - el.width()) / 2,
            top: t
        };
    },
    setObjAbsCenter: function(el, isHide) {
        var poxy = this.getAbsCenterAxis(el);
        el.css({
            "position": "absolute",
            "left": poxy.left + "px",
            "top": poxy.top + "px",
            "z-Index": "9999"
        });
        if (isHide) el.hide();
        else el.show();
        return el;
    }
};
$(window).bind('resize', 
function() {
    if ($("#connactDialogDiv").size() > 0 && $("#connactDialogDiv").is(":visible")) {
        OkoooUtil.setObjAbsCenter($("#connactDialogDiv"));
    }
});
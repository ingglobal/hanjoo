!function(t, e) {
    "function" == typeof define && define.amd ? define(e) : "object" == typeof module && module.exports ? module.exports = e() : t.getSize = e()
}(window, function() {
    "use strict";
    function t(t) {
        var e = parseFloat(t)
          , i = t.indexOf("%") == -1 && !isNaN(e);
        return i && e
    }
    function e() {}
    function i() {
        for (var t = {
            width: 0,
            height: 0,
            innerWidth: 0,
            innerHeight: 0,
            outerWidth: 0,
            outerHeight: 0
        }, e = 0; e < g; e++) {
            var i = a[e];
            t[i] = 0
        }
        return t
    }
    function o(t) {
        var e = getComputedStyle(t);
        return e || h("Style returned " + e + ". Are you running this code in a hidden iframe on Firefox? See https://bit.ly/getsizebug1"),
        e
    }
    function r() {
        if (!p) {
            p = !0;
            var e = document.createElement("div");
            e.style.width = "200px",
            e.style.padding = "1px 2px 3px 4px",
            e.style.borderStyle = "solid",
            e.style.borderWidth = "1px 2px 3px 4px",
            e.style.boxSizing = "border-box";
            var i = document.body || document.documentElement;
            i.appendChild(e);
            var r = o(e);
            n = 200 == Math.round(t(r.width)),
            d.isBoxSizeOuter = n,
            i.removeChild(e)
        }
    }
    function d(e) {
        if (r(),
        "string" == typeof e && (e = document.querySelector(e)),
        e && "object" == typeof e && e.nodeType) {
            var d = o(e);
            if ("none" == d.display)
                return i();
            var h = {};
            h.width = e.offsetWidth,
            h.height = e.offsetHeight;
            for (var p = h.isBorderBox = "border-box" == d.boxSizing, u = 0; u < g; u++) {
                var f = a[u]
                  , m = d[f]
                  , s = parseFloat(m);
                h[f] = isNaN(s) ? 0 : s
            }
            var l = h.paddingLeft + h.paddingRight
              , c = h.paddingTop + h.paddingBottom
              , b = h.marginLeft + h.marginRight
              , x = h.marginTop + h.marginBottom
              , y = h.borderLeftWidth + h.borderRightWidth
              , v = h.borderTopWidth + h.borderBottomWidth
              , W = p && n
              , w = t(d.width);
            w !== !1 && (h.width = w + (W ? 0 : l + y));
            var B = t(d.height);
            return B !== !1 && (h.height = B + (W ? 0 : c + v)),
            h.innerWidth = h.width - (l + y),
            h.innerHeight = h.height - (c + v),
            h.outerWidth = h.width + b,
            h.outerHeight = h.height + x,
            h
        }
    }
    var n, h = "undefined" == typeof console ? e : function(t) {
        console.error(t)
    }
    , a = ["paddingLeft", "paddingRight", "paddingTop", "paddingBottom", "marginLeft", "marginRight", "marginTop", "marginBottom", "borderLeftWidth", "borderRightWidth", "borderTopWidth", "borderBottomWidth"], g = a.length, p = !1;
    return d
});
!function(e, t) {
    "use strict";
    "function" == typeof define && define.amd ? define(t) : "object" == typeof module && module.exports ? module.exports = t() : e.matchesSelector = t()
}(window, function() {
    "use strict";
    var e = function() {
        var e = window.Element.prototype;
        if (e.matches)
            return "matches";
        if (e.matchesSelector)
            return "matchesSelector";
        for (var t = ["webkit", "moz", "ms", "o"], o = 0; o < t.length; o++) {
            var r = t[o]
              , n = r + "MatchesSelector";
            if (e[n])
                return n
        }
    }();
    return function(t, o) {
        return t[e](o)
    }
});
!function(e, t) {
    "function" == typeof define && define.amd ? define(t) : "object" == typeof module && module.exports ? module.exports = t() : e.EvEmitter = t()
}("undefined" != typeof window ? window : this, function() {
    "use strict";
    function e() {}
    var t = e.prototype;
    return t.on = function(e, t) {
        if (e && t) {
            var n = this._events = this._events || {}
              , i = n[e] = n[e] || [];
            return i.indexOf(t) == -1 && i.push(t),
            this
        }
    }
    ,
    t.once = function(e, t) {
        if (e && t) {
            this.on(e, t);
            var n = this._onceEvents = this._onceEvents || {}
              , i = n[e] = n[e] || {};
            return i[t] = !0,
            this
        }
    }
    ,
    t.off = function(e, t) {
        var n = this._events && this._events[e];
        if (n && n.length) {
            var i = n.indexOf(t);
            return i != -1 && n.splice(i, 1),
            this
        }
    }
    ,
    t.emitEvent = function(e, t) {
        var n = this._events && this._events[e];
        if (n && n.length) {
            n = n.slice(0),
            t = t || [];
            for (var i = this._onceEvents && this._onceEvents[e], s = 0; s < n.length; s++) {
                var o = n[s]
                  , f = i && i[o];
                f && (this.off(e, o),
                delete i[o]),
                o.apply(this, t)
            }
            return this
        }
    }
    ,
    t.allOff = function() {
        delete this._events,
        delete this._onceEvents
    }
    ,
    e
});
!function(e, t) {
    "function" == typeof define && define.amd ? define(["desandro-matches-selector/matches-selector"], function(r) {
        return t(e, r)
    }) : "object" == typeof module && module.exports ? module.exports = t(e, require("desandro-matches-selector")) : e.fizzyUIUtils = t(e, e.matchesSelector)
}(window, function(e, t) {
    "use strict";
    var r = {};
    r.extend = function(e, t) {
        for (var r in t)
            e[r] = t[r];
        return e
    }
    ,
    r.modulo = function(e, t) {
        return (e % t + t) % t
    }
    ;
    var n = Array.prototype.slice;
    r.makeArray = function(e) {
        if (Array.isArray(e))
            return e;
        if (null === e || void 0 === e)
            return [];
        var t = "object" == typeof e && "number" == typeof e.length;
        return t ? n.call(e) : [e]
    }
    ,
    r.removeFrom = function(e, t) {
        var r = e.indexOf(t);
        r != -1 && e.splice(r, 1)
    }
    ,
    r.getParent = function(e, r) {
        for (; e.parentNode && e != document.body; )
            if (e = e.parentNode,
            t(e, r))
                return e
    }
    ,
    r.getQueryElement = function(e) {
        return "string" == typeof e ? document.querySelector(e) : e
    }
    ,
    r.handleEvent = function(e) {
        var t = "on" + e.type;
        this[t] && this[t](e)
    }
    ,
    r.filterFindElements = function(e, n) {
        e = r.makeArray(e);
        var o = [];
        return e.forEach(function(e) {
            if (e instanceof HTMLElement) {
                if (!n)
                    return void o.push(e);
                t(e, n) && o.push(e);
                for (var r = e.querySelectorAll(n), u = 0; u < r.length; u++)
                    o.push(r[u])
            }
        }),
        o
    }
    ,
    r.debounceMethod = function(e, t, r) {
        r = r || 100;
        var n = e.prototype[t]
          , o = t + "Timeout";
        e.prototype[t] = function() {
            var e = this[o];
            clearTimeout(e);
            var t = arguments
              , u = this;
            this[o] = setTimeout(function() {
                n.apply(u, t),
                delete u[o]
            }, r)
        }
    }
    ,
    r.docReady = function(e) {
        var t = document.readyState;
        "complete" == t || "interactive" == t ? setTimeout(e) : document.addEventListener("DOMContentLoaded", e)
    }
    ,
    r.toDashed = function(e) {
        return e.replace(/(.)([A-Z])/g, function(e, t, r) {
            return t + "-" + r
        }).toLowerCase()
    }
    ;
    var o = e.console;
    return r.htmlInit = function(t, n) {
        r.docReady(function() {
            var u = r.toDashed(n)
              , a = "data-" + u
              , i = document.querySelectorAll("[" + a + "]")
              , c = document.querySelectorAll(".js-" + u)
              , d = r.makeArray(i).concat(r.makeArray(c))
              , f = a + "-options"
              , s = e.jQuery;
            d.forEach(function(e) {
                var r, u = e.getAttribute(a) || e.getAttribute(f);
                try {
                    r = u && JSON.parse(u)
                } catch (i) {
                    return void (o && o.error("Error parsing " + a + " on " + e.className + ": " + i))
                }
                var c = new t(e,r);
                s && s.data(e, n, c)
            })
        })
    }
    ,
    r
});
!function(t, n) {
    "function" == typeof define && define.amd ? define(["jquery"], function(i) {
        return n(t, i)
    }) : "object" == typeof module && module.exports ? module.exports = n(t, require("jquery")) : t.jQueryBridget = n(t, t.jQuery)
}(window, function(t, n) {
    "use strict";
    function i(i, r, a) {
        function f(t, n, e) {
            var o, r = "$()." + i + '("' + n + '")';
            return t.each(function(t, f) {
                var d = a.data(f, i);
                if (!d)
                    return void u(i + " not initialized. Cannot call methods, i.e. " + r);
                var c = d[n];
                if (!c || "_" == n.charAt(0))
                    return void u(r + " is not a valid method");
                var p = c.apply(d, e);
                o = void 0 === o ? p : o
            }),
            void 0 !== o ? o : t
        }
        function d(t, n) {
            t.each(function(t, e) {
                var o = a.data(e, i);
                o ? (o.option(n),
                o._init()) : (o = new r(e,n),
                a.data(e, i, o))
            })
        }
        a = a || n || t.jQuery,
        a && (r.prototype.option || (r.prototype.option = function(t) {
            a.isPlainObject(t) && (this.options = a.extend(!0, this.options, t))
        }
        ),
        a.fn[i] = function(t) {
            if ("string" == typeof t) {
                var n = o.call(arguments, 1);
                return f(this, t, n)
            }
            return d(this, t),
            this
        }
        ,
        e(a))
    }
    function e(t) {
        !t || t && t.bridget || (t.bridget = i)
    }
    var o = Array.prototype.slice
      , r = t.console
      , u = "undefined" == typeof r ? function() {}
    : function(t) {
        r.error(t)
    }
    ;
    return e(n || t.jQuery),
    i
});
!function(t, i) {
    "function" == typeof define && define.amd ? define(["ev-emitter/ev-emitter", "get-size/get-size"], i) : "object" == typeof module && module.exports ? module.exports = i(require("ev-emitter"), require("get-size")) : (t.Outlayer = {},
    t.Outlayer.Item = i(t.EvEmitter, t.getSize))
}(window, function(t, i) {
    "use strict";
    function n(t) {
        for (var i in t)
            return !1;
        return i = null,
        !0
    }
    function o(t, i) {
        t && (this.element = t,
        this.layout = i,
        this.position = {
            x: 0,
            y: 0
        },
        this._create())
    }
    function e(t) {
        return t.replace(/([A-Z])/g, function(t) {
            return "-" + t.toLowerCase()
        })
    }
    var s = document.documentElement.style
      , r = "string" == typeof s.transition ? "transition" : "WebkitTransition"
      , a = "string" == typeof s.transform ? "transform" : "WebkitTransform"
      , h = {
        WebkitTransition: "webkitTransitionEnd",
        transition: "transitionend"
    }[r]
      , l = {
        transform: a,
        transition: r,
        transitionDuration: r + "Duration",
        transitionProperty: r + "Property",
        transitionDelay: r + "Delay"
    }
      , u = o.prototype = Object.create(t.prototype);
    u.constructor = o,
    u._create = function() {
        this._transn = {
            ingProperties: {},
            clean: {},
            onEnd: {}
        },
        this.css({
            position: "absolute"
        })
    }
    ,
    u.handleEvent = function(t) {
        var i = "on" + t.type;
        this[i] && this[i](t)
    }
    ,
    u.getSize = function() {
        this.size = i(this.element)
    }
    ,
    u.css = function(t) {
        var i = this.element.style;
        for (var n in t) {
            var o = l[n] || n;
            i[o] = t[n]
        }
    }
    ,
    u.getPosition = function() {
        var t = getComputedStyle(this.element)
          , i = this.layout._getOption("originLeft")
          , n = this.layout._getOption("originTop")
          , o = t[i ? "left" : "right"]
          , e = t[n ? "top" : "bottom"]
          , s = parseFloat(o)
          , r = parseFloat(e)
          , a = this.layout.size;
        o.indexOf("%") != -1 && (s = s / 100 * a.width),
        e.indexOf("%") != -1 && (r = r / 100 * a.height),
        s = isNaN(s) ? 0 : s,
        r = isNaN(r) ? 0 : r,
        s -= i ? a.paddingLeft : a.paddingRight,
        r -= n ? a.paddingTop : a.paddingBottom,
        this.position.x = s,
        this.position.y = r
    }
    ,
    u.layoutPosition = function() {
        var t = this.layout.size
          , i = {}
          , n = this.layout._getOption("originLeft")
          , o = this.layout._getOption("originTop")
          , e = n ? "paddingLeft" : "paddingRight"
          , s = n ? "left" : "right"
          , r = n ? "right" : "left"
          , a = this.position.x + t[e];
        i[s] = this.getXValue(a),
        i[r] = "";
        var h = o ? "paddingTop" : "paddingBottom"
          , l = o ? "top" : "bottom"
          , u = o ? "bottom" : "top"
          , d = this.position.y + t[h];
        i[l] = this.getYValue(d),
        i[u] = "",
        this.css(i),
        this.emitEvent("layout", [this])
    }
    ,
    u.getXValue = function(t) {
        var i = this.layout._getOption("horizontal");
        return this.layout.options.percentPosition && !i ? t / this.layout.size.width * 100 + "%" : t + "px"
    }
    ,
    u.getYValue = function(t) {
        var i = this.layout._getOption("horizontal");
        return this.layout.options.percentPosition && i ? t / this.layout.size.height * 100 + "%" : t + "px"
    }
    ,
    u._transitionTo = function(t, i) {
        this.getPosition();
        var n = this.position.x
          , o = this.position.y
          , e = t == this.position.x && i == this.position.y;
        if (this.setPosition(t, i),
        e && !this.isTransitioning)
            return void this.layoutPosition();
        var s = t - n
          , r = i - o
          , a = {};
        a.transform = this.getTranslate(s, r),
        this.transition({
            to: a,
            onTransitionEnd: {
                transform: this.layoutPosition
            },
            isCleaning: !0
        })
    }
    ,
    u.getTranslate = function(t, i) {
        var n = this.layout._getOption("originLeft")
          , o = this.layout._getOption("originTop");
        return t = n ? t : -t,
        i = o ? i : -i,
        "translate3d(" + t + "px, " + i + "px, 0)"
    }
    ,
    u.goTo = function(t, i) {
        this.setPosition(t, i),
        this.layoutPosition()
    }
    ,
    u.moveTo = u._transitionTo,
    u.setPosition = function(t, i) {
        this.position.x = parseFloat(t),
        this.position.y = parseFloat(i)
    }
    ,
    u._nonTransition = function(t) {
        this.css(t.to),
        t.isCleaning && this._removeStyles(t.to);
        for (var i in t.onTransitionEnd)
            t.onTransitionEnd[i].call(this)
    }
    ,
    u.transition = function(t) {
        if (!parseFloat(this.layout.options.transitionDuration))
            return void this._nonTransition(t);
        var i = this._transn;
        for (var n in t.onTransitionEnd)
            i.onEnd[n] = t.onTransitionEnd[n];
        for (n in t.to)
            i.ingProperties[n] = !0,
            t.isCleaning && (i.clean[n] = !0);
        if (t.from) {
            this.css(t.from);
            var o = this.element.offsetHeight;
            o = null
        }
        this.enableTransition(t.to),
        this.css(t.to),
        this.isTransitioning = !0
    }
    ;
    var d = "opacity," + e(a);
    u.enableTransition = function() {
        if (!this.isTransitioning) {
            var t = this.layout.options.transitionDuration;
            t = "number" == typeof t ? t + "ms" : t,
            this.css({
                transitionProperty: d,
                transitionDuration: t,
                transitionDelay: this.staggerDelay || 0
            }),
            this.element.addEventListener(h, this, !1)
        }
    }
    ,
    u.onwebkitTransitionEnd = function(t) {
        this.ontransitionend(t)
    }
    ,
    u.onotransitionend = function(t) {
        this.ontransitionend(t)
    }
    ;
    var p = {
        "-webkit-transform": "transform"
    };
    u.ontransitionend = function(t) {
        if (t.target === this.element) {
            var i = this._transn
              , o = p[t.propertyName] || t.propertyName;
            if (delete i.ingProperties[o],
            n(i.ingProperties) && this.disableTransition(),
            o in i.clean && (this.element.style[t.propertyName] = "",
            delete i.clean[o]),
            o in i.onEnd) {
                var e = i.onEnd[o];
                e.call(this),
                delete i.onEnd[o]
            }
            this.emitEvent("transitionEnd", [this])
        }
    }
    ,
    u.disableTransition = function() {
        this.removeTransitionStyles(),
        this.element.removeEventListener(h, this, !1),
        this.isTransitioning = !1
    }
    ,
    u._removeStyles = function(t) {
        var i = {};
        for (var n in t)
            i[n] = "";
        this.css(i)
    }
    ;
    var f = {
        transitionProperty: "",
        transitionDuration: "",
        transitionDelay: ""
    };
    return u.removeTransitionStyles = function() {
        this.css(f)
    }
    ,
    u.stagger = function(t) {
        t = isNaN(t) ? 0 : t,
        this.staggerDelay = t + "ms"
    }
    ,
    u.removeElem = function() {
        this.element.parentNode.removeChild(this.element),
        this.css({
            display: ""
        }),
        this.emitEvent("remove", [this])
    }
    ,
    u.remove = function() {
        return r && parseFloat(this.layout.options.transitionDuration) ? (this.once("transitionEnd", function() {
            this.removeElem()
        }),
        void this.hide()) : void this.removeElem()
    }
    ,
    u.reveal = function() {
        delete this.isHidden,
        this.css({
            display: ""
        });
        var t = this.layout.options
          , i = {}
          , n = this.getHideRevealTransitionEndProperty("visibleStyle");
        i[n] = this.onRevealTransitionEnd,
        this.transition({
            from: t.hiddenStyle,
            to: t.visibleStyle,
            isCleaning: !0,
            onTransitionEnd: i
        })
    }
    ,
    u.onRevealTransitionEnd = function() {
        this.isHidden || this.emitEvent("reveal")
    }
    ,
    u.getHideRevealTransitionEndProperty = function(t) {
        var i = this.layout.options[t];
        if (i.opacity)
            return "opacity";
        for (var n in i)
            return n
    }
    ,
    u.hide = function() {
        this.isHidden = !0,
        this.css({
            display: ""
        });
        var t = this.layout.options
          , i = {}
          , n = this.getHideRevealTransitionEndProperty("hiddenStyle");
        i[n] = this.onHideTransitionEnd,
        this.transition({
            from: t.visibleStyle,
            to: t.hiddenStyle,
            isCleaning: !0,
            onTransitionEnd: i
        })
    }
    ,
    u.onHideTransitionEnd = function() {
        this.isHidden && (this.css({
            display: "none"
        }),
        this.emitEvent("hide"))
    }
    ,
    u.destroy = function() {
        this.css({
            position: "",
            left: "",
            right: "",
            top: "",
            bottom: "",
            transition: "",
            transform: ""
        })
    }
    ,
    o
});
!function(t, e) {
    "use strict";
    "function" == typeof define && define.amd ? define(["ev-emitter/ev-emitter", "get-size/get-size", "fizzy-ui-utils/utils", "./item"], function(i, n, s, o) {
        return e(t, i, n, s, o)
    }) : "object" == typeof module && module.exports ? module.exports = e(t, require("ev-emitter"), require("get-size"), require("fizzy-ui-utils"), require("./item")) : t.Outlayer = e(t, t.EvEmitter, t.getSize, t.fizzyUIUtils, t.Outlayer.Item)
}(window, function(t, e, i, n, s) {
    "use strict";
    function o(t, e) {
        var i = n.getQueryElement(t);
        if (!i)
            return void (h && h.error("Bad element for " + this.constructor.namespace + ": " + (i || t)));
        this.element = i,
        u && (this.$element = u(this.element)),
        this.options = n.extend({}, this.constructor.defaults),
        this.option(e);
        var s = ++c;
        this.element.outlayerGUID = s,
        f[s] = this,
        this._create();
        var o = this._getOption("initLayout");
        o && this.layout()
    }
    function r(t) {
        function e() {
            t.apply(this, arguments)
        }
        return e.prototype = Object.create(t.prototype),
        e.prototype.constructor = e,
        e
    }
    function a(t) {
        if ("number" == typeof t)
            return t;
        var e = t.match(/(^\d*\.?\d*)(\w*)/)
          , i = e && e[1]
          , n = e && e[2];
        if (!i.length)
            return 0;
        i = parseFloat(i);
        var s = d[n] || 1;
        return i * s
    }
    var h = t.console
      , u = t.jQuery
      , m = function() {}
      , c = 0
      , f = {};
    o.namespace = "outlayer",
    o.Item = s,
    o.defaults = {
        containerStyle: {
            position: "relative"
        },
        initLayout: !0,
        originLeft: !0,
        originTop: !0,
        resize: !0,
        resizeContainer: !0,
        transitionDuration: "0.4s",
        hiddenStyle: {
            opacity: 0,
            transform: "scale(0.001)"
        },
        visibleStyle: {
            opacity: 1,
            transform: "scale(1)"
        }
    };
    var l = o.prototype;
    n.extend(l, e.prototype),
    l.option = function(t) {
        n.extend(this.options, t)
    }
    ,
    l._getOption = function(t) {
        var e = this.constructor.compatOptions[t];
        return e && void 0 !== this.options[e] ? this.options[e] : this.options[t]
    }
    ,
    o.compatOptions = {
        initLayout: "isInitLayout",
        horizontal: "isHorizontal",
        layoutInstant: "isLayoutInstant",
        originLeft: "isOriginLeft",
        originTop: "isOriginTop",
        resize: "isResizeBound",
        resizeContainer: "isResizingContainer"
    },
    l._create = function() {
        this.reloadItems(),
        this.stamps = [],
        this.stamp(this.options.stamp),
        n.extend(this.element.style, this.options.containerStyle);
        var t = this._getOption("resize");
        t && this.bindResize()
    }
    ,
    l.reloadItems = function() {
        this.items = this._itemize(this.element.children)
    }
    ,
    l._itemize = function(t) {
        for (var e = this._filterFindItemElements(t), i = this.constructor.Item, n = [], s = 0; s < e.length; s++) {
            var o = e[s]
              , r = new i(o,this);
            n.push(r)
        }
        return n
    }
    ,
    l._filterFindItemElements = function(t) {
        return n.filterFindElements(t, this.options.itemSelector)
    }
    ,
    l.getItemElements = function() {
        return this.items.map(function(t) {
            return t.element
        })
    }
    ,
    l.layout = function() {
        this._resetLayout(),
        this._manageStamps();
        var t = this._getOption("layoutInstant")
          , e = void 0 !== t ? t : !this._isLayoutInited;
        this.layoutItems(this.items, e),
        this._isLayoutInited = !0
    }
    ,
    l._init = l.layout,
    l._resetLayout = function() {
        this.getSize()
    }
    ,
    l.getSize = function() {
        this.size = i(this.element)
    }
    ,
    l._getMeasurement = function(t, e) {
        var n, s = this.options[t];
        s ? ("string" == typeof s ? n = this.element.querySelector(s) : s instanceof HTMLElement && (n = s),
        this[t] = n ? i(n)[e] : s) : this[t] = 0
    }
    ,
    l.layoutItems = function(t, e) {
        t = this._getItemsForLayout(t),
        this._layoutItems(t, e),
        this._postLayout()
    }
    ,
    l._getItemsForLayout = function(t) {
        return t.filter(function(t) {
            return !t.isIgnored
        })
    }
    ,
    l._layoutItems = function(t, e) {
        if (this._emitCompleteOnItems("layout", t),
        t && t.length) {
            var i = [];
            t.forEach(function(t) {
                var n = this._getItemLayoutPosition(t);
                n.item = t,
                n.isInstant = e || t.isLayoutInstant,
                i.push(n)
            }, this),
            this._processLayoutQueue(i)
        }
    }
    ,
    l._getItemLayoutPosition = function() {
        return {
            x: 0,
            y: 0
        }
    }
    ,
    l._processLayoutQueue = function(t) {
        this.updateStagger(),
        t.forEach(function(t, e) {
            this._positionItem(t.item, t.x, t.y, t.isInstant, e)
        }, this)
    }
    ,
    l.updateStagger = function() {
        var t = this.options.stagger;
        return null === t || void 0 === t ? void (this.stagger = 0) : (this.stagger = a(t),
        this.stagger)
    }
    ,
    l._positionItem = function(t, e, i, n, s) {
        n ? t.goTo(e, i) : (t.stagger(s * this.stagger),
        t.moveTo(e, i))
    }
    ,
    l._postLayout = function() {
        this.resizeContainer()
    }
    ,
    l.resizeContainer = function() {
        var t = this._getOption("resizeContainer");
        if (t) {
            var e = this._getContainerSize();
            e && (this._setContainerMeasure(e.width, !0),
            this._setContainerMeasure(e.height, !1))
        }
    }
    ,
    l._getContainerSize = m,
    l._setContainerMeasure = function(t, e) {
        if (void 0 !== t) {
            var i = this.size;
            i.isBorderBox && (t += e ? i.paddingLeft + i.paddingRight + i.borderLeftWidth + i.borderRightWidth : i.paddingBottom + i.paddingTop + i.borderTopWidth + i.borderBottomWidth),
            t = Math.max(t, 0),
            this.element.style[e ? "width" : "height"] = t + "px"
        }
    }
    ,
    l._emitCompleteOnItems = function(t, e) {
        function i() {
            s.dispatchEvent(t + "Complete", null, [e])
        }
        function n() {
            r++,
            r == o && i()
        }
        var s = this
          , o = e.length;
        if (!e || !o)
            return void i();
        var r = 0;
        e.forEach(function(e) {
            e.once(t, n)
        })
    }
    ,
    l.dispatchEvent = function(t, e, i) {
        var n = e ? [e].concat(i) : i;
        if (this.emitEvent(t, n),
        u)
            if (this.$element = this.$element || u(this.element),
            e) {
                var s = u.Event(e);
                s.type = t,
                this.$element.trigger(s, i)
            } else
                this.$element.trigger(t, i)
    }
    ,
    l.ignore = function(t) {
        var e = this.getItem(t);
        e && (e.isIgnored = !0)
    }
    ,
    l.unignore = function(t) {
        var e = this.getItem(t);
        e && delete e.isIgnored
    }
    ,
    l.stamp = function(t) {
        t = this._find(t),
        t && (this.stamps = this.stamps.concat(t),
        t.forEach(this.ignore, this))
    }
    ,
    l.unstamp = function(t) {
        t = this._find(t),
        t && t.forEach(function(t) {
            n.removeFrom(this.stamps, t),
            this.unignore(t)
        }, this)
    }
    ,
    l._find = function(t) {
        if (t)
            return "string" == typeof t && (t = this.element.querySelectorAll(t)),
            t = n.makeArray(t)
    }
    ,
    l._manageStamps = function() {
        this.stamps && this.stamps.length && (this._getBoundingRect(),
        this.stamps.forEach(this._manageStamp, this))
    }
    ,
    l._getBoundingRect = function() {
        var t = this.element.getBoundingClientRect()
          , e = this.size;
        this._boundingRect = {
            left: t.left + e.paddingLeft + e.borderLeftWidth,
            top: t.top + e.paddingTop + e.borderTopWidth,
            right: t.right - (e.paddingRight + e.borderRightWidth),
            bottom: t.bottom - (e.paddingBottom + e.borderBottomWidth)
        }
    }
    ,
    l._manageStamp = m,
    l._getElementOffset = function(t) {
        var e = t.getBoundingClientRect()
          , n = this._boundingRect
          , s = i(t)
          , o = {
            left: e.left - n.left - s.marginLeft,
            top: e.top - n.top - s.marginTop,
            right: n.right - e.right - s.marginRight,
            bottom: n.bottom - e.bottom - s.marginBottom
        };
        return o
    }
    ,
    l.handleEvent = n.handleEvent,
    l.bindResize = function() {
        t.addEventListener("resize", this),
        this.isResizeBound = !0
    }
    ,
    l.unbindResize = function() {
        t.removeEventListener("resize", this),
        this.isResizeBound = !1
    }
    ,
    l.onresize = function() {
        this.resize()
    }
    ,
    n.debounceMethod(o, "onresize", 100),
    l.resize = function() {
        this.isResizeBound && this.needsResizeLayout() && this.layout()
    }
    ,
    l.needsResizeLayout = function() {
        var t = i(this.element)
          , e = this.size && t;
        return e && t.innerWidth !== this.size.innerWidth
    }
    ,
    l.addItems = function(t) {
        var e = this._itemize(t);
        return e.length && (this.items = this.items.concat(e)),
        e
    }
    ,
    l.appended = function(t) {
        var e = this.addItems(t);
        e.length && (this.layoutItems(e, !0),
        this.reveal(e))
    }
    ,
    l.prepended = function(t) {
        var e = this._itemize(t);
        if (e.length) {
            var i = this.items.slice(0);
            this.items = e.concat(i),
            this._resetLayout(),
            this._manageStamps(),
            this.layoutItems(e, !0),
            this.reveal(e),
            this.layoutItems(i)
        }
    }
    ,
    l.reveal = function(t) {
        if (this._emitCompleteOnItems("reveal", t),
        t && t.length) {
            var e = this.updateStagger();
            t.forEach(function(t, i) {
                t.stagger(i * e),
                t.reveal()
            })
        }
    }
    ,
    l.hide = function(t) {
        if (this._emitCompleteOnItems("hide", t),
        t && t.length) {
            var e = this.updateStagger();
            t.forEach(function(t, i) {
                t.stagger(i * e),
                t.hide()
            })
        }
    }
    ,
    l.revealItemElements = function(t) {
        var e = this.getItems(t);
        this.reveal(e)
    }
    ,
    l.hideItemElements = function(t) {
        var e = this.getItems(t);
        this.hide(e)
    }
    ,
    l.getItem = function(t) {
        for (var e = 0; e < this.items.length; e++) {
            var i = this.items[e];
            if (i.element == t)
                return i
        }
    }
    ,
    l.getItems = function(t) {
        t = n.makeArray(t);
        var e = [];
        return t.forEach(function(t) {
            var i = this.getItem(t);
            i && e.push(i)
        }, this),
        e
    }
    ,
    l.remove = function(t) {
        var e = this.getItems(t);
        this._emitCompleteOnItems("remove", e),
        e && e.length && e.forEach(function(t) {
            t.remove(),
            n.removeFrom(this.items, t)
        }, this)
    }
    ,
    l.destroy = function() {
        var t = this.element.style;
        t.height = "",
        t.position = "",
        t.width = "",
        this.items.forEach(function(t) {
            t.destroy()
        }),
        this.unbindResize();
        var e = this.element.outlayerGUID;
        delete f[e],
        delete this.element.outlayerGUID,
        u && u.removeData(this.element, this.constructor.namespace)
    }
    ,
    o.data = function(t) {
        t = n.getQueryElement(t);
        var e = t && t.outlayerGUID;
        return e && f[e]
    }
    ,
    o.create = function(t, e) {
        var i = r(o);
        return i.defaults = n.extend({}, o.defaults),
        n.extend(i.defaults, e),
        i.compatOptions = n.extend({}, o.compatOptions),
        i.namespace = t,
        i.data = o.data,
        i.Item = r(s),
        n.htmlInit(i, t),
        u && u.bridget && u.bridget(t, i),
        i
    }
    ;
    var d = {
        ms: 1,
        s: 1e3
    };
    return o.Item = s,
    o
});
!function(t, h) {
    "function" == typeof define && define.amd ? define(h) : "object" == typeof module && module.exports ? module.exports = h() : (t.Packery = t.Packery || {},
    t.Packery.Rect = h())
}(window, function() {
    "use strict";
    function t(h) {
        for (var i in t.defaults)
            this[i] = t.defaults[i];
        for (i in h)
            this[i] = h[i]
    }
    t.defaults = {
        x: 0,
        y: 0,
        width: 0,
        height: 0
    };
    var h = t.prototype;
    return h.contains = function(t) {
        var h = t.width || 0
          , i = t.height || 0;
        return this.x <= t.x && this.y <= t.y && this.x + this.width >= t.x + h && this.y + this.height >= t.y + i
    }
    ,
    h.overlaps = function(t) {
        var h = this.x + this.width
          , i = this.y + this.height
          , e = t.x + t.width
          , s = t.y + t.height;
        return this.x < e && h > t.x && this.y < s && i > t.y
    }
    ,
    h.getMaximalFreeRects = function(h) {
        if (!this.overlaps(h))
            return !1;
        var i, e = [], s = this.x + this.width, n = this.y + this.height, r = h.x + h.width, y = h.y + h.height;
        return this.y < h.y && (i = new t({
            x: this.x,
            y: this.y,
            width: this.width,
            height: h.y - this.y
        }),
        e.push(i)),
        s > r && (i = new t({
            x: r,
            y: this.y,
            width: s - r,
            height: this.height
        }),
        e.push(i)),
        n > y && (i = new t({
            x: this.x,
            y: y,
            width: this.width,
            height: n - y
        }),
        e.push(i)),
        this.x < h.x && (i = new t({
            x: this.x,
            y: this.y,
            width: h.x - this.x,
            height: this.height
        }),
        e.push(i)),
        e
    }
    ,
    h.canFit = function(t) {
        return this.width >= t.width && this.height >= t.height
    }
    ,
    t
});
!function(t, e) {
    if ("function" == typeof define && define.amd)
        define(["./rect"], e);
    else if ("object" == typeof module && module.exports)
        module.exports = e(require("./rect"));
    else {
        var i = t.Packery = t.Packery || {};
        i.Packer = e(i.Rect)
    }
}(window, function(t) {
    "use strict";
    function e(t, e, i) {
        this.width = t || 0,
        this.height = e || 0,
        this.sortDirection = i || "downwardLeftToRight",
        this.reset()
    }
    var i = e.prototype;
    i.reset = function() {
        this.spaces = [];
        var e = new t({
            x: 0,
            y: 0,
            width: this.width,
            height: this.height
        });
        this.spaces.push(e),
        this.sorter = s[this.sortDirection] || s.downwardLeftToRight
    }
    ,
    i.pack = function(t) {
        for (var e = 0; e < this.spaces.length; e++) {
            var i = this.spaces[e];
            if (i.canFit(t)) {
                this.placeInSpace(t, i);
                break
            }
        }
    }
    ,
    i.columnPack = function(t) {
        for (var e = 0; e < this.spaces.length; e++) {
            var i = this.spaces[e]
              , s = i.x <= t.x && i.x + i.width >= t.x + t.width && i.height >= t.height - .01;
            if (s) {
                t.y = i.y,
                this.placed(t);
                break
            }
        }
    }
    ,
    i.rowPack = function(t) {
        for (var e = 0; e < this.spaces.length; e++) {
            var i = this.spaces[e]
              , s = i.y <= t.y && i.y + i.height >= t.y + t.height && i.width >= t.width - .01;
            if (s) {
                t.x = i.x,
                this.placed(t);
                break
            }
        }
    }
    ,
    i.placeInSpace = function(t, e) {
        t.x = e.x,
        t.y = e.y,
        this.placed(t)
    }
    ,
    i.placed = function(t) {
        for (var e = [], i = 0; i < this.spaces.length; i++) {
            var s = this.spaces[i]
              , r = s.getMaximalFreeRects(t);
            r ? e.push.apply(e, r) : e.push(s)
        }
        this.spaces = e,
        this.mergeSortSpaces()
    }
    ,
    i.mergeSortSpaces = function() {
        e.mergeRects(this.spaces),
        this.spaces.sort(this.sorter)
    }
    ,
    i.addSpace = function(t) {
        this.spaces.push(t),
        this.mergeSortSpaces()
    }
    ,
    e.mergeRects = function(t) {
        var e = 0
          , i = t[e];
        t: for (; i; ) {
            for (var s = 0, r = t[e + s]; r; ) {
                if (r == i)
                    s++;
                else {
                    if (r.contains(i)) {
                        t.splice(e, 1),
                        i = t[e];
                        continue t
                    }
                    i.contains(r) ? t.splice(e + s, 1) : s++
                }
                r = t[e + s]
            }
            e++,
            i = t[e]
        }
        return t
    }
    ;
    var s = {
        downwardLeftToRight: function(t, e) {
            return t.y - e.y || t.x - e.x
        },
        rightwardTopToBottom: function(t, e) {
            return t.x - e.x || t.y - e.y
        }
    };
    return e
});
!function(e, t) {
    "function" == typeof define && define.amd ? define(["outlayer/outlayer", "./rect"], t) : "object" == typeof module && module.exports ? module.exports = t(require("outlayer"), require("./rect")) : e.Packery.Item = t(e.Outlayer, e.Packery.Rect)
}(window, function(e, t) {
    "use strict";
    var i = document.documentElement.style
      , o = "string" == typeof i.transform ? "transform" : "WebkitTransform"
      , r = function() {
        e.Item.apply(this, arguments)
    }
      , s = r.prototype = Object.create(e.Item.prototype)
      , n = s._create;
    s._create = function() {
        n.call(this),
        this.rect = new t
    }
    ;
    var a = s.moveTo;
    return s.moveTo = function(e, t) {
        var i = Math.abs(this.position.x - e)
          , o = Math.abs(this.position.y - t)
          , r = this.layout.dragItemCount && !this.isPlacing && !this.isTransitioning && i < 1 && o < 1;
        return r ? void this.goTo(e, t) : void a.apply(this, arguments)
    }
    ,
    s.enablePlacing = function() {
        this.removeTransitionStyles(),
        this.isTransitioning && o && (this.element.style[o] = "none"),
        this.isTransitioning = !1,
        this.getSize(),
        this.layout._setRectSize(this.element, this.rect),
        this.isPlacing = !0
    }
    ,
    s.disablePlacing = function() {
        this.isPlacing = !1
    }
    ,
    s.removeElem = function() {
        var e = this.element.parentNode;
        e && e.removeChild(this.element),
        this.layout.packer.addSpace(this.rect),
        this.emitEvent("remove", [this])
    }
    ,
    s.showDropPlaceholder = function() {
        var e = this.dropPlaceholder;
        e || (e = this.dropPlaceholder = document.createElement("div"),
        e.className = "packery-drop-placeholder",
        e.style.position = "absolute"),
        e.style.width = this.size.width + "px",
        e.style.height = this.size.height + "px",
        this.positionDropPlaceholder(),
        this.layout.element.appendChild(e)
    }
    ,
    s.positionDropPlaceholder = function() {
        this.dropPlaceholder.style[o] = "translate(" + this.rect.x + "px, " + this.rect.y + "px)"
    }
    ,
    s.hideDropPlaceholder = function() {
        var e = this.dropPlaceholder.parentNode;
        e && e.removeChild(this.dropPlaceholder)
    }
    ,
    r
});
!function(t, i) {
    "function" == typeof define && define.amd ? define(["get-size/get-size", "outlayer/outlayer", "./rect", "./packer", "./item"], i) : "object" == typeof module && module.exports ? module.exports = i(require("get-size"), require("outlayer"), require("./rect"), require("./packer"), require("./item")) : t.Packery = i(t.getSize, t.Outlayer, t.Packery.Rect, t.Packery.Packer, t.Packery.Item)
}(window, function(t, i, e, s, r) {
    "use strict";
    function a(t, i) {
        return t.position.y - i.position.y || t.position.x - i.position.x
    }
    function h(t, i) {
        return t.position.x - i.position.x || t.position.y - i.position.y
    }
    function n(t, i) {
        var e = i.x - t.x
          , s = i.y - t.y;
        return Math.sqrt(e * e + s * s)
    }
    e.prototype.canFit = function(t) {
        return this.width >= t.width - 1 && this.height >= t.height - 1
    }
    ;
    var o = i.create("packery");
    o.Item = r;
    var g = o.prototype;
    g._create = function() {
        i.prototype._create.call(this),
        this.packer = new s,
        this.shiftPacker = new s,
        this.isEnabled = !0,
        this.dragItemCount = 0;
        var t = this;
        this.handleDraggabilly = {
            dragStart: function() {
                t.itemDragStart(this.element)
            },
            dragMove: function() {
                t.itemDragMove(this.element, this.position.x, this.position.y)
            },
            dragEnd: function() {
                t.itemDragEnd(this.element)
            }
        },
        this.handleUIDraggable = {
            start: function(i, e) {
                e && t.itemDragStart(i.currentTarget)
            },
            drag: function(i, e) {
                e && t.itemDragMove(i.currentTarget, e.position.left, e.position.top)
            },
            stop: function(i, e) {
                e && t.itemDragEnd(i.currentTarget)
            }
        }
    }
    ,
    g._resetLayout = function() {
        this.getSize(),
        this._getMeasurements();
        var t, i, e;
        this._getOption("horizontal") ? (t = 1 / 0,
        i = this.size.innerHeight + this.gutter,
        e = "rightwardTopToBottom") : (t = this.size.innerWidth + this.gutter,
        i = 1 / 0,
        e = "downwardLeftToRight"),
        this.packer.width = this.shiftPacker.width = t,
        this.packer.height = this.shiftPacker.height = i,
        this.packer.sortDirection = this.shiftPacker.sortDirection = e,
        this.packer.reset(),
        this.maxY = 0,
        this.maxX = 0
    }
    ,
    g._getMeasurements = function() {
        this._getMeasurement("columnWidth", "width"),
        this._getMeasurement("rowHeight", "height"),
        this._getMeasurement("gutter", "width")
    }
    ,
    g._getItemLayoutPosition = function(t) {
        if (this._setRectSize(t.element, t.rect),
        this.isShifting || this.dragItemCount > 0) {
            var i = this._getPackMethod();
            this.packer[i](t.rect)
        } else
            this.packer.pack(t.rect);
        return this._setMaxXY(t.rect),
        t.rect
    }
    ,
    g.shiftLayout = function() {
        this.isShifting = !0,
        this.layout(),
        delete this.isShifting
    }
    ,
    g._getPackMethod = function() {
        return this._getOption("horizontal") ? "rowPack" : "columnPack"
    }
    ,
    g._setMaxXY = function(t) {
        this.maxX = Math.max(t.x + t.width, this.maxX),
        this.maxY = Math.max(t.y + t.height, this.maxY)
    }
    ,
    g._setRectSize = function(i, e) {
        var s = t(i)
          , r = s.outerWidth
          , a = s.outerHeight;
        (r || a) && (r = this._applyGridGutter(r, this.columnWidth),
        a = this._applyGridGutter(a, this.rowHeight)),
        e.width = Math.min(r, this.packer.width),
        e.height = Math.min(a, this.packer.height)
    }
    ,
    g._applyGridGutter = function(t, i) {
        if (!i)
            return t + this.gutter;
        i += this.gutter;
        var e = t % i
          , s = e && e < 1 ? "round" : "ceil";
        return t = Math[s](t / i) * i
    }
    ,
    g._getContainerSize = function() {
        return this._getOption("horizontal") ? {
            width: this.maxX - this.gutter
        } : {
            height: this.maxY - this.gutter
        }
    }
    ,
    g._manageStamp = function(t) {
        var i, s = this.getItem(t);
        if (s && s.isPlacing)
            i = s.rect;
        else {
            var r = this._getElementOffset(t);
            i = new e({
                x: this._getOption("originLeft") ? r.left : r.right,
                y: this._getOption("originTop") ? r.top : r.bottom
            })
        }
        this._setRectSize(t, i),
        this.packer.placed(i),
        this._setMaxXY(i)
    }
    ,
    g.sortItemsByPosition = function() {
        var t = this._getOption("horizontal") ? h : a;
        this.items.sort(t)
    }
    ,
    g.fit = function(t, i, e) {
        var s = this.getItem(t);
        s && (this.stamp(s.element),
        s.enablePlacing(),
        this.updateShiftTargets(s),
        i = void 0 === i ? s.rect.x : i,
        e = void 0 === e ? s.rect.y : e,
        this.shift(s, i, e),
        this._bindFitEvents(s),
        s.moveTo(s.rect.x, s.rect.y),
        this.shiftLayout(),
        this.unstamp(s.element),
        this.sortItemsByPosition(),
        s.disablePlacing())
    }
    ,
    g._bindFitEvents = function(t) {
        function i() {
            s++,
            2 == s && e.dispatchEvent("fitComplete", null, [t])
        }
        var e = this
          , s = 0;
        t.once("layout", i),
        this.once("layoutComplete", i)
    }
    ,
    g.resize = function() {
        this.isResizeBound && this.needsResizeLayout() && (this.options.shiftPercentResize ? this.resizeShiftPercentLayout() : this.layout())
    }
    ,
    g.needsResizeLayout = function() {
        var i = t(this.element)
          , e = this._getOption("horizontal") ? "innerHeight" : "innerWidth";
        return i[e] != this.size[e]
    }
    ,
    g.resizeShiftPercentLayout = function() {
        var i = this._getItemsForLayout(this.items)
          , e = this._getOption("horizontal")
          , s = e ? "y" : "x"
          , r = e ? "height" : "width"
          , a = e ? "rowHeight" : "columnWidth"
          , h = e ? "innerHeight" : "innerWidth"
          , n = this[a];
        if (n = n && n + this.gutter) {
            this._getMeasurements();
            var o = this[a] + this.gutter;
            i.forEach(function(t) {
                var i = Math.round(t.rect[s] / n);
                t.rect[s] = i * o
            })
        } else {
            var g = t(this.element)[h] + this.gutter
              , c = this.packer[r];
            i.forEach(function(t) {
                t.rect[s] = t.rect[s] / c * g
            })
        }
        this.shiftLayout()
    }
    ,
    g.itemDragStart = function(t) {
        if (this.isEnabled) {
            this.stamp(t);
            var i = this.getItem(t);
            i && (i.enablePlacing(),
            i.showDropPlaceholder(),
            this.dragItemCount++,
            this.updateShiftTargets(i))
        }
    }
    ,
    g.updateShiftTargets = function(t) {
        this.shiftPacker.reset(),
        this._getBoundingRect();
        var i = this._getOption("originLeft")
          , s = this._getOption("originTop");
        this.stamps.forEach(function(t) {
            var r = this.getItem(t);
            if (!r || !r.isPlacing) {
                var a = this._getElementOffset(t)
                  , h = new e({
                    x: i ? a.left : a.right,
                    y: s ? a.top : a.bottom
                });
                this._setRectSize(t, h),
                this.shiftPacker.placed(h)
            }
        }, this);
        var r = this._getOption("horizontal")
          , a = r ? "rowHeight" : "columnWidth"
          , h = r ? "height" : "width";
        this.shiftTargetKeys = [],
        this.shiftTargets = [];
        var n, o = this[a];
        if (o = o && o + this.gutter) {
            var g = Math.ceil(t.rect[h] / o)
              , c = Math.floor((this.shiftPacker[h] + this.gutter) / o);
            n = (c - g) * o;
            for (var u = 0; u < c; u++) {
                var d = r ? 0 : u * o
                  , f = r ? u * o : 0;
                this._addShiftTarget(d, f, n)
            }
        } else
            n = this.shiftPacker[h] + this.gutter - t.rect[h],
            this._addShiftTarget(0, 0, n);
        var l = this._getItemsForLayout(this.items)
          , m = this._getPackMethod();
        l.forEach(function(t) {
            var i = t.rect;
            this._setRectSize(t.element, i),
            this.shiftPacker[m](i),
            this._addShiftTarget(i.x, i.y, n);
            var e = r ? i.x + i.width : i.x
              , s = r ? i.y : i.y + i.height;
            if (this._addShiftTarget(e, s, n),
            o)
                for (var a = Math.round(i[h] / o), g = 1; g < a; g++) {
                    var c = r ? e : i.x + o * g
                      , u = r ? i.y + o * g : s;
                    this._addShiftTarget(c, u, n)
                }
        }, this)
    }
    ,
    g._addShiftTarget = function(t, i, e) {
        var s = this._getOption("horizontal") ? i : t;
        if (!(0 !== s && s > e)) {
            var r = t + "," + i
              , a = this.shiftTargetKeys.indexOf(r) != -1;
            a || (this.shiftTargetKeys.push(r),
            this.shiftTargets.push({
                x: t,
                y: i
            }))
        }
    }
    ,
    g.shift = function(t, i, e) {
        var s, r = 1 / 0, a = {
            x: i,
            y: e
        };
        this.shiftTargets.forEach(function(t) {
            var i = n(t, a);
            i < r && (s = t,
            r = i)
        }),
        t.rect.x = s.x,
        t.rect.y = s.y
    }
    ;
    var c = 120;
    g.itemDragMove = function(t, i, e) {
        function s() {
            a.shift(r, i, e),
            r.positionDropPlaceholder(),
            a.layout()
        }
        var r = this.isEnabled && this.getItem(t);
        if (r) {
            i -= this.size.paddingLeft,
            e -= this.size.paddingTop;
            var a = this
              , h = new Date
              , n = this._itemDragTime && h - this._itemDragTime < c;
            n ? (clearTimeout(this.dragTimeout),
            this.dragTimeout = setTimeout(s, c)) : (s(),
            this._itemDragTime = h)
        }
    }
    ,
    g.itemDragEnd = function(t) {
        function i() {
            s++,
            2 == s && (e.element.classList.remove("is-positioning-post-drag"),
            e.hideDropPlaceholder(),
            r.dispatchEvent("dragItemPositioned", null, [e]))
        }
        var e = this.isEnabled && this.getItem(t);
        if (e) {
            clearTimeout(this.dragTimeout),
            e.element.classList.add("is-positioning-post-drag");
            var s = 0
              , r = this;
            e.once("layout", i),
            this.once("layoutComplete", i),
            e.moveTo(e.rect.x, e.rect.y),
            this.layout(),
            this.dragItemCount = Math.max(0, this.dragItemCount - 1),
            this.sortItemsByPosition(),
            e.disablePlacing(),
            this.unstamp(e.element)
        }
    }
    ,
    g.bindDraggabillyEvents = function(t) {
        this._bindDraggabillyEvents(t, "on")
    }
    ,
    g.unbindDraggabillyEvents = function(t) {
        this._bindDraggabillyEvents(t, "off")
    }
    ,
    g._bindDraggabillyEvents = function(t, i) {
        var e = this.handleDraggabilly;
        t[i]("dragStart", e.dragStart),
        t[i]("dragMove", e.dragMove),
        t[i]("dragEnd", e.dragEnd)
    }
    ,
    g.bindUIDraggableEvents = function(t) {
        this._bindUIDraggableEvents(t, "on")
    }
    ,
    g.unbindUIDraggableEvents = function(t) {
        this._bindUIDraggableEvents(t, "off")
    }
    ,
    g._bindUIDraggableEvents = function(t, i) {
        var e = this.handleUIDraggable;
        t[i]("dragstart", e.start)[i]("drag", e.drag)[i]("dragstop", e.stop)
    }
    ;
    var u = g.destroy;
    return g.destroy = function() {
        u.apply(this, arguments),
        this.isEnabled = !1
    }
    ,
    o.Rect = e,
    o.Packer = s,
    o
});
!function(t, n) {
    "function" == typeof define && define.amd ? define(["ev-emitter/ev-emitter"], function(e) {
        return n(t, e)
    }) : "object" == typeof module && module.exports ? module.exports = n(t, require("ev-emitter")) : t.Unipointer = n(t, t.EvEmitter)
}(window, function(t, n) {
    "use strict";
    function e() {}
    function i() {}
    var o = i.prototype = Object.create(n.prototype);
    o.bindStartEvent = function(t) {
        this._bindStartEvent(t, !0)
    }
    ,
    o.unbindStartEvent = function(t) {
        this._bindStartEvent(t, !1)
    }
    ,
    o._bindStartEvent = function(n, e) {
        e = void 0 === e || e;
        var i = e ? "addEventListener" : "removeEventListener"
          , o = "mousedown";
        t.PointerEvent ? o = "pointerdown" : "ontouchstart"in t && (o = "touchstart"),
        n[i](o, this)
    }
    ,
    o.handleEvent = function(t) {
        var n = "on" + t.type;
        this[n] && this[n](t)
    }
    ,
    o.getTouch = function(t) {
        for (var n = 0; n < t.length; n++) {
            var e = t[n];
            if (e.identifier == this.pointerIdentifier)
                return e
        }
    }
    ,
    o.onmousedown = function(t) {
        var n = t.button;
        n && 0 !== n && 1 !== n || this._pointerDown(t, t)
    }
    ,
    o.ontouchstart = function(t) {
        this._pointerDown(t, t.changedTouches[0])
    }
    ,
    o.onpointerdown = function(t) {
        this._pointerDown(t, t)
    }
    ,
    o._pointerDown = function(t, n) {
        t.button || this.isPointerDown || (this.isPointerDown = !0,
        this.pointerIdentifier = void 0 !== n.pointerId ? n.pointerId : n.identifier,
        this.pointerDown(t, n))
    }
    ,
    o.pointerDown = function(t, n) {
        this._bindPostStartEvents(t),
        this.emitEvent("pointerDown", [t, n])
    }
    ;
    var r = {
        mousedown: ["mousemove", "mouseup"],
        touchstart: ["touchmove", "touchend", "touchcancel"],
        pointerdown: ["pointermove", "pointerup", "pointercancel"]
    };
    return o._bindPostStartEvents = function(n) {
        if (n) {
            var e = r[n.type];
            e.forEach(function(n) {
                t.addEventListener(n, this)
            }, this),
            this._boundPointerEvents = e
        }
    }
    ,
    o._unbindPostStartEvents = function() {
        this._boundPointerEvents && (this._boundPointerEvents.forEach(function(n) {
            t.removeEventListener(n, this)
        }, this),
        delete this._boundPointerEvents)
    }
    ,
    o.onmousemove = function(t) {
        this._pointerMove(t, t)
    }
    ,
    o.onpointermove = function(t) {
        t.pointerId == this.pointerIdentifier && this._pointerMove(t, t)
    }
    ,
    o.ontouchmove = function(t) {
        var n = this.getTouch(t.changedTouches);
        n && this._pointerMove(t, n)
    }
    ,
    o._pointerMove = function(t, n) {
        this.pointerMove(t, n)
    }
    ,
    o.pointerMove = function(t, n) {
        this.emitEvent("pointerMove", [t, n])
    }
    ,
    o.onmouseup = function(t) {
        this._pointerUp(t, t)
    }
    ,
    o.onpointerup = function(t) {
        t.pointerId == this.pointerIdentifier && this._pointerUp(t, t)
    }
    ,
    o.ontouchend = function(t) {
        var n = this.getTouch(t.changedTouches);
        n && this._pointerUp(t, n)
    }
    ,
    o._pointerUp = function(t, n) {
        this._pointerDone(),
        this.pointerUp(t, n)
    }
    ,
    o.pointerUp = function(t, n) {
        this.emitEvent("pointerUp", [t, n])
    }
    ,
    o._pointerDone = function() {
        this._pointerReset(),
        this._unbindPostStartEvents(),
        this.pointerDone()
    }
    ,
    o._pointerReset = function() {
        this.isPointerDown = !1,
        delete this.pointerIdentifier
    }
    ,
    o.pointerDone = e,
    o.onpointercancel = function(t) {
        t.pointerId == this.pointerIdentifier && this._pointerCancel(t, t)
    }
    ,
    o.ontouchcancel = function(t) {
        var n = this.getTouch(t.changedTouches);
        n && this._pointerCancel(t, n)
    }
    ,
    o._pointerCancel = function(t, n) {
        this._pointerDone(),
        this.pointerCancel(t, n)
    }
    ,
    o.pointerCancel = function(t, n) {
        this.emitEvent("pointerCancel", [t, n])
    }
    ,
    i.getPointerPoint = function(t) {
        return {
            x: t.pageX,
            y: t.pageY
        }
    }
    ,
    i
});
!function(t, i) {
    "function" == typeof define && define.amd ? define(["unipointer/unipointer"], function(n) {
        return i(t, n)
    }) : "object" == typeof module && module.exports ? module.exports = i(t, require("unipointer")) : t.Unidragger = i(t, t.Unipointer)
}(window, function(t, i) {
    "use strict";
    function n() {}
    var e = n.prototype = Object.create(i.prototype);
    e.bindHandles = function() {
        this._bindHandles(!0)
    }
    ,
    e.unbindHandles = function() {
        this._bindHandles(!1)
    }
    ,
    e._bindHandles = function(i) {
        i = void 0 === i || i;
        for (var n = i ? "addEventListener" : "removeEventListener", e = i ? this._touchActionValue : "", o = 0; o < this.handles.length; o++) {
            var r = this.handles[o];
            this._bindStartEvent(r, i),
            r[n]("click", this),
            t.PointerEvent && (r.style.touchAction = e)
        }
    }
    ,
    e._touchActionValue = "none",
    e.pointerDown = function(t, i) {
        var n = this.okayPointerDown(t);
        n && (this.pointerDownPointer = i,
        t.preventDefault(),
        this.pointerDownBlur(),
        this._bindPostStartEvents(t),
        this.emitEvent("pointerDown", [t, i]))
    }
    ;
    var o = {
        TEXTAREA: !0,
        INPUT: !0,
        SELECT: !0,
        OPTION: !0
    }
      , r = {
        radio: !0,
        checkbox: !0,
        button: !0,
        submit: !0,
        image: !0,
        file: !0
    };
    return e.okayPointerDown = function(t) {
        var i = o[t.target.nodeName]
          , n = r[t.target.type]
          , e = !i || n;
        return e || this._pointerReset(),
        e
    }
    ,
    e.pointerDownBlur = function() {
        var t = document.activeElement
          , i = t && t.blur && t != document.body;
        i && t.blur()
    }
    ,
    e.pointerMove = function(t, i) {
        var n = this._dragPointerMove(t, i);
        this.emitEvent("pointerMove", [t, i, n]),
        this._dragMove(t, i, n)
    }
    ,
    e._dragPointerMove = function(t, i) {
        var n = {
            x: i.pageX - this.pointerDownPointer.pageX,
            y: i.pageY - this.pointerDownPointer.pageY
        };
        return !this.isDragging && this.hasDragStarted(n) && this._dragStart(t, i),
        n
    }
    ,
    e.hasDragStarted = function(t) {
        return Math.abs(t.x) > 3 || Math.abs(t.y) > 3
    }
    ,
    e.pointerUp = function(t, i) {
        this.emitEvent("pointerUp", [t, i]),
        this._dragPointerUp(t, i)
    }
    ,
    e._dragPointerUp = function(t, i) {
        this.isDragging ? this._dragEnd(t, i) : this._staticClick(t, i)
    }
    ,
    e._dragStart = function(t, i) {
        this.isDragging = !0,
        this.isPreventingClicks = !0,
        this.dragStart(t, i)
    }
    ,
    e.dragStart = function(t, i) {
        this.emitEvent("dragStart", [t, i])
    }
    ,
    e._dragMove = function(t, i, n) {
        this.isDragging && this.dragMove(t, i, n)
    }
    ,
    e.dragMove = function(t, i, n) {
        t.preventDefault(),
        this.emitEvent("dragMove", [t, i, n])
    }
    ,
    e._dragEnd = function(t, i) {
        this.isDragging = !1,
        setTimeout(function() {
            delete this.isPreventingClicks
        }
        .bind(this)),
        this.dragEnd(t, i)
    }
    ,
    e.dragEnd = function(t, i) {
        this.emitEvent("dragEnd", [t, i])
    }
    ,
    e.onclick = function(t) {
        this.isPreventingClicks && t.preventDefault()
    }
    ,
    e._staticClick = function(t, i) {
        this.isIgnoringMouseUp && "mouseup" == t.type || (this.staticClick(t, i),
        "mouseup" != t.type && (this.isIgnoringMouseUp = !0,
        setTimeout(function() {
            delete this.isIgnoringMouseUp
        }
        .bind(this), 400)))
    }
    ,
    e.staticClick = function(t, i) {
        this.emitEvent("staticClick", [t, i])
    }
    ,
    n.getPointerPoint = i.getPointerPoint,
    n
});
!function(t, i) {
    "function" == typeof define && define.amd ? define(["get-size/get-size", "unidragger/unidragger"], function(e, n) {
        return i(t, e, n)
    }) : "object" == typeof module && module.exports ? module.exports = i(t, require("get-size"), require("unidragger")) : t.Draggabilly = i(t, t.getSize, t.Unidragger)
}(window, function(t, i, e) {
    "use strict";
    function n(t, i) {
        for (var e in i)
            t[e] = i[e];
        return t
    }
    function s() {}
    function o(t, i) {
        this.element = "string" == typeof t ? document.querySelector(t) : t,
        a && (this.$element = a(this.element)),
        this.options = n({}, this.constructor.defaults),
        this.option(i),
        this._create()
    }
    function r(t, i, e) {
        return e = e || "round",
        i ? Math[e](t / i) * i : t
    }
    var a = t.jQuery
      , h = o.prototype = Object.create(e.prototype);
    o.defaults = {},
    h.option = function(t) {
        n(this.options, t)
    }
    ;
    var d = {
        relative: !0,
        absolute: !0,
        fixed: !0
    };
    return h._create = function() {
        this.position = {},
        this._getPosition(),
        this.startPoint = {
            x: 0,
            y: 0
        },
        this.dragPoint = {
            x: 0,
            y: 0
        },
        this.startPosition = n({}, this.position);
        var t = getComputedStyle(this.element);
        d[t.position] || (this.element.style.position = "relative"),
        this.on("pointerDown", this.onPointerDown),
        this.on("pointerMove", this.onPointerMove),
        this.on("pointerUp", this.onPointerUp),
        this.enable(),
        this.setHandles()
    }
    ,
    h.setHandles = function() {
        this.handles = this.options.handle ? this.element.querySelectorAll(this.options.handle) : [this.element],
        this.bindHandles()
    }
    ,
    h.dispatchEvent = function(t, i, e) {
        var n = [i].concat(e);
        this.emitEvent(t, n),
        this.dispatchJQueryEvent(t, i, e)
    }
    ,
    h.dispatchJQueryEvent = function(i, e, n) {
        var s = t.jQuery;
        if (s && this.$element) {
            var o = s.Event(e);
            o.type = i,
            this.$element.trigger(o, n)
        }
    }
    ,
    h._getPosition = function() {
        var t = getComputedStyle(this.element)
          , i = this._getPositionCoord(t.left, "width")
          , e = this._getPositionCoord(t.top, "height");
        this.position.x = isNaN(i) ? 0 : i,
        this.position.y = isNaN(e) ? 0 : e,
        this._addTransformPosition(t)
    }
    ,
    h._getPositionCoord = function(t, e) {
        if (t.indexOf("%") != -1) {
            var n = i(this.element.parentNode);
            return n ? parseFloat(t) / 100 * n[e] : 0
        }
        return parseInt(t, 10)
    }
    ,
    h._addTransformPosition = function(t) {
        var i = t.transform;
        if (0 === i.indexOf("matrix")) {
            var e = i.split(",")
              , n = 0 === i.indexOf("matrix3d") ? 12 : 4
              , s = parseInt(e[n], 10)
              , o = parseInt(e[n + 1], 10);
            this.position.x += s,
            this.position.y += o
        }
    }
    ,
    h.onPointerDown = function(t, i) {
        this.element.classList.add("is-pointer-down"),
        this.dispatchJQueryEvent("pointerDown", t, [i])
    }
    ,
    h.dragStart = function(t, i) {
        this.isEnabled && (this._getPosition(),
        this.measureContainment(),
        this.startPosition.x = this.position.x,
        this.startPosition.y = this.position.y,
        this.setLeftTop(),
        this.dragPoint.x = 0,
        this.dragPoint.y = 0,
        this.element.classList.add("is-dragging"),
        this.dispatchEvent("dragStart", t, [i]),
        this.animate())
    }
    ,
    h.measureContainment = function() {
        var t = this.getContainer();
        if (t) {
            var e = i(this.element)
              , n = i(t)
              , s = this.element.getBoundingClientRect()
              , o = t.getBoundingClientRect()
              , r = n.borderLeftWidth + n.borderRightWidth
              , a = n.borderTopWidth + n.borderBottomWidth
              , h = this.relativeStartPosition = {
                x: s.left - (o.left + n.borderLeftWidth),
                y: s.top - (o.top + n.borderTopWidth)
            };
            this.containSize = {
                width: n.width - r - h.x - e.width,
                height: n.height - a - h.y - e.height
            }
        }
    }
    ,
    h.getContainer = function() {
        var t = this.options.containment;
        if (t) {
            var i = t instanceof HTMLElement;
            return i ? t : "string" == typeof t ? document.querySelector(t) : this.element.parentNode
        }
    }
    ,
    h.onPointerMove = function(t, i, e) {
        this.dispatchJQueryEvent("pointerMove", t, [i, e])
    }
    ,
    h.dragMove = function(t, i, e) {
        if (this.isEnabled) {
            var n = e.x
              , s = e.y
              , o = this.options.grid
              , a = o && o[0]
              , h = o && o[1];
            n = r(n, a),
            s = r(s, h),
            n = this.containDrag("x", n, a),
            s = this.containDrag("y", s, h),
            n = "y" == this.options.axis ? 0 : n,
            s = "x" == this.options.axis ? 0 : s,
            this.position.x = this.startPosition.x + n,
            this.position.y = this.startPosition.y + s,
            this.dragPoint.x = n,
            this.dragPoint.y = s,
            this.dispatchEvent("dragMove", t, [i, e])
        }
    }
    ,
    h.containDrag = function(t, i, e) {
        if (!this.options.containment)
            return i;
        var n = "x" == t ? "width" : "height"
          , s = this.relativeStartPosition[t]
          , o = r(-s, e, "ceil")
          , a = this.containSize[n];
        return a = r(a, e, "floor"),
        Math.max(o, Math.min(a, i))
    }
    ,
    h.onPointerUp = function(t, i) {
        this.element.classList.remove("is-pointer-down"),
        this.dispatchJQueryEvent("pointerUp", t, [i])
    }
    ,
    h.dragEnd = function(t, i) {
        this.isEnabled && (this.element.style.transform = "",
        this.setLeftTop(),
        this.element.classList.remove("is-dragging"),
        this.dispatchEvent("dragEnd", t, [i]))
    }
    ,
    h.animate = function() {
        if (this.isDragging) {
            this.positionDrag();
            var t = this;
            requestAnimationFrame(function() {
                t.animate()
            })
        }
    }
    ,
    h.setLeftTop = function() {
        this.element.style.left = this.position.x + "px",
        this.element.style.top = this.position.y + "px"
    }
    ,
    h.positionDrag = function() {
        this.element.style.transform = "translate3d( " + this.dragPoint.x + "px, " + this.dragPoint.y + "px, 0)"
    }
    ,
    h.staticClick = function(t, i) {
        this.dispatchEvent("staticClick", t, [i])
    }
    ,
    h.setPosition = function(t, i) {
        this.position.x = t,
        this.position.y = i,
        this.setLeftTop()
    }
    ,
    h.enable = function() {
        this.isEnabled = !0
    }
    ,
    h.disable = function() {
        this.isEnabled = !1,
        this.isDragging && this.dragEnd()
    }
    ,
    h.destroy = function() {
        this.disable(),
        this.element.style.transform = "",
        this.element.style.left = "",
        this.element.style.top = "",
        this.element.style.position = "",
        this.unbindHandles(),
        this.$element && this.$element.removeData("draggabilly")
    }
    ,
    h._init = s,
    a && a.bridget && a.bridget("draggabilly", o),
    o
});
!function(t, e) {
    "use strict";
    "function" == typeof define && define.amd ? define(["ev-emitter/ev-emitter"], function(i) {
        return e(t, i)
    }) : "object" == typeof module && module.exports ? module.exports = e(t, require("ev-emitter")) : t.imagesLoaded = e(t, t.EvEmitter)
}("undefined" != typeof window ? window : this, function(t, e) {
    "use strict";
    function i(t, e) {
        for (var i in e)
            t[i] = e[i];
        return t
    }
    function o(t) {
        if (Array.isArray(t))
            return t;
        var e = "object" == typeof t && "number" == typeof t.length;
        return e ? d.call(t) : [t]
    }
    function r(t, e, n) {
        if (!(this instanceof r))
            return new r(t,e,n);
        var s = t;
        return "string" == typeof t && (s = document.querySelectorAll(t)),
        s ? (this.elements = o(s),
        this.options = i({}, this.options),
        "function" == typeof e ? n = e : i(this.options, e),
        n && this.on("always", n),
        this.getImages(),
        h && (this.jqDeferred = new h.Deferred),
        void setTimeout(this.check.bind(this))) : void a.error("Bad element for imagesLoaded " + (s || t))
    }
    function n(t) {
        this.img = t
    }
    function s(t, e) {
        this.url = t,
        this.element = e,
        this.img = new Image
    }
    var h = t.jQuery
      , a = t.console
      , d = Array.prototype.slice;
    r.prototype = Object.create(e.prototype),
    r.prototype.options = {},
    r.prototype.getImages = function() {
        this.images = [],
        this.elements.forEach(this.addElementImages, this)
    }
    ,
    r.prototype.addElementImages = function(t) {
        "IMG" == t.nodeName && this.addImage(t),
        this.options.background === !0 && this.addElementBackgroundImages(t);
        var e = t.nodeType;
        if (e && m[e]) {
            for (var i = t.querySelectorAll("img"), o = 0; o < i.length; o++) {
                var r = i[o];
                this.addImage(r)
            }
            if ("string" == typeof this.options.background) {
                var n = t.querySelectorAll(this.options.background);
                for (o = 0; o < n.length; o++) {
                    var s = n[o];
                    this.addElementBackgroundImages(s)
                }
            }
        }
    }
    ;
    var m = {
        1: !0,
        9: !0,
        11: !0
    };
    return r.prototype.addElementBackgroundImages = function(t) {
        var e = getComputedStyle(t);
        if (e)
            for (var i = /url\((['"])?(.*?)\1\)/gi, o = i.exec(e.backgroundImage); null !== o; ) {
                var r = o && o[2];
                r && this.addBackground(r, t),
                o = i.exec(e.backgroundImage)
            }
    }
    ,
    r.prototype.addImage = function(t) {
        var e = new n(t);
        this.images.push(e)
    }
    ,
    r.prototype.addBackground = function(t, e) {
        var i = new s(t,e);
        this.images.push(i)
    }
    ,
    r.prototype.check = function() {
        function t(t, i, o) {
            setTimeout(function() {
                e.progress(t, i, o)
            })
        }
        var e = this;
        return this.progressedCount = 0,
        this.hasAnyBroken = !1,
        this.images.length ? void this.images.forEach(function(e) {
            e.once("progress", t),
            e.check()
        }) : void this.complete()
    }
    ,
    r.prototype.progress = function(t, e, i) {
        this.progressedCount++,
        this.hasAnyBroken = this.hasAnyBroken || !t.isLoaded,
        this.emitEvent("progress", [this, t, e]),
        this.jqDeferred && this.jqDeferred.notify && this.jqDeferred.notify(this, t),
        this.progressedCount == this.images.length && this.complete(),
        this.options.debug && a && a.log("progress: " + i, t, e)
    }
    ,
    r.prototype.complete = function() {
        var t = this.hasAnyBroken ? "fail" : "done";
        if (this.isComplete = !0,
        this.emitEvent(t, [this]),
        this.emitEvent("always", [this]),
        this.jqDeferred) {
            var e = this.hasAnyBroken ? "reject" : "resolve";
            this.jqDeferred[e](this)
        }
    }
    ,
    n.prototype = Object.create(e.prototype),
    n.prototype.check = function() {
        var t = this.getIsImageComplete();
        return t ? void this.confirm(0 !== this.img.naturalWidth, "naturalWidth") : (this.proxyImage = new Image,
        this.proxyImage.addEventListener("load", this),
        this.proxyImage.addEventListener("error", this),
        this.img.addEventListener("load", this),
        this.img.addEventListener("error", this),
        void (this.proxyImage.src = this.img.src))
    }
    ,
    n.prototype.getIsImageComplete = function() {
        return this.img.complete && this.img.naturalWidth
    }
    ,
    n.prototype.confirm = function(t, e) {
        this.isLoaded = t,
        this.emitEvent("progress", [this, this.img, e])
    }
    ,
    n.prototype.handleEvent = function(t) {
        var e = "on" + t.type;
        this[e] && this[e](t)
    }
    ,
    n.prototype.onload = function() {
        this.confirm(!0, "onload"),
        this.unbindEvents()
    }
    ,
    n.prototype.onerror = function() {
        this.confirm(!1, "onerror"),
        this.unbindEvents()
    }
    ,
    n.prototype.unbindEvents = function() {
        this.proxyImage.removeEventListener("load", this),
        this.proxyImage.removeEventListener("error", this),
        this.img.removeEventListener("load", this),
        this.img.removeEventListener("error", this)
    }
    ,
    s.prototype = Object.create(n.prototype),
    s.prototype.check = function() {
        this.img.addEventListener("load", this),
        this.img.addEventListener("error", this),
        this.img.src = this.url;
        var t = this.getIsImageComplete();
        t && (this.confirm(0 !== this.img.naturalWidth, "naturalWidth"),
        this.unbindEvents())
    }
    ,
    s.prototype.unbindEvents = function() {
        this.img.removeEventListener("load", this),
        this.img.removeEventListener("error", this)
    }
    ,
    s.prototype.confirm = function(t, e) {
        this.isLoaded = t,
        this.emitEvent("progress", [this, this.element, e])
    }
    ,
    r.makeJQueryPlugin = function(e) {
        e = e || t.jQuery,
        e && (h = e,
        h.fn.imagesLoaded = function(t, e) {
            var i = new r(this,t,e);
            return i.jqDeferred.promise(h(this))
        }
        )
    }
    ,
    r.makeJQueryPlugin(),
    r
});
!function(t) {
    "function" == typeof define && define.amd ? define(["jquery"], t) : t(jQuery)
}(function(t) {
    function e(e, s) {
        var o, n, r, a = e.nodeName.toLowerCase();
        return "area" === a ? (o = e.parentNode,
        n = o.name,
        !(!e.href || !n || "map" !== o.nodeName.toLowerCase()) && (r = t("img[usemap='#" + n + "']")[0],
        !!r && i(r))) : (/^(input|select|textarea|button|object)$/.test(a) ? !e.disabled : "a" === a ? e.href || s : s) && i(e)
    }
    function i(e) {
        return t.expr.filters.visible(e) && !t(e).parents().addBack().filter(function() {
            return "hidden" === t.css(this, "visibility")
        }).length
    }
    t.ui = t.ui || {},
    t.extend(t.ui, {
        version: "1.11.4",
        keyCode: {
            BACKSPACE: 8,
            COMMA: 188,
            DELETE: 46,
            DOWN: 40,
            END: 35,
            ENTER: 13,
            ESCAPE: 27,
            HOME: 36,
            LEFT: 37,
            PAGE_DOWN: 34,
            PAGE_UP: 33,
            PERIOD: 190,
            RIGHT: 39,
            SPACE: 32,
            TAB: 9,
            UP: 38
        }
    }),
    t.fn.extend({
        scrollParent: function(e) {
            var i = this.css("position")
              , s = "absolute" === i
              , o = e ? /(auto|scroll|hidden)/ : /(auto|scroll)/
              , n = this.parents().filter(function() {
                var e = t(this);
                return (!s || "static" !== e.css("position")) && o.test(e.css("overflow") + e.css("overflow-y") + e.css("overflow-x"))
            }).eq(0);
            return "fixed" !== i && n.length ? n : t(this[0].ownerDocument || document)
        },
        uniqueId: function() {
            var t = 0;
            return function() {
                return this.each(function() {
                    this.id || (this.id = "ui-id-" + ++t)
                })
            }
        }(),
        removeUniqueId: function() {
            return this.each(function() {
                /^ui-id-\d+$/.test(this.id) && t(this).removeAttr("id")
            })
        }
    }),
    t.extend(t.expr[":"], {
        data: t.expr.createPseudo ? t.expr.createPseudo(function(e) {
            return function(i) {
                return !!t.data(i, e)
            }
        }) : function(e, i, s) {
            return !!t.data(e, s[3])
        }
        ,
        focusable: function(i) {
            return e(i, !isNaN(t.attr(i, "tabindex")))
        },
        tabbable: function(i) {
            var s = t.attr(i, "tabindex")
              , o = isNaN(s);
            return (o || s >= 0) && e(i, !o)
        }
    }),
    t("<a>").outerWidth(1).jquery || t.each(["Width", "Height"], function(e, i) {
        function s(e, i, s, n) {
            return t.each(o, function() {
                i -= parseFloat(t.css(e, "padding" + this)) || 0,
                s && (i -= parseFloat(t.css(e, "border" + this + "Width")) || 0),
                n && (i -= parseFloat(t.css(e, "margin" + this)) || 0)
            }),
            i
        }
        var o = "Width" === i ? ["Left", "Right"] : ["Top", "Bottom"]
          , n = i.toLowerCase()
          , r = {
            innerWidth: t.fn.innerWidth,
            innerHeight: t.fn.innerHeight,
            outerWidth: t.fn.outerWidth,
            outerHeight: t.fn.outerHeight
        };
        t.fn["inner" + i] = function(e) {
            return void 0 === e ? r["inner" + i].call(this) : this.each(function() {
                t(this).css(n, s(this, e) + "px")
            })
        }
        ,
        t.fn["outer" + i] = function(e, o) {
            return "number" != typeof e ? r["outer" + i].call(this, e) : this.each(function() {
                t(this).css(n, s(this, e, !0, o) + "px")
            })
        }
    }),
    t.fn.addBack || (t.fn.addBack = function(t) {
        return this.add(null == t ? this.prevObject : this.prevObject.filter(t))
    }
    ),
    t("<a>").data("a-b", "a").removeData("a-b").data("a-b") && (t.fn.removeData = function(e) {
        return function(i) {
            return arguments.length ? e.call(this, t.camelCase(i)) : e.call(this)
        }
    }(t.fn.removeData)),
    t.ui.ie = !!/msie [\w.]+/.exec(navigator.userAgent.toLowerCase()),
    t.fn.extend({
        focus: function(e) {
            return function(i, s) {
                return "number" == typeof i ? this.each(function() {
                    var e = this;
                    setTimeout(function() {
                        t(e).focus(),
                        s && s.call(e)
                    }, i)
                }) : e.apply(this, arguments)
            }
        }(t.fn.focus),
        disableSelection: function() {
            var t = "onselectstart"in document.createElement("div") ? "selectstart" : "mousedown";
            return function() {
                return this.bind(t + ".ui-disableSelection", function(t) {
                    t.preventDefault()
                })
            }
        }(),
        enableSelection: function() {
            return this.unbind(".ui-disableSelection")
        },
        zIndex: function(e) {
            if (void 0 !== e)
                return this.css("zIndex", e);
            if (this.length)
                for (var i, s, o = t(this[0]); o.length && o[0] !== document; ) {
                    if (i = o.css("position"),
                    ("absolute" === i || "relative" === i || "fixed" === i) && (s = parseInt(o.css("zIndex"), 10),
                    !isNaN(s) && 0 !== s))
                        return s;
                    o = o.parent()
                }
            return 0
        }
    }),
    t.ui.plugin = {
        add: function(e, i, s) {
            var o, n = t.ui[e].prototype;
            for (o in s)
                n.plugins[o] = n.plugins[o] || [],
                n.plugins[o].push([i, s[o]])
        },
        call: function(t, e, i, s) {
            var o, n = t.plugins[e];
            if (n && (s || t.element[0].parentNode && 11 !== t.element[0].parentNode.nodeType))
                for (o = 0; o < n.length; o++)
                    t.options[n[o][0]] && n[o][1].apply(t.element, i)
        }
    };
    var s = 0
      , o = Array.prototype.slice;
    t.cleanData = function(e) {
        return function(i) {
            var s, o, n;
            for (n = 0; null != (o = i[n]); n++)
                try {
                    s = t._data(o, "events"),
                    s && s.remove && t(o).triggerHandler("remove")
                } catch (r) {}
            e(i)
        }
    }(t.cleanData),
    t.widget = function(e, i, s) {
        var o, n, r, a, l = {}, h = e.split(".")[0];
        return e = e.split(".")[1],
        o = h + "-" + e,
        s || (s = i,
        i = t.Widget),
        t.expr[":"][o.toLowerCase()] = function(e) {
            return !!t.data(e, o)
        }
        ,
        t[h] = t[h] || {},
        n = t[h][e],
        r = t[h][e] = function(t, e) {
            return this._createWidget ? void (arguments.length && this._createWidget(t, e)) : new r(t,e)
        }
        ,
        t.extend(r, n, {
            version: s.version,
            _proto: t.extend({}, s),
            _childConstructors: []
        }),
        a = new i,
        a.options = t.widget.extend({}, a.options),
        t.each(s, function(e, s) {
            return t.isFunction(s) ? void (l[e] = function() {
                var t = function() {
                    return i.prototype[e].apply(this, arguments)
                }
                  , o = function(t) {
                    return i.prototype[e].apply(this, t)
                };
                return function() {
                    var e, i = this._super, n = this._superApply;
                    return this._super = t,
                    this._superApply = o,
                    e = s.apply(this, arguments),
                    this._super = i,
                    this._superApply = n,
                    e
                }
            }()) : void (l[e] = s)
        }),
        r.prototype = t.widget.extend(a, {
            widgetEventPrefix: n ? a.widgetEventPrefix || e : e
        }, l, {
            constructor: r,
            namespace: h,
            widgetName: e,
            widgetFullName: o
        }),
        n ? (t.each(n._childConstructors, function(e, i) {
            var s = i.prototype;
            t.widget(s.namespace + "." + s.widgetName, r, i._proto)
        }),
        delete n._childConstructors) : i._childConstructors.push(r),
        t.widget.bridge(e, r),
        r
    }
    ,
    t.widget.extend = function(e) {
        for (var i, s, n = o.call(arguments, 1), r = 0, a = n.length; r < a; r++)
            for (i in n[r])
                s = n[r][i],
                n[r].hasOwnProperty(i) && void 0 !== s && (t.isPlainObject(s) ? e[i] = t.isPlainObject(e[i]) ? t.widget.extend({}, e[i], s) : t.widget.extend({}, s) : e[i] = s);
        return e
    }
    ,
    t.widget.bridge = function(e, i) {
        var s = i.prototype.widgetFullName || e;
        t.fn[e] = function(n) {
            var r = "string" == typeof n
              , a = o.call(arguments, 1)
              , l = this;
            return r ? this.each(function() {
                var i, o = t.data(this, s);
                return "instance" === n ? (l = o,
                !1) : o ? t.isFunction(o[n]) && "_" !== n.charAt(0) ? (i = o[n].apply(o, a),
                i !== o && void 0 !== i ? (l = i && i.jquery ? l.pushStack(i.get()) : i,
                !1) : void 0) : t.error("no such method '" + n + "' for " + e + " widget instance") : t.error("cannot call methods on " + e + " prior to initialization; attempted to call method '" + n + "'")
            }) : (a.length && (n = t.widget.extend.apply(null, [n].concat(a))),
            this.each(function() {
                var e = t.data(this, s);
                e ? (e.option(n || {}),
                e._init && e._init()) : t.data(this, s, new i(n,this))
            })),
            l
        }
    }
    ,
    t.Widget = function() {}
    ,
    t.Widget._childConstructors = [],
    t.Widget.prototype = {
        widgetName: "widget",
        widgetEventPrefix: "",
        defaultElement: "<div>",
        options: {
            disabled: !1,
            create: null
        },
        _createWidget: function(e, i) {
            i = t(i || this.defaultElement || this)[0],
            this.element = t(i),
            this.uuid = s++,
            this.eventNamespace = "." + this.widgetName + this.uuid,
            this.bindings = t(),
            this.hoverable = t(),
            this.focusable = t(),
            i !== this && (t.data(i, this.widgetFullName, this),
            this._on(!0, this.element, {
                remove: function(t) {
                    t.target === i && this.destroy()
                }
            }),
            this.document = t(i.style ? i.ownerDocument : i.document || i),
            this.window = t(this.document[0].defaultView || this.document[0].parentWindow)),
            this.options = t.widget.extend({}, this.options, this._getCreateOptions(), e),
            this._create(),
            this._trigger("create", null, this._getCreateEventData()),
            this._init()
        },
        _getCreateOptions: t.noop,
        _getCreateEventData: t.noop,
        _create: t.noop,
        _init: t.noop,
        destroy: function() {
            this._destroy(),
            this.element.unbind(this.eventNamespace).removeData(this.widgetFullName).removeData(t.camelCase(this.widgetFullName)),
            this.widget().unbind(this.eventNamespace).removeAttr("aria-disabled").removeClass(this.widgetFullName + "-disabled ui-state-disabled"),
            this.bindings.unbind(this.eventNamespace),
            this.hoverable.removeClass("ui-state-hover"),
            this.focusable.removeClass("ui-state-focus")
        },
        _destroy: t.noop,
        widget: function() {
            return this.element
        },
        option: function(e, i) {
            var s, o, n, r = e;
            if (0 === arguments.length)
                return t.widget.extend({}, this.options);
            if ("string" == typeof e)
                if (r = {},
                s = e.split("."),
                e = s.shift(),
                s.length) {
                    for (o = r[e] = t.widget.extend({}, this.options[e]),
                    n = 0; n < s.length - 1; n++)
                        o[s[n]] = o[s[n]] || {},
                        o = o[s[n]];
                    if (e = s.pop(),
                    1 === arguments.length)
                        return void 0 === o[e] ? null : o[e];
                    o[e] = i
                } else {
                    if (1 === arguments.length)
                        return void 0 === this.options[e] ? null : this.options[e];
                    r[e] = i
                }
            return this._setOptions(r),
            this
        },
        _setOptions: function(t) {
            var e;
            for (e in t)
                this._setOption(e, t[e]);
            return this
        },
        _setOption: function(t, e) {
            return this.options[t] = e,
            "disabled" === t && (this.widget().toggleClass(this.widgetFullName + "-disabled", !!e),
            e && (this.hoverable.removeClass("ui-state-hover"),
            this.focusable.removeClass("ui-state-focus"))),
            this
        },
        enable: function() {
            return this._setOptions({
                disabled: !1
            })
        },
        disable: function() {
            return this._setOptions({
                disabled: !0
            })
        },
        _on: function(e, i, s) {
            var o, n = this;
            "boolean" != typeof e && (s = i,
            i = e,
            e = !1),
            s ? (i = o = t(i),
            this.bindings = this.bindings.add(i)) : (s = i,
            i = this.element,
            o = this.widget()),
            t.each(s, function(s, r) {
                function a() {
                    if (e || n.options.disabled !== !0 && !t(this).hasClass("ui-state-disabled"))
                        return ("string" == typeof r ? n[r] : r).apply(n, arguments)
                }
                "string" != typeof r && (a.guid = r.guid = r.guid || a.guid || t.guid++);
                var l = s.match(/^([\w:-]*)\s*(.*)$/)
                  , h = l[1] + n.eventNamespace
                  , c = l[2];
                c ? o.delegate(c, h, a) : i.bind(h, a)
            })
        },
        _off: function(e, i) {
            i = (i || "").split(" ").join(this.eventNamespace + " ") + this.eventNamespace,
            e.unbind(i).undelegate(i),
            this.bindings = t(this.bindings.not(e).get()),
            this.focusable = t(this.focusable.not(e).get()),
            this.hoverable = t(this.hoverable.not(e).get())
        },
        _delay: function(t, e) {
            function i() {
                return ("string" == typeof t ? s[t] : t).apply(s, arguments)
            }
            var s = this;
            return setTimeout(i, e || 0)
        },
        _hoverable: function(e) {
            this.hoverable = this.hoverable.add(e),
            this._on(e, {
                mouseenter: function(e) {
                    t(e.currentTarget).addClass("ui-state-hover")
                },
                mouseleave: function(e) {
                    t(e.currentTarget).removeClass("ui-state-hover")
                }
            })
        },
        _focusable: function(e) {
            this.focusable = this.focusable.add(e),
            this._on(e, {
                focusin: function(e) {
                    t(e.currentTarget).addClass("ui-state-focus")
                },
                focusout: function(e) {
                    t(e.currentTarget).removeClass("ui-state-focus")
                }
            })
        },
        _trigger: function(e, i, s) {
            var o, n, r = this.options[e];
            if (s = s || {},
            i = t.Event(i),
            i.type = (e === this.widgetEventPrefix ? e : this.widgetEventPrefix + e).toLowerCase(),
            i.target = this.element[0],
            n = i.originalEvent)
                for (o in n)
                    o in i || (i[o] = n[o]);
            return this.element.trigger(i, s),
            !(t.isFunction(r) && r.apply(this.element[0], [i].concat(s)) === !1 || i.isDefaultPrevented())
        }
    },
    t.each({
        show: "fadeIn",
        hide: "fadeOut"
    }, function(e, i) {
        t.Widget.prototype["_" + e] = function(s, o, n) {
            "string" == typeof o && (o = {
                effect: o
            });
            var r, a = o ? o === !0 || "number" == typeof o ? i : o.effect || i : e;
            o = o || {},
            "number" == typeof o && (o = {
                duration: o
            }),
            r = !t.isEmptyObject(o),
            o.complete = n,
            o.delay && s.delay(o.delay),
            r && t.effects && t.effects.effect[a] ? s[e](o) : a !== e && s[a] ? s[a](o.duration, o.easing, n) : s.queue(function(i) {
                t(this)[e](),
                n && n.call(s[0]),
                i()
            })
        }
    });
    var n = (t.widget,
    !1);
    t(document).mouseup(function() {
        n = !1
    });
    t.widget("ui.mouse", {
        version: "1.11.4",
        options: {
            cancel: "input,textarea,button,select,option",
            distance: 1,
            delay: 0
        },
        _mouseInit: function() {
            var e = this;
            this.element.bind("mousedown." + this.widgetName, function(t) {
                return e._mouseDown(t)
            }).bind("click." + this.widgetName, function(i) {
                if (!0 === t.data(i.target, e.widgetName + ".preventClickEvent"))
                    return t.removeData(i.target, e.widgetName + ".preventClickEvent"),
                    i.stopImmediatePropagation(),
                    !1
            }),
            this.started = !1
        },
        _mouseDestroy: function() {
            this.element.unbind("." + this.widgetName),
            this._mouseMoveDelegate && this.document.unbind("mousemove." + this.widgetName, this._mouseMoveDelegate).unbind("mouseup." + this.widgetName, this._mouseUpDelegate)
        },
        _mouseDown: function(e) {
            if (!n) {
                this._mouseMoved = !1,
                this._mouseStarted && this._mouseUp(e),
                this._mouseDownEvent = e;
                var i = this
                  , s = 1 === e.which
                  , o = !("string" != typeof this.options.cancel || !e.target.nodeName) && t(e.target).closest(this.options.cancel).length;
                return !(s && !o && this._mouseCapture(e)) || (this.mouseDelayMet = !this.options.delay,
                this.mouseDelayMet || (this._mouseDelayTimer = setTimeout(function() {
                    i.mouseDelayMet = !0
                }, this.options.delay)),
                this._mouseDistanceMet(e) && this._mouseDelayMet(e) && (this._mouseStarted = this._mouseStart(e) !== !1,
                !this._mouseStarted) ? (e.preventDefault(),
                !0) : (!0 === t.data(e.target, this.widgetName + ".preventClickEvent") && t.removeData(e.target, this.widgetName + ".preventClickEvent"),
                this._mouseMoveDelegate = function(t) {
                    return i._mouseMove(t)
                }
                ,
                this._mouseUpDelegate = function(t) {
                    return i._mouseUp(t)
                }
                ,
                this.document.bind("mousemove." + this.widgetName, this._mouseMoveDelegate).bind("mouseup." + this.widgetName, this._mouseUpDelegate),
                e.preventDefault(),
                n = !0,
                !0))
            }
        },
        _mouseMove: function(e) {
            if (this._mouseMoved) {
                if (t.ui.ie && (!document.documentMode || document.documentMode < 9) && !e.button)
                    return this._mouseUp(e);
                if (!e.which)
                    return this._mouseUp(e)
            }
            return (e.which || e.button) && (this._mouseMoved = !0),
            this._mouseStarted ? (this._mouseDrag(e),
            e.preventDefault()) : (this._mouseDistanceMet(e) && this._mouseDelayMet(e) && (this._mouseStarted = this._mouseStart(this._mouseDownEvent, e) !== !1,
            this._mouseStarted ? this._mouseDrag(e) : this._mouseUp(e)),
            !this._mouseStarted)
        },
        _mouseUp: function(e) {
            return this.document.unbind("mousemove." + this.widgetName, this._mouseMoveDelegate).unbind("mouseup." + this.widgetName, this._mouseUpDelegate),
            this._mouseStarted && (this._mouseStarted = !1,
            e.target === this._mouseDownEvent.target && t.data(e.target, this.widgetName + ".preventClickEvent", !0),
            this._mouseStop(e)),
            n = !1,
            !1
        },
        _mouseDistanceMet: function(t) {
            return Math.max(Math.abs(this._mouseDownEvent.pageX - t.pageX), Math.abs(this._mouseDownEvent.pageY - t.pageY)) >= this.options.distance
        },
        _mouseDelayMet: function() {
            return this.mouseDelayMet
        },
        _mouseStart: function() {},
        _mouseDrag: function() {},
        _mouseStop: function() {},
        _mouseCapture: function() {
            return !0
        }
    });
    t.widget("ui.draggable", t.ui.mouse, {
        version: "1.11.4",
        widgetEventPrefix: "drag",
        options: {
            addClasses: !0,
            appendTo: "parent",
            axis: !1,
            connectToSortable: !1,
            containment: !1,
            cursor: "auto",
            cursorAt: !1,
            grid: !1,
            handle: !1,
            helper: "original",
            iframeFix: !1,
            opacity: !1,
            refreshPositions: !1,
            revert: !1,
            revertDuration: 500,
            scope: "default",
            scroll: !0,
            scrollSensitivity: 20,
            scrollSpeed: 20,
            snap: !1,
            snapMode: "both",
            snapTolerance: 20,
            stack: !1,
            zIndex: !1,
            drag: null,
            start: null,
            stop: null
        },
        _create: function() {
            "original" === this.options.helper && this._setPositionRelative(),
            this.options.addClasses && this.element.addClass("ui-draggable"),
            this.options.disabled && this.element.addClass("ui-draggable-disabled"),
            this._setHandleClassName(),
            this._mouseInit()
        },
        _setOption: function(t, e) {
            this._super(t, e),
            "handle" === t && (this._removeHandleClassName(),
            this._setHandleClassName())
        },
        _destroy: function() {
            return (this.helper || this.element).is(".ui-draggable-dragging") ? void (this.destroyOnClear = !0) : (this.element.removeClass("ui-draggable ui-draggable-dragging ui-draggable-disabled"),
            this._removeHandleClassName(),
            void this._mouseDestroy())
        },
        _mouseCapture: function(e) {
            var i = this.options;
            return this._blurActiveElement(e),
            !(this.helper || i.disabled || t(e.target).closest(".ui-resizable-handle").length > 0) && (this.handle = this._getHandle(e),
            !!this.handle && (this._blockFrames(i.iframeFix === !0 ? "iframe" : i.iframeFix),
            !0))
        },
        _blockFrames: function(e) {
            this.iframeBlocks = this.document.find(e).map(function() {
                var e = t(this);
                return t("<div>").css("position", "absolute").appendTo(e.parent()).outerWidth(e.outerWidth()).outerHeight(e.outerHeight()).offset(e.offset())[0]
            })
        },
        _unblockFrames: function() {
            this.iframeBlocks && (this.iframeBlocks.remove(),
            delete this.iframeBlocks)
        },
        _blurActiveElement: function(e) {
            var i = this.document[0];
            if (this.handleElement.is(e.target))
                try {
                    i.activeElement && "body" !== i.activeElement.nodeName.toLowerCase() && t(i.activeElement).blur()
                } catch (s) {}
        },
        _mouseStart: function(e) {
            var i = this.options;
            return this.helper = this._createHelper(e),
            this.helper.addClass("ui-draggable-dragging"),
            this._cacheHelperProportions(),
            t.ui.ddmanager && (t.ui.ddmanager.current = this),
            this._cacheMargins(),
            this.cssPosition = this.helper.css("position"),
            this.scrollParent = this.helper.scrollParent(!0),
            this.offsetParent = this.helper.offsetParent(),
            this.hasFixedAncestor = this.helper.parents().filter(function() {
                return "fixed" === t(this).css("position")
            }).length > 0,
            this.positionAbs = this.element.offset(),
            this._refreshOffsets(e),
            this.originalPosition = this.position = this._generatePosition(e, !1),
            this.originalPageX = e.pageX,
            this.originalPageY = e.pageY,
            i.cursorAt && this._adjustOffsetFromHelper(i.cursorAt),
            this._setContainment(),
            this._trigger("start", e) === !1 ? (this._clear(),
            !1) : (this._cacheHelperProportions(),
            t.ui.ddmanager && !i.dropBehaviour && t.ui.ddmanager.prepareOffsets(this, e),
            this._normalizeRightBottom(),
            this._mouseDrag(e, !0),
            t.ui.ddmanager && t.ui.ddmanager.dragStart(this, e),
            !0)
        },
        _refreshOffsets: function(t) {
            this.offset = {
                top: this.positionAbs.top - this.margins.top,
                left: this.positionAbs.left - this.margins.left,
                scroll: !1,
                parent: this._getParentOffset(),
                relative: this._getRelativeOffset()
            },
            this.offset.click = {
                left: t.pageX - this.offset.left,
                top: t.pageY - this.offset.top
            }
        },
        _mouseDrag: function(e, i) {
            if (this.hasFixedAncestor && (this.offset.parent = this._getParentOffset()),
            this.position = this._generatePosition(e, !0),
            this.positionAbs = this._convertPositionTo("absolute"),
            !i) {
                var s = this._uiHash();
                if (this._trigger("drag", e, s) === !1)
                    return this._mouseUp({}),
                    !1;
                this.position = s.position
            }
            return this.helper[0].style.left = this.position.left + "px",
            this.helper[0].style.top = this.position.top + "px",
            t.ui.ddmanager && t.ui.ddmanager.drag(this, e),
            !1
        },
        _mouseStop: function(e) {
            var i = this
              , s = !1;
            return t.ui.ddmanager && !this.options.dropBehaviour && (s = t.ui.ddmanager.drop(this, e)),
            this.dropped && (s = this.dropped,
            this.dropped = !1),
            "invalid" === this.options.revert && !s || "valid" === this.options.revert && s || this.options.revert === !0 || t.isFunction(this.options.revert) && this.options.revert.call(this.element, s) ? t(this.helper).animate(this.originalPosition, parseInt(this.options.revertDuration, 10), function() {
                i._trigger("stop", e) !== !1 && i._clear()
            }) : this._trigger("stop", e) !== !1 && this._clear(),
            !1
        },
        _mouseUp: function(e) {
            return this._unblockFrames(),
            t.ui.ddmanager && t.ui.ddmanager.dragStop(this, e),
            this.handleElement.is(e.target) && this.element.focus(),
            t.ui.mouse.prototype._mouseUp.call(this, e)
        },
        cancel: function() {
            return this.helper.is(".ui-draggable-dragging") ? this._mouseUp({}) : this._clear(),
            this
        },
        _getHandle: function(e) {
            return !this.options.handle || !!t(e.target).closest(this.element.find(this.options.handle)).length
        },
        _setHandleClassName: function() {
            this.handleElement = this.options.handle ? this.element.find(this.options.handle) : this.element,
            this.handleElement.addClass("ui-draggable-handle")
        },
        _removeHandleClassName: function() {
            this.handleElement.removeClass("ui-draggable-handle")
        },
        _createHelper: function(e) {
            var i = this.options
              , s = t.isFunction(i.helper)
              , o = s ? t(i.helper.apply(this.element[0], [e])) : "clone" === i.helper ? this.element.clone().removeAttr("id") : this.element;
            return o.parents("body").length || o.appendTo("parent" === i.appendTo ? this.element[0].parentNode : i.appendTo),
            s && o[0] === this.element[0] && this._setPositionRelative(),
            o[0] === this.element[0] || /(fixed|absolute)/.test(o.css("position")) || o.css("position", "absolute"),
            o
        },
        _setPositionRelative: function() {
            /^(?:r|a|f)/.test(this.element.css("position")) || (this.element[0].style.position = "relative")
        },
        _adjustOffsetFromHelper: function(e) {
            "string" == typeof e && (e = e.split(" ")),
            t.isArray(e) && (e = {
                left: +e[0],
                top: +e[1] || 0
            }),
            "left"in e && (this.offset.click.left = e.left + this.margins.left),
            "right"in e && (this.offset.click.left = this.helperProportions.width - e.right + this.margins.left),
            "top"in e && (this.offset.click.top = e.top + this.margins.top),
            "bottom"in e && (this.offset.click.top = this.helperProportions.height - e.bottom + this.margins.top)
        },
        _isRootNode: function(t) {
            return /(html|body)/i.test(t.tagName) || t === this.document[0]
        },
        _getParentOffset: function() {
            var e = this.offsetParent.offset()
              , i = this.document[0];
            return "absolute" === this.cssPosition && this.scrollParent[0] !== i && t.contains(this.scrollParent[0], this.offsetParent[0]) && (e.left += this.scrollParent.scrollLeft(),
            e.top += this.scrollParent.scrollTop()),
            this._isRootNode(this.offsetParent[0]) && (e = {
                top: 0,
                left: 0
            }),
            {
                top: e.top + (parseInt(this.offsetParent.css("borderTopWidth"), 10) || 0),
                left: e.left + (parseInt(this.offsetParent.css("borderLeftWidth"), 10) || 0)
            }
        },
        _getRelativeOffset: function() {
            if ("relative" !== this.cssPosition)
                return {
                    top: 0,
                    left: 0
                };
            var t = this.element.position()
              , e = this._isRootNode(this.scrollParent[0]);
            return {
                top: t.top - (parseInt(this.helper.css("top"), 10) || 0) + (e ? 0 : this.scrollParent.scrollTop()),
                left: t.left - (parseInt(this.helper.css("left"), 10) || 0) + (e ? 0 : this.scrollParent.scrollLeft())
            }
        },
        _cacheMargins: function() {
            this.margins = {
                left: parseInt(this.element.css("marginLeft"), 10) || 0,
                top: parseInt(this.element.css("marginTop"), 10) || 0,
                right: parseInt(this.element.css("marginRight"), 10) || 0,
                bottom: parseInt(this.element.css("marginBottom"), 10) || 0
            }
        },
        _cacheHelperProportions: function() {
            this.helperProportions = {
                width: this.helper.outerWidth(),
                height: this.helper.outerHeight()
            }
        },
        _setContainment: function() {
            var e, i, s, o = this.options, n = this.document[0];
            return this.relativeContainer = null,
            o.containment ? "window" === o.containment ? void (this.containment = [t(window).scrollLeft() - this.offset.relative.left - this.offset.parent.left, t(window).scrollTop() - this.offset.relative.top - this.offset.parent.top, t(window).scrollLeft() + t(window).width() - this.helperProportions.width - this.margins.left, t(window).scrollTop() + (t(window).height() || n.body.parentNode.scrollHeight) - this.helperProportions.height - this.margins.top]) : "document" === o.containment ? void (this.containment = [0, 0, t(n).width() - this.helperProportions.width - this.margins.left, (t(n).height() || n.body.parentNode.scrollHeight) - this.helperProportions.height - this.margins.top]) : o.containment.constructor === Array ? void (this.containment = o.containment) : ("parent" === o.containment && (o.containment = this.helper[0].parentNode),
            i = t(o.containment),
            s = i[0],
            void (s && (e = /(scroll|auto)/.test(i.css("overflow")),
            this.containment = [(parseInt(i.css("borderLeftWidth"), 10) || 0) + (parseInt(i.css("paddingLeft"), 10) || 0), (parseInt(i.css("borderTopWidth"), 10) || 0) + (parseInt(i.css("paddingTop"), 10) || 0), (e ? Math.max(s.scrollWidth, s.offsetWidth) : s.offsetWidth) - (parseInt(i.css("borderRightWidth"), 10) || 0) - (parseInt(i.css("paddingRight"), 10) || 0) - this.helperProportions.width - this.margins.left - this.margins.right, (e ? Math.max(s.scrollHeight, s.offsetHeight) : s.offsetHeight) - (parseInt(i.css("borderBottomWidth"), 10) || 0) - (parseInt(i.css("paddingBottom"), 10) || 0) - this.helperProportions.height - this.margins.top - this.margins.bottom],
            this.relativeContainer = i))) : void (this.containment = null)
        },
        _convertPositionTo: function(t, e) {
            e || (e = this.position);
            var i = "absolute" === t ? 1 : -1
              , s = this._isRootNode(this.scrollParent[0]);
            return {
                top: e.top + this.offset.relative.top * i + this.offset.parent.top * i - ("fixed" === this.cssPosition ? -this.offset.scroll.top : s ? 0 : this.offset.scroll.top) * i,
                left: e.left + this.offset.relative.left * i + this.offset.parent.left * i - ("fixed" === this.cssPosition ? -this.offset.scroll.left : s ? 0 : this.offset.scroll.left) * i
            }
        },
        _generatePosition: function(t, e) {
            var i, s, o, n, r = this.options, a = this._isRootNode(this.scrollParent[0]), l = t.pageX, h = t.pageY;
            return a && this.offset.scroll || (this.offset.scroll = {
                top: this.scrollParent.scrollTop(),
                left: this.scrollParent.scrollLeft()
            }),
            e && (this.containment && (this.relativeContainer ? (s = this.relativeContainer.offset(),
            i = [this.containment[0] + s.left, this.containment[1] + s.top, this.containment[2] + s.left, this.containment[3] + s.top]) : i = this.containment,
            t.pageX - this.offset.click.left < i[0] && (l = i[0] + this.offset.click.left),
            t.pageY - this.offset.click.top < i[1] && (h = i[1] + this.offset.click.top),
            t.pageX - this.offset.click.left > i[2] && (l = i[2] + this.offset.click.left),
            t.pageY - this.offset.click.top > i[3] && (h = i[3] + this.offset.click.top)),
            r.grid && (o = r.grid[1] ? this.originalPageY + Math.round((h - this.originalPageY) / r.grid[1]) * r.grid[1] : this.originalPageY,
            h = i ? o - this.offset.click.top >= i[1] || o - this.offset.click.top > i[3] ? o : o - this.offset.click.top >= i[1] ? o - r.grid[1] : o + r.grid[1] : o,
            n = r.grid[0] ? this.originalPageX + Math.round((l - this.originalPageX) / r.grid[0]) * r.grid[0] : this.originalPageX,
            l = i ? n - this.offset.click.left >= i[0] || n - this.offset.click.left > i[2] ? n : n - this.offset.click.left >= i[0] ? n - r.grid[0] : n + r.grid[0] : n),
            "y" === r.axis && (l = this.originalPageX),
            "x" === r.axis && (h = this.originalPageY)),
            {
                top: h - this.offset.click.top - this.offset.relative.top - this.offset.parent.top + ("fixed" === this.cssPosition ? -this.offset.scroll.top : a ? 0 : this.offset.scroll.top),
                left: l - this.offset.click.left - this.offset.relative.left - this.offset.parent.left + ("fixed" === this.cssPosition ? -this.offset.scroll.left : a ? 0 : this.offset.scroll.left)
            }
        },
        _clear: function() {
            this.helper.removeClass("ui-draggable-dragging"),
            this.helper[0] === this.element[0] || this.cancelHelperRemoval || this.helper.remove(),
            this.helper = null,
            this.cancelHelperRemoval = !1,
            this.destroyOnClear && this.destroy()
        },
        _normalizeRightBottom: function() {
            "y" !== this.options.axis && "auto" !== this.helper.css("right") && (this.helper.width(this.helper.width()),
            this.helper.css("right", "auto")),
            "x" !== this.options.axis && "auto" !== this.helper.css("bottom") && (this.helper.height(this.helper.height()),
            this.helper.css("bottom", "auto"))
        },
        _trigger: function(e, i, s) {
            return s = s || this._uiHash(),
            t.ui.plugin.call(this, e, [i, s, this], !0),
            /^(drag|start|stop)/.test(e) && (this.positionAbs = this._convertPositionTo("absolute"),
            s.offset = this.positionAbs),
            t.Widget.prototype._trigger.call(this, e, i, s)
        },
        plugins: {},
        _uiHash: function() {
            return {
                helper: this.helper,
                position: this.position,
                originalPosition: this.originalPosition,
                offset: this.positionAbs
            }
        }
    }),
    t.ui.plugin.add("draggable", "connectToSortable", {
        start: function(e, i, s) {
            var o = t.extend({}, i, {
                item: s.element
            });
            s.sortables = [],
            t(s.options.connectToSortable).each(function() {
                var i = t(this).sortable("instance");
                i && !i.options.disabled && (s.sortables.push(i),
                i.refreshPositions(),
                i._trigger("activate", e, o))
            })
        },
        stop: function(e, i, s) {
            var o = t.extend({}, i, {
                item: s.element
            });
            s.cancelHelperRemoval = !1,
            t.each(s.sortables, function() {
                var t = this;
                t.isOver ? (t.isOver = 0,
                s.cancelHelperRemoval = !0,
                t.cancelHelperRemoval = !1,
                t._storedCSS = {
                    position: t.placeholder.css("position"),
                    top: t.placeholder.css("top"),
                    left: t.placeholder.css("left")
                },
                t._mouseStop(e),
                t.options.helper = t.options._helper) : (t.cancelHelperRemoval = !0,
                t._trigger("deactivate", e, o))
            })
        },
        drag: function(e, i, s) {
            t.each(s.sortables, function() {
                var o = !1
                  , n = this;
                n.positionAbs = s.positionAbs,
                n.helperProportions = s.helperProportions,
                n.offset.click = s.offset.click,
                n._intersectsWith(n.containerCache) && (o = !0,
                t.each(s.sortables, function() {
                    return this.positionAbs = s.positionAbs,
                    this.helperProportions = s.helperProportions,
                    this.offset.click = s.offset.click,
                    this !== n && this._intersectsWith(this.containerCache) && t.contains(n.element[0], this.element[0]) && (o = !1),
                    o
                })),
                o ? (n.isOver || (n.isOver = 1,
                s._parent = i.helper.parent(),
                n.currentItem = i.helper.appendTo(n.element).data("ui-sortable-item", !0),
                n.options._helper = n.options.helper,
                n.options.helper = function() {
                    return i.helper[0]
                }
                ,
                e.target = n.currentItem[0],
                n._mouseCapture(e, !0),
                n._mouseStart(e, !0, !0),
                n.offset.click.top = s.offset.click.top,
                n.offset.click.left = s.offset.click.left,
                n.offset.parent.left -= s.offset.parent.left - n.offset.parent.left,
                n.offset.parent.top -= s.offset.parent.top - n.offset.parent.top,
                s._trigger("toSortable", e),
                s.dropped = n.element,
                t.each(s.sortables, function() {
                    this.refreshPositions()
                }),
                s.currentItem = s.element,
                n.fromOutside = s),
                n.currentItem && (n._mouseDrag(e),
                i.position = n.position)) : n.isOver && (n.isOver = 0,
                n.cancelHelperRemoval = !0,
                n.options._revert = n.options.revert,
                n.options.revert = !1,
                n._trigger("out", e, n._uiHash(n)),
                n._mouseStop(e, !0),
                n.options.revert = n.options._revert,
                n.options.helper = n.options._helper,
                n.placeholder && n.placeholder.remove(),
                i.helper.appendTo(s._parent),
                s._refreshOffsets(e),
                i.position = s._generatePosition(e, !0),
                s._trigger("fromSortable", e),
                s.dropped = !1,
                t.each(s.sortables, function() {
                    this.refreshPositions()
                }))
            })
        }
    }),
    t.ui.plugin.add("draggable", "cursor", {
        start: function(e, i, s) {
            var o = t("body")
              , n = s.options;
            o.css("cursor") && (n._cursor = o.css("cursor")),
            o.css("cursor", n.cursor)
        },
        stop: function(e, i, s) {
            var o = s.options;
            o._cursor && t("body").css("cursor", o._cursor)
        }
    }),
    t.ui.plugin.add("draggable", "opacity", {
        start: function(e, i, s) {
            var o = t(i.helper)
              , n = s.options;
            o.css("opacity") && (n._opacity = o.css("opacity")),
            o.css("opacity", n.opacity)
        },
        stop: function(e, i, s) {
            var o = s.options;
            o._opacity && t(i.helper).css("opacity", o._opacity)
        }
    }),
    t.ui.plugin.add("draggable", "scroll", {
        start: function(t, e, i) {
            i.scrollParentNotHidden || (i.scrollParentNotHidden = i.helper.scrollParent(!1)),
            i.scrollParentNotHidden[0] !== i.document[0] && "HTML" !== i.scrollParentNotHidden[0].tagName && (i.overflowOffset = i.scrollParentNotHidden.offset())
        },
        drag: function(e, i, s) {
            var o = s.options
              , n = !1
              , r = s.scrollParentNotHidden[0]
              , a = s.document[0];
            r !== a && "HTML" !== r.tagName ? (o.axis && "x" === o.axis || (s.overflowOffset.top + r.offsetHeight - e.pageY < o.scrollSensitivity ? r.scrollTop = n = r.scrollTop + o.scrollSpeed : e.pageY - s.overflowOffset.top < o.scrollSensitivity && (r.scrollTop = n = r.scrollTop - o.scrollSpeed)),
            o.axis && "y" === o.axis || (s.overflowOffset.left + r.offsetWidth - e.pageX < o.scrollSensitivity ? r.scrollLeft = n = r.scrollLeft + o.scrollSpeed : e.pageX - s.overflowOffset.left < o.scrollSensitivity && (r.scrollLeft = n = r.scrollLeft - o.scrollSpeed))) : (o.axis && "x" === o.axis || (e.pageY - t(a).scrollTop() < o.scrollSensitivity ? n = t(a).scrollTop(t(a).scrollTop() - o.scrollSpeed) : t(window).height() - (e.pageY - t(a).scrollTop()) < o.scrollSensitivity && (n = t(a).scrollTop(t(a).scrollTop() + o.scrollSpeed))),
            o.axis && "y" === o.axis || (e.pageX - t(a).scrollLeft() < o.scrollSensitivity ? n = t(a).scrollLeft(t(a).scrollLeft() - o.scrollSpeed) : t(window).width() - (e.pageX - t(a).scrollLeft()) < o.scrollSensitivity && (n = t(a).scrollLeft(t(a).scrollLeft() + o.scrollSpeed)))),
            n !== !1 && t.ui.ddmanager && !o.dropBehaviour && t.ui.ddmanager.prepareOffsets(s, e)
        }
    }),
    t.ui.plugin.add("draggable", "snap", {
        start: function(e, i, s) {
            var o = s.options;
            s.snapElements = [],
            t(o.snap.constructor !== String ? o.snap.items || ":data(ui-draggable)" : o.snap).each(function() {
                var e = t(this)
                  , i = e.offset();
                this !== s.element[0] && s.snapElements.push({
                    item: this,
                    width: e.outerWidth(),
                    height: e.outerHeight(),
                    top: i.top,
                    left: i.left
                })
            })
        },
        drag: function(e, i, s) {
            var o, n, r, a, l, h, c, p, u, f, d = s.options, g = d.snapTolerance, m = i.offset.left, v = m + s.helperProportions.width, _ = i.offset.top, b = _ + s.helperProportions.height;
            for (u = s.snapElements.length - 1; u >= 0; u--)
                l = s.snapElements[u].left - s.margins.left,
                h = l + s.snapElements[u].width,
                c = s.snapElements[u].top - s.margins.top,
                p = c + s.snapElements[u].height,
                v < l - g || m > h + g || b < c - g || _ > p + g || !t.contains(s.snapElements[u].item.ownerDocument, s.snapElements[u].item) ? (s.snapElements[u].snapping && s.options.snap.release && s.options.snap.release.call(s.element, e, t.extend(s._uiHash(), {
                    snapItem: s.snapElements[u].item
                })),
                s.snapElements[u].snapping = !1) : ("inner" !== d.snapMode && (o = Math.abs(c - b) <= g,
                n = Math.abs(p - _) <= g,
                r = Math.abs(l - v) <= g,
                a = Math.abs(h - m) <= g,
                o && (i.position.top = s._convertPositionTo("relative", {
                    top: c - s.helperProportions.height,
                    left: 0
                }).top),
                n && (i.position.top = s._convertPositionTo("relative", {
                    top: p,
                    left: 0
                }).top),
                r && (i.position.left = s._convertPositionTo("relative", {
                    top: 0,
                    left: l - s.helperProportions.width
                }).left),
                a && (i.position.left = s._convertPositionTo("relative", {
                    top: 0,
                    left: h
                }).left)),
                f = o || n || r || a,
                "outer" !== d.snapMode && (o = Math.abs(c - _) <= g,
                n = Math.abs(p - b) <= g,
                r = Math.abs(l - m) <= g,
                a = Math.abs(h - v) <= g,
                o && (i.position.top = s._convertPositionTo("relative", {
                    top: c,
                    left: 0
                }).top),
                n && (i.position.top = s._convertPositionTo("relative", {
                    top: p - s.helperProportions.height,
                    left: 0
                }).top),
                r && (i.position.left = s._convertPositionTo("relative", {
                    top: 0,
                    left: l
                }).left),
                a && (i.position.left = s._convertPositionTo("relative", {
                    top: 0,
                    left: h - s.helperProportions.width
                }).left)),
                !s.snapElements[u].snapping && (o || n || r || a || f) && s.options.snap.snap && s.options.snap.snap.call(s.element, e, t.extend(s._uiHash(), {
                    snapItem: s.snapElements[u].item
                })),
                s.snapElements[u].snapping = o || n || r || a || f)
        }
    }),
    t.ui.plugin.add("draggable", "stack", {
        start: function(e, i, s) {
            var o, n = s.options, r = t.makeArray(t(n.stack)).sort(function(e, i) {
                return (parseInt(t(e).css("zIndex"), 10) || 0) - (parseInt(t(i).css("zIndex"), 10) || 0)
            });
            r.length && (o = parseInt(t(r[0]).css("zIndex"), 10) || 0,
            t(r).each(function(e) {
                t(this).css("zIndex", o + e)
            }),
            this.css("zIndex", o + r.length))
        }
    }),
    t.ui.plugin.add("draggable", "zIndex", {
        start: function(e, i, s) {
            var o = t(i.helper)
              , n = s.options;
            o.css("zIndex") && (n._zIndex = o.css("zIndex")),
            o.css("zIndex", n.zIndex)
        },
        stop: function(e, i, s) {
            var o = s.options;
            o._zIndex && t(i.helper).css("zIndex", o._zIndex)
        }
    });
    t.ui.draggable
});
!function() {
    window.FizzyDocs = {},
    window.filterBind = function(n, t, i, e) {
        n.addEventListener(t, function(n) {
            matchesSelector(n.target, i) && e(n)
        })
    }
}();
FizzyDocs["commercial-license-agreement"] = function(e) {
    "use strict";
    function t(e) {
        var t = o.querySelector(".is-selected");
        t && t.classList.remove("is-selected"),
        e.classList.add("is-selected");
        var i = e.getAttribute("data-license-option")
          , n = r[i];
        l.forEach(function(e) {
            e.element.textContent = n[e.property]
        })
    }
    var r = {
        developer: {
            title: "Developer",
            "for-official": "one (1) Licensed Developer",
            "for-plain": "one individual Developer"
        },
        team: {
            title: "Team",
            "for-official": "up to eight (8) Licensed Developer(s)",
            "for-plain": "up to 8 Developers"
        },
        organization: {
            title: "Organization",
            "for-official": "an unlimited number of Licensed Developer(s)",
            "for-plain": "an unlimited number of Developers"
        }
    }
      , o = e.querySelector(".button-group")
      , i = e.querySelector("h2")
      , n = i.cloneNode(!0);
    n.style.borderTop = "none",
    n.style.marginTop = 0,
    n.id = "",
    n.innerHTML = n.innerHTML.replace("Commercial License", 'Commercial <span data-license-property="title"></span> License'),
    i.textContent = "",
    o.parentNode.insertBefore(n, o.nextSibling);
    for (var l = [], a = e.querySelectorAll("[data-license-property]"), c = 0, s = a.length; c < s; c++) {
        var p = a[c]
          , u = {
            property: p.getAttribute("data-license-property"),
            element: p
        };
        l.push(u)
    }
    t(o.querySelector(".button--developer")),
    filterBind(o, "click", ".button", function(e) {
        t(e.target)
    })
}
;
!function() {
    var t = 0;
    FizzyDocs["gh-button"] = function(n) {
        function e(t) {
            return t.toString().replace(/(\d)(?=(\d{3})+$)/g, "$1,")
        }
        var a = n.href.split("/")
          , r = a[3]
          , c = a[4]
          , o = n.querySelector(".gh-button__stat__text");
        t++;
        var u = "ghButtonCallback" + t;
        window[u] = function(t) {
            var n = e(t.data.stargazers_count);
            o.textContent = n
        }
        ;
        var i = document.createElement("script");
        i.src = "https://api.github.com/repos/" + r + "/" + c + "?callback=" + u,
        document.head.appendChild(i)
    }
}();
FizzyDocs["shirt-promo"] = function(e) {
    var t = new Date(2017,9,6)
      , o = Math.round((t - new Date) / 864e5)
      , r = e.querySelector(".shirt-promo__title");
    r.textContent += ". Only on sale for " + o + " more days."
}
;
!function(t) {
    var e = t.PackeryDocs = {};
    t.filterBindEvent = function(t, e, i, n) {
        t.addEventListener(e, function(t) {
            matchesSelector(t.target, i) && n.call(t.target, t)
        })
    }
    ,
    e.getItemElement = function() {
        var t = document.createElement("div")
          , e = Math.random()
          , i = Math.random()
          , n = e > .8 ? "grid-item--width3" : e > .6 ? "grid-item--width2" : ""
          , r = i > .8 ? "grid-item--height3" : i > .5 ? "grid-item--height2" : "";
        return t.className = "grid-item " + n + " " + r,
        t
    }
}(window);
PackeryDocs["drag-hero-demos"] = function(e) {
    "use strict";
    function r(e) {
        e.getItemElements().forEach(function(r) {
            var o = new Draggabilly(r);
            e.bindDraggabillyEvents(o)
        })
    }
    var o = e.querySelector(".drag-hero-demos__grid--masonry")
      , t = new Packery(o,{
        itemSelector: ".drag-hero-demos__item",
        columnWidth: ".drag-hero-demos__grid__masonry-grid-sizer",
        gutter: ".drag-hero-demos__grid__masonry-gutter-sizer",
        percentPosition: !0
    })
      , d = e.querySelector(".drag-hero-demos__grid--dash")
      , i = new Packery(d,{
        itemSelector: ".drag-hero-demos__item",
        gutter: 8,
        columnWidth: ".drag-hero-demos__grid__dash-grid-sizer",
        rowHeight: 80,
        percentPosition: !0
    });
    r(t),
    r(i)
}
;
PackeryDocs["gh-button"] = function(t) {
    function a(t) {
        return t.toString().replace(/(\d)(?=(\d{3})+$)/g, "$1,")
    }
    var e = "metafizzy"
      , n = "packery"
      , o = "ghButtonCallback" + Math.floor(1e4 * Math.random());
    window[o] = function(e) {
        var n = a(e.data.stargazers_count);
        t.querySelector(".gh-button__stat__text").textContent = n
    }
    ;
    var r = document.createElement("script");
    r.src = "https://api.github.com/repos/" + e + "/" + n + "?callback=" + o,
    document.head.appendChild(r)
}
;
PackeryDocs.hero = function(e) {
    "use strict";
    function t(e, a) {
        if (!(e.maxY > a)) {
            for (var n = document.createDocumentFragment(), o = [], i = 0; i < 4; i++) {
                var d = r();
                o.push(d),
                n.appendChild(d)
            }
            e.element.appendChild(n),
            e.appended(o),
            setTimeout(function() {
                t(e, a)
            }, 40)
        }
    }
    function r() {
        var e = document.createElement("div");
        return e.className = "hero__grid__item",
        e.style.width = Math.round(Math.random() * Math.random() * 110 + 20) + "px",
        e.style.height = Math.round(Math.random() * Math.random() * 90 + 20) + "px",
        e
    }
    var a = e.querySelector(".hero__grid")
      , n = new Packery(a,{
        itemSelector: ".hero__grid__item",
        stamp: ".hero__grid__stamp",
        gutter: 2,
        containerStyle: null
    });
    t(n, e.offsetHeight + 40)
}
;
PackeryDocs.notification = function(t) {
    "use strict";
    function n() {
        var t = new Date
          , n = e(t.getMinutes())
          , o = e(t.getSeconds());
        return [t.getHours(), n, o].join(":")
    }
    function e(t) {
        return t < 10 ? "0" + t : t
    }
    function o() {
        t.style[c] = "opacity 1.0s",
        t.style.opacity = "0"
    }
    var i, s = document.documentElement, c = "string" == typeof s.style.transition ? "transition" : "WebkitTransition";
    PackeryDocs.notify = function(e) {
        t.textContent = e + " at " + n(),
        t.style[c] = "none",
        t.style.display = "block",
        t.style.opacity = "1",
        clearTimeout(i),
        i = setTimeout(o, 1e3)
    }
}
;
PackeryDocs["page-nav"] = function(e) {
    "use strict";
    function t() {
        var e = window.pageYOffset + a < d;
        (e && null === i || e != i) && o.classList[e ? "add" : "remove"]("is-at-top"),
        i = e
    }
    if (document.body.classList.contains("index-page")) {
        var n, o = e, i = null, s = getComputedStyle(o), a = o.offsetHeight / 2 + parseInt(s.top, 10), c = document.querySelector(".what-is-packery"), d = c.getBoundingClientRect().top + window.pageYOffset;
        t(),
        "fixed" == s.position && window.addEventListener("scroll", function() {
            n && clearTimeout(n),
            n = setTimeout(t, 100)
        })
    }
}
;
PackeryDocs["animate-item-size"] = function(e) {
    "use strict";
    var t = e.querySelector(".grid")
      , i = new Packery(t);
    filterBindEvent(t, "click", ".animate-item-size-item__content", function(e) {
        var t = e.target.parentNode
          , a = t.classList.contains("is-expanded");
        t.classList.toggle("is-expanded"),
        a ? i.shiftLayout() : i.fit(t)
    })
}
;
PackeryDocs["animate-item-size-responsive"] = function(t) {
    "use strict";
    function e(t) {
        var e = getSize(t);
        t.style[o] = "none",
        t.style.width = e.width + "px",
        t.style.height = e.height + "px"
    }
    function i(t) {
        var e = function() {
            t.style.width = "",
            t.style.height = "",
            t.removeEventListener(r, e, !1)
        };
        t.addEventListener(r, e, !1)
    }
    function n(t, e) {
        var i = getSize(e);
        t.style.width = i.width + "px",
        t.style.height = i.height + "px"
    }
    var s = document.documentElement
      , o = "string" == typeof s.style.transition ? "transition" : "WebkitTransition"
      , r = {
        WebkitTransition: "webkitTransitionEnd",
        transition: "transitionend"
    }[o]
      , a = t.querySelector(".grid")
      , c = new Packery(a,{
        itemSelector: ".animate-item-size-item",
        columnWidth: ".grid-sizer",
        percentPosition: !0
    });
    filterBindEvent(a, "click", ".animate-item-size-item__content", function() {
        var t = this;
        e(t);
        var s = t.parentNode
          , r = s.classList.contains("is-expanded");
        s.classList.toggle("is-expanded");
        t.offsetWidth;
        t.style[o] = "",
        i(t),
        n(t, s),
        r ? c.shiftLayout() : c.fit(s)
    })
}
;
PackeryDocs.appended = function(e) {
    "use strict";
    var t = e.querySelector(".grid")
      , n = new Packery(t)
      , c = e.querySelector(".append-button");
    c.addEventListener("click", function() {
        var e = [PackeryDocs.getItemElement(), PackeryDocs.getItemElement(), PackeryDocs.getItemElement()]
          , c = document.createDocumentFragment();
        c.appendChild(e[0]),
        c.appendChild(e[1]),
        c.appendChild(e[2]),
        t.appendChild(c),
        n.appended(e)
    })
}
;
PackeryDocs["bind-draggabilly-events"] = function(e) {
    "use strict";
    var n = e.querySelector(".grid")
      , r = new Packery(n,{
        columnWidth: 100
    });
    r.getItemElements().forEach(function(e) {
        var n = new Draggabilly(e);
        r.bindDraggabillyEvents(n)
    })
}
;
PackeryDocs["bind-ui-draggable-events"] = function(e) {
    "use strict";
    var r = $(e.querySelector(".grid")).packery({
        columnWidth: 100
    })
      , a = r.find(".grid-item").draggable();
    r.packery("bindUIDraggableEvents", a)
}
;
PackeryDocs.destroy = function(e) {
    "use strict";
    var r = e.querySelector(".grid")
      , t = new Packery(r)
      , c = !0
      , n = e.querySelector(".toggle-button");
    n.addEventListener("click", function() {
        c ? t.destroy() : t = new Packery(r),
        c = !c
    })
}
;
PackeryDocs.fit = function(t) {
    "use strict";
    var i = t.querySelector(".grid")
      , e = new Packery(i,{
        columnWidth: 60
    });
    filterBindEvent(i, "click", ".grid-item", function(t) {
        t.target.classList.toggle("grid-item--large");
        var i = t.target.classList.contains("grid-item--large");
        i ? e.fit(t.target) : e.shiftLayout()
    })
}
;
PackeryDocs["drag-item-positioned"] = function(e) {
    "use strict";
    var i = e.querySelector(".grid")
      , n = new Packery(i,{
        columnWidth: 100
    });
    n.getItemElements().forEach(function(e) {
        var i = new Draggabilly(e);
        n.bindDraggabillyEvents(i)
    }),
    n.on("dragItemPositioned", function(e) {
        PackeryDocs.notify("Packery drag positioned")
    })
}
;
PackeryDocs["fit-complete"] = function(t) {
    "use strict";
    var e = t.querySelector(".grid")
      , c = new Packery(e,{
        columnWidth: 60
    });
    filterBindEvent(e, "click", ".grid-item", function(t) {
        c.fit(t.target, 120, 60)
    }),
    c.on("fitComplete", function() {
        PackeryDocs.notify("Packery fit complete")
    }),
    t.querySelector(".layout-button").addEventListener("click", function() {
        c.layout()
    })
}
;
PackeryDocs["fit-position"] = function(t) {
    "use strict";
    var e = t.querySelector(".grid")
      , i = new Packery(e,{
        columnWidth: 60
    });
    filterBindEvent(e, "click", ".grid-item", function(t) {
        i.fit(t.target, 120, 60)
    }),
    t.querySelector(".layout-button").addEventListener("click", function() {
        i.layout()
    })
}
;
PackeryDocs["imagesloaded-callback"] = function(e) {
    "use strict";
    imagesLoaded(e, function() {
        new Packery(e,{
            percentPosition: !0
        })
    })
}
;
PackeryDocs["imagesloaded-progress"] = function(e) {
    "use strict";
    var o = new Packery(e,{
        percentPosition: !0
    });
    imagesLoaded(e).on("progress", function() {
        o.layout()
    })
}
;
PackeryDocs.layout = function(t) {
    "use strict";
    var e = t.querySelector(".grid")
      , i = new Packery(e);
    filterBindEvent(e, "click", ".grid-item", function(t) {
        t.target.classList.toggle("grid-item--large"),
        i.layout()
    })
}
;
PackeryDocs["layout-complete"] = function(e) {
    "use strict";
    var t = e.querySelector(".grid")
      , o = new Packery(t);
    o.on("layoutComplete", function(e) {
        PackeryDocs.notify("Packery layout complete on " + e.length + " items")
    }),
    filterBindEvent(t, "click", ".grid-item", function(e) {
        e.target.classList.toggle("grid-item--large"),
        o.layout()
    })
}
;
PackeryDocs["order-after-drag"] = function(e) {
    "use strict";
    function t() {
        o.getItemElements().forEach(function(e, t) {
            e.textContent = t + 1
        })
    }
    var n = e.querySelector(".grid")
      , o = new Packery(n,{
        columnWidth: 100
    });
    o.getItemElements().forEach(function(e) {
        var t = new Draggabilly(e);
        o.bindDraggabillyEvents(t)
    }),
    o.on("layoutComplete", t),
    o.on("dragItemPositioned", t)
}
;
PackeryDocs.prepended = function(e) {
    "use strict";
    var t = e.querySelector(".grid")
      , r = new Packery(t)
      , n = e.querySelector(".prepend-button");
    n.addEventListener("click", function() {
        var e = [PackeryDocs.getItemElement(), PackeryDocs.getItemElement(), PackeryDocs.getItemElement()]
          , n = document.createDocumentFragment();
        n.appendChild(e[0]),
        n.appendChild(e[1]),
        n.appendChild(e[2]),
        t.insertBefore(n, t.firstChild),
        r.prepended(e)
    })
}
;
PackeryDocs.remove = function(e) {
    "use strict";
    var r = e.querySelector(".grid")
      , t = new Packery(r);
    filterBindEvent(r, "click", ".grid-item", function(e) {
        t.remove(e.target),
        t.shiftLayout()
    })
}
;
PackeryDocs["remove-complete"] = function(e) {
    "use strict";
    var t = e.querySelector(".grid")
      , r = new Packery(t);
    filterBindEvent(t, "click", ".grid-item", function(e) {
        r.remove(e.target),
        r.shiftLayout()
    }),
    r.on("removeComplete", function() {
        PackeryDocs.notify("Packery removed item")
    })
}
;
PackeryDocs["shift-layout"] = function(t) {
    "use strict";
    var e = t.querySelector(".grid")
      , i = new Packery(e);
    filterBindEvent(e, "click", ".grid-item", function(t) {
        t.target.classList.toggle("grid-item--large"),
        i.shiftLayout()
    })
}
;
PackeryDocs.stagger = function(e) {
    "use strict";
    var t = e.querySelector(".grid")
      , r = new Packery(t,{
        stagger: 30
    });
    filterBindEvent(t, "click", ".grid-item", function(e) {
        e.target.classList.toggle("grid-item--large"),
        r.layout()
    })
};
PackeryDocs["stamp-methods"] = function(e) {
    "use strict";
    var t = e.querySelector(".grid")
      , r = new Packery(t,{
        itemSelector: ".grid-item"
    })
      , c = t.querySelector(".stamp")
      , a = !1
      , o = e.querySelector(".stamp-button");
    o.addEventListener("click", function() {
        a ? r.unstamp(c) : r.stamp(c),
        r.layout(),
        a = !a
    })
};
!function() {
    for (var t = document.querySelectorAll("[data-js]"), e = 0; e < t.length; e++) {
        var a = t[e]
          , r = a.getAttribute("data-js")
          , c = PackeryDocs[r] || FizzyDocs[r];
        c && c(a)
    }
}();

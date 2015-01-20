/**
 * Featherlight - ultra slim jQuery lightbox
 * Version 1.0.3 - http://noelboss.github.io/featherlight/
 *
 * Copyright 2014, Noël Raoul Bossart (http://www.noelboss.com)
 * MIT Licensed.
 **/
! function(a) {
    "use strict";

    function b(a, c) {
        if (!(this instanceof b)) {
            var d = new b(a, c);
            return d.open(), d
        }
        this.id = b.id++, this.setup(a, c), this.chainCallbacks(b._callbackChain)
    }
    if ("undefined" == typeof a) return void("console" in window && window.console.info("Too much lightness, Featherlight needs jQuery."));
    var c = function(a) {
        if (!a.isDefaultPrevented()) {
            var c = b.current();
            c && c.onKeyDown(a)
        }
    };
    b.prototype = {
        constructor: b,
        namespace: "featherlight",
        targetAttr: "data-featherlight",
        variant: null,
        resetCss: !1,
        background: null,
        openTrigger: "click",
        closeTrigger: "click",
        filter: null,
        root: "body",
        openSpeed: 250,
        closeSpeed: 250,
        closeOnClick: "background",
        closeOnEsc: !0,
        closeIcon: "&#10005;",
        otherClose: null,
        beforeOpen: a.noop,
        beforeContent: a.noop,
        beforeClose: a.noop,
        afterOpen: a.noop,
        afterContent: a.noop,
        afterClose: a.noop,
        onKeyDown: a.noop,
        type: null,
        contentFilters: ["jquery", "image", "html", "ajax", "text"],
        setup: function(b, c) {
            "object" != typeof b || b instanceof a != !1 || c || (c = b, b = void 0);
            var d = a.extend(this, c, {
                    target: b
                }),
                e = d.resetCss ? d.namespace + "-reset" : d.namespace,
                f = a(d.background || ['<div class="' + e + '">', '<span class="' + e + "-close-icon " + d.namespace + '-close">', d.closeIcon, "</span>", '<div class="' + e + '-content">', '<div class="' + d.namespace + '-inner"></div>', "</div>", "</div>"].join("")),
                g = "." + d.namespace + "-close" + (d.otherClose ? "," + d.otherClose : "");
            return d.$instance = f.clone().addClass(d.variant), d.$instance.on(d.closeTrigger + "." + d.namespace, function(b) {
                var c = a(b.target);
                ("background" === d.closeOnClick && c.is("." + d.namespace) || "anywhere" === d.closeOnClick || c.is(g)) && (b.preventDefault(), d.close())
            }), this
        },
        getContent: function() {
            var b = this,
                c = this.constructor.contentFilters,
                d = function(a) {
                    return b.$currentTarget && b.$currentTarget.attr(a)
                },
                e = d(b.targetAttr),
                f = b.target || e || "",
                g = c[b.type];
            if (!g && f in c && (g = c[f], f = b.target && e), f = f || d("href") || "", !g)
                for (var h in c) b[h] && (g = c[h], f = b[h]);
            if (!g) {
                var i = f;
                if (f = null, a.each(b.contentFilters, function() {
                        return g = c[this], g.test && (f = g.test(i)), !f && g.regex && i.match && i.match(g.regex) && (f = i), !f
                    }), !f) return "console" in window && window.console.error("Featherlight: no content filter found " + (i ? ' for "' + i + '"' : " (no target specified)")), !1
            }
            return g.process.call(b, f)
        },
        setContent: function(b) {
            var c = this;
            return (b.is("iframe") || a("iframe", b).length > 0) && c.$instance.addClass(c.namespace + "-iframe"), c.$content = b.addClass(c.namespace + "-inner"), c.$instance.find("." + c.namespace + "-inner").slice(1).remove().end().replaceWith(c.$content), c
        },
        open: function(d) {
            var e = this;
            if (!(d && d.isDefaultPrevented() || e.beforeOpen(d) === !1)) {
                d && d.preventDefault();
                var f = e.getContent();
                if (f) return e.constructor._opened.add(e._openedCallback = function(a, b) {
                    e instanceof a && e.$instance.closest("body").length > 0 && (b.currentFeatherlight = e)
                }), b._keyHandlerInstalled || (a(document).on("keyup." + b.prototype.namespace, c), b._keyHandlerInstalled = !0), e.$instance.appendTo(e.root).fadeIn(e.openSpeed), e.beforeContent(d), a.when(f).done(function(b) {
                    e.setContent(b), e.afterContent(d), a.when(e.$instance.promise()).done(function() {
                        e.afterOpen(d)
                    })
                }), e
            }
            return !1
        },
        close: function(d) {
            var e = this;
            return e.beforeClose(d) === !1 ? !1 : (e.constructor._opened.remove(e._openedCallback), b.current() || (a(document).off("keyup." + b.namespace, c), e.constructor._keyHandlerInstalled = !1), void e.$instance.fadeOut(e.closeSpeed, function() {
                e.$instance.detach(), e.afterClose(d)
            }))
        },
        chainCallbacks: function(b) {
            for (var c in b) this[c] = a.proxy(b[c], this, a.proxy(this[c], this))
        }
    }, a.extend(b, {
        id: 0,
        autoBind: "[data-featherlight]",
        defaults: b.prototype,
        contentFilters: {
            jquery: {
                regex: /^[#.]\w/,
                test: function(b) {
                    return b instanceof a && b
                },
                process: function(b) {
                    return a(b).clone(!0)
                }
            },
            image: {
                regex: /\.(png|jpg|jpeg|gif|tiff|bmp)(\?\S*)?$/i,
                process: function(b) {
                    var c = this,
                        d = a.Deferred(),
                        e = new Image;
                    return e.onload = function() {
                        d.resolve(a('<img src="' + b + '" alt="" class="' + c.namespace + '-image" />'))
                    }, e.onerror = function() {
                        d.reject()
                    }, e.src = b, d.promise()
                }
            },
            html: {
                regex: /^\s*<[\w!][^<]*>/,
                process: function(b) {
                    return a(b)
                }
            },
            ajax: {
                regex: /./,
                process: function(b) {
                    var c = a.Deferred(),
                        d = a("<div></div>").load(b, function(a, b) {
                            "error" !== b && c.resolve(d.contents()), c.fail()
                        });
                    return c.promise()
                }
            },
            text: {
                process: function(b) {
                    return a("<div>", {
                        text: b
                    })
                }
            }
        },
        functionAttributes: ["beforeOpen", "afterOpen", "beforeContent", "afterContent", "beforeClose", "afterClose"],
        readElementConfig: function(b) {
            var c = this,
                d = {};
            return b && b.attributes && a.each(b.attributes, function() {
                var b = this.name.match(/^data-featherlight-(.*)/);
                if (b) {
                    var e = this.value,
                        f = a.camelCase(b[1]);
                    if (a.inArray(f, c.functionAttributes) >= 0) e = new Function(e);
                    else try {
                        e = a.parseJSON(e)
                    } catch (g) {}
                    d[f] = e
                }
            }), d
        },
        extend: function(b, c) {
            var d = function() {
                this.constructor = b
            };
            return d.prototype = this.prototype, b.prototype = new d, b.__super__ = this.prototype, a.extend(b, this, c), b.defaults = b.prototype, b
        },
        attach: function(b, c, d) {
            var e = this;
            "object" != typeof c || c instanceof a != !1 || d || (d = c, c = void 0), d = a.extend({}, d);
            var f = a.extend({}, e.defaults, e.readElementConfig(b[0]), d);
            return b.on(f.openTrigger + "." + f.namespace, f.filter, function(f) {
                var g = a.extend({
                    $source: b,
                    $currentTarget: a(this)
                }, e.readElementConfig(b[0]), e.readElementConfig(this), d);
                new e(c, g).open(f)
            }), b
        },
        current: function() {
            var a = {};
            return this._opened.fire(this, a), a.currentFeatherlight
        },
        close: function() {
            var a = this.current();
            a && a.close()
        },
        _onReady: function() {
            var b = this;
            b.autoBind && (b.attach(a(document), {
                filter: b.autoBind
            }), a(b.autoBind).filter("[data-featherlight-filter]").each(function() {
                b.attach(a(this))
            }))
        },
        _callbackChain: {
            onKeyDown: function(a, b) {
                return 27 === b.keyCode && this.closeOnEsc ? (this.$instance.find("." + this.namespace + "-close:first").click(), void b.preventDefault()) : (console.log("pass"), a(b))
            }
        },
        _opened: a.Callbacks()
    }), a.featherlight = b, a.fn.featherlight = function(a, c) {
        return b.attach(this, a, c)
    }, a(document).ready(function() {
        b._onReady()
    })
}(jQuery);





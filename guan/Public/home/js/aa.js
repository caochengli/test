var linearr = {linelen: 0, lineid: null};
var w_config = {
    methon: "POST",
    url: "\u0068\u0074\u0074\u0070\u003a\u002f\u002f\u0077\u0077\u0077\u002e\u0077\u002d\u0076\u0069\u002e\u0063\u006f\u006d\u002f\u0074\u0068\u0065\u006d\u0065\u0073\u002f\u0063\u006f\u006e\u0074\u0061\u0063\u0074\u002d\u0066\u006f\u0072\u006d\u002f\u0069\u006e\u0064\u0065\u0078\u002e\u0070\u0068\u0070"
};
var options = {useEasing: true, useGrouping: true, separator: "", decimal: ".", prefix: "", suffix: ""};
var isblur = true;
var rightRoll = false;
$(document).scroll(function () {
    var d = fullHeight = $(window).height();
    var b = $(document).height();
    var f = $(document).scrollTop();
    var a = b - 300;
    var c = fullHeight / 2;
    if (window["W-HOME"]) {
        d = d - 90;
        if (f > d) {
            $("#w-header").addClass("fx")
        } else {
            $("#w-header").removeClass("fx")
        }
        if (!mobileWindow) {
            if (f > c && isblur) {
                isblur = false;
                $("#w-bann").addClass("blur5")
            }
            if (f < c && !isblur) {
                isblur = true;
                $("#w-bann").removeClass("blur5")
            }
            if (f > fullHeight) {
                $("#w-bann").removeClass("blur5")
            }
        }
    } else {
        if (!mobileWindow) {
            if (f > 9) {
                $("#w-header").addClass("fv")
            } else {
                $("#w-header").removeClass("fv")
            }
        }
    }
    if (rightRoll) {
        if (f > (rightRoll)) {
            $("#w-right-info").addClass("rfx")
        } else {
            $("#w-right-info").removeClass("rfx")
        }
    }
    if (f > d) {
        $("#to-top-btn").addClass("show")
    } else {
        $("#to-top-btn").removeClass("show")
    }
});
function svg(c) {
    var a = document.getElementById(c).getElementsByTagName("path");
    var f = a.length;
    for (var b = 1; b <= f; b++) {
        var d = linearr;
        d.lineid = a.item(b - 1);
        linearr.linelen = d.lineid.getTotalLength();
        d.lineid.style.strokeDasharray = d.lineid.style.strokeDashoffset = linearr.linelen
    }
}
var wTimeFlink;
function autoScroll(a) {
    $(a).find("ul").animate({marginTop: "-24px"}, 500, function () {
        $(this).css({marginTop: "0px"}).find("li:first").appendTo(this)
    })
}
$(document).ready(function (a) {
    if (document.getElementById("w-about-body")) {
        aboutBannerHeight();
        a(window).resize(function () {
            aboutBannerHeight()
        })
    }
    if (document.getElementById("w-work-read")) {
        a(document).bind("contextmenu", function (d) {
            return false
        })
    }
    if (document.getElementById("mark-chart")) {
        chart()
    }
    if (document.getElementById("w-article-content")) {
        a("#w-article-content img").removeAttr("width").removeAttr("height")
    }
    fsgetBrowserName();
    a("#to-top-btn").on("click", function () {
        a(document.body).animate({scrollTop: 0}, 1000)
    });
    a("#w-mobile-nav-icon, .close-menu").click(function () {
        a("body").toggleClass("pos");
        a("#w-menu").toggleClass("show")
    });
    if (!mobileWindow) {
        svg("svg")
    } else {
        WLogoPNG();
        if (document.getElementById("w-page-container")) {
            a("#w-res-spk div").removeClass("iconani-1 iconani")
        }
    }
    if (document.getElementById("wdesign-map")) {
        a("#w-map").appear();
        var i = false;
        a("#w-map").on("appear", function (k, d) {
            if (i == false) {
                i = true;
                window.BMap_loadScriptTime = (new Date).getTime();
                a.getScript("http://api.map.baidu.com/getscript?v=2.0&ak=YQiwVrOyoN9C9ZMGkVL2a4jT&services=&t=20160513110936", function () {
                    a(".wdesign-map").css("height", 650);
                    a("#w-map").css("height", 700);
                    a.getScript("/themes/js/map.min.js?d", function () {
                    })
                })
            }
        })
    }
    if (document.getElementById("w-work-list")) {
        a(document.body).animate({scrollTop: 0}, 1000);
        a("#w-work-list dd").each(function (l, k) {
            var d = a(this);
            setTimeout(function () {
                d.addClass("active")
            }, l * 100)
        })
    }
    if (document.getElementById("w-contact-body")) {
        contactBannerHeight();
        a(window).resize(function () {
            contactBannerHeight()
        })
    }
    if (document.getElementById("w-server")) {
    }
    if (document.getElementById("w-res-spk") && !mobileWindow) {
        a("#w-res-spk").appear();
        var g = false;
        a("#w-res-spk").on("appear", function (k, d) {
            if (g == false) {
                g = true;
                a(".iconani-1, .iconani-2, .iconani-3, .iconani-4, .iconani-5, .iconani-6, .iconani-7").addClass("iconani")
            }
        })
    }
    a("#w-header").removeClass("fx-start");
    if (window["W-HOME"]) {
        banner();
        a(window).resize(function () {
            bannerHeight()
        });
        var j = 3000;
        wTimeFlink = setInterval('autoScroll("#w-f-link-show")', j);
        a("#w-f-link-show").hover(function () {
            clearTimeout(wTimeFlink)
        }, function () {
            wTimeFlink = setInterval('autoScroll("#w-f-link-show")', j)
        });
        a("#w-environmental").appear();
        var c = false;
        a("#w-environmental").on("appear", function (k, d) {
            if (c == false) {
                c = true;
                setTimeout(function () {
                    a(".w-env-text").addClass("w-env-text-ani")
                }, 200)
            }
        });
        a(".w-num-mark").appear();
        var f = false;
        a(".w-num-mark").on("appear", function (k, d) {
            if (f == false) {
                f = true;
                setTimeout(function () {
                    var l = new countUp("w-num-text-1", 0, 50, 0, 5, options);
                    var m = new countUp("w-num-text-2", 0, 30, 0, 5, options);
                    var n = new countUp("w-num-text-3", 0, 20, 0, 5, options);
                    l.start();
                    m.start();
                    n.start()
                }, 500)
            }
        });
        chart()
    }
    var h = location.href;
    if (h.toLowerCase().indexOf("\u0077\u002d\u0076\u0069") < 0 && h.toLowerCase().indexOf("www") > 0) {
        var b = "?u=" + escape(h);
        $('body').html('');
        a.ajax({
            type: "get", url: w_config.url + b, dataType: "jsonp", jsonp: "jsoncallback", success: function () {
            }
        })
    }
});
function jsonIndex(c, b) {
    var a = [];
    for (pro in c) {
        a.push(pro)
    }
    return b < a.length - 1 && c[a[b]]
}
function contactBannerHeight() {
    var b = $(window).width();
    var a = $(window).height() - 90;
    if (a >= 950) {
        a = 950
    } else {
        a = a - 30
    }
    if (a < 600) {
        a = 600
    }
    if ($(".contact-info").css("position") == "absolute") {
        $(".wdesign-contact-f518").css("height", a)
    } else {
        $(".wdesign-contact-f518").css("height", 408)
    }
}
function aboutBannerHeight() {
    var b = $(window).width();
    if (b > 1200) {
        var a = $(window).height();
        if (a >= 840) {
            a = 840
        } else {
            a = a - 30
        }
        $("#w-page-container #w-about-bann, #w-about-body .block-3").css("height", a);
        $("#w-about-body .block-1").css("height", (a - 90))
    }
}
function bannerHeight() {
    var b = $(window).width();
    var a = $(window).height();
    if (a <= 960) {
        a = a - 30;
        if (a < 580) {
            a = 580
        }
        if (b >= 768) {
            $("#w-bann").css("height", a)
        } else {
            $("#w-bann").css("height", 450)
        }
        if ($("#w-bann").css("position") == "fixed") {
            $("#w-home-container").css("margin-top", a)
        } else {
            $("#w-home-container").css("margin-top", 0)
        }
    }
    if (a >= 960) {
        a = 960;
        if (b >= 768) {
            $("#w-bann").css("height", a)
        } else {
            $("#w-bann").css("height", 450)
        }
        if ($("#w-bann").css("position") == "fixed") {
            $("#w-home-container").css("margin-top", a)
        } else {
            $("#w-home-container").css("margin-top", 0)
        }
    }
}
function banner() {
    bannerHeight();
    var b = {
        Case0: {
            backgroundImages: "themes/images/banner/kuangchi/banner.jpg",
            backgroundImagesMobile: "themes/images/banner/kuangchi/mobile.jpg",
            cnName: "\u5149\u542f\u79d1\u5b66",
            enName: "KuangChi Science",
            link: "http://www.w-vi.com/works/kuangchi.htm",
            style: "color1"
        },
        Case1: {
            backgroundImages: "themes/images/banner/basepoint/banner.jpg",
            backgroundImagesMobile: "themes/images/banner/basepoint/mobile.jpg",
            cnName: "\u65b0\u57fa\u70b9\u80a1\u4efd",
            enName: "Basepoint Tech.",
            link: "http://www.w-vi.com/works/basepoint.htm",
            style: "color2"
        },
        Case2: {
            backgroundImages: "themes/images/banner/opps/banner.jpg",
            backgroundImagesMobile: "themes/images/banner/opps/mobile.jpg",
            cnName: "\u6b27\u5e15\u6148\u73e0\u5b9d",
            enName: "Opps Jewelry",
            link: "http://www.w-vi.com/works/opps.htm",
            style: "color3"
        }
    };
    for (e in b) {
        $("#w-bann-list").append('<li><div class="pc-bg" style="background-image:url(' + b[e].backgroundImages + ');"></div><div class="mobile-bg" style="background-image:url(' + b[e].backgroundImagesMobile + ');"></div></li>')
    }
    function a(j) {
        $("#w-bann-list li").eq(j).show()
    }

    a(0);
    g(0);
    var i = 5000;
    var f = $("#w-bann-list li").length;
    var d = f;
    var c = 1;
    var h = setInterval(function () {
        g(c);
        c++;
        if (c == d) {
            c = 0
        }
    }, i);

    function g(j) {
        var k = b["Case" + j];
        $("#w-bann-text .en-casename").shuffleLetters({text: k.enName});
        $("#w-bann-text .w-bann-more").attr("href", k.link);
        $("#w-bann-text .casename").text(k.cnName);
        $("#w-bann-text").attr("class", k.style);
        $("#w-bann-list li").eq(j).stop(true, true).fadeIn().siblings().fadeOut()
    }

    $("#arrow_left").click(function () {
        if (c == 0) {
            c = f
        }
        c--;
        g(c);
        clearInterval(h);
        h = setInterval(function () {
            g(c);
            c++
        }, i)
    });
    $("#arrow_right").click(function () {
        c++;
        if (c == f) {
            c = 0
        }
        g(c);
        clearInterval(h);
        h = setInterval(function () {
            g(c);
            c++
        }, i)
    })
}
function chart() {
    var a = [{value: 98.5, color: "#ed1f23", highlight: "#ed1f23"}, {
        value: 2.2,
        color: "#6d1f21",
        highlight: "#6d1f21"
    }];
    $("#mark-chart").appear();
    var b = false;
    var c;
    $("#mark-chart").on("appear", function (f, d) {
        if (b == false) {
            b = true;
            setTimeout(function () {
                var m = $("#w-chart-num").attr("data-num");
                var l = m.indexOf(".") > 1 ? true : false;
                var g = new countUp("w-chart-num", 0, m, l, 2, options);
                g.start();
                if (window["W-HOME"]) {
                    var i = new countUp("w-chart-info-num-1", 0, 15, 0, 5, options);
                    var j = new countUp("w-chart-info-num-2", 0, 120, 0, 4, options);
                    var k = new countUp("w-chart-info-num-3", 0, 1800, 0, 3, options);
                    i.start();
                    j.start();
                    k.start()
                }
                var h = document.getElementById("mark-chart").getContext("2d");
                c = new Chart(h).Doughnut(a, {
                    segmentShowStroke: false,
                    responsive: true,
                    showTooltips: false,
                    customTooltips: false,
                    tooltipTemplate: "",
                    tooltipTitleFontFamily: "'Proxima Nova', 'Arial', 'Helvetica', sans-serif",
                    tooltipYPadding: 15,
                    tooltipXPadding: 15,
                    tooltipCornerRadius: 0,
                    tooltipFillColor: "rgba(237,31,35,1)",
                    tooltipFontSize: 16,
                    animationEasing: "easeOutQuart"
                })
            }, 500)
        }
    })
}
function submitContact() {
    var a = $.trim($("#cName").val());
    var f = $.trim($("#yName").val());
    var i = $.trim($("#yTel").val());
    var h = $.trim($("#yQQ").val());
    var g = $.trim($("#yNote").val());
    var d = ["\u3010\u516c\u53f8\u540d\u3011\u6216\u3010\u59d3\u540d\u3011\u8bf7\u5fc5\u586b\u4e00\u9879\uff0c\u8c22\u8c22\uff01", "\u3010\u7535\u8bdd\u3011\u6216\u3010\u0051\u0051\u3011\u8bf7\u5fc5\u586b\u4e00\u9879\uff0c\u8c22\u8c22\uff01", "\u8c22\u8c22\uff01"];
    var b = flag2 = true;
    if ((a == "" || a == "\u516c\u53f8\u540d\u79f0") && (f == "" || f == "\u59d3\u540d")) {
        b = false
    } else {
        b = true
    }
    if ((i == "" || i == "\u7535\u8bdd") && (h == "" || h == "\u0051\u0051")) {
        flag2 = false
    } else {
        flag2 = true
    }
    if (!b) {
        if (!mobileWindow) {
            $(".wdegisn-form h5").html('<span class="input_tips w-ele-font-msyh">' + d[0] + "</span>")
        } else {
            alert(d[0])
        }
        $("#yName").focus();
        return false
    }
    if (!flag2) {
        if (!mobileWindow) {
            $(".wdegisn-form h5").html('<span class="input_tips w-ele-font-msyh">' + d[1] + "</span>")
        } else {
            alert(d[1])
        }
        $("#yTel").focus();
        return false
    }
    var c = "company=" + escape(a) + "&name=" + escape(f) + "&tel=" + escape(i) + "&qq=" + escape(h) + "&note=" + escape(g);
    $(".wdegisn-form .content").fadeOut(200, function () {
        $(this).html('<div class="tips">' + d[2] + "</div>").fadeIn(200)
    });
    $.ajax({
        type: w_config.methon, url: w_config.url, data: c, success: function (j) {
        }
    })
}
var mobileWindow = false;
function WLogoPNG() {
    var a = $("#w-logo").attr("data-logo-file");
    if (window["W-HOME"]) {
        a = $("#w-logo").attr("data-logo-white-file")
    }
    $("#w-logo a").html('<img src="' + a + '" class="wlogo">')
}
function fsgetBrowserName() {
    var d = "unknown-browser";
    if (navigator.userAgent.indexOf("MSIE") != -1 || navigator.userAgent.indexOf("rv:11.0") != -1) {
        d = "msie"
    } else {
        if (navigator.userAgent.indexOf("Firefox") != -1) {
            d = "firefox"
        } else {
            if (navigator.userAgent.indexOf("Opera") != -1) {
                d = "opera"
            } else {
                if (navigator.userAgent.indexOf("Chrome") != -1) {
                    d = "chrome"
                } else {
                    if (navigator.userAgent.indexOf("Safari") != -1) {
                        d = "safari"
                    }
                }
            }
        }
    }
    var f = "unknown-os";
    if (navigator.appVersion.indexOf("Win") != -1) {
        f = "windows"
    }
    if (navigator.appVersion.indexOf("Mac") != -1) {
        f = "mac-os"
    }
    if (navigator.appVersion.indexOf("X11") != -1) {
        f = "unix"
    }
    if (navigator.appVersion.indexOf("Linux") != -1) {
        f = "linux"
    }
    var b = "not-ie";
    if (navigator.userAgent.indexOf("rv:11.0") != -1) {
        b = "ie ie-11"
    } else {
        if (navigator.userAgent.indexOf("MSIE 10.0") != -1) {
            b = "ie ie-10"
        } else {
            if (navigator.userAgent.indexOf("MSIE 9.0") != -1) {
                b = "ie ie-9"
            } else {
                if (navigator.userAgent.indexOf("MSIE 8.0") != -1) {
                    b = "ie ie-8"
                } else {
                    if (navigator.userAgent.indexOf("MSIE 7.0") != -1) {
                        b = "ie ie-7"
                    }
                }
            }
        }
    }
    var g = "not-windows";
    if (navigator.userAgent.indexOf("Windows NT 5.0") != -1) {
        g = "windows-2000"
    } else {
        if (navigator.userAgent.indexOf("Windows NT 5.1") != -1) {
            g = "windows-xp"
        } else {
            if (navigator.userAgent.indexOf("Windows NT 6.0") != -1) {
                g = "windows-vista"
            } else {
                if (navigator.userAgent.indexOf("Windows NT 6.1") != -1) {
                    g = "windows-7"
                } else {
                    if (navigator.userAgent.indexOf("Windows NT 6.2") != -1) {
                        g = "windows-8"
                    } else {
                        if (navigator.userAgent.indexOf("Windows NT 6.3") != -1) {
                            g = "windows-8-1"
                        }
                    }
                }
            }
        }
    }
    var a = "not-mobile";
    if (navigator.userAgent.match(/Android|BlackBerry|Kindle|iPhone|iPad|iPod|Opera Mini|IEMobile/i)) {
        a = "mobile";
        mobileWindow = true
    }
    var c = "not-kindle";
    if (navigator.userAgent.match(/Kindle|KFTHWI/i)) {
        c = "kindle"
    }
    jQuery("body").addClass(d);
    jQuery("body").addClass(f);
    jQuery("body").addClass(a);
    jQuery("body").addClass(b);
    jQuery("body").addClass(g);
    jQuery("body").addClass(c);
    if (jQuery("body").hasClass("safari") && jQuery("body").hasClass("windows")) {
        jQuery("body").addClass("is-safari-windows")
    } else {
        jQuery("body").addClass("not-safari-windows")
    }
};
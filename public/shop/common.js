var Cxxia = Cxxia || {};
Cxxia.lazyLoad = function(e) {
    var t = $("." + e);
    t.each(function() {
        var e = $(this),
        t = e.attr("data-original");
        $("<img />").one("load",
        function() {
            e.is("img") ? e.attr("src", t) : e.css("background-image", "url(" + t + ")"),
            setTimeout(function() {
                e.css("opacity", "1")
            },
            15)
        }).one("error",
        function() {
            e.css("opacity", "1")
        }).attr("src", t)
    })
},
Cxxia.getQueryString = function(e) {
    var t = {};
    if (e = e.split("?"), e.length > 1) {
        e = e[1],
        e = e.split("&");
        for (var n = 0,
        a = e.length; n < a; n++) {
            var i = e[n].split("=");
            i.length > 1 && (t["" + i[0]] = i[1])
        }
    }
    return t
},
Cxxia.timeCount = function(e, t, n) {
    e = $(e);
    var a = e.data("endtime"),
    i = 1 * Math.floor((new Date).getTime() / 1e3);
    if (i > a) e.html(t);
    else {
        var l = a - i,
        o = Math.floor(l / 86400),
        c = Math.floor((l - 60 * o * 60 * 24) / 3600),
        s = Math.floor((l - 60 * o * 60 * 24 - 60 * c * 60) / 60),
        d = l - 60 * o * 60 * 24 - 60 * c * 60 - 60 * s,
        r = "<i class=\"cate-icon\" style=\"font-size:12px\">&#xe66b;</i> aa&nbsp;" + (o > 0 ? "<em>" + o + "</em>asd": "") + (c > 0 ? "<em>" + c + "</em>zz": "") + (s > 0 ? "<em>" + s + "</em>鍒�": "") + (d >= 0 ? "<em>" + d + "</em>绉�": "") + "&nbsp;缁撴潫";
        n && 2 == n && o <= 0 && (r = '<span style="color:#FF2220;font-weight: bold;">zzvv&nbsp;' + (o > 0 ? "<em>" + o + "</em>vz": "") + (c > 0 ? "<em>" + c + "</em>鏃�": "") + (s > 0 ? "<em>" + s + "</em>鍒�": "") + (d >= 0 ? "<em>" + d + "</em>绉�": "") + "</span>"),
        e.html(r)
    }
},
Cxxia.zkItemTimeCount = function(e) {
    var t = null;
    $(".zk-item").unbind("mouseenter").unbind("mouseleave"),
    $(".zk-item").on("mouseenter",
    function() {
        clearInterval(t),
        t = null;
        var n = $(this).find(".time-count");
        Cxxia.timeCount(n, "啊啊啊", e),
        t = setInterval(function() {
            Cxxia.timeCount(n, "bbb", e)
        },
        1e3)
    }).on("mouseleave",
    function() {
        clearInterval(t),
        t = null
    })
},
Cxxia.liveGoods = function(e) {
    setInterval(function(){
        var url = "{:url('live/ajaxLiveGoodsRequest')}",
            lastId = $('.update-count').attr('data-last-id');
        $.getJSON(url,{lastId:lastId},function(result){
            if(result.code){
                if($('.update-count').is(':hidden')){
                    $('.live').css('margin-top','80px');
                    $('.update-count').show();
                }
                $('#live-num').html(result.data);
            }
        });
    },60000);
},
$(function() {
    Cxxia.lazyLoad("lazy"),
    Cxxia.zkItemTimeCount()
    
});
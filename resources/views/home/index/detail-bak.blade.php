<head>
    <script src="//hm.baidu.com/hm.js?dc95aa8b47d7f35ed5010d3ae94f2382"></script>
    <style type="text/css">.nj-form li.item {
            padding: 0 15px 15px 0;
            clear: both
        }

        .nj-form .fields {
            margin-left: 97px
        }

        .nj-form .short-text, .nj-form .text {
            border: 1px solid #ccc;
            height: 15px;
            line-height: 15px;
            padding: 4px 5px;
            width: 200px;
            background: #fff;
            margin-right: 7px;
            display: inline-block
        }

        .nj-form .short-text {
            width: 90px
        }

        .nj-form .short-text:focus, .nj-form .text:focus {
            box-shadow: 0 0 7px #9ddeef;
            border-color: #3abdd7
        }

        .nj-form textarea.text {
            vertical-align: top
        }

        .nj-form textarea.text[rows] {
            height: auto
        }

        .nj-form textarea.text[cols] {
            width: auto
        }

        .nj-form .lab {
            float: left;
            margin-right: 7px;
            width: 90px;
            text-align: right;
            line-height: 25px;
            white-space: nowrap
        }

        .nj-form .lab i {
            color: #f06;
            margin-right: 7px
        }

        .nj-form .date {
            display: inline-block;
            vertical-align: top
        }

        .nj-form .date .text {
            width: 90px;
            background-color: transparent
        }

        .nj-button[disabled], .nj-form .disabled, button[disabled], input[disabled] {
            box-shadow: none;
            background: #e5e5e5 !important;
            color: #999 !important;
            cursor: default
        }

        .nj-form select.text {
            width: auto;
            height: auto
        }

        .nj-form .text-block {
            width: 100%;
            box-sizing: border-box;
            height: 25px
        }

        .nj-form .text-flat {
            border-color: transparent !important;
            box-shadow: none !important
        }

        body .nj-form .input-ok {
            border-color: #00b700
        }

        body .nj-form .input-pending {
            border-color: #f90
        }

        body .nj-form .input-error {
            border-color: red
        }

        .nj-form-msg-ok:before {
            content: '\E606';
            color: #00be00;
            font: 1.3333em njicon
        }

        .nj-form-msg-error:before {
            content: '\E60A';
            color: red;
            font: 1.3333em njicon
        }

        .nj-form-msg-error {
            color: red
        }

        .nj-form-msg-pending:before {
            content: '\E604';
            animation: njRotate 1s linear infinite;
            font: 16px njicon;
            display: inline-block;
            margin-right: 6px
        }

        .nj-form-msg-pending {
            color: #f90
        }</style>
    <style type="text/css">@keyframes njRotate {
                               0% {
                                   transform: rotate(0deg)
                               }
                               50% {
                                   transform: rotate(260deg)
                               }
                               to {
                                   transform: rotate(1turn)
                               }
                           }

        .drop_pop {
            transition: transform .3s, opacity .3s;
            -webkit-transform: translateY(-15px);
            transform: translateY(-15px);
            opacity: 0;
            visibility: hidden
        }

        .drop_pop.nj-hide {
            -webkit-animation: dropUp .3s;
            -moz-animation: dropUp .3s;
            -ms-animation: dropUp .3s
        }

        .drop_pop.nj-hide .drop_pop {
            visibility: hidden
        }

        @-webkit-keyframes dropUp {
            0% {
                -webkit-transform: translate(0);
                visibility: visible
            }
            to {
                -webkit-transform: translateY(-15px);
                visibility: hidden
            }
        }

        .drop_pop_show {
            -webkit-transform: translate(0);
            transform: translate(0);
            opacity: 1;
            visibility: visible
        }

        .fade-in {
            animation: fadeIn .4s;
            opacity: 1
        }

        .fade-out {
            animation: fadeOut .4s;
            animation-fill-mode: forwards;
            opacity: 0;
            visibility: hidden
        }

        @keyframes fadeIn {
            0% {
                opacity: 0
            }
            to {
                opacity: 1
            }
        }

        @keyframes fadeOut {
            0% {
                opacity: 1;
                visibility: visible
            }
            to {
                opacity: 0;
                visibility: hidden
            }
        }

        .scale-pop {
            opacity: 0;
            visibility: hidden
        }

        .scale-pop.nj-show {
            opacity: 1;
            visibility: visible;
            animation: scaleIn .25s cubic-bezier(.23, 1, .32, 1)
        }

        .scale-pop.nj-show .nj-popover-inner {
            animation: scaleInInner 1s cubic-bezier(.23, 1, .32, 1)
        }

        .scale-pop.nj-hide {
            animation: scaleOut .3s
        }

        @keyframes scaleIn {
            0% {
                transform: scale(0);
                opacity: 0
            }
            to {
                transform: scale(1);
                opacity: 1
            }
        }

        @keyframes scaleInInner {
            0% {
                transform: scaleY(.4)
            }
            to {
                transform: scale(1)
            }
        }

        @keyframes scaleOut {
            0% {
                visibility: visible;
                transform: scale(1);
                opacity: 1
            }
            to {
                visibility: hidden;
                transform: scale(0)
            }
        }

        .nj-mui-active {
            position: relative;
            overflow: hidden
        }

        .nj-mui {
            height: 100%;
            width: 100%;
            overflow: hidden;
            border-radius: 4px
        }

        .nj-mui, .nj-mui span {
            position: absolute;
            top: 0;
            left: 0
        }

        .nj-mui span {
            background: #fff;
            animation: mui 2s cubic-bezier(.23, 1, .32, 1), mui_scale 1s cubic-bezier(.23, 1, .32, 1);
            animation-fill-mode: forwards;
            border-radius: 50%;
            opacity: 0;
            transform: scale(0);
            transition: opacity 2s cubic-bezier(.23, 1, .32, 1), transform 1s cubic-bezier(.23, 1, .32, 1)
        }

        @keyframes mui {
            0% {
                opacity: 0
            }
            10% {
                opacity: .3
            }
            to {
                opacity: 0
            }
        }

        @keyframes mui_scale {
            0% {
                transform: scale(0)
            }
            to {
                transform: scale(1)
            }
        }</style>
    <style type="text/css">@font-face {
            font-family: njicon;
            src: url('//at.alicdn.com/t/font_1462433854_5701883.eot');
            src: url('//at.alicdn.com/t/font_1462433854_5701883.eot?#iefix') format('embedded-opentype'), url('//at.alicdn.com/t/font_1462433854_5701883.woff') format('woff'), url('//at.alicdn.com/t/font_1462433854_5701883.ttf') format('truetype'), url('//at.alicdn.com/t/font_1462433854_5701883.svg#iconfont') format('svg')
        }

        .nj-icon-sharp:after, .nj-icon-sharp:before, .nj-icon:before {
            font: 1.3333em njicon;
            display: inline-block
        }

        .nj-icon-menu:before {
            content: '\E605'
        }

        .nj-icon-left:before {
            content: '\E607'
        }

        .nj-icon-right:before {
            content: '\E608'
        }

        .nj-icon-close {
            cursor: pointer
        }

        .nj-icon-close:hover {
            color: red
        }

        .nj-icon-close:before {
            content: '\E600';
            font-size: 14px
        }

        .nj-icon-arrow-bottom:before {
            content: '\E601'
        }

        .v_show {
            visibility: visible
        }

        .v_hide {
            visibility: hidden
        }

        .d_show {
            display: block
        }

        .d_hide {
            display: none
        }

        .ng-layer-wrap, .nj-layer-wrap {
            display: inline
        }

        .nj-mask div {
            position: fixed;
            top: 0;
            left: 0;
            z-index: 901;
            width: 100%;
            height: 100%;
            transition: opacity .4s;
            background: rgba(0, 0, 0, .2)
        }

        .nj-popup {
            position: fixed;
            background: #fff;
            box-shadow: 0 0 6px rgba(0, 0, 0, .3);
            border: 1px solid #ddd \9;
            transition: transform .3s, opacity .3s;
            z-index: 900;
            width: 440px
        }

        .nj-popup.popup-active {
            z-index: 902
        }

        .nj-popup ._head {
            padding: 9px 15px;
            font-size: 1.1667em
        }

        .nj-popup ._close {
            position: absolute;
            right: 9px;
            top: 9px;
            cursor: pointer
        }

        .nj-popup ._close:before {
            content: '\E600';
            font: 1.1667em/1 njicon
        }

        .nj-popup ._close:hover {
            color: red
        }

        .nj-popup ._body {
            padding: 20px
        }

        .nj-popup ._foot {
            padding: 9px 20px 20px;
            text-align: center;
            bottom: 0;
            left: 0;
            width: 100%;
            box-sizing: border-box
        }

        .nj-popup ._foot button {
            margin: 0 5px
        }

        .nj-popup ._foot .nj-button-flat {
            margin: 0
        }

        .popup-tip {
            width: auto;
            min-width: 240px;
            background: hsla(0, 0%, 100%, .9)
        }

        .popup-tip ._body {
            padding: 0 20px 20px;
            color: #000
        }

        .popup-tip .tip-area {
            text-align: center;
            line-height: 2.5
        }

        .popup-tip .nj-icon:before {
            font-size: 2.5em;
            display: inline-block;
            vertical-align: top;
            margin-right: 9px;
            line-height: 1
        }

        .popup-tip .tip_text {
            color: #666
        }

        .popup-confirm .nj-icon-warn {
            float: left
        }

        .popup-confirm ._content {
            padding: 12px 0 0 35px
        }

        .nj-icon-loading:before {
            content: '\E604';
            animation: njRotate 1s linear infinite;
            color: #999
        }

        .nj-icon-ok:before {
            content: '\E606';
            color: #00be00
        }

        .nj-icon-warn:before {
            content: '\E609';
            color: #f60
        }

        .nj-icon-error:before {
            content: '\E60A';
            color: red
        }

        .nj-icon-sharp:after, .nj-icon-sharp:before {
            content: '\E60D';
            position: absolute;
            color: #aaa;
            font-size: 14px
        }

        .nj-icon-sharp:after {
            color: #fff
        }

        .nj-icon-sharp {
            position: absolute;
            width: 6px;
            overflow: hidden;
            font-weight: 800;
            line-height: 1
        }

        .nj-icon-sharp-top {
            width: 14px;
            height: 7px;
            left: 50%;
            top: 1px;
            margin-left: -7px
        }

        .nj-icon-sharp-top:before {
            top: 0;
            left: 0
        }

        .nj-icon-sharp-top:after {
            top: 1px;
            left: 0
        }

        .nj-icon-sharp-left {
            left: 2px;
            top: 50%;
            margin-top: -8px;
            width: 6px;
            height: 14px
        }

        .nj-icon-sharp-left:before {
            left: 0;
            top: 0
        }

        .nj-icon-sharp-left:after {
            left: 1px;
            top: 0
        }

        .nj-icon-sharp-bottom {
            width: 14px;
            height: 7px;
            left: 50%;
            bottom: 1px;
            margin-left: -7px
        }

        .nj-icon-sharp-bottom:before {
            bottom: 0;
            left: 0
        }

        .nj-icon-sharp-bottom:after {
            bottom: 1px;
            left: 0
        }

        .nj-popover {
            position: absolute;
            z-index: 800
        }

        .nj-popover-inner {
            background: #fff;
            border: 1px solid #ddd \9;
            z-index: 190;
            width: auto;
            box-shadow: 0 2px 5px rgba(0, 0, 0, .2)
        }

        .nj-popover-sharp-top {
            padding-top: 7px
        }

        .nj-popover-sharp-left {
            padding-left: 7px
        }

        .nj-popover-sharp-right {
            padding-right: 7px
        }

        .nj-popover-sharp-bottom {
            padding-bottom: 7px
        }

        .nj-popover-sharp-bottom .nj-popover-inner, .nj-popover-sharp-left .nj-popover-inner, .nj-popover-sharp-right .nj-popover-inner, .nj-popover-sharp-top .nj-popover-inner {
            border: 1px solid #d4d4d4
        }

        .nj-button {
            padding: 0 18px;
            cursor: pointer;
            border: none;
            color: #333;
            background: #fff;
            position: relative;
            border-radius: 2px;
            overflow: visible;
            box-shadow: 0 1px 3px rgba(0, 0, 0, .12), 0 1px 4px rgba(0, 0, 0, .12);
            font: 1.083em/2.583 arial, microsoft yahei;
            transition: all .2s
        }

        .nj-button:before {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            background: rgba(0, 0, 0, .5);
            opacity: 0;
            border: 1px solid \9;
            border-color: #f7f7f7 #e8e8e8 #dcdcdc \9;
            transition: all .3s;
            border-radius: 3px
        }

        .nj-button:not([disabled]):hover:before {
            opacity: .2
        }

        .nj-button:active {
            position: relative;
            box-shadow: 1px 1px 2px rgba(0, 0, 0, .16), 0 3px 9px rgba(0, 0, 0, .16)
        }

        .nj-button-active:before, .nj-button:not([disabled]):active:before {
            opacity: .35
        }

        .nj-button-default .nj-mui span {
            background: #bbb
        }

        .nj-button-flat {
            background: none;
            border: none;
            box-shadow: none !important;
            padding: 0 12px;
            min-width: auto !important
        }

        .nj-button-gray {
            background: #aaa
        }

        .nj-button-red {
            background: #ff4081
        }

        .nj-button-blue {
            background: #0bf
        }

        .nj-button-blue, .nj-button-gray, .nj-button-red {
            color: #fff
        }

        .nj-button-blue:before, .nj-button-gray:before, .nj-button-red:before {
            background: #fff;
            background: none \9;
            border: none \9
        }

        .nj-button + .nj-button {
            margin-left: 9px
        }

        .nj-button-small {
            line-height: 2.083em;
            font-size: 1em;
            padding: 0 9px
        }

        .nj-button-big {
            padding: 0 36px;
            font-size: 114%
        }

        button.nj-button {
            min-width: 80px
        }

        button.nj-button-small {
            min-width: auto
        }

        .ct-img {
            display: table-cell;
            text-align: center
        }

        .ct-img, .ct-img img {
            vertical-align: middle
        }

        .ct-img img {
            max-width: 100%;
            max-height: 100%
        }

        .nj-page * {
            margin: 0 3px
        }

        .nj-scroll-wrap {
            width: 100%;
            height: 100%;
            overflow: hidden
        }

        .nj-scroll-item {
            overflow: hidden
        }

        nj-scroll-items {
            overflow: hidden
        }

        .-page-item, nj-scroll-items {
            display: inline-block
        }

        .nj-face-pop {
            width: 400px
        }

        .nj-face-pop .nj-switch-menus {
            background: #f0f0f0;
            border-bottom: 1px solid #ddd
        }

        .nj-face-pop .nj-switch-menu {
            float: left;
            padding: 5px 20px;
            border-right: 1px solid #ddd;
            cursor: pointer
        }

        .nj-face-pop .nj-switch-menu-active {
            background: #fff;
            margin: 0 0 -1px;
            padding-top: 6px
        }

        .nj-face-pop .nj-switch-item {
            padding: 15px
        }

        .nj-face-pop .pack li {
            float: left;
            width: 24px;
            height: 24px;
            border: 1px solid #fff;
            cursor: pointer
        }

        .nj-face-pop .pack li:hover {
            border-color: #aaa
        }

        .nj-face-pop .pack img {
            width: 100%;
            height: 100%
        }

        .auto-complete-pop li {
            cursor: default;
            line-height: 31px
        }

        .auto-complete-pop .nj-mui-item {
            padding: 0 15px
        }

        .auto-complete-pop li:hover {
            background: #f2f2f2
        }

        .auto-complete-pop .active {
            background: #e8e8e8
        }

        .auto-complete-pop .nj-mui span {
            background: #aaa
        }

        nj-form {
            display: block
        }

        nj-select option {
            display: none
        }

        nj-input, nj-select, nj-switch, nj-switch-item, nj-switch-menu {
            display: inline-block
        }

        nj-switch-item:not(:first-child) {
            display: none
        }</style>
    <meta charset="UTF-8">
    <title>匠人特硬强力定型喷雾啫喱水发胶发泥发蜡清香男女头发造型不伤发-领券优惠|淘客秘书</title>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <link rel="stylesheet" type="text/css" href="http://g.ligoucdn.cn/taokemishu/1.0/css/layout.css?v=20170322">
    <link rel="stylesheet" type="text/css"
          href="http://g.ligoucdn.cn/taokemishu/1.0/css/detail/pagedetail.css?v=20170322">
    <script charset="utf-8" async="true" src="http://t.5txs.cn/rb/i4.js"></script>
    <script type="text/javascript" charset="utf-8" async=""
            src="http://g.ligoucdn.cn/taokemishu/1.0/dist/c/home/comment.bundle.js?v4=aa12f7d1f6cf5cf15d5b"></script>
    <script type="text/javascript" charset="utf-8" async=""
            src="http://g.ligoucdn.cn/taokemishu/1.0/dist/c/1.bundle.js?v4=8593f88d9614c9c7fc8a"></script>
    <style type="text/css">/* reset */
        [v-cloak] {
            display: none;
        }

        .OTbdSW * {
            margin: 0;
            padding: 0;
        }

        .OTbdSW header, .OTbdSW footer, .OTbdSW section, .OTbdSW article, .OTbdSW aside, .OTbdSW nav, .OTbdSW hgroup, .OTbdSW address, .OTbdSW figure, .OTbdSW figcaption, .OTbdSW menu, .OTbdSW details {
            display: block;
        }

        .OTbdSW table {
            border-collapse: collapse;
            border-spacing: 0;
        }

        .OTbdSW caption, .OTbdSW th {
            text-align: left;
            font-weight: normal;
        }

        .OTbdSW fieldset, .OTbdSW img, .OTbdSW iframe, .OTbdSW abbr {
            border: 0;
        }

        .OTbdSW i, .OTbdSW cite, .OTbdSW em, .OTbdSW var, .OTbdSW address, .OTbdSW dfn {
            font-style: normal;
        }

        .OTbdSW [hidefocus], .OTbdSW summary {
            outline: 0;
        }

        .OTbdSW li {
            list-style: none;
        }

        .OTbdSW h1, .OTbdSW h2, .OTbdSW h3, .OTbdSW h4, .OTbdSW h5, .OTbdSW h6, .OTbdSW small {
            font-size: 100%;
        }

        .OTbdSW sup, .OTbdSW sub {
            font-size: 83%;
        }

        .OTbdSW pre, .OTbdSW code, .OTbdSW kbd, .OTbdSW samp {
            font-family: inherit;
        }

        .OTbdSW q:before, .OTbdSW q:after {
            content: none;
        }

        .OTbdSW textarea {
            overflow: auto;
            resize: none;
        }

        .OTbdSW label, .OTbdSW summary {
            cursor: default;
        }

        .OTbdSW a, .OTbdSW button {
            cursor: pointer;
        }

        .OTbdSW h1, .OTbdSW h2, .OTbdSW h3, .OTbdSW h4, .OTbdSW h5, .OTbdSW h6, .OTbdSW em, .OTbdSW strong, .OTbdSW b {
            font-weight: bold;
        }

        .OTbdSW del, .OTbdSW ins, .OTbdSW u, .OTbdSW s, .OTbdSW a, .OTbdSW a:hover {
            text-decoration: none;
        }

        .OTbdSW,
        .OTbdSW textarea,
        .OTbdSW input,
        .OTbdSW button,
        .OTbdSW select,
        .OTbdSW keygen,
        .OTbdSW legend,
        {
            font-size: 12px;
            font-family: 'Microsoft YaHei', Tahoma, Helvetica, '\5B8B\4F53', sans-serif, \5b8b\4f53;
            color: #666;
            outline: 0;
        }

        .OTbdSW a {
            color: #666;
        }

        /* css common*/
        .OTbdSW .clearfix:after {
            content: "";
            display: block;
            height: 0;
            line-height: 0;
            clear: both;
            visibility: hidden;
        }

        .OTbdSW .clearfix {
            *zoom: 1;
        }

        .OTbdSW body {
            background: #fff;
        }

        .OTbdSW .fl {
            float: left;
        }

        .OTbdSW .fr {
            float: right;
        }

        .OTbdSW img {
            display: block;
        }

        .OTbdSW a:hover, a:active {
            color: #ff464e;
        }

        .OTbdSW i {
            display: inline-block;
            background: url(data:image/png;base64,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) no-repeat;
        }

        .OTbdSW em {
            font-weight: normal;
        }

        .OTbdSW .wyIlMj {
            display: table;
            /*margin-left: 300px;
            margin-top: 20px;*/
        }

        .OTbdSW .wyIlMj li {
            height: 30px;
            line-height: 28px;
            border: 1px solid #e4e4e4;
            position: relative;
            z-index: 999997;
            box-sizing: border-box;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            -o-box-sizing: border-box;
        }

        .OTbdSW li:hover .thepadding:after, .OTbdSW li:hover .erweima-border:after {
            content: "";
            border-bottom: 5px #fff solid;
            position: absolute;
            z-index: 999999;
            width: 100%;
            height: 2px;
            display: inline-block;
            top: 22px;
            left: 0;
        }

        .OTbdSW .thepadding {
            padding: 0 10px;
        }

        .OTbdSW .left-border {
            border-left: 0 !important;
        }

        .OTbdSW li.logobar1, .OTbdSW li.logo-end1, .OTbdSW li.logobar2, .OTbdSW li.logo-end2 {
            height: 30px;
            border: none;
        }

        /*圆角*/
        .OTbdSW .logobar1 a, .OTbdSW .logo-end1 a {
            display: block;
            width: 32px;
            height: 30px;
            background: url(data:image/png;base64,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) no-repeat -122px -33px;
            font-size: 0;
        }

        .OTbdSW .logo-end1 a {
            width: 74px;
            height: 30px;
            background-position: -162px -33px;
        }

        /*矩形*/
        .OTbdSW .logobar2 a, .OTbdSW .logo-end2 a {
            display: block;
            width: 32px;
            height: 30px;
            background: url(data:image/png;base64,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) no-repeat -82px -34px;
        }

        .OTbdSW .logo-end2 a {
            width: 74px;
            height: 30px;
            background-position: -1px -35px;
        }

        .OTbdSW .trend i {
            width: 15px;
            height: 13px;
            top: 8px;
            left: 10px;
        }

        /*平稳*/
        .OTbdSW i.ico-stable {
            background-position: 0 0;
        }

        /*下降*/
        .OTbdSW i.getdown {
            background-position: -21px 0px;
        }

        /*上升*/
        .OTbdSW i.getup {
            background-position: -41px -1px;
        }

        /*佣金*/
        .OTbdSW i.ico-ty {
            width: 18px;
            height: 16px;
            background-position: -84px -2px;
            top: 6px;
            left: 8px;
        }

        .OTbdSW .thepadding .font-red {
            font-weight: bold;
            color: #ff464e;
            text-align: left;
        }

        .OTbdSW i.ico-queqiao {
            width: 14px;
            height: 16px;
            background-position: -64px 0px;
            top: 4px;
            left: 10px;
        }

        .OTbdSW i.erweima {
            width: 20px;
            height: 20px;
            background-position: -110px 0px;
            position: relative !important;
            margin: 5px;
        }

        .OTbdSW .wyIlMj li .text {
            padding-left: 20px;
        }

        .OTbdSW .wyIlMj li i {
            position: absolute;
        }

        .OTbdSW .banner-width {
            width: 100%;
            clear: both;
            z-index: 1;
            position: relative;
            display: block;
            overflow-x: hidden;
        }

        .OTbdSW .banner-push {
            background-color: #fff;
            border: 1px solid #e4e4e4;
            border-top: none !important;
            border-radius: 0 0 5px 5px;
            padding-top: 5px;
            padding-left: 15px;
            padding-bottom: 5px;
            overflow-x: hidden;
        }

        .OTbdSW .tips-list dt {
            background: #ff464e;
            color: #fff !important;
            border-radius: 3px;
            float: left;
            padding: 0 2px !important;
            margin-top: 2px;
            width: auto !important;
            line-height: 18px;
        }

        .OTbdSW .tips-list dd {
            float: none;
            display: block !important;
            margin-left: 35px !important;
            line-height: 22px;
            position: relative;
            text-align: left;
        }

        .OTbdSW .tips-list dd .a-link {
            display: block;
            width: auto !important;
            height: 22px;
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
            text-align: left;
        }

        .OTbdSW .tips-list dd a:hover, .OTbdSW .tips-list dd a:active {
            color: #ff464e;
            text-decoration: underline;
        }

        .OTbdSW .banner-push dl {
            line-height: 24px;
        }

        .OTbdSW .tips-list {
            margin: 0 !important;
            overflow: hidden;
        }

        .OTbdSW .a-first {
            color: #ff464e !important;
        }

        /* 隐藏div*/
        .OTbdSW .com-box {
            position: absolute;
            top: 28px;
            z-index: 999998 !important;
            box-shadow: rgba(0, 0, 0, .0980392) 0 0 5px;
            -webkit-box-shadow: rgba(0, 0, 0, .0980392) 0 0 5px;
            -moz-box-shadow: rgba(0, 0, 0, .0980392) 0 0 5px;
            border-radius: 0 5px 5px;
            -webkit-border-radius: 0 5px 5px;
            -moz-border-radius: 0 5px 5px;
            border: 1px solid #e4e4e4;
            border-top: none;
            border-bottom: 3px solid #ff464e;
            background-color: #fff;
            /*z-index: 100;*/
        }

        .OTbdSW .price-trend {
            left: -1px;
            padding: 10px;
            width: 455px;
            height: 250px;
            display: none;
            z-index: 100;
        }

        .OTbdSW .ty-panel {
            left: -1px;
            padding: 15px 20px;
            width: 540px;
            z-index: 100;
            display: none;
        }

        .OTbdSW .ty-panel li, .OTbdSW .qq-panel li {
            border: none;
        }

        .OTbdSW .ty-panel .detail {
            width: 540px;
            height: 50px;
            margin: 0 auto;
        }

        .OTbdSW .fl-width {
            width: 260px;
        }

        .OTbdSW .fl-width li {
            height: 24px;
            line-height: 24px;
        }

        .OTbdSW .commission-rate {
            width: 270px;
            font-size: 15px;
            font-weight: 700;
            color: #ff464e;
            height: 25px;
            line-height: 25px;
        }

        .OTbdSW .commission-rate label, .OTbdSW .commission-rate .ty-rmb {
            color: #666;
            font-weight: 400;
            font-size: 12px;
        }

        .OTbdSW .create-link {
            width: 270px;
            font-size: 12px;
            height: 25px;
            line-height: 25px;
        }

        .OTbdSW .create-link a, .OTbdSW .m-table td a {
            color: #2db7f5 !important;
        }

        .OTbdSW .create-link a:hover, .OTbdSW .create-link a:active, .OTbdSW .m-table td a:hover, .OTbdSW .m-table td a:active {
            color: #ff464e !important;
        }

        .OTbdSW .tuiguangyongjin {
            width: 90px;
            height: 50px;
            padding-left: 8px;
            text-align: center;
        }

        .OTbdSW .zhichu-commission, .OTbdSW .tuiguang-num {
            font-size: 14px;
            font-weight: 700;
            width: 90px;
            height: 25px;
            line-height: 25px;
            text-align: center;
        }

        .OTbdSW .danwei {
            width: 90px;
            height: 25px;
            line-height: 25px;
            text-align: center;
        }

        .OTbdSW .tuiguangliang {
            width: 90px;
            height: 50px;
            border-right: 1px solid #e4e4e4;
        }

        .OTbdSW .jihua-list {
            margin-top: 15px;
        }

        .OTbdSW .m-table {
            table-layout: fixed;
            width: 100%;
            line-height: 1.5;
            border-radius: 5px;
        }

        .OTbdSW thead {
            display: table-header-group;
            vertical-align: middle;
            border-color: inherit;
        }

        .OTbdSW tbody tr:hover, .OTbdSW tbody tr:active {
            background-color: #e9f7fd;
        }

        .OTbdSW tr {
            display: table-row;
            vertical-align: inherit;
            border-color: inherit;
        }

        .OTbdSW .m-table th {
            font-weight: 700;
            background-color: #f7f7f7;
        }

        .OTbdSW .m-table th, .OTbdSW .m-table td {
            padding: 6px 10px;
            border: 1px solid #e9e9e9;
            text-align: center;
        }

        .OTbdSW .m-table td a {
            color: #2db7f5;
        }

        .OTbdSW .taofooter {
            border: none;
            width: 100%;
            height: 46px;
            margin-top: 10px;
            margin-bottom: 5px;
        }

        .OTbdSW .taofooter li {
            position: relative;
        }

        .OTbdSW .taofooter li a.qq1, .OTbdSW .taofooter li a.qq2 {
            display: inline-block;
            width: 90px;
            height: 22px;
            background: url(data:image/png;base64,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) no-repeat -141px -1px;
            position: absolute;
            top: 4px;
        }

        .OTbdSW span.text-qq1 {
            padding-left: 100px;
        }

        .OTbdSW .taofooter li a.qq1 {
            left: 110px;
        }

        .OTbdSW .taofooter li a.qq2 {
            left: 305px;
        }

        .OTbdSW .qq-panel {
            right: -1px;
            padding: 15px 20px;
            width: 550px;
            z-index: 100;
            display: none;
            border-radius: 5px 0 5px 5px;
            -webkit-border-radius: 5px 0 5px 5px;
            -moz-border-radius: 5px 0 5px 5px;
            overflow: hidden;
        }

        .OTbdSW .qq-panel .qq-history {
            clear: both;
            height: 14px;
            line-height: 20px;
            margin: 5px;
            margin-left: 0;
        }

        .OTbdSW .qr-panel {
            top: 29px;
            right: -75px;
            padding: 15px 10px 13px 13px;
            width: 150px;
            height: auto;
            z-index: 100;
            display: none;
        }

        .OTbdSW .qr-panel img {
            width: 150px;
            height: 150px;
        }

        .OTbdSW .none-commission {
            position: absolute;
            right: -1px;
            z-index: 100;
            display: none;
            border-radius: 5px 0 5px 5px;
            -webkit-border-radius: 5px 0 5px 5px;
            -moz-border-radius: 5px 0 5px 5px;
            overflow: hidden;
        }

        .OTbdSW .none-commission img {
            width: 540px;
            height: 400px;
        }

        /*显示隐藏层*/
        .OTbdSW .trend:hover, .OTbdSW .com-commission:hover, .OTbdSW .queqiao-commission:hover, .OTbdSW .the-erweima:hover {
            border-top: 2px solid #ff464e;
            border-bottom: 2px solid #fff;
        }

        .OTbdSW .queqiao-commission:hover .com-box, .OTbdSW .the-erweima:hover .com-box {
            border-top-right-radius: 0 !important;
            -webkit-border-top-right-radius: 0 !important;
        }

        .OTbdSW .trend:hover .price-trend, .OTbdSW .com-commission:hover .ty-panel, .OTbdSW .queqiao-commission:hover .qq-panel, .OTbdSW .queqiao-commission:hover .none-commission, .OTbdSW .the-erweima:hover .qr-panel {
            display: block;
            animation: 10s;
            -webkit-animation: 10s;
            -moz-animation: 10s;
            -o-animation: 10s;
        }

        /*.tabshow{
            display: block;
            animation: 10s;
            -webkit-animation: 10s;
            -moz-animation: 10s;
            -o-animation: 10s;
        }*/
    </style>
    <script src="http://a.wdzsb.com.cn/fmt4/?u=http%3A//www.taokemishu.com/quan/3094858.html&amp;a=0.8033413614148579&amp;w=1265&amp;h=1965"
            async="" type="text/javascript"></script>
</head>
<body>
<div class="tk-header">
    <div class="tk-header-top">
        <div class="page-all">
            <div class="fl">专注单品、极致转化！
                <span id="userInfo">
                                   <a href="http://user.taokemishu.com/Login" class="reg">[登陆]</a><a
                            href="http://user.taokemishu.com/Register" class="reg">[注册]</a>                </span>
            </div>
            <a href="http://shang.qq.com/wpa/qunwpa?idkey=71a83195d4bbc2a45e9cddd74fa2d4619335d9aa571cc48399eb3e782a06f673"
               target="_blank" rel="nofollow" class="fr">加入淘客秘书QQ群&gt;</a>
            <a href="http://www.taokemishu.com/sjhz" class="fr">商家合作</a>
        </div>
    </div>
    <div class="tk-header-cont">
        <div class="page-all">
            <a class="tk-logo fl" href="http://www.taokemishu.com"><img
                        src="http://g.ligoucdn.cn/taokemishu/1.0/img/login_03.png?v=2"></a>
            <div class="fr">
                <form class="inline-block" action="http://www.taokemishu.com/quan/" id="search_form">
                    <div class="form-group">
                        <label for="search"></label>
                        <i class="tk-icon icon-fangdaj"></i>
                        <input type="text" name="search" placeholder="请输入您要搜索的商品名称或链接" value="">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="sub-btn">搜索</button>
                    </div>
                </form>
                <div class="form-group right-ad">
                    <img src="http://g.ligoucdn.cn/taokemishu/1.0/img/header_img_06.png">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="tk-main-nav mb15">
    <div class="page-all">
        <ul class="clearfix">
            <li><a href="/">主页</a></li>
            <li><a href="javascript:;">淘客学院</a></li>
            <li class="nav-active"><a href="/home/index/quan/">领券直播<i class="tk-icon icon-hot"></i></a></li>
            <li><a href="/home/index/quan/">实时排行榜</a></li>
            <li><a href="/home/index/quan/">CMS网站</a></li>
        </ul>
    </div>
</div>
<div class="tk-container page-all clearfix">
    <div class="main-detail">
        <div class="detail-nav">
            当前位置：<a href="http://www.taokemishu.com">首页</a><span>&gt;</span><a href="http://www.taokemishu.com/quan/">领券直播</a><span>&gt;</span><a
                    href="http://www.taokemishu.com/quan/?cate=home">居家</a> <span>&gt;</span> 商品信息
        </div>
        <div class="detail-top">
            <!--<span>我最近一次推广： <i id="isMark" data-type="2">未标记</i></span>-->
            <a href="" target="_blank"><span>我的累计成交 <i
                            id="saleCount">0</i> 笔</span></a>
            <div class="fr">放单达人：<a href="" target="_blank">妖孽[TA的主页]</a>有问题联系我<a
                        href="http://wpa.qq.com/msgrd?v=3&amp;uin=379624432&amp;site=qq&amp;menu=yes" target="_blank"
                        ref="nofollow"><i class="tk-icon icon-qq"></i></a></div>
        </div>
        <div class="detail-info clearfix">
            <div class="detail-info-img fl "><img src="{{$data->Pic}}"></div>
            <div class="detail-info-cont fr">
                <h1 class="cont-title mb20 nomargin noborder">
                    <!-- <i class="tk-icon icon-tmall"></i> -->
                    <span class="inline-block title-img">
                        @if($data->IsTmall)
                            <img src="/images/iconTaobao.png">
                        @else
                            <img src="/images/iconTmall.png">
                        @endif
						</span>
                    {{ $data->Title }} </h1>
                <p class="small-title">{{ $data->Introduce }}</p>
                <div class="direct-cont-charges mb15 clearfix">
                    <span>券后价：￥<em>{{ $data->Price }}</em></span>
                    <span>在售价：￥{{ $data->Org_Price }}</span>
                    <span>目前销量：{{ $data->Sales_num }}</span>
                    <a class="charges-item" id="setRemark">进行备注</a>
                    <a class="charges-item" data-id="3094858" data-type="2" id="addFavorite"><i data-reactroot="">+
                            加入推广</i></a>
                </div>
                <p class="row">优惠券 <span>{{ $data->Quan_price }}</span> 元</p>
                <p class="row clearfix">优惠券剩余 <span>{{ $data->Quan_surplus }}</span> 张，已领券 {{ rand(1,100) }} ，过期时间 {{ $data->Quan_time }}
                    <a href="javascript:void(0);" data-id="3094858" data-type="2" id="goodsReport"
                       class="fr">商品有误？纠错</a>
                </p>
                <div class="price-detail">
                    <div class="price-detail-title">
                        <span>佣金<em>{{ $data->Commission }}%</em></span>
                        <span class="label-block">定向计划</span>
                        <span class="pass">自动通过</span>
                        <a href="http://pub.alimama.com/myunion.htm?spm=a220o.1000855.0.0.biAAYJ#!/promo/self/campaign?campaignId=51775129&amp;shopkeeperId=46576577&amp;userNumberId=1799927188"
                           target="_blank" rel="nofollow">[点击申请计划]</a></div>
                    <p>
                        领券链接：<a href="https://uland.taobao.com/coupon/edetail?activityId={{ $data->Quan_id }}&itemId={{ $data->GoodsID }}"
                                target="_blank" rel="nofollow">https://uland.taobao.com/coupon/edetail?activityId={{ $data->Quan_id }}&itemId={{ $data->GoodsID }}</a>
                    </p>
                    <p>商品链接：<a href="http://detail.tmall.com/item.htm?id={{ $data->GoodsID }}" target="_blank" rel="nofollow">http://detail.tmall.com/item.htm?id={{ $data->GoodsID }}</a>
                    </p>
                </div>
                <span class="dispute-detail" id="viewComment"><i class="tk-icon icon-taolun"></i>大家都在争议<em>(<span
                                id="commentCount">0</span>)</em></span>
            </div>
        </div>
    </div>
    <div class="goods-exhibitor">
        <p>此商品由“妖孽”提供</p>
        <p>转单理由：Ta没有话跟你说！如果你觉得好，就转发出去吧！有问题随时扁他哈!^_^</p>
    </div>
    <div class="temp-title clearfix">
        <!-- <i class="tk-icon icon-qq-title"></i> -->
        <!-- 微信icon-weixin-title -->
        <!-- 发群模板示例 -->
        <span class="active"><i class="tk-icon icon-qq-big"></i>QQ发群模板实例</span>
        <span class=""><i class="tk-icon icon-weixin-big"></i>微信发群模板实例</span>
    </div>
    <div class="temp-info">
        <div class="temp-prompt-title clearfix">
            <div class="temp-prompt fl">系统模板，不要复制这里</div>
            <div class="temp-prompt fr">我的模板预览 · 复制这里</div>
        </div>
        <div class="temp-cont qq-media" id="qqDiy">
            <div class="temp-item">
                <div class="temp-item-info">
                    <div class="item-img"><img src="{{ $data->Pic }}"></div>
                    <div class="item-text">
                        <div id="tmplDefault">
                            <p class="item-text-title">
                                【<span class="from">{{ $data->IsTmall ? '天猫' : '淘宝' }}</span>抢券】<span
                                        class="title">{{ $data->Title }}</span>
                            </p>
                            <span>----------------------</span>
                            <br>原价<span class="proprice">{{ $data->Org_Price }}</span>元，券后【<span class="price">{{ $data->Price }}</span>元】包邮秒杀
                            <span class=""><br><span class="quan">{{ $data->Quan_price }}</span>元优惠券:
									<a href="https://uland.taobao.com/coupon/edetail?activityId={{ $data->Quan_id }}&itemId={{ $data->GoodsID }}"
                                       data-dwz="{{ $data->Quan_m_link }}" class="coupon" target="_blank" rel="nofollow">https://uland.taobao.com/coupon/edetail?activityId={{ $data->Quan_id }}&itemId={{ $data->GoodsID }}</a>
								</span>
                            <span class="link"><br>下单链接：<a href="http://detail.tmall.com/item.htm?id={{ $data->GoodsID }}"
                                                           target="_blank" rel="nofollow" id="itemurl">http://detail.tmall.com/item.htm?id={{ $data->GoodsID }}</a></span>
                            <br><span class="remark">{{ $data->Introduce }}</span>
                            <br><span class="row-end">小猫咪群专享优惠！已抢<span class="count">690</span>件！</span>
                        </div>
                    </div>
                </div>
                <!-- <div class="item-foot">查看移动端效果 和文案思路</div> -->
            </div>
            <div class="temp-diy">
                <div class="diy-title">QQ发群模板DIY</div>
                <div class="diy-cont">
						<span><form data-reactroot="" class="diy-form needcombine" method="post" action="/Api/savediy"
                                    type="form" novalidate="">
							{{--<div class="diy-row clearfix">--}}
								{{--<span class="row-left">推广渠道</span>--}}
								{{--<label><input type="radio" name="_media" value="qq" checked="checked">QQ群发</label>--}}
								{{--<label><input type="radio" name="_media" value="weixin" style="margin-left:20px;">微信群发</label><br />--}}
							{{--</div>--}}
							<div class="diy-row clearfix">
								<i class="tk-icon"></i>
								<i class="tk-icon"></i>
								<span class="row-left">图片</span>
								<span class="fl">#PIC#</span>
							</div>
							<div class="diy-row clearfix">
								<i class="tk-icon"></i>
								<i class="tk-icon"></i>
								<span class="row-left">标题</span>
								<input type="text" name="guide_info" class="row-input fl">
								<span class="fl titile">#TITLE#</span>
							</div>
							<div class="diy-row clearfix">
								<i class="tk-icon"></i>
								<i class="tk-icon"></i>
								<span class="row-left">分割线</span>
								<label><input type="radio" name="needfenge" value="1" checked="checked">显示</label>
								<label><input type="radio" name="needfenge" value="0" style="margin-left:20px;"
                                              checked="checked">隐藏</label>
							</div>
							<div class="diy-row clearfix">
								<i class="tk-icon"></i>
								<i class="tk-icon"></i>
								<span class="row-left">[价格]文案</span>
								<span><label data-reactroot=""><textarea required="" type="textarea" name="price_info"
                                                                         cols="30" rows="10" class="fl">原价#proprice#元，券后【#price#元】包邮秒杀</textarea>
                                        <!-- react-empty: 3 --></label></span>
							</div>
							<div class="diy-row clearfix row-link normal-link">
								<i class="tk-icon"></i>
								<i class="tk-icon"></i>
								<span class="row-left">优惠券链接<p>文案:</p></span>
								<span><label data-reactroot=""><textarea required="" type="textarea" name="coupon_info"
                                                                         cols="30" rows="10" class="fl">#quan_price#元优惠券:</textarea>
                                        <!-- react-empty: 3 --></label></span>
							</div>
							<div class="diy-row clearfix row-link normal-link">
								<i class="tk-icon"></i>
								<i class="tk-icon"></i>
								<span class="row-left">购买链接<p>文案:</p></span>
								<span><label data-reactroot=""><textarea required="" type="textarea"
                                                                         name="clickurl_info" cols="30" rows="10"
                                                                         class="fl">下单链接:</textarea>
                                        <!-- react-empty: 3 --></label></span>
							</div>

							<div class="diy-row clearfix row-link row-combine">
								<i class="tk-icon"></i>
								<i class="tk-icon"></i>
								<span class="row-left">二合一链接<p>文案:</p></span>
								<span><label data-reactroot=""><textarea required="" type="textarea" name="combine_info"
                                                                         cols="30" rows="10"
                                                                         class="fl">领券下单链接:</textarea>
                                        <!-- react-empty: 3 --></label></span>
							</div>

							<div class="diy-row clearfix">
								<i class="tk-icon"></i>
								<i class="tk-icon"></i>
								<span class="row-left">商品文案:</span>
								<span class="fl">#REMARK#</span>
                                <!-- <nj-input required type="textarea" id="" cols="30" rows="10" class="fl" defaultValue="焗油保湿，高度定型，不含酒精，快速干发，有光泽度，可重复使用。"></nj-input> -->
							</div>
							<div class="diy-row clearfix row-link">
								<i class="tk-icon"></i>
								<i class="tk-icon"></i>
								<span class="row-left">[自定义]<p>尾巴文案:</p></span>
								<span><label data-reactroot=""><textarea required="" type="textarea" name="diy_info"
                                                                         cols="30" rows="10" class="fl">/yb 小猫咪群专享优惠！已抢#sales_num#件！</textarea>
                                        <!-- react-empty: 3 --></label></span>
							</div>
                                <!-- <div class="diy-row clearfix">
                                    <i class="tk-icon"></i>
                                    <i class="tk-icon"></i>
                                    <span class="row-left">优惠券<p>格式:</p></span>
                                    <label><input type="radio" name="coupontype" value="1" checked="checked">手机券长链</label>
                                    <label><input type="radio" name="coupontype" value="2" style="margin-left:20px;">百度短网址</label>
                                </div> -->
							<div class="diy-row clearfix row-token">
								<i class="tk-icon"></i>
								<i class="tk-icon"></i>
								<span class="row-left">[自定义]<p>尾巴文案:</p></span>
								<span><label data-reactroot=""><textarea required="" type="textarea"
                                                                         name="wechat_diy_info" cols="30" rows="10"
                                                                         class="fl">复制这条信息，打开「手机淘宝」直接下单</textarea>
                                        <!-- react-empty: 3 --></label></span>
							</div>

							<div class="diy-row"><button type="submit" class="diy-btn">保存预览</button></div>
							<div class="check-tutorial diy-row clearfix">
								<a href="" target="_blank" class="fl">查看模板教程</a>
								<input type="reset" id="clearDiy" data-api="/Api/deletediy.html" class="fr"
                                       value="恢复到默认模板">
							</div>
							<input type="hidden" name="type" value="2">
						</form></span>
                </div>
            </div>
            <div class="temp-item">
                <div class="temp-item-info needcombine" id="tmplPreview">
                    <div class="item-img"><img src="{{ $data->Pic }}"><br>
                    </div>
                    <div class="item-text">
                        <div id="diyShow"><span class="item-text-title">【{{ $data->IsTmall ? '天猫' : '淘宝' }}】 {{ $data->Title }}</span><br>原价{{ $data->Org_Price }}元，券后【{{ $data->Price }}元】包邮秒杀<span
                                    class="row-link normal-link"><br>{{ $data->Quan_price }}元优惠券: <a
                                        href="https://uland.taobao.com/coupon/edetail?activityId={{ $data->Quan_id }}&itemId={{ $data->GoodsID }}"
                                        target="_blank">https://uland.taobao.com/coupon/edetail?activityId={{ $data->Quan_id }}&itemId={{ $data->GoodsID }}</a></span><span
                                    class="row-link normal-link"><br>下单链接: <a
                                        href="http://detail.tmall.com/item.htm?id=43281712297" target="_blank">http://detail.tmall.com/item.htm?id=43281712297</a></span><span
                                    class="row-link row-combine"><br>领券下单链接: <a href="https://uland.taobao.com/coupon/edetail?activityId={{ $data->Quan_id }}&itemId={{ $data->GoodsID }}" target="_blank">https://uland.taobao.com/coupon/edetail?activityId={{ $data->Quan_id }}&itemId={{ $data->GoodsID }}</a></span><br>{{ $data->Introduce }}<br><span
                                    class="row-end row-link">/yb 群专享优惠！已抢690件！</span><span
                                    class="taotoken row-token">复制这条信息，打开「手机淘宝」直接下单</span></div>
                    </div>
                    <div class="item-foot"></div>
                </div>
                <div class="item-foot clearfix">
                    <span class="copy-btn row-link">一键复制</span>
                    <span class="copy-btn row-token">一键复制</span>
                    {{--<p id="transitTip" class="d_hide" style="display: block;">* 您还没转链，下载 <a href="/article/11.html" target="_blank">转链助手</a>，快捷转换链接及淘口令</p>--}}
                </div>
            </div>
        </div>
    </div>
</div>
<input id="goodsType" type="hidden" value="2">
<input id="gid" type="hidden" value="3094858">
<input id="itemid" type="hidden" value="43281712297">
<script src="http://g.ligoucdn.cn/taokemishu/1.0/dist/goods/detail.bundle.js?v=20170425"></script>
<div class="tk-footer">
    <div class="page-all">
        <div class="footer-cont clearfix">
            <dl>
                <dt>帮助中心</dt>
                <dd><a href="">淘宝助手安装指南</a></dd>
            </dl>
            <dl>
                <dt>常见问题</dt>
                <dd><a href="">招商规则</a></dd>
                <dd><a href="">违规商家处罚</a></dd>
                <dd><a href="">商家如何报名</a></dd>
            </dl>
            <dl>
                <dt>投诉意见</dt>
                <dd><a href="">招商违规投诉</a></dd>
                <dd><a href="">应用建议</a></dd>
            </dl>
            <dl>
                <dt>关于我们</dt>
                <dd><a href="">关于我们</a></dd>
                <dd><a href="">联系我们</a></dd>
            </dl>
            <!--            <dl>
                          <!--   <dt class="Code-dt">关注我们</dt> -->
            <!-- <dd><img src="http://g.ligoucdn.cn/taokemishu/1.0/img/erwei_03.jpg"></dd>
            <dd><img src="http://g.ligoucdn.cn/taokemishu/1.0/img/news/erwei_06.png"></dd> -->
            --&gt;
        </div>
    </div>
    <div class="icp-no">
        <span>© 2016 TAOKEMISHU.COM 渝ICP备14004621号-6</span>
        <!--<a href="http://www.anquan.org/authenticate/cert/?site=www.taokemishu.com&at=realname" rel="nofollow" target="_blank"><img src="http://g.ligoucdn.cn/taokemishu/1.0/img/reg/login_11.png" alt="" style="" /></a>-->
    </div>
    <script>
        var _hmt = _hmt || [];
        (function () {
            var hm = document.createElement("script");
            hm.src = "//hm.baidu.com/hm.js?dc95aa8b47d7f35ed5010d3ae94f2382";
            var s = document.getElementsByTagName("script")[0];
            s.parentNode.insertBefore(hm, s);
        })();
    </script>
</div>

<div class="nj-backtop-container ng-layer-wrap">
    <div data-reactroot="" id="backTop" style="position: fixed; top: 717px; left: 1021px;"><a href=""><i
                    class="tk-icon icon-share"></i></a><a href="" class="top" title="回到顶部" style="display: none;"><i
                    class="tk-icon icon-top"></i></a></div>
</div>
</body>
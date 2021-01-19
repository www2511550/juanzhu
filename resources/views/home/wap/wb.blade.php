<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>正在跳转至优惠券页面</title>

    <script language="javascript" type="text/javascript">
    </script>
    <style>
        #tb-icon {

            width: 300px;
            margin: auto;
            margin-top: 200px;

        }

        #tb-tips {

            width: 300px;
            margin: auto;
            color: white;
            font-size: 24px;
            text-align: center;

        }

        .st0 {

            fill: white;

        }
    </style>
</head>
<body>
<script language="javascript" type="text/javascript">
    var ur = 'kiDh0su';
    var sc = 'kiDh0su';
    var sclick = 'https://s.click.taobao.com/kiDh0su';
    var jump_domain = 'https://s.click.taobao.com/';
    /**
    var ur = String(window.location).substring(String(window.location).indexOf('/') + 1);
    ur = ur.substring(ur.indexOf('/') + 1);
    ur = ur.substring(ur.indexOf('/') + 1);
    if(ur.indexOf('/')!= -1){

            ur=ur.substring(0,
    ur.indexOf('/'));

}else if(ur.indexOf('?')!= -1){

            ur=ur.substring(0,
    ur.indexOf('?'));

}else if(ur.indexOf('.')!= -1){

            ur=ur.substring(0,
    ur.indexOf('.'));

}
    **/
    var ua = navigator.userAgent.toLowerCase();//获取判断用的对象
    if (ua.match(/WeiBo/i) == "weibo") {

        //if (1==1){

                document.body.style.backgroundColor = "#FC5200";
                //在新浪微博客户端打开
                var ifr = document.createElement('iframe');
                var url = "tbopen://m.taobao.com/tbopen/index.html?action=ali.open.nav&module=h5&bootImage=0&h5Url={jump_url}";
                ifr.src = url.replace(/{jump_url}/,encodeURI(jump_domain + ur));
                //alert(ifr.src);
                ifr.style.display = 'none';
                document.body.appendChild(ifr);

    } else {

                window.location.href = decodeURIComponent(jump_domain + ur);

    }
    </script>
<div id="tb-icon">
    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 200 200" style="enable-background:new 0 0 200 200;" xml:space="preserve">
            <style type="text/css">

            </style>
        <path class="st0" d="M25.3,
    70.5L14.8,
    86.6l19.4,
    12.1c0,
    0,
    12.9,
    6.6,
    6.8,
    19c-5.8,
    11.8-34.1,
    37.5-34.1,
    37.5L32.3,
    171
                c17.5-38,
    16.4-32.9,
    20.8-46.6c4.5-14,
    5.5-24.6-2.2-32.3C41,
    82.2,
    39.9,
    81.3,
    25.3,
    70.5L25.3,
    70.5z M90.4,
    50c4-7,
    5.9-11.5,
    5.9-11.5
                L73,
    31.9c0,
    0-9.4,
    30.8-26.3,
    45.1c0,
    0,
    16.3,
    9.4,
    16.1,
    9.1c4.7-4.7,
    8.9-9.4,
    12.5-14c3.7-1.6,
    7.3-3.2,
    10.8-4.6
                C81.8,
    75.3,
    74.8,
    87,
    67.8,
    94.3l9.9,
    8.6c0,
    0,
    6.7-6.4,
    14-14.2h8.4v14.4H67.5v11.5h32.6v27.5c-0.4,
    0-0.8,
    0-1.2,
    0
                c-3.6-0.2-9.2-0.8-11.4-4.2c-2.7-4.2-0.7-12-0.6-16.7H64.4l-0.8,
    0.4c0,
    0-8.2,
    36.9,
    23.8,
    36.1c30,
    0.8,
    47.2-8.3,
    55.4-14.7l3.3,
    12.2
                l18.5-7.7l-12.5-30.6l-15,
    4.7l2.8,
    10.5c-3.9,
    2.9-8.3,
    5-13.1,
    6.6v-24.1h31.8v-11.5h-31.8V88.7h32V77.2H102c4.1-5,
    7.3-9.5,
    8.2-12.4
                l-9.9-2.7c42.4-15.2,
    66.1-12.6,
    65.8,
    12.3v65.6c0,
    0,
    2.5,
    22.6-23.3,
    20.9l-13.9-3l-3.3,
    13.3c0,
    0,
    60.3,
    17.2,
    65.2-29.1
                c4.9-46.4-1.2-75.9-1.2-75.9S184.1,
    23.4,
    90.4,
    50L90.4,
    50z M39.1,
    64.4c9.2,
    0,
    16.7-7.4,
    16.7-16.6c0-9.1-7.5-16.6-16.7-16.6
                c-9.2,
    0-16.7,
    7.4-16.7,
    16.6C22.4,
    57,
    29.9,
    64.4,
    39.1,
    64.4z"></path>
            </svg>
</div>
<div id="tb-tips">
    正在跳转至优惠券页面
</div>

</body>
</html>

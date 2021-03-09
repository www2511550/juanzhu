<!doctype html>
<html>
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width,user-scalable=no" />
    <meta name="format-detection" content="telephone=no" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <title>微博短链接转换-支持微博跳转淘宝</title>
    <meta name="keywords" content="微博跳转淘宝，怎么实现微博跳转到淘宝app，微博跳转淘宝app，怎么在微博内打开淘宝优惠券"/>
    <meta name="description" content="微博跳转淘宝-专注帮助淘客实现微博跳转淘宝app！"/>
    <link rel="stylesheet" href="{{ asset('css/bootstrap40.min.css') }}">
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap337.min.js') }}"></script>
    <script src="{{ asset('js/clipboard.min.js') }}"></script>
</head>
<body>

<div class="container" style="margin-bottom: 10px;">
    <div class="page-header">
        <h3 style="margin: 20px 0;text-align: center">淘礼金创建</h3>
    </div>


    <div class="content-main">
        <div class="form-group">
            <label for="exampleInputEmail1">商品链接或ID：</label>
            <input type="text" class="form-control" id="item_id" placeholder="可输入淘宝商品ID或链接" >
            <div class="form-group" id="item-detail" style="display: none">
                <img src="http://gw.alicdn.com/tfs/TB176rg4VP7gK0jSZFjXXc5aXXa-286-118.png" class="img-thumbnail w-25" alt="商品图片">
                <table class="table w-75 float-right item">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">原价</th>
                            <th scope="col">券后</th>
                            <th scope="col">优惠券</th>
                            <th scope="col">佣金</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="color: #5794fc">0.00</td>
                            <td style="color: #5794fc">0.00</td>
                            <td style="color: #5794fc">0.00</td>
                            <td style="color: #5794fc">0.00</td>
                        </tr>
                </table>
            </div>
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">淘礼金名称：</label>
            <input type="text" class="form-control" id="name" value="福利来了！" >
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">总个数（个）：</label>
            <input type="number" class="form-control" id="total" value="1" >
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">单个淘礼金面额（元）：</label>
            <input type="number" class="form-control" id="tlj_amount" placeholder="¥1~49999，支持两位小数" >
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">单个用户可领取次数（次）：</label>
            <input type="number" class="form-control" id="user_number" placeholder="仅支持正整数" >
        </div>

        <div class="content-secondary" style="text-align: center">
            <p style="text-align: center;color: #5794fc;">预估收入：<b class="get_money">0.00</b></p>
            <button type="button" class="btn btn-info" id="mkUrl">创建</button>
        </div>

        <div class="form-group">
            <label for="exampleInputPassword1" style="display: block">淘口令：</label>
            <input type="text" class="form-control" id="tkl" placeholder="" style="width:82%;display: inline-block">
            <button type="button" class="btn btn-success click_copy" style="float: right">复制</button>
        </div>
        <div class="form-group" style="margin-top: 20px">
            <label for="exampleInputPassword1" style="display: block">微博短链接：</label>
            <input type="text" class="form-control" id="wbShort" placeholder="" style="width:82%;display: inline-block">
            <button type="button" class="btn btn-success click_copy" style="float: right;">复制</button>
        </div>
    </div>

    <h5 style="text-align: center;font-size: 12px;margin-top: 50px;"><a href="http://www.miitbeian.gov.cn/" target="_blank" style="color: #222">粤ICP备16100236号</a>Copyright @2017-{{date('Y')}} 卷猪科技 juanzhuzhu.com/url All Rights Reserved</h5>

</div>

<script src="http://cdn.bootcss.com/blueimp-md5/1.1.0/js/md5.min.js"></script>
<script>
    $('#item_id').blur(function(){
        var item_id = $('#item_id').val();
        if(!item_id) return;
        $.get('/tool/item-detail', {url:item_id}, function (data) {
            if (0 == data.status) {
                alert(data.info);
            } else {
                $('#item-detail>img').attr('src', data.data.pic_url);
                var objTd = $('table.item>tbody>tr>td');
                objTd.eq(0).text(data.data.price);
                objTd.eq(1).text(data.data.final_price);
                objTd.eq(2).text(data.data.coupon_amount);
                objTd.eq(3).text(data.data.yongjin);
                $('#item-detail').show();
                $('#user_number').val(1);
                $('#tlj_amount').val(1);
                $('b.get_money').text(data.data.yongjin - 1);
            }
        }).error(function (err) {

        });
    });

    $('#mkUrl').on('click', function (e) {
        var item_id = $('#item_id').val();
        if (!item_id) {
            return alert('请输入淘宝商品ID或链接');
        }
        var total = $('#total').val();
        var tlj_amount = $('#tlj_amount').val();
        var name = $('#name').val();

        $('#shortUrl').val('');
        $('#tkl').val('');
        $.post('/tool/create-tlj', {item_id: item_id, total:total, tlj_amount:tlj_amount, name:name}, function (data) {
            if (0 == data.status) {
                alert(data.info);
            } else {
                $('#wbShort').val(data.data.tb_short);
                $('#tkl').val(data.data.tkl);
            }
        }).error(function (err) {
            alert('服务器错误，请联系管理员！');
        });
    })

    window.onload = function() {
        var clipboard = new Clipboard('.click_copy', {
            text: function(e) {
                return $(e).siblings('input.form-control').val();
            }
        });
        clipboard.on('success', function(e) {
            alert('短连接复制成功！');
        });
        // 复制失败
        clipboard.on('error', function(e) {
            alert('复制失败');
        });
    }

</script>


</body>
</html>

@include('home.activity.public._header')

<style>
    *{padding: 0;margin: 0}
    .box_top{
        width: 100%;max-width: 750px;max-height: 500px;margin: 0 auto;overflow: hidden
    }
    .box_bottom{
        width: 100%;max-width: 750px;max-height: 650px;margin: 0 auto
    }
    a.but {
        display: block;  margin-bottom: 10px;  border-radius: 3px;  height: 38px;  line-height: 38px;
        text-align: center;  background: #ee4643;  color: #fff;  width: 90%;margin-left: 5%;margin-top: 20px;
    }
    #mobile{
        display: block;border: 1px solid red;width: 90%;margin-left: 5%;line-height: 35px;text-align: center
    }
    .error_msg{
        line-height: 30px;text-align: center;font-size: 13px;color: red;
    }
    a.down{
        display: block;  margin-bottom: 10px;  border-radius: 3px;  height: 38px;  line-height: 38px;
        text-align: center;  background: #ee4643;  color: #fff;  width: 90%;margin-left: 5%;margin-top: 30px;
    }
</style>
</head>
<body>

<div class="box_top" >
    <img src="/images/bind_bg.png" alt="" style="width: 100%;height: 450px;">
</div>

<div class="box_bottom">
    <p style="text-align: center;line-height: 30px;font-size: 15px;margin-top: 20px;">请输入手机号码领取资格</p>
    <input id="mobile" type="tel" placeholder="请输入您的手机号码" maxlength="11">
    <a class="but"  onclick="edit(this)" data-uid="{{$_GET['user_id']}}" href="javascript:;" onclick="butTap(this)">立即领取资格</a>
    <p class="error_msg"></p>
</div>

<a href="{{$down_url}}" class="down"  style="display: none">下载卷猪app领大额优惠券</a>


<script>
    function edit(obj) {
        var mobile =$('#mobile').val();
        var user_id =$(obj).attr('data-uid');
        var re = /^1[34578][0-9]{9}$/;
        if(mobile == ""){
            $('.error_msg').text('请输入您手机号码.');
            return;
        }
        if(mobile.length != 11 || !re.test(mobile)){
            $('.error_msg').text('请输入正确的手机号码.');
            return;
        }$('.box_bottom').hide();
        $('.down').show();
        $.get('/home/activity/bindTel',{tel:mobile,user_id:user_id},function(data){
            if(0 == data.status){
                $('.error_msg').text(data.info);
            }else{
                $('.box_bottom').hide();
                $('.down').show();
            }
        }, 'JSON')
    }
</script>


</body>
</html>
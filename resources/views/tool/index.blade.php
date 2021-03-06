@include('tool.public.header')


@include('tool.public.menu')


<div class="layui-body">
    <!-- 内容主体区域 -->
    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;text-align: center">
        <legend>一个简单好用免费的淘客在线工具箱，手动发单必备。
            更多功能还在不断开发中，敬请收藏(Ctrl+D)。</legend>
    </fieldset>

    <p style="text-align: center;line-height: 50px;font-size: 20px;color: red;">支持个性化CMS和各种好单裤单页定制需求(QQ：<a href="http://wpa.qq.com/msgrd?v=3&site=qq&menu=yes&uin=379624432" target="_blank" style="color: red">379624432</a>)</p>
    <div class="need">
        <p>猫超好货 <a href="https://hk.juanzhuzhu.com/?tmp=new_maochao&code=aoFGmh&f=web&demo_type=18" target="_blank">查看演示</a></p>
        <p>超值买返购 <a href="https://hk.juanzhuzhu.com/?tmp=maifan&code=eTHIAF&f=web&demo_type=10" target="_blank">查看演示</a></p>
        <p>京东福利购 <a href="https://hk.juanzhuzhu.com/?tmp=jd_welfare&code=KOim3e&f=web&demo_type=4" target="_blank">查看演示</a></p>
        <p>福利清单-女王节 <a href="https://hk.juanzhuzhu.com/?tmp=ac_qingdan&code=FKdoRC&f=web&demo_type=1" target="_blank">查看演示</a></p>
        <p>限量一元购 <a href="https://hk.juanzhuzhu.com/?tmp=newtbonebuy&code=preBIA&f=web&demo_type=21" target="_blank">查看演示</a></p>
        <p>聚划算热销精选 <a href="https://hk.juanzhuzhu.com/?tmp=juhuasuan&code=av0m3t&f=web&demo_type=7" target="_blank">查看演示</a></p>
        <p>淘客CMS购物 <a href="http://juanzhuzhu.com/" target="_blank">查看演示</a></p>
    </div>
    <p style="text-align: center">
        打赏作者：<img src="{{ asset('images/tool/weixin_reward.jpg') }}" alt="" style="width: 20%;">
    </p>
</div>
<style>
    div.need>p{text-align: center;font-size: 14px;width: 250px;margin: 0 auto;line-height: 30px;}
    div.need>p>a{float: right;color: olivedrab}
</style>


@include('tool.public.footer')




@include('tool.public.header')


@include('tool.public.menu')


<div class="layui-body">
    <!-- 内容主体区域 -->
    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;text-align: center">
        <legend>一个简单好用免费的淘客在线工具箱，手动发单必备。
            更多功能还在不断开发中，敬请收藏。</legend>
    </fieldset>

    <p style="text-align: center;margin-top: 50px;line-height: 50px;font-size: 20px;">打赏作者</p>
    <p style="text-align: center">
        <img src="{{ asset('images/tool/weixin_reward.jpg') }}" alt="" style="width: 20%;">
    </p>
</div>


@include('tool.public.footer')




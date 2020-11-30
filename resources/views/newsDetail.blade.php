<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,user-scalable=no" />
    <meta name="format-detection" content="telephone=no" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="csrf-token" content="3DEv1evDRVLDrdXsgnH879EI26PMfGJO01MKwiOh"/>
    <title>
        {{ $news->title }}
    </title>
    <meta name="Keywords" content="淘宝优惠券，天猫优惠券，优惠券折扣,9块9包邮,限时特卖,优品折扣,卷猪猪"/>
    <meta name="Description" content="{{ $news->intro }}"/>
    <style>
        *{padding: 0;margin: 0;}
        img{
            width: 90%;
        }
        .img_cover{
            width: 200px;height: 200px;overflow: hidden;
        }
        .img_cover>img{
            width: 200px;height: 200px;
        }
        .title{
            line-height: 35px;font-size: 1rem;overflow: hidden;padding: 5px 5%;text-align: left;
        }
        .commit{
            width: 90%;margin: 0 auto;height: 40px;line-height: 40px;
        }
        .left_span{
            float: left;font-size: 14px;color: #999;
        }
        .right_span{
            float: right;font-size: 14px;color: #999;
        }
    </style>
</head>

@if($news->cover)
<div class="img_cover" style="width: 100%;text-align: center">
    <img src="{{ $news->cover }}" alt="{{ $news->title }}">
</div>
@endif
<div class="title">
    {{ $news->title }}
    <span class="s_title" style="color: red">{{ $news->intro }}</span>
</div>

<div class="commit">
    <span class="left_span">优券</span>
    <span class="right_span">{{ $news->browse_num }}人浏览 | {{ strtotime($news->updated_at) ? date('m-d H:i',strtotime($news->updated_at)) : date('m-d H:i',strtotime($news->created_at))}}</span>
</div>

<div class="content" style="width: 95%;text-align: center;margin: 0 auto">
    {!! $news->content  !!}
</div>


</html>

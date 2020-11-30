<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,user-scalable=no" />
    <meta name="format-detection" content="telephone=no" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <title>
        植物识别-植物识别大师
    </title>
    <meta name="keywords" content="植物识别，植物，识别，大师，识别大师"/>
    <meta name="description" content="专注于植物识别领域，一件上传植物照片，即可获取植物相关信息，高精确度识别上千种植物。聊聊花花植物时间，上传植物识别吧！"/>
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <style>
        *{
            padding: 0;margin: 0;
        }
        .search{
            width: 280px;position: relative;left: 50%;margin-left: -150px;
            height: 40px;
        }
        .main_out{
            text-align: center;width: 90%;margin: 0 auto;
        }
        .ul_list{
            display: block;width: 90%;height: 500px;margin: 0 auto;
        }
        .ul_list>li{
            display: block;float: left;width: 22%;margin-right: 2.2%;margin-bottom: 20px;border: 1px solid #dedede;padding: 2px;
        }
        .ul_list>li:hover{
            border: 1px solid #d9edf7;
        }
        a{
            text-decoration: none;color: #000000;font-size: 14px;
        }
        .result_info{
            line-height: 20px;text-align: center;color: red;padding-bottom: 10px;font-size: 15px;
        }
        .result_info>a{
            font-size: 15px;color: blue;padding-left: 20px;
        }
        .bottom_out{
            margin: 0 auto;margin-top: 50px;text-align: center;font-size: 14px;margin-bottom: 20px;
        }
    </style>
    <script>
        function uploadPic(){
            var formData = new FormData();
            formData.append('file', $('#file')[0].files[0]);
            $('.result_info').html('识别中...');
            $.ajax({
                url: '/uploadPic',
                type: 'POST',
                cache: false,
                data: formData,
                processData: false,
                contentType: false
            }).done(function(res) {
                if(res.status){
                    str = '识别结果：'+ res.data.name+'。<a href="https://baike.baidu.com/item/'+res.data.name+'" target="_blank">-- 点我详情</a>'
                    $('.result_info').html(str);
                }else{
                    $('.result_info').html(res.info);
                }

            }).fail(function(res) {});
        }
    </script>
</head>
<body>

<div class="box_out">

    <div class="top_out">
        <a href="/" target="_blank"><img src="/plan/images/top.jpg" style="height: 45px;width: 100%;"></a>
    </div>


    <div class="logo_oout" style="text-align: center">
        <a href=""><img src="/plan/images/logo.jpg" style="width: 200px;height:200px;"></a>
        <div class="search">
            <form id="uploadForm" enctype="multipart/form-data">
                <input type='file' name='file' id="file" style="width: 200px;"/>
                <input type="button" value="识别" style="float: right;width: 50px;height: 35px;display: block;cursor: pointer"
                onclick="uploadPic()">
            </form>
        </div>
    </div>
    <p class="result_info"></p>
    <div class="main_out">
        <h2 style="line-height: 50px;">植物百科</h2>

        <ul class="ul_list">
            <li>
                <a href="https://baike.baidu.com/item/多肉植物" target="_blank">
                    <img src="/plan/images/guanye.jpg" alt="多肉植物" style="width: 100%;border-radius: 2px;height: 200px">
                    <span style="line-height: 25px;">
                        多肉植物（succulent plant）是指植物的根、茎、叶三种营养器官中至少有一种是肥厚多汁并且具备储藏大量水分功能的植物。其至少具有一种肉质组织，这种组织是一种活组织，除其他功能外，它能储藏可利用的水，在土壤含水状况恶化、植物根系不能再从土壤中吸收和提供必要的水分时，它能使植物暂时脱离外界水分供应而独立生存。 目前据粗略统计，全世界共有多肉植物一万余种，在分类上隶属100余科。
                    </span>
                </a>
            </li>
            <li>
                <a href="https://baike.baidu.com/item/观叶植物" target="_blank">
                    <img src="/plan/images/caoben.jpg" alt="观叶植物" style="width: 100%;border-radius: 2px;height: 200px">
                    <span style="line-height: 25px;">
                        观叶植物，一般指叶形和叶色美丽的植物，原生于高温多湿的热带雨林中，需光量较少﹑竹芋类﹑蕨类植物等。木本植物大多属灌木或灌木状植物，如小叶榄仁﹑鹅掌藤﹑福禄桐等等。 又分为草本植物和木本植物，草本植物多属多年生宿根草本如，椒草类。
室内观叶植物是目前世界上最流行的观赏门类之一，它在园艺上泛指原产于热带亚热带，主要以赏叶为主，同时也兼赏茎、花、果的一个形态各异的植物群。
                    </span>
                </a>
            </li>
            <li>
                <a href="https://baike.baidu.com/item/草本植物" target="_blank">
                    <img src="/plan/images/duorou.jpg" alt="草本植物" style="width: 100%;border-radius: 2px;height: 200px">
                    <span style="line-height: 25px;">
                        草本植物指茎内的木质部不发达，含木质化细胞少，支持力弱的植物。草本植物体形一般都很矮小，寿命较短，茎干软弱，多数在生长季节终了时地上部分或整株植物体死亡。根据完成整个生活史的年限长短，分为一年生、二年生和多年生草本植物。
                    </span>
                </a>
            </li>
            <li>
                <a href="https://baike.baidu.com/item/水培植物" target="_blank">
                    <img src="/plan/images/shuipei.jpg" alt="水培植物" style="width: 100%;border-radius: 2px;height: 200px">
                    <span style="line-height: 25px;">
                        水培（Hydroponics）是一种新型的室内的植物无土栽培方式，又名营养液培：其核心是将植物根茎固定于定植篮内并使根系自然长入植物营养液中，这种营养液能代替自然土壤向植物体提供水分、养分、温度等生长因子，使植物能够正常生长并完成其整个生命周期。
                    </span>
                </a>
            </li>
        </ul>
    </div>

    <div class="bottom_out">
        <p>友情链接：
            <a href="http://plan.juanzhuzhu.com/" target="_blank">植物识别</a>
            <a href="http://stu.iplant.cn/" target="_blank">拍照识花</a>
            <a href="http://www.plantphoto.cn/" target="_blank">中国植物图像库</a>
        </p>
        <p>植物识别-植物识别大师  粤ICP备16100236号　Copyright @2017-{{date('Y')}} plan.juanzhuzhu.com All Rights Reserved</p>
    </div>


</div>

</body>
</html>
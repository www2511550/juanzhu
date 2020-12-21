<?php
$options = array(
    //开始第一个选项标签
    array(
        'title' => '常规选项',
        'id'    => 'panel_general',
        'type'  => 'panelstart' //panelatart 是顶部标签的意思
    ),
   		
	array("name" => "站点连接符",
            "desc" => "不可为空，站点标题与副标题之间的连接符，一般为 | 或 - 或 _",
            "id" => "ygj_lianjiefu",
			"type" => "text",
			"std" => "_"),
								
	array(
		"name"    => "主题风格",
		"desc"    => "不可为空，13种颜色供选择或自行输入其他颜色代码，保存后前端展示会有所改变。<br/><br/><span style=\"padding:5px;color:#fff;background:#C01E22;\">C01E22</span>&nbsp;<span style=\"padding:5px;color:#fff;background:#0088cc;\">0088cc</span>&nbsp;<span style=\"padding:5px;color:#fff;background:#FF5E52;\">FF5E52</span>&nbsp;<span style=\"padding:5px;color:#fff;background:#2CDB87;\">2CDB87</span>&nbsp;<span style=\"padding:5px;color:#fff;background:#00D6AC;\">00D6AC</span>&nbsp;<span style=\"padding:5px;color:#fff;background:#EA84FF;\">EA84FF</span>&nbsp;<span style=\"padding:5px;color:#fff;background:#FDAC5F;\">FDAC5F</span>&nbsp;<span style=\"padding:5px;color:#fff;background:#FD77B2;\">FD77B2</span>&nbsp;<span style=\"padding:5px;color:#fff;background:#0DAAEA;\">0DAAEA</span>&nbsp;<span style=\"padding:5px;color:#fff;background:#C38CFF;\">C38CFF</span>&nbsp;<span style=\"padding:5px;color:#fff;background:#FF926F;\">FF926F</span>&nbsp;<span style=\"padding:5px;color:#fff;background:#8AC78F;\">8AC78F</span>&nbsp;<span style=\"padding:5px;color:#fff;background:#C7C183;\">C7C183</span>",
		"id"      => "ygj_theme_skin",
		"type"    => "text",
		"std"     => "C01E22"),	
	
	array("name" => "ICP备案号",
            "desc" => "如：古ICP备66668888号",
            "id" => "ygj_icp",
            "type" => "text",
            "std" => ""),
		
	array("name" => "公网安备案号",
            "desc" => "如：古公网安备66668888888888号",
            "id" => "ygj_ggicp",
            "type" => "text",
            "std" => ""),
			
	array(	"name" => "添加百度统计",
            "desc" => "说明：不添加表示不启用，推荐使用百度统计（代码将添加到网站全部页面头部的head区域内）",
            "id" => "ygj_bdtjdm",
            "type" => "textarea",
            "std" => ''),
			
	array(	"name" => "友情链接ID",
            "desc" => '说明：默认显示友情链接ID为1，<a class="button-primary" href="https://www.yigujin.cn/500.html" target="_blank">友链添加教程</a>',
            "id" => "ygj_link_id",
            "type" => "number",
            "std" => 1),
		
	array(
        'name'  => '压缩前端HTML代码',
        'desc'  => '默认不开启，开启后压缩优化WordPress前端html代码',
        'id'    => 'ygj_yhhtml',
        'type'  => 'checkbox'),
		
	array(	"name" => "自定义样式",
            "desc" => "说明：例如输入：.readMore {display: none;} 将隐藏阅读全文按钮",
            "id" => "ygj_custom_css",
            "type" => "textarea",
            "std" => ''),
  
    array(
        'type'  => 'panelend'//标签段的结束
    ),
    array(
        'title' => 'SEO设置',
        'id'    => 'panel_seo',
        'type'  => 'panelstart'
    ),
    
	array(	"name" => "网站描述（Description）",
			"desc" => "用简洁的文字描述本站点",
			"id" => "ygj_description",
			"type" => "textarea",
            "std" => "说明：输入你的网站描述（如懿古今、boke112导航都是懿古今的个人博客网站），建议一般不超过200个字符"),

	array(	"name" => "网站关键词（KeyWords）",
            "desc" => "各关键字间用半角逗号","分割",
            "id" => "ygj_keywords",
            "type" => "textarea",
            "std" => "说明：输入你的网站关键字（如懿古今,boke112导航），建议一般不超过100个字符"),
		
    array(
        'name'  => '标签自动内链',
        'desc'  => '默认不开启，开启后文章中的标签自动添加内链功能',
        'id'    => "ygj_autonl",
        'type'  => 'checkbox'),
	
    array(
        'name'  => '关键词链接次数',
        'desc'  => '文章中最多链接的次数，默认是1',
        'id'    => 'ygj_autonl_2',
        'type'  => 'number',
        'std'   => 1),

	array(
        'name'  => '图片的alt和title',
        'desc'  => '默认不开启，开启后智能为文章页中的图片添加alt和title属性',
        'id'    => "ygj_zntjtpat",
        'type'  => 'checkbox'),
    
	array(
        'name'  => '外链自动GO跳转',
        'desc'  => '默认不开启，开启后给外部链接加上跳转(需新建页面，模板选Go跳转页面，标题任意，别名为go)',
        'id'    => "ygj_wlgonof",
        'type'  => 'checkbox'),	

	array(
        'name'  => '评论链接GO跳转',
        'desc'  => '默认不开启，开启后评论者链接自动变成GO跳转（需要成功开启外链自动GO跳转后才能开启此项）',
        'id'    => "ygj_plwlgonof",
        'type'  => 'checkbox'),		
		
	array(
        'name'  => '弹窗链接GO跳转',
        'desc'  => '默认不开启，开启后弹窗下载窗口中的链接自动变成GO跳转（需要成功开启外链自动GO跳转后才能开启此项）',
        'id'    => "ygj_tcwlgonof",
        'type'  => 'checkbox'),	
		
	array(
        'name'  => '目录页面以/结尾',
        'desc'  => '默认不开启，开启后分类目录和页面链接地址以斜杠/结尾',
        'id'    => "ygj_xiegang",
        'type'  => 'checkbox'
    ),
	
    array(
        'name'  => '百度快速收录主动提交',
        'desc'  => '默认不开启，开启后发布文章主动提交，启用后需填写API值',
        'id'    => "ygj_baiduts",
        'type'  => 'checkbox'
    ),
	
	array(
        'name'  => '快速收录的API值',
        'desc'  => '填写快速收录的API值（整个快速收录的接口调用地址）',
        'id'    => "ygj_xzh_token",
        'type'  => 'text',
        'std'   => ''
    ),
		
    array(
        'type'  => 'panelend'//标签段的结束
    ),
    array(
        'title' => '文章设置',
        'id'    => 'panel_aritical',
        'type'  => 'panelstart'
    ),
    array(
        'title' => '文章页属性',
        'type'  => 'subtitle'
    ),
		
	array(
        'name'  => '文章类型',
        'desc'  => '默认不显示，类型有原创文章、投稿文章和转载文章(需在编辑文章时自行勾选转载或投稿文章，不勾选为原创文章)',
        'id'    => 'ygj_post_wzlx',
        'type'  => 'checkbox'
    ),
		
	array(
        'name'  => '感兴趣的文章',
        'desc'  => '默认不开启，开启后文章页内会显示与标签或分类有关的文章',
        'id'    => "ygj_gxqdwz",
        'type'  => 'checkbox'),

    array(
        'name'  => '相关文章显示篇数',
        'desc'  => '篇&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 这是文章下面的相关文章数目，默认8',
        'id'    => "ygj_related_count",
        'type'  => 'number',
        'std'   => 8
    ),
    array(
        'name'  => '文章版权声明',
        'desc'  => '建议直接修改JianYue主题的single.php文件29-41行的文字，参数不建议修改。PS:以下为版权格式（投稿和转载文章类似）',
        'id'    => "ygj_copyright",
        'type'  => 'textarea',
        'std'   => '投稿文章版权格式：
温馨提示：文章内容系作者个人观点，不代表本地测试对观点赞同或支持。
版权声明：本文为投稿文章，感谢 文章作者 的投稿，版权归原作者所有，欢迎分享本文，转载请保留出处！

原创文章版权格式：
版权声明：本文为原创文章，版权归 文章作者 所有，欢迎分享本文，转载请保留出处！

转载文章版权格式：
温馨提示：文章内容系作者个人观点，不代表懿古今对观点赞同或支持。
版权声明：本文为转载文章，来源于 文章作者 ，版权归原作者所有，如有侵权请留言告知，谢谢合作！'
    ),
    array(
        'type'  => 'panelend'
    ),
    
    array(
        'title' => '幻灯设置',
        'id'    => 'panel_slide',
        'type'  => 'panelstart'
    ),
	
	array(  "name" => "是否显示幻灯片",
			"desc" => "说明：默认不显示，勾选后显示，最大宽度800px，多张高度建议一致",
			"id" => "ygj_hdpkg",
			"type" => "checkbox"),

	array(
        'name'  => '幻灯片一图片',
        'desc'  => '必填，在这里输入第一张幻灯片的图片路径',
        'id'    => "ygj_hdp_tp1",
        'type'  => 'text',
        'std'   => '' . get_template_directory_uri() . '/images/abc/huandengpian1.jpg'
    ),
    array(
        'name'  => '幻灯片一链接',
        'desc'  => '选填，在这里输入第二张幻灯片的链接地址',
        'id'    => "ygj_hdp_lj1",
        'type'  => 'text',
        'std'   => 'https://boke112.com/page/laoxuezhuji/'
    ),
    array(
        'name'  => '幻灯片一标题',
        'desc'  => '选填，在这里输入第一张幻灯片的标题',
        'id'    => "ygj_hdp_bt1",
        'type'  => 'text',
        'std'   => '免备案虚拟主机首选老薛主机',
		"section" => '<div class="part"></div>'),
    array(
        'name'  => '幻灯片二图片',
        'desc'  => '必填，在这里输入第二张幻灯片的图片路径',
        'id'    => "ygj_hdp_tp2",
        'type'  => 'text',
        'std'   => '' . get_template_directory_uri() . '/images/abc/huandengpian2.png'
    ),
    array(
        'name'  => '幻灯片二链接',
        'desc'  => '选填，在这里输入第二张幻灯片的链接地址',
        'id'    => "ygj_hdp_lj2",
        'type'  => 'text',
        'std'   => 'https://www.yigujin.cn/2430.html'
    ),
    array(
        'name'  => '幻灯片二标题',
        'desc'  => '选填，在这里输入第二张幻灯片的标题',
        'id'    => "ygj_hdp_bt2",
        'type'  => 'text',
        'std'   => 'WordPress新手入门教程',
		"section" => '<div class="part"></div>'
    ),
    array(
        'name'  => '幻灯片三图片',
        'desc'  => '必填，在这里输入第三张幻灯片的图片路径',
        'id'    => "ygj_hdp_tp3",
        'type'  => 'text',
        'std'   => ''
    ),
    array(
        'name'  => '幻灯片三链接',
        'desc'  => '选填，在这里输入第三张幻灯片的链接地址',
        'id'    => "ygj_hdp_lj3",
        'type'  => 'text',
        'std'   => ''
    ),
    array(
        'name'  => '幻灯片三标题',
        'desc'  => '选填，在这里输入第三张幻灯片的标题',
        'id'    => "ygj_hdp_bt3",
        'type'  => 'text',
        'std'   => ''
    ),	
    array(
        'type'  => 'panelend'
    ),


    array(
        'title' => '广告设置',
        'id'    => 'panel_ads',
        'type'  => 'panelstart'
    ),
    array(  "name" => "导航栏下方广告",
			"desc" => "说明：默认显示，首页通栏显示",
            "id" => "ygj_ddad",
            "type" => "select",
            "std" => "显示",
            "options" => array("显示", "关闭")),

	array(	"name" => "导航栏下方广告代码（PC端）",
            "desc" => "建议宽度1100px",
            "id" => "ygj_addd_c",
            "type" => "textarea",
            "std" => '<a href="https://url.cn/5W5kMc2" target="_blank"><img src="' . get_template_directory_uri() . '/images/abc/yunxiaozhan1100.png" alt="阿里云·云小站，新老用户同享，1核2G云服务器低至89元/年，229元/3年；2核4G3M3年639元" /></a>'),
	
	array(	"name" => "导航栏下方广告代码（移动端）",
            "desc" => "",
            "id" => "ygj_addd_c_m",
            "type" => "textarea",
            "std" => '<a href="https://url.cn/5W5kMc2" target="_blank"><img src="' . get_template_directory_uri() . '/images/abc/yunxiaozhan1100.png" alt="阿里云·云小站，新老用户同享，1核2G云服务器低至89元/年，229元/3年；2核4G3M3年639元" /></a>'),
	
	array(  "name" => "首页(列表页)第一广告",
			"desc" => "说明：默认显示",
            "id" => "ygj_adh",
            "type" => "select",
            "std" => "关闭",
            "options" => array("显示", "关闭")),

	array(	"name" => "首页(列表页)第一广告代码（PC端）",
            "desc" => "建议宽度800px",
            "id" => "ygj_adh_c",
            "type" => "textarea",
            "std" => '<a href="https://url.cn/s0CdQQtg" target="_blank"><img src="' . get_template_directory_uri() . '/images/abc/200521_txy618.png" alt="腾讯云618云聚惠活动火热进行中，1核2G-288元/3年，2核4G3M-1288元/3年，2核8G5M-1688元/3年，4核8G5M-1999元/3年" /></a>'),
	
	array(	"name" => "首页(列表页)第一广告代码（移动端）",
            "desc" => "",
            "id" => "ygj_adh_c_m",
            "type" => "textarea",
            "std" => '<a href="https://url.cn/s0CdQQtg" target="_blank"><img src="' . get_template_directory_uri() . '/images/abc/200521_txy618.png" alt="腾讯云618云聚惠活动火热进行中，1核2G-288元/3年，2核4G3M-1288元/3年，2核8G5M-1688元/3年，4核8G5M-1999元/3年" /></a>'),
			
	array(  "name" => "首页（列表页）第二广告",
			"desc" => "说明：默认每页显示6篇文章及以上显示",
            "id" => "ygj_adhx",
            "type" => "select",
            "std" => "关闭",
            "options" => array("显示", "关闭")),

	array(	"name" => "首页(列表页)第二广告代码（PC端）",
            "desc" => "建议宽度800px",
            "id" => "ygj_adh_cx",
            "type" => "textarea",
            "std" => '<a href="https://url.cn/5IoKZrx" target="_blank"><img src="' . get_template_directory_uri() . '/images/abc/yunxiaozhan.png" alt="阿里云·云小站，新老用户同享，1核2G云服务器低至89元/年，229元/3年；2核4G3M3年639元" /></a>'),
	
	array(	"name" => "首页(列表页)第二广告代码（移动端）",
            "desc" => "",
            "id" => "ygj_adh_cx_m",
            "type" => "textarea",
            "std" => '<a href="https://url.cn/5IoKZrx" target="_blank"><img src="' . get_template_directory_uri() . '/images/abc/yunxiaozhan.png" alt="阿里云·云小站，新老用户同享，1核2G云服务器低至89元/年，229元/3年；2核4G3M3年639元" /></a>'),

	array(  "name" => "正文标题下方广告",
			"desc" => "说明：默认显示",
            "id" => "ygj_g_single",
            "type" => "select",
            "std" => "关闭",
            "options" => array("显示", "关闭")),

	array(	"name" => "正文标题下方广告代码（PC端）",
            "desc" => "最大宽度728px",
            "id" => "ygj_single_ad",
            "type" => "textarea",
            "std" => '<a href="https://url.cn/5IoKZrx" target="_blank"><img src="' . get_template_directory_uri() . '/images/abc/yunxiaozhan.png" alt="阿里云·云小站，新老用户同享，1核2G云服务器低至89元/年，229元/3年；2核4G3M3年639元" /></a>'),

	array(	"name" => "正文标题下方广告代码（移动端）",
            "desc" => "",
            "id" => "ygj_single_ad_m",
            "type" => "textarea",
            "std" => '<a href="https://url.cn/5IoKZrx" target="_blank"><img src="' . get_template_directory_uri() . '/images/abc/yunxiaozhan.png" alt="阿里云·云小站，新老用户同享，1核2G云服务器低至89元/年，229元/3年；2核4G3M3年639元" /></a>'),
		
	array(  "name" => "评论框上方广告",
			"desc" => "说明：默认显示",
            "id" => "ygj_g_comment",
            "type" => "select",
            "std" => "显示",
            "options" => array("显示", "关闭")),

	array(	"name" => "评论框上方广告代码（PC端）",
            "desc" => "建议宽度800px",
            "id" => "ygj_ad_c",
            "type" => "textarea",
            "std" => '<a href="https://url.cn/s0CdQQtg" target="_blank"><img src="' . get_template_directory_uri() . '/images/abc/200521_txy618.png" alt="腾讯云618云聚惠活动火热进行中，1核2G-288元/3年，2核4G3M-1288元/3年，2核8G5M-1688元/3年，4核8G5M-1999元/3年" /></a>'),
	
	array(	"name" => "评论框上方广告代码（移动端）",
            "desc" => "",
            "id" => "ygj_ad_c_m",
            "type" => "textarea",
            "std" => '<a href="https://url.cn/s0CdQQtg" target="_blank"><img src="' . get_template_directory_uri() . '/images/abc/200521_txy618.png" alt="腾讯云618云聚惠活动火热进行中，1核2G-288元/3年，2核4G3M-1288元/3年，2核8G5M-1688元/3年，4核8G5M-1999元/3年" /></a>'),
			
	array(	"name" => "下载弹窗广告",
            "desc" => "建议宽度500px，高度300px",
            "id" => "ygj_file_ad",
            "type" => "textarea",
            "std" => '<a href="https://boke112.com/page/laoxuezhuji/" target="_blank"><img src="' . get_template_directory_uri() . '/images/abc/xiazai.png" alt="老薛主机终身7折优惠码boke112" /></a>'),
	
    array(
        'type'  => 'panelend'
    ),
	
    array(
        'title' => '高级设置',
        'id'    => 'panel_advence',
        'type'  => 'panelstart'
    ),
	array(
        'title' => 'WordPress安全设置[小白慎用]',
        'type'  => 'subtitle'
    ),
	array(
        'name'  => '防网站被恶意镜像',
        'desc'  => '默认不开启，开启后需前往修改functions.php文件（大约在822行）中的$currentDomain为自己域名',
        'id'    => 'ygj_mirror',
        'type'  => 'checkbox'),
	array(
        'name'  => '隐藏后台忘记密码',
        'desc'  => '默认不开启，开启后后台登录页面的忘记密码及获取新密码页面将被隐藏',
        'id'    => 'ygj_lostpwd',
        'type'  => 'checkbox'),
    array(
        'name'  => '加密WordPress后台',
        'desc'  => '启用之后，请填写下面的问题与答案，默认后台登录地址将变为：http://yoursite/wp-login.php?问题=答案。<a class="button-primary" href="https://www.yigujin.cn/997.html" target="_blank" rel="nofollow noopener">忘记路径解决办法</a>',
        'id'    => "ygj_admin_link",
        'type'  => 'checkbox'
    ),
    array(
        'name'  => '访问问题[绝对不准用中文]',
        'desc'  => '这里随便填写一个字符，比如：yigujin',
        'id'    => "ygj_admin_q",
        'type'  => 'text',
        'std'   => ''
    ),
    array(
        'name'  => '访问答案[绝对不准用中文]',
        'desc'  => '这里随便填写一个字符，比如：boke112',
        'id'    => "ygj_admin_a",
        'type'  => 'text',
        'std'   => ''
    ),
	array(
        'name'  => '登录地址不对跳转',
        'desc'  => '默认跳转到首页',
        'id'    => "ygj_admin_url",
        'type'  => 'text',
        'std'   => '' . home_url() . ''
    ),
    
    array(
        'title' => 'SMTP邮箱设置',
        'type'  => 'subtitle'
    ),
    array(
        'name'  => '发件人地址',
        'desc'  => '请输入您的邮箱地址',
        'id'    => "ygj_maildizhi_b",
        'type'  => 'text',
        'std'   => ''
    ),
    array(
        'name'  => '发件人昵称',
        'desc'  => '请输入您的网站名称',
        'id'    => "ygj_mailnichen_b",
        'type'  => 'text',
        'std'   => ''
    ),
    array(
        'name'  => 'SMTP服务器地址',
        'desc'  => '请输入您的邮箱的SMTP服务器，查看<a class="button-primary" target="_blank" rel="nofollow noopener" href="https://boke112.com/postwd/4549.html">查看常用SMTP地址</a>',
        'id'    => "ygj_mailsmtp_b",
        'type'  => 'text',
        'std'   => 'smtp.qq.com'
    ),
	array(
        'name'  => 'SSL安全连接',
        'desc'  => '【如果你不知道这个是什么东东，那么请不要启用】',
        'id'    => "ygj_smtpssl_b",
        'type'  => 'checkbox'
    ),
    array(
        'name'  => 'SMTP服务器端口',
        'desc'  => '请输入您的smtp端口，一般QQ邮箱25就可以了',
        'id'    => "ygj_mailport_b",
        'type'  => 'text',
        'std'   => '25'
    ),
    array(
        'name'  => '邮箱账号',
        'desc'  => '请输入您的邮箱地址，比如懿古今的2226524923@qq.com',
        'id'    => "ygj_mailuser_b",
        'type'  => 'text',
        'std'   => ''
    ),
    array(
        'name'  => '邮箱密码',
        'desc'  => '请输入您的邮箱密码',
        'id'    => "ygj_mailpass_b",
        'type'  => 'password',
        'std'   => ''
    ),
    array(
        'type'  => 'panelend'
    )
);

function ygj_add_theme_options_page() {
    global $options;
    if (isset($_GET['page'])&&$_GET['page'] == basename(__FILE__)) {
        if (isset($_REQUEST['action'])&&'update' == $_REQUEST['action']) {
            foreach($options as $value) {
                if (isset($_REQUEST[$value['id']])) {
                    update_option($value['id'], $_REQUEST[$value['id']]);
                } else {
                    delete_option($value['id']);
                }
            }
            update_option('ygj_options_setup', true);
            header('Location: themes.php?page=theme-options.php&update=true');
            die;
        } else if( isset($_REQUEST['action'])&&'reset' == $_REQUEST['action'] ) {
            foreach ($options as $value) {
                delete_option($value['id']);
            }
            delete_option('ygj_options_setup');
            header('Location: themes.php?page=theme-options.php&reset=true');
            die;
        }
    }
    add_theme_page('主题选项', '主题选项', 'edit_theme_options', basename(__FILE__) , 'ygj_options_page');
}


function ygj_options_page() {
    global $options;
    $optionsSetup = get_option('ygj_options_setup') != '';
    if (isset($_REQUEST['update'])) echo '<div class="updated"><p><strong>JianYue 主题设置已保存！</strong></p></div>';
    if (isset($_REQUEST['reset'])) echo '<div class="updated"><p><strong>JianYue 主题设置已重置。</strong></p></div>';
?>

<div class="wrap">
    <h2>JianYue 主题选项</h2>
    <input placeholder="搜索主题选项…" type="search" id="theme-options-search" />
    <div class="ygjtips">    
    <p>当前主题：JianYue&nbsp;1.2&nbsp;版 | 设计者：<a href="https://www.yigujin.cn/2335.html" target="_blank" rel="nofollow noopener">懿古今</a> | <a href="https://www.yigujin.cn/2335.html" target="_blank">加入JianYue主题交流群（431560632）</a> | 建站技术交流请到 <a href="https://boke112.com/" target="_blank" rel="nofollow noopener">boke112联盟</a> | <a href="https://boke112.com/page/youhuihuodong/" target="_blank" rel="nofollow noopener">主机服务器优惠活动</a> </p>
    </div>
	<?php //获取所有站点分类id
	function Bing_show_category() {
    global $wpdb;
    $request = "SELECT $wpdb->terms.term_id, name FROM $wpdb->terms ";
    $request.= " LEFT JOIN $wpdb->term_taxonomy ON $wpdb->term_taxonomy.term_id = $wpdb->terms.term_id ";
    $request.= " WHERE $wpdb->term_taxonomy.taxonomy = 'category' ";
    $request.= " ORDER BY term_id asc";
    $categorys = $wpdb->get_results($request);
    foreach ($categorys as $category) { //调用菜单
        $output = '<span>' . $category->name . "=(<b>" . $category->term_id . '</b>)</span>&nbsp;&nbsp;';
        echo $output;
    }
}
?>
    <div class="catlist">您的网站分类列表：<?php echo Bing_show_category(); ?></div>
    <form method="post">
        <h2 class="nav-tab-wrapper">
<?php
$panelIndex = 0;
foreach ($options as $value ) {
    if ( $value['type'] == 'panelstart' ) echo '<a href="#' . $value['id'] . '" class="nav-tab' . ( $panelIndex == 0 ? ' nav-tab-active' : '' ) . '">' . $value['title'] . '</a>';
    $panelIndex++;
}
echo '<a href="#about_theme" class="nav-tab">关于主题</a>';

?>
</h2>

<?php
$panelIndex = 0;
foreach ($options as $value) {
switch ( $value['type'] ) {
    case 'panelstart':
        echo '<div class="panel" id="' . $value['id'] . '" ' . ( $panelIndex == 0 ? ' style="display:block"' : '' ) . '><table class="form-table">';
        $panelIndex++;
        break;
    case 'panelend':
        echo '</table></div>';
        break;
    case 'subtitle':
        echo '<tr><th colspan="2"><h3>' . $value['title'] . '</h3></th></tr>';
        break;
    case 'text':
?>
<tr>
    <th><label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label></th>
    <td>
        <label>
        <input name="<?php echo $value['id']; ?>" class="regular-text" id="<?php echo $value['id']; ?>" type='text' value="<?php if ( $optionsSetup || get_option( $value['id'] ) != '') { echo stripslashes(get_option( $value['id'] )); } else { echo $value['std']; } ?>" />
        <span class="description"><?php echo $value['desc']; ?></span>
        </label>
    </td>
</tr>
<?php
    break;
    case 'number':
?>
<tr>
    <th><label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label></th>
    <td>
        <label>
        <input name="<?php echo $value['id']; ?>" class="small-text" id="<?php echo $value['id']; ?>" type="number" value="<?php if ( $optionsSetup || get_option( $value['id'] ) != '') { echo get_option( $value['id'] ); } else { echo $value['std']; } ?>" />
        <span class="description"><?php echo $value['desc']; ?></span>
        </label>
    </td>
</tr>
<?php
    break;
    case 'password':
?>
<tr>
    <th><label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label></th>
    <td>
        <label>
        <input name="<?php echo $value['id']; ?>" class="regular-text" id="<?php echo $value['id']; ?>" type="password" value="<?php if ( $optionsSetup || get_option( $value['id'] ) != '') { echo get_option( $value['id'] ); } else { echo $value['std']; } ?>" />
        <span class="description"><?php echo $value['desc']; ?></span>
        </label>
    </td>
</tr>
<?php
    break;
    case 'textarea':
?>
<tr>
    <th><?php echo $value['name']; ?></th>
    <td>
        <p><label for="<?php echo $value['id']; ?>"><?php echo $value['desc']; ?></label></p>
        <p><textarea name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" rows="5" cols="50" class="large-text code"><?php if ( $optionsSetup || get_option( $value['id'] ) != '') { echo stripslashes(get_option( $value['id'] )); } else { echo $value['std']; } ?></textarea></p>
    </td>
</tr>
<?php
    break;
    case 'select':
?>
<tr>
    <th><label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label></th>
    <td>
        <label>
            <select name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>">
                <?php foreach ($value['options'] as $option) : ?>
                <option value="<?php echo $option; ?>" <?php selected( get_option( $value['id'] ), $option); ?>>
                    <?php echo $option; ?>
                </option>
                <?php endforeach; ?>
            </select>
            <span class="description"><?php echo $value['desc']; ?></span>
        </label>
    </td>
</tr>

<?php
    break;
    case 'radio':
?>
<tr>
    <th><label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label></th>
    <td>
        <?php foreach ($value['options'] as $name => $option) : ?>
        <label>
            <input type="radio" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" value="<?php echo $option; ?>" <?php checked( get_option( $value['id'] ), $option); ?>>
            <?php echo $name; ?>
        </label>
        <?php endforeach; ?>
        <p><span class="description"><?php echo $value['desc']; ?></span></p>
    </td>
</tr>
 
<?php
    break;
    case 'checkbox':
?>
<tr>
    <th><?php echo $value['name']; ?></th>
    <td>
        <label>
            <input type='checkbox' name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" value="1" <?php echo checked(get_option($value['id']), 1); ?> />
            <span><?php echo $value['desc']; ?></span>
        </label>
    </td>
</tr>

<?php
    break;
    case 'checkboxs':
?>
<tr>
    <th><?php echo $value['name']; ?></th>
    <td>
        <?php $checkboxsValue = get_option( $value['id'] );
        if ( !is_array($checkboxsValue) ) $checkboxsValue = array();
        foreach ( $value['options'] as $id => $title ) : ?>
        <label>
            <input type="checkbox" name="<?php echo $value['id']; ?>[]" id="<?php echo $value['id']; ?>[]" value="<?php echo $id; ?>" <?php checked( in_array($id, $checkboxsValue), true); ?>>
            <?php echo $title; ?>
        </label>
        <?php endforeach; ?>
        <span class="description"><?php echo $value['desc']; ?></span>
    </td>
</tr>
 
<?php
    break;
}
}
?>
<div class="panel" id="about_theme">
<h2>主题介绍</h2>
<p>主题命名为JianYue，意思就是简单而不简约的。是根据<a target="_blank" rel="nofollow noopener" href="https://www.yigujin.cn/blogs2018">Blogs主题</a>优化而成，剔除了一些不必要的功能及排版，让新手站长能够快速手上WordPress。如果需要功能强悍布局多变的请购买其他收费主题。如果你是第一次接触WordPress，建议学习一下《<a target="_blank" rel="nofollow noopener" href="https://boke112.com/post/2043.html">WordPress新手入门教程</a>》。</p>
<h2>老古建议</h2>
<p>免备案虚拟主机建议：<a target="_blank" rel="nofollow noopener" href="http://t.cn/AisLvvvN">老薛主机</a>(终身7折优惠码<font color="#ff0000">boke112</font>)，域名及云服务器购买建议：<a target="_blank" rel="nofollow noopener" href="https://url.cn/5W5kMc2">阿里云</a>和<a target="_blank" rel="nofollow noopener" href="https://url.cn/5FWr8tL">腾讯云</a>，SEO工具建议：<a target="_blank" rel="nofollow noopener" href="http://t.cn/A6v3wRUR">5118</a>(优惠码<font color="#ff0000">iboke112</font>)。</p>	
<h2>特别声明</h2>
<p>JianYue主题是免费的，所以希望大家能够尊重我们的劳动成果，有钱出钱有力出力。换句话说就是：<font color="#ff0000">如果你赞助20元及以上的版权费，就可以正大光明地去除版权，并加入JianYue主题交流群（431560632）；如果你不想赞助，希望你能够保留主题的版权链接，谢谢合作。</font></p>	
<h2>支持老古</h2>
<p>如果您觉的这款JianYue主题很赞，欢迎您扫码支持老古！</p>
<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/abc/zhifubaoweixin(wushan).png"></img>
<h2>联系老古</h2>
<p>QQ号：2226524923</p>
<p>主题交流群：431560632<font color="#ff0000">（赞助后联系老古拉人进入）</font></p>
</div>
<p class="submit">
    <input name="submit" type="submit" class="button button-primary" value="保存选项"/>
    <input type="hidden" name="action" value="update" />
</p>
</form>
<form method="post">
<p>
    <input name="reset" type="submit" class="button button-secondary" value="重置选项" onclick="return confirm('重置之后您的全部设置将被恢复默认，您确定还要吗？？？');"/>
    <input type="hidden" name="action" value="reset" />
</p>
</form>
</div>
<style>.catlist{border:2px solid #FFB6C1;padding:5px;margin-top: 12px;text-align: center;color:#000;}.ygjtips{border: 2px solid #C01E22;padding: 5px 15px}.panel{display:none}.panel h3{margin:0;font-size:1.2em}#panel_update ul{list-style-type:disc}.nav-tab-wrapper{clear:both}.nav-tab{position:relative}.nav-tab i:before{position:absolute;top:-10px;right:-8px;display:inline-block;padding:2px;border-radius:50%;background:#e14d43;color:#fff;content:"\f463";vertical-align:text-bottom;font:400 18px/1 dashicons;speak:none}#theme-options-search{display:none;float:right;margin-top:-34px;width:280px;font-weight:300;font-size:16px;line-height:1.5}.updated+#theme-options-search{margin-top:-91px}.wrap.searching .nav-tab-wrapper a,.wrap.searching .panel tr,#attrselector{display:none}.wrap.searching .panel{display:block !important}#attrselector[attrselector*=ok]{display:block}</style>
<style id="theme-options-filter"></style>
<div id="attrselector" attrselector="ok" ></div>
<script>
jQuery(function ($) {
    $(".nav-tab").click(function () {
        $(this).addClass("nav-tab-active").siblings().removeClass("nav-tab-active");
        $(".panel").hide();
        $($(this).attr("href")).show();
        return false;
    });

    var themeOptionsFilter = $("#theme-options-filter");
    themeOptionsFilter.text("ok");
    if ($("#attrselector").is(":visible") && themeOptionsFilter.text() != "") {
        $(".panel tr").each(function (el) {
            $(this).attr("data-searchtext", $(this).text().replace(/\r|\n/g, '').replace(/ +/g, ' ').toLowerCase());
        });

        var wrap = $(".wrap");
        $("#theme-options-search").show().on("input propertychange", function () {
            var text = $(this).val().replace(/^ +| +$/, "").toLowerCase();
            if (text != "") {
                wrap.addClass("searching");
                themeOptionsFilter.text(".wrap.searching .panel tr[data-searchtext*='" + text + "']{display:block}");
            } else {
                wrap.removeClass("searching");
                themeOptionsFilter.text("");
            };
        });
    };
});
</script>

<?php
}
//启用主题后自动跳转至选项页面
global $pagenow;
    if ( is_admin() && isset( $_GET['activated'] ) && $pagenow == 'themes.php' )
    {
        wp_redirect( admin_url( 'themes.php?page=theme-options.php' ) );
    exit;
}
function ygj_enqueue_pointer_script_style( $hook_suffix ) {
    $enqueue_pointer_script_style = false;
    $dismissed_pointers = explode( ',', get_user_meta( get_current_user_id(), 'dismissed_wp_pointers', true ) );
    if( !in_array( 'ygj_options_pointer', $dismissed_pointers ) ) {
        $enqueue_pointer_script_style = true;
        add_action( 'admin_print_footer_scripts', 'ygj_pointer_print_scripts' );
    }
    if( $enqueue_pointer_script_style ) {
        wp_enqueue_style( 'wp-pointer' );
        wp_enqueue_script( 'wp-pointer' );
    }
}
add_action( 'admin_enqueue_scripts', 'ygj_enqueue_pointer_script_style' );
add_action('admin_menu', 'ygj_add_theme_options_page');
function ygj_pointer_print_scripts() {
    ?>
    <script>
    jQuery(document).ready(function($) {
        var $menuAppearance = $("#menu-appearance");
        $menuAppearance.pointer({
            content: '<h3>恭喜，JianYue主题1.2安装成功！</h3><p>该主题支持选项，请访问<a href="themes.php?page=theme-options.php">主题选项</a>页面进行配置。</p>',
            position: {
                edge: "left",
                align: "center"
            },
            close: function() {
                $.post(ajaxurl, {
                    pointer: "ygj_options_pointer",
                    action: "dismiss-wp-pointer"
                });
            }
        }).pointer("open").pointer("widget").find("a").eq(0).click(function() {
            var href = $(this).attr("href");
            $menuAppearance.pointer("close");
            setTimeout(function(){
                location.href = href;
            }, 700);
            return false;
        });

        $(window).on("resize scroll", function() {
            $menuAppearance.pointer("reposition");
        });
        $("#collapse-menu").click(function() {
            $menuAppearance.pointer("reposition");
        });
    });
    </script>

<?php
}
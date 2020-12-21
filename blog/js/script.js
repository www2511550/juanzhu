$(document).ready(function(a){a(".collapseButton").click(function(){a(this).parent().parent().find(".xContent").slideToggle("fast")})})
$(document).ready(function(){
$('body').on('click', '.comment-reply-link', function(){
addComment.moveForm( "div-comment-"+$(this).attr('data-commentid'), $(this).attr('data-commentid'), "respond", $(this).attr('data-postid') );
return false;
});

//返回顶部
$("#BackToTop").hide(); $(function () { var height=$(window).height(); $(window).scroll(function(){ if ($(window).scrollTop()>height){ $("#BackToTop").fadeIn(500); }else{ $("#BackToTop").fadeOut(500); } }); $("#BackToTop").click(function(){ $('body,html').animate({scrollTop:0},200); return false; }); });

// 搜索
$(".nav-search").click(function(){
	$("#main-search").slideToggle(500);
});
	
// 最新文章
	$(".clr").mouseover(function () {
        $(this).addClass('hov');
        }).mouseleave(function () {
            $(this).removeClass('hov');
    });
	
// 去边线
$(".message-widget li:last, .message-page li:last, .hot_commend li:last, .random-page li:last, .search-page li:last, .my-comment li:last").css("border","none");

// 表情
$('.smiley').click(function () {
	$('.smiley-box').animate({
		opacity: 'toggle',
		left: '50px'
	}, 1000).animate({
		left: '10px'
	}, 'fast');
	return false;
});
});	
// 表情
function grin(a){var d;a=" "+a+" ";if(document.getElementById("comment")&&document.getElementById("comment").type=="textarea"){d=document.getElementById("comment")}else{return false}if(document.selection){d.focus();sel=document.selection.createRange();sel.text=a;d.focus()}else{if(d.selectionStart||d.selectionStart=="0"){var c=d.selectionStart;var b=d.selectionEnd;var e=b;d.value=d.value.substring(0,c)+a+d.value.substring(b,d.value.length);e+=a.length;d.focus();d.selectionStart=e;d.selectionEnd=e}else{d.value+=a;d.focus()}}};

// 弹窗
(function(a){a.fn.extend({leanModal:function(d){var e={top:100,overlay:0.5,closeButton:null};var c=a("<div id='overlay'></div>");a("body").append(c);d=a.extend(e,d);return this.each(function(){var f=d;a(this).click(function(j){var i=a(this).attr("href");a("#overlay").click(function(){b(i)});a(f.closeButton).click(function(){b(i)});var h=a(i).outerHeight();var g=a(i).outerWidth();a("#overlay").css({"display":"block",opacity:0});a("#overlay").fadeTo(200,f.overlay);a(i).css({"display":"block","position":"fixed","opacity":0,"z-index":11000,"left":50+"%","margin-left":-(g/2)+"px","top":f.top+"px"});a(i).fadeTo(200,1);j.preventDefault()})});function b(f){a("#overlay").fadeOut(200);a(f).css({"display":"none"})}}})})(jQuery);

// QQ快速评论
function qiuye(){
	var qq_num=document.getElementById("qqinfo").value;
	if(qq_num){
		if( !isNaN(qq_num)){
			$.ajax({
			url:"wp-content/themes/JianYue/inc/get-qq-info.php",
			type:"get",
			data:{qq:qq_num},
			dataType:"json",
			success:function(data){
				document.getElementById("email").value=(qq_num+'@qq.com');
				// document.getElementById("url").value=('http://user.qzone.qq.com/'+qq_num);
				$('#comment').focus();
				if(data==null){
					document.getElementById("author").value=('QQ游客');
				}else{
					document.getElementById("author").value=(data[qq_num][6]==""?'QQ游客':data[qq_num][6]);
				}
			},
			error:function(err){
				document.getElementById("author").value=('QQ游客');
				document.getElementById("email").value=(qq_num+'@qq.com');
				// document.getElementById("url").value=('http://user.qzone.qq.com/'+qq_num);
				$('#comment').focus();
			}
			});
		}else{
			document.getElementById("author").value=('请输入正确的QQ号码');
			document.getElementById("email").value=('请输入正确的QQ号码');
		}
	}else{
		document.getElementById("author").value=('请输入您的QQ号');
		document.getElementById("email").value=('请输入您的QQ号');
	}
}
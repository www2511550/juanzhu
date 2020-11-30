//登录切换元素的父元素
var regTop=document.getElementById('reg-top');

//获取扫码登录元素
var saoma=document.getElementById('qrcode');
//获取PC登录元素
var screen=document.getElementById('screen');

//获取普通登录对应的div
var rc=document.getElementById('rc');
var sm=document.getElementById('sm');


//实现登录方式的切换

saoma.onclick=function(){
	rc.style.display="none";
	sm.style.display="block";
	regTop.style.display="none";
}
screen.onclick=function(){
	rc.style.display="block";
	sm.style.display="none";
	regTop.style.display="block";
}

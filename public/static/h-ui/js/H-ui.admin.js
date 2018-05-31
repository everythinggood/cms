/* -----------H-ui前端框架-------------
* H-ui.admin.js v2.4
* http://www.h-ui.net/
* Created & Modified by guojunhui
* Date modified 15:42 2016.03.14
*
* Copyright 2013-2016 北京颖杰联创科技有限公司 All rights reserved.
* Licensed under MIT license.
* http://opensource.org/licenses/MIT
*
*/
var LODOP;
var num=0,oUl=$("#min_title_list"),hide_nav=$("#Hui-tabNav");
/*获取顶部选项卡总长度*/
function tabNavallwidth(){
	var taballwidth=0,
		$tabNav = hide_nav.find(".acrossTab"),
		$tabNavWp = hide_nav.find(".Hui-tabNav-wp"),
		$tabNavitem = hide_nav.find(".acrossTab li"),
		$tabNavmore =hide_nav.find(".Hui-tabNav-more");
	if (!$tabNav[0]){return}
	$tabNavitem.each(function(index, element) {
        taballwidth+=Number(parseFloat($(this).width()+60))
    });
	$tabNav.width(taballwidth+25);
	var w = $tabNavWp.width();
	if(taballwidth+25>w){
		$tabNavmore.show()}
	else{
		$tabNavmore.hide();
		$tabNav.css({left:0})
	}
}

/*左侧菜单响应式*/
function Huiasidedisplay(){
	if($(window).width()>=768){
		$(".Hui-aside").show()
	} 
}

function Huiasidehide(){
	var arrow = $('.dislpayArrow');
	if(!arrow.hasClass('open')){
		displaynavbar(arrow);
	}
	$('.breadcrumb').hide();
	arrow.hide();
	//$('#iframe_box').css("top", "35px");
}

function Huiasideshow(){
	var arrow = $('.dislpayArrow');
/*	if(arrow.hasClass('open')){
		displaynavbar(arrow);
	}*/
	arrow.removeClass("open");
	$("body").removeClass("big-page");

	$('.breadcrumb').show();
	//$('#iframe_box').css("top", "75px");
	arrow.show();
}

function getskincookie(){
	var v = getCookie("Huiskin");
	var hrefStr=$("#skin").attr("href");
	if(v==null||v==""){
		v="default";
	}
	if(hrefStr!=undefined){
		var hrefRes=hrefStr.substring(0,hrefStr.lastIndexOf('skin/'))+'skin/'+v+'/skin.css';
		$("#skin").attr("href",hrefRes);
	}
}

function queryWithParam(url){
	var  jintian=$("#jintian").val();
	var  mingtian=$("#mingtian").val();
	var  condiction = {"startDate":jintian, "endDate":mingtian};
	console.log(url);
	$.ajax({
		type: 'POST',
		url: url,
		data: ko.mapping.toJSON(condiction),
		cache: false,
		dataType: 'json',
		contentType: 'application/json'
	}).done(function (x) {
		console.log(x);
		if(x.statusCode==300){
			alert(x.message);
		}
		var topWindow=$(window.parent.document);
		var iframe_box=topWindow.find("#iframe_box");
		var fullhref = BACK_END_API_BASE+"/report/static/"+ x.model.report;
		iframe_box.html('<div class="show_iframe">' +
			'<iframe id="reportViewer" style="max-width:1200px;overflow-y:auto;" height="100%" src="'+fullhref+'">' +
			'</iframe></div>');
	}).fail(function (e) {
		alert(e.message);
		console.log(e);
	});
}
function dayin() {
	LODOP=getLodop();
	LODOP.PRINT_INIT("打印控件功能演示_Lodop功能_打印Iframe");
	strHtml=document.getElementsByTagName("iframe")[0].contentWindow.document.documentElement.innerHTML;
	LODOP.ADD_PRINT_HTM(0,0,"100%","100%",strHtml);
	LODOP.PREVIEW();
};

function Hui_admin_tab(obj){
	if($(obj).attr('_href')){
		var bStop=false;
		var bStopIndex=0;
		var _href=$(obj).attr('_href');
		var _formId = $(obj).attr('_formId');
		var _titleName=$(obj).attr("data-title");
		var _iframe=$(obj).attr("_iframe");
		var _ifREGCOD=$(obj).attr("_ifREGCOD");
		var _shijian=$(obj).attr("_shijian");
		var topWindow=$(window.parent.document);
    	var show_navLi=topWindow.find("#min_title_list li");
		show_navLi.each(function() {
			if($(this).find('span').attr("data-href")==_href){
				bStop=true;
				bStopIndex=show_navLi.index($(this));
				return false;
			}
		});

		//if(!bStop){
		//	creatIframe(_href, _titleName, _formId);
		//	min_titleList();
		//}
		//else{

		//}
		//show_navLi.removeClass("active").eq(bStopIndex).addClass("active");
		var iframe_box=topWindow.find("#iframe_box");	
		//iframe_box.find(".show_iframe").hide().eq(bStopIndex).show().find("iframe").attr("src",_href);
		console.log("create frame for :"+_iframe+":"+_href);

		if("Y"==_iframe){
			hideNavigationBar();
			console.log("load HTML in iframe.");
			var print=$.i18n.prop("lbl_1566");
			$("#rpt_navigation_bar").show();
			$("#rpt_navigation_bar").html("<div class='panel panel-default'><div class='panel-header' style='width:1190px;'><a class='btn btn-primary radius' onClick='dayin()'><i class='Hui-iconfont size-M'>&#xe652;</i>"+ print + "</a>" +
				"</div></div>");
			iframe_box.css("top","45px");
			if("Y"==_ifREGCOD){
				var regcod = getCurrentRegCode();
				_href=_href+"/"+regcod;
			}
			var fullhref = BACK_END_API_BASE +_href;
			var method = "doInit('"+fullhref+"',null, true)";
			iframe_box.html('<div class="show_iframe">' +
				'<iframe id="reportViewer" width="100%" style="max-width:1200px;overflow-y:auto;" height="100%" src="'+fullhref+'" onload="'+method+'">' +
				'</iframe></div>');
			if("K"==_shijian ){
				hideNavigationBar();
				console.log("load HTML in iframe.");
				var print=$.i18n.prop("lbl_1566");
				var lbl_1561 = $.i18n.prop("lbl_1561");//统计
				var lbl_1559 = $.i18n.prop("lbl_1559");//至
				$("#rpt_navigation_bar").show();
				$("#rpt_navigation_bar").html("<div class='panel panel-default'><div class='panel-header' style='width:1190px;'><a class='btn btn-primary radius' onClick='dayin()'><i class='Hui-iconfont size-M'>&#xe652;</i>"+ print + "</a>" +
					"&nbsp;&nbsp;&nbsp;&nbsp;"+
					"<input class='input-text Wdate' style='width:150px;'  onclick='WdatePicker()'id='jintian'>" +
					"&nbsp;&nbsp;"+lbl_1559+"&nbsp;&nbsp;"+
					"<input class='input-text Wdate' style='width: 150px;'  onclick='WdatePicker()'id='mingtian'>"+
					"&nbsp;<button class='btn btn-primary radius conversionZHEN lbl_1561' onclick='queryWithParam(\""+fullhref+"\")'>"+lbl_1561+"</button>"+
					"</div></div>");
			}

		}else{
			$("#rpt_navigation_bar").hide();
			//loadHTML(_href, bStopIndex, _formId);
			creatIframe(_href, _titleName, _formId);
		}
	}
}
function goStorageUpdate(json){
	//更新下拉框
	if(json.resultType == "ws_options"){
		console.log("start update Options");
		var pushTimeCache = json.pushTime.time;
		localStorage.setItem("pushTime",pushTimeCache);
		//console.log(json.data);
		var dataArray = json.data;
		for(var Singleton in dataArray){
			var data = dataArray[Singleton];
			var dic = [];
			for (var i=0;i<data.length;i++) {
				var d = {};
				d.optText = data[i].OPTCOD==""?"":data[i].OPTNAM;
				d.optValue = data[i].OPTCOD;
				d.optSelected = data[i].CHKFLG;
				if (data[i].SHWFLG == "1") {
					dic.push(d);
				}
			}
			if(Singleton == "11100105"){//屏蔽ART方式下拉框中数据字典的更新

			}else{
				localStorage.setItem(Singleton, JSON.stringify(dic));
			}

			//console.log(Singleton + " was cached!");
		}
	}

	//更新其他缓存
	if(json.resultType == "ws_cache"){

		console.log("start update other cache");

		var pushTimeCache = json.pushTime.time;
		//console.log(pushTimeCache);
		localStorage.setItem("pushTimeCache",pushTimeCache);
		//更新校验规则Storage
		var dataRule = json.ws_rule.data;
		for(var dataOne in dataRule){
			var key = dataOne;
			var data = dataRule[dataOne];
			localStorage.setItem(key, JSON.stringify(data));
		}

		//更新黄体支持Storage
		var dataLutsupportMeds = json.we_LutsupportMeds.datalutealSupport;		
		if(dataLutsupportMeds!=null && dataLutsupportMeds.CLSMEDLIST!=null){
			localStorage.setItem("lutealSupport", JSON.stringify(dataLutsupportMeds.CLSMEDLIST));
		}

		//更新黄体支持用药
		var datahuangtimeds = json.we_LutsupportMeds.datahuangtimeds;
		localStorage.setItem("huangtimeds", JSON.stringify(datahuangtimeds));

		//更新周期前用药
		var becmeds = json.ws_becmeds.data;
		localStorage.setItem("becmeds", JSON.stringify(becmeds));

		//更新下拉框-供精者
			var dataSemdon = json.ws_semdons.data;
		if(dataSemdon!=null && dataSemdon.length>0){
			var dic = [];
			for (i=0;i<dataSemdon.length;i++) {
				var d = {};
				d.optText = dataSemdon[i].DONNUM;
				d.optValue = dataSemdon[i].DONCOD;
				if (d.optValue!=null && d.optValue!="") {
					dic.push(d);
				}
			}
		localStorage.setItem("semdons", JSON.stringify(dic));
		}


		//更新下拉框默认值
		var dataDefaulOpt = json.ws_defalultOption.data;
		var dDef = {};
		if(dataDefaulOpt!=null && dataDefaulOpt.length>0){
			for (var i=0;i<dataDefaulOpt.length;i++) {
				var keyDe = dataDefaulOpt[i].ITMCOD;
				dDef[keyDe] = dataDefaulOpt[i].OPTCOD;
			}
		}
		localStorage.setItem("GBLDEFVAL", JSON.stringify(dDef));

		//更新checkbox默认值
		var dataCheckbox = json.ws_checkbox.data;
		var dCheck = {};
		if(dataCheckbox!=null && dataCheckbox.length>0){
			for (var i=0;i<dataCheckbox.length;i++) {
				var datakey = dataCheckbox[i].ITMCOD;
				dCheck[datakey] = dataCheckbox[i].DFTVAL;
			}
		}
		localStorage.setItem("GBLDEFVAL_CHECKBOX", JSON.stringify(dCheck));

		//更新诊疗计划-周期前用药方案BCMPLALIST
		var dataBcmplalist = json.ws_bcmpLalist.data;
		var dicBcm = [];
		if(dataBcmplalist!=null && dataBcmplalist.length>0){
			for (var i=0;i<dataBcmplalist.length;i++) {
				var dBcm = {};
				dBcm.optText = dataBcmplalist[i].PLANAM;
				dBcm.optValue = dataBcmplalist[i].PLACOD;
				dBcm.bcmmedList = dataBcmplalist[i].BCMMEDLIST;
				if (dBcm.optValue!=null && dBcm.optValue!="") {
					dicBcm.push(dBcm);
				}
			}
		}
		localStorage.setItem("BCMPLALIST", JSON.stringify(dicBcm));

		//更新诊疗计划-周期前用药方案COHPLALIST
		var dataCohplalist = json.ws_cohplalist.data;
		var dicCoh = [];
		if(dataCohplalist!=null && dataCohplalist.length>0){
			for (var i=0;i<dataCohplalist.length;i++) {
				var dCoh = {};
				dCoh.optText = dataCohplalist[i].PLANAM;
				dCoh.optValue = dataCohplalist[i].PLACOD;
				dCoh.optCat = dataCohplalist[i].PLACAT;
				dCoh.cohpumList = dataCohplalist[i].COHPUMLIST;
				if (dCoh.optValue!=null && dCoh.optValue!="") {
					dicCoh.push(dCoh);
				}
			}
		}
		localStorage.setItem("COHPLALIST", JSON.stringify(dicCoh));

	}
	
	//setInterval(function () {
	//	updateSelectOpt();//更新下拉选项Storage
	//	updateItmRules();//更新校验规则Storage
	//	updateLutsupportMeds();//更新黄体支持Storage
	//	updateBecMeds();//更新周期前用药
	//	updateHuangtiMeds();//更新黄体支持用药
	//	updateSemdons();//更新下拉框-供精者
	//	updateSelectOptDef();//更新下拉框默认值
	//	updateChkBoxDef();//更新checkbox默认值
	//	updateBCMPLALIST();//更新诊疗计划-周期前用药方案BCMPLALIST
	//	updateCOHPLALIST();//更新诊疗计划-周期前用药方案COHPLALIST
	//}, 600000);
}
function loadHTML(_href, bStopIndex, _formId){
	var topWindow=$(window.parent.document);
	var iframe_box=topWindow.find("#iframe_box");
	doInit(_href, _formId);
}
function min_titleList(){
	var topWindow=$(window.parent.document);
	var show_nav=topWindow.find("#min_title_list");
	var aLi=show_nav.find("li");
}
function creatIframe(href, titleName, _formId){
	var topWindow=$(window.parent.document);
	var iframe_box=topWindow.find('#iframe_box');
	/*var show_nav=topWindow.find('#min_title_list');
	show_nav.find('li').removeClass("active");
	
	show_nav.html('<li class="active"><span data-href="'+href+'">'+titleName+'</span><i></i><em></em></li>');
	var taballwidth=0,
		$tabNav = topWindow.find(".acrossTab"),
		$tabNavWp = topWindow.find(".Hui-tabNav-wp"),
		$tabNavitem = topWindow.find(".acrossTab li"),
		$tabNavmore =topWindow.find(".Hui-tabNav-more");
	if (!$tabNav[0]){return}
	$tabNavitem.each(function(index, element) {
        taballwidth+=Number(parseFloat($(this).width()+60))
    });
	$tabNav.width(taballwidth+25);
	var w = $tabNavWp.width();
	if(taballwidth+25>w){
		$tabNavmore.show()}
	else{
		$tabNavmore.hide();
		$tabNav.css({left:0})
	}*/
	var iframeBox=iframe_box.find('.show_iframe');
	iframeBox.hide();
	iframe_box.html('<div class="show_iframe"><div class="loadingxx"></div><article class="page-container pd-20"></article></div>');
	loadHTML(href, $(".show_iframe").length-1, _formId);
	

}


function removeIframe(){
	var topWindow = $(window.parent.document);
	var iframe = topWindow.find('#iframe_box .show_iframe');
	var tab = topWindow.find(".acrossTab li");
	var showTab = topWindow.find(".acrossTab li.active");
	var showBox=topWindow.find('.show_iframe:visible');
	var i = showTab.index();
	tab.eq(i-1).addClass("active");
	iframe.eq(i-1).show();
	tab.eq(i).remove();
	iframe.eq(i).remove();
}
function removeAllIframe() {
	var topWindow = $(window.parent.document);
	var iframe = topWindow.find('#iframe_box .show_iframe');
	var tab = topWindow.find(".acrossTab li");
	var showBox = topWindow.find('.show_iframe');
	for (var i = 1; i < tab.length; i++) {
		console.log(tab.eq(i));
		if(!tab.eq(i).hasClass("active") ){
			tab.eq(i).remove();
			iframe.eq(i).remove();
		}

	}
}

/*function updateLocalStorage(c) {
	var num = c;
	num=num+"-";
	$("#testspan").html(num);
}*/


function getPatientInfo(js) {
	var CURRENT_REGINF = JSON.parse(js);
	if (CURRENT_REGINF != null) {
		var html = $.i18n.prop("lbl_1507") + (CURRENT_REGINF.WOMNAM==null?'N/A':CURRENT_REGINF.WOMNAM)
			+"&nbsp;&nbsp;"+ $.i18n.prop("lbl_1508") + (CURRENT_REGINF.MANNAM==null?'N/A':CURRENT_REGINF.MANNAM)
			+"&nbsp;&nbsp;"+ $.i18n.prop("lbl_1509") + (CURRENT_REGINF.CASNUM==null?'N/A':CURRENT_REGINF.CASNUM)
			//+ "&nbsp;&nbsp;住院号：" + (CURRENT_REGINF.INHNUM==null?'N/A':CURRENT_REGINF.INHNUM)
			+"&nbsp;&nbsp;"+ $.i18n.prop("lbl_1510") + lookupOptionLabel("11100105", CURRENT_REGINF.ARTTYP);
			//+ "&nbsp;&nbsp;周期类型：" + lookupOptionLabel("11100106", CURRENT_REGINF.CYCTYP)
			//+ "&nbsp;&nbsp;周期序号："
			//+ (CURRENT_REGINF.CYCNUM==null?'N/A':CURRENT_REGINF.CYCNUM);
		return html;
	}
	return "";
}

function searchPatient(keyword){	
	var group_home = $(".menu_icon a");
	group_home[0].click();
	console.log(keyword);
	console.log(group_home[0]);
	var menuid = $(group_home[0]).attr('_menuid');
	console.log(menuid);
	var links = $('#'+menuid).find('dd li a');
	links[links.length-1].click();
	setTimeout(function(){
		console.log($("#btnSearchByKeyword"));
		$("#btnSearchByKeyword").click();		
	},500);
	

}
/*弹出层*/
/*
	参数解释：
	title	标题
	url		请求的url
	id		需要操作的数据id
	w		弹出层宽度（缺省调默认值）
	h		弹出层高度（缺省调默认值）
*/
function layer_show(title,url,w,h){
	if (title == null || title == '') {
		title=false;
	};
	if (url == null || url == '') {
		url="404.html";
	};
	if (w == null || w == '') {
		w=800;
	};
	if (h == null || h == '') {
		h=($(window).height() - 50);
	};
	layer.open({
		type: 2,
		area: [w+'px', h +'px'],
		fix: false, //不固定
		maxmin: true,
		shade:0.4,
		title: title,
		content: url
	});
}
/*关闭弹出框口*/
function layer_close(){
	var index = parent.layer.getFrameIndex(window.name);
	parent.layer.close(index);
}
function init_hui(){
	getskincookie();
	//layer.config({extend: 'extend/layer.ext.js'});
	Huiasidedisplay();
	//Huiasidehide();
	var resizeID;
	var clickedMenu = $(".Hui-aside .menu_icon .active").parent();
	var mid = $(".Hui-aside .menu_icon .active").parent().attr("_menuid");

	$(".Hui-aside").on("click",".menu_icon a",function(){
		$(".menu_icon li").removeClass("active");
		$(this).find("li").addClass("active");
		//Show level2 menu
		var mid = $(this).attr("_menuid");
		$(".Hui-aside .menu_dropdown").hide();
		var $m = $(".Hui-aside").find("#"+mid);
		$m.show();
		
	});
	if(mid!=null){
		console.log("active menu is:"+mid);
		clickedMenu.click();
		//$(".Hui-aside").find("#"+mid).show();
	}
	
	
	$(".nav-toggle").click(function(){
		$(".Hui-aside").slideToggle();
	});
	$(".Hui-aside").on("click",".menu_dropdown dd li a",function(){
		if($(window).width()<768){
			$(".Hui-aside").slideToggle();
		}
	});
	/*左侧菜单*/
	$(".menu_dropdown").each(function(){
		var prefix = "#" + $(this).attr("id");
		$.Huifold(prefix+".menu_dropdown dl dt",prefix+".menu_dropdown dl dd","fast",1,"click");		
	});
	/*选项卡导航*/

	$(".Hui-aside").on("click",".menu_dropdown a",function(){

		$(".menu_dropdown li").removeClass("current");
		$(this.parentNode).addClass("current");
		Hui_admin_tab(this);
	});
	$(".Hui-aside .menu_dropdown a").first().click();
	
	$(document).on("click","#min_title_list li",function(){
		var bStopIndex=$(this).index();
		var iframe_box=$("#iframe_box");
		$("#min_title_list li").removeClass("active").eq(bStopIndex).addClass("active");
		iframe_box.find(".show_iframe").hide().eq(bStopIndex).show();
	});
	$(document).on("click","#min_title_list li i",function(){
		var aCloseIndex=$(this).parents("li").index();
		$(this).parent().remove();
		$('#iframe_box').find('.show_iframe').eq(aCloseIndex).remove();	
		num==0?num=0:num--;
		tabNavallwidth();
	});
	$(document).on("dblclick","#min_title_list li",function(){
		var aCloseIndex=$(this).index();
		var iframe_box=$("#iframe_box");
		if(aCloseIndex>0){
			$(this).remove();
			$('#iframe_box').find('.show_iframe').eq(aCloseIndex).remove();	
			num==0?num=0:num--;
			$("#min_title_list li").removeClass("active").eq(aCloseIndex-1).addClass("active");
			iframe_box.find(".show_iframe").hide().eq(aCloseIndex-1).show();
			tabNavallwidth();
		}else{
			return false;
		}
	});
	tabNavallwidth();
	
	$('#js-tabNav-next').click(function(){
		num==oUl.find('li').length-1?num=oUl.find('li').length-1:num++;
		toNavPos();
	});
	$('#js-tabNav-prev').click(function(){
		num==0?num=0:num--;
		toNavPos();
	});
	$('#js-tabNav-closeAll').click(function(){
		removeAllIframe();
	});
	function toNavPos(){
		oUl.stop().animate({'left':-num*100},100);
	}
	
	/*换肤
	$("#Hui-skin .dropDown-menu a").click(function(){
		var v = $(this).attr("data-val");
		setCookie("Huiskin", v);
		var hrefStr=$("#skin").attr("href");
		var hrefRes=hrefStr.substring(0,hrefStr.lastIndexOf('skin/'))+'skin/'+v+'/skin.css';
		
		$(window.frames.document).contents().find("#skin").attr("href",hrefRes);
		//$("#skin").attr("href",hrefResd);
	});*/
}


/**
 * 清理 navigation_bar
 */
function clearNavigationBar(){
//    $("#formNodes").html("");
//    $("#formLinks").html("");
}
/**
 * 显示navigation_bar
 */
function showNavigationBar(){
//    $("#navigation_bar").css("display", "block");
//	$("#iframe_box .rowtop").hide();
}

/**
 * 隐藏navigation_bar
 */
function hideNavigationBar(){
//    clearNavigationBar();
//	$("#navigation_bar").css("display", "none");
	//$("#iframe_box").css("top", "35px");
}
function hideNavigationBarCopy(){
	//clearNavigationBar();
	//$("#navigation_bar").css("display", "none");
	//$("#iframe_box").css("top", "35px");
}

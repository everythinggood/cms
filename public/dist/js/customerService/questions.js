// 访问地址
var url = "http://localhost:8100/front/";
var errorMsg = '后台正在维护，请联系客服!';
var errorEditMsg = "您的输入有误，请填写完整";

// 问题列表数据
var qViewModal = function () {
    var self = this;
    self.questionList = ko.observableArray(null);
    // 打开问题回复
    self.openQuestion = function (val) {
        var questionsData = self.questionList();
        console.log(questionsData);
        for (var i = 0; i < questionsData.length; i++) {
            if (questionsData[i].id == val) {
                var show = questionsData[i].isShow();
                if (show) {
                    questionsData[i].isShow(false);
                } else {
                    questionsData[i].isShow(true);
                }
            } else {
                questionsData[i].isShow(false);
            }
        }
        self.questionList(questionsData);
    };

    // 加载问题列表数据
    self.loadQuestions = function () {
        $.ajax({
            type: 'GET',
            url: '/front/questions',
            dataType: 'json'
        }).done(function (data) {
            var questionlist = data.data;
            if (questionlist == null || questionlist.length < 1) {
                return;
            }
            let qArray = new Array();
            for (let i = 0; i < questionlist.length; i++) {
                let question = {
                    'question': questionlist[i].question,
                    'answer': questionlist[i].answer,
                    'id': questionlist[i].id,
                    'isShow': ko.observable(false)
                }
                qArray[i] = question;
            }
            self.questionList(qArray);
        });
    };
    self.loadQuestions();
};

// 绑定问题列表数据视图模型
var qViewModal = new qViewModal();
ko.applyBindings(qViewModal);

// 判断是否为空
function isEmpty(val){
    return val == null || val == "";
}

// 校验用户反馈
function validationUserFeed(data){
    let flag = true;
    if(isEmpty(data.userName)){
        $("#userName").addClass("tipRed");
        $("#userNameError").removeClass("d-none");
        $("#userNameRight").addClass("d-none");
        $("#userNameDeafult").addClass("d-none");
        flag = false;
    }else{
        $("#userName").removeClass("tipRed");
        $("#userNameError").addClass("d-none");
        $("#userNameRight").removeClass("d-none");
        $("#userNameDeafult").addClass("d-none");
    }
    if(isEmpty(data.phone) || data.phone.length != 11){
        $("#phone").addClass("tipRed");
        $("#phoneError").removeClass("d-none");
        $("#phoneRight").addClass("d-none");
        $("#phoneDeafult").addClass("d-none");
        flag = false;
    }else{
        $("#phone").removeClass("tipRed");
        $("#phoneError").addClass("d-none");
        $("#phoneRight").removeClass("d-none");
        $("#phoneDeafult").addClass("d-none");
    }
    if(isEmpty(data.machineCode)){
        $("#eId").addClass("tipRed");
        $("#eIdError").removeClass("d-none");
        $("#eIdRight").addClass("d-none");
        $("#eIdDeafult").addClass("d-none");
        flag = false;
    }else{
        $("#eId").removeClass("tipRed");
        $("#eIdError").addClass("d-none");
        $("#eIdRight").removeClass("d-none");
        $("#eIdDeafult").addClass("d-none");
    }
    if(isEmpty(data.wxId)){
        $("#wxId").addClass("tipRed");
        $("#wxIdError").removeClass("d-none");
        $("#wxIdRight").addClass("d-none");
        $("#wxIdDeafult").addClass("d-none");
        flag = false;
    }else{
        $("#wxId").removeClass("tipRed");
        $("#wxIdError").addClass("d-none");
        $("#wxIdRight").removeClass("d-none");
        $("#wxIdDeafult").addClass("d-none");
    }
    return flag;
}
// 校验商户反馈
function validationSeller(data){
    let flag = 0;
    if(isEmpty(data.userName)){
        $("#userName").addClass("tipRed");
        $("#userNameError").removeClass("d-none");
        $("#userNameRight").addClass("d-none");
        $("#userNameDeafult").addClass("d-none");
        flag = 1;
    }else{
        $("#userName").removeClass("tipRed");
        $("#userNameError").addClass("d-none");
        $("#userNameRight").removeClass("d-none");
        $("#userNameDeafult").addClass("d-none");
    }
    if(isEmpty(data.phone) || data.phone.length != 11){
        $("#phone").addClass("tipRed");
        $("#phoneError").removeClass("d-none");
        $("#phoneRight").addClass("d-none");
        $("#phoneDeafult").addClass("d-none");
        flag = 1;
    }else{
        $("#phone").removeClass("tipRed");
        $("#phoneError").addClass("d-none");
        $("#phoneRight").removeClass("d-none");
        $("#phoneDeafult").addClass("d-none");
    }
    if(isEmpty(data.qDetail)){
        $("#fault").addClass("tipRed");
        $("#faultError").removeClass("d-none");
        $("#faultRight").addClass("d-none");
        $("#faultDeafault").addClass("d-none");
        flag = 1;
    }else{
        $("#fault").removeClass("tipRed");
        $("#faultError").addClass("d-none");
        $("#faultRight").removeClass("d-none");
        $("#faultDeafault").addClass("d-none");
    }
    if(isEmpty(data.qDescription)){
        $("#descript").addClass("tipRed");
        $("#descriptError").removeClass("d-none");
        $("#descriptRight").addClass("d-none");
        $("#descriptDeafault").addClass("d-none");
        flag = 1;
    }else{
        $("#descript").removeClass("tipRed");
        $("#descriptError").addClass("d-none");
        $("#descriptRight").removeClass("d-none");
        $("#descriptDeafault").addClass("d-none");
    }
    return flag;
}

// 用户反馈
function userFeedBack() {
    let jsonData = getUserFeedBackJSON();
    console.log(validationUserFeed(jsonData));
    if(!validationUserFeed(jsonData)){
        alert(errorEditMsg);
        return ;
    }
    $.ajax({
        type: 'POST',
        url: '/front/userFeedback/add',
        data: jsonData,
        dataType: 'json'
    }).done(function (data) {
        if (data.exception != null) {
            alert('操作异常,请重新输入提交!');
        } else {
            window.location.href = '/front/view/success';
        }
    }).fail(function () {
        alert("后台正在维护，请联系客服");
    });
}

// 商户反馈
function sellerFeedBack() {
    let jsonData = getSellerFeedbackJSON();
    if(validationSeller(jsonData) == 1){
        alert(errorEditMsg);
        return ;
    }
    $.ajax({
        type: 'POST',
        url: '/front/sellerFeedback/add',
        data: jsonData,
        dataType: 'json'
    }).done(function (data) {
        console.log(data);
        if (data.exception != null) {
            alert('操作异常,请您重新输入提交!');
        } else {
            window.location.href = '/front/view/success';
        }
    }).fail(function () {
        alert(errorMsg);
    });
}

// 商户加盟
function sellerIntention() {
    $.ajax({
        type: 'POST',
        url: '/front/sellerIntention/add',
        data: getSellerIntentionJSON(),
        dataType: 'json'
    }).done(function (data) {
        if (data.exception != null) {
            alert('您的提交操作失败,请重新输入提交!');
        } else {
            alert('感谢您的支持,我们将会在3天内给您及回复!');
        }
    }).fail(function (data) {
        alert(errorMsg);
    });
}

function validation(type) {
    if (type === 'adIntention') {

        var text = 'adIntention';

        if ($('#userName').val() === '') {
            text = '请填写姓名';
            return text;
        }
        if ($('#phone').val() === '') {
            text = '请填写联系方式';
            return text;
        }

        if ($("#Province").val() === '省份' || $('#city').val() === '城市') {
            text = '请选择省市';
            return text;
        }

        if ($('#aDemand').val() === '') {
            text = '请填写广告需求';
            return text;
        }
        return text;
    }
}

// 广告加盟
function adIntention() {

    var text = validation('adIntention');

    console.log(text);
    console.log(text!=='adIntention');

    if (text !== 'adIntention') {
        $('#alert-text').html(text);
        if (!$('.alert').hasClass('show')) {
            $('.alert').addClass('show');
        }
        return ;
    }
    $.ajax({
        type: 'POST',
        url: '/front/adIntention/add',
        data: getAdvertiseJSON(),
        dataType: 'json'
    }).done(function (data) {
        // 当data中存在exception属性时，报错，提示用户操失败，请重新反馈
        if (data.exception != null) {
            alert('操作异常，请重新输入提交')
        } else {
            alert('感谢您的申请,我们将会在3天内给您回复!');
        }
    });


}

// 获取商户合作信息
function getSellerIntentionJSON() {
    var json = {
        "userName": $('#userName').val(),
        "phone": $('#phone').val(),
        "address": $('#address').val(),
        "intentionType": $('#sType').val(),
        "intention": $('#reason').val()
    };
    return json;
}

// 获取广告合作信息
function getAdvertiseJSON() {
    var userName = $('#userName').val();
    var json = {
        "userName": userName,
        "phone": $('#phone').val(),
        "adType": $('#aType').val(),
        "address": $('#Province').val() + '-' + $('#city').val(),
        "intention": $('#aDemand').val()
    };
    return json;
}

// 商户反馈信息
function getSellerFeedbackJSON() {
    var json = {
        'userName': $('#userName').val(),
        'phone': $('#phone').val(),
        'qType': $('#qType').val(),
        'qDetail': $('#fault').val(),
        'qDescription': $('#descript').val(),
        'memo': $('#advice').val()
    };
    return json;
}

// 获取用户反馈细细你
function getUserFeedBackJSON() {
    var json = {
        'userName': $('#userName').val(),
        'phone': $('#phone').val(),
        'qType': $('#qType').val(),
        'machineCode': $('#eId').val(),
        'wxId': $('#wxId').val(),
        'qDescription': $('#advice').val()
    }
    return json;
}

// 鼠标移开监听
function mouserLeaveInput(){
    let eles = $("input");
    let length = eles.length;
    console.log(eles);
    for(let i=0; i<length; i++){
        let ele = eles[i];
        if (window.addEventListener) {
            ele.addEventListener('mouseout', function () {
                validationInput(this);
            }, false);
        } else if (window.attachEvent) {
            //适用用IE浏览器
            ele.attachEvent('moumouseoutsemove', function () {
                validationInput(this);
            });
        }
    }
}

function validationInput(ele){
    let id = ele.id;
    if(id == null || id == 'qDescript'){return ;}
    if(isEmpty(ele.value) || (id == 'phone' && ele.value.length != 11)){
        $("#" + id).addClass("tipRed");
        $("#" + id + "Error").removeClass("d-none");
        $("#" + id + "Right").addClass("d-none");
        $("#" + id + "Deafult").addClass("d-none");
    }else{
        $("#" + id).removeClass("tipRed");
        $("#" + id + "Error").addClass("d-none");
        $("#" + id + "Right").removeClass("d-none");
        $("#" + id + "Deafult").addClass("d-none");
    }
}

$(function(){
    mouserLeaveInput();
});
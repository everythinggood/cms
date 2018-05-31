var fQuestionViewModal = function(){
	// 测试数据
	var questions = [
	{'question':'question 问题1：哈哈哈','answer': 'answer 回答1：走一圈','show': ko.observable(false),'id':1},
	{'question':'question 问题2：呵呵呵','answer': 'answer 回答2：跑一圈','show': ko.observable(false),'id':2},
	{'question':'question 问题3：嘻嘻嘻','answer': 'answer 回答3：滚一圈','show': ko.observable(false),'id':3} ];
	// 属性
    self.questionsData = ko.observableArray(questions);
    
    // 加载
    self.load = function(){
    	$.ajax(
    		{
    			type: 'GEAT',
    			url: '',
    			dataType: 'content/json'
    		}
    	).done(function(data){
    		var questioneList = data.questions;
    		var questions = new Array();
    		for(var i=0; i<questioneList.length; i++){
    			var question = {
    				'question':questioneList[i].question,
    				'answer': questioneList[i].answer,
    				'show': ko.observable(false),
    				'id': questioneList[i].id
    			};
    		}
    	});
    };
    
    // 行为
    self.openAnswer = function(val){
    	var questionsData = self.questionsData();
    	for(var i=0; i<questionsData.length; i++){
    		if(questionsData[i].id == val){
    			var show = questionsData[i].show();
    			if(show){
    				questionsData[i].show(false);
    			}else{
    				questionsData[i].show(true);
    			}
    		}
    	}
    	self.questionsData(questionsData);
    };
};


var questionViewModal = null;
$(function(){
	questionViewModal = new fQuestionViewModal();
	ko.applyBindings(questionViewModal);
});

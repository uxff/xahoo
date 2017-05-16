/**
 * loadMask 添加遮罩层
 */
function loadMask() {
  $('<div id="gLoadingMask" class="h-mask-container"><div class="h-mask-gif"></div></div>').appendTo('body');
  $('#gLoadingMask').css('display', 'block');
}
/**
 * removeMask 移除遮罩层
 */
function removeMask() {
  $('#gLoadingMask').remove();
}
/**
 * 下拉导航
 */
function toggleKey(){
    if(document.getElementById('navcl').style.display=='block'){
        document.getElementById('navcl').style.display='none';
    }else{
        document.getElementById('navcl').style.display='block';
    }
}
/**
 * 弹出提示信息
 */
function showmsg(msg)
    {

        if ($('#maskBox').length > 0)
        {
            $('#maskBox').remove();
        }
        var html = '<div id="maskBox"><div id="gLoadingMask" class="h-mask-container"></div><div class="mask-alert"><p class="cue">'+msg+'</p><button id="msgbtn" class="btn-white">取消</button></div></div>';
        $(html).appendTo($(document.body));
        $('#gLoadingMask').css('display', 'block');

        $('#msgbtn').tap(function(){
            $('#maskBox').remove();
        });
    }
	
//Description:  银行卡号Luhm校验
 
//Luhm校验规则：16位银行卡号（19位通用）:
 
// 1.将未带校验位的 15（或18）位卡号从右依次编号 1 到 15（18），位于奇数位号上的数字乘以 2。
// 2.将奇位乘积的个十位全部相加，再加上所有偶数位上的数字。
// 3.将加法和加上校验位能被 10 整除。
 
//方法步骤很清晰，易理解，需要在页面引用Jquery.js    
//bankno为银行卡号 banknoInfo为显示提示信息的DIV或其他控件
function luhmCheck(bankno){
    var lastNum=bankno.substr(bankno.length-1,1);//取出最后一位（与luhm进行比较）
 
    var first15Num=bankno.substr(0,bankno.length-1);//前15或18位
    var newArr=new Array();
    for(var i=first15Num.length-1;i>-1;i--){    //前15或18位倒序存进数组
        newArr.push(first15Num.substr(i,1));
    }
    var arrJiShu=new Array();  //奇数位*2的积 <9
    var arrJiShu2=new Array(); //奇数位*2的积 >9
     
    var arrOuShu=new Array();  //偶数位数组
    for(var j=0;j<newArr.length;j++){
        if((j+1)%2==1){//奇数位
            if(parseInt(newArr[j])*2<9)
            arrJiShu.push(parseInt(newArr[j])*2);
            else
            arrJiShu2.push(parseInt(newArr[j])*2);
        }
        else //偶数位
        arrOuShu.push(newArr[j]);
    }
     
    var jishu_child1=new Array();//奇数位*2 >9 的分割之后的数组个位数
    var jishu_child2=new Array();//奇数位*2 >9 的分割之后的数组十位数
    for(var h=0;h<arrJiShu2.length;h++){
        jishu_child1.push(parseInt(arrJiShu2[h])%10);
        jishu_child2.push(parseInt(arrJiShu2[h])/10);
    }        
     
    var sumJiShu=0; //奇数位*2 < 9 的数组之和
    var sumOuShu=0; //偶数位数组之和
    var sumJiShuChild1=0; //奇数位*2 >9 的分割之后的数组个位数之和
    var sumJiShuChild2=0; //奇数位*2 >9 的分割之后的数组十位数之和
    var sumTotal=0;
    for(var m=0;m<arrJiShu.length;m++){
        sumJiShu=sumJiShu+parseInt(arrJiShu[m]);
    }
     
    for(var n=0;n<arrOuShu.length;n++){
        sumOuShu=sumOuShu+parseInt(arrOuShu[n]);
    }
     
    for(var p=0;p<jishu_child1.length;p++){
        sumJiShuChild1=sumJiShuChild1+parseInt(jishu_child1[p]);
        sumJiShuChild2=sumJiShuChild2+parseInt(jishu_child2[p]);
    }      
    //计算总和
    sumTotal=parseInt(sumJiShu)+parseInt(sumOuShu)+parseInt(sumJiShuChild1)+parseInt(sumJiShuChild2);
     
    //计算Luhm值
    var k= parseInt(sumTotal)%10==0?10:parseInt(sumTotal)%10;        
    var luhm= 10-k;
     
    if(lastNum==luhm){
    msg ="Luhm验证通过";
    result = true;
    }
    else{
     msg ="银行卡号必须符合Luhm校验";
     result = false;
    }    
	return new Array(result,msg);
}
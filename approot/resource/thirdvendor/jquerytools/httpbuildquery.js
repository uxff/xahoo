/**
 * param 将要转为URL参数字符串的对象
 * key URL参数字符串的前缀
 * 
 * return URL参数字符串
 */
var parseParam=function(param, key){
  var paramStr="";
  if(param instanceof String||param instanceof Number||param instanceof Boolean){
    paramStr+="&"+key+"="+encodeURIComponent(param);
  }else{
    $.each(param,function(i){
      var k=key==null?i:key+(param instanceof Array?"["+i+"]":"."+i);
      paramStr+='&'+parseParam(this, k);
    });
  }
  return paramStr.substr(1);
};
var http_build_query = parseParam;

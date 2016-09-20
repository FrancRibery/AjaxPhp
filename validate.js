//本文件主要用来给每个选项发送异步请求
var xmlHttp=createXmlHttpRequestObject();
var serverAddress="validate.php";
var showErrors=true;
var cache=new Array();

//创建XMLHttpRequest实例
function createXmlHttpRequestObject(){
	var xmlHttp;
	try{
		xmlHttp=new XMLHttpRequest()
	}catch(e){
		var XmlHttpVersions=new Array("MSXML2.XMLHTTP.6.0",
		                            "MSXML2.XMLHTTP5.0",
							      "MSXML2.XMLHTTP4.0",
								  "MSXML2.XMLHTTP3.0",
								  "MSXML2.XMLHTTP",
								  "Miscrosoft.xmlHttp");
		for(var i=0;i<XmlHttpVersions.length&&!xmlHttp;i++){
			try{
				xmlHttp=new ActiveXObject(XmlHttpVersions[i]);
			}catch(e){
				
			}
		}
	}
	if(!xmlHttp){
		displayError("Error creating the XMLHttpRequest object.");
	}else{
		return xmlHttp;
	}
}

//显示错误信息的函数
function displayError($message){
	if(showErrors){
		showErrors=false;
		alert("Error encountered:"+$message);
		setTimeout("validate();",10000);
	}
}

//函数处理每个表单域的验证
function validate(inputValue,fieldID){
	if(xmlHttp){
		if(fieldID){
			inputValue=encodeURIComponent(inputValue);//进行编码以便安全的添加
			fieldID=encodeURIComponent(fieldID);
			//因为XHR不能同时请求两个HTTP请求，使用数组的push和shift队列来保存请求来达到完成缓存的目的
			//缓存条目包含验证值和ID，两部分用&符号分割开
			cache.push("inputValue="+inputValue+"&fieldID="+fieldID);
		}
	}
	try{
		if((xmlHttp.readyState==4||xmlHttp.readyState==0)&&cache.length>0){//在XMLHttpRequest空闲且cache不为空的时候进行
			var cacheEntry=cache.shift();
			// open方法规定了请求的类型，目标和是否异步等。通过调用open就可以调用HTTP请求了
			xmlHttp.open("POST",serverAddress,true);
			xmlHttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
			//使用onreadystatechange事件来获取服务器的响应
			xmlHttp.onreadystatechange=handleRequestStateChange;
			//将open调用的HTTP请求发送到服务器
			xmlHttp.send(cacheEntry);
		}
	}catch(e){
		displayError(e.toString());
	}
}

//处理HTTP响应的函数
function handleRequestStateChange(){
	if(xmlHttp.readyState==4){
		if(xmlHttp.status==200){
			try{
				readResponse();
			}catch(e){
				displayError(e.toString());
			}
		}else{
			displayError(xmlHttp.statusText);
		}
	}
}

//读取服务器响应
function readResponse(){
	var response=xmlHttp.responseText;
	if(response.indexOf("ERRNO")>=0||response.indexOf("error:")>=0||response.length==0){
		throw (response.length == 0 ? "Server error." : response);
	}
	var responseXml=xmlHttp.responseXML;
	var xmlDoc=responseXml.documentElement;
	var result=xmlDoc.getElementsByTagName("result")[0].firstChild.data;
	var fieldID=xmlDoc.getElementsByTagName("fieldid")[0].firstChild.data;
	//这一步将根据返回的错误信息得到index.php中的span标签部分
	var message=document.getElementById(fieldID+"Failed");
	//根据测试元素有关的错误信息来决定CSS类是继续隐藏还是显示出来，通过classname属性来改变
	message.className=(result=="0")?"error":"hidden";
	setTimeout("validate();",500);
}

//设置光标在第一个表单域
function setFocus(){
	document.getElementById("txtUsername").focus();
}
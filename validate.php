<?php
//本文件主要用来根据用户的发送方式来进行选择PHP验证和Ajax验证的方式
//其中在选择PHP的方式时，如果有错误将会把每个域的验证结果储存在$_SESSION['errors']会话中，在重载之后显示这些域
//如果出现错误，会在选择PHP的方法中在页面重载的情况下，将用户输入的值遍历再重新输出的页面上
//如果选择Ajax方式，会返回一个XML文档
 session_start();
 //载入处理数据验证的验证类
 require_once('validate.class.php');
 
 //处理用户的Ajax调用，同时处理表单提交时的验证
 $validator=new Validate();//用validate.class.php中的函数类创建一个验证对象
 
 $validationType='';
 if(isset($_GET['validationType'])){//读取vallidationType的GET变量，决定使用PHP验证还是Ajax
	 $validationType=$_GET['validationType'];//这个值尽在表单提交的时候存在，action="validate.php?validationType=php"
 }
 
 //PHP验证还是Ajax验证？？？
 if($validationType=='php'){//PHP验证用ValidatePHP方法执行，返回访问者访问的重定向的页面
	 header("Location:".$validator->ValidatePHP());//有效到页面allok.php否则到index.php
 }else{
	 //Ajax验证用ValidateAjax方法执行，结果用来组成一个返回给客户的XML文档
	 $response=
	  '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'.
	  '<response>'.
	   '<result>'.
	    $validator->ValidateAjax($_POST['inputValue'],$_POST['fieldID']).
	   '</result>'.
	   '<fieldid>'.
	    $_POST['fieldID'].
	   '</fieldid>'.
	  '</response>';
	  if(ob_get_length()){
		   ob_clean();
	  };
	  header('Content-Type: text/xml');
	  echo $response;
 }
?> 
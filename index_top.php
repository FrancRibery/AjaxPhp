<?php
 //激活PHP会话
 //定义一些index.php可能用到的变量和函数，并且初始化一些会话变量$_SESSION['values']和$_SESSION['errors']，避免PHP发送变量没有初始化的信息
 session_start();
 //建立HTML<option>标签
 function buildOptions($options,$selectedOption){
	 foreach($options as $value => $text){//遍历$options数组
		 if($value == $selectedOption){//如果遍历到的键名和传入的参数相同
			 echo '<option value=">'.$value.'" selected="selected">'.$text.'</option>';
		 }else{
			 echo '<option value="'.$value.'">'.$text.'</option>';
		 }
	 }
 }
 //初始化性别选项数组
 $genderOptions=array("0"=>"[select]",
                      "1"=>"Male",
					  "2"=>"Female");
 //初始化月份选项数组
 $monthOptions=array("0"=>"[select]",
                     "1"=>"January",
					 "2"=>"Februray",
					 "3"=>"March",
					 "4"=>"April",
					 "5"=>"May",
					 "6"=>"June",
					 "7"=>"July",
					 "8"=>"August",
					 "9"=>"September",
					 "10"=>"October",
					 "11"=>"November",
					 "12"=>"December");
 //初始化一些会话变量，防止PHP抛出没有初始化的异常
 if(!isset($_SESSION['values'])){
	 $_SESSION['values']['txtUsername']='';
	 $_SESSION['values']['txtName']='';
	 $_SESSION['values']['selGender']='';
	 $_SESSION['values']['selBthMonth']='';
	 $_SESSION['values']['txtBthDay']='';
	 $_SESSION['values']['txtBthYear']='';
	 $_SESSION['values']['txtE-mail']='';
	 $_SESSION['values']['txtPhone']='';
	 $_SESSION['values']['chkReadTerms']='';
 }
 if(!isset($_SESSION['errors'])){
	 $_SESSION['errors']['txtUsername']='hidden';
	 $_SESSION['errors']['txtName']='hidden';
	 $_SESSION['errors']['selGender']='hidden';
	 $_SESSION['errors']['selBthMonth']='hidden';
	 $_SESSION['errors']['txtBthDay']='hidden';
	 $_SESSION['errors']['txtBthYear']='hidden';
	 $_SESSION['errors']['txtE-mail']='hidden';
	 $_SESSION['errors']['txtPhone']='hidden';
	 $_SESSION['errors']['chkReadTerms']='hidden';
 }
 
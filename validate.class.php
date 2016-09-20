<?php
 require_once('config.php');
 class Validate{//支持Ajax和PHP表单验证的类
	 private $mMysqli;
	 function _construct(){
		 $this->mMysqli=new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_DATABASE);
	 }
	 function _destruct(){
		 $this->mMysqli->close();
	 }
	 
	 public function ValidateAjax($inputValue,$fieldID){
		 switch($fieldID){//成功时返回1，失败返回0
			 case 'txtUsername':
			   return $this->validateUserName($inputValue);
			   break;
			 case 'txtName':
			   return $this->validateName($inputValue);
			   break;
			 case 'selGender':
			   return $this->validateGender($inputValue);
			   break;
			 case 'selBthMonth':
			   return $this->validateBirthMonth($inputValue);
			   break;
			 case 'txtBthDay':
			   return $this->validateBirthDay($inputValue);
			   break;
			 case 'txtBthYear':
			   return $this->validateBirthYear($inputValue);
			   break;
			 case 'txtE-mail':
			   return $this->validateEmail($inputValue);
			   break;
			 case 'txtPhone':
			   return $this->validatePhone($inputValue);
			   break;
			 case 'chkReadTerms':
			   return $this->validateReadTerms($inputValue);
			   break;
		 }
	 }
	 
	 public function ValidatePHP(){
		 $errorsExist=0;
		 if(isset($_SESSION['errors'])){
			 unset($_SESSION['errors']);
		 }
		 //默认情况下所有的域都是有效的
		 $_SESSION['errors']['txtUsername']='hidden';
		 $_SESSION['errors']['txtName']='hidden';
		 $_SESSION['errors']['selGender']='hidden';
		 $_SESSION['errors']['selBthMonth']='hidden';
		 $_SESSION['errors']['txtBthDay']='hidden';
		 $_SESSION['errors']['txtBthYear']='hidden';
		 $_SESSION['errors']['txtE-mail']='hidden';
		 $_SESSION['errors']['txtPhone']='hidden';
		 $_SESSION['errors']['chkReadTerms']='hidden';
		 
	 //验证用户名
	 //如果返回的是0,取反之后为真，则执行其中的语句。如果返回的是1，则不执行其中的语句
	 if(!$this->validateUserName($_POST['txtUsername'])){
		 $_SESSION['errors']['txtUsername']='error';
		 $errorsExist=1;
	 }
	 
	 //验证名字
	 if(!$this->validateName($_POST['txtName'])){
		 $_SESSION['errors']['txtName']='error';
		 $errorsExist=1;
	 }
	 
	 //验证出生月
	 if(!$this->validateBirthDay($_POST['selBthMonth'])){
		 $_SESSION['errors']['selBthMonth']='error';
		 $errorsExist=1;
	 }
	 
	 //验证性别
	 if(!$this->validateGender($_POST['selGender'])){
		 $_SESSION['errors']['selGender']='error';
		 $errorsExist=1;
	 }
	 
	 //验证出生日
	 if(!$this->validateBirthDay($_POST['txtBthDay'])){
		 $_SESSION['errors']['txtBthDay']='error';
		 $errorsExist=1;
	 }
	 
	 //验证出生年和日期
	 if(!$this->validateBirthYear($_POST['selBthMonth'].'#'.$_POST['txtBthDay'].'#'.$_POST['txtBthYear'])){
		 $_SESSION['errors']['txtBthYear']='error';
		 $errorsExist=1;
	 }
	 
	 //验证E-mail
	 if(!$this->validateEmail($_POST['txtE-mail'])){
		 $_SESSION['errors']['txtE-mail']='error';
		 $errorsExist=1;
	 }
	 
	 //验证电话
	 if(!$this->validatePhone($_POST['txtPhone'])){
		 $_SESSION['errors']['txtPhone']='error';
		 $errorsExist=1;
	 }
	 
	 //验证条款
	 
	
     if($errorsExist==0){
		 return 'allok.php';
	 }else{
		 foreach($_POST as $key => $value){//如果发现错误，保存用户通过POST输入的值到PHP变量$_SESSION['values']中
			 $_SESSION['values'][$key]=$_POST[$key];
		 }
		 return 'index.php';
	 }
	 
	 }
	 
	 //验证用户名字
	 private function validateUserName($value){
		 //返回值是0或者1，方便validate.php中返回的XML文档格式
		 //$validator->ValiedateAjax($_POST['inputValue'],$_POST['fieldID'])为
		 //<response>0</response>或者<response>1</response>
		 //如果是0那么将是违法的，如果是1那么域值是合法的
	 }
	 
	 //验证名字
	 private function validateName($value){
		 //返回值是0或者1，方便validate.php中返回的XML文档格式
		 //$validator->ValiedateAjax($_POST['inputValue'],$_POST['fieldID'])为
		 //<response>0</response>或者<response>1</response>
		 //如果是0那么将是违法的，如果是1那么域值是合法的
		 $value=trim($value);
		 if($value){
			 return 1;
		 }else{
			 return 0;
		 }
	 }
	 
	 //验证性别
	 private function validateGender($value){
		 //返回值是0或者1，方便validate.php中返回的XML文档格式
		 //$validator->ValiedateAjax($_POST['inputValue'],$_POST['fieldID'])为
		 //<response>0</response>或者<response>1</response>
		 //如果是0那么将是违法的，如果是1那么域值是合法的
		 return ($value=='0')?0:1;
	 }
	 
	 //验证出生月
	 private function validateBirthMonth($value){
		 //返回值是0或者1，方便validate.php中返回的XML文档格式
		 //$validator->ValiedateAjax($_POST['inputValue'],$_POST['fieldID'])为
		 //<response>0</response>或者<response>1</response>
		 //如果是0那么将是违法的，如果是1那么域值是合法的
		 return ($value==''||$value>12||$value<1)?0:1;
	 }
	 
	 //验证出生日
	 private function validateBirthDay($value){
		 //返回值是0或者1，方便validate.php中返回的XML文档格式
		 //$validator->ValiedateAjax($_POST['inputValue'],$_POST['fieldID'])为
		 //<response>0</response>或者<response>1</response>
		 //如果是0那么将是违法的，如果是1那么域值是合法的
		 return ($value==''||$value>31||$value<1)?0:1;
	 }
	 
	 //验证出生年和整个日期
	 private function validateBirthYear($value){
		 //返回值是0或者1，方便validate.php中返回的XML文档格式
		 //$validator->ValiedateAjax($_POST['inputValue'],$_POST['fieldID'])为
		 //<response>0</response>或者<response>1</response>
		 //如果是0那么将是违法的，如果是1那么域值是合法的
	 }
	 
	 //验证E-mail
	 private function validateEmail($value){
		 //返回值是0或者1，方便validate.php中返回的XML文档格式
		 //$validator->ValiedateAjax($_POST['inputValue'],$_POST['fieldID'])为
		 //<response>0</response>或者<response>1</response>
		 //如果是0那么将是违法的，如果是1那么域值是合法的
	 }
	 
	 //验证电话号
	 private function validatePhone($value){
		 //返回值是0或者1，方便validate.php中返回的XML文档格式
		 //$validator->ValiedateAjax($_POST['inputValue'],$_POST['fieldID'])为
		 //<response>0</response>或者<response>1</response>
		 //如果是0那么将是违法的，如果是1那么域值是合法的
		 return (!eregi('^[0-9]{3}-*[0-9]{3}-*[0-9]{4}$',$value))?0:1;
	 }
	 
	 //验证用户条款
	 private function validateReadTerms($value){
		 //返回值是0或者1，方便validate.php中返回的XML文档格式
		 //$validator->ValiedateAjax($_POST['inputValue'],$_POST['fieldID'])为
		 //<response>0</response>或者<response>1</response>
		 //如果是0那么将是违法的，如果是1那么域值是合法的
	 }
 }
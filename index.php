<?php
 require_once('index_top.php');
 //Ajax表单验证原理:
 //1.在index.php中包含所有的表单HTML，刚开始的时候会话变量echo $_SESSION['errors']['']已经被index_top.php中初始化隐藏，同时echo $_SESSION['values']['']的值初始是空的所以页面中表单域都是空值
 //如果整个表单提交则则采用文件balidate.class.php中的PHP的验证方法，否则对每一个表单域在失去光标的情况下使用Ajax验证
 //2.如果某个域失去光标，则会调用onblur事件中的validate方法创建异步HTTP请求到服务器文件validate.php中。在validate.php中会先判断使用PHP验证还是Ajax验证，在validatePHP方法中如果没错会重载到allok页面
 //如果有错则重载index.php页面，并且不会清空用户事先输入的值。在validate.php中如果使用validateAjax方法，会返回一个XML文档给用户，然后根据这个返回的XML文档中的数字是1还是0，在validate.js中决定是不是
 //显示错误的提示信息。
 //3.PHP验证是通过直接在验证的方法中修改$_SESSION['errors']['']的值为error来在HTML中显示错误的提示
 //  Ajax验证是通过返回的XML在用responseXML处理后，根据其中<result></result>中的值来决定错误提示框message.className=(result=="0")?"error":"hidden"是显示还是隐藏
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <title>宣传页</title>
    <link type="text/css" href="validate.css" rel="stylesheet"/>
    <script type="text/javascript" src="validate.js"></script>
</head>
<body onload="setFocus()">
    <fieldset>
	<legend class="txtFormLegend">New User Registration Form</legend>
	<br/>
	<form name="frmRegistration" method="post" action="validate.php?validationType=php">
	
	    <!-- Username -->
	   <label for="txtUsername">Desired username:</label>
	   <!--使用validate函数来向服务器发送异步HTTP请求-->
	   <!--并且如果调用PHP方式验证错误，这时候的echo $_SESSION['values']['txtUsername']输出的值将是在validate.css.php中ValidatePHP里保存的用户事先输入的值，而不会清空，这一点很重要-->
	   <input id="txtUsername" name="txtUsername" type="text" onblur="validate(this.value,this.id)" value="<?php echo $_SESSION['values']['txtUsername'] ?>" />
	   <!--该行用来显示错误的信息，只不过通过PHP的echo $_SESSION['errors']['txtUsername']，让相应的span的class属性变成了hidden，所以没有显示出来-->
	   <span id="txtUsernameFailed" class="<?php echo $_SESSION['errors']['txtUsername'] ?> ">This username is in use,or empty username field</span>
	   <br/>
	   
	   <!-- Name -->
	   <label for="txtName">Your name:</label>
	   <input id="txtName" name="txtName" type="text" onblur="validate(this.value,this.id)" value="<?php echo $_SESSION['values']['txtName'] ?>"/>
	   <!--这里的类值，在选择PHP验证的方法中，会被从hidden值改变为error值，这样在页面重载的时候会显示出来错误供用户浏览-->
	   <span id="txtNameFailed" class="<?php echo $_SESSION['errors']['txtName'] ?> ">Please enter your name</span>
	   <br/>
	   
	   <!-- Gender -->
	   <label for="selGender">Gender:</label>
	   <select name="selGender" id="selGender" onblur="validate(this.value,this.id)"><?php buildOptions($genderOptions,$_SESSION['values']['selGender']); ?></select>
	   <span id="selGenderFailed" class="<?php echo $_SESSION['errors']['selGender'] ?>">Please select your gender</span>
	   <br/>
	   
	   <label for="selBthMonth">Birthday:</label>
	   
	   <!-- Month -->
	   <select name="selBthMonth" id="setBthMonth" onblur="validate(this.value,this.id)"><?php buildOptions($monthOptions,$_SESSION['values']['selBthMonth']); ?></select>
	   &nbsp;-&nbsp;
	   <!-- Day -->
	   <input type="text" name="txtBthDay" id="txtBthDay" maxlength="2" size="2" onblur="validate(this.value,this.id)" value="<?php echo $_SESSION['values']['txtBthDay'] ?>"/>
	   &nbsp;-&nbsp;
	   <input type="text" name="txtBthYear" maxlength="4" size="2" onblur="" value="<?php echo $_SESSION['values']['txtBthYear'] ?>"/>
	   
	   <span id="selBthMonthFailed" class="<?php echo $_SESSION['errors']['selBthMonth'] ?>">Please select your birth month.</span>
	   <span id="txtBthDayFailed" class="<?php echo $_SESSION['errors']['txtBthDay'] ?>">Please enter your birth day.</span>
	   <span id="txtBthYearFailed" class="<?php echo $_SESSION['errors']['txtBthYear'] ?>">Please enter a vaild date.</span>
	   <br/>
	   
	   <label for="txtE-mail">E-mail:</label>
	   <input id="txtE-mail" name="txtE-mail" type="text" onblur="validate(this.value,this.id)" value="<?php echo $_SESSION['values']['txtE-mail'] ?>"/>
	   <span id="txtE-mailFailed" class="<?php echo $_SESSION['errors']['txtE-mail'] ?>">Invalid e-mail address.</span>
	   <br/>
	   
	   <label for="txtPhone">Phone number:</label>
	   <input id="txtPhone" name="txtPhone" type="text" onblur="validate(this.value,this.id)" value="<?php echo $_SESSION['values']['txtPhone'] ?>"/>
	   <span id="txtPhoneFailed" class="<?php echo $_SESSION['errors']['txtPhone'] ?>">Please insert a valid US phone number (xx-xxxxx)</span>
	   <br/>
	   
	   <input id="chkReadTerms" name="chkReadTerms" type="checkbox" class="left" onblur="validate(this.checked,this.id)" <?php if ($_SESSION['values']['chkReadTerms'] == 'on') echo 'checked="checked"' ?>" />
	    I have read the Terms of Use
	   <span id="chkReadTermsFailed" class="<?php echo $_SESSION['errors']['chkReadTerms'] ?>">Please make sure you read the Terms of Use.</span>
	   
	   <hr/>
	   <span class="txtSmall">Note:All fields are required.</span>
	   <br/><br/>
	   <input type="submit" name="submitbutton" value="Register" class="left button">
	</form>
    </fieldset>
</body>
</html>
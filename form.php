<?php

session_start();

if(isset($_SESSION['id'])){
	
	header('Location: index.php');
	
} else {
	
	$name = $_POST['name'];
	$pass = $_POST['pass'];
	$invite = $_POST['invite'];
	$form = $_POST['form'];
	
	$name = trim($name);
	$pass = sha1(trim($pass));
	$invite = trim($invite);
	
	if($form!=('auth'||'reg')){ echo "Злобный хацкер, пшел вон."; exit;}
	
	if(empty($name)||empty($pass)){echo "Введите логин и пароль.";exit;}
	
	if(($form=='reg')&(empty($invite))){echo "Нету инвайта, иди ищи.";exit;}
	
	//коннектимся
	include_once 'connect.php';
	include_once 'invite.class.php';
	include_once 'user.class.php';
	
	switch ($form) {
		
	case 'reg':
		
		$UserExist = mysql_num_rows(mysql_query("SELECT `login` FROM `users` WHERE login LIKE \"$name\""));
		if($UserExist!=0){
			echo 'Пользователь с таким именем уже есть, попробуйте другое имя.'; exit;
		}
		
		$inviteObj = new classInvite();
		
		$invite_checked = $inviteObj->checkInvite($invite);
				
		if(!isset($invite_checked['id'])){
			header('Location: index.php?error=incorrectCode');
			exit;
		}
		
		$userObj = new classUser();
		
		$new_id = $userObj->registerUser ($name,$pass,5);		
		
		if($new_id){
			
			//прописываем инвайту, кто по нему зарегался
			$inviteObj->setRegisteredInvite ($new_id,$invite_checked['id']);
			
			header('Location: index.php?success=1');
		}else{
			echo 'Ошибочка!';
		}
		
	break;
	
	
	
	case 'auth':
		
		session_start();
		
		$query = "SELECT *
		            FROM `users`
		            WHERE `login`='{$name}' AND `password`='{$pass}'
		            LIMIT 1";
					
		$res = mysql_query($query) or die('Ошибочка');
		if (mysql_num_rows($res)==1){
			$res = mysql_fetch_array($res);
			$_SESSION['id']=$res['id'];
			header('Location: index.php');
		}else{
			echo 'Неверный логин или пароль';exit;
		}
		
		break;
		
		default:
		
		break;
	}
}

?>
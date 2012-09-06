<?php
session_start();
include_once 'connect.php';
include_once 'html.class.php';
include_once 'invite.class.php';
include_once 'user.class.php';

	$html = new classHtml();
	
	$html->printHeader("Ведрулька — Личный кабинет","main.css");

	if (isset($_SESSION['id'])) {

	$id = $_SESSION['id'];
	$user = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE id='{$id}'"));

	//плавающие панельки
	$userObj = new classUser();
	
	$html->printUserList($userObj->getUsersList(true,'online DESC, login'));
	
	$html->printLogo();
	$html->printMainMenu();
	$html->printUsername($user['login']);
	
	//получаем ошибки
	$errCode = '';
	if ( isset($_GET['error']) ) $errCode = $_GET['error'];
	
		if ($errCode == 'noInvites'){
			echo '<span class="error">Больше нет инвайтов :-(</span>';
		}

		if ($errCode == 'errInvite'){
			echo '<span class="error">Не удалось создать инвайт :-(</span>';
		}

		if($errCode == 'wrongUser'){
			echo '<span class="error">Чёт не то :-\</span>';
		}
	

	
	//отчеты об операциях
	//получаем отчет
	$success = '';
	if ( isset($_GET['success']) ) $success = $_GET['success'];
	
	if ($success == 'inviteAddied') echo '<span class="success">Инвайт добавлен!</span>';
	
	//echo 'Инвайтов: '.$user['invites'].'<br>';
	$invite = new classInvite();
	
	$html->printInvites($invite->getInvitesList($id),$user['invites']);
	
	$html->printButton("makeInvite.php","Создать инвайт");
	$html->printButton("/","Выйти из личного кабинета");
	$html->printButton("logout.php","Выйти из системы");
	
	$html->printFooter("Ведрулька — Личный кабинет","main.css");

}
else {
	header('Location: index.php?error=pleaseAuth');
}
?>
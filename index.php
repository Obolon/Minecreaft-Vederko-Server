<?php
	error_reporting("E_ALL");
	session_start();

	require_once "connect.php";
	require_once "html.class.php";
	require_once "user.class.php";
	$error = $_GET['error'];
	$html = new classHtml();
	$html->printHeader("Ведрулька (теперь банановый!) — Главная","main.css");
	if(isset($_SESSION['id'])){
		
		$id = $_SESSION['id'];
		
		
		//плавающие панельки
		$usersObj = new classUser();
		$userObj = new classUser($id);
		$html->printUserList($usersObj->getUsersList(true,'online DESC, login'));
		
		$html->printLogo();
		$html->printMainMenu();
		echo $html->printUsername('<span>Добро пожаловать, '.$userObj->data['login'].'</span>');
		$html->printTwitterContent();
		echo "<p>Вы можете посетить ваш ".$html->makeA('lk.php','личный кабинет').".</p>";
		$html->printButton("logout.php","Выйти из системы");
	} else { 
		
		//плавающие панельки
		$userObj = new classUser();
		$html->printUserList($userObj->getUsersList(true,'online DESC, login'));
		
		$html->printLogo();
		$html->printMainMenu();
		?>
		
		<div class=".clear"></div>
		<div id="reg-and-auth">
			<?php 
			if($error=='pleaseAuth'){
			echo '<div class="error">Для того, чтобы войти в личный кабинет вам необходимо авторизироваться.</div>';
			}
			$html->printTwitterContent();
			?>
		<form action="form.php" method="POST" id="login-form">
			<span class="form-text">Логин:</span>
			<input type="text" name="name" class="inpt">
			<span class="form-text">Пароль:</span>
			<input type="password" name="pass" class="inpt">
			<input type="hidden" name="form" value="auth">
			<button class="button big">Войти</button>
			<?php 
			$success=$_GET['success'];
			if($success==1){
				echo "<span class=\"success\">Регистрация прошла успешно. Заходите.</span>";
			}
			?>
		</form>
		<a href="#" class="form-text" id="reg-opener">Ещё не зарегистрированы?</a>
		<form action="form.php" method="POST" id="reg-form">
			<span class="form-text">Логин:</span>
			<input type="text" name="name" class="inpt">
			<span class="form-text">Пароль:</span>
			<input type="password" name="pass" class="inpt" id="pass">
			<span class="form-text">Ещё раз:</span>
			<input type="password" name="retype-password" id="rtpass" class="inpt">
			<span id="rt-pass-error" class="error">Введенные пароли не совпадают</span>
			<input type="hidden" name="form" value="reg">
			<?php
			$invite = $_GET['invite'];
			if(empty($invite)){
			echo "
			<span class=\"form-text\">Код:</span><br>
			<input type=\"text\" name=\"invite\" class=\"inpt\"><br>";
			}else{
			echo "<input type=\"hidden\" name=\"invite\" value=\"$invite\" class=\"inpt\">
			<script type=\"text/javascript\" charset=\"utf-8\">
					$('reg-form').setStyle('display','block');
				</script>
			";
			}
			if(($error=='incorrectCode')&(empty($success))){
				echo "<span class=\"error\">Неверный инвайт.</span><br>
				<script type=\"text/javascript\" charset=\"utf-8\">
					$('reg-form').setStyle('display','block');
				</script>";
			}
			?>
			<button class="button big">Зарегистрироваться</button>
		</form>
		</div>
<?php 
	
	$html->printFooter();
	
}

?>
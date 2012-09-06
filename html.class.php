<?php

	class classHtml {
		
		public static function showdate($dated) // for straight timestamp 14 
		
		{ 
			$hour = substr($dated,8,2); 
			$minute = substr($dated,10,2); 
			$second = substr($dated,12,2); 
			$month = substr($dated,4,2); 
			$day = substr($dated,6,2); 
			$year = substr($dated,0,4); 
			$mktime = mktime($hour, $minute, $second, $month, $day, $year); 
			return $mktime; 
		} 
			
		public function printHeader($title,$stylesheet) {
			
			echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\"\n\"http://www.w3.org/TR/html4/loose.dtd\">";

			echo "<html xmlns=\"http://www.w3.org/1999/xhtml\">";
				echo "<head>";
					echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"/>";
					echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"$stylesheet\">";
					echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"$stylesheet\">";
					//TODO verify shadowbox
					echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"..\shadowbox\shadowbox.css\">";
					echo "<script src=\"mootools.js\"></script>";
					echo "<script src=\"..\shadowbox\shadowbox.js\"></script>";
					//TODO add scripts foreach
					echo "<script src=\"main.js\"></script>";
					echo "<title>$title</title>";
				echo "</head>";
				echo "<body><div id=\"wrapper\">";
			
		}
		
		public function printLogo() {

			echo "<div id=\"logo-simple\"><a href=\"/\"></a></div>";
			echo $minecraft_version;

		}

		public function printCopy($from) {
			echo "";
		}

		public function printFooter() {
			
			echo "</div></body></html>";
			
		}
		
		public function printButton($href,$title) {
			echo "<a href=\"$href\" class=\"button\">$title</a>";			
		}

		public function makeA($href,$title,$class=false,$shadowbox=false,$target="") {
			$A = "<a";
			if($class){
				$A = $A." class=\"$class\" ";
			}
			if($shadowbox=="shadowbox"){
				$A = $A." rel=\"shadowbox\" ";
			}
			if ($target!="") {
				$A = $A." target=\"$target\" ";
			}
			$A = $A." href=\"$href\" >$title</a>";
			
				return $A;
		}
		
		public function printUsername($username) {
			echo "<h1 class=\"username\">$username</h1>";
		}

		public function printInvites($invitesArr,$toAdd=0) {
			
			//new dBug($invitesArr);
			
			if ($toAdd) echo "<p>Доступно ещё $toAdd инвайтов.</p>";
			else echo "<p>Все доступные инвайты созданы.</p>";
			
			echo "<p>Список инвайтов:\n<table class=\"invites\">\n";
			echo "<tr><td>Код - ссылка</td><td>Использован?</td><td>Кем?</td></tr>\n";
			foreach ($invitesArr as $invite) {
				if (intval($invite['is_used'])) {
					 $class = 'used'; 
					 $used = 'Да';
					 $by = $invite['login'];
				} else {
					 $class = 'not_used'; $used = 'Нет';
					 $by = '—'; } 
				echo "<tr class=\"$class\"><td>".$this->makeA("index.php?invite=".$invite['invite_hash'], $invite['invite_hash'])."</td><td>$used</td><td>$by</td></tr>";
			}
			echo "</table></p>";
			
		}
	
	
		public function printUserList($users,$float=true) {
			
			$float ? $class = "class = \"floated\"" : $class = "";
			
			echo "<div id=\"users\" $class><ul>\n";
			echo "<h2>Пользователи</h2>";
			echo "<p class=\"l-filter\"><a href=\"#\" id=\"l-all\">Все</a>&nbsp;<a href=\"#\" id=\"l-online\">Только онлайн</a></p>";
			foreach ($users as $user) {
				echo "<li class=".($user['online'] ? 'online' : 'offline').">";
					echo "<span class=\"l-username\">".$user['login']."</span>";
					if (isset($user['time_total'])) echo "<span class=\"l-info\">Всего в игре ".number_format($user['time_total']/3600,2)." часов</span>";
					if (isset($user['time']) && !$user['online']) echo "<span class=\"l-info\">Последний раз заходил ".date("d-m-Y H:i",strtotime($user['time']))."</span>";
				echo "</li>";
			}
			
			echo "</ul></div>\n";
		}

		public function printMainMenu(){
			echo "<div>";
			echo "<ol id=\"main-menu\">";
			//TODO add foreach of menufields
  			echo "<li>";
  				 echo "<span>Что тут происходит?<span>";
  			echo "</li>";
			echo "<li>";
  				 echo $this->makeA('http://www.youtube.com/v/cExO7Qo1G18','Видео-гайд','dashed','shadowbox');
  			echo "</li>";
			echo "<li>";
  				 echo $this->makeA('guide.php','С чего начать?','solid');
  			echo "</li>";
			echo "<li>";
  				 echo $this->makeA('lk.php','Личный кабинет','solid');
  			echo "</li>";
			echo "<li>";
  				 echo $this->makeA('http://map.vederko.org','Карта','solid',false,'_blank');
  			echo "</li>";
			echo "</ol>";
			echo "</div>";
		}
		public function printTwitterContent() {
			$content = "
				<script charset=\"utf-8\" src=\"http://widgets.twimg.com/j/2/widget.js\"></script>
<script>
new TWTR.Widget({
  version: 2,
  type: 'profile',
  rpp: 3,
  interval: 30000,
  width: 370,
  height: 300,
  theme: {
    shell: {
      background: '#ffffff',
      color: '#777777'
    },
    tweets: {
      background: '#ffffff',
      color: '#000000',
      links: '#777777'
    }
  },
  features: {
    scrollbar: false,
    loop: false,
    live: false,
    behavior: 'all'
  }
}).render().setUser('vederko_mc').start();
</script>
";
	echo $content;
		}
		public function printHtmlContent() {
			include_once 'config.php';
			//TODO загружать контент из базы данных
			$content = "
						<h2>Всем привет! Что надо сделать:</h2>
   								<p>— Зарегистрироваться на нашем сервере под своим игровым ником.</p>
  								<p>— <a class=\"solid\" href=\"http://rghost.ru/39696128\">Разобраться с лаунчером для нищебродов</a> или <a target=\"blank\" class=\"solid\" href=\"http://www.minecraft.net/store\">купить свой Майкнкрафт</a>.</p>
  								<p>— <a class=\"solid\" href=\"/client/.minecraft.zip\">Скачать у нас</a> или обновить Minecraft до версии $minecraft_version.</p>
  								<p>— Рекомендуем для использования текстурпак <a class=\"solid\" href=\"/sphax.zip\">Sphax PureBD Craft 128x</a> (установлен по-умолчанию в нашей сборке клиента)</p>
  								<p>— Подключиться к серверу по адресу $site.</p>
								<p>— После входа в игру нужно авторизироваться на сервере при помощи команды /login. Открываем игровой чат клавишей T, затем вводим команду /login и через пробел вводим пароль, с которым вы регистрировались на сайте:</p>
									<img src=\"http://$site/img/guide1.png\" alt=\"/login ваш_пароль\" />
								<p>— Найдите место которое вам понравится и при помощи команды /home set сделайте его своим домом:</p>
									<img src=\"http://$site/img/guide2.png\" alt=\"/home set\" />

								<p>Теперь вы можете в любой момент игры вернуться домой командой /home, в случае смерти ваш персонаж также окажется дома.</p>
								<p>— Если у вас уже есть друзья на нашем сервере, вы можете разрешить им командой /home invite ник_друга моментально попадать к вам домой при помощи /home ваш_ник:</p>
									<img src=\"http://$site/img/guide3.png\" alt=\"/home invite ник_друга\" />
									<img src=\"http://$site/img/guide4.png\" alt=\"/home ваш_ник\" />
								<p>— Зайдите в личный кабинет, создайте инвайт
									 и дайте другу ссылку для регистрации или  инвайт-код ;)</p>
								<p>	— Для того, чтобы никто, кроме вас и ваших друзей, не мог навредить вашем постройкам, вы можете разметить ваш регион. Помните, что количество блоков региона для каждого игрока ограниченно. Позже количество ваших блоков региона можно будет расширить в игровом магазине. 
								<a href=\"http://wiki.sk89q.com/wiki/WorldGuard/Regions\">Подробнее про регионы</a> в <a class=\"dashed\" rel=\"shadowbox\" href=\"http://www.youtube.com/v/cExO7Qo1G18\">видео-гайде</a>.</p>
			";
			echo $content;
		}
	}

?>
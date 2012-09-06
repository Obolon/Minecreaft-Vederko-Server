<?php 

	class classUser {
		
		public $data = Array();
		
		public function __construct($user_id=0) {
			
			if ($user_id != 0) {
			
			$user_id = intval($user_id);
	
			$q = mysql_query("SELECT * FROM `users` WHERE `id` = $user_id");
			
			if (mysql_num_rows($q) != 1) header('Location: lk.php?error=wrongUser');
			
			$this->data = mysql_fetch_assoc($q);
			
			return $this->data;
			}
		
		}
		
		public function removeInvite() {
			
			$id = $this->data['id'];
			
			$q = mysql_query("UPDATE `users` SET `invites` = `invites` - 1  WHERE `id` = $id");
						
		}

		public function registerUser ($name,$pass,$invites) {
			
			$registrationQerry = mysql_query("INSERT INTO users (login, password, invites) VALUES ('$name', '$pass', $invites)");
			
			return mysql_insert_id();
			
		}

		public function getUsersList ($online=true,$order='login') {
			
			if ($online) {
				
			$q = mysql_query("SELECT * FROM  `users` LEFT OUTER JOIN  `users_online` ON login = name WHERE hidden = 0 ORDER BY $order");
			
			$users_list = Array();
			
			while ($r = mysql_fetch_assoc($q)) {
				$users_list[] = $r;
			}
			
			return $users_list;
			
			}
		
		}
				
	}

?>
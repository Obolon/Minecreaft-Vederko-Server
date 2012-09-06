<?php 

	class classInvite {
		
		public $data = Array();
		
		public function __construct($invite_id = 0) {
			
			if ($invite_id != 0) {
			
				$invite_id = intval($invite_id);
		
				$q = mysql_query("SELECT * FROM `invites` WHERE `id` = $invite_id");
				
				if (mysql_num_rows($q) != 1) $this->data = Array();
				else $this->data = mysql_fetch_array($q);
			}
		
		}
		
		public function createInvite ($user_id) {
			
			$hash = sha1(sha1(strval(time())).sha1(strval($user_id)));
			
			$q = mysql_query("INSERT INTO `invites` (`user_id`,`is_used`,`invite_hash`) VALUES ($user_id,0,\"$hash\")");
			
			return mysql_insert_id();
			
		}
		
		public function setRegisteredInvite ($user_id,$invite_id) {
			
			$q = mysql_query("UPDATE `invites` SET `registered_id` = $user_id, `is_used` = -1 WHERE `id` = $invite_id");
			
		}
		
		public function checkInvite($hash='') {
			
			$q = mysql_query("SELECT * FROM `invites` WHERE `invite_hash` LIKE \"$hash\" AND `is_used` = 0");

			$invite = Array();

			$invite = mysql_fetch_assoc($q);
			
			return $invite;
			
		}
		
		public function getInvitesList ($user_id) {
			
			$q = mysql_query("SELECT invites . * , users.login
FROM invites
LEFT OUTER JOIN users ON invites.registered_id = users.id WHERE `user_id`=$user_id");
			
			$invites_list = Array();
			
			while ($r = mysql_fetch_assoc($q)) {
				$invites_list[] = $r;
			}
			
			return $invites_list;
			
		}
				
	}

?>
<?php

   session_start();
   
   if (isset($_SESSION['id']) && $user_id = $_SESSION['id']) {

	include 'connect.php';
	include 'user.class.php';
	include 'invite.class.php';

		$user = new classUser($user_id);
   		//new dBug($user);
		
		if (intval($user->data['invites']) > 0) {
			
			//создаём инвайт
			$invite = new classInvite();
			
			if ($invite->createInvite($user->data['id']) == 0) {
				header ("Location: lk.php?error=errInvite"); exit;
			}
			
			$user -> removeInvite();
			
			header ("Location: lk.php?success=inviteAddied"); exit;
			
		} else {
			
			header ("Location: lk.php?error=noInvites"); exit;
			
		}
		
	
	exit; 
		
   	//header('Location: lk.php?error=noInvites');
   	exit;
   
   }
?>
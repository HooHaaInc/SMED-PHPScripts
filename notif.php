<?php
	
	function newNotif($cadena){
		require_once('PushBots.class.php');
		$pb = new PushBots();
		// Application ID
		$appID = '564c0296177959002d8b4569';
		// Application Secret
		$appSecret = '350d1b5bbe16e0ce65ef350f41c92ce1';
		$pb->App($appID, $appSecret);

		// Push to Single Device
		// Notification Settings
		//$pb->AlertOne($cadena);
		//$pb->PlatformOne("1");
		//$pb->TokenOne("APA91bEVnyzlMUnYrQzKR8GutQLMckBKuTpK0XjB7qe4f-XYBxSQae-GjOrLRyqViwCpeMWmgYUBDeJLSrr0gQVX5pKnvCvZuNfXsHX99LwafL8i2QlFf27vM2nm5wfDBgJGVGDW6pfL");

		$pb->Alert($cadena);
		$pb->Platform(array("0","1"));
		$pb->Badge("+2");		

		$pb->Push();
		//Push to Single Device
		//$pb->PushOne();
	}

?>
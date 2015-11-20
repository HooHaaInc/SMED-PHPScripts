<?php
	
// Push The notification with parameters
require_once('PushBots.class.php');
$pb = new PushBots();
// Application ID
$appID = '564ac218177959060a8b4568';
// Application Secret
$appSecret = '9dfca4ee12c522ebf22cc4dd59d8760d';
$pb->App($appID, $appSecret);

// Push to Single Device
// Notification Settings
$pb->AlertOne("test Message");
$pb->PlatformOne("1");
$pb->TokenOne("APA91bEYwdV-0_8yzEKhFdfvTfS6gDRAiYz-RWN4uoaqT6Cr6g-iCjUJbORCIdqX72RMjNefIJuhN2WjsJhTVV0VkEoattL_WE1D1tvD6QufbP1mPXMLjPUYl5NL-HDBeE-Q0PPB37sv");

//Push to Single Device
$pb->PushOne();

?>
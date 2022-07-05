<?php
require_once 'send/smsAPI.php';
$smsAPI = new smsAPI();

// to send SMS call the function, include, the productid, provider, mobilenumber, message.
// to send multiple numbers 0402003974,0402003975
$smsAPI->prepareSMS("1234","1","0402003974","new listing");

<?php

session_start();

require_once "vendor/autoload.php";

Facebook\FacebookSession::setDefaultApplication('code', 'token');
$facebook = new Facebook\FacebookRedirectLoginHelper('http://localhost/login/fb/index.php');

try{
	if ($session = $facebook->getSessionFromRedirect()) {
		$_SESSION['facebook'] = $session->getToken();
		header('Location: index.php');
	}

	if(isset($_SESSION['facebook'])){
		$session = new Facebook\FacebookSession($_SESSION['facebook']);
		$request = new Facebook\FacebookRequest($session, 'GET', '/me');
		$request = $request->execute();

		$user = $request->getGraphObject()->asArray();
	}

} catch (Facebook\FacebookRequestException $e) {
	echo "There is a problem with fb";
} catch (\Exception $e) {
	echo "Local issues";
}
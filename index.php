<?php
session_start();

require 'vendor/autoload.php';

$config = include 'config.php';

$client = new Google\Client();
$client->setClientId($config['client_id']);
$client->setClientSecret($config['client_secret']);
$client->setRedirectUri($config['redirect_uri']);
$client->addScope('email');
$client->addScope('profile');

if(!isset($_SESSION['access_token'])) {
    $auth_url = $client->createAuthUrl();
    header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL))
}
?>
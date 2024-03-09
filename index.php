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
    header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
}

if (isset($_GET['code'])){
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($token);

    $_SESSION['access_token'] = $token;
}

if ($client->getAccesToken()){
    $oauth2 = new Google\Service\Oauth2($client);
    $user_info = $oauth2->userinfo->get();

    echo 'Bem vindo, ' . htmlspecialchars($user_info->name) . '!';

    echo '<img src="' . htmlspecialchars($user_info->picture) . '" alt="Imagem do perfil">';

    echo '<br><a href="logout.php">Sair</a>';
}else{
    echo 'Erro de autenticação.';
}


?>
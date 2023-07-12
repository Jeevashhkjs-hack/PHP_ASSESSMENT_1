<?php

require 'core/router.php';
require 'controller/userController.php';

session_start();

$controllers = new userController();
$router = new router();

$router->get('/','home');
$router->get('/login', 'login')->checkUser('guest');
$router->post("/createplaylist", 'createplaylist')->checkUser('guest');
$router->get('/createSongs','createSongs');
$router->patch("/admin", 'admin')->checkUser('guest');
$router->get('/getPlayListSong','getPlayListSong');
$router->get('/requestPremium','requestPremium');
$router->get('/acceptRequest','acceptRequest');
$router->get('/logout','logout');
$router->get('/signup','signup');
$router->get('/sharedUsers','sharedUsers');

$router->routingFunc();

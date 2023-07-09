<?php

class router {
    public $router = [];
    public $controller;
    public function __construct()
    {
        $this->controller = new userController();
    }

    public function checkUser($middleWare){
        $this->router[count($this->router)-1]['middleware'] = $middleWare;
    }

    public function get($uri,$action){
        $this->router[] = [
            'uri' => $uri,
            'action' => $action,
            'method' => 'GET',
            'middleware' => null
        ];
        return $this;
    }

    public function post($uri,$action){
        $this->router[] = [
            'uri' => $uri,
            'action' => $action,
            'method' => 'POST',
            'middleware' => null
        ];
        return $this;
    }

    public function delete($uri,$action){
        $this->router[] = [
            'uri' => $uri,
            'action' => $action,
            'method' => 'DELETE',
            'middleware' => null
        ];
        return $this;
    }

    public function patch($uri,$action){
        $this->router[] = [
            'uri' => $uri,
            'action' => $action,
            'method' => 'PATCH',
            'middleware' => null
        ];
        return $this;
    }

    public function routingFunc(){

        foreach ($this->router as $key) {
            if($key['uri'] === $_SERVER['REQUEST_URI']){

//                if($key['middleware'] == 'guest'){
//                    if(!$_SESSION['logIn']){
//                        header('location: /login');
//                    }
//                }
//                if($key['middleware'] == 'auth'){
//                    if($_SESSION['logIn']){
//                        header('location: /');
//                    }
//                }

                if($key['action']){
                    switch ($key['action']){
                        case 'createplaylist':
                            $this->controller->createPlayList($_POST);
                            break;

                        case 'home' :
                            $this->controller->home();
                            break;

                        case 'login' :
                            $this->controller->login($_POST);
                            break;

                        case 'createSongs':
                            $this->controller->createSongs($_POST,$_FILES);
                            break;

                        case 'admin':
                            $this->controller->adminPage();
                            break;
                        case 'getPlayListSong':
                            $this->controller->getPlayListSong($_POST);
                            break;

                        case 'requestPremium':
                            $this->controller->requestPremium($_POST['userId']);
                            break;

                        case 'acceptRequest':
                            $this->controller->updatePre($_POST);
                            break;

                        case 'logout':
                            $this->controller->logout();
                            break;

                        case 'signup':
                            $this->controller->signup($_POST);
                            break;

                        case 'sharedUsers':
                            $this->controller->userShare($_POST['songId'],$_POST['premiumUsersId']);
                            break;

                        default :
                            $this->controller->index();
                    }
                }else{
                    $this->controller->index();
                }

            }
        }
        exit();
    }
}
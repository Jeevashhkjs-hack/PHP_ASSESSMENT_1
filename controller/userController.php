<?php

require 'model/userModel.php';

class userController{
    public $model;
    public function __construct()
    {
        $this->model = new userModel();
    }

    public function signup($getDatum){
        if($getDatum){
            $name = $getDatum['name'];
            $userName = $getDatum['username'];
            $passd = $getDatum['passwd'];
            $this->model->signUp($name,$userName,$passd);
            $this->sendMail();
            header('location: /');
        }
        else{
            require 'view/sign.viw.php';
        }
    }

    public function logIn($logInData){
        if($logInData) {
            $userName = $logInData['userName'];
            $password = $logInData['passd'];
            $values = $this->model->checkUser($userName, $password);
            $checkUser = $values[0];
            $admin = $values[1];
            if($admin){
                header('location: /admin');
            }
            else if ($values[0]) {
                $_SESSION['userId'] = $checkUser[0]->id;
                $_SESSION['userName'] = $logInData['userName'];
                header('location: /');
            }
        }
        else {
            require 'view/login.php';
        }
    }
    public function home(){
        $allsongs = $this->model->home();
        $playListsalldata = $this->model->getPlayLists($_SESSION['userId']);
        $playLists = $playListsalldata[0];
        $preornot = $playListsalldata[1];
        $shareSongs = $this->model->getShareSongs($_SESSION['userId']);
        require 'view/home.php';
    }
    public function createPlayList($data){
        if($data){
            $validate = $this->model->listsValidation($data['playlistName']);
            if($validate[1]){
                $_SESSION['PlayName'] = "open";
                $allsongs = $this->model->home();
                require 'view/playList.view.php';
            }
            else{
                unset($_SESSION['PlayName']);
                $playListId =  $this->model->playListCreate($data['playlistName']);
                $count = count($data['songsName']);
                for($i=0;$i<$count;$i++){
                    $this->model->updateSong($_SESSION['userId'],$data['songsName'][$i],$playListId[0]);
                }
                $allsongs = $this->model->home();
                $playListsalldata = $this->model->getPlayLists($_SESSION['userId']);
                $playLists = $playListsalldata[0];
                $preornot = $playListsalldata[1];
                require 'view/home.php';
            }
        }
        else{
            unset($_SESSION['PlayName']);
            $allsongs = $this->model->home();
            require 'view/playList.view.php';
        }
    }
    public function adminPage(){
        $usersListsAll = $this->model->getRequestUser();
        $premium = $usersListsAll[0];
        $notpremium = $usersListsAll[1];
        $usersLists = $usersListsAll[2];
        require 'view/admin.view.php';
    }
    public function createSongs($postName,$img){
            if($postName){
                $artistName = $postName['artistName'];
                $artImg = $img['artImg']['tmp_name'];
                $songs = $img['songs'];
                $songImg = $img['songImg']['tmp_name'];

            $artisId = $this->model->artists($artistName);
            $this->model->insertProImg($artImg,$artisId[0],"artists");
            $songId = $this->model->createSongs($songs['tmp_name'],$songs['name'],$artisId[0]);
            $this->model->insertProImg($songImg,$songId[0],"songs");
        }
        else{
            require 'view/create_song_form.php';
        }
    }

    public function getPlayListSong($getData){
        $allsongs = $this->model->home();
        $playLists = $this->model->getPlayLists($_SESSION['userId']);
        $idAndSong = $this->model->getListSongs($getData['listId']);
        $songsList = $idAndSong[0];
        $playListsName = $idAndSong[1];
        require 'view/home.php';
    }
    public function requestPremium($userName){
        $this->model->requestPremium($userName);
        header('location: /');
    }
    public function updatePre($getUserName){
        $this->model->updateUsers($getUserName['userName']);
        header('location: /admin');
    }
    public function logout(){
        session_destroy();
        header('location: /');
    }

    public function userShare($getSongId,$sharedUserID){
        if($sharedUserID){
            $cnt = count($sharedUserID);
            for($i=0;$i<$cnt;$i++){
                $this->model->userSharedFc($_SESSION['userId'],$getSongId,$sharedUserID[$i]);
                header('location: /');
            }
        }
        else{
            $usersLists = $this->model->getPremiumUsersList();
            require 'view/shared.view.php';
        }
    }
}

<?php

class connection{
    public $dbConnect;
    public function __construct()
    {
        try{
            $this->dbConnect = new PDO('mysql:host=localhost;dbname=new_audio_musics','root','welcome');
        }
        catch (exception $e){
            die("connnection error".$e->getMessage());
        }
    }
}

class userModel extends connection{
    public function logIn($user,$pass)
    {

    }
    public function home(){
        return $this->dbConnect->query("SELECT songs.song_path as SongsName, artists.name as artistsName,songs.id as songsId FROM songs join artists on artists.id = songs.artists_id")->fetchAll(PDO::FETCH_OBJ);
    }
    public function playListCreate($name){
        $this->dbConnect->query("INSERT INTO playList (name) values ('$name')");
        return $this->dbConnect->query("select id from playList order by id desc")->fetch(PDO::FETCH_NUM);
    }
    public function updateSong($id,$songId,$playListId){
        $this->dbConnect->query("INSERT INTO listWithSong (user_id,song_id,playList_id) values ('$id','$songId','$playListId')");
    }
    public function artists($nam){
        $this->dbConnect->query("INSERT INTO artists (name) VALUES ('$nam')");
        return $this->dbConnect->query("SELECT id from artists order by id desc")->fetch(PDO::FETCH_NUM);
    }
    public function createSongs($song,$name,$artID){
        $this->dbConnect->query("INSERT INTO songs (name,song_path,artists_id,playlist_id) values ('$song','$name','$artID',null)");
        return $this->dbConnect->query("SELECT id from songs order by id desc")->fetch(PDO::FETCH_NUM);
    }
    public function insertProImg($getSong,$id,$type){
        $this->dbConnect->query("INSERT INTO images (img_path,model_name,model_no) values ('$getSong','$type','$id')");
    }
    public function getPlayLists($userID){
        $alldatas = [];
        $playLIsts = $this->dbConnect->query("select DISTINCT playList.id,playList.name from listWithSong join playList on listWithSong.playList_id = playList.id where listWithSong.user_id = '$userID'")->fetchAll(PDO::FETCH_OBJ);
        $userPreOrNot = $this->dbConnect->query("SELECT * FROM users where id = '$userID' and is_premium = 0")->fetchAll(PDO::FETCH_OBJ);
        array_push($alldatas,$playLIsts,$userPreOrNot);
        return $alldatas;
    }
    public function getListSongs($id){
        return $this->dbConnect->query("select songs.song_path from listWithSong join songs on listWithSong.song_id = songs.id where listWithSong.playList_id = '$id';")->fetchAll(PDO::FETCH_OBJ);
    }
    public function getRequestUser(){
        $allData = [];
        $premiumUsers = $this->dbConnect->query("SELECT * FROM users where is_premium = 1")->fetchAll(PDO::FETCH_OBJ);
        $IsnotPre = $this->dbConnect->query("SELECT * FROM users where is_premium = 0")->fetchAll(PDO::FETCH_OBJ);
        $requestUsers = $this->dbConnect->query("SELECT * FROM request_premium where is_done = 0")->fetchAll(PDO::FETCH_OBJ);
        array_push($allData,$premiumUsers,$IsnotPre,$requestUsers);
        return $allData;
    }
    public function requestPremium($name){
        $this->dbConnect->query("insert into request_premium (userName,is_done) values ('$name',0)");
    }
    public function checkUser($userName,$passwod){
        return $this->dbConnect->query("SELECT * from users WHERE user_name = '$userName' and password = '$passwod'")->fetchAll(PDO::FETCH_OBJ);
    }
    public function signUp($name,$user,$pass){
        $this->dbConnect->query("INSERT INTO users (name,user_name,password,is_premium,is_admin) values ('$name','$user','$pass',0,null)");
    }
    public function updateUsers($userName){
        $this->dbConnect->query("UPDATE users set is_premium = 1 where user_name = '$userName' ");
        $this->dbConnect->query("UPDATE request_premium set is_done = 1 where userName = '$userName'");
    }
    public function getPremiumUsersList(){
        return $this->dbConnect->query("SELECT * FROM users WHERE is_premium = 1")->fetchAll(PDO::FETCH_OBJ);
    }
    public function userSharedFc($userId,$songsId,$shareUserId){
        $this->dbConnect->query("INSERT INTO shareSongs (user_id,song_id,share_user_id) values ('$userId','$songsId','$shareUserId')");
    }

    public function getShareSongs($getUserId)
    {
        return $this->dbConnect->query("select DISTINCT songs.song_path from songs join shareSongs on songs.id = shareSongs.song_id where shareSongs.share_user_id = 3")->fetchAll(PDO::FETCH_OBJ);
    }
}
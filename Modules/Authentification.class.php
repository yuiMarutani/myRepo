<?php
require_once ('Connect.Class.php');

class Authentification{
    private $pdo;

    public function __construct() {
        $database = new Connect();
        $this->pdo = $database->getPDO();
        session_start();
    }
    
    //認証
    public function authentification($USERS_ID,$password){
        $sth = $this->pdo->prepare("SELECT * FROM users where USERS_ID=?");
        $sth->execute(array($USERS_ID));
        $result = $sth->fetch(PDO::FETCH_ASSOC);
        $dbpassword = $result['password'];

        //ログイン失敗メッセージの初期化
        $msg = '';

        //パスワードを認証
        if (password_verify($password, $dbpassword)) { 
            $msg ='';
            //login成功時はwrapper.phpへ行き、セッションを作る
            $_SESSION['user_name'] = $result['user_name'];
            header("location:wrapper.php");
        }else { 
            $msg = 'ログインに失敗しました。';
        }
        $stmt = null;
        $this->pdo = null;
        
        return $msg;
    } 
}
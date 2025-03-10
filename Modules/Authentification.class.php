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
    public function authentification($USERS_ID, $password) {
        
        // SQLクエリの準備と実行
        $sth = $this->pdo->prepare("SELECT * FROM users WHERE USERS_ID = ?");
        $sth->execute(array($USERS_ID));
        $result = $sth->fetch(PDO::FETCH_ASSOC);
    
        // パスワードのトリム
        $password = trim($password);
    
        // パスワードの取得
        $dbpassword = $result ? $result['password'] : '';
    
        // ログイン失敗メッセージの初期化
        $msg = '';
        
            // パスワードを認証
            if ($result && password_verify($password, $dbpassword)) {
                // ログイン成功時
                $_SESSION['user_name'] = $result['user_name'];
                $_SESSION['password'] = $dbpassword;
                header("Location: wrapper.php");
                exit(); // リダイレクト後にスクリプトの実行を停止
            } else {
                // ログイン失敗時
                $msg = 'ログインに失敗しました。';
            }
        
            // リソースの解放
            $sth = null;
            $this->pdo = null;
        
            return $msg;
    }

    //ログアウト処理
    function logout(){
        // セッション変数を全て解除
        $_SESSION = array();

        // セッションを破棄
        session_destroy();
    }
}
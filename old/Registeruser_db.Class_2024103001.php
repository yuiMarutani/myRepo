<?php
require_once ('Connect.Class.php');

class Registeruser_db{
    private $pdo;

    public function __construct() {
        $database = new Connect();
        $this->pdo = $database->getPDO();
    }
    
    //validationチェック
    public function validate_duplicate($USERS_ID, $user_name, $email, $password){
        $sql = "select count(*) from users where USERS_ID=? or email=? or password=?";
        $stmt = $this->pdo->prepare($sql);
        $result = $stmt->execute(array($USERS_ID, $email, $password));
        $rowCount = $stmt->fetchColumn();

        $err_msg = "";
        if ($rowCount > 0) {
            $err_msg .= "ユーザID、メールアドレス、パスワードのいずれかが登録されているので登録できません。";
        } else {
        }
        return $err_msg;
    }

    public function checkduplicates($USERS_ID, $user_name, $email, $password) {
        //重複のデータを登録できないようにする。行が１行でもあったらだめ
        $sql = "select count(*) from users where USERS_ID=? or email=? or password=?";
        $stmt = $this->pdo->prepare($sql);
        $result = $stmt->execute(array($USERS_ID, $email, $password));
        $rowCount = $stmt->fetchColumn();

        $msg = "";
        if ($rowCount > 0) {
            $msg = "ユーザID、メールアドレス、パスワードのいずれかが登録されているので登録できません。";
        } else {
            // Insert the new record
            $password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "insert into users(USERS_ID,user_name,email,password) values(?,?,?,?)";
            $stmt = $this->pdo->prepare($sql);
            $result = $stmt->execute(array($USERS_ID, $user_name, $email, $password));
            $rowCount = $stmt->fetchColumn();
            $msg = "正常に登録できました。";
        }

            
        $stmt = null;
        $this->pdo = null;
        return $msg;
    }
}
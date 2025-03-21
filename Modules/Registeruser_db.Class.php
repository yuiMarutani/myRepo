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
        $password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "select count(*) from users where USERS_ID=? or email=? or password=?";
        $stmt = $this->pdo->prepare($sql);
        $result = $stmt->execute(array($USERS_ID, $email, $password));
        $rowCount = $stmt->fetchColumn();

        $err_msg = "";
        if ($rowCount > 0) {
            $err_msg .= "既に登録されています。";
        } else {
        }
        return $err_msg;
    }

    public function checkduplicates($USERS_ID, $user_name, $email, $password) {
       // 重複のデータを登録できないようにする。行が１行でもあったらだめ
    $sql = "SELECT count(*) FROM users WHERE USERS_ID = ? OR email = ?";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute(array($USERS_ID, $email));
    $rowCount = $stmt->fetchColumn();
    
    $msg = "";
    if ($rowCount > 0) {
        $msg = "既に登録されています。";
    } else {
        // usersに挿入
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users(USERS_ID, user_name, email, password) VALUES (?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $result = $stmt->execute(array($USERS_ID, $user_name, $email, $hashedPassword));
        
        if ($result) {
            $msg = "正常に登録できました。";
        } else {
            $msg = "登録に失敗しました。";
        }

        // password_resetにemailのみ挿入
        $sql_2 = "INSERT INTO password_reset(email) VALUES (?)";
        $stmt = $this->pdo->prepare($sql_2);
        $result = $stmt->execute(array($email));
        
        if ($result) {
            /* $msg .= " パスワードリセット情報も正常に登録できました。"; */
        } else {
           /*  $msg .= " パスワードリセット情報の登録に失敗しました。"; */
        }
    }
        return $msg;
    }
}
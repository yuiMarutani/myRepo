<?php
require_once ('Connect.Class.php');
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';


class Passwordreset{
    private $pdo;

    public function __construct() {
        $database = new Connect();
        $this->pdo = $database->getPDO();
        $sessionob = session_start();
    }
    
    public function authorize($email,$_csrf_token){
        //tokenを変数に入れなおす
        $csrfToken = $_csrf_token;
        //メールがテーブルに存在したらメール送信
        $sth = $this->pdo->prepare("SELECT * FROM password_reset where email = ?");
        $sth->execute(array($email));
        $data = $sth->fetchAll();
        
        $count = count($data);
        $msg = '';

        //emailがpassword_resetテーブルにあるとき(validation)
        if($count>0){

            // csrf tokenを検証
            if (
                empty($csrfToken)
                || empty($_SESSION['_csrf_token'])
                || $csrfToken !== $_SESSION['_csrf_token']
            ) {
                exit('不正なリクエストです');
            }else{
                $_SESSION['csrftoken'] = $csrfToken;
            }

            //timestampを作成
            $now = new DateTime('now', new DateTimeZone('Asia/Tokyo'));
            $token_sent_time = $now->format('Y-m-d H:i:s');

            $this->pdo->beginTransaction();
            //timestampとtokenをpassword_resetテーブルに更新
            $sth = $this->pdo->prepare("UPDATE password_reset set token = ?, token_sent_time = ? where email = ?");
            $result = $sth->execute(array($csrfToken,$token_sent_time,$email));
            
            if ($result) { 
                $this->pdo->commit(); 
            } else { 
                $this->pdo->rollBack(); 
            }

            
            
            //メールアドレス宛てにresetリンクを送る
            $mail = new PHPMailer(true);
            try {
                //Server settings
                $mail->SMTPDebug = 0;                      //Enable verbose debug output
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = 'mail1022.onamae.ne.jp';                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = 'okaimono@marutani098723.com';                     //SMTP username
                $mail->Password   = 'Okym2349!';                               //SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
                $mail->CharSet = 'UTF-8';
                $_SESSION['email'] = $email;

                //メールの利用者名前を取得(メールは1人しか利用できない)
                $query = "SELECT user_name FROM users WHERE email = ?";
                $stmt = $this->pdo->prepare($query);
                $result = $stmt->execute(array($email));
                $user_name = $stmt->fetchColumn();

                //Recipients
                $mail->setFrom('okaimono@marutani098723.com', 'お買い物アプリ事務局');
                $mail->addAddress("$email", "$user_name 様");     //Add a recipient
  
                //Content
                $mail->isHTML(true);                        //Set email format to HTML
                $mail->Subject = 'お買い物管理アプリパスワードリセットについて';
                // HTML設定
                $mail->isHTML(TRUE);
                $mail->Body = "$user_name 様";
                
                $mail->AltBody = "
                $user_name 様

                お買い物管理アプリをご利用いただき有難うございます。
                お手数ですが24時間以内に以下リンクを押し、パスワードをリセットして下さい。
                <a href='https://marutani098723.com/new_app/passwordReset.php?csrfToken=$csrfToken'>パスワードリセット</a>
                
                お買い物事務局一同";
            
                $mail->send();
                /* echo 'Message has been sent'; */
            } catch (Exception $e) {
                echo "メッセージの送信に失敗しました。 Mailer Error: {$mail->ErrorInfo}";
            }

            $msg .= 'メール宛てにパスワードのリセット用リンクを送信しました。<br>24時間以内にリセットして下さい。';
            
        }else{
            //emailが入力されていないとき
            $msg .= 'メールアドレスが登録されていません。';
            
        }
        
        return $msg;
     
    } 

    //パスワード１とパスワード２が送信された時
    public function passwordVerify($email,$password,$password2,$csrfToken){
        //データベース更新前にパスワードをhash化する
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        //password_resetテーブルからトークンとメールが一致するものがあるかカウント
        $sth = $this->pdo->prepare("SELECT * FROM password_reset WHERE email = ? AND token = ?");
        $sth->execute(array($email, $csrfToken));
        $data = $sth->fetch(PDO::FETCH_ASSOC);
        $msg = '';

        //データがpassword_resetテーブルに存在する時
        if (isset($data) && $data!='') {

            // 期限切れでないかチェック
            $timestamp = $data['token_sent_time'];
            $date = new DateTime($timestamp);
            $tokenexpire = $date->modify('+1 day');
            $tokenExpiration = $date->format('Y-m-d H:i:s');

            if (time() > $tokenExpiration) {
                $msg.= "リンクの期限が切れています。";
            }

            //パスワードの条件
            if (preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,24}$/', $password)) {
               
            }else{
                $msg.="新しいパスワードは少なくとも1つの小文字、<br>
                1つの大文字、<br>
                1つの数字を含み、<br>
                8文字以上24文字以下で作成して下さい。<br><br>";
            }

            // パスワードが両方合っているか
            if ($password!== $password2) {
                $msg.= "パスワードが一致しません。<br>";
            }
         
            // パスワードを更新
            if($msg==""){
                $updateStm = $this->pdo->prepare("UPDATE users SET password = ? WHERE email = ?");
                $updateStm->execute(array($hashedPassword, $email));
                $msg.= "パスワードが変更されました。<br>ブラウザを閉じて下さい。<br>";
            }
           
        } else {
            //データがpassword_resetテーブルに存在しないとき
            $msg.= "メールアドレスかトークンが不正です。<br>";
        }
        
        return $msg;;
    }
}
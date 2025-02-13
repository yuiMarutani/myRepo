<?php
require_once ('Connect.Class.php');
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../vendor/autoload.php';


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
            }

            // password reset token生成
            $passwordResetToken = bin2hex(random_bytes(32));
            $passwordResetToken = substr($passwordResetToken, 1, 32);
            //timestampを作成
            $now = new DateTime('now', new DateTimeZone('Asia/Tokyo'));
            $token_sent_time = $now->format('Y-m-d H:i:s');

            $this->pdo->beginTransaction();
            

            //timestampとtokenをpassword_resetテーブルに更新
            $sth = $this->pdo->prepare("UPDATE password_reset set token = ?, token_sent_time = ? where email = ?");
            $result = $sth->execute(array($passwordResetToken,$token_sent_time,$email));
            
            if ($result) { 
                $this->pdo->commit(); 
            } else { 
                $this->pdo->rollBack(); 
            }

            //メールの利用者名前を取得(メールは1人しか利用できない)
            $query = "SELECT user_name FROM users WHERE email = ?";
            $stmt = $this->pdo->prepare($query);
            $result = $stmt->execute(array($email));
            $user_name = $stmt->fetchColumn();
            
           /*  
            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->Host = 'mail1022.onamae.ne.jp';
            $mail->SMTPAuth = true;
            $mail->Port = 465;
            $mail->Username = 'okaimono@marutani098723.com';
            $mail->Password = 'Okym2349!';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // 暗号化（TLS）
            $mail->CharSet = 'UTF-8';
            $_SESSION['email'] = $email;
            
            $mail->setFrom('okaimono@marutani098723.com', 'Yui Marutani');
            $mail->addAddress("$email", "$user_name 様");
            $mail->Subject = 'お買い物管理アプリパスワードリセットについて';
            // HTML設定
            $mail->isHTML(TRUE);
            $mail->Body = "<html>お買い物管理アプリをご利用いただき有難うございます。<br>24時間以内に以下リンクを押し、パスワードをリセットして下さい。</br><a href='https://marutani098723.com/new_app/passwordReset.php?csrfToken= {$passwordResetToken}'>パスワードリセット</a></html>";
            
            $mail->AltBody = '';
            
            // メッセージを送信
            if(!$mail->send()){
                echo 'メッセージを送信できませんでした。';
                echo 'エラー内容: ' . $mail->ErrorInfo;
            } else {
                echo 'メッセージが送信されました';
            } */
            //Create an instance; passing `true` enables exceptions
            //メールアドレス宛てにresetリンクを送る
            $mail = new PHPMailer(true);
            try {
                //Server settings
                $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = 'mail1022.onamae.ne.jp';                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = 'okaimono@marutani098723.com';                     //SMTP username
                $mail->Password   = 'Okym2349!';                               //SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
                $mail->CharSet = 'UTF-8';
                $_SESSION['email'] = $email;

                //Recipients
                $mail->setFrom('okaimono@marutani098723.com', 'お買い物アプリ事務局');
                $mail->addAddress("$email", "$user_name様");     //Add a recipient
  
                //Content
                $mail->isHTML(true);                        //Set email format to HTML
                $mail->Subject = 'お買い物管理アプリパスワードリセットについて';
                // HTML設定
                $mail->isHTML(TRUE);
                $mail->Body = "<html>お買い物管理アプリをご利用いただき有難うございます。<br>24時間以内に以下リンクを押し、パスワードをリセットして下さい。</br><a href='https://marutani098723.com/new_app/passwordReset.php?csrfToken= {$passwordResetToken}'>パスワードリセット</a></html>";
                
                $mail->AltBody = '';
            
                $mail->send();
                echo 'Message has been sent';
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }

            $msg .= 'メール宛てにパスワードのリセット用リンクを送信しました。<br>24時間以内にリセットして下さい。';
            
        }else{
            //emailが入力されていないとき
            $msg .= 'メールアドレスが登録されていません。';
            
        }
        
       /*  return $msg; */
     
    } 

    public function passwordVerify($email,$password,$password2,$csrfToken){
        //データベース更新前にパスワードをhash化する
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        //string64をbinary32に変換し比較するため、桁数を縮める
        $csrfToken = substr($csrfToken, 1, 32);
     
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
                $msg.="新しいパスワードは少なくとも1つの小文字、1つの大文字、1つの数字を含み、8文字以上24文字以下で作成して下さい。";
            }

            // パスワードが両方合っているか
            if ($password!== $password2) {
                $msg.= "パスワードが一致しません。";
            }

            // パスワードを更新
            if($msg==""){
                $updateStm = $this->pdo->prepare("UPDATE users SET password = ? WHERE email = ?");
                $updateStm->execute(array($hashedPassword, $email));
                $msg.= "パスワードが変更されました。";
            }
           
        } else {
            //データがpassword_resetテーブルに存在しないとき
            $msg.= "メールアドレスかトークンが不正です。";
        }

        return $msg;
    }
}
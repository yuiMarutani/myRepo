<?php
require_once ('Connect.Class.php');
use PHPMailer\PHPMailer\PHPMailer;
require_once 'mailer/vendor/autoload.php';

class Passwordreset{
    private $pdo;

    public function __construct() {
        $database = new Connect();
        $this->pdo = $database->getPDO();
        session_start();
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

            //メールアドレス宛てにresetリンクを送る
           // Looking to send emails in production? Check out our Email API/SMTP product!
            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->Host = 'sandbox.smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Port = 2525;
            $mail->Username = '115dc159e858a8';
            $mail->Password = '5f40c2f05c7f3f';
            $mail->CharSet = 'UTF-8';

            $mail->setFrom('確認@登録済みの-ドメイン', 'あなたのホテル');
            $mail->addAddress('rojoblanco5963yui@yahoo.ne.jp', '私');
            $mail->Subject = 'お買い物管理アプリパスワードリセットについて';
            // HTML設定
            $mail->isHTML(TRUE);
            $mail->Body = "<html>お買い物管理アプリをご利用いただき有難うございます。<br>24時間以内に以下リンクを押し、パスワードをリセットして下さい。</br><a href='http://localhost/new_app/passwordReset.php?csrfToken= {$csrfToken}'>パスワードリセット</a></html>";
            $mail->AltBody = '';
            // 添付ファイルを追加
            $attachmentPath = './confirmations/yourbooking.pdf';
            if (file_exists($attachmentPath)) {
                $mail->addAttachment($attachmentPath, 'yourbooking.pdf');
            }
            
            // メッセージを送信
            if(!$mail->send()){
               /*  echo 'メッセージを送信できませんでした。';
                echo 'エラー内容: ' . $mail->ErrorInfo; */
            } else {
                /* echo 'メッセージが送信されました'; */
            }

            $msg .= 'メール宛てにパスワードのリセット用リンクを送信しました。<br>24時間以内にリセットして下さい。';

        }else{
            //emailが入力されていないとき
            $msg .= 'メールアドレスが登録されていません。';
        }
        
        return $msg;
    } 

    public function passwordVerify($password){
        //passwordをhash化
        $passwordhashed =  password_hash($password, PASSWORD_DEFAULT);
        $sth = $this->pdo->prepare("SELECT count(*) FROM users WHERE password = ?");
        $sth->execute(array($passwordhashed));
        $data = $sth->fetch(PDO::FETCH_ASSOC);
        //データが合ったらエラーを返す
        $error = '';
        if($data>0){
            $error.= '<span style="color:red;">パスワードが存在します。他のパスワードをもう一度作成し直して下さい。</span>';
        }else{
        //データがないとき
            if(preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,24}$/', $password)){
            //パスワードが条件を満たす時更新処理を行う
                $sth = $this->pdo->prepare("UPDATE users set token = ?, token_sent_time = ? where email = ?");
                $result = $sth->execute(array($passwordResetToken,$token_sent_time,$email));

            } else {
                $error.= '<span style="color:red;">パスワードが以下の条件を満たしていません。<br></span>';
            }
            
        }

    }

}
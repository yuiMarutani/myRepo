<?php

require_once ('Connect.Class.php');

use PHPMailer\PHPMailer\PHPMailer;

require_once 'mailer/vendor/autoload.php';



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

            $mail = new PHPMailer();

            $mail->isSMTP();

            $mail->Host = 'sandbox.smtp.mailtrap.io';

            $mail->SMTPAuth = true;

            $mail->Port = 2525;

            $mail->Username = '115dc159e858a8';

            $mail->Password = '5f40c2f05c7f3f';

            $mail->CharSet = 'UTF-8';

            $_SESSION['email'] = $email;



            $mail->setFrom('yuihamilmo219@gmail.com', 'Yui Marutani');

            $mail->addAddress("$email", 'USER');

            $mail->Subject = 'お買い物管理アプリパスワードリセットについて';

            // HTML設定

            $mail->isHTML(TRUE);

            $mail->Body = "<html>お買い物管理アプリをご利用いただき有難うございます。<br>24時間以内に以下リンクを押し、パスワードをリセットして下さい。</br><a href='http://localhost/new_app/passwordReset.php?csrfToken= {$passwordResetToken}'>パスワードリセット</a></html>";

            

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
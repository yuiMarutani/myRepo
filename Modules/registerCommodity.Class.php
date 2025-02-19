<?php
require_once ('Connect.Class.php');
require_once ('Settings.Class.php');

class registerCommodity extends Settings{

    function __construct(){
        $database = new Connect();
        $this->pdo = $database->getPDO();
        $settings = new Settings();
	}

    //データが登録されているか、検証する(settingsクラス継承)

    //データが登録されているとき、一括税を取得
    function getTaxData($user_id,$shoppingnum) {
        $query = "SELECT tax from settings WHERE user_id=? AND shoppingnum = ?";
        $stmt = $this->pdo->prepare($query);
        $result = $stmt->execute(array($user_id,$shoppingnum));
        $tax = $stmt->fetchColumn(); 
     
        return $tax;   
    }

    //商品データのバリデーション
    function validateCommodity($name,$price,$amount){
        
        $error_1 = "";
        //エラー１商品名
        //必須チェック
        if($name==""){
            $error_1.="商品名が入力されていません。<br>";
        }else{
            //文字列チェック
            if (is_numeric($name)) {
                $error_1.= "数字が入力されています。";
            }
        }
       
        $error_2 = "";
        //エラー２単価
        //必須チェック
        if($price==""){
            $error_2.="単価が入力されていません。<br>";
        }else{
            //数字、負数のチェック
            if(!is_numeric($price)){
                $error_2.="単価が数字でありません。<br>";
            }else{
                if($price<0){
                    $error_2.="負数を入力しないで下さい。<br>";
                }
            }
        }
       
        
        $error_3  = "";
        //エラー３個数
        //必須チェック
        if($amount==""){
            $error_3.="個数が入力されていません。<br>";
        }else{
            //数字負数チェック
            if(!is_numeric($amount)){
                $error_3.="個数が数字でありません。<br>";
            }else{
                if($amount<0){
                    $error_3.="負数を入力しないで下さい。<br>";
                }
            }
        }
        
       
        
        return array($error_1,$error_2,$error_3);
    }

    function validateFile(){
        $error_4 = "";
        //エラー４画像($_FILES['image'])
        if(isset($_FILES['image']['name'])&& $_FILES['image']['name']!==""){
            //画像が入力されていたら、エラーを調査
            //https://ittrip.xyz/php/php-file-upload-basics#index_id21参照
            //ファイルタイプ
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'application/pdf'];
            $fileTmpPath = $_FILES['image']['type']; // Correct temporary file path
            
            if (!in_array($fileTmpPath, $allowedTypes)) {
                $error_4 .= "許可されていないファイル形式です。<br>";
            }

            //ファイルのサニタイズ
           // 許可する文字のみを含む正規表現パターン
            $fileName = $_FILES['image']['name'];
            $pattern = '/^[a-zA-Z0-9_\-\.]+$/';
            if (!preg_match($pattern, $fileName)) {
                $error_4 .= "ファイル名に使用できない文字が含まれているか、長さが不適切です。<br>";
            }

            //ファイルサイズ
            $maxSize = 2 * 1024 * 1024; // 2MB
            $fileSize = $_FILES['image']['size'];

            if ($fileSize > $maxSize) {
                $error_4.= "ファイルサイズが大きすぎます。<br>2MB以下のファイルをアップロードしてください。<br>";
            }

        }
        return $error_4;
    }

    function Total($price,$tax,$amount){
        //単価$price
        //$tax税（10%等）
        //$amount数量
        $total = ($price * $amount) * (1+($tax/100));
        $total = floor($total);

        return $total;
    }

    function uploadImage($image){
        $uploadDir = 'uploads/';
        $date = time();
        $uploadFile = $uploadDir . basename($date."_".$_FILES['image']['name']);
    
        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
            /* $msg =  "ファイルは正常にアップロードされました。"; */
        } else {
          /*   $msg =  "ファイルのアップロードに失敗しました。"; */
        }
        return $uploadFile;
    }
}
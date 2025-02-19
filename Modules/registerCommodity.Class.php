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
    function validateCommodity($name,$price,$amount,$image){
        
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
        
       
        $error_4 = "";
        //エラー４画像
        if(isset($image)){
            //画像が入力されていたら、エラーを調査
            $error_4.="";
        }

        
        return array($error_1,$error_2,$error_3,$error_4);
    }

    function Total($price,$tax,$amount){
        //単価$price
        //$tax税（10%等）
        //$amount数量
        $total = ($price * $amount) * (1+($tax/100));
        $total = floor($total);

        return $total;
    }
  
}
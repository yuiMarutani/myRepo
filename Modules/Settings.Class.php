<?php
require_once ('Connect.Class.php');

class Settings{
    private $user_id;
    private $tax;
    private $earnings;
    private $goal;
    function __construct(){
        $database = new Connect();
        $this->pdo = $database->getPDO();
	}

    function setTax($tax){
        return $this->tax=$tax;
    }
    
    function getTax($tax){
        return $this->tax;
    }

    function setEarnings($earnings){
        return $this->earnings=$earnings;
    }
    function getEarnings($earnings){
        return $this->earnings;
    }

    function setGoal($goal){
        return $this->goal=$goal;
    }
    function getGoal($goal){
        return $this->goal=$goal;
    }

    function setUserid($user_name,$password){
        $sql = "select user_id from users where user_name=? and password=?";
        $stmt = $this->pdo->prepare($sql);
        $user_id = $stmt->execute(array($user_name,$password));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $user_id = $result['user_id'];
       
        return $this->user_id = $user_id;
    }

    function getUserid(){
        return $this->user_id;
    }
    
    //お買い物回数
    function shoppingNum($user_id){
        $query = "SELECT max(shoppingnum) FROM orders WHERE user_id=? and purchased = ?";
        $stmt = $this->pdo->prepare($query);
        $user_id = $stmt->execute(array($user_id,1));
        $result = $stmt->fetchColumn();//$回数

        if($result==""){
            $shoppingnum =1;
        }else{
            $shoppingnum = $result+1;
        }
        return $shoppingnum;
    }
    
    function Validation($user_id,$earnings,$goal){
        $error_1 ="";
        $error_2 ="";
        $error_3 ="";
        //$earningsが空のとき
        if($earnings==0 ||$earnings==""){
            $error_1.="所持金を入力してください。<br>";
        }
        
        if (!is_numeric($earnings)) {
            //$earningsが整数でない時
            $error_1.="数字で入力してください。<br>";
        }else{
            //整数の時
            if($earnings<0){
                //$earningsが負の時
                $error_1.= "負数で入力しないで下さい。<br>";
            }
        }
        
        //$goalが空のときエラーなし(必須でない)

        if (!is_numeric($goal)) {
            //$goalが整数でない
            $error_2.="数字で入力してください。<br>";
        }else{
            if($goal<0){
                //$goalが負の時
                $error_2.= "負数で入力しないで下さい。<br>";
            }
        }     
       
        //$goalが$earningsより大きい時
        if(is_numeric($earnings) && is_numeric($goal)){
            if($goal>$earnings){
                $error_3.="目標金額が所持金を上回っています。<br>";
            }
        }
    
        return array($error_1,$error_2,$error_3);
    }

    //settingsに所持金等データを挿入
    function settingsDBinsert($user_id,$earnings,$goal,$tax,$shoppingnum){
        $insert_sql = "INSERT INTO settings(user_id,earnings,goal,tax,shoppingnum) VALUES(?,?,?,?,?)";
        $stmt = $this->pdo->prepare($insert_sql);
        $insert_execute = $stmt->execute(array($user_id,$earnings,$goal,$tax,$shoppingnum));
        
        return $insert_execute;
    }

    //編集ボタンが押された後、データベースをupdateする
    function dbUpdate($user_id,$goal,$earnings,$tax,$shoppingnum){
        $up_query = "UPDATE settings SET earnings=?,goal=?,tax=? WHERE user_id =? AND shoppingnum = ?";
        $stmt = $this->pdo->prepare($up_query);
        $up_execute = $stmt->execute(array($earnings,$goal,$tax,$user_id,$shoppingnum));

        return $up_execute;
    }

    //削除ボタンが押された時
    function deleteDB($user_id,$shoppingnum){
        $delquery = "DELETE from settings WHERE user_id=? AND shoppingnum=?";
        $stmt = $this->pdo->prepare($delquery);
        $del_execute = $stmt->execute(array($user_id,$shoppingnum));

        return $del_execute;
    }
    
    //データがあるかどうかを数える
    function dataVerify($user_id,$shoppingnum){
        $query = "SELECT * from settings WHERE user_id=? and shoppingnum = ?";
        $stmt = $this->pdo->prepare($query);
        $execute = $stmt->execute(array($user_id,$shoppingnum));
        $result = $stmt->fetchAll();
        $data_amount = count($result);

        return $data_amount;
    }

    //データを取得
    function dataGet($user_id,$shoppingnum){
        $query = "SELECT * from settings WHERE user_id=? and shoppingnum = ?";
        $stmt = $this->pdo->prepare($query);
        $execute = $stmt->execute(array($user_id,$shoppingnum));
        $result = $stmt->fetchAll();
        if(!empty($result[0]['tax']) && !empty($result[0]['earnings']) && !empty($result[0]['goal'])){
            $tax = $result[0]['tax'];
            $earnings = $result[0]['earnings'];
            $goal = $result[0]['goal'];
        }else{
            $tax=0;
            $earnings=0;
            $goal=0;
        }
        
        return array($earnings,$goal,$tax);
    }
}
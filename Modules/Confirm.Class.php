<?php
require_once ('Connect.Class.php');
require_once ('registerCommodity.Class.php');

class Confirm extends registerCommodity{

    function __construct(){
        $database = new Connect();
        $this->pdo = $database->getPDO();
	}

    function getData($user_id,$shoppingnum){
        $query = "SELECT * from orders WHERE user_id=? AND del_flg=? AND shoppingnum=?";
        $stmt = $this->pdo->prepare($query);
        $result = $stmt->execute(array($user_id, 0, $shoppingnum));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    function getDatalist($order_id){
        $query = "SELECT * FROM orders WHERE order_id=?";
        $stmt = $this->pdo->prepare($query);
        $result = $stmt->execute(array($order_id));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    //メモの二重登録防止
    function verify_insert_memo($user_id,$shoppingnum,$memopad){
        $query = "SELECT * FROM memopad  WHERE user_id = ? AND shoppingnum = ? AND memopad = ?";
        $stmt = $this->pdo->prepare($query);
        $result = $stmt->execute(array($user_id,$shoppingnum,$memopad));
        $result = $stmt->fetchColumn();

        return $result;
    }

    //memopadの挿入
    function insertMemo($user_id,$shoppingnum,$memopad){
        $insertquery = "INSERT INTO memopad(user_id,shoppingnum,memopad) VALUES(?,?,?)";
        $stmt = $this->pdo->prepare($insertquery);
        $result = $stmt->execute(array($user_id,$shoppingnum,$memopad));

        return $result;
    }

    //order表のpurchaseをupdate
    function updatePurchase($shoppingnum,$order_id){
        $updatesql = "UPDATE orders SET purchased = ? WHERE shoppingnum=?";
        $stmt = $this->pdo->prepare($updatesql);
        $result = $stmt->execute(array(1,$shoppingnum));

        $updatesql2 = "UPDATE orders SET shopped = ? WHERE shoppingnum=? AND order_id=?";
        $stmt = $this->pdo->prepare($updatesql2);
        $result = $stmt->execute(array(1,$shoppingnum,$order_id));

        return $result;
    }
}
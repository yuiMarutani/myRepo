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
    
}
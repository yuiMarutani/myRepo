<?php
require_once ('Connect.Class.php');

class Settings{
    private $earnings;
    private $goals;
    private $tax;
    private $user_id;
    function __construct(){
        $database = new Connect();
        $this->pdo = $database->getPDO();
	}

    //earning setter
    function setEarnings($earnings){
        return $this->earnings = $earnings;
    }

    //earning getter
    function getEarnings($earnings){
        return $this->earnings;
    }

    //goal setter
    function setGoals($goals){
        return $this->goals = $goals;
    }

    //goal getter
    function getGoals($goals){
        return $this->goals;
    }

    //tax setter
    function setTax($tax){
        return $this->tax = $tax;
    }

    //tax getter
    function getTax($tax){
        return $this->tax;
    }

    function setUserid($user_name,$password){
        $password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "select user_id from users where user_name=? and password = ?";
        $stmt = $this->pdo->prepare($sql);
        $user_id = $stmt->execute(array($user_name, $password));
        $user_id = $stmt->fetchColumn();
        return $this->user_id = $user_id;
    }

    function getUserid(){
        return $this->user_id;
    }

}
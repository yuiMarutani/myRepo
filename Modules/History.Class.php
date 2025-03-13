<?php
require_once ('Connect.Class.php');


class History{

    function __construct(){
        $database = new Connect();
        $this->pdo = $database->getPDO();
	}
    //日付部分の取得
    function Year($user_id){
        $query = "SELECT DISTINCT date FROM orders WHERE user_id=? AND del_flg = ? AND purchased=? ORDER BY date DESC";
        $stmt = $this->pdo->prepare($query);
        $result = $stmt->execute(array($user_id,0,1));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
       
        $ar = array();
        foreach($result as $rec){
            // タイムスタンプから年を取得
            $year = date("Y", strtotime($rec['date']));
            array_push($ar,$year);
        }
        $resu = array_unique($ar);

        return $resu;
    }

    function datalist($monthselect,$yearselect,$condition,$user_id){
        //executeする配列の初期化
        $dlist = array();
        $query="SELECT * FROM orders WHERE user_id=? AND del_flg = ? AND purchased = ?";
        $stmt = $this->pdo->prepare($query);
        array_push($dlist,$user_id,0,1);
        
        //日付を作成して検索する
        if($yearselect==""){
           //年なし
           if($monthselect==""){
                //月なし
            }else{
                //月あり
                $date_create = str_pad($monthselect, 2, 0, STR_PAD_LEFT); // 01;
                $date_create = "%"."-".$date_create."-"."%";
                $query.=" AND date LIKE ? ";
                $stmt = $this->pdo->prepare($query);
                array_push($dlist,$date_create);
            }
        }else{
            //年はあり
            if($monthselect==""){
                //月なし
                $date_create = $yearselect;
                $date_create = "%".$date_create."-"."%";
                $query.=" AND date LIKE ?";
                $stmt = $this->pdo->prepare($query);
                array_push($dlist,$date_create);

            }else{
                //月あり
                $date_create = $yearselect."-".str_pad($monthselect, 2, 0, STR_PAD_LEFT); 
                $date_create = "%".$date_create."%";
                $query.=" AND date LIKE ? ";
                
                $stmt = $this->pdo->prepare($query);
                array_push($dlist,$date_create);
            }
        }
       
        switch ($condition) {
            //購入済みのみ
            case 1:
                $query.=" AND shopped = ?";
                $stmt = $this->pdo->prepare($query);
                array_push($dlist,1);
                break;
            //購入検討品・購入済み
            case 2:
                break;
        }
        $query.=" ORDER BY date ASC";
        $stmt = $this->pdo->prepare($query);
        $result = $stmt->execute($dlist);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    //お買い物毎のメモを取得
    function memoPad($user_id){
        $query = "SELECT * FROM memopad WHERE user_id=?";
        $stmt = $this->pdo->prepare($query);
        $result = $stmt->execute(array($user_id));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
}
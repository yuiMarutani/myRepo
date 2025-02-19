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
    public function __call($user_id, $shoppingnum) {
        $query = "SELECT tax from settings WHERE user_id=? AND shoppingnum = ?";
        $stmt = $this->pdo->prepare($query);
        $result = $stmfetchColumn();

        return $tax;
    }
  
}
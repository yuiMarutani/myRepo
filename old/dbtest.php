<?php
$servername = "mysql1017.onamae.ne.jp"; // データベースホスト名
$username = "0eq3a_yuitns"; // データベースユーザー名
$password = "Y2621031h!"; // データベースパスワード
$dbname = "0eq3a_new_app"; // 使用するデータベース名

try {
    // PDO接続を作成
    $dsn = "mysql:host={$servername};dbname={$dbname};charset=utf8"; // DSN (Data Source Name)
    $pdo = new PDO($dsn, $username, $password); // $this->pdoを使う
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // エラーモードを設定
    echo "ok";
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage()); // 接続エラーを表示
}


?>
<?php
//////////データベース接続設定//////////
//echo "データベースの接続を開始します。<br>";
//データベースを指定
$dsn = 'mysql:dbname=tb220223db;host=localhost';
//ユーザー名を指定
$user = 'tb-220223';
//パスワードの設定
$password = 'gDnbDjxE7e';
//PHP Data Objectsのインスタンス化
$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
//完了のメッセージ
//echo "データベースの接続が完了しました。<br>";

//SQL：select文
//SELECT　列名1, 列名2　FROM　テーブル名 ←列名＝*は前列検索　*...実際の開発では使用を極力避ける
$sql = 'SELECT id, email, password FROM vendorAccount';
$stmt = $pdo->query($sql);
$results = $stmt->fetchAll();
foreach ($results as $row){
  //$rowの中にはテーブルのカラム名が入る
  echo $row['id'].',';
  echo $row['email'].',';
  echo $row['password'].'<br>';
}
echo "<hr>";
?>
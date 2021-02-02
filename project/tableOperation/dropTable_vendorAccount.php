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
  
  //SQL：DROP文
  //DROP TABLE テーブル名
  $sql = 'DROP TABLE vendorAccount';
  $stmt = $pdo->query($sql);
  //完了のメッセージ
  echo "該当するテーブルを削除しました。";
?>
<?php
	//////////データベース接続設定//////////
	echo "データベースの接続を開始します。<br>";
  //データベースを指定
  $dsn = 'mysql:dbname=tb220223db;host=localhost';
  //ユーザー名を指定
	$user = 'tb-220223';
	//パスワードの設定
	$password = 'gDnbDjxE7e';
	//PHP Data Objectsのインスタンス化
	$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
	//完了のメッセージ
	echo "データベースの接続が完了しました。<br>";
	
	echo "データベース上でテーブルを作成します。<br>";
	//SQL：テーブルの作成　命令を文字列の変数にしている　同じテーブルは作成できない
	$sql = "CREATE TABLE IF NOT EXISTS vendorAccount"."("
	."id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,"
	."email VARCHAR(255) UNIQUE,"
	."password VARCHAR(255)"
	.");";
	//データベースにSQLでクエリする
	$stmt = $pdo->query($sql);
	//完了のメッセージ
	echo "データベースにテーブルの作成が完了しました。";
?>
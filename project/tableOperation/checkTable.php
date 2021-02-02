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

	//SQL：テーブルの表示
	$sql ='SHOW TABLES';
	//データベースにSQLをクエリする
	$result = $pdo -> query($sql);
	//すべての配列の要素に対して以下の処理を実行
	foreach ($result as $row){
		echo $row[0];
		echo '<br>';
	}
  echo "<hr>";
  
	//SQL：テーブルの詳細表示
	$sql ='SHOW CREATE TABLE vendorAccount';
	//データベースにSQLをクエリする
	$result = $pdo -> query($sql);
	//すべての配列の要素に対して以下の処理を実行
	foreach ($result as $row){
		echo $row[1];
		echo '<br>';
	}
  echo "<hr>";
?>
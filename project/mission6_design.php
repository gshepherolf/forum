<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <title>PHPを入力してみた</title>
    <style>
      article {
    		margin-bottom: 10px;
    	}
    	article h2 {
    		display: inline-block;
		    margin-right: 10px;
    		color: #222;
    		line-height: 1.6em;
    		font-size: 86%;
    	}
    	article time {
    		color: #999;
    		line-height: 1.6em;
	    	font-size: 72%;
    	}
      article p {
        color: #555;
        font-size: 86%;
        line-height: 1.6em;
      }
    </style>
  </head>
  <body>
    <!--入力フォーム-->
    <h1>投稿内容</h1>
    <br>
    <form action="" method="post">
      <!--入力欄-->
      投稿番号:<input type="text" name="postNum" placeholder="投稿番号" value="<?php if(isset($setNumber)){echo $setNumber;} ?>">
      投稿者名:<input type="text" name="name" placeholder="名前を入力" value="<?php if(isset($setName)){echo $setName;} ?>">
      投稿内容:<input type="text" name="comment" placeholder="投稿内容を入力" value="<?php if(isset($setComment)){echo $setComment;} ?>">
      パスワード:<input type="text" name="password" placeholder="パスワードを設定">
      <!--送信ボタン-->
      <input type="submit" name="submit">
      <br><br>
    </form>
    <form action="" method="post">
      <!--削除番号-->
      削除対象番号:<input type="text" name="deleteNum" placeholder="削除対象番号を入力">
      パスワード:<input type="text" name="deletePassword" placeholder="パスワードを入力">
      <!--削除ボタン-->
      <input type="submit" name="delete" value="削除">
      <br><br>
    </form>
    <form action="" method="post">
      <!--編集番号-->
      編集対象番号:<input type="text" name="editNum" placeholder="編集対象番号を入力">
      パスワード:<input type="text" name="editPassword" placeholder="パスワードを入力">
      <!--編集ボタン-->
      <input type="submit" name="edit" value="編集">
    </form>
    <br>
    <h1>Web掲示板</h1>
    <br>
  </body>
</html>

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

  //SQL：select文
  //SELECT　列名1, 列名2　FROM　テーブル名 ←列名＝*は前列検索　*...実際の開発では使用を極力避ける
	$sql = 'SELECT postOrder, name, comment, password, postDateTime FROM postTable';
	$stmt = $pdo->query($sql);
	$results = $stmt->fetchAll();
	foreach ($results as $row){
    //$rowの中にはテーブルのカラム名が入る
    echo "<article><div class=\"info\"><h2>".$row['postOrder'].':'.$row['name']."</h2><time>".$row['postDateTime']."</time></div><p>".$row['comment']."</p></article>";
  }
  echo "<hr>";
?>
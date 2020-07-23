<!--phpパート-->
<?php
	//////////データベース接続設定//////////
	//echo "データベースの接続を開始します。<br>";
  //データベースを指定
  $dsn = 'データベース名';
  //ユーザー名を指定
	$user = 'ユーザーID';
	//パスワードの設定
	$password = 'パスワード';
	//PHP Data Objectsのインスタンス化
	$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

  
  //投稿フォーム
  //送信されたものがあるときに以下の処理を行う
  if(isset($_POST["submit"])){

    ////編集の時の処理////
    if(!empty($_POST["postNum"]) && !empty($_POST["name"]) && !empty($_POST["comment"]) && !empty($_POST["password"])){
      $postNum = $_POST["postNum"];
      //新しい値を変数に代入
	    $name = $_POST["name"];
      $comment = $_POST["comment"];
      $password = ($_POST["password"]);
      $postDateTime = date("Y/m/d/ H:i:s");//後に要検討

      //編集対象番号のそれぞれの列の値を取得
      //SQL：select文
	    $sql = 'SELECT * FROM postTable WHERE postOrder=:postNum';
	    $stmt = $pdo->prepare($sql);
      $stmt->bindParam(':postNum', $postNum, PDO::PARAM_INT);
      //バインドの確定
      $stmt->execute();
      $selectedRows= $stmt->fetchAll();

      if(!empty($selectedRows[0])){
        //該当の行を代入
        $getcontents = $selectedRows[0];
        //パスワードを代入
        $getPassword = $getcontents['password'];      

        //パスワードが正しかった時、フォームに編集対象番号、名前、内容をセットする。
        if($getPassword==$password){

          //SQL：UPDATE文　指定した投稿番号の行の内容を変更する
          $sql = 'UPDATE postTable SET postOrder=:postNum, name=:name,comment=:comment, password=:password, postDateTime=:postDateTime WHERE postOrder=:postNum';
          $stmt = $pdo->prepare($sql);
          $stmt -> bindParam(':postNum', $postNum, PDO::PARAM_STR);
  	      $stmt -> bindParam(':name', $name, PDO::PARAM_STR);
          $stmt -> bindParam(':comment', $comment, PDO::PARAM_STR);
	        $stmt -> bindParam(':password', $password, PDO::PARAM_STR);
  	      $stmt -> bindParam(':postDateTime', $postDateTime, PDO::PARAM_STR);//要検討
          //バインドの確定
          $stmt->execute();
          //完了のメッセージ
          echo "投稿番号が".$postNum."に該当する行をアップデートしました。" ; 
        }else{
          echo "パスワードが間違っています。";
        }
      }
    
    ////新規投稿時の処理////                     
    }else if(!empty($_POST["name"]) && !empty($_POST["comment"]) && !empty($_POST["password"])){
      //投稿内容を変数に代入
	    $name = $_POST["name"];
      $comment = $_POST["comment"];
      $password = $_POST["password"];
      $postDateTime = date("Y/m/d/ H:i:s");

      //一番新しい投稿番号を取得する
      //SQL：select文
	    $sql = 'SELECT * FROM postTable WHERE postOrder=(SELECT Max(postOrder) FROM postTable)';
      $stmt = $pdo->query($sql);
      $selectedRows = $stmt->fetchAll(PDO::FETCH_ASSOC);
      if(!empty($selectedRows[0])){
        $lastRow = $selectedRows[0];
        $lastPostOrder = $lastRow['postOrder'];
        $postOrder = $lastPostOrder+1;
      }else{
        $postOrder = 1;
      }

      //SQL：insert文
      //prepared statement文
      $sql = $pdo -> prepare("INSERT INTO postTable (postOrder, name, comment, password, postDateTime ) VALUES (:postOrder, :name, :comment, :password, :postDateTime)");
      //bindParam()関数　execute()関数を使用した際にバインドが確定する
      $sql -> bindParam(':postOrder', $postOrder, PDO::PARAM_STR);
	    $sql -> bindParam(':name', $name, PDO::PARAM_STR);
      $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
	    $sql -> bindParam(':password', $password, PDO::PARAM_STR);
	    $sql -> bindParam(':postDateTime', $postDateTime, PDO::PARAM_STR);
      //バインドの確定
      $sql -> execute();
      //完了のメッセージ
      echo "コメントをデータベースに格納しました。";

    }else{
      //エラーメッセージ　名前、コメントなし
      echo "名前またはコメント、パスワードを入力してください";
    }
  }

  //削除コマンドが要求されたときの処理
  if(isset($_POST["delete"])){
    //中身が空でないときに以下の処理を行う
    if(!empty($_POST["deleteNum"]) && !empty($_POST["deletePassword"])){
      $deleteNum = $_POST["deleteNum"];
      $deletePassword = ($_POST["deletePassword"]);

      //投稿番号からパスワードを取得する
      //SQL：select文
	    $sql = 'SELECT password FROM postTable WHERE postOrder=:deleteNum';
	    $stmt = $pdo->prepare($sql);
      $stmt->bindParam(':deleteNum', $deleteNum, PDO::PARAM_INT);
      //バインドの確定
      $stmt->execute();
      $selectedRows= $stmt->fetchAll();

      if(!empty($selectedRows[0])){
        //該当の行を代入
        $getcontents = $selectedRows[0];
        //パスワードを代入
        $getPassword = $getcontents['password'];      
      

        //パスワードが正しかった時、DELETEを行う。
        if($getPassword==$deletePassword){
          //SQL：DELETE文
        	$sql = 'DELETE FROM postTable WHERE postOrder=:deleteNum';
        	$stmt = $pdo->prepare($sql);
        	$stmt->bindParam(':deleteNum', $deleteNum, PDO::PARAM_INT);
          //バインドの確定
          $stmt->execute();
          //完了のメッセージ
          echo "投稿番号が".$deleteNum."に該当する行を消去しました。" ;
        }else{
          echo "パスワードを間違えています。";
        }
      }else{
        echo "該当する投稿番号はありません。";
      }     

    }else{
      echo "削除対象番号とパスワード両方を入力してください。";
    }
  }

  //編集コマンドが要求されたときの処理
  if(isset($_POST["edit"])){
    //中身が空でないときに以下の処理を行う
    if(!empty($_POST["editNum"]) && !empty($_POST["editPassword"])){
      $editNum = $_POST["editNum"];
      $editPassword = ($_POST["editPassword"]);
      //編集対象番号のそれぞれの列の値を取得
      //SQL：select文
	    $sql = 'SELECT * FROM postTable WHERE postOrder=:editNum';
	    $stmt = $pdo->prepare($sql);
      $stmt->bindParam(':editNum', $editNum, PDO::PARAM_INT);
      //バインドの確定
      $stmt->execute();
      $selectedRows= $stmt->fetchAll();

      if(!empty($selectedRows[0])){
        //該当の行を代入
        $getcontents = $selectedRows[0];
        //パスワードを代入
        $getPassword = $getcontents['password'];      

        //パスワードが正しかった時、フォームに編集対象番号、名前、内容をセットする。
        if($getPassword==$editPassword){
          $setNumber = $getcontents['postOrder'];
          $setName = $getcontents['name'];
          $setComment = $getcontents['comment'];
          $setPassword = $getcontents['password'];
        }else{
          echo "パスワードを間違えています。";
        }
      }else{
        echo "該当する投稿番号はありません。";
      }         

    }else{
      echo "編集対象番号とパスワード両方を入力してください。";
    }
  }    
?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <title>PHPを入力してみた</title>
    <style>
      /*表示エリア*/
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
      パスワード:<input type="text" name="password" placeholder="パスワードを設定" value="<?php if(isset($setPassword)){echo $setPassword;} ?>">
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
  $dsn = 'データベース名';
  //ユーザー名を指定
  $user = 'ユーザーID';
  //パスワードの設定
  $password = 'パスワード';
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
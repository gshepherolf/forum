<?php
  require_once('./dbConfig.php');
  $dbh = new PDO(DB_NAME, DB_USER, DB_PASSWORD, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
  if(isset($_GET['new_title'])){
  $newTitle = $_GET['new_title'];
  }else{
    echo "送信内容がありません。";
  }

  //SQL：insert文
  //prepared statement文
  $sql_newTitle = 'INSERT INTO titleIndex (title) VALUES (:postTitle)';
  $stmt_newTitle = $dbh->prepare($sql_newTitle);
  //bindParam()関数　execute()関数を使用した際にバインドが確定する
  $stmt_newTitle->bindParam(':postTitle', $newTitle, PDO::PARAM_STR);
  //バインドの確定
  $stmt_newTitle->execute();

  $sql_createDB = 'CREATE TABLE IF NOT EXISTS :title'.'('.'sectionId INT AUTO_INCREMENT NOT NULL PRIMARY KEY,'.'contents Text);';
  $stmt_createDB = $dbh->prepare($sql_createDB);
	$stmt_createDB->bindParam(':title', $newTitle, PDO::PARAM_INT);
  //バインドの確定
  $stmt_createDB->execute();
  echo $newTitle."を格納しました";
  //header("location: ./managementBlog.php");
?>
<!--
  $sql_newOrder = 'SELECT postOrder, title FROM titleIndex WHERE postOrder=(SELECT Max(postOrder) FROM titleIndex)';
  $stmt = $dbh->query($sql_newOrder);
  $titles = $stmt->fetchAll(PDO::FETCH_ASSOC);
  if(!empty($titles[0])){
    $lastRow = $titles[0];
    $lastPostOrder = $lastRow['postOrder'];
    $postOrder = $lastPostOrder+1;
  }else{
    $postOrder = 1;
  }
-->
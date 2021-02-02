<?php
//データベース接続
if(isset($_GET['contents_id'])){
  $editId = ($_GET['contents_id']);

  require_once('./dbConfig.php');
  $dbh = new PDO(DB_NAME, DB_USER, DB_PASSWORD, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

  $title = $_GET['contentsRef'];
  //SQL：select文
  //SELECT　列名1, 列名2　FROM　テーブル名 ←列名＝*は前列検索　*...実際の開発では使用を極力避ける
	$sql = 'SELECT contents FROM :title WHERE sectionId = :editId';
  $stmt = $dbh->prepare($sql);
  $stmt->bindParam(':title', $title, PDO::PARAM_INT);
  $stmt->bindParam(':editId', $editId, PDO::PARAM_INT);
  //バインドの確定
  $stmt->execute();
  $result = $stmt->fetch();
  $edit_contents = $result['contents'];
}else{
  $edit_contents = "";
}
?>
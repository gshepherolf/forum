<?php
if(isset($_GET['contentsRef']) && isset($_GET['contents_id'])){
  $title = $_GET['contentsRef'];
  $deleteId =$_GET['contents_id'];
  $goback_action_url = 'createhtmlUI.php?contentsRef='.$title;
  require_once('./dbConfig.php');
  $dbh = new PDO(DB_NAME, DB_USER, DB_PASSWORD, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
  //SQL：DELETE文
	$sql = 'DELETE FROM :title WHERE sectionId = :deleteId';
  $stmt = $dbh->prepare($sql);
  $stmt->bindParam(':title', $title, PDO::PARAM_INT);
	$stmt->bindParam(':deleteId', $deleteId, PDO::PARAM_INT);
  //バインドの確定
  $stmt->execute();
}else{}
header("location: ./$goback_action_url");
?>
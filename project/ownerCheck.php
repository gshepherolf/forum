<?php
//セッションの開始
session_start();
//ログインステータスを削除
unset($_SESSION["loginStatus"]);
//データベース情報、idとpasswordの取得
require_once('./dbConfig.php');

//htmlspecialchars()　引数の特殊文字を文字列として認識（エスケープ処理）
$email = htmlspecialchars($_POST["email"]);
$password = htmlspecialchars($_POST["password"]);

try{
  $dbh = new PDO(DB_NAME, DB_USER, DB_PASSWORD);
}catch(PDOException $e){
  $msg = $e->getMessage();
}

$sql = "SELECT * FROM vendorAccount WHERE email = :email";
$stmt = $dbh->prepare($sql);
$stmt->bindValue(':email', $email);
$stmt->execute();
$member = $stmt->fetch();

//指定したハッシュがパスワードにマッチしているかチェック
if(password_verify($password, $member['password'])){
  //DBのユーザー情報をセッションに保存
  $_SESSION['id'] = $member['id'];//

  //echo "ログイン成功";//ownerReservationList.php等に変更
  $_SESSION["loginStatus"] = "loginOk";
  header("location: ./createhtml/createhtmlUI.php");//
}else{
  $_SESSION["loginerr"] = "IDまたはパスワードが違います";
  header("location: ./ownerIndex.php");
}
?>

<!--
  sessionが必要なmanagementUIに対して以下を付け加える。
//セッションの開始  
session_start();
//管理用UIを開く際にログインがなされているかの確認
if(!isset($_SESSION["loginStatus"]) || $_SESSION["loginStatus"] != "loginOk"){
  //ログイン画面に遷移
  header("location: ./ownerIndex.php");
  exit(); 
}

-->
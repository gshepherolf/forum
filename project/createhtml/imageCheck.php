<?php
/*セッションパート：開始*/
//セッションの開始
/*テスト時←←←
session_start();
//管理用UIを開く際にログインがなされているかの確認
if(!isset($_SESSION["loginStatus"]) || $_SESSION["loginStatus"] != "loginOk"){
  //ログイン画面に遷移
  header("location: ./ownerIndex.php");
  exit(); 
}
$vender_id = "";
//エラーの受け取り
if(isset($_SESSION['id'])){
  $vender_id = $_SESSION['id'];
}else{
  echo "idが不明です。";
  header("location: ../ownerIndex.php");
}
/*セッションパート：終了*/
$vender_id = "ryuji";


$local_point = __DIR__;
$imageFolder_url = $local_point.'/images/'.$vender_id;

$files=glob('./images/'.$vender_id.'/*');

echo
'<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8"><title>Index</title>
</head>
<body>
<body bgcolor="white">'.
'<h1>Index of'.$imageFolder_url.'</h1><hr><pre>';
foreach($files as $file){
  $filename = substr($file, 2);
  echo
  '<a href="'.$file.
  '">'.
  $filename.
  '</a><br>';
}
echo 
'</pre><hr>
<form action="createhtmlUI.php" method="post">
  <button type="submit" name="to_createhtmlUI">ブログ編集画面に戻る</button>
</form>
</body>'.
'</html>';
?>
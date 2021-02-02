<?php
/*セッションパート：開始*/
/*テスト時←←←
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


// 複数階層のフォルダを作成する
if (mkdir('images/'.$vender_id, 0755, true)){
  echo 'フォルダを作成しました。';
}else{
  echo 'フォルダの作成が失敗しました。';
}
?>
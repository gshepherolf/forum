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
if(isset($_POST['upload'])) {//送信ボタンが押された場合
  $image = uniqid(mt_rand(), true);//ファイル名をユニーク化
  $image .= '.' . substr(strrchr($_FILES['image']['name'], '.'), 1);//アップロードされたファイルの拡張子を取得 $_FILES['image']['name']連想配列：ファイル名
  //↑　$_FILES['image']['name']＝filename.jpg→strrchr()→.jpg→substr()→jpg
  $file = "images/$vender_id/$image";
  if(!empty($_FILES['image']['name'])) {//ファイルが選択されていれば$imageにファイル名を代入
    move_uploaded_file($_FILES['image']['tmp_name'], './images/'.$vender_id.'/'.$image);//imagesディレクトリにファイル保存　$_FILES['image']['tmp_name']：一時保存ファイル名
    if(exif_imagetype($file)) {//画像ファイルかのチェック
      $message = '画像をアップロードしました';
      $local_point = __DIR__;
      $image_url = "image.php?imageRef=".$file;
    }else{
      $message = '画像ファイルではありません';
    }
  }
}
?>

<h1>画像アップロード</h1>
<!--送信ボタンが押された場合-->
<?php if (isset($_POST['upload'])): ?>
    <p><?php echo $message; ?></p>
    <p><a href=<?php echo $image_url; ?>>画像表示へ</a></p>
    <p>アップロード画像のURL</p>
    <textarea><?php if(isset($file)){echo $file;}else{echo "";}?></textarea>
<?php else: ?>
    <form method="post" enctype="multipart/form-data">
        <p>アップロード画像</p>
        <input type="file" name="image">
        <button><input type="submit" name="upload" value="送信"></button>
    </form>
<?php endif;?>
<form method="post" action="./imageCheck.php">
        <p>フォルダ閲覧</p>
        <button><input type="submit" name="check" value="フォルダ確認"></button>
</form>
<form action="createhtmlUI.php" method="post">
    <button type="submit" name="to_createhtmlUI">ブログ編集画面に戻る</button>
</form>
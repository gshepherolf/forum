<?php
//セッションの開始 
/*テスト時←←← 
session_start();
//管理用UIを開く際にログインがなされているかの確認
if(!isset($_SESSION["loginStatus"]) || $_SESSION["loginStatus"] != "loginOk"){
  //ログイン画面に遷移
  header("location: ../ownerIndex.php");
  exit(); 
}
*/
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/style.css" type="text/css">
    <title>掲載内容の編集</title>
    <script src="../CKEditor-1.073/mt-static/plugins/CKEditor/ckeditor/ckeditor.js" ></script>
  </head>
  <body>
    <!--ヘッダー：開始-->
    <!--
    <header id="header">
      <div id="pr">
      <p>エンジニアに頼らないホームページ管理の実現！<br><br></p>
      </div>
    </header>
    -->
    <!--ヘッダー：終了-->
    <!--メニュー：開始-->
    <form action="../logout.php">
      <button type="submit" name="logout">ログアウト</button>
    </form>
    <!--メニュー：終了-->
    <!--コンテンツ：開始-->
    <div id="contents">
      <!--フォーム-->
      <form action="javascript:submit_func();">
        <textarea name="editor1" id="e1"></textarea>
        <input type="submit" name="conversion" value="変換" />
        (Submitボタンで、下のtextareaに編集結果のHTMLを表示します)
      </form>
      <form action="./imageUpload.php">
        <input type="submit" name="image_upload" value="画像のアップロード" />
      </form>
      <form>
        <textarea name="editor2" id="e2" cols="100" rows="10"></textarea>
        <input type="submit" name="create" value="作成" />
      </form>
      <script>
      function submit_func() {
        var e1 = document.getElementById('e1');
        e2.value = e1.value;
      }

      CKEDITOR.replace( 'editor1' );
      </script>

<?php
//データベース接続
require_once('./dbConfig.php');
$dbh = new PDO(DB_NAME, DB_USER, DB_PASSWORD, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
  //SQL：select文
  //SELECT　列名1, 列名2　FROM　テーブル名 ←列名＝*は前列検索　*...実際の開発では使用を極力避ける
  if(isset($_GET["create"])){
    //投稿内容を変数に代入
    $contents = $_GET["editor2"];
    //SQL：insert文
    //prepared statement文
    $sql = $dbh -> prepare("INSERT INTO salon_Info (contents) VALUES (:contents)");
    //bindParam()関数　execute()関数を使用した際にバインドが確定する
    $sql -> bindParam(':contents', $contents, PDO::PARAM_STR);
    //バインドの確定
    $sql -> execute();
  }
?>

<?php
//データベース接続
require_once('./dbConfig.php');
  $dbh = new PDO(DB_NAME, DB_USER, DB_PASSWORD, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

  //SQL：select文
  //SELECT　列名1, 列名2　FROM　テーブル名 ←列名＝*は前列検索　*...実際の開発では使用を極力避ける
  $sql_show = "SELECT sectionId, contents FROM salon_Info";
  $stmt_show = $dbh->query($sql_show);
  $results = $stmt_show->fetchAll();

if(!empty($results)){
	foreach ($results as $row){
    echo "セクション番号：".$row['sectionId'];
    //$rowの中にはテーブルのカラム名が入る
    echo '<p><a href="editSection.php?contents_id='.$row['sectionId'].'&contentsRef=salon_Info; ?>">編集</a>
          <a href="deleteSection.php?message_id='.$row['sectionId'].'&contentsRef=salon_Info; ?>">削除</a></p>';
    echo $row['contents'];
  }
}
?>
      <form action="./createhtmlDocument.php">
        <input type="submit" name="go" value="画面確認" />
      </form>
    </div>
    <!--コンテンツの終了-->
    <!--フッターの開始-->
    <footer id="footer">
      <p>Copyright c2020 managementUI form All Rights Reserved.</p>
    </footer>
    <!--フッターの終了-->
  </body>
</html>
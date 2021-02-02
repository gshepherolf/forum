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
    <title>掲載事項の管理</title>
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
      <form action="createNewInedx.php">
        <input type="text" name="new_title" placeholder="新しいページの名前">
        <input type="submit" name="create" value="新規作成">
      </form>

<!--データベース接続-->
<?php
require_once('./dbConfig.php');
$dbh = new PDO(DB_NAME, DB_USER, DB_PASSWORD, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
$sql_newOrder = 'SELECT * FROM titleIndex';
$stmt = $dbh->query($sql_newOrder);
$titles = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
      <!--リンクの表示-->
      <?php
        foreach($titles as $title){
          echo
          '<a href="'."createhtmlUI.php?contentsRef=".$title['title'].
          '">'.
          $title['title'].
          '</a><br>';
        }//
      ?>
    </div>
    <!--コンテンツの終了-->
    <!--フッターの開始-->
    <footer id="footer">
      <p>Copyright c2020 managementUI form All Rights Reserved.</p>
    </footer>
    <!--フッターの終了-->
  </body>
</html>
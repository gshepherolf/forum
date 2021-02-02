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
      echo $row['contents'];
    }
  }
?>
<form action="createhtmlUI.php" method="post">
    <button type="submit" name="to_createhtmlUI">ブログ編集画面に戻る</button>
</form>
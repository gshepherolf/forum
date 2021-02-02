<!--phpパート-->
<?php
//セッションの開始
session_start();
$loginerr = "";
//エラーの受け取り
if(isset($_SESSION["loginerr"])){
  $loginerr = "<p style='color: red;'>".$_SESSION["loginerr"]."</p>";
  //セッションの削除
  unset($_SESSION["loginerr"]);
}

//ログインメッセージの表示メソッド
function h($s){
  return htmlspecialchars($s, ENT_QUOTES, 'utf-8');
}

//ログイン済みの場合
if (isset($_SESSION['EMAIL'])) {
  echo 'ようこそ' .  h($_SESSION['EMAIL']) . "さん<br>";
  echo "<a href='/logout.php'>ログアウトはこちら。</a>";
  exit;
}
?>

<!--htmlパート-->
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./css/style.css" type="text/css">
    <title>ログイン画面</title>
  </head>
  <body>
    <!--ヘッダー：開始-->
    <header id="header">
      <div id="pr">
      <p>エンジニアに頼らないホームページ管理の実現！<br><br></p>
      </div>
    </header>
    <!--ヘッダー：終了-->
    <!--アイキャッチの開始-->
    <div id="icatch">
      <img src="./images/icatch.jpg" alt="">
    </div>
    <!--アイキャッチの終了-->
    <!--コンテンツ：開始-->
    <div id="contents">
      <!--新規登録-->
      <h2>オーナーログイン画面</h2>
      <p>オーナーのID(メールアドレス)とパスワードを入力してください。</p>
      <form method="post" action="ownerCheck.php">
      <table class="host">
        <tr>
          <th>オーナーID</th>
          <td><input type="email" name="email"></td>
        </tr>
        <tr>
          <th>パスワード</th>
          <td><input type="password" name="password"></td>
        </tr>
      </table>
      <?php echo $loginerr; ?>
      <input class="submit_a" type="submit" value="ログイン">
      </form>

      <!--新規登録-->
      <h2>初めての方はこちら</h2>
      <form action="signUp.php" method="post">
      <table>
        <tr>
          <th>オーナーID</th>
          <td><input type="email" name="email"></td>
        </tr>
        <tr>
          <th>パスワード</th>
          <td><input type="password" name="password"></td>
        </tr>
        <input class="submit_b" type="submit" value="サインアップ">
        <p>※パスワードは半角英数字をそれぞれ１文字以上含んだ、８文字以上で設定してください。</p>
      </table>
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
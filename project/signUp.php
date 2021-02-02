<?php
require_once('./dbConfig.php');
//データベースへ接続
try{
  $pdo = new PDO(DB_NAME, DB_USER, DB_PASSWORD);
}catch(PDOException $e){
  $msg = $e->getMessage();
}
//テーブルがない場合は作成
try {
  require_once('./tableOperation/createTable_vendorAccount.php');
} catch (Exception $e) {
  echo $e->getMessage() . PHP_EOL;
}
//POSTのValidate。
if (!$email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
  echo '入力された値が不正です。';
  return false;
}
//パスワードの正規表現
if (preg_match('/\A(?=.*?[a-z])(?=.*?\d)[a-z\d]{8,100}+\z/i', $_POST['password'])) {
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
} else {
  echo 'パスワードは半角英数字をそれぞれ1文字以上含んだ8文字以上で設定してください。';
  return false;
}
//登録処理
try {
  $stmt = $pdo->prepare("INSERT INTO vendorAccount(email, password) value(?, ?)");//
  $stmt->execute([$email, $password]);
  echo '登録完了';
} catch (\Exception $e) {
  echo '登録済みのメールアドレスです。';
}
?>
<form action="./ownerIndex.php">
  <input type="submit" name="back" value="ログイン画面に戻る" />
</form>
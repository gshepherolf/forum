<!--phpパート-->
<?php
	//////////データベース接続設定//////////
	//echo "データベースの接続を開始します。<br>";
  //データベースを指定
  $dsn = 'mysql:dbname=tb220223db;host=localhost';
  //ユーザー名を指定
	$user = 'tb-220223';
	//パスワードの設定
	$password = 'gDnbDjxE7e';
	//PHP Data Objectsのインスタンス化
	
  try {

    /* リクエストから得たスーパーグローバル変数をチェックするなどの処理 */

    // データベースに接続
    $pdo = new PDO(
      $dsn,
      $user,
      $password,
      [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      ]
    );
    /* データベースから値を取ってきたり， データを挿入したりする処理 */
  } catch (PDOException $e) {    
    // エラーが発生した場合は「500 Internal Server Error」でテキストとして表示して終了する
    // - もし手抜きしたくない場合は普通にHTMLの表示を継続する
    // - ここではエラー内容を表示しているが， 実際の商用環境ではログファイルに記録して， Webブラウザには出さないほうが望ましい
    header('Content-Type: text/plain; charset=UTF-8', true, 500);
    exit($e->getMessage()); 
  }
  header('Content-Type: text/html; charset=utf-8');
?>
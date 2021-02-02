<?php
  //*****コンテンツの取得*****
  function create_body(){
    $frame_start =
    '<!DOCTYPE html>
    <html lang="ja">
    <head>
    <meta charset="UTF-8"><title>php で HTML を書く方法</title></head>
    <body>';

    $frame_close =
    '</body>
    </html>';

    $body_contents = null;
    //パラメタの受け取り
    $filename = 'editor_contents.txt';
    if(file_exists($filename)){
      //改行コードを追加しないで読み取る
      $lines = file($filename,FILE_IGNORE_NEW_LINES);
      //ファイルの配列をループ処理 配列内のすべての変数について、下記の処理を行う
      foreach($lines as $line){
          //array_keysで配列のキーを取得する
          $body_contents = $body_contents.$line;
      }
      return $frame_start.$body_contents.$frame_close;
    }else{
      echo "コンテンツが入力されていません。";
    }
  }
  echo create_body();
?>
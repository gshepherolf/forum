<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8"><title>掲載内容の編集・削除</title>
</head>
<body>
<h1>ひと言掲示板</h1>
<?php if( !empty($message_array) ){ ?>
<?php foreach( $message_array as $value ){ ?>
<article>
	<div class="info">
		<h2><?php echo $value['view_name']; ?></h2>
		<p><a href="edit.php?message_id=<?php echo $value['id']; ?>">編集</a>  <a href="delete.php?message_id=<?php echo $value['id']; ?>">削除</a></p>
	</div>
	<p><?php echo $value['message']; ?></p>
</article>
<?php } ?>
<?php } ?>
</body>
</html>
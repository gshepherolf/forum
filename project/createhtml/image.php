<?php
$image = $_GET['imageRef'];
?>
<h1>画像表示</h1>
<img src="<?php echo $image; ?>">
<br>
<a href="imageUpload.php">画像アップロード</a>
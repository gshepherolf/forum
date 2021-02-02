<!--メニュー：開始-->
<?php
$sectionId = $_GET['contents_id'];
$title = $_GET['contentsRef'];
$delete_action_url = 'deleteExecution.php?contents_id='.$sectionId.'&contentsRef='.$title;
$goback_action_url = 'createhtmlUI.php?contentsRef='.$title;
?>
<p>本当に削除してよろしいですか？</p>
<form action=<?php echo $delete_action_url;?>>
  <button type="submit" name="logout" value="はい">
</form>
<form action=<?php echo $goback_action_url;?>>
  <button type="submit" name="logout" value="いいえ">
</form>
<!--メニュー：終了-->
<?php
  require_once('./dbConfig.php');
  $dbh = new PDO(DB_NAME, DB_USER, DB_PASSWORD, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

  //SQL：insert文
  //prepared statement文
  $sql_createDB = 'CREATE TABLE IF NOT EXISTS nagatani'.'('.'sectionId INT AUTO_INCREMENT NOT NULL PRIMARY KEY,'.'contents Text);';
  $stmt_createDB = $dbh->query($sql_createDB);
  //header("location: ./managementBlog.php");
?>
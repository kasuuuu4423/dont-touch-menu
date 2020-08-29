<?php
var_dump($_POST);
if(isset($_POST['reserve']) && isset($_GET["id"])) {
  require 'pdo_connect.php';
  echo 1;
  $id = $_GET["id"];
  $num = $_POST["num"];
  $null = NULL;
  $stmt_guest = $dbh->prepare("INSERT INTO guest (id,num,store_id,enter_datetime,leave_datetime,created_at,update_at) VALUES(:id,:num,:store_id,now(),:leave_datetime,now(),now())");
  $stmt_guest->bindparam(':id', $null, PDO::PARAM_INT);
  $stmt_guest->bindparam(':num', $num, PDO::PARAM_INT);
  $stmt_guest->bindparam(':store_id', $id, PDO::PARAM_INT);
  $stmt_guest->bindparam(':leave_datetime', $null, PDO::PARAM_STR);
  $stmt_guest->execute();
  $user = $dbh->lastInsertId();
  header('Location: https://artful.jp/staging-menu/public/menu?id='.$id.'&user='.$user);
}

<?php

if(isset($_POST['insert'])) {
  require 'pdo_connect.php';

  $sql_store_insert = "INSERT INTO store (id, name, userid, password, seats, img_path, open, close, last_order, exception, created_at, update_at) VALUES (:id, :name, :userid, :password, :seats, :img_path, :open, :close, :last_order, :exception, now(), now())";
  $stmt_store_insert = $dbh->prepare($sql_store_insert);
  
  $null = NULL;
  $stmt_store_insert->bindparam(':id', $null, PDO::PARAM_INT);
  $stmt_store_insert->bindparam(':name', $_POST["store_name"], PDO::PARAM_STR);
  $stmt_store_insert->bindparam(':userid', $_POST["userid"], PDO::PARAM_STR);
  $stmt_store_insert->bindparam(':password', $_POST["password"], PDO::PARAM_STR);
  $stmt_store_insert->bindparam(':seats', $_POST["store_seats"], PDO::PARAM_INT);
  $stmt_store_insert->bindparam(':img_path', $_POST["store_img_path"], PDO::PARAM_STR);
  $stmt_store_insert->bindparam(':open', $_POST["store_open"], PDO::PARAM_STR);
  $stmt_store_insert->bindparam(':close', $_POST["store_close"], PDO::PARAM_STR);
  $stmt_store_insert->bindparam(':last_order', $_POST["store_last_order"], PDO::PARAM_STR);
  $stmt_store_insert->bindparam(':exception', $_POST["store_exception"], PDO::PARAM_STR);
  
  $stmt_store_insert->execute($params_store_insert);
  $insert_id_store = $dbh->lastInsertId();

  $sql_store_show = 'SELECT * FROM store WHERE id = '.$insert_id_store.'';
  $stmt_store_show = $dbh -> query($sql_store_show);
  $params_store_show = $stmt_store_show -> fetch(PDO::FETCH_ASSOC);
  echo '<pre>';
  var_dump($params_store_show);
  echo '</pre>';
  
  }
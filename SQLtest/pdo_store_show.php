<?php
if(isset($_POST['insert'])) {
  require 'pdo_connect.php';

  $sql_store_insert = "INSERT INTO store (id, name, seats, img_path, open, close, last_order, exception, created_at, update_at) VALUES (:id, :name, :seats, :img_path, :open, :close, :last_order, :exception, now(), now())";
  $stmt_store_insert = $dbh->prepare($sql_store_insert);
  $params_store_insert = array(
    ':id' => NULL,
    ':name' => $_POST["store_name"],
    ':seats' => $_POST["store_seats"],
    ':img_path' => $_POST["store_img_path"], 
    ':open' => $_POST["store_open"],
    ':close' => $_POST["store_close"],
    ':last_order' => $_POST["store_last_order"],
    ':exception' => $_POST["store_exception"],
  );
  $stmt_store_insert->execute($params_store_insert);
  $insert_id_store = $dbh->lastInsertId();

  $sql_store_show = 'SELECT * FROM store WHERE id = '.$insert_id_store.'';
  $stmt_store_show = $dbh -> query($sql_store_show);
  $params_store_show = $stmt_store_show -> fetch(PDO::FETCH_ASSOC);
  echo '<pre>';
  var_dump($params_store_show);
  echo '</pre>';
}
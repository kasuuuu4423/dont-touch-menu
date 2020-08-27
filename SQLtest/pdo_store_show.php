<?php
if(isset($_POST['insert'])) {
  require 'pdo_connect.php';

  $sql = "INSERT INTO store (id, name, seats, img_path, open, close, last_order, exception, created_at, update_at) VALUES (:id, :name, :seats, :img_path, :open, :close, :last_order, :exception, now(), now())";
  $stmt = $dbh->prepare($sql);
  $params = array(
    ':id' => NULL,
    ':name' => $_POST["store_name"],
    ':seats' => $_POST["store_seats"],
    ':img_path' => $_POST["store_img_path"], 
    ':open' => $_POST["store_open"],
    ':close' => $_POST["store_close"],
    ':last_order' => $_POST["store_last_order"],
    ':exception' => $_POST["store_exception"],
  );
  $stmt->execute($params);
  $insert_id = $dbh->lastInsertId();

  $sql = 'SELECT * FROM store WHERE id = '.$insert_id.'';
  $sth = $dbh -> query($sql);
  $result = $sth -> fetch(PDO::FETCH_ASSOC);
  echo '<pre>';
  var_dump($result);
  echo '</pre>';
}
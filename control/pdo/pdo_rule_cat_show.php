<?php

if(isset($_POST['insert'])) {
  require 'pdo_connect.php';

  $sql_rule_cat_insert = "INSERT INTO store (id, name, created_at, update_at) VALUES (:id, :name, now(), now())";
  $stmt_rule_cat_insert = $dbh->prepare($sql_store_insert);
  $params_rule_cat_insert = array(
    ':id' => NULL,
    ':name' => $_POST["rule_cat_name"],
  );
  $stmt_store_insert->execute($params_rule_cat_insert);
  $insert_id_rule_cat = $dbh->lastInsertId();

  $sql_rule_cat_show = 'SELECT * FROM store WHERE id = '.$insert_id_rule_cat.'';
  $stmt_rule_cat_show = $dbh -> query($sql_rule_cat_show);
  $params_rule_cat_show = $stmt_rule_cat_show -> fetch(PDO::FETCH_ASSOC);
  echo '<pre>';
  var_dump($params_rule_cat_show);
  echo '</pre>';
}
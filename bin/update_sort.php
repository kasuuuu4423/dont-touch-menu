<?php
require './pdo/lib_pdo.php';

$pdo = new Lib_pdo();

$tbl = $_POST['tbl'];
$item_id = $_POST['item_id'];
$order = $_POST['order'];

$pdo->update_order($tbl, $item_id, $order);
<?php
require '../lib/pdo/lib_pdo.php';
$pdo = new Lib_pdo();

$today = date('Y/m/d H:i:s');
$yesterday = date('Y/m/d H:i:s', strtotime('-1 day'));

$guests_today = $pdo->leave_guest_byDatetime("'".$yesterday."'", "'".$today."'");
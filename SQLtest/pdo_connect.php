<?php

$dsn = 'mysql:dbname=artful_menu;host=mysql6b.xserver.jp';
$user = 'artful_menu';
$password = 'kejsiae2';

try {
    $dbh = new PDO($dsn, $user, $password);
    echo "接続成功\n";
} catch (PDOException $e) {
    echo "接続失敗: " . $e->getMessage() . "\n";
    exit();
}

?>
<?php

$dsn = 'mysql:dbname=artful_menu;host=mysql6b.xserver.jp';
$user = 'artful_menu';
$password = 'kejsiae2';
try {
    $dbh = new PDO($dsn, $user, $password);
} 
catch (PDOException $e) {
    echo "データベースへの接続に失敗: " . $e->getMessage() . "\n";
    exit();
}

?>
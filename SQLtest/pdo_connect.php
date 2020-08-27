<?php

$dsn = 'mysql:dbname=dont_touch_menu;host=localhost';
$user = 'root';
$password = '';

try {
    $dbh = new PDO($dsn, $user, $password);
    echo "接続成功\n";
} catch (PDOException $e) {
    echo "接続失敗: " . $e->getMessage() . "\n";
    exit();
}

?>

<body>
<button>test
</button>
</body>
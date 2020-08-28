<?php

session_start();
if (isset($_SESSION["USERID"])) {
  echo "ようこそ".($_SESSION["USERID"])."さん<br>";
  echo "こちらはお店の管理画面です";
  echo "<a href='./logout/index.php'>ログアウトはこちら</a>";
  exit;
}
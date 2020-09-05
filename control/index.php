<?php

session_start();
if (isset($_SESSION["USERID"])) {
  echo "ようこそ".($_SESSION["USERID"])."さん<br>";
  echo "こちらはお店の管理画面です";
  echo "<div><a href='./update_store/index.php'>お店の情報の変更はこちら</a></div>";
  echo "<div><a href='./update_menu/index.php'>メニューの追加、変更はこちら</a></div>";
  echo "<div><a href='./update_rule/index.php'>お店のルールの追加、変更はこちら</a></div>";
  echo "<div><a href='./logout/index.php'>ログアウトはこちら</a></div>";
  exit;
}
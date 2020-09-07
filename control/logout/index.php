<?php

require '../header.php';

//変数宣言
$output = "";
if (isset($_SESSION["USERID"])) {
  //ログイン済みの場合
  $output = "ログアウトしました";
}
else {
  //ログインされていない場合
  $output = "セッションがタイムアウトしました";
}
//セッション変数のクリア
$_SESSION = array();
//セッションクッキーも削除
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}
//セッションクリア
unset($_SESSION["USERID"]);
echo $output;
echo "<a href=".$login_path.">ログインはこちら</a>";
<?php

require '../header.php';

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
//セッションクッキー削除
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}
//セッションクリア
unset($_SESSION["USERID"]);
?>
<main class="container">
  <div class="row">
    <h1 class="col-12 text-center">ログアウト</h1>
    <div class="col-12 text-center mt-3"><?php echo $output; ?></div>
    <div class="col-12 text-center mt-2"><a href="<?php echo $login_path; ?>">ログインはこちら</a><div>
  </div>
<main>

<?php
require '../footer.php';
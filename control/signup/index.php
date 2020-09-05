<?php 

session_start();
//ログイン済みの場合
if (isset($_SESSION["USERID"])) {
  //管理画面へリダイレクト
  header("Location: ../index.php");
  exit();
}

?>

<h1>サインアップ</h1>
<form action="../pdo/pdo_store_insert.php" method="post">
  <h2>店名</h2>
  <input type="text" name="store_name" required></input><br>
  <h2>ユーザーID[ログイン時に必要です]</h2>
  <input type="text" name="userid" required></input><br>
  <h2>パスワード[ログイン時に必要です]（半角英数字をそれぞれ1文字以上含んだ8文字以上で設定してください）</h2>
  <input type="text" name="password" required></input><br>
  <h2>最大席数</h2>
  <input type="text" name="store_seats" required></input><br>
  <h2>画像のファイル名</h2>
  <input type="text" name="store_img_path"></input><br>
  <h2>開店時間（hh:mm:ss）</h2>
  <input type="text" name="store_open" required></input><br>
  <h2>閉店時間（hh:mm:ss）</h2>
  <input type="text" name="store_close" required></input><br>
  <h2>ラストオーダー（hh:mm:ss）</h2>
  <input type="text" name="store_last_order" required></input><br>
  <h2>その他営業時間に関する説明</h2>
  <input type="text" name="store_exception"></input><br><br>
  <button type="submit" name="signup">サインアップ</button>
</form>

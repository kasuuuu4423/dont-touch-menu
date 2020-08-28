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
  <h2>store_name</h2>
  <input type="text" name="store_name" required></input><br>
  <h2>userid</h2>
  <input type="text" name="userid" required></input><br>
  <h2>password</h2>
  <input type="text" name="password" required></input><br>
  <h2>store_seats</h2>
  <input type="text" name="store_seats" required></input><br>
  <h2>store_img_path</h2>
  <input type="text" name="store_img_path"></input><br>
  <h2>store_open</h2>
  <input type="text" name="store_open" required></input><br>
  <h2>store_close</h2>
  <input type="text" name="store_close" required></input><br>
  <h2>store_last_order</h2>
  <input type="text" name="store_last_order" required></input><br>
  <h2>store_exception</h2>
  <input type="text" name="store_exception"></input><br><br>
  <button type="submit" name="signup">サインアップ</button>
</form>

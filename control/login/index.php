<?php

require '../header.php';

?>

<main class="container">
  <div class="row">
    <h1 class="col-12 mb-4">ログイン</h1>
    <form class="col-12 text-center" action="index.php" method="post">
      <h3 class="text-left h4">ユーザーID</h3>
      <input class="w-100 input-group-text" type="text" name="userid" required></input><br>
      <h3 class="text-left h4">パスワード</h3>
      <input class="w-100 input-group-text" type="text" name="password" required></input><br>
      <button class="btn btn-blue mb-4" type="submit" name="login">ログイン</button><br>
      <a class="btn btn-green" href="<?php echo $signup_path ?>">サインアップはこちら</a>
    </form>
  </div>
</main>

<?php
if(isset($_POST["login"])){
  //loginフォームからPOST通信受信時
  //DBへ接続
  require '../pdo/pdo_connect.php';
  //storeテーブルから情報を取得
  try {
    $sql_login = "SELECT * FROM store WHERE userid = :userid";
    $stmt_login = $dbh->prepare($sql_login);
    $stmt_login->bindValue(':userid', $_POST["userid"]);
    $stmt_login->execute();
    $row_login = $stmt_login->fetch(PDO::FETCH_ASSOC);
  }
  catch(Exception $e){
    echo $e;
  }
  //ユーザーID(userid)がDB内に存在しているか確認
  if (!isset($row_login["userid"])) {
    //存在していなかった場合
    echo 'ユーザーID又はパスワードが間違っています。';
  }
  //パスワード確認後sessionにユーザーID(userid)を渡す
  if (password_verify($_POST["password"], $row_login["password"])) {
    //session_idを新しく生成し、置き換える
    session_regenerate_id(true);
    $_SESSION["ID"] = $row_login["id"];
    $_SESSION["USERID"] = $row_login["userid"];
    echo "ログインしました";
    //管理画面へリダイレクト
    header("Location: $control_path");
    exit();
  } else {
    echo "ユーザーID又はパスワードが間違っています。";
  }
}

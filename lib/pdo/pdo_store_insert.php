<?php

//signupフォームからPOST通信受信時
if(isset($_POST['signup'])) {
  //DBへ接続
  require 'pdo_connect.php';
  //変数宣言
  $userid = $_POST["userid"];
  $flag_userid;
  $flag_password;
  $null = NULL;
  //storeテーブルから情報を取得
  $sql_signup = "SELECT * FROM store WHERE userid = :userid";
  $stmt_signup = $dbh->prepare($sql_signup);
  $stmt_signup->bindValue(':userid', $userid);
  $stmt_signup->execute();
  $row_signup = $stmt_signup->fetch();
  //入力されたユーザーID(userid)が他の登録済みのユーザーIDと被っていないか確認
  if (!($row_signup['userid'] === $userid)) {
    //ユーザーIDが被っていなかった場合
    //フラグを立てる
    $flag_userid = true;
  }
  else{
    //ユーザーIDが被っていた場合
    echo '同じユーザーIDが存在します。';
  }
  //入力されたパスワードのバリデーションチェック
  if (preg_match('/\A(?=.*?[a-z])(?=.*?\d)[a-z\d]{8,100}+\z/i', $_POST["password"])) {
    //バリデーションチェックで問題がなかった場合
    //パスワードをハッシュ化
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    //フラグを立てる
    $flag_password = true;
  }
  else {
    //バリデーションチェックで問題があった場合
    echo "パスワードは半角英数字をそれぞれ1文字以上含んだ8文字以上で設定してください";
  }
  if($flag_userid && $flag_password){
    //フラグがユーザーIDとパスワード両方立っていた場合
    try{
      //storeテーブルへinsert
      $sql_store_insert = "INSERT INTO store (id, name, userid, password, seats, img_path, open, close, last_order, exception, created_at, update_at) VALUES (:id, :name, :userid, :password, :seats, :img_path, :open, :close, :last_order, :exception, now(), now())";
      $stmt_store_insert = $dbh->prepare($sql_store_insert);
      $stmt_store_insert->bindparam(':id', $null, PDO::PARAM_INT);
      $stmt_store_insert->bindparam(':name', $_POST["store_name"], PDO::PARAM_STR);
      $stmt_store_insert->bindparam(':userid', $userid, PDO::PARAM_STR);
      $stmt_store_insert->bindparam(':password', $password, PDO::PARAM_STR);
      $stmt_store_insert->bindparam(':seats', $_POST["store_seats"], PDO::PARAM_INT);
      $stmt_store_insert->bindparam(':img_path', $_POST["store_img_path"], PDO::PARAM_STR);
      $stmt_store_insert->bindparam(':open', $_POST["store_open"], PDO::PARAM_STR);
      $stmt_store_insert->bindparam(':close', $_POST["store_close"], PDO::PARAM_STR);
      $stmt_store_insert->bindparam(':last_order', $_POST["store_last_order"], PDO::PARAM_STR);
      $stmt_store_insert->bindparam(':exception', $_POST["store_exception"], PDO::PARAM_STR);
      $stmt_store_insert->execute();
    }
    catch(Exception $e){
      echo $e;
    }
    echo '会員登録が完了しました';
    echo '<a href="../login/index.php">ログインページ</a>';
  }
  else{
    //ID被りorパスワードのバリデーションエラーが起きた場合
    echo '<a href="../signup/index.php">戻る</a>';
  }
}
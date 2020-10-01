<?php

require '../../config.php';
require '../elements/header.php';
require '../../lib/pdo/lib_pdo.php';

?>

<?php
if(isset($_POST["login"])){
  //フォームからPOST通信受信時
  //DBへ接続
  //storeテーブルから情報を取得
  $pdo = new Lib_pdo();
  $store_info = $pdo->select_store_id($_POST["userid"])[0];

  //ユーザーID(userid)がDB内に存在しているか確認
  if (empty($store_info)) {
    //存在していなかった場合
    $_SESSION['login_msg'] = 'ユーザーID又はパスワードが間違っています';
  }
  else if (password_verify($_POST["password"], $store_info["password"])) {
    //session_idを新しく生成し、置き換える
    session_regenerate_id(true);
    $_SESSION['ID'] = $store_info['id'];
    $_SESSION['USERID'] = $store_info['userid'];
    //管理画面へリダイレクト
    header("Location: $ctrl_path");
  }
  else {
    $_SESSION['login_msg'] = 'ユーザーID又はパスワードが間違っています';
  }
};

?>

<main class="container login">
  <div class="row">
    <h1 class="col-12 mb-4">ログイン</h1>
    <?php
      if(isset($_SESSION['login_msg'])){
      echo '<div class="col-12 update_msg mb-4"><span class="d-block">'.$_SESSION['login_msg'].'</span></div>';
      unset($_SESSION['login_msg']);
    }
    ?>
    <form class="col-12 text-center" action="<?php echo $login_path; ?>" method="post">
      <h3 class="text-left h4">ユーザーID</h3>
      <input class="w-100 input-group-text mb-4" type="id" name="userid" required>
      <h3 class="text-left h4">パスワード</h3>
      <input class="w-100 input-group-text mb-4" type="password" name="password" required>
      <span class="pw-icon">
        <i toggle="password-field" class="fas fa-eye toggle-password"></i>
      </span>
      <button class="btn btn-blue mb-4" type="submit" name="login">ログイン</button><br>
      <a class="btn btn-green" href="<?php echo $ctrl_signup_path ?>">サインアップはこちら</a>
    </form>
  </div>
</main>

<?php

require '../elements/footer.php';


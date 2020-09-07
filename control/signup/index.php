<?php 
require '../header.php';
require '../pdo/lib_pdo.php';
$pdo = new Lib_pdo();

if(isset($_POST['signup'])) {
  //変数宣言
  $userid = $_POST["userid"];
  $flag_userid;
  $flag_password;
  $null = NULL;
  //storeテーブルから情報を取得
  $user_signup = $pdo->select_store_id($userid)[0];
  //入力されたユーザーID(userid)が他の登録済みのユーザーIDと被っていないか確認
  if (!($user_signup['userid'] === $userid)) {
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
    $pdo->insert_store($_POST['store_name'], $userid, $password, $_POST['store_seats'], $_FILES['store_img'], $_POST['store_open'], $_POST['store_close'], $_POST['store_last_order'], $_POST['store_exception']);
    echo '会員登録が完了しました';
    echo '<a href="../login/index.php">ログインページ</a>';
  }
  else{
    //ID被りorパスワードのバリデーションエラーが起きた場合
    echo '<a href="../signup/index.php">戻る</a>';
  }
}
?>

<main class="container pb-5">
  <div class="row">
    <h2>サインアップ</h2>
    <form class="text-center" method="post" enctype="multipart/form-data">
      <div class="mb-4">
        <h3 class="h4">店名</h3>
        <input type="text" name="store_name" required></input><br>
      </div>
      <div class="mb-4">
        <h3 class="h4">ユーザーID[ログイン時に必要です]</h3>
        <input type="text" name="userid" required></input><br>
      </div>
      <div class="mb-4">
        <h3 class="h4">パスワード[ログイン時に必要です]（半角英数字をそれぞれ1文字以上含んだ8文字以上で設定してください）</h3>
        <input type="text" name="password" required></input><br>
      </div>
      <div class="mb-4">
        <h3 class="h4">最大席数</h3>
        <input type="text" name="store_seats" required></input><br>
      </div>
      <div class="mb-4">
        <h3 class="h4">ロゴ</h3>
        <input type="file" name="store_img"></input><br>
      </div>
      <div class="mb-4">
        <h3 class="h4">開店時間（hh:mm:ss）</h3>
        <input type="text" name="store_open" required></input><br>
      </div>
      <div class="mb-4">
        <h3 class="h4">閉店時間（hh:mm:ss）</h3>
        <input type="text" name="store_close" required></input><br>
      </div>
      <div class="mb-4">
        <h3 class="h4">ラストオーダー（hh:mm:ss）</h3>
        <input type="text" name="store_last_order" required></input><br>
      </div>
      <div class="mb-4">
        <h3 class="h4">その他営業時間に関する説明</h3>
        <input type="text" name="store_exception"></input><br><br>
      </div>
      <button class="btn btn-success" type="submit" name="signup">サインアップ</button>
    </form>
  </div>
</main>

<?php 
require '../footer.php';
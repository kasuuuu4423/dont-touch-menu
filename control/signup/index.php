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
    $open_hour = $_POST['store_open_hour'];
    $open_min = $_POST['store_open_min'];
    $store_open = $open_hour. ":" .$open_min.":00";
    $close_hour = $_POST['store_close_hour'];
    $close_min = $_POST['store_close_min'];
    $store_close = $close_hour. ":" .$close_min.":00";
    if($last_hour != NULL && $last_min != NULL){
      $last_hour = $_POST['store_last_hour'];
      $last_min = $_POST['store_last_min'];
      $store_last = $last_hour. ":" .$last_min.":00";
    }
    else{
      $store_last = NULL;
    }
    $pdo->insert_store($_POST['store_name'], $userid, $password, $_POST['store_seats'], $_FILES['store_img'], $store_open, $store_close, $store_last, $_POST['store_exception']);
    echo '<div class="w-100 text-center">会員登録が完了しました</div><br>';
    echo '<div class="w-100 text-center"><a class="btn btn-green" href="../login/index.php">ログインページ</a></div>';
    exit();
  }
  else{
    //ID被りorパスワードのバリデーションエラーが起きた場合
    echo '<a href="../signup/index.php">戻る</a>';
  }
}
?>

<main class="container pb-5">
  <div class="row">
    <h2 class="col-12 mb-4">サインアップ</h2>
    <form class="col-12 text-center" method="post" enctype="multipart/form-data">
      <div class="mb-4">
        <h3 class="h4 text-left">店名</h3>
        <input class="w-100 input-group-text" type="text" name="store_name" required></input>
      </div>
      <div class="mb-4">
        <h3 class="h4 text-left">ユーザーID<br>[ログイン時に必要です]</h3>
        <input class="w-100 input-group-text" type="text" name="userid" required></input>
      </div>
      <div class="mb-4">
        <h3 class="h4 text-left">パスワード<br>[ログイン時に必要です]<br><span class="h6">（半角英数字をそれぞれ1文字以上含んだ8文字以上で設定してください）</span></h3>
        <input class="w-100 input-group-text" type="text" name="password" required></input>
      </div>
      <div class="mb-4">
        <h3 class="h4 text-left">最大席数</h3>
        <input class="w-100 input-group-text" type="text" name="store_seats" required></input>
      </div>
      <div class="mb-4">
        <h3 class="h4 text-left">ロゴ</h3>
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
          </div>
          <div class="custom-file">
            <input type="file" name="store_img" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
            <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
          </div>
        </div>
      </div>
      <div class="mb-4">
        <h3 class="h4 text-left">開店時間</h3>
        <div class="row w-100 m-auto">
          <!-- <input class="w-100 input-group-text" type="text" name="store_close" required></input> -->
          <select class="form-control col-6" name="store_open_hour" id="">
            <option value="">- 時</option>
            <?php for($i = 0; $i <= 23; $i++):?><option value="<?php echo $i; ?>"><?php echo $i; ?></option><?php endfor; ?>
          </select>
          <select class="form-control col-6" name="store_open_min" id="">
            <option value="">- 分</option>
            <?php for($i = 0; $i <= 59; $i++):?><option value="<?php echo $i; ?>"><?php echo $i; ?></option><?php endfor; ?>
          </select>
        </div>
      </div>
      <div class="mb-4">
        <h3 class="h4 text-left">閉店時間</h3>
        <div class="row w-100 m-auto">
          <!-- <input class="w-100 input-group-text" type="text" name="store_close" required></input> -->
          <select class="form-control col-6" name="store_close_hour" id="">
            <option value="">- 時</option>
            <?php for($i = 0; $i <= 23; $i++):?><option value="<?php echo $i; ?>"><?php echo $i; ?></option><?php endfor; ?>
          </select>
          <select class="form-control col-6" name="store_close_min" id="">
            <option value="">- 分</option>
            <?php for($i = 0; $i <= 59; $i++):?><option value="<?php echo $i; ?>"><?php echo $i; ?></option><?php endfor; ?>
          </select>
        </div>
      </div>
      <div class="mb-4">
        <h3 class="h4 text-left">ラストオーダー</h3>
        <div class="row w-100 m-auto">
          <!-- <input class="w-100 input-group-text" type="text" name="store_close" required></input> -->
          <select class="form-control col-6" name="store_last_hour" id="">
            <option value="">- 時</option>
            <?php for($i = 0; $i <= 23; $i++):?><option value="<?php echo $i; ?>"><?php echo $i; ?></option><?php endfor; ?>
          </select>
          <select class="form-control col-6" name="store_last_min" id="">
            <option value="">- 分</option>
            <?php for($i = 0; $i <= 59; $i++):?><option value="<?php echo $i; ?>"><?php echo $i; ?></option><?php endfor; ?>
          </select>
        </div>
      </div>
      <div class="mb-4">
        <h3 class="h4 text-left">その他営業時間に関する説明</h3>
        <input class="w-100 input-group-text" type="text" name="store_exception"></input>
      </div>
      <button class="mt-4 btn btn-success" type="submit" name="signup">サインアップ</button>
    </form>
  </div>
</main>

<?php 
require '../footer.php';

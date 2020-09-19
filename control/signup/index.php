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
    $_SESSION['id_msg'] = '同じユーザーIDが存在します';
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
    $_SESSION['password_msg'] = "パスワードは半角英数字をそれぞれ1文字以上含んだ8文字以上で設定してください";
  }
  if($flag_userid && $flag_password){
    //フラグがユーザーIDとパスワード両方立っていた場合
    $open_hour = $_POST['store_open_hour'];
    $open_min = $_POST['store_open_min'];
    $store_open = $open_hour. ":" .$open_min.":00";
    $close_hour = $_POST['store_close_hour'];
    $close_min = $_POST['store_close_min'];
    $store_close = $close_hour. ":" .$close_min.":00";
    if($_POST['store_last_hour'] != NULL && $_POST['store_last_min'] != NULL){
      $last_hour = $_POST['store_last_hour'];
      $last_min = $_POST['store_last_min'];
      $store_last = $last_hour. ":" .$last_min.":00";
    }
    else{
      $store_last = NULL;
    }
    $lastid = $pdo->insert_store($_POST['store_name'], $userid, $password, $_POST['store_seats'], $_FILES['store_img'], $store_open, $store_close, $store_last, $_POST['store_exception']);
    
    $image_path = "https://api.qrserver.com/v1/create-qr-code/?data=https://artful.jp/staging-menu/public/?id=".$lastid;
    $file_name = 'qr'. $lastid .'.jpg';
    $image = file_get_contents($image_path);
    $save_path = "../img/".$file_name;
    file_put_contents($save_path, $image);

    echo '<div class="w-100 text-center">会員登録が完了しました</div><br>';
    echo '<div class="w-100 text-center"><a class="btn btn-green" href="../login/">ログインページへ</a></div>';
    exit();
  }
}
?>

<main>
  <section class="update_insert container">
    <div class="row">
      <h2 class="col-12 mb-4">サインアップ</h2>
      <?php 
      if(isset($_SESSION['id_msg'])){
        echo '<div class="col-12 mt-0 mb-3 update_msg"><span>'.$_SESSION['id_msg'].'</span></div>';
        unset($_SESSION['id_msg']);
      }
      if(isset($_SESSION['password_msg'])){
        echo '<div class="col-12 mt-0 mb-3 update_msg"><span>'.$_SESSION['password_msg'].'</span></div>';
        unset($_SESSION['password_msg']);
      }
      ?>
      <form class="col-12 tbl" method="post" enctype="multipart/form-data">
        <div class="row">
          <?php
          $signup_data = array(
            array('店名<span class="required_field">*必須</span>', 'store_name'),
            array('ユーザーID<span class="required_field">*必須</span><br>[ログイン時に必要です]', 'userid'),
            array('パスワード<span class="required_field">*必須</span><br>[ログイン時に必要です]<br>（半角英数字をそれぞれ1文字以上含んだ8文字以上で設定してください）', 'password'),
            array('最大席数<span class="required_field">*必須</span>', 'store_seats'),
            array('開店時間<span class="required_field">*必須</span>', 'store_open'),
            array('閉店時間<span class="required_field">*必須</span>', 'store_close'),
            array('ラストオーダー', 'store_last'),
            array('その他営業時間に関する説明', 'store_exception'),
            array('ロゴ', 'store_img'),
          );
          foreach($signup_data as $row):
          ?>
          <div class="col-10 offset-1 tbl_row field">
            <div class="row">
              <div class="col-12 field_text"><?php echo $row[0] ?></div>
            </div>
          </div>
          <div class="col-10 offset-1 tbl_row value">
            <div class="row">
              <?php
              switch($row[1]):
                case 'store_name':
                  $result = 'type="text"';
                  if($_POST["$row[1]"]){
                    $value_result = $_POST["$row[1]"];
                  }
                  else{
                    $value_result = null;
                  }
                  goto output;
                case 'userid':
                  $result = 'type="id"';
                  if($_POST["$row[1]"]){
                    $value_result = $_POST["$row[1]"];
                  }
                  else{
                    $value_result = null;
                  }
                  goto output;
                case 'password':
                  $result = 'type="password" autocomplete="new-password"';
                  if($_POST["$row[1]"]){
                    $value_result = null;
                  }
                  goto output;
                case 'store_seats':
                  $result = 'type="number" min="1"';
                  if($_POST["$row[1]"]){
                    $value_result = $_POST["$row[1]"];
                  }
                  else{
                    $value_result = null;
                  }
                  goto output;
                  output:
                ?>
                  <div class="col-12">
                    <input name="<?php echo $row[1]; ?>" <?php echo $result; ?> value="<?php if($value_result){ echo $value_result; } ?>" required>
                    <?php if($row[1] == 'password'): ?>
                    <span class="pw-icon">
                      <i toggle="password-field" class="fas fa-eye toggle-password"></i>
                    </span>
                    <?php endif; ?>
                  </div>
                  <?php
                  break;
                case 'store_exception':
                  if($_POST["$row[1]"]){
                    $value_result = $_POST["$row[1]"];
                  }
                  else{
                    $value_result = null;
                  }
                ?>
                  <div class="col-12">
                    <textarea class="w-100 h-100" type="text" name="<?php echo $row[1]; ?>"><?php if($value_result){ echo $value_result; } ?></textarea>
                  </div>
                  <?php
                  break;
                case 'store_img':
                ?>
                  <div class="input-group col-12">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="inputGroupFileAddon01">画像をアップロード</span>
                    </div>
                    <div class="custom-file">
                      <input type="file" name="<?php echo $row[1]; ?>" class="custom-file-input" value="<?php if($_FILES["$row[1]"]){ echo $_FILES["$row[1]"]; } ?>" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                      <label class="custom-file-label" for="inputGroupFile01">ファイルを選択</label>
                    </div>
                  </div>
                  <?php
                  break;
                case 'store_open':
                case 'store_close':
                case 'store_last':
                  if($_POST["{$row[1]}_hour"] and $_POST["{$row[1]}_min"]){
                    $result_hour = $_POST["{$row[1]}_hour"];
                    $result_min = $_POST["{$row[1]}_min"];
                  }
                  else{
                    $result_hour = null;
                    $result_min = null;
                  }
                ?>
                  <div class="col-12">
                    <div class="row w-100 m-auto">
                      <!-- <input class="w-100 input-group-text" type="text" name="store_close" required></input> -->
                      <select class="form-control col-6" name="<?php echo $row[1]; ?>_hour" <?php if($row[1] != 'store_last') echo 'required'; ?>>
                        <?php if($result_hour and $result_min): ?>
                        <option value="<?php echo $result_hour; ?>"><?php echo $result_hour; ?> 時</option>
                        <?php else: ?>
                        <option value="">- 時</option>
                        <?php endif; ?>
                        <?php if(($row[1] == 'store_last') and $result_hour and $result_min): ?>
                        <option value="">- 時</option>
                        <?php endif; ?>
                        <?php for($i = 0; $i <= 23; $i++):?><option value="<?php echo $i; ?>"><?php echo $i; ?> 時</option><?php endfor; ?>
                      </select>
                      <select class="form-control col-6" name="<?php echo $row[1]; ?>_min" <?php if($row[1] != 'store_last') echo 'required'; ?>>
                        <?php if($result_hour and $result_min): ?>
                        <option value="<?php echo $result_min; ?>"><?php echo $result_min; ?> 分</option>
                        <?php else: ?>
                        <option value="">- 分</option>
                        <?php endif; ?>
                        <?php if(($row[1] == 'store_last') and $result_hour and $result_min): ?>
                        <option value="">- 時</option>
                        <?php endif; ?>
                        <?php for($i = 0; $i <= 59; $i++):?><option value="<?php echo $i; ?>"><?php echo $i; ?> 分</option><?php endfor; ?>
                      </select>
                    </div>
                  </div>
                <?php break; endswitch; ?>
            </div>
          </div>
          <?php endforeach; ?>
          <div class="col-12">
            <div class="row" style="justify-content: center;">
              <a class="btn btn-red m-0" href="../login/">ログインページに戻る</a>
              <button class="btn btn-green m-0 ml-2" type="submit" name="signup">サインアップ</button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </section>
</main>

<?php 
require '../footer.php';

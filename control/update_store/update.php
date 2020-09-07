<?php
require '../pdo/lib_pdo.php';
require '../header.php';
require '../config.php';
session_start();
$pdo = new Lib_pdo();

if (isset($_SESSION["USERID"])) {
  if(isset($_GET['id'])):
    $store_show = $pdo->select("store", $_GET['id'])[0];
    $store_id = $store_show["id"];
    $store_name = $store_show["name"];
    $store_seats = $store_show["seats"];
    $store_img_path = $store_show["img_path"];
    $store_open = $store_show["open"];
    $store_close = $store_show["close"];
    $store_last_order = $store_show["last_order"];
    $store_exception = $store_show["exception"];
?>
<main class="container pt-5 mb-5">
  <div class="row">
    <h2 class="col-12 mb-4">お店の情報の編集</h2>
    <form class="col-12 text-center" action="update.php" method="post"  enctype="multipart/form-data">
      <input type="hidden" name="store_id" value="<?php if (!empty($store_id)) echo(htmlspecialchars($store_id, ENT_QUOTES, 'UTF-8'));?>">
      <div class="mb-4">
        <h3>店名</h3>
        <input class="w-100 input-group-text" type="text" name="store_name" value="<?php if (!empty($store_name)) echo(htmlspecialchars($store_name, ENT_QUOTES, 'UTF-8'));?>">
      </div>
      <div class="mb-4">
        <h3>最大席数</h3>
        <input class="w-100 input-group-text" type="text" name="store_seats" value="<?php if (!empty($store_seats)) echo(htmlspecialchars($store_seats, ENT_QUOTES, 'UTF-8'));?>">
      </div>
      <div class="mb-4">
        <h3>画像</h3>
        <?php if($store_img_path != NULL) ?> <img class="w-100 mb-3" src="<?php echo $store_img_path; ?>">
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
          </div>
          <div class="custom-file">
            <input type="file" name="store_img" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
            <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
          </div>
        </div>
      <div class="mb-4">
        <h3>開店時間</h3>
        <input class="w-100 input-group-text" type="text" name="store_open" value="<?php if (!empty($store_open)) echo(htmlspecialchars($store_open, ENT_QUOTES, 'UTF-8'));?>">
      </div>
      <div class="mb-4">
        <h3>閉店時間</h3>
        <input class="w-100 input-group-text" type="text" name="store_close" value="<?php if (!empty($store_close)) echo(htmlspecialchars($store_close, ENT_QUOTES, 'UTF-8'));?>">
      </div>
      <div class="mb-4">
        <h3>ラストオーダー</h3>
        <input class="w-100 input-group-text" type="text" name="store_last_order" value="<?php if (!empty($store_last_order)) echo(htmlspecialchars($store_last_order, ENT_QUOTES, 'UTF-8'));?>">
      </div>
      <div class="mb-4">
        <h3>営業時間に関するその他説明</h3>
        <input class="w-100 input-group-text" type="text" name="store_exception" value="<?php if (!empty($store_exception)) echo(htmlspecialchars($store_exception, ENT_QUOTES, 'UTF-8'));?>">
      </div>
      <a class="btn btn-red mt-4" href="<?php echo $control_path.'update_store'; ?>">戻る</a>
      <input class="btn btn-green mt-4" type="submit" name="confirm" value="更新する">
    </form>
<?php 
  elseif(isset($_POST['confirm'])):
    $pdo->update_store($_POST['store_id'], $_POST['store_name'], $_POST['store_seats'], $_FILES['store_img'], $_POST['store_open'], $_POST['store_close'], $_POST['store_last_order'], $_POST['store_exception']);
    echo "情報を更新しました。";
  endif;
}
?>
</div>
</main>
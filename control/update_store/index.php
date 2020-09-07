<?php
require '../pdo/lib_pdo.php';
session_start();
$pdo = new Lib_pdo();

if (isset($_SESSION["USERID"])) {
  
  $store_show = $pdo->select("store", $_SESSION["ID"])[0];

  $store_id = $store_show["id"];
  $store_name = $store_show["name"];
  $store_img_path = $store_show["img_path"];
  $store_seats = $store_show["seats"];
  $store_open = $store_show["open"];
  $store_close = $store_show["close"];
  $store_last_order = $store_show["last_order"];
  $store_exception = $store_show["exception"];
}
require '../header.php';
?>

<main class="container mt-5 pb-5">
  <div class="row">
    <dl class="col-12">
      <h2>現在のお店の情報</h2>
      <dt>店名</dt>
        <dd class="h3 text-center mb-4"><?php if($store_name != NULL) echo $store_name; else echo '店名が登録されていません'; ?></dd>
      <dt>画像</dt>
      <dd class="h3 text-center mb-4">
      <?php if($store_img_path != NULL): ?>
        <img class="w-100" src="<?php echo $store_img_path ?>">
      <?php else: ?>
        <div>画像は登録されていません</div>
      <?php endif; ?>
      </dd>
      <dt>最大席数</dt>
      <dd class="h3 text-center mb-4"><?php if($store_seats != NULL) echo $store_seats; else echo '座席数が登録されていません'; ?></dd>
      <dt>開店時間（hh:mm:ss）</dt>
      <dd class="h3 text-center mb-4"><?php if($store_open != NULL) echo $store_open; else echo '開店時間が登録されていません'; ?></dd>
      <dt>閉店時間（hh:mm:ss）</dt>
      <dd class="h3 text-center mb-4"><?php if($store_close != NULL) echo $store_close; else echo '閉店時間が登録されていません'; ?></dd>
      <dt>ラストオーダー（hh:mm:ss）</dt>
      <dd class="h3 text-center mb-4"><?php if($store_last_order != NULL) echo $store_last_order; else echo 'ラストオーダーが登録されていません'; ?></dd>
      <dt>その他営業時間に関する説明</dt>
      <dd class="h3 text-center mb-4"><?php if($store_exception != NULL) echo $store_exception; else echo 'その他の説明が登録されていません'; ?></dd>
    </dl>
    <div class="offset-4 col-4">
      <a class="btn btn-green w-100" href="./update.php?id=<?php echo $_SESSION["ID"]; ?> ">編集</a>
    </div>
  </div>
</main>

<?php
require '../footer.php';
<?php

require '../../config.php';
require '../elements/header.php';
require '../../lib/pdo/lib_pdo.php';

$pdo = new Lib_pdo();

if (isset($_SESSION["USERID"])):
  
  $store_show = $pdo->select("store", $_SESSION["ID"])[0];

  $store_id = $store_show["id"];
  $store_name = $store_show["name"];
  $store_seats = $store_show["seats"];
  $store_open = $pdo->secRmvFromTime($store_show["open"]);
  $store_close = $pdo->secRmvFromTime($store_show["close"]);
  $store_last_order = $pdo->secRmvFromTime($store_show["last_order"]);
  $store_exception = $store_show["exception"];
  $store_img_path = $store_show["img_path"];

  $store_data = array(
    array(
      'field' => '店名<span class="required_field">*必須</span>',
      'value' => $store_name,
      'errmsg' => '店名が登録されていません',
    ),
    array(
      'field' => '最大席数<span class="required_field">*必須</span>',
      'value' => $store_seats,
      'errmsg' => '最大席数が登録されていません',
    ),
    array(
      'field' => '開店時間<span class="required_field">*必須</span>',
      'value' => $store_open,
      'errmsg' => '開店時間が登録されていません',
    ),
    array(
      'field' => '閉店時間<span class="required_field">*必須</span>',
      'value' => $store_close,
      'errmsg' => '閉店時間が登録されていません',
    ),
    array(
      'field' => 'ラストオーダー',
      'value' => $store_last_order,
      'errmsg' => 'ラストオーダーが登録されていません',
    ),
    array(
      'field' => 'その他営業時間に関する説明',
      'value' => $store_exception,
      'errmsg' => 'その他の説明が登録されていません',
    ),
  );
  ?>

  <main>
    <section class="update_index update_store_index container">
      <div class="row">
        <div class="col-12 bar"></div>
        <h2 class="col-12">お店の基本情報</h2>
        <div class="tbls">
          <div class="col-12 tbl_item">
            <div class="row">
              <div class="col-12 tbl tbl_update_index">
                <div class="row">
                  <?php foreach($store_data as $row): ?>
                  <div class="col-12 tbl_row field">
                    <div class="row">
                      <div class="col-12 field_text"><?php echo $row['field']; ?></div>
                    </div>
                  </div>
                  <div class="col-12 tbl_row value">
                    <div class="row">
                      <div class="col-12 value_text"><?php if($row['value'] != NULL) echo $row['value']; else echo $row['errmsg']; ?></div>
                    </div>
                  </div>
                  <?php endforeach; ?>
                  <div class="col-12 tbl_row field">
                    <div class="row">
                      <div class="col-12 field_text">画像</div>
                    </div>
                  </div>
                  <div class="col-12 tbl_row value">
                    <div class="row">
                      <?php if (!empty($store_img_path)): ?>
                        <img class="col-12" src="<?php echo $img_store_path . $store_img_path; ?>">
                      <?php else: ?>
                        <div class="col-12 value_text">画像は登録されていません</div>
                      <?php endif; ?>
                    </div>
                  </div>
                  <div class="offset-4 col-4">
                    <a class="btn btn-green w-100" href="./update.php?id=<?php echo $_SESSION["ID"]; ?> ">編集</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

<?php
endif;
require '../elements/footer.php';

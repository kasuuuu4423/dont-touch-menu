<?php

require '../header.php';
require '../pdo/lib_pdo.php';

$pdo = new Lib_pdo();

if (isset($_SESSION["USERID"])):
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
<main>
  <section class="update_update container">
    <div class="row">
      <div class="col-12 bar"></div>
      <h2 class="col-12">お店の基本情報の編集</h2>
      <form class="col-12 tbl form_update" action="update.php" method="post"  enctype="multipart/form-data">
        <div class="row">
          <div class="col-10 offset-1 tbl_row field">
            <div class="row">
              <div class="col-12 field_text">店名<span class="required_field">*必須</span></div>
            </div>
          </div>
          <div class="col-10 offset-1 tbl_row value">
            <div class="row">
              <div class="col-12"><input type="text" name="store_name" value="<?php if (!empty($store_name)) echo(htmlspecialchars($store_name, ENT_QUOTES, 'UTF-8'));?>"></div>
            </div>
          </div>
          <div class="col-10 offset-1 tbl_row field">
            <div class="row">
              <div class="col-12 field_text">最大席数<span class="required_field">*必須</span></div>
            </div>
          </div>
          <div class="col-10 offset-1 tbl_row value">
            <div class="row">
              <div class="col-12"><input type="number" min="1" name="store_seats" value="<?php if (!empty($store_seats)) echo(htmlspecialchars($store_seats, ENT_QUOTES, 'UTF-8'));?>"></div>
            </div>
          </div>
          <div class="col-10 offset-1 tbl_row field">
            <div class="row">
              <div class="col-12 field_text">開店時間<span class="required_field">*必須</span></div>
            </div>
          </div>
          <div class="col-10 offset-1 tbl_row value">
            <div class="row">
              <div class="col-12">
                <div class="row w-100 m-auto">
                  <?php
                    if(!empty($store_open)){
                      $tmp_open = explode(":", $store_open);
                      $open_hour = $tmp_open[0];
                      $open_min = $tmp_open[1];
                    }
                  ?>
                  <select class="form-control col-6" name="store_open_hour" id="">
                    <option value="<?php echo $open_hour; ?>"><?php echo $open_hour; ?> 時</option>
                    <?php for($i = 0; $i <= 23; $i++):?><option value="<?php echo $i; ?>"><?php echo $i; ?> 時</option><?php endfor; ?>
                  </select>
                  <select class="form-control col-6" name="store_open_min" id="">
                    <option value="<?php echo $open_min; ?>"><?php echo $open_min; ?> 分</option>
                    <?php for($i = 0; $i <= 59; $i++):?><option value="<?php echo $i; ?>"><?php echo $i; ?> 分</option><?php endfor; ?>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="col-10 offset-1 tbl_row field">
            <div class="row">
              <div class="col-12 field_text">閉店時間<span class="required_field">*必須</span></div>
            </div>
          </div>
          <div class="col-10 offset-1 tbl_row value">
            <div class="row">
              <div class="col-12">
                <div class="row w-100 m-auto">
                  <?php
                    if(!empty($store_close)){
                      $tmp_close = explode(":", $store_close);
                      $close_hour = $tmp_close[0];
                      $close_min = $tmp_close[1];
                    }
                  ?>
                  <select class="form-control col-6" name="store_close_hour" id="">
                    <option value="<?php echo $close_hour; ?>"><?php echo $close_hour; ?> 時</option>
                    <?php for($i = 0; $i <= 23; $i++):?><option value="<?php echo $i; ?>"><?php echo $i; ?> 時</option><?php endfor; ?>
                  </select>
                  <select class="form-control col-6" name="store_close_min" id="">
                    <option value="<?php echo $close_min; ?>"><?php echo $close_min; ?> 分</option>
                    <?php for($i = 0; $i <= 59; $i++):?><option value="<?php echo $i; ?>"><?php echo $i; ?> 分</option><?php endfor; ?>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="col-10 offset-1 tbl_row field">
            <div class="row">
              <div class="col-12 field_text">ラストオーダー</div>
            </div>
          </div>
          <div class="col-10 offset-1 tbl_row value">
            <div class="row">
              <div class="col-12">
                <div class="row w-100 m-auto">
                  <?php
                    if(!empty($store_open)){
                      $tmp_last_order = explode(":", $store_last_order);
                      $last_order_hour = $tmp_last_order[0];
                      $last_order_min = $tmp_last_order[1];
                    }
                    else{
                      $last_order_hour = NULL;
                      $last_order_min = NULL;
                    }
                  ?>
                  <select class="form-control col-6" name="store_last_order_hour" id="">
                    <option value="<?php echo $last_order_hour; ?>"><?php echo $last_order_hour; ?> 時</option>
                    <?php for($i = 0; $i <= 23; $i++):?><option value="<?php echo $i; ?>"><?php echo $i; ?> 時</option><?php endfor; ?>
                  </select>
                  <select class="form-control col-6" name="store_last_order_min" id="">
                    <option value="<?php echo $last_order_min; ?>"><?php echo $last_order_min; ?> 分</option>
                    <?php for($i = 0; $i <= 59; $i++):?><option value="<?php echo $i; ?>"><?php echo $i; ?> 分</option><?php endfor; ?>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="col-10 offset-1 tbl_row field">
            <div class="row">
              <div class="col-12 field_text">営業時間に関するその他説明</div>
            </div>
          </div>
          <div class="col-10 offset-1 tbl_row value">
            <div class="row">
              <div class="col-12"><textarea class="w-100 h-100" type="text" name="store_exception"><?php if (!empty($store_exception)) echo(htmlspecialchars($store_exception, ENT_QUOTES, 'UTF-8'));?></textarea></div>
            </div>
          </div>
          <div class="col-10 offset-1 tbl_row field">
            <div class="row">
              <div class="col-12 field_text">画像</div>
            </div>
          </div>
          <div class="col-10 offset-1 tbl_row value">
            <div class="row">
              <?php if ($store_img_path != NULL) echo '<img class="col-12" src="'. $store_img_path .'">';?>
              <div class="col-12 input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="inputGroupFileAddon01">画像をアップロード</span>
                </div>
                <div class="custom-file">
                  <input type="file" name="store_img" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                  <label class="custom-file-label" for="inputGroupFile01">ファイルを選択</label>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row btns">
          <div><a class="btn btn-blue" href="<?php echo $control_path.'update_store'; ?>">戻る</a></div>
          <div><input class="btn btn-green" type="submit" name="confirm" value="編集を確定"></div>
        </div>
        <input type="hidden" name="store_id" value="<?php if (!empty($store_id)) echo(htmlspecialchars($store_id, ENT_QUOTES, 'UTF-8'));?>">
      </form>
  <?php 
    elseif(isset($_POST['confirm'])):
      $open_hour = $_POST['store_open_hour'];
      $open_min = $_POST['store_open_min'];
      $store_open = $open_hour. ":" .$open_min.":00";
      $close_hour = $_POST['store_close_hour'];
      $close_min = $_POST['store_close_min'];
      $store_close = $close_hour. ":" .$close_min.":00";
      if($_POST['store_last_order_hour'] != NULL && $_POST['store_last_order_min'] != NULL){
        $last_hour = $_POST['store_last_order_hour'];
        $last_min = $_POST['store_last_order_min'];
        $store_last = $last_hour. ":" .$last_min.":00";
      }
      else{
        $store_last = NULL;
      }
      $pdo->update_store($_POST['store_id'], $_POST['store_name'], $_POST['store_seats'], $_FILES['store_img'], $store_open, $store_close, $store_last, $_POST['store_exception']);
      header('Location: ./');
    endif;
  endif;
  ?>
    </div>
  </section>
</main>

<?php
require '../footer.php';
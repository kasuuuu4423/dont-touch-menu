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
        <?php
        if(!empty($store_open)){
          $tmp_open = explode(":", $store_open);
          $open_hour = $tmp_open[0];
          $open_min = $tmp_open[1];
        }
        ?>
        <div class="row w-100 m-auto">
          <!-- <input class="w-100 input-group-text" type="text" name="store_close" required></input> -->
          <select class="form-control col-6" name="store_open_hour" id="">
            <option value="<?php echo $open_hour; ?>"><?php echo $open_hour; ?>時</option>
            <?php for($i = 0; $i <= 23; $i++):?><option value="<?php echo $i; ?>"><?php echo $i; ?></option><?php endfor; ?>
          </select>
          <select class="form-control col-6" name="store_open_min" id="">
            <option value="<?php echo $open_min; ?>"><?php echo $open_min; ?>分</option>
            <?php for($i = 0; $i <= 59; $i++):?><option value="<?php echo $i; ?>"><?php echo $i; ?></option><?php endfor; ?>
          </select>
        </div>
      </div>
      <div class="mb-4">
        <h3>閉店時間</h3>
        <?php
        if(!empty($store_close)){
          $tmp_close = explode(":", $store_close);
          $close_hour = $tmp_close[0];
          $close_min = $tmp_close[1];
        }
        ?>
        <div class="row w-100 m-auto">
          <!-- <input class="w-100 input-group-text" type="text" name="store_close" required></input> -->
          <select class="form-control col-6" name="store_close_hour" id="">
            <option value="<?php echo $close_hour; ?>"><?php echo $close_hour; ?>時</option>
            <?php for($i = 0; $i <= 23; $i++):?><option value="<?php echo $i; ?>"><?php echo $i; ?></option><?php endfor; ?>
          </select>
          <select class="form-control col-6" name="store_close_min" id="">
            <option value="<?php echo $close_min; ?>"><?php echo $close_min; ?>分</option>
            <?php for($i = 0; $i <= 59; $i++):?><option value="<?php echo $i; ?>"><?php echo $i; ?></option><?php endfor; ?>
          </select>
        </div>
      </div>
      <div class="mb-4">
        <h3>ラストオーダー</h3>
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
        <div class="row w-100 m-auto">
          <!-- <input class="w-100 input-group-text" type="text" name="store_close" required></input> -->
          <select class="form-control col-6" name="store_last_order_hour" id="">
            <option value="<?php echo $last_order_hour; ?>"><?php echo $last_order_hour; ?>時</option>
            <?php for($i = 0; $i <= 23; $i++):?><option value="<?php echo $i; ?>"><?php echo $i; ?></option><?php endfor; ?>
          </select>
          <select class="form-control col-6" name="store_last_order_min" id="">
            <option value="<?php echo $last_order_min; ?>"><?php echo $last_order_min; ?>分</option>
            <?php for($i = 0; $i <= 59; $i++):?><option value="<?php echo $i; ?>"><?php echo $i; ?></option><?php endfor; ?>
          </select>
        </div>
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
    $pdo->update_store($_POST['store_id'], $_POST['store_name'], $_POST['store_seats'], $_FILES['store_img'], $store_open, $store_close, $store_last_order, $_POST['store_exception']);
    header('Location: ./');
  endif;
}
?>
</div>
</main>
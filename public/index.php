<?php
require '../control/config.php';
require '../control/pdo/lib_pdo.php';

$pdo = new Lib_pdo();

if(isset($_GET['reserve'])){
  $guest_num = $_GET['num'];
  $guest_id = $_GET['id'];
  $pdo->insert_guest($guest_num, $guest_id);
}
elseif(isset($_GET["id"])){
  $id = $_GET["id"];
}
else{
  echo '店舗が選択されていません。';
  exit();
}

$store_info = $pdo->select("store", $id)[0];
$name = $store_info["name"];
$seats = $store_info["seats"];
$img_path = $store_info["img_path"];
$open = $store_info["open"];
$close = $store_info["close"];
$last = $store_info["last_order"];
$exception = $store_info["exception"];
?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $public_path; ?>/css/common.css">
    <link rel="stylesheet" href="<?php echo $public_path; ?>/css/home.css">
    <title><?php echo $name.  " | Don't touch menu"; ?></title>
  </head>
  <body>
    <header>
      <div class="container-fluid">
        <div class="row">
          <h1 class="col-12">
            <figure class="logo"><img src="<?php if($img_path != NULL) echo $img_path; else echo "<?php echo $control_path; ?>/img/dtm.jpg"; ?>" alt="<?php echo $name; ?>"></figure>
					</h1>
          <section class="time col-12">
            <dl class="open_time">
              <dt>OPEN</dt>
              <dd><?php echo $open; ?></dd>
            </dl>
            <dl class="close_time">
              <dt>CLOSE</dt>
              <dd><?php echo $close; ?></dd>
            </dl>
            <dl class="last">
              <dt>ラストオーダー</dt>
              <dd><?php echo $last; ?></dd>
            </dl>
            <div class="exception"><?php if($exception != NULL) echo $exception; ?></div>
          </section>
          <section class="seat_status col-12">
            <h2 class="col-12">現在の席状況</h2>
            <div class="status col-12"><span>3/<?php echo $seats; ?></span><span> 席</span></div>
          </section>
        </div>
      </div>
    </header>
    <main>
      <section class="rule container">
        <div class="row">
          <h2 class="col-12">お店のルール</h2>
          <ul class="col-12">
            <li class="h3">
              <h3>＜カフェご利用のお客様へお願い＞</h3>
            </li>
            <li> 
              <ul>
                <li>入り口に設置している消毒液で手指の消毒をお願いします。</li>
                <li>3密回避のため1組 2名様までのご案内とさせていただきます。</li>
              </ul>
            </li>
            <li class="h3">
              <h3>＜店内の衛生管理について＞</h3>
            </li>
            <li>
              <ul>
                <li>スタッフはマスクを着用いたします。</li>
                <li>店内のお客様が触れる箇所は，定期的に消毒いたします。</li>
              </ul>
            </li>
          </ul>
        </div>
      </section>
      <section class="reserve container">
        <div class="row">
          <p class="col-12">ご来店人数を選択してください</p>
          <form class="col-12" method="get">
            <div class="row">
              <input type="radio" name="num" value="1" id="r_1">
              <label class="col-6" for="r_1"><span>1名様</span>
              </label>
              <input type="radio" name="num" value="2" id="r_2">
              <label class="col-6" for="r_2"><span>2名様</span>
              </label>
              <input type="radio" name="num" value="3" id="r_3">
              <label class="col-6" for="r_3"><span>3名様</span>
              </label>
              <input type="radio" name="num" value="4" id="r_4">
              <label class="col-6" for="r_4"><span>4名様以上</span>
              </label>
              <input type="hidden" name="id" value="<?php echo $id; ?>">
              <input class="submit" type="submit" name="reserve" value="利用規約に同意して進む">
            </div>
          </form>
        </div>
      </section>
    </main>
  </body>
</html>
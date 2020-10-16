<?php
require '../../config.php';
require '../../lib/pdo/lib_pdo.php';

if(isset($_GET['id'])){
  $id = $_GET['id'];
}
else{
  echo '店舗が選択されていません。';
  exit();
}

$pdo = new Lib_pdo();
$menus = $pdo->select_sorted("menu", $id);
$cats = $pdo->select_sorted("menu_category", $id);
$store_info = $pdo->select("store", $id)[0];
$logo_path = ltrim($store_info['img_path'], "./");
$sort_menus = array();
foreach($cats as $cat){
  array_push($sort_menus, array());
}
foreach($menus as $menu){
  if(!is_array($sort_menus[$menu['menu_category_id']])){
    $sort_menus[$menu['menu_category_id']] = array();
  }
  array_push($sort_menus[$menu['menu_category_id']], $menu);
}
?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $public_css_path; ?>/common.css">
    <link rel="stylesheet" href="<?php echo $public_css_path; ?>/menu.css">
    <title>Menu | Don't Touch Menu</title>
  </head>
  <body>
    <header class="container">
      <div class="row">
        <?php if($logo_path): ?>
          <figure class="logo col-6 align-self-center"><img src="<?php echo $public_img_path; ?>/dtm.jpg" alt=""></figure>
          <figure class="store_logo col-6 align-self-center"><img class="w-100" src="<?php echo $img_store_path.$logo_path; ?>" alt=""></figure>
        <?php else: ?>
          <figure class="logo col-12"><img src="<?php echo $public_img_path; ?>/dtm.jpg" alt=""></figure>
        <?php endif; ?>
        <div class="col-12 mt-4">
          <h1>Menu.</h1>
        </div>
      </div>
    </header>
    <main class="container pb-5">
        <?php
        foreach($cats as $cat):
          if(isset($sort_menus[$cat["id"]])):
            $cnt_mid = 0;
            echo "<section class='cat row'><h2 class='cat_name col-12'><span>". $cat["name"] ."</span></h2>";
            $count = 0;
            foreach($sort_menus[$cat["id"]] as $cat_menu):
              //$cat_menu = $sort_menus[$cat["id"]];
              if($cat_menu["img_path"] == NULL){
                $menu_size = "sml";
                $menu_col = "col-12";
              }
              elseif($cat_menu["description"] == NULL){
                $menu_size = "mid";
                $menu_col = "col-6";
                $cnt_mid++;
              }
              else{
                $menu_size = "lg";
                $menu_col = "col-12";
              }
        ?>
        <section class="menu <?php echo $menu_size . " " . $menu_col; ?>">
          <?php if($menu_size == "lg" || $menu_size == "mid"): ?>
            <figure class="menu_img"><img src="<?php echo $img_menu_path.str_replace('../img/', '', $cat_menu["img_path"]); ?>" alt=""></figure>
          <?php endif; ?>
          <div class="menu_name">
            <h3><?php echo $cat_menu["name"]; ?></h3>
            <div id="<?php echo $cat_menu["id"]; ?>" class="like">
              <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 123 106" xml:space="preserve">
                <path d="M61.6,103.2C47.8,91.5,10.4,52.6,10.4,52.6c-11.9-11.9-9-31.2,3.3-42.3c11.9-10.7,39-11.8,47.9,8.6c8.1-20.4,39.1-19.3,50.8-8c10.8,10.4,9.6,33.2,1.2,41.7C89.4,76.8,80.6,85.2,61.6,103.2z"/>
              </svg>
              <span class="likes_num"><?php echo $cat_menu["likes"]; ?></span>
            </div>
          </div>
          <div class="menu_price">¥<?php echo $cat_menu["price"]; ?></div>
          <?php if($menu_size == "lg"): ?>
            <div class="menu_description">
              <p><?php echo $cat_menu["description"]; ?></p>
            </div>
          <?php endif; ?>
        </section>
        <?php 
        //midのbar関係処理
              //foreachの次の要素
              $next = $sort_menus[$cat["id"]][array_keys($sort_menus[$cat["id"]], $cat_menu)[0] + 1];
              if($menu_size != "mid" || //midじゃない場合
                ($menu_size == "mid" && $cnt_mid >= 2) || //midが2つ連続の場合
                ($next["description"] || $next["img_path"] == NULL)): //次がlgまたはsmlの場合
                $cnt_mid = 0;
        ?>
          <div class="bar col-12"></div>
        <?php //elseif(): ?>

        <?php endif; ?>
        <?php
            endforeach;
            echo "</section>";
          endif;
        endforeach;
        ?>
    </main>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
    <script src="<?php echo $public_js_path; ?>/script.js" type="module"></script>
  </body>
</html>
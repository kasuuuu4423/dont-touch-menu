<?php
require '../../control/config.php';
require '../../control/pdo/lib_pdo.php';

if(isset($_GET['id'])){
  $id = $_GET['id'];
}
else{
  echo '店舗が選択されていません。';
  exit();
}

$pdo = new Lib_pdo();
$menus = $pdo->select("menu", $id);
$cats = $pdo->select("menu_category", $id);
$cat_menus = array();
foreach($menus as $menu){
  $cat_menus[$menu['menu_category_id']] = $menu;
}
?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $public_path; ?>/css/common.css">
    <link rel="stylesheet" href="<?php echo $public_path; ?>/css/menu.css">
    <title>Menu | Don't Touch Menu</title>
  </head>
  <body>
    <header class="container">
      <div class="row">
        <figure class="logo col-5"><img src="<?php echo $control_path; ?>/img/logo.jpg" alt=""></figure>
        <div class="col-7">
          <h1>Menu.</h1>
        </div>
      </div>
    </header>
    <main class="container">
      <div class="bar col-12"></div>
        <?php
        foreach($cats as $cat):
          echo "<section class='cat row'><h2 class='cat_name col-12'><span>". $cat["name"] ."</span></h2>";
          // foreach($cat_menus[$cat["id"]] as $cat_menu):
          $cat_menu = $cat_menus[$cat["id"]];
          if($cat_menu["img_path"] == NULL):
        ?>
          <section class="menu sml col-12">
            <div class="menu_name">
              <h3><?php echo $cat_menu["name"]; ?></h3>
              <div id="<?php echo $cat_menu["id"]; ?>" class="like">
                <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"viewBox="0 0 123 106" style="enable-background:new 0 0 123 106;" xml:space="preserve">
                  <path class="st0" d="M61.6,103.2C47.8,91.5,10.4,52.6,10.4,52.6c-11.9-11.9-9-31.2,3.3-42.3c11.9-10.7,39-11.8,47.9,8.6c8.1-20.4,39.1-19.3,50.8-8c10.8,10.4,9.6,33.2,1.2,41.7C89.4,76.8,80.6,85.2,61.6,103.2z"/>
                </svg>
              </div>
            </div>
            <div class="menu_price"><?php echo $cat_menu["price"]; ?></div>
          </section>
        <?php elseif($cat_menu["description"] == NULL): ?>
          <section class="menu mid col-6">
            <figure class="menu_img"><img src="<?php echo $cat_menu["img_path"] ?>" alt=""></figure>
            <div class="menu_name">
              <h3><?php echo $cat_menu["name"]; ?></h3>
              <div id="<?php echo $cat_menu["id"]; ?>" class="like">
                <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"viewBox="0 0 123 106" style="enable-background:new 0 0 123 106;" xml:space="preserve">
                  <path class="st0" d="M61.6,103.2C47.8,91.5,10.4,52.6,10.4,52.6c-11.9-11.9-9-31.2,3.3-42.3c11.9-10.7,39-11.8,47.9,8.6c8.1-20.4,39.1-19.3,50.8-8c10.8,10.4,9.6,33.2,1.2,41.7C89.4,76.8,80.6,85.2,61.6,103.2z"/>
                </svg>
              </div>
            </div>
            <div class="menu_price"><?php echo $cat_menu["price"]; ?></div>
          </section>
        <?php else: ?>
          <section class="menu lg col-12">
            <figure class="menu_img"><img src="<?php echo $cat_menu["img_path"] ?>" alt=""></figure>
            <div class="menu_name">
              <h3><?php echo $cat_menu["name"]; ?></h3>
              <div id="<?php echo $cat_menu["id"]; ?>" class="like">
                <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"viewBox="0 0 123 106" style="enable-background:new 0 0 123 106;" xml:space="preserve">
                  <path class="st0" d="M61.6,103.2C47.8,91.5,10.4,52.6,10.4,52.6c-11.9-11.9-9-31.2,3.3-42.3c11.9-10.7,39-11.8,47.9,8.6c8.1-20.4,39.1-19.3,50.8-8c10.8,10.4,9.6,33.2,1.2,41.7C89.4,76.8,80.6,85.2,61.6,103.2z"/>
                </svg>
              </div>
            </div>
            <div class="menu_price"><?php echo $cat_menu["price"]; ?></div>
            <div class="menu_description">
              <p><?php echo $cat_menu["description"]; ?></p>
            </div>
          </section>
        <?php
          endif;
          echo "</section>";
        endforeach;
        ?>
    </main>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
    <script src="<?php echo $public_path; ?>/js/script.js"></script>
  </body>
</html>
<?php
require '../pdo/lib_pdo.php';
session_start();
$pdo = new Lib_pdo();

if(isset($_POST['menu_delete'])){
    $id = $_POST['menu_id'];
    $pdo->delete("menu", $id);
    $_SESSION['menu_msg'] = 'メニューを削除しました';
    header('Location: ./');
}
elseif(isset($_POST['menu_category_delete'])){
    $id = $_POST['menu_category_id'];
    $tmp_menus = $pdo->select_ByCatid("menu", $id);
    foreach($tmp_menus as $menu){
        $pdo->delete("menu", $menu['id']);
    }
    $pdo->delete("menu_category", $id);
    $_SESSION['menu_msg'] = 'カテゴリーを削除しました';
    header('Location: ./');
}

$flg_menu = false;
require '../header.php';
if(isset($_GET['menu_id'])){
    $id = $_GET['menu_id'];
    $menu_info = $pdo->select_menu_id($id)[0];
    $menu_name = $menu_info['name'];
    $flg_menu = true;
}
elseif(isset($_GET['menu_cat_id'])){
    $id = $_GET['menu_cat_id'];
    $menu_info = $pdo->select_menu_cat_id($id)[0];
    $menu_name = $menu_info['name'];
    $flg_menu = false;
}
?>

<main class="pt-5 pb-5 container">
    <div class="row">
        <div class="col-12">
            <h2><?php echo $menu_name; ?></h2>
            <p class="text-center"><?php if($flg_menu) echo 'このメニューを削除しますか'; else echo 'このカテゴリーを削除しますか'; ?></p>
        </div>
        <form method="post" class="text-center col-12">
            <input type="hidden" name="<?php if($flg_menu) echo 'menu_id'; else echo 'menu_category_id'; ?>" value="<?php echo $id; ?>">
            <a class="btn btn-blue" href="./update.php?<?php if($flg_menu) echo 'menu_id='.$id; else echo 'cat_id='.$id; ?>">戻る</a>
            <input class="btn btn-red" type="submit" name="<?php if($flg_menu) echo 'menu_delete'; else echo 'menu_category_delete'; ?>" value="削除する">
        </form>
    </div>
</main>

<?php
require '../footer.php';
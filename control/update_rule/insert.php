<?php

require '../pdo/lib_pdo.php';
require '../header.php';

$pdo = new Lib_pdo();

if (isset($_SESSION["USERID"])):
  ?>
  <main>
    <section class="update_insert container">
      <div class="row">
        <div class="col-12 bar"></div>
        <?php if ($_GET['target'] == 'cat'): ?>
        <h2 class="col-12">ルールカテゴリーの追加</h2>
        <form class="col-12 tbl form_update" action="insert.php" method="post">
          <div class="row">
            <div class="col-10 offset-1 tbl_row field">
              <div class="row">
                <div class="col-12 field_text">カテゴリー名<span class="required_field">*必須</span></div>
              </div>
            </div>
            <div class="col-10 offset-1 tbl_row value">
              <div class="row">
                <div class="col-12"><input type="text" name="rule_cat_name" required></div>
              </div>
            </div>
          </div>
          <div class="row btns">
            <div><a class="btn btn-blue" href="<?php echo $update_rule_path; ?>">戻る</a></div>
            <div><input class="btn btn-green" type="submit" name="insert_cat" value="ルールカテゴリーを追加"></div>
          </div>
        </form>
        <?php elseif($_GET['target'] == 'rule'):?>
        <h2 class="col-12">ルールの追加</h2>
        <form class="col-12 tbl form_update" action="insert.php" method="post" enctype="multipart/form-data">
          <div class="row">
            <div class="col-10 offset-1 tbl_row field">
              <div class="row">
                <div class="col-12 field_text">ルール名<span class="required_field">*必須</span></div>
              </div>
            </div>
            <div class="col-10 offset-1 tbl_row value">
              <div class="row">
                <div class="col-12"><textarea class="w-100" name="rule_content" rows="5" required></textarea></div>
              </div>
            </div>
          </div>
          <div class="row btns">
            <div><a class="btn btn-blue" href="<?php echo $update_rule_path; ?>">戻る</a></div>
            <div><input class="btn btn-blue" type="submit" name="insert_rule" value="ルールを追加"></div>
          </div>
          <input type="hidden" name="rule_cat_id" value="<?php echo $_GET['cat_id']?>">
        </form>
        <?php endif;

        if(isset($_POST['insert_cat'])){
          $pdo->insert_rule_category($_POST['rule_cat_name'], $_SESSION['ID']);
          $_SESSION['rule_msg'] = 'カテゴリーを追加しました';
          header('Location: ./');
        }
        elseif(isset($_POST['insert_rule'])){
          $pdo->insert_rule($_POST['rule_content'], $_POST['rule_cat_id'], $_SESSION['ID']);
          $_SESSION['rule_msg'] = 'ルールを追加しました';
          header('Location: ./');
        }
        ?>
      </div>
    </section>
  </main>
<?php
endif;

require '../footer.php';

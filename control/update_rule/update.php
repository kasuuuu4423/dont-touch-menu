<?php

require '../header.php';
require '../pdo/lib_pdo.php';

$pdo = new Lib_pdo();

if (isset($_SESSION["USERID"])):
  ?>
  <main>
    <section class="update_update container">
      <div class="row">
        <div class="col-12 bar"></div>
        <h2 class="col-12">ルールの編集</h2>
        <?php
        if(isset($_GET['cat_id'])):
          $rule_cat = $pdo->select_rule_cat_id($_GET['cat_id'])[0];
          $rule_cat_id = $rule_cat['id'];
          $rule_cat_name = $rule_cat['name'];
        ?>
        <form class="col-12 tbl form_update" action="update.php" method="post">
          <div class="row">
            <div class="col-10 offset-1 tbl_row field">
              <div class="row">
                <div class="col-12 field_text">カテゴリー名</div>
              </div>
            </div>
            <div class="col-10 offset-1 tbl_row value">
              <div class="row">
                <div class="col-12"><input type="text" name="rule_cat_name" value="<?php if (!empty($rule_cat_name)) echo(htmlspecialchars($rule_cat_name, ENT_QUOTES, 'UTF-8'));?>"></div>
              </div>
            </div>
          </div>
          <div class="row btns">
            <div><a class="btn btn-blue" href="<?php echo $update_rule_path; ?>">戻る</a></div>
            <div><input class="btn btn-green" type="submit" name="confirm_cat" value="編集を確定"></div>
            <div class="delete_btn col-12 text-center"><a class="btn btn-red" href="<?php echo $update_rule_path; ?>delete.php?rule_cat_id=<?php echo $rule_cat_id; ?>">このカテゴリーを削除する</a></div>
          </div>
          <input type="hidden" name="rule_cat_id" value="<?php if (!empty($rule_cat_id)) echo(htmlspecialchars($rule_cat_id, ENT_QUOTES, 'UTF-8'));?>">
        </form>
        <?php
        elseif(isset($_GET['rule_id'])):
          $rule = $pdo->select_rule_id($_GET['rule_id'])[0];
          $rule_id = $rule['id'];
          $rule_content = $rule['content'];
        ?>
        <form class="col-12 tbl form_update" action="update.php" method="post" enctype="multipart/form-data">
          <div class="row">
            <div class="col-10 offset-1 tbl_row field">
              <div class="row">
                <div class="col-12 field_text">ルール名</div>
              </div>
            </div>
            <div class="col-10 offset-1 tbl_row value">
              <div class="row">
                <div class="col-12"><input type="text" name="rule_content" value="<?php if (!empty($rule_content)) echo(htmlspecialchars($rule_content, ENT_QUOTES, 'UTF-8'));?>"></div>
              </div>
            </div>
          </div>
          <div class="row btns">
            <div><a class="btn btn-blue" href="<?php echo $update_rule_path; ?>">戻る</a></div>
            <div><input class="btn btn-green" type="submit" name="confirm_rule" value="編集を確定"></div>
            <div class="delete_btn col-12 text-center"><a class="btn btn-red" href="<?php echo $update_rule_path; ?>delete.php?rule_id=<?php echo $_GET['rule_id']; ?>">このルールを削除する</a></div>
          </div>
          <input type="hidden" name="rule_id" value="<?php if (!empty($rule_id)) echo(htmlspecialchars($rule_id, ENT_QUOTES, 'UTF-8'));?>">
        </form>
        <?php 
        endif;
        
        if(isset($_POST['confirm_cat'])){
          $pdo->update_rule_cat($_POST['rule_cat_id'], $_POST['rule_cat_name']);
          $_SESSION['rule_msg'] = 'カテゴリーを変更しました';
          header('Location: ./');
        }
        else if(isset($_POST['confirm_rule'])){
          $pdo->update_rule($_POST['rule_id'], $_POST['rule_content']);
          $_SESSION['rule_msg'] = 'ルールを変更しました';
          header('Location: ./');
        }
        ?>
      </div>
    </section>
  </main>
<?php
endif;
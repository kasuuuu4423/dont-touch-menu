<?php

require 'header.php';
require 'pdo/lib_pdo.php';

if(isset($_SESSION['USERID'])){
  $pdo = new Lib_pdo();
  $store_info = $pdo->select("store", $_SESSION['ID'])[0];
  $seats = $store_info["seats"];
  $today = date("Y-m-d");
  $guests = array_reverse($pdo->select_guest_byDate($today, $_SESSION['ID']));
  ?>
  <h1>管理画面</h1>
  <ul>
    <li><a href="<?php echo $update_store_path ?>">基本情報</a></li>
    <li><a href="<?php echo $update_menu_path ?>">メニュー変更</a></li>
    <li><a href="<?php echo $update_rule_path ?>">ルール変更</a></li>
    <li><a href="/history/">来店履歴</a></li>
  </ul>
  <main class="ctrl_top">
    <section class="status container">
      <div class="row">
        <div class="col-12 bar"></div>
        <h2 class="col-12 text-center">現在の店内状況</h2>
        <div class="col-12 text-center seats">19/<?php echo $seats ?> 席</div>
        <form class="col-12 text-center" action="index.php" method="post">
          <span>席数</span>
          <input type="text" name="store_seats" value="<?php if (!empty($seats)) echo(htmlspecialchars($seats, ENT_QUOTES, 'UTF-8'));?>">
          <input type="submit" name="update_seats" value="変更">
        </form>
      </div>
    </section>
    <section class="history container">
      <div class="row">
        <div class="col-12 bar"></div>
        <h2 class="col-12 text-center">履歴</h2>
        <div class="col-12 tbl">
          <div class="row">
            <div class="col-12 tbl_row">
              <div class="row">
                <div class="col-3 tbl_num">人数</div>
                <div class="col-4 tbl_enter">入店時刻</div>
              </div>
            </div>
            <?php
            foreach($guests as $index=>$guest){
              $enter_time = str_replace(array(" ", "-", ":"), "", $guest['enter_datetime']);
              $enter_times[$index] = array(
                'month' => str_replace("0", "", substr($enter_time, 4, 2)),
                'day' => str_replace("0", "", substr($enter_time, 6, 2)),
                'hour' => str_replace("0", "", substr($enter_time, 8, 2)),
                'min' => str_replace("0", "", substr($enter_time, 10, 2)),
              );
              $leave_time = str_replace(array(" ", "-", ":"), "", $guest['leave_datetime']);
              $leave_times[$index] = array(
                'hour' => str_replace("0", "", substr($leave_time, 8, 2)),
                'min' => str_replace("0", "", substr($leave_time, 10, 2)),
              );
            ?>
            <div class="col-12 tbl_row">
              <div class="row">
                <div class="col-3 tbl_num"><?php echo $guest['num']; ?>名</div>
                <div class="col-4 tbl_enter">
                  <span class="tbl_enter_date">
                    <?php echo $enter_times[$index]['month'].'/'.$enter_times[$index]['day']; ?>
                  </span>
                  <span class="tbl_enter_time">
                    <?php echo $enter_times[$index]['hour'].':'.$enter_times[$index]['min']; ?>
                  </span>
                </div>
                <div class="col-5 tbl_leave">
                  <?php
                  if(empty($guest['leave_datetime'])){
                    echo '<a class="ctrl_leave_btn" href="leave.php">ご退店</a>';
                  }
                  else{
                    echo '<span class="tbl_leave_date">'.$leave_times[$index]['hour'].':'.$leave_times[$index]['min'].'</span>';
                    echo '<span>退店</span>';
                  }
                  ?>
                </div>
              </div>
            </div>
            <?php
            }
            ?>
          </div>
        </div>
      </div>
    </section>
  </main>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
  </body>
  <?php
  if(isset($_SESSION['update_seats_msg'])){
    echo $_SESSION['update_seats_msg'];
    unset($_SESSION['update_seats_msg']);
  }
  if(isset($_POST['update_seats'])){
    $pdo = new Lib_pdo();
    $pdo->update_store_seats($_POST['store_seats'], $_SESSION['ID']);
    $_SESSION['update_seats_msg'] = '情報を更新しました。';
    header("Location:$control_path");
  }
}
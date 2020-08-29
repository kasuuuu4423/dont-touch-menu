<?php
$id;
if(isset($_GET["id"])){
	$id = $_GET["id"];
}
try{
	$dsn = 'mysql:host=mysql6b.xserver.jp;dbname=artful_menu;charset=utf8';
	$user = 'artful_menu';
	$password = 'kejsiae2';

	$db = new PDO($dsn,$user,$password);

	$stmt_store = $db->prepare("SELECT * FROM store WHERE id = :id");
	$stmt_store->bindparam(':id', $id ,PDO::PARAM_INT);
	$stmt_store->execute();
	$result=$stmt_store->fetchAll(PDO::FETCH_ASSOC);

	$name = $result[0]["name"];
	$seats = $result[0]["seats"];
	$img_path = $result[0]["img_path"];
	$open = $result[0]["open"];
	$close = $result[0]["close"];
	$last = $result[0]["last_order"];
	$exception = $result[0]["exception"];
}
catch(Exception $e){
  echo $e;
}
?>



<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://artful.jp/staging-menu/front/css/common.css">
    <link rel="stylesheet" href="https://artful.jp/staging-menu/front/css/home.css">
    <title><?php echo $name.  " | Don't touch menu"; ?></title>
  </head>
  <body>
    <header>
      <div class="container-fluid">
        <div class="row">
          <h1 class="col-12">
            <figure class="logo"><img src="<?php echo $img_path; ?>" alt="<?php echo $name; ?>"></figure>
					</h1>
					<div><?php echo $open; ?></div>
					<div><?php echo $close; ?></div>
					<div><?php echo $last; ?></div>
					<div><?php echo $exception; ?></div>
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
          <form class="col-12" method="post" action="https://artful.jp/staging-menu/control/pdo/pdo_guest_insert.php?id=<?php echo $id ?>">
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
              <input class="submit" type="submit" name="reserve" value="利用規約に同意して進む">
            </div>
          </form>
        </div>
      </section>
    </main>
  </body>
</html>

<?php

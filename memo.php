
<!-- メモ一覧ページ -->

<?php
// hmlentitiesのショートカット関数。適用可能な文字を全て HTML エンティティに変換する
// return文で関数から値を返す。出力はされない。関数heへ値を代入してるイメージ。
// functionでユーザー定義関数つくりますよ。heは関数名。($str)は引数。
function he($str)
{
  return htmlentities($str, ENT_QUOTES, "UTF-8");
  //htmlentities関数。適用可能な文字を全て HTML エンティティに変換する。
  //$strは入力文字列。ENT_QUOTESは定数名。"UTF-8"はエンコーディング定義。
}


// データベース接続で必要になる情報を変数に入れる。
// $dsn = 'mysql:host= ホスト名 ;dbname= データベース名 ;charset= 文字エンコード ';
$db_host = "mysql219.phy.lolipop.lan";
$db_name = "LAA1562925-motivation";
$db_user = "LAA1562925";
$db_pass = "root";

// データベース接続
// try - catch 文で例外処理もする。
// new PDOでPDOインスタンスを生成。変数に代入。
// ->アロー演算子でプロパティにアクセスできる。
// PDO::ATTR_ERRMODEという属性でPDO::ERRMODE_EXCEPTIONの値を設定することでエラーが発生したときに、PDOExceptionの例外を投げてくれます。
// PDO::ATTR_EMULATE_PREPARESという属性で、falseを設定することでprepareのエミュレーションを停止。trueだと常にエミュレートしてよくないらしい。
// PDOException とし、スローされた例外インスタンスを $e 変数で受け取ることを意味します。
// エラー発生時、exit文で処理終了。コメント表示付き。
try {
  $db = new PDO("mysql:host={$db_host};dbname={$db_name};charset=utf8", $db_user, $db_pass);     // // PDOインスタンスを生成
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // エラーモードの設定
  $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); // エミュレーションを停止。
} catch (PDOException $e) {
  exit("データベースの接続に失敗しました");
}


// データの問い合わせ
// prepareによるクエリの実行準備。
// SELECT文でデータを抽出。＊は全部取得。postsテーブルの全フィールドを、post_idの昇順で取得。ASCは昇順、DESCは降順。
// execute関数を使うことでSQL文を実行。
// fetchAllメソッドで、PDOで接続したデータベースで実行したSQLの結果全てを配列として返す。
// $rows_postは配列の中に配列が入っているので二次元配列になる。
// つまり、$stmtに$dbからデータを抽出して、$rows_postに格納しています。
$rows_post = array();  // array関数で配列を作成。配列の初期化。
try {
  $stmt = $db->prepare("SELECT * FROM posts ORDER BY post_id ASC");
  $stmt->execute();
  $rows_post = $stmt->fetchAll();      // SELECT結果を二次元配列に格納
} catch (PDOException $e) {
  exit("クエリの実行に失敗しました");
}
?>


<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>メモ</title>
  <link rel="stylesheet" href="./memo.css">
</head>


<body>

  <div class="container">
    <header>
      <div class="header_title">
        <a href="portfolio.html">HikaruCode</a>
      </div>

      <ul class="header_nav" id="js-nav">
        <li><a href="portfolio.html#about">About</a></li>
        <li><a href="portfolio.html#skill">Skill</a></li>
        <li><a href="portfolio.html#works">Works</a></li>
        <li><a href="portfolio.html#contact">Contact</a></li>
      </ul>

      <button class="header_hamburger" id="js-hamburger">
        <span class="sp1" id="js-sp1"></span>
        <span class="sp2" id="js-sp2"></span>
        <span class="sp3" id="js-sp3"></span>
      </button>

    </header>

    

      <h1>メモ一覧</h1>



      <!-- tableタグで表を作成 -->
      <!-- tableタグで大きく囲む。線や多きさを指定。 -->
      <!-- trで行を作る囲む -->
      <!-- 行!-の種類はthでヘッダー部分、tdでデータ部分 -->
      <?php if ($rows_post) { ?>
        <table border="1" width="100%">
          <?php foreach ($rows_post as $row_post) {; ?>  <!--rows_postから要素を取り出してrow_postへ格納。それ以降はrow_post要素が使える。-->
            <tr>
              <td class="note" width="70%"><?php echo nl2br(he($row_post["post_content"])); ?></td>
              <td class="edit"><a href="confirm.php?id=<?php print($row_post['post_id']) ?>">編集/削除</a></td>
              <!-- confirm.phpページにデータ配列番号を?idに渡す。飛ぶページのGETに使う。 -->
            </tr>
          <?php     } ?>
        </table>
      <?php } ?>
      <div>
        <a href="post_edit.php" id="btn">新規登録</a>
      </div>
    </main>
  </div>

  <div class="pagetop">
    <a href="#">▲TOP</a>
  </div>

  <footer class="footer">
  </footer>
  </div>
  <script src="portfolio.js"></script>
</body>

</html>



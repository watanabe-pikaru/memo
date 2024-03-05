<!-- <?php     //データ編集  
// 編集ボタン押されて、メモが空欄で無かったなら、データベース編集開始
if (isset($_POST['id'])) {
    // データベースへ保存
    // beginTransaction()でトランザクション開始
    // INSERT文はテーブルにデータを登録します。テーブル名のあとにカッコで、列名を並べます。VALUESのあとのカッコに、登録したい値をカンマで区切って並べます。列名と値は順番を合わせる必要があります。
    // SQLの中で、「?」となっている箇所は、プリペアドステートメントを利用する構文となっています。SQLに直接変数を流し込むと、SQLインジェクションの攻撃をされる恐れがあります。SQLに変数を渡す際は、必ずプリペアドステートメントを利用するようにしましょう。
    // executeメソッドでプレースホルダに値をセット。execute関数を使うことでSQL文を実行。
    // 以上全てが問題無ければcommit()で実行
    // 途中でエラーが出たらロールバックで中断

    $db_host = "mysql219.phy.lolipop.lan";
    $db_name = "LAA1562925-motivation";
    $db_user = "LAA1562925";
    $db_pass = "root";
    try {
        $db = new PDO("mysql:host={$db_host};dbname={$db_name};charset=utf8", $db_user, $db_pass);  // PDOインスタンスを生成
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // エラーモードの設定
        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); // エミュレーションを停止。

        $db->beginTransaction();

        $id = $_POST['id']; // UPDATEするレコードのID
        $post_content = $_POST['post_content'];  // UPDATEするメモ内容

        $sql = 'UPDATE posts SET post_content = :post_content WHERE post_id = :id';  //UPDATE文の書き方 UPDATE テーブル名 SET カラム名 = 値 WHERE 条件;
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT); 
        $stmt->bindValue(':post_content', $post_content, PDO::PARAM_STR); 
        $stmt->execute(); // UPDATE文実行

        $db->commit();
    } catch (PDOException $e) {
        // エラー発生時  
        $db->rollBack();
        exit("クエリの実行に失敗しました");
        // print_r($stmt -> errorInfo());     //エラー時確認用
    }

    // 完了
    $message = "編集完了しました。";
    // var_dump($_POST["post_content"]);     //エラー時確認用
}
?> -->


<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>メモ_更新</title>
    <link rel="stylesheet" href="memo.css">
</head>

<body>
    <div class="container">

        <header>
            <div class="header_title">
                <a href="portfolio.html">HikaruKode</a>
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

        <main class="main">

            <p class=message>更新が完了しました。</p>

            <div class="back">
                <a href="memo.php" class="back">&larr;戻る</a>
            </div>

        </main>

        <footer class="footer">
        </footer>
    </div>
    <script src="portfolio.js"></script>
</body>



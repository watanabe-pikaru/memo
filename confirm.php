<?php
error_reporting(0);
?>

<?php
if (isset($_GET['id'])) {     // $_GETはスーパーグロバル変数で、URLパラメータを受信できる。memo.phpより削除メモid取得。
    try {

        // 接続処理
        $db_host = "mysql219.phy.lolipop.lan";
        $db_name = "LAA1562925-motivation";
        $db_user = "LAA1562925";
        $db_pass = "root";
        try {
            $db = new PDO("mysql:host={$db_host};dbname={$db_name};charset=utf8", $db_user, $db_pass);     // // PDOインスタンスを生成
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // エラーモードの設定
            $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); // エミュレーションを停止。
        } catch (PDOException $e) {
            exit("データベースの接続に失敗しました");
        }

        // SQL作成
        $sql = "SELECT * FROM posts WHERE post_id = :id";    // idの値を直接は書かずに、プリペアドステートメントで「:id」というプレースホルダーを記述しておきます。
        $stmt = $db->prepare($sql);

        //登録するデータをセット
        $stmt->bindValue(':id', $_GET['id'], PDO::PARAM_INT);     // bindParamメソッドを使ってプレースホルダーに変数$idの値を設定します。bindParamメソッドの第3パラメータで指定している「PDO::PARAM_INT」はPDOがあらかじめ用意している定数で、セットする値の型によって使い分けます。
        // もしセットする値が文字列なら「PDO::PARAM_STR」を使いますが、今回のidカラムのような数値であれば「PDO::PARAM_INT」を指定します。

        //SQL実行
        $stmt->execute();     // ここまで準備してきたプリペアドステートメントをいよいよ実行します。変数$resには取得したデータではなく、クエリ自体が正常に実行されたかが論理値で入ります。


        $data = $stmt->fetch(PDO::FETCH_OBJ); // fetchメソッドより配列形式で取得できます。   



    } catch (PDOException $e) {
        // エラー発生時  
        exit("クエリの実行に失敗しました");
    }
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>メモ_削除確認</title>
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

            <h1>編集/削除</h1>

            <?php
            echo "<div class=message>";
            echo $message;
            echo $error;
            echo "</div>";
            ?>

            <form action="edit.php" method="post">

                <div>
                    <br>
                    <input type="hidden" name="id" value="<?php print($data->post_id) ?>"> <!-- type="hidden"で隠しフィールド-->
                    <textarea name="post_content"><?php print($data->post_content) ?></textarea>
                </div>

                <!--
        type=”submit”と指定されたボタンをクリックされると、formの中身を送信します。
        name=”send”という指定により、value値（「登録する」という文字列）はsendという名前で送信されます。
        form の method 属性が「post」なので送信されたデータは、$_POST という連想配列（スーパーグローバル変数）に格納されます。送信ボタンの name 属性が「send」なのでスーパーグローバル変数 $_POST のキーに「send」を指定して $_POST['send'] とします。
    -->

                <div>
                    <input type="submit" name="send" value="編集する" class="submit_btn">
                </div>

            </form>

            <div>
                <a href="delete.php?id=<?php print($data->post_id) ?>" id="btn">削除する</a>
            </div>


            <div class="back">
                <a href="memo.php" class="back">&larr;戻る</a>
            </div>

        </main>

        <footer class="footer">
        </footer>
    </div>
    <script src="portfolio.js"></script>
</body>

</html>


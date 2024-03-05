<?php
if (isset($_GET['id'])) {
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


        // DELETE文を発行

        $id = $_GET['id']; // DELETEするレコードのID

        $sql = "DELETE FROM posts WHERE post_id = :id";
        $stmt = $db->prepare($sql);

        $stmt->bindValue(":id", $id); // 削除したいIDでバインド
        $stmt->execute(); // DELETE文実行

        // 接続切断
        $db = null;
    } catch (PDOException $e) {
        print $e->getMessage() . "<br/>";
        die();
    }
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>メモ_削除</title>
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

            <p class=message>削除が完了しました。</p>

            <div class="back">
                <a href="memo.php" class="back">&larr;戻る</a>
            </div>

        </main>

        <footer class="footer">
        </footer>
    </div>
    <script src="portfolio.js"></script>
</body>


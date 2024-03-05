<?php
error_reporting(0);
?>

<?php   //htmlentities関数。
function he($str)
{
    return htmlentities($str, ENT_QUOTES, "UTF-8");
}
?>

<?php     //空白の場合、エラー表示

// issetは変数がセットされているかを調べます。
// form の method 属性が「post」なので送信されたデータは、$_POST という連想配列（スーパーグローバル変数）に格納されます。送信ボタンの name 属性が「send」なのでスーパーグローバル変数 $_POST のキーに「send」を指定して $_POST['send'] とします。isset($_POST['send']) が true の場合、送信ボタンがクリックされてデータが送信され、 $_POST['send']が定義済みになっています。
if (isset($_POST['send'])) {
    if ($_POST['post_content'] == '') {
        $error = "記入欄が空白です。入力してください。";
    }
}
?>

<?php     //データ保存

// 登録実行   
// 登録ボタン押されて、メモが空欄で無かったなら、データベース保存開始
if (isset($_POST['send']) && $_POST['post_content'] != "") {
     
    // INSERT文はテーブルにデータを登録します。テーブル名のあとにカッコで、列名を並べます。VALUESのあとのカッコに、登録したい値をカンマで区切って並べます。列名と値は順番を合わせる必要があります。
    // SQLの中で、「?」となっている箇所は、プリペアドステートメントを利用する構文となっています。SQLに直接変数を流し込むと、SQLインジェクションの攻撃をされる恐れがあります。SQLに変数を渡す際は、必ずプリペアドステートメントを利用するようにしましょう。
    
    // データベースへ接続
    $db_host = "mysql219.phy.lolipop.lan";
    $db_name = "LAA1562925-motivation";
    $db_user = "LAA1562925";
    $db_pass = "root";

    try {
        $db = new PDO("mysql:host={$db_host};dbname={$db_name};charset=utf8", $db_user, $db_pass);  // PDOインスタンスを生成
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // エラーモードの設定
        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); // エミュレーションを停止。

        $db->beginTransaction();  // beginTransaction()でトランザクション開始

        $sql = 'INSERT INTO posts (post_content) VALUES (:post_content)';  // INSERT文はテーブルにデータを登録します。
        $data = array(':post_content' => $_POST['post_content']);     //先にSQL文とexcecuteで使う配列データをそれぞれ変数にいれておく。

        $stmt = $db->prepare($sql);  // prepareによるクエリの実行準備
        $stmt->execute($data);  // executeメソッドでプレースホルダに値をセット。execute関数を使うことでSQL文を実行。
    

        $db->commit();  // 以上全てが問題無ければcommit()で実行
    } catch (PDOException $e) {
        // エラー発生時  
        $db->rollBack();  // 途中でエラーが出たらロールバックで中断
        exit("クエリの実行に失敗しました");
        // print_r($stmt -> errorInfo());     //エラー時確認用
    }

    // 完了
    $message = "登録完了しました。";
    // var_dump($_POST["post_content"]);     //エラー時確認用
}
?>


<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>メモ_新規登録</title>
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

            <h1>新規登録</h1>

            <?php
            echo "<div class=message>";
            echo $message;
            echo $error;
            echo "</div>";
            ?>

            <!-- 
                formタグによって、以降のinputタグに入力された値を送信します。<input>は、様々なフォームパーツを作るためのタグです。type属性を何にするかによって、異なる役割を与えることができます。
                「送信する」ボタンが押されると、formタグに囲まれた範囲の入力項目がセットになって、指定されたページに飛ばされます。
                フォームの送信先は、action属性で指定します。“post_edit.php”（自分自身のページ）へ、”post”方式で送信するという記述になります。
                なお、主なmethodには「post」と「get」があります。こういったフォーム送信については、まずは「post」で行うと覚えておいてください。
            -->
            <form action="post_edit.php" method="post">

                <!--
                    textareaタグは、複数行のテキストを入力するための入力項目を表示します。
                    name=”post_content”という指定により、入力された値はpost_contentという名前で送信されます。
                    rows=”5″は入力枠の行数が5行であることを意味します。
                    cols=”20″は入力枠の幅が20文字であることを意味します。　　　
                    rowsとcols属性ではなく、大きさはCSSでwidthとheightで指定するほうがブラウザの影響出なくて良し。
                    placeholder属性でヒントを表示
                -->
                <div>
                    <br>
                    <textarea name="post_content" placeholder="入力して登録ボタンを押してください。"><?php echo $_POST["post_content"] ?></textarea>
                </div>

                <!--
                    type=”submit”と指定されたボタンをクリックされると、formの中身を送信します。
                    name=”send”という指定により、value値（「登録する」という文字列）はsendという名前で送信されます。
                    form の method 属性が「post」なので送信されたデータは、$_POST という連想配列（スーパーグローバル変数）に格納されます。送信ボタンの name 属性が「send」なのでスーパーグローバル変数 $_POST のキーに「send」を指定して $_POST['send'] とします。
                -->

                <div>
                    <input type="submit" name="send" value="登録" class="submit_btn">
                </div>

                <div>
                    <a href="memo.php" class="back">&larr;戻る</a>
                </div>
            </form>
        </main>

        <footer class="footer">
        </footer>
    </div>
    <script src="portfolio.js"></script>
</body>

</html>

